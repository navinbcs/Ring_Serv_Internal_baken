<?php 
date_default_timezone_set('Asia/Kolkata');
class FinancialService extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model(array('WebserviceModel'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
     //   $this->load->library('m_pdf');
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');
    }

    function saveFinancialReportOfPatient()
    {
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $insertArray = array( 
                "DoctorName"=>$data->DoctorName,
                "PatientName"=>$data->PatientName,
                "RingId"=>$data->RingId,
                "RecordType"=>$data->CategoryName,
                "ImplementationId"=>$data->ImpId,
                "HospitalName"=>$data->HospitalName,
		        "CMSName"=>$data->CMSName,
                "PatientMobileCode"=>$data->PatientMobileCode,
                "PatientMobile"=>$data->PatientMobile,
                "PatientEmail"=>$data->PatientEmail,
		        "PatientMRN"=>$data->UserId,
                "DocumentUrl"=>$data->FileAttachments[0]->DocumentUrl                               
            );
            // print_r($insertArray);exit;
            $saveData = $this->WebserviceModel->saveFinancialReportOfPatient($insertArray);            
            if($saveData)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
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

    function CMSNameList()
    {
        $data = $this->WebserviceModel->CMSNameList();
            if($data)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
		$response['response_data'] = $data;
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }
	echo json_encode($response);exit;
    }

    function getFinancialReportDataAndCount()
    {
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $cms_name = isset($data->CMS_Name)?$data->CMS_Name:"";
            $start_date = date_create($data->start_date);
            $startDate = date_format($start_date,"Y-m-d 00:00:00.000");
            $end_date = date_create($data->end_date);
            $endDate = date_format($end_date,"Y-m-d 23:59:59.000");
            if(isset($cms_name) && !empty($cms_name)){
                $BillingData = $this->WebserviceModel->getBillingData($cms_name,$startDate,$endDate);
                $MRDTData = $this->WebserviceModel->getMRDTData($cms_name,$startDate,$endDate);
                //echo "<pre>"; print_r($MRDTData);exit;
                $UserData = $this->WebserviceModel->getMRDTUserData($cms_name,$startDate,$endDate);
                $AllMRDTData = $this->WebserviceModel->getAllMRDTData($cms_name,$startDate,$endDate);
                if($AllMRDTData){
                    foreach($AllMRDTData as $AllMRDTDataVal){
                        $AllMRDTDataVal->AmountVal = 3;
                        $AllMRDTDataVal->Amount = '3 MYR';
                    }		
                }
                $result['BillingData'] = $BillingData;
                $result['AllMrdtData'] = $AllMRDTData;
                $result['Invoice_Count'] = count($BillingData);
                $result['MRDT_Count'] = count($MRDTData);
                if($cms_name == "SITI CLINIC"){
                    $userContInSiti = $this->WebserviceModel->getIntegratedUser($cms_name,$startDate,$endDate);
                    $result['User_Count'] = $userContInSiti->Id;
                }else if($cms_name == "RAMCAR"){
                    $userContInRAMCAR = $this->getIntegratedUser("RAMCAR",$startDate,$endDate);
                    $result['User_Count'] = isset($userContInRAMCAR)?$userContInRAMCAR:0;
                }else if($cms_name == "ORIANA"){
                    // $userContInOriana = $this->getIntegratedUser("ORIANA",$startDate,$endDate);
                    $result['User_Count'] = isset($userContInOriana)?$userContInOriana:0;
                }
                    
                $result['Total_File_Count'] = count($BillingData) + count($MRDTData);
                $Transaction_cost = $this->config->item("Transaction_cost");
                $result['Amount'] = $result['Total_File_Count'] * $Transaction_cost." MYR";
            }else{
                $BillingData = $this->WebserviceModel->getBillingData($cms_name,$startDate,$endDate);
                $MRDTData = $this->WebserviceModel->getMRDTData($cms_name,$startDate,$endDate);
		        $UserData = $this->WebserviceModel->getMRDTUserData($cms_name,$startDate,$endDate);
                $AllMRDTData = $this->WebserviceModel->getAllMRDTData($cms_name,$startDate,$endDate);
                $permaiMRDT = $this->WebserviceModel->getpermaiMRDTData($startDate,$endDate);
                if($AllMRDTData){
                    foreach($AllMRDTData as $AllMRDTDataVal){
                        $AllMRDTDataVal->AmountVal = 3;
                        $AllMRDTDataVal->Amount = '3 MYR';
                    }		
                }
                $result['BillingData'] = $BillingData;
                $result['AllMrdtData'] = $AllMRDTData;
                $result['Invoice_Count'] = count($BillingData);
                $result['MRDT_Count'] = count($MRDTData) + count($permaiMRDT);
                $userCountInSiti = $this->WebserviceModel->getIntegratedUser($cms_name,$startDate,$endDate);
                $userContInRAMCAR = $this->getIntegratedUser("RAMCAR",$startDate,$endDate);
                //print_r($userContInRAMCAR);exit;
                if(isset($userContInRAMCAR)){
                    $userContInR = $userContInRAMCAR;
                }else{
                    $userContInR = 0;
                }
                // $userContInOriana = $this->getIntegratedUser("ORIANA",$startDate,$endDate);
                // print_r($userContInOriana);exit;
                // if(isset($userContInOriana)){
                //     $userContInO = $userContInOriana;
                // }else{
                //     $userContInO = 0;
                // }
                // print_r($userContInSiti);exit;
                $result['User_Count'] = $userCountInSiti->Id + intval($userContInR);
                $result['Total_File_Count'] = count($BillingData) + count($MRDTData) + count($permaiMRDT);
                $Transaction_cost = $this->config->item("Transaction_cost");
                $result['Amount'] = $result['Total_File_Count'] * $Transaction_cost." MYR";
            }
            if($result)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $result;
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

    public function getIntegratedUser($cms_name,$startDate,$endDate){
        if($cms_name == "RAMCAR"){
            $url = 'https://apimobile.ring.healthcare:5026/RAMCAR_Dev/index.php/Webservice/getIntegratedUser';
        }else{
            $url = 'https://apimobile.ring.healthcare:5026/ORIANA_Dev/index.php/Webservice/getIntegratedUser';
        }
        $json = '{"start_date":"'.$startDate.'",
            "end_date":"'.$endDate.'"}';   
        $headers = array('Content-Type: application/json');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_HTTPHEADER => $headers,
        ));
        $res = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            echo $error_msg;
        }
        curl_close($curl);
        return  $res;
    }

    public function userLogin()
	{
	if ($this->input->server('REQUEST_METHOD') == 'OPTIONS')
		{
			$data["status"] = "ok";
			echo json_encode($data);
			exit;
		}
	$data = json_decode(file_get_contents('php://input'));
        if($data)
        {
            $userName = $data->userName;
            $password = $data->password;
			if($userName == "Admin" && $password == "12345678")             
			{
                $result = array(
                    "UserId"=> 1,
                    "UserName" => "Admin",
                    "Email" => "administration@gmail.in",
                    "MobileNumber" => "9999999999",
                    "MobileCode" => "+60",
                    "Status" => 1,
                    "IsActive" => 1,
                );
                $kunci = $this->config->item('thekey');
                $token['UserId'] = 1;  
                $token['data'] = $result;
                $date1 = new DateTime();
                $token['iat'] = $date1->getTimestamp();
                $token['exp'] = $date1->getTimestamp() + 60 * 60 * 5; 
                $output['token'] = JWT::encode($token, $kunci);
				$response['response_code']=1;
				$response['response_message']='Success';
				$response['data']=$result;
				$response['token']=$output['token'];
            }else{
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

	public function refresh_access_token(){

		if ($this->input->server('REQUEST_METHOD') == 'OPTIONS')
		{
			$data["status"] = "ok";
			echo json_encode($data);
			exit;
		}

		$headers = apache_request_headers();
	    try{
		$token_str = str_replace("Bearer ", "", $headers['Authorization']);
		$kunci = $this->config->item('thekey');
		$token = JWT::decode($token_str, $kunci);

		$token = json_decode(json_encode($token), true);
		
		$date1 = new DateTime();
		$token['iat'] = $date1->getTimestamp();
		$token['exp'] = $date1->getTimestamp() + 60 *  2000; //To here is to generate token
		$outputData['token'] = JWT::encode($token, $kunci); //This is the output token
		$outputData["user"] = $token['data'];

		$response['response_code']=1;
		$response['response_message']='Success';
		$response['response_data']=$outputData;

		
		}catch(Exception $e){

			$response['response_code']=1;
			$response['response_message']='Failed';
			$response['response_data']="Unautherised Token";
		}
		echo json_encode($response);exit;  
		

	}

    function getFinancialReportInvoiceData()
    {
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $cms_name = isset($data->CMS_Name)?$data->CMS_Name:"";
            $BillingData = $this->WebserviceModel->getFinancialReportInvoiceData($cms_name);
            if($BillingData)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $BillingData;
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

    function createPdfForTransactionInvoice(){

            $filepath = "https://apimobile.ring.healthcare:5026/Ring_dev/";
            $template_name = 'template/invoice_template.html';
            // $template_name = 'template/ring.html';
            $content = file_get_contents($template_name);

            $this->m_pdf->pdf->SetHTMLHeader('<div style="border-bottom:2px solid gray;"><img src="https://apimobile.ring.healthcare:5026/Ring_dev/assets/logo/ring_logo.png" style="width: 200px"></div>
            <h2 class="txt-center"> INVOICE</h2>');
            $this->m_pdf->pdf->SetHTMLFooter('<table class="table-headleft">
            <thead class="bgprimary">
            <tr>
                <th colspan="2" class="txt-center">BANK DETAILS</th>
            </tr>
            </thead>
            <tr>
                <th>Account Nam</th>
                <th>Ring Solutions Sdn Bhd</th>
            </tr>
            <tr>
                <th>Bank Name</th>
                <th>RHB BANK BERHAD</th>
            </tr>
            <tr>
                <th>Bank Branch</th>
                <th>Damansara Utama Branch</th>
            </tr>
            <tr>
                <th>Account No.</th>
                <th>21234900063760</th>
            </tr>
                <tr>
                <th>Swift Code</th>
                <th>RHBBMYKL</th>
            </tr>
            </table>

            <div style="margin:3rem 0">
            <p >Authorized Signature : </p>
            </div>
            <div style="margin:0 0 2rem">
                <p style="margin:0">Abhishek Chakravertty</p>
                <p style="margin:0">Chief Executive Officer</p>
            </div>

            <section class="footer">
            <h4 style="margin:0">RING SOLUTIONS SDN. BHD. <span class="smalltxt">(1440936-D)</span></h4>
            <span class="smalltxt">Referral Integration Network Group</span>
            <p style="margin:0">Unit 08-02, Tower B, The Vertical Business Suites, Jalan Kerinchi, Bangsar South 59200 Kuala Lumpur | Tel.: 03-2241 1192</p>
                
            </section>
            ');
            $this->m_pdf->pdf->AddPage('', '', '', '', '',
            20, // margin_left
            20, // margin right
            25, // margin top
            35, // margin bottom
            5, // margin header
            5); // margin footer
            
            $content = $this->createPdfContentHtml($content);
            $path =  dirname(dirname(__DIR__)).'/pdfDoc/';
            $pdfName = time().rand(1,10).'_invoice_.pdf';
            $this->m_pdf->pdf->WriteHTML($content);
            $this->m_pdf->pdf->Output($path.$pdfName, "F");
            $pdfPath =$filepath.'pdfDoc/'.$pdfName;    
            if($pdfPath)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $pdfPath;
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }
		echo json_encode($response);exit;
        
    }

    public function createPdfContentHtml($content){
        // echo "<pre>"; print_r($dataArray);exit;
        $filepath = "https://apimobile.ring.healthcare:5026/Ring_dev/upload/";    
        $str ='';
        if(isset($pdfInfo) && !empty($pdfInfo)){                     
            // $str .= '<tr><th> Report Details</th>';
            $str .= '<div style="color:black; margin-top:3rem;">'.$pdfInfo.'</div>';
            // $str .= '</tr>';
        }
        $str .= '<h4>TO : </h4>

                    <table class="border-none" style="width:100%;margin-bottom: 2rem;">
                        <tr>
                        <th class="txt-right">Inv No : </th>
                        <td>100</td>
                        </tr>
                        <tr>
                            <th class="txt-right">PO Ref : </th>
                            <td>Lorem Ipsum is</td>
                        </tr>
                        <tr>
                            <th class="txt-right"> Date : </th>
                            <td style="width:200px;">19-09-2024</td>
                        </tr>
                    </table>

                    <table style="width:100%">
                    <thead class="bgprimary">
                    <tr>
                        <th>ITEM NO</th>
                        <th>DESCRIPTION</th> 
                        <th>QTY</th>
                        <th>UNIT</th>
                        <th>RATE MYR</th>
                        <th>AMOUNT MYR</th>
                    </tr>
                    </thead>
                    <tr>
                        <td class="txt-center">01</td>
                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </td>
                        <td class="txt-center">50</td>
                        <td class="txt-center">50</td>
                        <td class="txt-center">1050</td>
                        <td class="txt-center">5550</td>
                    </tr>
                    <tr>
                        <td class="txt-center">02</td>
                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </td>
                        <td class="txt-center">50</td>
                        <td class="txt-center">50</td>
                        <td class="txt-center">1050</td>
                        <td class="txt-center">5550</td>
                    </tr>
                    <tr>
                        <th colspan="5" class="txt-right">TOTAL AMOUNT IN MYR</th>
                        <td></td>
                    </tr>
                    
                    </table>

                    <p>AMOUNT IN WORDS: Ringgit Malaysia </p>
                    '; 
        $content = str_replace(
         array('VAR_ITEM_DATA'),
         array($str),
         $content
      );
      return $content;
    }
}