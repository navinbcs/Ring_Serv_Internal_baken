<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageMasterApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PackageMaster_model', 'pkg');
        header('Content-Type: application/json');
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->load->library('mpdf_lib');
        $this->upload->initialize($config);
            $config = [
            'tempDir' => APPPATH . 'tmp' 
        ];
        $this->mpdf = new \Mpdf\Mpdf($config);
        $this->load->library('PdfMerger');
       
            
    }

    // GET:
    // /index.php/FacilityManagement/PackageMasterApi/serviceItem?tenantId=1632&q=para&sort=DisplayText&order=ASC&limit=50&type=ALL
    public function serviceItem()
    {

         if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                $data["status"] = "ok";
                echo json_encode($data);
                exit;
              }


        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);
        $tenantId = $tokenData->TenantId;
     


    //    $tenantId = (int)$this->input->get('tenantId');
        if (!$tenantId) return $this->jsonError('tenantId required');

        $q     = trim($this->input->get('q') ?? '');
        $limit = (int)($this->input->get('limit') ?? 50);
        $sort  = trim($this->input->get('sort') ?? 'DisplayText');
        $order = strtoupper(trim($this->input->get('order') ?? 'ASC'));
        $type  = strtoupper(trim($this->input->get('type') ?? 'ALL')); // ALL|SERVICE|ITEM

        $data = $this->pkg->search_items_union($tenantId, $q, $limit, $sort, $order, $type);
        return $this->jsonOk($data);
    }

    


    // GET:
    // /index.php/FacilityManagement/PackageMasterApi/nextCode
    // Uses token: TenantId as FacilityId and TenantName.
    public function nextCode()
    {
        if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
            exit;
        }

        $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = str_replace('Bearer ', '', $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);

        $facilityId = (int)($tokenData->TenantId ?? 0);
        $tenantName = trim((string)($tokenData->TenantName ?? ''));

        if (!$facilityId) return $this->jsonError('Invalid token / TenantId missing');
        if ($tenantName === '') return $this->jsonError('Invalid token / TenantName missing');

        try {
            $code = $this->pkg->get_next_package_code($facilityId, $tenantName);
            return $this->jsonOk(['PackageCode' => $code], 'Success');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

 
// POST: /PackageMasterApi/create
public function save()
{
    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
        exit;
    }

    try {

        // ---------------------------
        // 1) Auth (JWT)
        // ---------------------------
        $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token   = str_replace('Bearer ', '', $headers);

        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);

        if (!$tokenData) {
            return $this->json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        $facilityId = (int)$tokenData->TenantId;      // FacilityId
        $tenantName = (string)$tokenData->TenantName; // prefix mapping
        $userId     = isset($tokenData->id) ? (int)$tokenData->id : null;

        // ---------------------------
        // 2) Read POST JSON
        // ---------------------------
        $payload = json_decode($this->input->raw_input_stream, true);
        if (!is_array($payload)) {
            return $this->json(['status' => 0, 'message' => 'Invalid JSON payload'], 400);
        }

        // ---------------------------
        // 3) Validate fields
        // ---------------------------
        $packageName = trim($payload['packageName'] ?? '');
        if ($packageName === '') {
            return $this->json(['status' => 0, 'message' => 'PackageName is required'], 400);
        }

        $status = isset($payload['status']) ? (int)$payload['status'] : 1; 

        // NEW: Validity logic
        $validityType = strtoupper(trim($payload['validityType'] ?? ''));  // if "B" -> use durationDays
        $durationDays = isset($payload['durationDays']) ? (int)$payload['durationDays'] : 0;
        $validUntil   = trim($payload['validUntil'] ?? '');

        // ValidFrom always today (server date)
        $validFrom = date('Y-m-d');

        // Determine ValidTo
        $validTo = null;
        $Duration = null;
        if ($validityType === 'B') {

            if ($durationDays <= 0) {
                return $this->json(['status' => 0, 'message' => 'durationDays must be greater than 0 for validityType B'], 400);
            }

            // // Inclusive rule: durationDays=1 => validTo=today
            // // durationDays=7 => today + 6 days
            // $daysToAdd = max(0, $durationDays - 1);

            // $dt = new DateTime($validFrom);
            // $dt->modify("+{$daysToAdd} days");
            $Duration = $durationDays;

        } else {

            if ($validUntil === '') {
                return $this->json(['status' => 0, 'message' => 'validUntil is required when validityType is not B'], 400);
            }

            
          $validUntilRaw = $validUntil ?? null;

            if ($validUntilRaw) {

                // Try ISO 8601 first (Angular sends this)
                try {
                    $dt = new DateTime($validUntilRaw);
                } catch (Exception $e) {
                    return $this->json([
                        'status' => 0,
                        'message' => 'Invalid validUntil date format'
                    ], 400);
                }

                // Normalize to DATE (YYYY-MM-DD)
                $validUntil = $dt->format('Y-m-d');

            }

            $validTo = $validUntil;
        }

        // Safety: validTo should not be before validFrom
        if ($validTo !== null && $validTo < $validFrom) {
            return $this->json(['status' => 0, 'message' => 'ValidTo cannot be before today'], 400);
        }

        $components = $payload['components'] ?? [];
        if (!is_array($components) || count($components) === 0) {
            return $this->json(['status' => 0, 'message' => 'At least one Package Item is required'], 400);
        }

        // ---------------------------
        // 4) Save (Master + Items)
        // ---------------------------
        $result = $this->pkg->save_package($facilityId, $tenantName, $userId, [
            'PackageName' => $packageName,
            'ValidFrom'   => $validFrom,
            'ValidTo'     => $validTo,
            'Status'      => $status,
            'Items'       => $components,
            'Duration'   => $Duration
        ]);

        return $this->json([
            'status'  => 1,
            'message' => 'Package saved successfully',
            'data'    => $result
        ], 200);

    } catch (Exception $e) {
        log_message('error', 'Package save error: ' . $e->getMessage());
        return $this->json(['status' => 0, 'message' => 'Server error while saving package'], 500);
    }
}



    private function jsonOk($data = [], $msg = 'Success')
    {
        echo json_encode(['status' => 1, 'message' => $msg, 'data' => $data]);
        exit;
    }

    private function jsonError($msg)
    {
        echo json_encode(['status' => 0, 'message' => $msg, 'data' => []]);
        exit;
    }


private function json($data, int $statusCode = 200)
{
    $this->output
        ->set_status_header($statusCode)
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
    return;
}


 /* ================================
       PACKAGE LIST
       GET: /FacilityManagement/PackageMasterApi/packageList
    ================================= */
    public function list()
    {
           if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
            exit;
        }
        try {

            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }
            
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
           
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized'], 401);
            }

            $facilityId = (int)$tokenData->TenantId;

            // Mark expired packages (ValidTo < today) as inactive before returning list
            $this->pkg->mark_expired_packages_inactive($facilityId);

            $search = $this->input->get('search');
            $status = $this->input->get('status');
            $limit  = (int)($this->input->get('limit') ?? 50);
            $offset = (int)($this->input->get('offset') ?? 0);

            $data = $this->pkg->get_package_list($facilityId, $search, $status, $limit, $offset);

            return $this->json([
                'status' => 1,
                'data'   => $data
            ]);

        } catch (Exception $e) {
            log_message('error', 'Package list error: ' . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Server error'], 500);
        }
    }


public function updateStatus()
{

      if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
            exit;
        }
           
    try {
          $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
        // ✅ Use your existing JWT token data logic
       
        if (!$tokenData) return $this->respond(['status'=>0,'message'=>'Unauthorized'], 401);

        $facilityId = (int)$tokenData->TenantId;
        $userId     = $tokenData->UserId ?? null;

        $payload = json_decode($this->input->raw_input_stream, true);
        if (!is_array($payload)) return $this->respond(['status'=>0,'message'=>'Invalid payload'], 400);

        $packageId = (int)($payload['packageId'] ?? 0);
        $status    = (int)($payload['status'] ?? -1);

        if ($packageId <= 0) return $this->respond(['status'=>0,'message'=>'Invalid PackageId'], 400);
        if (!in_array($status, [0,1], true)) return $this->respond(['status'=>0,'message'=>'Invalid Status'], 400);

        $ok = $this->pkg->update_package_status($facilityId, $packageId, $status, $userId);

        if (!$ok) {
            return $this->json(['status'=>0,'message'=>'Record not found or no change'], 404);
        }

        return $this->json(['status'=>1,'message'=>'Status updated']);

    } catch (Exception $e) {
        log_message('error', 'updateStatus error: '.$e->getMessage());
        return $this->json(['status'=>0,'message'=>'Server error'], 500);
    }
}


public function packageDetails()
{
    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]); exit;
    }

    $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    $token = str_replace('Bearer ', '', $headers);
    $kunci = $this->config->item('thekey');
    $tokenData = JWT::decode($token, $kunci);

    $facilityId = (int)($tokenData->TenantId ?? 0);
    if (!$facilityId) return $this->jsonError('Invalid token');

    $packageId = (int)($this->input->get('packageId') ?? 0);
    if ($packageId <= 0) return $this->jsonError('packageId required');

    $data = $this->pkg->get_package_details($facilityId, $packageId);
    return $this->jsonOk($data);
}


 /**
     * DELETE /api/package-item/delete/{PackageItemId}
     * Soft delete: IsDeleted = 1
     */
 


    public function delete($packageItemId = null)
    {
          if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                $data["status"] = "ok";
                echo json_encode($data);
                exit;
              }



        $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token   = str_replace('Bearer ', '', $headers);

        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);

        if (!$tokenData) {
            return $this->json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        $facilityId = (int)$tokenData->TenantId;      // FacilityId
        $tenantName = (string)$tokenData->TenantName; // prefix mapping
        $userId     = isset($tokenData->id) ? (int)$tokenData->id : null;

        if (!$tokenData) {
            return $this->json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        // OPTIONS support
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            return $this->_json(['status' => 1, 'message' => 'ok']);
        }

        if (!$packageItemId) {
            return $this->_json(['status' => 0, 'message' => 'PackageItemId required'], 400);
        }

     

        // // Optional safety check
        // if (!$this->packageItem->exists($packageItemId)) {
        //     return $this->_json(['status' => 0, 'message' => 'Record not found'], 404);
        // }

        
        $deleted = $this->pkg->softDelete($packageItemId,  $userId );

        if (!$deleted) {
            return $this->_json(['status' => 0, 'message' => 'Delete failed'], 500);
        }

        return $this->_json([
            'status' => 1,
            'message' => 'Package item deleted successfully'
        ]);
    }

    private function _json($data, $status = 200)
    {
        return $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
   


public function printPackageBillMockupPdf()
{
    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
        exit;
    }

    try {

        $packageId = (int)($this->input->get('packageId') ?? 0);
        $facilityId = (int)($this->input->get('facilityId') ?? 0);
        
        if (!$packageId) {
            return $this->json(['status' => 0, 'message' => 'packageId is required'], 400);
        }
        
        if (!$facilityId) {
            return $this->json(['status' => 0, 'message' => 'facilityId is required'], 400);
        }

        $packageData = $this->pkg->get_package_details($facilityId, $packageId);
        
        if (!$packageData['master']) {
            return $this->json(['status' => 0, 'message' => 'Package not found'], 404);
        }

        $master = $packageData['master'];
        $items = $packageData['items'];

        $sqlTenant = "
            SELECT 
                TenantName,
                Address1,
                Address2,
                City,
                State,
                PostalCode,
                Country,
                PhoneNo,
                Email
            FROM dbo.TenantMaster
            WHERE TenantId = ?
        ";
        $tenant = $this->db->query($sqlTenant, [$facilityId])->row_array();

        $tenantAddress = '';
        if ($tenant) {
            $addressParts = array_filter([
                $tenant['Address1'] ?? '',
                $tenant['Address2'] ?? '',
                $tenant['City'] ?? '',
                $tenant['State'] ?? '',
                $tenant['PostalCode'] ?? '',
                $tenant['Country'] ?? ''
            ]);
            $tenantAddress = implode(', ', $addressParts);
        }

        $data = [
            'tenant' => [
                'name'    => $tenant['TenantName'] ?? 'RING Clinic',
                'address' => $tenantAddress,
                'phone'   => $tenant['PhoneNo'] ?? '',
                'email'   => $tenant['Email'] ?? '',
                'logo'    => ''
            ],
            'patient' => [
                'PatientFullName' => $this->input->get('patientName') ?? 'N/A',
                'PatientMRN'      => $this->input->get('patientMRN') ?? 'N/A',
            ],
            'visit' => [
                'DateOfVisit' => $this->input->get('visitDate') ?? date('d M Y'),
                'VisitNo'     => $this->input->get('visitNo') ?? 'N/A',
            ],
            'meta' => [
                'DateOfPrinting' => date('d M Y, h:i A'),
            ],
            'printedBy' => $this->input->get('printedBy') ?? 'System User',
            'package' => [
                'PackageName' => $master['PackageName'] ?? '',
                'PackageCode' => $master['PackageCode'] ?? '',
                'Status'      => $master['Status'] == 1 ? 'Active' : 'Inactive',
                'ValidFrom'   => $master['ValidFrom'] ?? '',
                'ValidTo'     => $master['ValidTo'] ?? '',
                'Duration'    => $master['Duration'] ?? '',
                'Components'  => $master['Components'] ?? 0,
                'TotalPrice'  => $master['TotalPrice'] ?? 0,
                'TaxValue'    => $master['TaxValue'] ?? 0,
                'DiscountAmount' => $master['DiscountAmount'] ?? 0,
                'NetAmount'   => $master['NetAmount'] ?? 0,
            ],
            'items' => array_map(function($item) {
                return [
                    'Code'        => $item['ItemId'] ?? '',
                    'Description' => $item['ItemName'] ?? $item['Description'] ?? '',
                    'Type'        => isset($item['ItemId']) && $item['ItemId'] ? 'Item' : 'Service',
                    'Qty'         => $item['Quantity'] ?? 1,
                    'Rate'        => $item['UnitPrice'] ?? 0,
                    'Discount'    => $item['PackageDiscount'] ?? 0,
                    'Tax'         => $item['TaxValue'] ?? 0,
                    'Amount'      => $item['NetAmount'] ?? 0,
                ];
            }, $items),
        ];

        $this->load->library('mpdf_lib');

        $config = [
            'tempDir' => APPPATH . 'tmp'
        ];
        $mpdf = new \Mpdf\Mpdf($config);
        $mpdf->SetTitle('Package Bill - ' . $master['PackageCode']);

        $html = $this->load->view('ring_package_bill', $data, true);

        $mpdf->WriteHTML($html);

        $fileName = 'PackageBill_' . $master['PackageCode'] . '_' . date('Ymd_His') . '.pdf';
        $mpdf->Output($fileName, 'I');

    } catch (Exception $e) {
        log_message('error', 'printPackageBillMockupPdf error: '.$e->getMessage());
        return $this->json([
            'status'  => 0,
            'message' => $e->getMessage(),
        ], 500);
    }
}

}