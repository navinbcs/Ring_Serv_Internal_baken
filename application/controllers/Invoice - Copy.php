<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller
{
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
            $usp_rpt_InvoiceDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_InvoiceDetails',$getData->PatientId,$visit_id );
            $usp_rpt_PatientDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PatientDetails',$getData->PatientId,$visit_id );
            $usp_rpt_PaymentDetails = $this->ReportPdfModel->getDataFromSP('usp_rpt_PaymentDetails',$getData->PatientId,$visit_id );
            
            //  print_r( $usp_rpt_BillDetails);
            //  print_r( $usp_rpt_InvoiceDetails);
            //  print_r( $usp_rpt_PatientDetails);
            // print_r(  $usp_rpt_PaymentDetails); exit;
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

      
    
        $data = [
            'visit_id'  => $visit_id,
             'Presp' => $usp_rpt_BillDetails,
            'payment_detail'=>$usp_rpt_PaymentDetails,
            'patient'   => [
                'name' => $getData->FirstName .' '.$getData->LastName,
                'age'  => $getData->Age,
                'sex'  => $getData->GenderDescription[0],
                'appointmentDate'=> date('d M Y', strtotime( $getData->AppointmentDate)),
                'AppointmentNo'=> $getData->AppointmentNo
            ],
             'doctor'   => [
                         'name' => $getData->DoctorFName .' '.$getData->DoctorLName  ,
                         'deprt' => $getData->Department        
             ],

            'tenant' => [
                         'name' => $getData->TenantName ,  
                         'address' => $getData->TenantAddress ,       
                           ]
           
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
        if($type == 'en'){
            $type1 = "Encrypt";
        }else{
            $type1 = "Decrypt";
        }
        $arrayToSend = array('userName'=>$name,'type'=>$type1);
        $url = 'https://internalapi.ring.healthcare:8443/api/Register/EncryptDecrypt';
        $json = json_encode($arrayToSend);           
        $headers = array('Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);            
        $response = curl_exec($ch); 
        // if ($response === false) {
        //     echo 'cURL error: ' . curl_error($ch);
        // } else {
        //     echo 'Response: ' . $response;
        // }        
        curl_close($ch); 
        
        // print_r($response);exit;
        return  $response;
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

function prescription($visit_id=null){

    if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
        echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
        exit;
    }

   


        // ---------------------------
        // 3) Mock Data (static)
        // ---------------------------
       $data = [
  'tenant' => [
    'name' => 'RING Clinic Kuala Lumpur',
    'address' => '8-02, Vertical Business Suites, Jln. Kerinchi, Bangsar South, W.P. Kuala Lumpur, 59200, Malaysia',
    'phone' => '+60 3-1234 5678',
    'email' => 'info@ring.healthcare',
    'logo' => ''
  ],
  'patient' => [
    'PatientFullName' => 'KESUTO AZURE',
    'Address' => 'MYS, Malaysia',
    'Phone' => '+60 867867867',
    'Age' => '40',
    'Sex' => 'Male',
    'ICPassport' => 'MYR326326',
    'PatientMRN' => 'RCM01-PRN-00003',
  ],
  'visit' => [
    'DateOfVisit' => '23/07/2025',
    'VisitNo' => 'RCKL1-00000030',
    'Consultant' => 'Dr. Greg House'
  ],
  'meta' => [
    'DateOfPrinting' => date('d M Y, h:i A')
  ],
  'printedBy' => 'System',
  'allergies' => [
    ['DateIdentified'=>'01/05/2025','Details'=>'dust','Remarks'=>'sneeze','Severity'=>'Minor','Category'=>'Non-drug'],
  ],
  'prescriptions' => [
    ['Medication'=>'Paracetamol 500mg','Quantity'=>'10','Frequency'=>'1-0-1','DurationDays'=>'5','Instructions'=>'After food'],
  ],
  'medicalHistory' => [
    ['DateIdentified'=>'01/05/2025','DiseaseOrSurgery'=>'skin','DoctorHospital'=>'Dr. Greg','UpdatedBy'=>'Dr. Greg House','UpdatedDate'=>'28/05/2025'],
  ],
  'progress' => [
    'Complaints' => '-',
    'Diagnosis' => '-',
    'Pulse' => '-',
    'BP' => '-',
    'Temperature' => '-',
    'RespiratoryRate' => '-',
    'Investigations' => '-',
  ],
  'investigations' => [
    ['DateTime'=>'23/07/2025 06:43 AM','Type'=>'General Consultation Consultation','By'=>'Dr. Greg House'],
  ],
];

        // ---------------------------
        // 4) Load HTML from view
        // Create: application/views/ring_package_bill_mockup.php
        // ---------------------------
        $html = $this->load->view('ring_precription', $data, true);


        // ---------------------------
        // 5) PDF output (inline like invoice)
        // ---------------------------
        $this->mpdf->WriteHTML($html);

        $fileName = 'PackageBill_Mockup_' . date('Ymd_His') . '.pdf';
        $this->mpdf->Output($fileName, 'I'); // I = inline in browser
}

function clinicalsummary($visit_id=null){

    echo 2 ;
}

function insuranceinvoice($visit_id=null){

    echo 3 ;
}

}