<?php 
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', '0');
set_time_limit(0);
class ReportPDF extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        ob_clean();
        $this->load->model(array('ReportPdfModel'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->load->library('mpdf_lib');
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');

        $config = [
            'tempDir' => APPPATH . 'tmp' 
        ];
        $this->mpdf = new \Mpdf\Mpdf($config);
        $this->load->library('PdfMerger');
       
    }

    public function createReportPdf(){
        $data = json_decode(file_get_contents('php://input'));
        $root = (isset($_SERVER['HTTPS']) ? "http://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        if($data)
        {
            $patientId = $data->patientId;
            // $reportType = $data->reportType;
            $enrollmentID = $data->enrollmentID;
            $reportData = array();
            $reportData["PatientDetails"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_PatientDetails", $patientId, $enrollmentID);
            // if($reportType == "Prescription"){            
            //     $reportData["Prescription"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_Prescription", $patientId, $enrollmentID);
            //     $reportData["Allergies"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_Allergies", $patientId, $enrollmentID);
            // }else if($reportType == "Clinical"){            
            $reportData["Prescription"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_Prescription", $patientId, $enrollmentID);
            $reportData["Allergies"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_Allergies", $patientId, $enrollmentID);
            $reportData["Medicalhistory"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_Medicalhistory", $patientId, $enrollmentID);
            $reportData["ProgressNotes"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_ProgressNotes", $patientId, $enrollmentID); 
            $reportData["DischargeNotes"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_DischargeNotes", $patientId, $enrollmentID);
            $reportData["Investigations"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_Investigations", $patientId, $enrollmentID);            
            // }
            $reportData["PaymentDetails"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_PaymentDetails", $patientId, $enrollmentID);  
            $reportData["InvoiceDetails"] = $this->ReportPdfModel->getDataFromSP("usp_rpt_InvoiceDetails", $patientId, $enrollmentID);
            if($reportData)
            { 
                // echo "<pre>"; print_r($reportData);exit;
                $createRepPdf = $this->createPdf($patientId,$reportData);
            }
            if($createRepPdf)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $createRepPdf;
                $response['fileWithPath'] = "https://apimobile.ring.healthcare/Ring_dev/".$createRepPdf;
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }
            
        }
        else
        {
            $response['response_code'] = 3;
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    function createPdf($patientId,$dataArray){
        $filepath = "https://apimobile.ring.healthcare:8443/Ring_dev/upload/";
        $template_name = 'template/report.html';
        $content = file_get_contents($template_name);
        $this->mpdf->AddPage('', '', '', '', '',
        20, // margin_left
        20, // margin right
        25, // margin top
        35, // margin bottom
        5, // margin header
        5); // margin footer
        
        $content = $this->createPdfContentHtml($content,$dataArray);
        $path =  dirname(dirname(__DIR__)).'/pdfDoc/';
        $pdfName = time().rand(1,10).'Report'.$patientId.'.pdf';
        $this->mpdf->WriteHTML($content);
        $this->mpdf->Output($path.$pdfName, "F");
        $pdfPath ='pdfDoc/'.$pdfName;
        return $pdfPath;
        
    }

    public function createPdfContentHtml($content,$reportData){
        echo "<pre>"; print_r($reportData);exit;
        $filepath = "https://apimobile.ring.healthcare:8443/Ring_dev/upload/";  
        $str = '';
        $str .= '<div class="a4"><section class="page"><img src="https://apimobile.ring.healthcare:8443/Ring_dev/assets/logo/RingLogo.png" width="150">';

        $patient = $reportData['PatientDetails'][0];
        $invoice = $reportData['InvoiceDetails'][0];
        $PhoneNo = $this->encryptDecrypt("dc",$patient->PhoneNo);
        $str.= '<div class="header">
            <div class="logo-wrap">
            <div>
                <h1>' . $patient->TenantName . '</h1>
                <div class="clinic-meta muted">' . $patient->TenantAddress . ' · ' . $patient->MobileCode.$PhoneNo. ' · ring.healthcare</div>
            </div>
            </div>
            <div class="doc-block w-100" style="width: 100%;">
            <div class="badge">OUTPATIENT BILL</div>
            <h3 class="mt-8 tight">Consultant</h3>
            <p class="tight"><strong>' . $patient->Consultant . '</strong></p>
            </div>
        </div>';
        // ---------- Patient / Invoice Info ----------
        $Fullname = $this->encryptDecrypt("dc",$patient->Fullname);
        $Lastname = $this->encryptDecrypt("dc",$patient->Lastname);
        $str .= '<div class="info card">
                    <div>
                        <h2>Patient</h2>
                        <div class="kv"><div class="k">Name</div><div class="v">' . $Fullname . ' ' . $Lastname . '</div></div>
                        <div class="kv"><div class="k">Age / Sex</div><div class="v">' . $patient->DateOfBirth . ' / ' . $patient->GenderId . '</div></div>
                        <div class="kv"><div class="k">MRN</div><div class="v mono">' . $patient->Prn . '</div></div>
                    </div>
                    <div>
                        <h2>Visit</h2>
                        <div class="kv"><div class="k">Visit No</div><div class="v mono">' . $patient->EncounterNo . '</div></div>
                        <div class="kv"><div class="k">Visit Date</div><div class="v">' . $patient->EnrollmentDate . '</div></div>
                        <div class="kv"><div class="k">Department</div><div class="v">General Medicine</div></div>
                    </div>
                    <div>
                        <h2>Invoice</h2>
                        <div class="kv"><div class="k">Invoice No</div><div class="v mono">' . $invoice->InvoiceNo . '</div></div>
                        <div class="kv"><div class="k">Invoice Date</div><div class="v">' . $invoice->InvoiceDate . '</div></div>
                        <div class="kv"><div class="k">Currency</div><div class="v">MYR</div></div>
                    </div>
                </div>';

        // ---------- Prescription Table ----------
        $str .= '<div class="mt-12"><table>
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Strength</th>
                            <th>Dosage</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($reportData['Prescription'] as $rx) {
            $str .= '<tr>
                        <td>' . $rx->Medication . '</td>
                        <td>—</td>
                        <td>' . $rx->FrequencyMasterDescription . '</td>
                        <td>' . $rx->Duration . ' days</td>
                        <td>' . $rx->Instruction . '</td>
                    </tr>';
        }
        $str .= '</tbody></table></div>';

        // ---------- Allergies ----------
        if(!empty($reportData['Allergies'])){
            $str .= '<div class="mt-12"><h2>Allergies</h2>';
            foreach ($reportData['Allergies'] as $alg) {
                $str .= '<p><strong class="danger">' . $alg->AllergyDetails . '</strong> — ' . $alg->Remarks . ' (' . $alg->AllergySeverity . ')</p>';
            }
            $str .= '</div>';
        }

        // ---------- Vitals / Progress Notes ----------
        if(!empty($reportData['ProgressNotes'])){
            $pn = $reportData['ProgressNotes'][0];
            $str .= '<div class="grid grid-2 mt-12">
                        <div class="card">
                            <h2>Vitals</h2>
                            <div class="kv"><div class="k">Pulse</div><div class="v">' . $pn->Pulse . ' bpm</div></div>
                            <div class="kv"><div class="k">Blood Pressure</div><div class="v">' . $pn->BP . ' mmHg</div></div>
                            <div class="kv"><div class="k">Temperature</div><div class="v">' . $pn->Temperature . ' °C</div></div>
                            <div class="kv"><div class="k">Respiration</div><div class="v">' . $pn->RespiratoryRate . ' / min</div></div>
                        </div>';
        }

        // ---------- Medical History ----------
        if(!empty($reportData['Medicalhistory'])){
            $mh = $reportData['Medicalhistory'][0];
            $str .= '<div class="card">
                        <h2>History</h2>
                        <p class="tight">' . $mh->Disease . ' — ' . $mh->HospitalName . '.</p>
                    </div>';
        }
        $str .= '</div>'; // close grid

        // ---------- Payments ----------
        if(!empty($reportData['PaymentDetails'])){
            $str .= '<div class="mt-12 card">
                        <h2>Payments</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Date / Time</th>
                                    <th class="num">Amount</th>
                                </tr>
                            </thead>
                            <tbody>';
            $totalPaid = 0;
            foreach ($reportData['PaymentDetails'] as $pay) {
                $totalPaid += (float)$pay->PaymentAmount;
                $str .= '<tr>
                            <td>' . $pay->PaymentMode . '</td>
                            <td class="mono">' . ($pay->ChequeCardNo ?: '—') . '</td>
                            <td>' . $pay->PaymentDate . '</td>
                            <td class="num">' . $pay->PaymentAmount . '</td>
                        </tr>';
            }
            $str .= '<tr>
                        <td colspan="3" class="num"><strong>Total Paid</strong></td>
                        <td class="num"><strong>' . number_format($totalPaid,2) . '</strong></td>
                    </tr>';
            $str .= '</tbody></table></div>';
        }

        // ---------- Totals / Amount in Words ----------
        $str .= '<div class="mt-12 meta-row">
                    <div class="amount-words">
                        <strong>Amount in words:</strong>
                        <div>' . $invoice->AmountInWords . '</div>
                    </div>
                    <table class="totals">
                        <tr><td>Subtotal</td><td class="num">' . $invoice->NetAmount . '</td></tr>
                        <tr><td>Discount</td><td class="num">' . $invoice->DiscountAmount . '</td></tr>
                        <tr><td>Tax</td><td class="num">' . $invoice->TaxAmount . '</td></tr>
                        <tr class="grand"><td>Balance</td><td class="num">' . $invoice->BillAmount . '</td></tr>
                    </table>
                </div>';


        
        $content = str_replace(
         array('VAR_ITEM_DATA'),
         array($str),
         $content
      );
      return $content;
    }

    function encryptDecrypt($type,$name){
        if($type == 'en'){
            $type1 = "Encrypt";
        }else{
            $type1 = "Decrypt";
        }
        $arrayToSend = array('userName'=>$name,'type'=>$type1);
        $url = 'https://internalapi.ring.healthcare/api/Register/EncryptDecrypt';
        $json = json_encode($arrayToSend);           
        $headers = array('Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);            
        $response = curl_exec($ch);         
        curl_close($ch); 
        return  $response;
    }
}