<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller
{
    public $currency;
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
        $this->currency = 'Ringgit';

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
          //  print_r( $getData->CurrrencyCode); exit;
            
            $usp_rpt_BillDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_BillDetails',$getData->PatientId,$visit_id );   
            $usp_rpt_InvoiceDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_InvoiceDetails',$getData->PatientId,$visit_id );
            $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails',$getData->PatientId,$visit_id );
            $usp_rpt_PaymentDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PaymentDetails',$getData->PatientId,$visit_id );
             $patientDetails = !empty($usp_rpt_PatientDetails) ? $usp_rpt_PatientDetails[0] : null;

            // echo "<pre>";
            // print_r( $usp_rpt_BillDetails); 
            //  print_r( $usp_rpt_InvoiceDetails);
            //  print_r( $usp_rpt_PatientDetails);
            // print_r(  $patientDetails); exit;
             if (!empty($patientDetails->PhoneNo)) {
                $decryptedPhoneNo = $this->encryptDecrypt("dc", $patientDetails->PhoneNo);
            }
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

       $this->currency = $getData->CurrrencyCode ;
      // echo "<pre>"; 
     //   print_r($getData); 'PatientMRN' => $patientDetails->Prn ?? '',
        $data = [
            'visit_id'  => $visit_id,
             'Presp' => $usp_rpt_BillDetails,
             'Bill' => $usp_rpt_InvoiceDetails,
             'currency'=>$getData->CurrrencyCode,
            'payment_detail'=>$usp_rpt_PaymentDetails,
            'tenant' => [
                'name' => $patientDetails->TenantName ?? $getData->TenantName ?? 'RING Clinic',
                'address' => $patientDetails->TenantAddress ?? $getData->TenantAddress ?? '',
                 'CityDescription' => $getData->CityDescription ?? $getData->CityDescription ?? '',
                 'StateDescription' => $getData->StateDescription ?? $getData->StateDescription ?? '',
                 'CountryDescription' => $getData->CountryDescription ?? $getData->CountryDescription ?? '',
                 'postcode' => $getData->postcode ?? $getData->postcode ?? '',
                'phone' => $decryptedPhoneNo ?: ($getData->PhoneNo ?? ''),
                'email' => '',
                'logo' => $patientDetails->tenantLogo ?? ''
            ],
            'patient'   => [
                'name' => $getData->FirstName .' '.$getData->LastName,
                'age'  => $getData->Age,
                'sex'  => $getData->GenderDescription[0],
                'appointmentDate'=> date('d M Y', strtotime( $getData->AppointmentDate)),
                'AppointmentNo'=> $getData->AppointmentNo,
                'PatientMRN' => $patientDetails->Prn ?? ''
            ],
             'doctor'   => [
                         'name' => $getData->DoctorFName .' '.$getData->DoctorLName  ,
                         'deprt' => $getData->Department        
             ],

           
            // add whatever you want to pass into the view
        ];
        
        //   print_r($data); exit;
        // 2. Load HTML from view
         $html = $this->load->view('ring_invoice', $data, true);   //exit ;

        // 3. Load mPDF library
       // $this->load->library('mn_pdf');

        // 4. Optional: set base path for CSS/images if needed
        // $this->m_pdf->pdf->setBasePath(base_url());

        // 5. Write HTML to PDF
        $this->mpdf->shrink_tables_to_fit = 0;
        $this->mpdf->keep_table_proportions = true;
        $this->mpdf->WriteHTML($html);

           
        // 6. Output PDF (I = inline, D = download)
       $fileName = 'RING_Invoice_' . ($visit_id ?: 'print') . '.pdf';
       $this->mpdf->Output($fileName, 'I');
    }

    public function print_new($chargeID = null)
{
    if (empty($chargeID)) {
        show_error('Invalid Charge ID');
        return;
    }

    $chargeHeaderOBj = $this->ReportPdfModel->getEnrolentID($chargeID);

    if (empty($chargeHeaderOBj) || !isset($chargeHeaderOBj[0]->EnrollmentId)) {
        show_error('Enrollment not found');
        return;
    }

    $visit_id = $chargeHeaderOBj[0]->EnrollmentId;
    $getData  = $this->WebserviceModel->getEnrollmentDetails($visit_id);

    if (empty($getData)) {
        show_error('Enrollment details not found');
        return;
    }

    $usp_rpt_BillDetails     = $this->ReportPdfModel->getDataFromSP('usp_rpt_BillDetails', $getData->PatientId, $visit_id);
    $usp_rpt_InvoiceDetails  = $this->ReportPdfModel->getDataFromSP('usp_rpt_InvoiceDetails', $getData->PatientId, $visit_id);
    $usp_rpt_PatientDetails  = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails', $getData->PatientId, $visit_id);
    $usp_rpt_PaymentDetails  = $this->ReportPdfModel->getDataFromSP('usp_rpt_PaymentDetails', $getData->PatientId, $visit_id);

    $patientDetails = !empty($usp_rpt_PatientDetails) ? $usp_rpt_PatientDetails[0] : null;
    $invoiceDetails = !empty($usp_rpt_InvoiceDetails) ? $usp_rpt_InvoiceDetails[0] : null;

    $decryptedPhoneNo = '';

    if (!empty($patientDetails) && !empty($patientDetails->PhoneNo)) {
        $decryptedPhoneNo = $this->encryptDecrypt("dc", $patientDetails->PhoneNo);
    } elseif (!empty($getData->PhoneNo)) {
        $decryptedPhoneNo = $getData->PhoneNo;
    }

    // Decrypt patient name
    $getData->FirstName = !empty($getData->FullName) ? $this->encryptDecrypt("dc", $getData->FullName) : '';
    $getData->LastName  = !empty($getData->LastName) ? $this->encryptDecrypt("dc", $getData->LastName) : '';

    // Format time safely
    $getData->FromTime = '';
    if (!empty($getData->FromTime)) {
        $fromTimeObj = DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
        if ($fromTimeObj) {
            $getData->FromTime = $fromTimeObj->format('H:i');
        }
    }

    $getData->ToTime = '';
    if (!empty($getData->ToTime)) {
        $toTimeObj = DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
        if ($toTimeObj) {
            $getData->ToTime = $toTimeObj->format('H:i');
        }
    }

    $getData->Age = !empty($getData->DateOfBirth) ? $this->ageCalculator($getData->DateOfBirth) : '';

    $this->currency = $getData->CurrrencyCode ?? '';

    $data = [
        'visit_id' => $visit_id,
        'BillDetails' => $usp_rpt_BillDetails,
        'InvoiceDetails' => $usp_rpt_InvoiceDetails,
        'InvoiceSummary' => $invoiceDetails,
        'currency' => $getData->CurrrencyCode ?? '',
        'payment_detail' => $usp_rpt_PaymentDetails,

        'tenant' => [
            'name' => $patientDetails->TenantName ?? $getData->TenantName ?? 'RING Clinic',
            'address' => $patientDetails->TenantAddress ?? $getData->TenantAddress ?? '',
            'CityDescription' => $getData->CityDescription ?? '',
            'StateDescription' => $getData->StateDescription ?? '',
            'CountryDescription' => $getData->CountryDescription ?? '',
            'postcode' => $getData->PostCode ?? '',
            'phone' => $decryptedPhoneNo,
            'email' => '',
            'logo' => $patientDetails->tenantLogo ?? ''
        ],

        'patient' => [
            'name' => trim(($getData->FirstName ?? '') . ' ' . ($getData->LastName ?? '')),
            'age' => $getData->Age ?? '',
            'sex' => !empty($getData->GenderDescription) ? substr($getData->GenderDescription, 0, 1) : '',
            'appointmentDate' => !empty($getData->AppointmentDate) ? date('d M Y', strtotime($getData->AppointmentDate)) : '',
            'AppointmentNo' => $getData->AppointmentNo ?? '',
            'PatientMRN' => $patientDetails->Prn ?? ''
        ],

        'doctor' => [
            'name' => trim(($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? '')),
            'deprt' => $getData->Department ?? ''
        ],
    ];

    // Uncomment only for debug
    /*
    echo "<pre>";
    print_r($data);
    exit;
    */

    $html = $this->load->view('ring_invoice', $data, true);

    $this->mpdf->WriteHTML($html);

    $fileName = 'RING_Invoice_' . $visit_id . '.pdf';
    $this->mpdf->Output($fileName, 'I');
}

    /**
     * Get bill detail as JSON (same logic as print, for drawer display).
     * GET /api/invoice/bill-detail/{chargeId}
     */
    public function billDetail($chargeID = null)           // Need to remove
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
        $usp_rpt_InvoiceDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_InvoiceDetails', $getData->PatientId, $visit_id);
        $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails', $getData->PatientId, $visit_id);
        $usp_rpt_PaymentDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PaymentDetails', $getData->PatientId, $visit_id);
        $patientDetails = !empty($usp_rpt_PatientDetails) ? $usp_rpt_PatientDetails[0] : null;

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
        $billItems = [];
        foreach ($usp_rpt_BillDetails as $p) {
            $totalAmt += (float) $p->Amount;
            $totalDisc += (float) ($p->Discount ?? 0);
            $billItems[] = [
                'code' => $p->Code ?? '',
                'description' => $p->Description ?? '',
                'quantity' => (float) ($p->Quantity ?? 0),
                'unitPrice' => (float) ($p->UnitPrice ?? 0),
                'discount' => (float) ($p->Discount ?? 0),
                'amount' => (float) ($p->Amount ?? 0),
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
        $invoiceNo = $firstBill && isset($firstBill->InvoiceNo) ? $firstBill->InvoiceNo : '';
        $invoiceDate = '';
        if ($firstBill && !empty($firstBill->BillDate ?? $firstBill->InvoiceDate ?? null)) {
            $invoiceDate = date('d M Y', strtotime($firstBill->BillDate ?? $firstBill->InvoiceDate));
        } else {
            $invoiceDate = date('d M Y');
        }
        $balance = $totalAmt - $totalDisc;

        $data = [
            'success' => true,
            'visitId' => (int) $visit_id,
            'chargeId' => (int) $chargeID,
          
              'tenant' => [
                'name' => $patientDetails->TenantName ?? $getData->TenantName ?? 'RING Clinic',
                'address' => $patientDetails->TenantAddress ?? $getData->TenantAddress ?? '',
                 'CityDescription' => $getData->CityDescription ?? $getData->CityDescription ?? '',
                 'StateDescription' => $getData->StateDescription ?? $getData->StateDescription ?? '',
                 'CountryDescription' => $getData->CountryDescription ?? $getData->CountryDescription ?? '',
                 'postcode' => $getData->postcode ?? $getData->postcode ?? '',
                'phone' => $decryptedPhoneNo ?: ($getData->PhoneNo ?? ''),
                'email' => '',
                'logo' => $patientDetails->tenantLogo ?? ''
            ],
            'doctor' => [
                'name' => ($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? ''),
                'department' => $getData->Department ?? '',
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


function amountInWordsMYR($number,$currency='')
{
    $no = floor($number);
    $decimal = round($number - $no, 2) * 100;
   
   
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

    return $result . ' '.$currency . $sen . ' Only';
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
       // print_r( $patientDetails); exit ;
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

        $data = [
              'tenant' => [
                'name' => $patientDetails->TenantName ?? $getData->TenantName ?? 'RING Clinic',
                'address' => $patientDetails->TenantAddress ?? $getData->TenantAddress ?? '',
                 'CityDescription' => $getData->CityDescription ?? $getData->CityDescription ?? '',
                 'StateDescription' => $getData->StateDescription ?? $getData->StateDescription ?? '',
                 'CountryDescription' => $getData->CountryDescription ?? $getData->CountryDescription ?? '',
                 'postcode' => $getData->postcode ?? $getData->postcode ?? '',
                'phone' => $decryptedPhoneNo ?: ($getData->PhoneNo ?? ''),
                'email' => '',
                'logo' => $patientDetails->tenantLogo ?? ''
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

function clinicalsummary($chargeID = null)
{
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

        // Get all clinical summary data
        $clinicalData = $this->ReportPdfModel->getClinicalSummary($patientId, $visit_id);

        // Decrypt / format patient basic details
        $getData->FirstName = $this->encryptDecrypt("dc", $getData->FullName);
        $getData->LastName  = $this->encryptDecrypt("dc", $getData->LastName);

        if (!empty($getData->FromTime)) {
            $FromTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->FromTime);
            if ($FromTime) $getData->FromTime = $FromTime->format('H:i');
        }

        if (!empty($getData->ToTime)) {
            $ToTime = @DateTime::createFromFormat('Y-m-d H:i:s.u', $getData->ToTime);
            if ($ToTime) $getData->ToTime = $ToTime->format('H:i');
        }

        $getData->Age = $this->ageCalculator($getData->DateOfBirth);

        $patientDetails   = !empty($clinicalData['patient_details']) ? $clinicalData['patient_details'][0] : null;
        $allergies        = $clinicalData['allergies'] ?? [];
        $prescriptions    = $clinicalData['prescription'] ?? [];
        $medicalHistory   = $clinicalData['medical_history'] ?? [];
        $progressNotes    = $clinicalData['progress_notes'] ?? [];
        $investigations   = $clinicalData['investigations'] ?? [];
        $dischargeNotes   = $clinicalData['discharge_notes'] ?? [];

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

        $data = [
            'tenant' => [
                'name' => $patientDetails->TenantName ?? $getData->TenantName ?? 'RING Clinic',
                'address' => $patientDetails->TenantAddress ?? $getData->TenantAddress ?? '',
                 'CityDescription' => $getData->CityDescription ?? $getData->CityDescription ?? '',
                 'StateDescription' => $getData->StateDescription ?? $getData->StateDescription ?? '',
                 'CountryDescription' => $getData->CountryDescription ?? $getData->CountryDescription ?? '',
                 'postcode' => $getData->postcode ?? $getData->postcode ?? '',
                'phone' => $decryptedPhoneNo ?: ($getData->PhoneNo ?? ''),
                'email' => '',
                'logo' => $patientDetails->tenantLogo ?? ''
            ],
            'patient' => [
                'PatientFullName' => trim(($getData->FirstName ?? '') . ' ' . ($getData->LastName ?? '')),
                'Address'         => $patientDetails->Address ?? '',
                'Phone'           => ($patientDetails->MobileCode ?? '') . ' ' . $decryptedPhoneNo,
                'Age'             => $patientDetails->DateOfBirth ?? $getData->Age ?? '',
                'Sex'             => $patientDetails->GenderId ?? '',
                'ICPassport'      => $decryptedIdentityNo ?: ($patientDetails->IdentityNo ?? ''),
                'PatientMRN'      => $patientDetails->Prn ?? '',
            ],
            'visit' => [
                'DateOfVisit' => $patientDetails->EnrollmentDate ?? (!empty($getData->AppointmentDate) ? date('d/m/Y', strtotime($getData->AppointmentDate)) : ''),
                'VisitNo'     => $patientDetails->EncounterNo ?? $getData->AppointmentNo ?? '',
                'Consultant'  => $patientDetails->Consultant ?? (($getData->DoctorFName ?? '') . ' ' . ($getData->DoctorLName ?? ''))
            ],
            'meta' => [
                'DateOfPrinting' => $patientDetails->CurrentDateTime ?? date('d M Y, h:i A')
            ],
            'printedBy' => 'System',

            'allergies' => array_map(function($item) {
                return [
                    'DateIdentified' => $item->DateIdentified ?? '',
                    'Details'        => $item->AllergyDetails ?? '',
                    'Remarks'        => $item->Remarks ?? '',
                    'Severity'       => $item->AllergySeverity ?? '',
                    'Category'       => $item->AllergyCategory ?? ''
                ];
            }, $allergies),

            'prescriptions' => array_map(function($item) {
                return [
                    'Medication'    => $item->Medication ?? '',
                    'Strength'      => $item->Strength ?? '',
                    'Quantity'      => $item->Quantity ?? '',
                    'Frequency'     => $item->FrequencyMasterDescription ?? '',
                    'DurationDays'  => $item->Duration ?? '',
                    'Instructions'  => $item->Instruction ?? ''
                ];
            }, $prescriptions),

            'medicalHistory' => array_map(function($item) {
                return [
                    'Condition'   => $item->Condition ?? ($item->Diagnosis ?? ''),
                    'Remarks'     => $item->Remarks ?? '',
                    'RecordedOn'  => $item->RecordedOn ?? ''
                ];
            }, $medicalHistory),

            'progressNotes' => array_map(function($item) {
                return [
                    'Date'          => $item->Date ?? '',
                    'Complaints'    => $item->Complaints ?? '',
                    'Diagnosis'     => $item->Diagnosis ?? '',
                    'Notes'         => $item->Notes ?? '',
                    'Pulse'         => $item->Pulse ?? '',
                    'BP'            => $item->BP ?? '',
                    'Temperature'   => $item->Temperature ?? '',
                    'RespiratoryRate' => $item->RespiratoryRate ?? '',
                ];
            }, $progressNotes),

            'investigations' => array_map(function($item) {
                return [
                    'Date'        => $item->Date ?? '',
                    'TestName'    => $item->TestName ?? '',
                    'Result'      => $item->Result ?? '',
                    'Remarks'     => $item->Remarks ?? ''
                ];
            }, $investigations),

            'dischargeNotes' => array_map(function($item) {
                return [
                    'Summary'        => $item->Summary ?? '',
                    'Advice'         => $item->Advice ?? '',
                    'FollowUp'       => $item->FollowUp ?? '',
                    'DischargeDate'  => $item->DischargeDate ?? ''
                ];
            }, $dischargeNotes),
        ];

        ob_end_clean();

        // Create separate clinical summary view
        $html = $this->load->view('ring_summary', $data, true);

        $this->mpdf->WriteHTML($html);

        $fileName = 'RING_ClinicalSummary_' . ($visit_id ?: 'print') . '.pdf';
        $this->mpdf->Output($fileName, 'I');

    } catch (Exception $e) {
        ob_end_clean();
        log_message('error', 'Clinical Summary error: ' . $e->getMessage());
        echo "Error generating clinical summary: " . $e->getMessage();
    }
}

function insuranceinvoice($visit_id=null){

    echo 3 ;
}

}