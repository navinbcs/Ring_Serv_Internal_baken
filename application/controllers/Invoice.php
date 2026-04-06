<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller
{
    /**
     * Clinic URL from Tenants — RING.Web Administration.Tenant uses column WebSite (not Website).
     */
    private function invoice_tenant_website_from_enrollment($getData)
    {
        $v = trim((string) ($getData->TenantWebSite ?? ''));
        if ($v !== '') {
            return $v;
        }
        return '';
    }

    /**
     * First non-empty property from a report SP row (column names vary by environment).
     */
    private function rpt_first_prop($obj, array $keys, $default = '')
    {
        if (!$obj || !is_object($obj)) {
            return $default;
        }
        foreach ($keys as $k) {
            if (!isset($obj->$k)) {
                continue;
            }
            $v = $obj->$k;
            if ($v === null || $v === '') {
                continue;
            }
            if (is_scalar($v)) {
                return trim((string) $v);
            }
        }

        return $default;
    }

    /**
     * Display scalar from SP row; formats DateTime as d/m/Y H:i (RING ClinicalSummary discharge band).
     */
    private function rpt_scalar_for_display($obj, array $keys)
    {
        if (!$obj || !is_object($obj)) {
            return '';
        }
        foreach ($keys as $k) {
            if (!isset($obj->$k)) {
                continue;
            }
            $v = $obj->$k;
            if ($v === null || $v === '') {
                continue;
            }
            if ($v instanceof \DateTimeInterface) {
                return $v->format('d/m/Y H:i');
            }
            if (is_string($v) || is_numeric($v)) {
                return trim((string) $v);
            }
        }

        return '';
    }

    /**
     * @return int|null Minutes from midnight 0–1439, or null if not parseable
     */
    private function invoice_time_to_minutes($val)
    {
        if ($val === null || $val === '') {
            return null;
        }
        if ($val instanceof DateTimeInterface) {
            return ((int) $val->format('G')) * 60 + (int) $val->format('i');
        }
        if (is_numeric($val)) {
            $n = (int) $val;
            if ($n >= 0 && $n < 1440) {
                return $n;
            }
        }
        $s = trim((string) $val);
        if (preg_match('/(\d{1,2}):(\d{2})(?::\d{2})?/', $s, $m)) {
            return ((int) $m[1]) * 60 + (int) $m[2];
        }
        return null;
    }

    /** e.g. 9:30 am, 10:30 pm (12-hour, lowercase am/pm) */
    private function invoice_minutes_to_ampm($minutes)
    {
        if ($minutes === null || $minutes < 0) {
            return '';
        }
        $minutes = $minutes % 1440;
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;
        $ts = mktime($h, $m, 0, 1, 1, 2020);
        $s = strtolower(date('g:i a', $ts));

        return preg_replace('/:/', '.', $s, 1);
    }

    /**
     * One line: earliest open to latest close across schedule rows (primary + secondary), 12h am/pm.
     */
    private function format_facility_working_hours($tenantId)
    {
        if (empty($tenantId)) {
            return '';
        }
        $rows = $this->WebserviceModel->getWorkingScheduleOfTenant((int) $tenantId);
        if (empty($rows)) {
            return '';
        }
        $earliest = null;
        $latest = null;
        foreach ($rows as $r) {
            $fromM = $this->invoice_time_to_minutes($r->FromTime ?? null);
            $toM = $this->invoice_time_to_minutes($r->ToTime ?? null);
            if ($fromM === null && isset($r->FtTime) && $r->FtTime !== null && $r->FtTime !== '') {
                $fromM = $this->invoice_time_to_minutes($r->FtTime);
            }
            if ($toM === null && isset($r->TtTime) && $r->TtTime !== null && $r->TtTime !== '') {
                $toM = $this->invoice_time_to_minutes($r->TtTime);
            }
            if ($fromM === null || $toM === null) {
                continue;
            }
            if ($toM < $fromM) {
                continue;
            }
            if ($earliest === null || $fromM < $earliest) {
                $earliest = $fromM;
            }
            if ($latest === null || $toM > $latest) {
                $latest = $toM;
            }
        }
        if ($earliest === null || $latest === null) {
            return '';
        }
        $a = $this->invoice_minutes_to_ampm($earliest);
        $b = $this->invoice_minutes_to_ampm($latest);
        if ($a === '' || $b === '') {
            return '';
        }

        return $a . ' – ' . $b;
    }

    public function __construct()
    {
       parent::__construct();
        ob_clean();
        $this->load->model(array('ReportPdfModel','WebserviceModel'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->load->library('mpdf_lib');
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');
        $this->load->helper('amount');
        require_once APPPATH . 'libraries/EncDecAlgorithm.php';

        $config = [
            'tempDir' => APPPATH . 'tmp' 
        ];
        $this->mpdf = new \Mpdf\Mpdf($config);
        $this->load->library('PdfMerger');
       
    }

    // Example: http://your-site.com/invoice/print/123
    public function print($chargeID = null)
    {
        // echo $chargeID ; exit ;
         
            $chargeHeaderOBj = $this->ReportPdfModel->getEnrolentID($chargeID);
            if(!isset($chargeHeaderOBj[0]->EnrollmentId)) echo "Error in Page";
            $visit_id = $chargeHeaderOBj[0]->EnrollmentId; 
            $getData = $this->WebserviceModel->getEnrollmentDetails($visit_id);   
        //    print_r( $getData);
            
            $usp_rpt_BillDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_BillDetails',$getData->PatientId,$visit_id );
            $usp_rpt_BillDetails = $this->ReportPdfModel->enrichBillDetailsFromChargeEntryDetails((int) $chargeID, $usp_rpt_BillDetails);
            $usp_rpt_InvoiceDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_InvoiceDetails',$getData->PatientId,$visit_id );
            $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails',$getData->PatientId,$visit_id );
            $usp_rpt_PaymentDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PaymentDetails',$getData->PatientId,$visit_id );
        //    echo "<pre>";
        //      print_r( $usp_rpt_BillDetails);
        //      print_r( $usp_rpt_InvoiceDetails);
        //      print_r( $usp_rpt_PatientDetails);
        //     print_r(  $usp_rpt_PaymentDetails); exit;
            if($getData)
            {
                
                $getData->FirstName = $this->encryptDecrypt("dc",$getData->FullName);
                $getData->LastName = $this->encryptDecrypt("dc",$getData->LastName);
                $FromTime = DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
                $getData->FromTime = $FromTime->format('H:i');
                $ToTime = DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
                $getData->ToTime = $ToTime->format('H:i');
                $getData->Age = $this->ageCalculator($getData->DateOfBirth);
            }

       // echo 1; exit;
        // 1. Get data from DB if needed (dummy array shown)

        $hdr = $chargeHeaderOBj[0] ?? null;
        $firstBillRow = !empty($usp_rpt_BillDetails[0]) ? $usp_rpt_BillDetails[0] : null;
        $invoice_no_raw = invoice_raw_number_from_first_line($firstBillRow);
        if ($invoice_no_raw === '') {
            $invoice_no_display = 'Draft';
            $invoice_date_display = '';
        } else {
            $invoice_no_display = $invoice_no_raw;
            $invoice_date_display = invoice_resolve_display_date_from_invoice_date($hdr, $firstBillRow);
        }

        $tenantId = isset($getData->TenantId) ? (int) $getData->TenantId : 0;
        $doctorLicence = trim((string) ($getData->MMCNumber ?? ''));
        if ($doctorLicence === '' && !empty($getData->PractitionerCode)) {
            $doctorLicence = trim((string) $getData->PractitionerCode);
        }
        $clinicWebsite = $this->invoice_tenant_website_from_enrollment($getData);

        $data = [
            'visit_id'  => $visit_id,
             'Presp' => $usp_rpt_BillDetails,
            'payment_detail'=>$usp_rpt_PaymentDetails,
            'invoice_no_display' => $invoice_no_display,
            'invoice_date_display' => $invoice_date_display,
            'patient'   => [
                'name' => $getData->FirstName .' '.$getData->LastName,
                'age'  => $getData->Age,
                'sex'  => $getData->GenderDescription[0],
                'appointmentDate'=> date('d M Y', strtotime( $getData->AppointmentDate)),
                'AppointmentNo'=> $getData->AppointmentNo
            ],
             'doctor'   => [
                         'name' => $getData->DoctorFName .' '.$getData->DoctorLName  ,
                         'deprt' => $getData->Department,
                         'licence_no' => $doctorLicence,
                         'primary_speciality' => trim((string) ($getData->DoctorPrimarySpeciality ?? '')),
                         'secondary_speciality' => trim((string) ($getData->DoctorSecondarySpeciality ?? '')),
             ],

            'tenant' => [
                         'name' => $getData->TenantName ,
                         'address' => $getData->TenantAddress ,
                         'email' => trim((string) ($getData->TenantEmail ?? '')),
                         'website' => $clinicWebsite,
                         'facility_working_hours' => $this->format_facility_working_hours($tenantId),
                           ],

            // add whatever you want to pass into the view
        ];

        // 2. Load HTML from view
        $html = $this->load->view('ring_invoice', $data, true);  

        // 3. Load mPDF library
       // $this->load->library('mn_pdf');

        // 4. Optional: set base path for CSS/images if needed
        // $this->m_pdf->pdf->setBasePath(base_url());

        // 5. Write HTML to PDF
        $this->mpdf->WriteHTML($html);


        // 6. Output PDF (I = inline, D = download)
        $fileName = 'RING_Invoice_' . ($visit_id ?: 'print') . '.pdf';
        $this->mpdf->Output($fileName, 'I');
    }

    /**
     * Inline bill PDF — same output as print(). Use index.php/invoice/bill/{chargeId}
     * (routes may alias here; if not, this method still resolves the URL).
     * Totals exclude ItemMaster BillingType = 2 (non-billable) via ring_invoice + bill_line_is_billable().
     */
    public function bill($chargeID = null)
    {
        $this->print($chargeID);
    }

    /**
     * Get bill detail as JSON (same logic as print, for drawer display).
     * GET /api/invoice/bill-detail/{chargeId}
     */
    public function billDetail($chargeID = null)
    {
        header('Content-Type: application/json');
        if (!$chargeID) {
            echo json_encode(['success' => false, 'message' => 'Charge ID required']);
            return;
        }
        $chargeHeaderOBj = $this->ReportPdfModel->getEnrolentID($chargeID);
        if (!isset($chargeHeaderOBj[0]->EnrollmentId)) {
            echo json_encode(['success' => false, 'message' => 'Invalid charge ID']);
            return;
        }
        $visit_id = $chargeHeaderOBj[0]->EnrollmentId;
        $getData = $this->WebserviceModel->getEnrollmentDetails($visit_id);
        if (!$getData) {
            echo json_encode(['success' => false, 'message' => 'Enrollment not found']);
            return;
        }
        $usp_rpt_BillDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_BillDetails', $getData->PatientId, $visit_id);
        $usp_rpt_BillDetails = $this->ReportPdfModel->enrichBillDetailsFromChargeEntryDetails((int) $chargeID, $usp_rpt_BillDetails);
        $usp_rpt_InvoiceDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_InvoiceDetails', $getData->PatientId, $visit_id);
        $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails', $getData->PatientId, $visit_id);
        $usp_rpt_PaymentDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PaymentDetails', $getData->PatientId, $visit_id);

        $getData->FirstName = $this->encryptDecrypt("dc", $getData->FullName);
        $getData->LastName = $this->encryptDecrypt("dc", $getData->LastName);
        if (!empty($getData->FromTime)) {
            $FromTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
            if ($FromTime) $getData->FromTime = $FromTime->format('H:i');
        }
        if (!empty($getData->ToTime)) {
            $ToTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
            if ($ToTime) $getData->ToTime = $ToTime->format('H:i');
        }
        $getData->Age = $this->ageCalculator($getData->DateOfBirth);

        $totalAmt = 0;
        $totalDisc = 0;
        $totalTax = 0;
        $billItems = [];
        foreach ($usp_rpt_BillDetails as $p) {
            $lineTax = bill_line_tax_amount($p);
            $billable = bill_line_is_billable($p);
            if ($billable) {
                $totalAmt += (float) ($p->Amount ?? 0);
                $totalDisc += (float) ($p->Discount ?? 0);
                $totalTax += $lineTax;
            }
            $desc = $p->Description ?? '';
            if (!$billable && $desc !== '') {
                $desc .= ' (Non-billable)';
            }
            $billItems[] = [
                'code' => $p->Code ?? '',
                'description' => $desc,
                'quantity' => (float) ($p->Quantity ?? 0),
                'unitPrice' => $billable ? (float) ($p->UnitPrice ?? 0) : 0.0,
                'discount' => $billable ? (float) ($p->Discount ?? 0) : 0.0,
                'amount' => $billable ? (float) ($p->Amount ?? 0) : 0.0,
                'tax' => $billable ? $lineTax : 0.0,
                'netAmount' => $billable ? bill_line_net_amount($p) : 0.0,
            ];
        }

        $totalPaid = 0;
        $payments = [];
        foreach ($usp_rpt_PaymentDetails as $p) {
            $amt = (float) ($p->PaymentAmount ?? 0);
            if (trim($p->PaymentMode ?? '') !== 'INSURANCE') {
                $totalPaid += $amt;
            }
            $payments[] = [
                'method' => $p->PaymentMode ?? '',
                'bankName' => $p->BankName ?? '',
                'reference' => $p->ChequeCardNo ?? '',
                'date' => $p->PaymentDate ?? '',
                'amount' => $amt,
            ];
        }

        $firstBill = $usp_rpt_BillDetails[0] ?? null;
        $hdr = $chargeHeaderOBj[0] ?? null;
        $invoice_no_raw = invoice_raw_number_from_first_line($firstBill);
        if ($invoice_no_raw === '') {
            $invoiceNo = 'Draft';
            $invoiceDate = '';
        } else {
            $invoiceNo = $invoice_no_raw;
            $invoiceDate = invoice_resolve_display_date_from_invoice_date($hdr, $firstBill);
        }
        $balance = ($totalAmt - $totalDisc) + $totalTax;

        $tenantId = isset($getData->TenantId) ? (int) $getData->TenantId : 0;
        $doctorLicence = trim((string) ($getData->MMCNumber ?? ''));
        if ($doctorLicence === '' && !empty($getData->PractitionerCode)) {
            $doctorLicence = trim((string) $getData->PractitionerCode);
        }
        $clinicWebsite = $this->invoice_tenant_website_from_enrollment($getData);

        $data = [
            'success' => true,
            'visitId' => (int) $visit_id,
            'chargeId' => (int) $chargeID,
            'tenant' => [
                'name' => $getData->TenantName ?? '',
                'address' => $getData->TenantAddress ?? '',
                'email' => trim((string) ($getData->TenantEmail ?? '')),
                'website' => $clinicWebsite,
                'facilityWorkingHours' => $this->format_facility_working_hours($tenantId),
            ],
            'doctor' => [
                'name' => ($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? ''),
                'department' => $getData->Department ?? '',
                'licenceNo' => $doctorLicence,
                'primarySpeciality' => trim((string) ($getData->DoctorPrimarySpeciality ?? '')),
                'secondarySpeciality' => trim((string) ($getData->DoctorSecondarySpeciality ?? '')),
            ],
            'patient' => [
                'name' => trim(($getData->FirstName ?? '') . ' ' . ($getData->LastName ?? '')),
                'age' => $getData->Age ?? 0,
                'sex' => isset($getData->GenderDescription[0]) ? $getData->GenderDescription[0] : '',
                'appointmentDate' => !empty($getData->AppointmentDate) ? date('d M Y', strtotime($getData->AppointmentDate)) : '',
                'appointmentNo' => $getData->AppointmentNo ?? '',
            ],
            'invoice' => [
                'invoiceNo' => $invoiceNo,
                'invoiceDate' => $invoiceDate,
                'currency' => 'MYR',
            ],
            'billItems' => $billItems,
            'totals' => [
                'subtotal' => $totalAmt,
                'discount' => $totalDisc,
                'tax' => $totalTax,
                'balance' => $balance,
                'amountInWords' => $this->amountInWordsMYR($balance),
            ],
            'payments' => $payments,
            'totalPaid' => $totalPaid,
            'totalPaidInWords' => $this->amountInWordsMYR($totalPaid),
        ];
        echo json_encode($data);
    }

    public function getEnrollmentDetails(){
        $data = json_decode(file_get_contents('php://input'));       
        if($data){
            $EnrollmentId = $data->EnrollmentId;
            $getData = $this->WebserviceModel->getEnrollmentDetails($EnrollmentId);      
            if($getData)
            {
                
                $getData->FirstName = $this->encryptDecrypt("dc",$getData->FullName);
                $getData->LastName = $this->encryptDecrypt("dc",$getData->LastName);
                $FromTime = DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
                $getData->FromTime = $FromTime->format('H:i');
                $ToTime = DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
                $getData->ToTime = $ToTime->format('H:i');
                $getData->Age = $this->ageCalculator($getData->DateOfBirth);
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $getData;
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is null';
        }   
        echo json_encode($response);exit;
    } 

    function ageCalculator($dob){
        if(!empty($dob)){
            $birthdate = new DateTime($dob);
            $today   = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        }else{
            return 0;
        }
    }

    function encryptDecrypt($type,$name){
        if (empty($name)) {
            return $name;
        }

        try {
            if($type == 'en'){
                return EncDecAlgorithm::encrypt($name);
            } else {
                return EncDecAlgorithm::decrypt($name);
            }
        } catch (Exception $e) {
            error_log("EncryptDecrypt error: " . $e->getMessage());
            return $name;
        }
    }

    public function fullReportPatientBilling()
    {
        $data = json_decode(file_get_contents('php://input'));
        if($data)        
        {
            $patientId    = $data->patientId;
            $enrollmentId = $data->enrollmentId;
            if (!$patientId || !$enrollmentId) {
                echo json_encode([
                    'status'  => false,
                    'message' => 'patientId and enrollmentId required'
                ]);
                return;
            }
            $resultData = $this->ReportPdfModel->fullReportPatientBilling($patientId, $enrollmentId);
            if($resultData)             
            {
                $response['response_code'] = 1;
                $response['response_message'] = 'Success';
                $response['response_data'] = $resultData;
            }
            else
            {
                $response['response_code']=2;
                $response['response_message']='Failed';
            }
        }
        else
        {
            $response['response_code'] = 3;
            $response['response_message'] = 'Data is NULL';
        }
        echo json_encode($response);exit;
    }


function amountInWordsMYR($number)
{
    if (is_string($number)) {
        $number = str_replace(',', '', $number);
    }
    $number = (float) $number;
    $no = floor($number);
    $decimal = round($number - $no, 2) * 100;
    if ($no == 0 && (int) $decimal === 0) {
        return 'Zero Ringgit Only';
    }

    $words = [
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
        20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
        50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
        80 => 'Eighty', 90 => 'Ninety'
    ];

    $digits = ['', 'Hundred', 'Thousand', 'Million', 'Billion'];
    $str = [];
    $i = 0;

    while ($no > 0) {
        $numberPart = $no % 1000;
        $no = floor($no / 1000);

        if ($numberPart) {
            $hundreds = floor($numberPart / 100);
            $remainder = $numberPart % 100;

            $text = '';

            if ($hundreds) {
                $text .= $words[$hundreds] . ' Hundred ';
            }

            if ($remainder < 21) {
                $text .= $words[$remainder];
            } else {
                $text .= $words[floor($remainder / 10) * 10] . ' ' .
                         $words[$remainder % 10];
            }

            $str[] = trim($text) . ' ' . $digits[$i];
        }

        $i++;
    }

    $result = trim(implode(' ', array_reverse($str)));

    $sen = '';
    if ($decimal) {
        if ($decimal < 21) {
            $sen = ' and ' . $words[$decimal] . ' Sen';
        } else {
            $sen = ' and ' . $words[floor($decimal / 10) * 10] . ' ' .
                   $words[$decimal % 10] . ' Sen';
        }
    }

    return $result . ' Ringgit' . $sen . ' Only';
}


public function printPackageBillMockupPdf()
{
    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
        exit;
    }

   


        // ---------------------------
        // 3) Mock Data (static)
        // ---------------------------
        $data = [
            'tenant' => [
                'name'    => 'RING Clinic Kuala Lumpur',
                'address' => 'Street 12, Bukit Bintang, Kuala Lumpur, Federal Territory 55100, Malaysia',
                'phone'   => '+60 3-1234 5678',
                'email'   => 'info@ring.healthcare',
                'logo'    => '' // optional: base_url('assets/images/logo.png')
            ],
            'patient' => [
                'PatientFullName' => 'Akansha Thakur',
                'PatientMRN'      => 'MRN-009812',
            ],
            'visit' => [
                'DateOfVisit' => date('d M Y'),
                'VisitNo'     => 'VST-2026-000145',
            ],
            'meta' => [
                'DateOfPrinting' => date('d M Y, h:i A'),
            ],
            'printedBy' => 'Rahul Sharma',
            'package' => [
                'PackageName' => 'Physio Recovery Package',
                'PackageCode' => 'RCKL-0021-A',
                'Status'      => 'Active',
            ],
            'items' => [
                [
                    'Code'        => 'SVC-1102',
                    'Description' => 'Physiotherapy Session (45 mins) - Includes assessment + guided exercises',
                    'Type'        => 'Service',
                    'Qty'         => 3,
                    'Rate'        => 120.00,
                    'Discount'    => 30.00,
                    'Tax'         => 0.00,
                    'Amount'      => 330.00,
                ],
                [
                    'Code'        => 'ITM-2407',
                    'Description' => 'Elastic Bandage (Small) - Dispensed item',
                    'Type'        => 'Item',
                    'Qty'         => 2,
                    'Rate'        => 8.50,
                    'Discount'    => 0.00,
                    'Tax'         => 0.00,
                    'Amount'      => 17.00,
                ],
                [
                    'Code'        => 'SVC-1410',
                    'Description' => 'Hot Pack Therapy - 10 mins pre-physio',
                    'Type'        => 'Service',
                    'Qty'         => 1,
                    'Rate'        => 25.00,
                    'Discount'    => 0.00,
                    'Tax'         => 0.00,
                    'Amount'      => 25.00,
                ],
            ],
        ];

        // ---------------------------
        // 4) Load HTML from view
        // Create: application/views/ring_package_bill_mockup.php
        // ---------------------------
        $html = $this->load->view('ring_package_bill', $data, true);


        // ---------------------------
        // 5) PDF output (inline like invoice)
        // ---------------------------
        $this->mpdf->WriteHTML($html);

        $fileName = 'PackageBill_Mockup_' . date('Ymd_His') . '.pdf';
        $this->mpdf->Output($fileName, 'I'); // I = inline in browser

   
}

function prescription($chargeID = null){

    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
        exit;
    }

    if (!$chargeID) {
        echo "Error: Charge ID is required";
        return;
    }

    ob_start();
    
    try {
        $chargeHeaderOBj = $this->ReportPdfModel->getEnrolentID($chargeID);
        if(!isset($chargeHeaderOBj[0]->EnrollmentId)) {
            ob_end_clean();
            echo "Error in Page - Invalid Charge ID";
            return;
        }
        
        $visit_id = $chargeHeaderOBj[0]->EnrollmentId; 
        $getData = $this->WebserviceModel->getEnrollmentDetails($visit_id);
        
        if (!$getData) {
            ob_end_clean();
            echo "Error: Enrollment details not found";
            return;
        }

        $usp_rpt_Prescription = $this->ReportPdfModel->getDataFromSP('usp_rpt_Prescription', $getData->PatientId, $visit_id);
        $usp_rpt_Allergies = $this->ReportPdfModel->getDataFromSP('usp_rpt_Allergies', $getData->PatientId, $visit_id);
        $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails', $getData->PatientId, $visit_id);

        if($getData) {
            $getData->FirstName = $this->encryptDecrypt("dc", $getData->FullName);
            $getData->LastName = $this->encryptDecrypt("dc", $getData->LastName);
            
            if (!empty($getData->FromTime)) {
                $FromTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
                if ($FromTime) $getData->FromTime = $FromTime->format('H:i');
            }
            
            if (!empty($getData->ToTime)) {
                $ToTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
                if ($ToTime) $getData->ToTime = $ToTime->format('H:i');
            }
            
            $getData->Age = $this->ageCalculator($getData->DateOfBirth);
        }

        $patientDetails = !empty($usp_rpt_PatientDetails) ? $usp_rpt_PatientDetails[0] : null;
        
        $genderChar = '';
        if (isset($getData->GenderDescription) && is_string($getData->GenderDescription) && strlen($getData->GenderDescription) > 0) {
            $genderChar = $getData->GenderDescription[0];
        }

        $decryptedIdentityNo = '';
        $decryptedPhoneNo = '';
        
        if ($patientDetails) {
            if (!empty($patientDetails->IdentityNo)) {
                $decryptedIdentityNo = $this->encryptDecrypt("dc", $patientDetails->IdentityNo);
            }
            if (!empty($patientDetails->PhoneNo)) {
                $decryptedPhoneNo = $this->encryptDecrypt("dc", $patientDetails->PhoneNo);
            }
        }

        $tenantId = isset($getData->TenantId) ? (int) $getData->TenantId : 0;
        $doctorLicence = trim((string) ($getData->MMCNumber ?? ''));
        if ($doctorLicence === '' && !empty($getData->PractitionerCode)) {
            $doctorLicence = trim((string) $getData->PractitionerCode);
        }
        $clinicWebsite = $this->invoice_tenant_website_from_enrollment($getData);
        $tenantPhone = '';
        if ($patientDetails) {
            $tenantPhone = trim((string) (($patientDetails->MobileCode ?? '') . ' ' . $decryptedPhoneNo));
            if ($tenantPhone === '') {
                $tenantPhone = $decryptedPhoneNo ?: (string) ($patientDetails->PhoneNo ?? '');
            }
        } elseif ($decryptedPhoneNo !== '') {
            $tenantPhone = $decryptedPhoneNo;
        }

        $data = [
            'tenant' => [
                'name' => $getData->TenantName ?? ($patientDetails->TenantName ?? 'RING Clinic'),
                'address' => $getData->TenantAddress ?? ($patientDetails->TenantAddress ?? ''),
                'email' => trim((string) ($getData->TenantEmail ?? '')),
                'website' => $clinicWebsite,
                'facility_working_hours' => $this->format_facility_working_hours($tenantId),
                'phone' => $tenantPhone,
                'logo' => $patientDetails->tenantLogo ?? '',
            ],
            'doctor' => [
                'name' => trim(($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? '')),
                'licence_no' => $doctorLicence,
                'primary_speciality' => trim((string) ($getData->DoctorPrimarySpeciality ?? '')),
                'secondary_speciality' => trim((string) ($getData->DoctorSecondarySpeciality ?? '')),
            ],
            'patient' => [
                'PatientFullName' => ($getData->FirstName ?? '') . ' ' . ($getData->LastName ?? ''),
                'Address' => $patientDetails->Address ?? '',
                'Phone' => ($patientDetails->MobileCode ?? '') . ' ' . $decryptedPhoneNo,
                'Age' => $patientDetails->DateOfBirth ?? $getData->Age ?? '',
                'Sex' => $patientDetails->GenderId ?? $genderChar,
                'ICPassport' => $decryptedIdentityNo ?: ($patientDetails->IdentityNo ?? ''),
                'PatientMRN' => $patientDetails->Prn ?? '',
            ],
            'visit' => [
                'DateOfVisit' => $patientDetails->EnrollmentDate ?? (!empty($getData->AppointmentDate) ? date('d/m/Y', strtotime($getData->AppointmentDate)) : ''),
                'VisitNo' => $patientDetails->EncounterNo ?? $getData->AppointmentNo ?? '',
                'Consultant' => $patientDetails->Consultant ?? (($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? ''))
            ],
            'meta' => [
                'DateOfPrinting' => $patientDetails->CurrentDateTime ?? date('d M Y, h:i A')
            ],
            'printedBy' => 'System',
            'allergies' => array_map(function($item) {
                return [
                    'DateIdentified' => $item->DateIdentified ?? '',
                    'Details' => $item->AllergyDetails ?? '',
                    'Remarks' => $item->Remarks ?? '',
                    'Severity' => $item->AllergySeverity ?? '',
                    'Category' => $item->AllergyCategory ?? ''
                ];
            }, $usp_rpt_Allergies),
            'prescriptions' => array_map(function($item) {
                return [
                    'Medication' => $item->Medication ?? '',
                    'Strength' => '',
                    'Quantity' => $item->Quantity ?? '',
                    'Frequency' => $item->FrequencyMasterDescription ?? '',
                    'DurationDays' => $item->Duration ?? '',
                    'Instructions' => $item->Instruction ?? ''
                ];
            }, $usp_rpt_Prescription),
            'medicalHistory' => [],
            'progress' => [
                'Complaints' => '-',
                'Diagnosis' => '-',
                'Pulse' => '-',
                'BP' => '-',
                'Temperature' => '-',
                'RespiratoryRate' => '-',
                'Investigations' => '-',
            ],
            'investigations' => [],
        ];

        ob_end_clean();
        
        $html = $this->load->view('ring_precription', $data, true);

        $this->mpdf->WriteHTML($html);

        $fileName = 'RING_Prescription_' . ($visit_id ?: 'print') . '.pdf';
        $this->mpdf->Output($fileName, 'I');
        
    } catch (Exception $e) {
        ob_end_clean();
        log_message('error', 'Prescription error: ' . $e->getMessage());
        echo "Error generating prescription: " . $e->getMessage();
    }
}

function clinicalsummary($chargeID = null){

    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
        exit;
    }

    if (!$chargeID) {
        echo "Error: Charge ID is required";
        return;
    }

    ob_start();

    try {
        $chargeHeaderOBj = $this->ReportPdfModel->getEnrolentID($chargeID);
        if (!isset($chargeHeaderOBj[0]->EnrollmentId)) {
            ob_end_clean();
            echo "Error in Page - Invalid Charge ID";
            return;
        }

        $visit_id = $chargeHeaderOBj[0]->EnrollmentId;
        $getData = $this->WebserviceModel->getEnrollmentDetails($visit_id);

        if (!$getData) {
            ob_end_clean();
            echo "Error: Enrollment details not found";
            return;
        }

        $patientId = $getData->PatientId;
        $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails', $patientId, $visit_id);
        $usp_rpt_Medicalhistory = $this->ReportPdfModel->getDataFromSP('usp_rpt_Medicalhistory', $patientId, $visit_id);
        $usp_rpt_Allergies = $this->ReportPdfModel->getDataFromSP('usp_rpt_Allergies', $patientId, $visit_id);
        $usp_rpt_ProgressNotes = $this->ReportPdfModel->getDataFromSP('usp_rpt_ProgressNotes', $patientId, $visit_id);
        $usp_rpt_Investigations = $this->ReportPdfModel->getDataFromSP('usp_rpt_Investigations', $patientId, $visit_id);
        $usp_rpt_Prescription = $this->ReportPdfModel->getDataFromSP('usp_rpt_Prescription', $patientId, $visit_id);
        $usp_rpt_DischargeNotes = $this->ReportPdfModel->getDataFromSP('usp_rpt_DischargeNotes', $patientId, $visit_id);

        if ($getData) {
            $getData->FirstName = $this->encryptDecrypt("dc", $getData->FullName);
            $getData->LastName = $this->encryptDecrypt("dc", $getData->LastName);

            if (!empty($getData->FromTime)) {
                $FromTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
                if ($FromTime) {
                    $getData->FromTime = $FromTime->format('H:i');
                }
            }
            if (!empty($getData->ToTime)) {
                $ToTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
                if ($ToTime) {
                    $getData->ToTime = $ToTime->format('H:i');
                }
            }
            $getData->Age = $this->ageCalculator($getData->DateOfBirth);
        }

        $patientDetails = !empty($usp_rpt_PatientDetails) ? $usp_rpt_PatientDetails[0] : null;

        $genderChar = '';
        if (isset($getData->GenderDescription) && is_string($getData->GenderDescription) && strlen($getData->GenderDescription) > 0) {
            $genderChar = $getData->GenderDescription[0];
        }

        $decryptedIdentityNo = '';
        $decryptedPhoneNo = '';

        if ($patientDetails) {
            if (!empty($patientDetails->IdentityNo)) {
                $decryptedIdentityNo = $this->encryptDecrypt("dc", $patientDetails->IdentityNo);
            }
            if (!empty($patientDetails->PhoneNo)) {
                $decryptedPhoneNo = $this->encryptDecrypt("dc", $patientDetails->PhoneNo);
            }
        }

        $tenantId = isset($getData->TenantId) ? (int) $getData->TenantId : 0;
        $doctorLicence = trim((string) ($getData->MMCNumber ?? ''));
        if ($doctorLicence === '' && !empty($getData->PractitionerCode)) {
            $doctorLicence = trim((string) $getData->PractitionerCode);
        }
        $clinicWebsite = $this->invoice_tenant_website_from_enrollment($getData);
        $tenantPhone = '';
        if ($patientDetails) {
            $tenantPhone = trim((string) (($patientDetails->MobileCode ?? '') . ' ' . $decryptedPhoneNo));
            if ($tenantPhone === '') {
                $tenantPhone = $decryptedPhoneNo ?: (string) ($patientDetails->PhoneNo ?? '');
            }
        } elseif ($decryptedPhoneNo !== '') {
            $tenantPhone = $decryptedPhoneNo;
        }

        $pnList = is_array($usp_rpt_ProgressNotes) ? $usp_rpt_ProgressNotes : [];
        $pn0 = !empty($pnList[0]) ? $pnList[0] : null;

        $progress = [
            'Complaints' => $this->rpt_first_prop($pn0, ['Complaints', 'ChiefComplaint', 'PresentingComplaint'], '—'),
            'Diagnosis' => $this->rpt_first_prop($pn0, ['Diagnosis', 'ProvisionalDiagnosis', 'FinalDiagnosis'], '—'),
            'Pulse' => $this->rpt_first_prop($pn0, ['Pulse', 'PulseRate'], '—'),
            'BP' => $this->rpt_first_prop($pn0, ['BP', 'BloodPressure'], '—'),
            'Temperature' => $this->rpt_first_prop($pn0, ['Temperature', 'Temp'], '—'),
            'RespiratoryRate' => $this->rpt_first_prop($pn0, ['RespiratoryRate', 'Respiration', 'RR'], '—'),
        ];

        $progressNoteLines = [];
        foreach ($pnList as $row) {
            $text = $this->rpt_first_prop($row, [
                'ProgressNotes', 'Notes', 'Note', 'ConsultationNote', 'SOAPNote', 'ClinicalNote', 'Description',
            ], '');
            $dt = $this->rpt_first_prop($row, [
                'NoteDate', 'RecordDate', 'CreatedOn', 'VisitDate', 'DateTime', 'ProgressNoteDate',
            ], '');
            if ($text !== '' || $dt !== '') {
                $progressNoteLines[] = ['date' => $dt, 'text' => $text];
            }
        }

        $dischargeList = is_array($usp_rpt_DischargeNotes) ? $usp_rpt_DischargeNotes : [];
        $dischargeRows = [];
        foreach ($dischargeList as $drow) {
            $dischargeRows[] = [
                'doctorName' => $this->rpt_first_prop($drow, [
                    'DoctorName', 'doctorName', 'DischargeDoctor', 'ConsultantName', 'Doctor', 'PhysicianName',
                ], ''),
                'dischargeDateTime' => $this->rpt_scalar_for_display($drow, [
                    'InsertDate', 'insertDate', 'DischargeDateTime', 'dischargeDateTime', 'DischargeDate',
                ]),
                'icdDescription' => $this->rpt_first_prop($drow, [
                    'ICDCodeDescription', 'icdCodeDescription', 'ICDDescription', 'FinalDiagnosis',
                ], ''),
                'dischargeNotes' => $this->rpt_first_prop($drow, ['DischargeNotes', 'dischargeNotes'], ''),
                'dischargedBy' => $this->rpt_first_prop($drow, [
                    'DischargedBy', 'DischargeBy', 'DischargedByName', 'AddedBy',
                ], ''),
                'followUpDateTime' => $this->rpt_scalar_for_display($drow, [
                    'FollowUpDateTime', 'followUpDateTime',
                ]),
                'followUpRemark' => $this->rpt_first_prop($drow, [
                    'FollowUpRemark', 'followUpRemark', 'FollowUpNotes',
                ], ''),
                'followUpDate' => $this->rpt_scalar_for_display($drow, ['FollowUpDate', 'followUpDate', 'NextVisitDate']),
                'remark' => $this->rpt_first_prop($drow, [
                    'Remark', 'Remarks', 'DischargeRemark', 'Summary', 'GeneralRemark',
                ], ''),
            ];
        }

        $mhRows = is_array($usp_rpt_Medicalhistory) ? $usp_rpt_Medicalhistory : [];

        $data = [
            'tenant' => [
                'name' => $getData->TenantName ?? ($patientDetails->TenantName ?? 'RING Clinic'),
                'address' => $getData->TenantAddress ?? ($patientDetails->TenantAddress ?? ''),
                'email' => trim((string) ($getData->TenantEmail ?? '')),
                'website' => $clinicWebsite,
                'facility_working_hours' => $this->format_facility_working_hours($tenantId),
                'phone' => $tenantPhone,
                'logo' => $patientDetails->tenantLogo ?? '',
            ],
            'doctor' => [
                'name' => trim(($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? '')),
                'licence_no' => $doctorLicence,
                'primary_speciality' => trim((string) ($getData->DoctorPrimarySpeciality ?? '')),
                'secondary_speciality' => trim((string) ($getData->DoctorSecondarySpeciality ?? '')),
            ],
            'patient' => [
                'PatientFullName' => ($getData->FirstName ?? '') . ' ' . ($getData->LastName ?? ''),
                'Address' => $patientDetails->Address ?? '',
                'Phone' => ($patientDetails->MobileCode ?? '') . ' ' . $decryptedPhoneNo,
                'Age' => $patientDetails->DateOfBirth ?? $getData->Age ?? '',
                'Sex' => $patientDetails->GenderId ?? $genderChar,
                'ICPassport' => $decryptedIdentityNo ?: ($patientDetails->IdentityNo ?? ''),
                'PatientMRN' => $patientDetails->Prn ?? '',
            ],
            'visit' => [
                'DateOfVisit' => $patientDetails->EnrollmentDate ?? (!empty($getData->AppointmentDate) ? date('d/m/Y', strtotime($getData->AppointmentDate)) : ''),
                'VisitNo' => $patientDetails->EncounterNo ?? $getData->AppointmentNo ?? '',
                'Consultant' => $patientDetails->Consultant ?? (($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? '')),
            ],
            'meta' => [
                'DateOfPrinting' => $patientDetails->CurrentDateTime ?? date('d M Y, h:i A'),
            ],
            'progress' => $progress,
            'medicalHistory' => array_map(function ($item) {
                return [
                    'DiseaseOrSurgery' => $this->rpt_first_prop($item, ['DiseaseOrSurgery', 'Disease', 'Description', 'Condition'], ''),
                    'DoctorHospital' => $this->rpt_first_prop($item, ['DoctorHospital', 'HospitalName', 'Hospital', 'Doctor', 'Surgeon'], ''),
                    'DateIdentified' => $this->rpt_first_prop($item, ['DateIdentified', 'Date', 'YearOfEvent', 'FromDate'], ''),
                ];
            }, $mhRows),
            'allergies' => array_map(function ($item) {
                return [
                    'DateIdentified' => $item->DateIdentified ?? '',
                    'Details' => $item->AllergyDetails ?? '',
                    'Remarks' => $item->Remarks ?? '',
                    'Severity' => $item->AllergySeverity ?? '',
                    'Category' => $item->AllergyCategory ?? '',
                ];
            }, is_array($usp_rpt_Allergies) ? $usp_rpt_Allergies : []),
            'progressNoteLines' => $progressNoteLines,
            'investigations' => array_map(function ($item) {
                return [
                    'Type' => $this->rpt_first_prop($item, [
                        'Investigation', 'InvestigationType', 'TestName', 'Type', 'Description', 'Name',
                    ], ''),
                    'DateTime' => $this->rpt_first_prop($item, [
                        'Date', 'RequestDate', 'TestDate', 'DateTime', 'OrderedDate',
                    ], ''),
                    'Notes' => $this->rpt_first_prop($item, [
                        'AddedBy', 'Notes', 'Remarks', 'Result', 'Findings', 'Report',
                    ], ''),
                ];
            }, is_array($usp_rpt_Investigations) ? $usp_rpt_Investigations : []),
            'prescriptions' => array_map(function ($item) {
                return [
                    'Medication' => $item->Medication ?? '',
                    'Strength' => '',
                    'Quantity' => $item->Quantity ?? '',
                    'Frequency' => $item->FrequencyMasterDescription ?? '',
                    'DurationDays' => $item->Duration ?? '',
                    'Instructions' => $item->Instruction ?? '',
                ];
            }, is_array($usp_rpt_Prescription) ? $usp_rpt_Prescription : []),
            'dischargeRows' => $dischargeRows,
        ];

        ob_end_clean();

        $html = $this->load->view('ring_clinical_summary', $data, true);

        $this->mpdf->WriteHTML($html);

        $fileName = 'RING_ClinicalSummary_' . ($visit_id ?: 'print') . '.pdf';
        $this->mpdf->Output($fileName, 'I');
    } catch (Exception $e) {
        ob_end_clean();
        log_message('error', 'Clinical summary error: ' . $e->getMessage());
        echo "Error generating clinical summary: " . $e->getMessage();
    }
}

function insuranceinvoice($visit_id=null){

    echo 3 ;
}

}