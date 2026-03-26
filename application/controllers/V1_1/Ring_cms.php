<?php 
date_default_timezone_set('Asia/Kolkata');
class Ring_cms extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model(array('RingCMSModel','WebserviceModel'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');
         require_once APPPATH . 'libraries/EncDecAlgorithm.php';
        $this->load->library('fcm', [
            'serviceAccountKeyFile' => 'ring-ee756-firebase-adminsdk-44fhx-9cb3b06973.json', // Replace with the path to your service account key file
            'projectID' => 'ring-ee756' // Replace with your Firebase project ID
            //'projectID' => 'ring-4c5e3'
        ]);
    }
//*********START: WEBSERVICE FOR LOGIN***********************


    function DoctorDetails(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $firstName = $data->firstName;
            $departmentId = isset($data->departmentId)?$data->departmentId:NULL;     
            $checkData = $this->RingCMSModel->DoctorDetails($firstName,$departmentId);
            // print_r($checkData);exit;
            if($checkData)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $checkData;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function encryptDecrypt1($type,$name){
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
        curl_close($ch); 
        return  $response;
    }

    function GetCMSDoctorDynamicCalendar(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $doctorId = $data->doctorId;
            $department_id = isset($data->department_id)?$data->department_id:NULL;   
            $year = isset($data->year)?$data->year:"NULL";  
            $checkData = $this->RingCMSModel->GetCMSDoctorDynamicCalendar($doctorId,$department_id,$year);
            // print_r($checkData);exit;
            if($checkData)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $checkData;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function AppointmentListForRing(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $Ringid = $data->Ringid;
            // $flag = isset($data->flag)?$data->flag:1;  
            // $Result["Cancelled"] = $this->RingCMSModel->AppointmentListForRing($Ringid,2);
            // if(isset($Result["Cancelled"])){
            //     foreach($Result["Cancelled"] as $canVal){
            //         $canVal->PatFirstname = $this->encryptDecrypt("dc",$canVal->PatFirstname);
            //         $canVal->PatLastname = $this->encryptDecrypt("dc",$canVal->PatLastname);
            //         $canVal->IdentityNo = $this->encryptDecrypt("dc",$canVal->IdentityNo);
            //         $canVal->IdentityNoNRIC = $this->encryptDecrypt("dc",$canVal->IdentityNoNRIC);
            //         $AppointmentDate = strtotime($canVal->AppointmentDate);
            //         $canVal->AppointmentDate = date("Y-m-d", $AppointmentDate);
            //         $StartTime = explode(' ',$canVal->StartTime);
            //         $StartTimenew  = new DateTime($StartTime[1]);
            //         $canVal->StartTime = $StartTimenew->format('h:i A');
            //         $EndTime = explode(' ',$canVal->EndTime);
            //         $EndTimenew  = new DateTime($EndTime[1]);
            //         $canVal->EndTime = $EndTimenew->format('h:i A');
            //     }
            // }
            // $Result["Completed"] = $this->RingCMSModel->AppointmentListForRing($Ringid,1);
            // if(isset($Result["Completed"])){
            //     foreach($Result["Completed"] as $canVal){
            //         $canVal->PatFirstname = $this->encryptDecrypt("dc",$canVal->PatFirstname);
            //         $canVal->PatLastname = $this->encryptDecrypt("dc",$canVal->PatLastname);
            //         $canVal->IdentityNo = $this->encryptDecrypt("dc",$canVal->IdentityNo);
            //         $canVal->IdentityNoNRIC = $this->encryptDecrypt("dc",$canVal->IdentityNoNRIC);
            //         $AppointmentDate = strtotime($canVal->AppointmentDate);
            //         $canVal->AppointmentDate = date("Y-m-d", $AppointmentDate);
            //         $StartTime = explode(' ',$canVal->StartTime);
            //         $StartTimenew  = new DateTime($StartTime[1]);
            //         $canVal->StartTime = $StartTimenew->format('h:i A');
            //         $EndTime = explode(' ',$canVal->EndTime);
            //         $EndTimenew  = new DateTime($EndTime[1]);
            //         $canVal->EndTime = $EndTimenew->format('h:i A');
            //     }
            // }
            $Result["Upcoming"] = $this->RingCMSModel->AppointmentListForRing($Ringid,3);
            if(isset($Result["Upcoming"])){
                foreach($Result["Upcoming"] as $canVal){
                    $canVal->PatFirstname = $this->encryptDecrypt("dc",$canVal->PatFirstname);
                    $canVal->PatLastname = $this->encryptDecrypt("dc",$canVal->PatLastname);
                    $canVal->IdentityNo = $this->encryptDecrypt("dc",$canVal->IdentityNo);
                    $canVal->IdentityNoNRIC = $this->encryptDecrypt("dc",$canVal->IdentityNoNRIC);
                    $AppointmentDate = strtotime($canVal->AppointmentDate);
                    $canVal->AppointmentDate = date("Y-m-d", $AppointmentDate);
                    $StartTime = explode(' ',$canVal->StartTime);
                    $StartTimenew  = new DateTime($StartTime[1]);
                    $canVal->StartTime = $StartTimenew->format('h:i A');
                    $EndTime = explode(' ',$canVal->EndTime);
                    $EndTimenew  = new DateTime($EndTime[1]);
                    $canVal->EndTime = $EndTimenew->format('h:i A');
                    $canVal->SearchStartTime = $StartTimenew->format('H:i');
                }
            }
            // $Result["Missed"] = $this->RingCMSModel->AppointmentListForRing($Ringid,4);
            // if(isset($Result["Missed"])){
            //     foreach($Result["Missed"] as $canVal){
            //         $canVal->PatFirstname = $this->encryptDecrypt("dc",$canVal->PatFirstname);
            //         $canVal->PatLastname = $this->encryptDecrypt("dc",$canVal->PatLastname);
            //         $canVal->IdentityNo = $this->encryptDecrypt("dc",$canVal->IdentityNo);
            //         $canVal->IdentityNoNRIC = $this->encryptDecrypt("dc",$canVal->IdentityNoNRIC);
            //         $AppointmentDate = strtotime($canVal->AppointmentDate);
            //         $canVal->AppointmentDate = date("Y-m-d", $AppointmentDate);
            //         $StartTime = explode(' ',$canVal->StartTime);
            //         $StartTimenew  = new DateTime($StartTime[1]);
            //         $canVal->StartTime = $StartTimenew->format('h:i A');
            //         $EndTime = explode(' ',$canVal->EndTime);
            //         $EndTimenew  = new DateTime($EndTime[1]);
            //         $canVal->EndTime = $EndTimenew->format('h:i A');
            //     }
            // }
            if($Result)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $Result;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function AppointmentListForPastHistory(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $Ringid = $data->Ringid;
            $flag = isset($data->flag)?$data->flag:1;  
            $Result["Cancelled"] = $this->RingCMSModel->AppointmentListForRing($Ringid,2);
            if(isset($Result["Cancelled"])){
                foreach($Result["Cancelled"] as $canVal){
                    $canVal->PatFirstname = $this->encryptDecrypt("dc",$canVal->PatFirstname);
                    $canVal->PatLastname = $this->encryptDecrypt("dc",$canVal->PatLastname);
                    $canVal->IdentityNo = $this->encryptDecrypt("dc",$canVal->IdentityNo);
                    $canVal->IdentityNoNRIC = $this->encryptDecrypt("dc",$canVal->IdentityNoNRIC);
                    $AppointmentDate = strtotime($canVal->AppointmentDate);
                    $canVal->AppointmentDate = date("Y-m-d", $AppointmentDate);
                    $StartTime = explode(' ',$canVal->StartTime);
                    $StartTimenew  = new DateTime($StartTime[1]);
                    $canVal->StartTime = $StartTimenew->format('h:i A');
                    $EndTime = explode(' ',$canVal->EndTime);
                    $EndTimenew  = new DateTime($EndTime[1]);
                    $canVal->EndTime = $EndTimenew->format('h:i A');
                    $canVal->cancelledapt  = 1;
                }
            }
            $Result["Completed"] = $this->RingCMSModel->AppointmentListForRing($Ringid,1);
            if(isset($Result["Completed"])){
                foreach($Result["Completed"] as $canVal){
                    $canVal->PatFirstname = $this->encryptDecrypt("dc",$canVal->PatFirstname);
                    $canVal->PatLastname = $this->encryptDecrypt("dc",$canVal->PatLastname);
                    $canVal->IdentityNo = $this->encryptDecrypt("dc",$canVal->IdentityNo);
                    $canVal->IdentityNoNRIC = $this->encryptDecrypt("dc",$canVal->IdentityNoNRIC);
                    $AppointmentDate = strtotime($canVal->AppointmentDate);
                    $canVal->AppointmentDate = date("Y-m-d", $AppointmentDate);
                    $StartTime = explode(' ',$canVal->StartTime);
                    $StartTimenew  = new DateTime($StartTime[1]);
                    $canVal->StartTime = $StartTimenew->format('h:i A');
                    $EndTime = explode(' ',$canVal->EndTime);
                    $EndTimenew  = new DateTime($EndTime[1]);
                    $canVal->EndTime = $EndTimenew->format('h:i A');
                    $canVal->cancelledapt  = 0;
                }
            }
            
            if($Result)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $Result;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function InsertAppointmentDetails(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $patientid = $data->patientid;
            $location_id = $data->location_id;
            $doctor_id = $data->doctor_id;
            $department_id = $data->department_id;
            $appointment_date = $data->appointment_date;
            $from_time = $data->from_time;
            $to_time = $data->to_time;
            if(isset($data->firstname) && !empty($data->firstname)){
                $firstname = $this->encryptDecrypt("en",$data->firstname);
            }else{
                $firstname = "NULL";
            }
            if(isset($data->lastname) && !empty($data->lastname)){
                $lastname = $this->encryptDecrypt("en",$data->lastname);
            }else{
                $lastname = "NULL";
            }
            $gender = $data->gender;
            $dob = $data->dob;
            if(isset($dob) && !empty($dob)){
                $ts = strtotime($dob);
                $dob1 = date("Y-m-d", $ts);
            }else{
                $dob1 = NULL;
            }
            $bloodgroup = isset($data->bloodgroup)?$data->bloodgroup:1;
            if(isset($data->email) && !empty($data->email)){
                $email = $this->encryptDecrypt("en",$data->email);
            }else{
                $email = "NULL";
            }
            $country_id = isset($data->country_id)?$data->country_id:0;
            $state_id = isset($data->state_id)?$data->state_id:0;
            $city_id = isset($data->city_id)?$data->city_id:0;
            $address = isset($data->address)?$data->address:"NULL";
            $pin_code = isset($data->pin_code)?$data->pin_code:"NULL";
            $mob_code = isset($data->mob_code)?$data->mob_code:"NULL";
            $bloodgrouptype = isset($data->bloodgrouptype)?$data->bloodgrouptype:"NULL";
            $isMainPatientID = $data->isMainPatientID;
            if(isset($data->mobile_number) && !empty($data->mobile_number)){
                $mobile_number = $this->encryptDecrypt("en",$data->mobile_number);
            }else{
                $mobile_number = "NULL";
            }
            $appointment_reason_id = $data->appointment_reason_id;
            $remark = $data->remark;
            $IdentificationTypeId = $data->IdentificationTypeId;
            if(isset($data->IdentityNo) && !empty($data->IdentityNo)){
                $IdentityNo = $this->encryptDecrypt("en",$data->IdentityNo);
            }else{
                $IdentityNo = "NULL";
            }
            $Apptype = isset($data->appointmentType)?$data->appointmentType:2;
            $BookAppointment = $this->RingCMSModel->InsertAppointmentDetails($patientid,$location_id,$doctor_id,$department_id,$appointment_date,$from_time,$to_time,$firstname,$lastname,$gender,$dob1,$bloodgroup,$email,$country_id,$state_id,$city_id,$address,$pin_code,$mob_code,$bloodgrouptype,$isMainPatientID,$mobile_number,$appointment_reason_id,$remark,$IdentificationTypeId,$IdentityNo,$Apptype);
            // print_r($BookAppointment);exit;
            if($BookAppointment)
            {
                // $appPaymentId = $this->RingCMSModel->getAppPaymentId($patientid);
                // $updateArray = array(         
                //     "AppointmentId"=>$BookAppointment->AppointmentId                              
                // );
                // $result = $this->RingCMSModel->updateAppointmentPaymentData($updateArray,$patientid,$appPaymentId);
                // $userName = $firstname;
                // $formattedDate = date("F d Y", strtotime($appointment_date));
                // $formattedTime = date("h:i A", strtotime($from_time));
                // $doctordatails = $this->WebserviceModel->getDoctorsDetails($doctor_id);
                // $doctorName = isset($doctordatails->DisplayName)?$doctordatails->DisplayName:Null;
                // $tenantdatails = $this->WebserviceModel->getTenantsDetails($location_id);
                // $locationName = isset($tenantdatails->TenantName)?$tenantdatails->TenantName:Null;
                // $type = "AppointmentBookWithPayment";
                // $dataArr = array("userName"=>$userName, "appointmentDate"=>$formattedDate, "appointmentTime"=>$formattedTime, "doctorName"=>$doctorName, "locationName"=>$locationName);
                // Utility::callSendMailWithTemplate($email,$type,$dataArr);
                $token = bin2hex(random_bytes(5));
                $lastQueData = $this->RingCMSModel->getLastQueOfDoctor($doctor_id,$appointment_date);
                if(isset($lastQueData) && !empty($lastQueData)){
                    $lastQueNumber = $lastQueData->TodaySerialNumber + 1;
                }else{
                    $lastQueNumber = 1;
                }
                $queDataArr = array("AppointmentId"=>$BookAppointment->AppointmentId,
                    "PatientId"=>$patientid,
                    "Token"=>$token,
                    "TodaySerialNumber"=>$lastQueNumber,
                    "AppointmentDate"=>$appointment_date,
                    "DoctorId"=>$doctor_id
                );
                $insertQue = $this->RingCMSModel->InsertQuetoken($queDataArr);

                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $BookAppointment;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function InsertAppointmentDetailsWithPayment(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {

            $patientid = $data->patientid;
            $location_id = $data->location_id;
            $doctor_id = $data->doctor_id;
            $department_id = $data->department_id;
            $appointment_date = $data->appointment_date;
            $from_time = $data->from_time;
            $to_time = $data->to_time;
            if(isset($data->firstname) && !empty($data->firstname)){
                $firstname = $this->encryptDecrypt("en",$data->firstname);
            }else{
                $firstname = "NULL";
            }
            if(isset($data->lastname) && !empty($data->lastname)){
                $lastname = $this->encryptDecrypt("en",$data->lastname);
            }else{
                $lastname = "NULL";
            }
            $gender = $data->gender;
            $dob = $data->dob;
            if(isset($dob) && !empty($dob)){
                $ts = strtotime($dob);
                $dob1 = date("Y-m-d", $ts);
            }else{
                $dob1 = NULL;
            }
            $bloodgroup = isset($data->bloodgroup)?$data->bloodgroup:1;
            if(isset($data->email) && !empty($data->email)){
                $email = $this->encryptDecrypt("en",$data->email);
            }else{
                $email = "NULL";
            }
            $country_id = isset($data->country_id)?$data->country_id:0;
            $state_id = isset($data->state_id)?$data->state_id:0;
            $city_id = isset($data->city_id)?$data->city_id:0;
            $address = isset($data->address)?$data->address:"NULL";
            $pin_code = isset($data->pin_code)?$data->pin_code:0;
            $mob_code = isset($data->mob_code)?$data->mob_code:"NULL";
            $bloodgrouptype = isset($data->bloodgrouptype)?$data->bloodgrouptype:"NULL";
            $isMainPatientID = $data->isMainPatientID;
            if(isset($data->mobile_number) && !empty($data->mobile_number)){
                $mobile_number = $this->encryptDecrypt("en",$data->mobile_number);
            }else{
                $mobile_number = "NULL";
            }
            $appointment_reason_id = $data->appointment_reason_id;
            $remark = $data->remark;
            $IdentificationTypeId = $data->IdentificationTypeId;
            if(isset($data->IdentityNo) && !empty($data->IdentityNo)){
                $IdentityNo = $this->encryptDecrypt("en",$data->IdentityNo);
            }else{
                $IdentityNo = "NULL";
            }
            $Apptype = isset($data->appointmentType)?$data->appointmentType:2;
            $BookAppointment = $this->RingCMSModel->InsertAppointmentDetails($patientid,$location_id,$doctor_id,$department_id,$appointment_date,$from_time,$to_time,$firstname,$lastname,$gender,$dob1,$bloodgroup,$email,$country_id,$state_id,$city_id,$address,$pin_code,$mob_code,$bloodgrouptype,$isMainPatientID,$mobile_number,$appointment_reason_id,$remark,$IdentificationTypeId,$IdentityNo,$Apptype);
            // print_r($BookAppointment);exit;
            if($BookAppointment)
            {
                if($data->appointmentType == 2){
                    $appPaymentId = $this->RingCMSModel->getAppPaymentId($patientid);
                    //print_r($appPaymentId);exit;
                    $updateArray = array(         
                        "AppointmentId"=>$BookAppointment->AppointmentId                              
                    );
                    $result = $this->RingCMSModel->updateAppointmentPaymentData($updateArray,$patientid,$appPaymentId->Id);
                }
                $userName = $firstname;
                $formattedDate = date("F d Y", strtotime($appointment_date));
                $formattedTime = date("h:i A", strtotime($from_time));
                $doctordatails = $this->RingCMSModel->getDoctorsDetails($doctor_id);
                $doctorName = $doctordatails->Title." ".$doctordatails->firstName." ".$doctordatails->LastName;
                // $doctorName = isset($doctordatails->DisplayName)?$doctordatails->DisplayName:Null;
                $tenantdatails = $this->WebserviceModel->getTenantsDetails($location_id);
                $locationName = isset($tenantdatails->TenantName)?$tenantdatails->TenantName:Null;
                $type = "AppointmentBookWithPayment";
                $dataArr = array("userName"=>$data->firstname, "appointmentDate"=>$formattedDate, "appointmentTime"=>$formattedTime, "doctorName"=>$doctorName, "locationName"=>$locationName);
                Utility::callSendMailWithTemplate($data->email,$type,$dataArr);

                $token = bin2hex(random_bytes(5));
                $lastQueData = $this->RingCMSModel->getLastQueOfDoctor($doctor_id,$appointment_date);
                if(isset($lastQueData) && !empty($lastQueData)){
                    $lastQueNumber = $lastQueData->TodaySerialNumber + 1;
                }else{
                    $lastQueNumber = 1;
                }
                $queDataArr = array("AppointmentId"=>$BookAppointment->AppointmentId,
                    "PatientId"=>$patientid,
                    "Token"=>$token,
                    "TodaySerialNumber"=>$lastQueNumber,
                    "AppointmentDate"=>$appointment_date,
                    "DoctorId"=>$doctor_id
                );
                $insertQue = $this->RingCMSModel->InsertQuetoken($queDataArr);
                
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $BookAppointment;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    public function getDoctorForHospitalsearchPage(){
        $data = json_decode(file_get_contents('php://input'));       
        if($data)
        {
            $todayDate = date("Y-m-d");
            $weekArr = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
			$specialityId = $data->specialityId;
            $searchDate = isset($data->searchDate)?$data->searchDate:$todayDate;
            $timestamp = strtotime($searchDate);
            $dayId = date('N', $timestamp);
            $week_day = $weekArr[$dayId];
            // print_r($week_day);exit;
            if($specialityId){
                $userData = $this->RingCMSModel->getDoctorFromTenant($specialityId,$dayId);
            }else{
                $userData = $this->RingCMSModel->getDoctorFromTenantForUniversal($dayId);
            }
                       
            if($userData){
                foreach($userData as $userDataArr){
                    // print_r($userDataArr);
                    // if($userDataArr->SecondarySpecialityId){
                    //    $secondData = $this->RingCMSModel->getDoctorFromTenantSec($userDataArr->DoctorId,$userDataArr->SecondarySpecialityId); 						
                    //    array_push($userData,$secondData);
                    // }
                    //$impData = $this->db->select('*')->from('DoctorImplementation')->where('RingDoctorId',$userDataArr->DoctorId)->get()->row();
                    //if($impData){
                        $userDataArr->Appointment = "enable";
                        // $userDataArr->impData = $impData;
                        // $userDataArr->Scheduled = $impData->Scheduled;
                    // }else{
                    //     $userDataArr->Appointment = "disable";
                    //     $userDataArr->Scheduled = 0;
                    // } 
                    $userDataArr->DoctorName = trim($userDataArr->DoctorName);
                }
            }
            // exit;
            // $tenantDetails = $this->WebserviceModel->getTenantsDetails($tenantId);
            // $workingArr = $this->WebserviceModel->getWorkingScheduleOfTenant($tenantId);
            // // print_r($workingArr);exit;
            // $workHrArr = array();
            //     foreach($workingArr as $workHrVal){
            //         $workHrVal->FromTime = date("h:i A", strtotime($workHrVal->FromTime));
			// 		$workHrVal->ToTime = date("h:i A", strtotime($workHrVal->ToTime));
			// 		array_push($workHrArr,$workHrVal);
			// 	}
            //     if(isset($workHrArr) && !empty($workHrArr)){
            //         $workingHTML = '<div class="f14 txtlist">';
            //         foreach($workHrArr as $workHrArrVal)
            //         {
            //             $workingHTML .= '<ion-col size="12" class="f14 txtlist">
            //                             <span class="fw600" translate> '.$workHrArrVal->DayName.' : </span>  '.$workHrArrVal->FromTime.' - '.$workHrArrVal->ToTime.'<br>
            //                         </ion-col>';
            //         }
            //         $workingHTML .= '</div>';
            //     }else{
            //         $workingHTML = '';            
            //     }
            if($userData)
            {

                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $userData;
                // if($tenantDetails){
                //     $response['Tenant_data'] = $tenantDetails;
                // }
                // $response['working_data'] = $workingHTML;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }
    
    function RescheduleAppointment(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $appointmentid = $data->appointmentid;
            $appointmentdate = $data->appointmentdate;
            $fromtime = $data->fromtime;
            $totime = $data->totime;
            $remarks = isset($data->remarks)?$data->remarks:"NULL";   
            $appointmentreason = isset($data->appointmentreason)?$data->appointmentreason:"NULL";  
            $userData = $this->RingCMSModel->UserDataByAppointmentId($appointmentid);
            if(isset($userData)){
                $userData->emailid = $this->encryptDecrypt("dc",$userData->Email);
                $userData->firstname = $this->encryptDecrypt("dc",$userData->firstname);
                if($userData->emailid){
                    $type = "AppointmentRescheduleApp";
                    $dataArr = array("userName"=>$userData->firstname, "appointmentDate"=>$userData->appointmentDate, "appointmentTime"=>$userData->appointmentTime, "newAppointmentDate"=>$appointmentdate, "newAppointmentTime"=>$fromtime, "doctorName"=>$userData->DoctorFName.' '.$userData->DoctorLName,  "locationName"=>$userData->locName, "locationAddress"=>$userData->locationAddress);
                    $sendRescheduleMail = Utility::callSendMailWithTemplate($userData->emailid,$type,$dataArr);					
                }
            }
            $reschedule = $this->RingCMSModel->RescheduleAppointment($appointmentid,$appointmentdate,$fromtime,$totime,$remarks,$appointmentreason);
            // print_r($reschedule);exit;
            if(true)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                // $response['response_data'] = $reschedule;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function CancelAppointment(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $appointmentid = $data->id; 
            $appcancelreason = isset($data->appcancelreason)?$data->appcancelreason:"cancel";  
            $cancel = $this->RingCMSModel->CancelAppointment($appointmentid,$appcancelreason);
            if(true)
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function TimeSlotList(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $weekArr = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
            $location_id = $data->location_id; 
            $doctor_id = $data->doctor_id;
            $appointment_date = $data->appointment_date;
            $appointmentDate = $appointment_date;
            $bookedTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Booked");
            $scheduleTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Schedule");
            //echo "<pre>"; print_r($bookedTimeForDoc);print_r($scheduleTimeForDoc);exit;
            if($scheduleTimeForDoc){
                $appointDate =  $appointment_date.' 00:00:00';
                $timestamp = strtotime($appointDate);
                $day = date('N', $timestamp);
                $timeSlotArr = [];
                foreach ($scheduleTimeForDoc as $key => $value) {

                    $appointmentDuration = $this->RingCMSModel->getAppointmentDuration($value->UserId);
                    if($appointmentDuration){
                        $durationInt = explode(" ",$appointmentDuration->Duration);
                        $slotduration = $durationInt[0];
                    }else{
                        $slotduration = 15;
                    }
                    // print_r($value);exit;
                    if($value->DayMasterId == $day)
                    {
                        $day_in_week = $value;
                        $starttime = explode(' ',$value->FromTime);
                        $endtime = explode(' ',$value->ToTime);
                        $dayid = $value->DayMasterId;
                        $week_day = $weekArr[$dayid];
                        $timeSlotArr['starttime'] = $starttime[1];
                        $timeSlotArr['endtime'] = $endtime[1];
                        $timeSlotArr['slotduration'] = $slotduration;
                        $timeSlotArr['dayid'] = $dayid;
                        $timeSlotArr['week_day'] = $week_day;

                    }			
                }
                // print_r($timeSlotArr);exit;
                $startTime  = new DateTime($timeSlotArr['starttime']);
                $endTime    = new DateTime($timeSlotArr['endtime']);
                $timeStep   = $timeSlotArr['slotduration'];
                
                $timeArray  = array();
                $currentDateTime = date('H:i:s');
                $currentDate = date('Y-m-d');
                $st = new DateTime($timeSlotArr['starttime']);
                // print_r($startTime);exit;
//$diff=date_diff($startTime->format('H:i:s'),$endTime->format('H:i:s')); 
//print_r($startTime->format('H:i:s'));exit;

 $i= 0 ;

                while((($startTime->diff($endTime)->h * 60) + $startTime->diff($endTime)->i)>$timeStep)
                {
                    $st1 = $st;
                    $end = $st->add(new DateInterval('PT'.$timeStep.'M'));
                    //  print_r($appointmentDate);exit;
                   
                    if($currentDate == $appointmentDate)
                    {
                        // echo 1;exit;
                        
                        $mflag=0;
                        foreach ($bookedTimeForDoc as $value) {
                            $AppFromT = explode(' ',$value->AppFromTime);
                            $AppFromTime  = new DateTime($AppFromT[1]);

                            $AppToT = explode(' ',$value->AppToTime);
                            $AppToTime  = new DateTime($AppToT[1]);
                            $mflag=1;
                            //print_r($startTime->format('H:i:s'));exit;
                            if(($AppFromTime->format('H:i:s') == $startTime->format('H:i:s')) && ($AppToTime->format('H:i:s') == $end->format('H:i:s')))
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                            }
                            else
                            {
                                if($currentDateTime >= $startTime->format('H:i:s'))
                                {
                                    $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                                }
                                else
                                {
                                    $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;
                                }
                            }

                        }
                        if($mflag==0){
                            if($currentDateTime >= $startTime->format('H:i:s'))
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');
                            }
                            else
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');
                            }
                        }

                    }
                    else
                    {
                        // echo 2;exit;
                        $qflag=0;
                        foreach ($bookedTimeForDoc as $key => $value) {
                            $AppFromT = explode(' ',$value->AppFromTime);
                            $AppFromTime  = new DateTime($AppFromT[1]);

                            $AppToT = explode(' ',$value->AppToTime);
                            $AppToTime  = new DateTime($AppToT[1]);
                            $qflag=1;
                            if($AppFromTime->format('H:i:s') == $startTime->format('H:i:s') && $AppToTime->format('H:i:s') == $end->format('H:i:s'))
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                            }
                            else
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;				
                            }

                        }
                        if($qflag==0){
                            // if($currentDateTime >= $end->format('H:i:s'))
                            // {
                            //     $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');
                            // }
                            // else
                            // {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');
                            // }
                        }
                    }
                    
                    $st = $end;
                   $startTime->add(new DateInterval('PT'.$timeStep.'M')); 
                   $i++;
                   
                //    echo $startTime->format('H:i') ."<=". $endTime->format('H:i') ;
                //    echo " --- ".$startTime->format('H:i') <= $endTime->format('H:i') ; echo "<br >";
                //   // print_r( $startTime);
                //   $interval = $startTime->diff($endTime);
                //   echo "<br />";
                //   print_r($startTime->diff($endTime));
                //   echo "<br />";
                //  echo "--------------interval-". (($startTime->diff($endTime)->h * 60) + $startTime->diff($endTime)->i) ;
                
                //    if($i==100) exit ;
                    
                }
                // print_r($timeArray);exit;
                if($timeArray)
                {
                    $response['response_code'] = '1';
                    $response['response_message'] = 'Success';
                    $response['response_data'] = $timeArray;
                }
                else
                {
                    $response['response_code'] = '2';
                    $response['response_message'] = 'Failed';
                }
            }
            else
            {
                $response['response_code'] = '4';
                $response['response_message'] = 'Doctor schedule not found';
            }    
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function getConfirmStatus(){
		$data = json_decode(file_get_contents('php://input'));
		if($data)
		{
			$appointmentId = $data->appointmentId;
			$getData = $this->RingCMSModel->getConfirmStatus($appointmentId);
			if($getData){
				$response['response_code']=1;
				$response['response_message']='Success';
				$response['response_data']=$getData;
			}else{
				$response['response_code']=2;
				$response['response_message']='Failed';
			}
			
		}
		else
		{
			$response['response_code'] = '3';
			$response['response_message'] = 'Data is Null';
		}	
		echo json_encode($response);exit;   
	}

    public function GetCMSCurrentDateTime()
    {
		$data = json_decode(file_get_contents('php://input'));
		if($data)
		{
            date_default_timezone_set("asia/Kuala_Lumpur");
			$Id = $data->appointmentId;
			$AppointData = $this->RingCMSModel->appointmentDataById($Id);
			$result['AppointmentData'] = $AppointData;
			$todayDate = date("Y-m-d");
			$currentDateTime = date("Y-m-d h:i:s");
			// $appDate = $AppointData->AppointmentDate;
            $appD = explode(' ',$AppointData->AppointmentDate);
            $appDate = $appD[0];
			$AppFromT = explode(' ',$AppointData->FromTime);
            $appStartTime  = $AppFromT[1];
            // print_r($appDate);exit;
			$AppToT = explode(' ',$AppointData->ToTime);
            $AppToTime  = new DateTime($AppToT[1]);
			if($appDate == $todayDate){
				$appStartTime1 = strtotime($appStartTime);
				$currentTime = time();
				$diff =  $currentTime - $appStartTime1;
				$diffInMin = $diff/60;
				// print_r($diffInMin);exit;
				if($diffInMin >= 0 && $diffInMin <= 15){
					$result['VideoCallAvl'] = "Enable";
				}else{
					$result['VideoCallAvl'] = "Disable";
				}
				if($diffInMin < 0){
					$diffRev =  $appStartTime1 - $currentTime;
					$diffInMinPos = $diffRev/60;
					$hours = intdiv((int)$diffInMinPos, 60).':'. ((int)$diffInMinPos % 60);
					$result['CallStartRemainingTime'] = $hours;
					$result['CallSession'] = "Not Started";
				}else if($diffInMin > 15){
					$hours = intdiv((int)$diffInMin, 60).':'. ((int)$diffInMin % 60);
					$result['CallEndTime'] = $hours;
					$result['CallSession'] = "Expired";
				}else if($diffInMin >= 0 && $diffInMin <= 15){
					$hours = intdiv((int)$diffInMin, 60).':'. ((int)$diffInMin % 60);
					$result['CallEndIn'] = $hours;
					$result['CallSession'] = "Live";
				}
			}else{
				$result['VideoCallAvl'] = "Disable";
				$result['CallSession'] = "Not Started";
			}
			//print_r($appDate);exit;
			//$currentDate = date("D M d Y H:i:s \G\M\T O");
			if($result){
				$response['response_code'] = '1';
				$response['response_message'] = 'Success';
				$response['data'] = $result;
			}else{				
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

    public function getRescheduleStatus(){
		$data = json_decode(file_get_contents('php://input'));
		if($data)
		{
            date_default_timezone_set("asia/Kuala_Lumpur");
			$Id = $data->appointmentId;
			$AppointData = $this->RingCMSModel->appointmentDataById($Id);
			$result['AppointmentData'] = $AppointData;
			$todayDate = date("Y-m-d");
			$currentDateTime = date("Y-m-d h:i:s");
			// $appDate = $AppointData->AppointmentDate;
            $appD = explode(' ',$AppointData->AppointmentDate);
            $appDate = $appD[0];
			$AppFromT = explode(' ',$AppointData->FromTime);
            $appStartTime  = $AppFromT[1];
            // print_r($appStartTime);exit;
			$AppToT = explode(' ',$AppointData->ToTime);
            $AppToTime  = new DateTime($AppToT[1]);
			if($appDate == $todayDate){
				$appStartTime1 = strtotime($appStartTime);
				$currentTime = time();
				$diff =  $currentTime - $appStartTime1;
				$diffInMin = $diff/60;
				// print_r($diffInMin);exit;
				if($diffInMin >= -120){
					$response['response_code'] = '4';
					$response['response_message'] = 'less than 2 hours';
					$response['response_data'] = $result;
				}else{
					if(isset($AppointData->RescheduledCount) && ($AppointData->RescheduledCount >= 2)){
						$response['response_code'] = '5';
						$response['response_message'] = 'reach max count';
						$response['response_data'] = $result;
					}else{
						$response['response_code'] = '1';
						$response['response_message'] = 'success';
						$response['response_data'] = $result;
					}
				}
				
			}else if($appDate > $todayDate){
				if(isset($AppointData->RescheduledCount) && ($AppointData->RescheduledCount >= 2)){
					$response['response_code'] = '5';
					$response['response_message'] = 'reach max count';
					$response['response_data'] = $result;
				}else{
					$response['response_code'] = '1';
					$response['response_message'] = 'success';
					$response['response_data'] = $result;
				}
			}
		}
		else
		{
			$response['response_code'] = '3';
			$response['response_message'] = 'Data is null';
		}
		echo json_encode($response);exit;        
    }

    function getDoctorDetailsAndMore(){        
        $data = json_decode(file_get_contents('php://input'));       
        if($data)
        {
            $doctor_id = $data->doctorId;
            $enrollment_Id = $data->enrollment_Id;
            $appointmentDetails = $this->RingCMSModel->getEnrollmentDetails($enrollment_Id);
            if($appointmentDetails){
                $appointmentDetails->FullName = $this->encryptDecrypt("dc",$appointmentDetails->FullName);
                $appointmentDetails->LastName = $this->encryptDecrypt("dc",$appointmentDetails->LastName);
                $appD = explode(' ',$appointmentDetails->AppointmentDate);
                $appointmentDetails->AppointmentDate = $appD[0];
                $AppFromT = explode(' ',$appointmentDetails->FromTime);
                $appointmentDetails->FromTime  = $AppFromT[1];
                // print_r($appStartTime);exit;
                $AppToT = explode(' ',$appointmentDetails->ToTime);
                $appointmentDetails->ToTime  = $AppToT[1];
            }
            $userData = $this->RingCMSModel->getDoctorsDetails($doctor_id);
            // $userData->tenants = $this->RingCMSModel->getDoctorsTenants($userData->UserId);
            $result['DoctorDetails'] = $userData;
            $result['AppointmentDetails'] = $appointmentDetails;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    public function GetPatientDocs1(){
        $data = json_decode(file_get_contents('php://input'));       
        if($data)
        {
            $patientId = $data->patientId;
            //$url = 'https://internal.ring.healthcare/GetPatientDocs?PatietnId=' . $patientId;
            // $json = json_encode($arrayToSend);           
            // $headers = array('Content-Type: application/json');
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // //curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"GET");
            // // curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            // curl_setopt($ch, CURLOPT_HTTPGET, 1);
            // //curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);            
            // $response = curl_exec($ch);         
            // curl_close($ch); 
            // echo $response;exit;
            // $res = json_decode($response,TRUE);
            // print_r($url);exit;

            $ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => 'https://internal.ring.healthcare/GetPatientDocs?Patientid=' . $patientId,
				CURLOPT_POST => 1,
                CURLOPT_RETURNTRANSFER => 1
			));
			// curl_exec($ch);

			$result = curl_exec($ch);
            //echo $result;exit;
            if($result){
                $cleanedResponse = str_replace(["\r\n"], '', $result);
                $responseArray = json_decode($cleanedResponse, true);
                print_r($responseArray);exit;
                if (json_last_error() === JSON_ERROR_NONE) {
                    $responseDataArray = $responseArray['response_data'];
                    
                } else {
                    echo "JSON decoding error: " . json_last_error_msg();
                }
                curl_close($ch);
            }else{
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }
            //echo $result;
            if ($errno = curl_errno($ch)) {
                $error_message = curl_strerror($errno);
                $error_message1 = "cURL error ({$errno}):\n {$error_message}";
                $response['response_code'] = '2';
                $response['response_message'] = $error_message1;
            }
            

        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    public function GetPatientDocs(){
        $data = json_decode(file_get_contents('php://input'));       
        if($data)
        {
            $patientId = $data->patientId;
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://internal.ring.healthcare:8443/GetPatientDocs?Patientid='.$patientId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $result = curl_exec($curl);
            $responseArray = json_decode($result, true);
            curl_close($curl);
            if($responseArray){
                foreach($responseArray as &$responseVal) { // Pass by reference
                    $workHrArr = $responseVal["WorkingSchedule"] ?? [];
                
                    if (!empty($workHrArr)) {
                        $workingHTML = '<div class="f14 txtlist">';
                        $workingHTMLinMalay = '<div class="f14 txtlist">';
                
                        foreach ($workHrArr as $workHrArrVal) {
                            $day = htmlspecialchars($workHrArrVal['Day'], ENT_QUOTES, 'UTF-8');
                            $time = htmlspecialchars($workHrArrVal['Time'], ENT_QUOTES, 'UTF-8');
                
                            $workingHTML .= '<ion-col size="12" class="f14 txtlist">
                                                <span class="fw600" translate>' . $day . ' : </span>  ' . $time . '<br>
                                             </ion-col>';
                            $workingHTMLinMalay .= '<ion-col size="12" class="f14 txtlist">
                                                <span class="fw600" translate>' . $day . ' : </span>  ' . $time . '<br>
                                             </ion-col>';
                        }
                
                        $workingHTML .= '</div>';
                        $workingHTMLinMalay .= '</div>';
                    } else {
                        $workingHTML = '<p class="f14 txtlist">
                                            <ion-col size="12" class="f14 txtlist">
                                                <span class="fw600" translate> From Time :</span> N/A<br>
                                            </ion-col>
                                            <ion-col size="12" class="f14 txtlist">
                                                <span class="fw600" translate> To Time :</span> N/A
                                            </ion-col>
                                        </p>';
                        $workingHTMLinMalay = '<p class="f14 txtlist">
                                            <ion-col size="12" class="f14 txtlist">
                                                <span class="fw600" translate> Dari jam :</span> N/A<br>
                                            </ion-col>
                                            <ion-col size="12" class="f14 txtlist">
                                                <span class="fw600" translate> Hingga jam :</span> N/A
                                            </ion-col>
                                        </p>';                
                    }
                
                    // Store the updated values back in the array
                    $responseVal['workingHTML'] = $workingHTML;
                    $responseVal['workingHTMLinMalay'] = $workingHTMLinMalay;
                }
                
                // Unset reference to avoid accidental modifications
                unset($responseVal);
                
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $responseArray;
            }else{
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function TimeSlotList123456(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $weekArr = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
            $location_id = $data->location_id; 
            $doctor_id = $data->doctor_id;
            $appointment_date = $data->appointment_date;
            $appointDate =  $appointment_date.' 00:00:00';
            $appointmentDate = $appointment_date;
            $bookedTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Booked");
            $scheduleTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Schedule");
            // echo "<pre>"; print_r($bookedTimeForDoc);print_r($scheduleTimeForDoc);exit;

            $doctorLeave = $this->RingCMSModel->getDoctorLeave($doctor_id,$appointDate,$location_id);
            
            if($scheduleTimeForDoc){
                $appointDate =  $appointment_date.' 00:00:00';
                $timestamp = strtotime($appointDate);
                $day = date('N', $timestamp);
                $timeSlotArr = [];
                foreach ($scheduleTimeForDoc as $key => $value) {
                    $appointmentDuration = $this->RingCMSModel->getAppointmentDuration($value->UserId);
                    if($appointmentDuration){
                        $durationInt = explode(" ",$appointmentDuration->Duration);
                        $slotduration = $durationInt[0];
                    }else{
                        $slotduration = 15;
                    }
                    
                    //print_r($slotduration);exit;
                    if($value->DayMasterId == $day)
                    {
                        $day_in_week = $value;
                        $starttime = explode(' ',$value->FromTime);
                        $endtime = explode(' ',$value->ToTime);
                        $dayid = $value->DayMasterId;
                        $week_day = $weekArr[$dayid];
                        $timeSlotArr['starttime'] = $starttime[1];
                        $timeSlotArr['endtime'] = $endtime[1];
                        $timeSlotArr['slotduration'] = $slotduration;
                        $timeSlotArr['dayid'] = $dayid;
                        $timeSlotArr['week_day'] = $week_day;

                    }			
                }
                // print_r($timeSlotArr);exit;
                $startTime  = new DateTime($timeSlotArr['starttime']);
                $endTime    = new DateTime($timeSlotArr['endtime']);
                $timeStep   = $timeSlotArr['slotduration'];
                $timeArray  = array();
                $currentDateTime = date('H:i:s');
                $currentDate = date('Y-m-d');
                $st = new DateTime($timeSlotArr['starttime']);
                // print_r($st);
                if(isset($doctorLeave) && !empty($doctorLeave)){
                    if($doctorLeave->LeaveTypeId == 1){
                        $docLeaveST = $startTime->format('H:i:s');
                        $docLeaveET = $endTime->format('H:i:s');
                        $DocLvstartTime = strtotime($docLeaveST);
                        $DocLvendTime = strtotime($docLeaveET);  
                        $interval = $slotduration * 60; 
                        $timeChunks = [];

                        while ($DocLvstartTime < $DocLvendTime) {
                            $nextTime = $DocLvstartTime + $interval; 
                            
                            $timeSlot = new stdClass();
                            $timeSlot->appStartTime = date("H:i:s", $DocLvstartTime);
                            $timeSlot->appEndTime = date("H:i:s", $nextTime);

                            $timeChunks[] = $timeSlot;

                            $DocLvstartTime = $nextTime; 
                        }
                    }
                    else{
                        $doctorLeaveSt = explode(' ',$doctorLeave->StartTime);
                        $doctorLeaveEt = explode(' ',$doctorLeave->EndTime);
                        $DstartTime  = new DateTime($doctorLeaveSt[1]);
                        $DendTime    = new DateTime($doctorLeaveEt[1]);
                        $docLeaveST = $DstartTime->format('H:i:s');
                        $docLeaveET = $DendTime->format('H:i:s');
                        $DocLvstartTime = strtotime($docLeaveST);
                        $DocLvendTime = strtotime($docLeaveET);  
                        $interval = $slotduration * 60; 
                        $timeChunks = [];

                        while ($DocLvstartTime < $DocLvendTime) {
                            $nextTime = $DocLvstartTime + $interval; 
                            
                            $timeSlot = new stdClass();
                            $timeSlot->appStartTime = date("H:i:s", $DocLvstartTime);
                            $timeSlot->appEndTime = date("H:i:s", $nextTime);

                            $timeChunks[] = $timeSlot;

                            $DocLvstartTime = $nextTime; 
                        }
                    }
                    
                        // Print the output
                        // print_r($timeChunks);exit;
                }
                while($startTime->format('H:i') <= $endTime->format('H:i'))
                {
                    $st1 = $st;
                    $end = $st1->add(new DateInterval('PT'.$timeStep.'M'));
                    // print_r($end);exit;
                    if(isset($doctorLeave) && !empty($doctorLeave)){
                        if($doctorLeave->LeaveTypeId == 1){
                            $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');  
                        }else{
                            foreach ($timeChunks as $key => $value) {
                            if($value->appStartTime == $startTime->format('H:i:s') && $value->appEndTime == $end->format('H:i:s'))
                                {
                                    $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                                }
                                else
                                {
                                    $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;
                                }
                            }
                        }                     
                    }
                    else if($currentDate == $appointmentDate)
                    {
                        // echo 1;exit;
                        $mflag=0;
                        foreach ($bookedTimeForDoc as $value) {
                            $AppFromT = explode(' ',$value->AppFromTime);
                            $AppFromTime  = new DateTime($AppFromT[1]);

                            $AppToT = explode(' ',$value->AppToTime);
                            $AppToTime  = new DateTime($AppToT[1]);
                            $mflag=1;
                            // print_r($end->format('H:i:s'));exit;
                            if(($AppFromTime->format('H:i:s') == $startTime->format('H:i:s')) && ($AppToTime->format('H:i:s') == $end->format('H:i:s')))
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                                
                            }
                            else
                            {
                                if($currentDateTime >= $startTime->format('H:i:s'))
                                {
                                    $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                                }
                                else
                                {
                                    $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;
                                }
                            }
                            
                        }
                        // if($timeChunks){
                        //     foreach ($timeChunks as $key => $value) {
                        //         $mflag=2;
                        //         if($value->appStartTime == $startTime->format('H:i:s') && $value->appEndTime == $end->format('H:i:s'))
                        //         {
                        //             $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                        //         }
                        //         else
                        //         {
                        //             if($currentDateTime >= $end->format('H:i:s'))
                        //             {
                        //                 $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                        //             }
                        //             else
                        //             {
                        //                 $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;
                        //             }
                        //         }
    
                        //     }
                        // }
                        if($mflag==0){
                           // echo 3; exit;
                            if($currentDateTime >= $startTime->format('H:i:s'))
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');
                            }
                            else
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');
                            }
                        }

                    }
                    else
                    {
                        // echo 2;exit;
                        $qflag=0;
                        foreach ($bookedTimeForDoc as $key => $value) {
                            
                            $qflag=1;
                            $AppFromT = explode(' ',$value->AppFromTime);
                            $AppFromTime  = new DateTime($AppFromT[1]);

                            $AppToT = explode(' ',$value->AppToTime);
                            $AppToTime  = new DateTime($AppToT[1]);

                            if($AppFromTime->format('H:i:s') == $startTime->format('H:i:s') && $AppToTime->format('H:i:s') == $end->format('H:i:s'))
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                            }
                            else
                            {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;				
                            }

                        }
                        // if($timeChunks){
                        //     foreach ($timeChunks as $key => $value) {
                        //         $mflag=2;
                        //         if($value->appStartTime == $startTime->format('H:i:s') && $value->appEndTime == $end->format('H:i:s'))
                        //         {
                        //             $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                        //         }
                        //         else
                        //         {
                        //             if($currentDateTime >= $end->format('H:i:s'))
                        //             {
                        //                 $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');break;
                        //             }
                        //             else
                        //             {
                        //                 $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');break;
                        //             }
                        //         }
    
                        //     }
                        // }
                        if($qflag==0){
                            // if($currentDateTime >= $end->format('H:i:s'))
                            // {
                            //     $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'true');
                            // }
                            // else
                            // {
                                $timeArray[] = array('start_time'=>$startTime->format('H:i'),'end_time'=>$end->format('H:i'),'disabled'=>'false');
                            // }
                        }
                    }
                    
                    $st = $end;
                    $startTime->add(new DateInterval('PT'.$timeStep.'M'));
                }
                // print_r($timeArray);exit;
                if($timeArray)
                {
                    $response['response_code'] = '1';
                    $response['response_message'] = 'Success';
                    $response['response_data'] = $timeArray;
                }
                else
                {
                    $response['response_code'] = '2';
                    $response['response_message'] = 'Failed';
                }
            }
            else
            {
                $response['response_code'] = '4';
                $response['response_message'] = 'Doctor schedule not found';
            }    
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    public function InsertCallLog()
    {
        // print_r($_POST['appId']);exit;
        // $data = json_decode(file_get_contents('php://input'));
        if($_POST['appId'])
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $user = explode("_",$_POST['appId']);
            $userType = $user[0];
            $userId = $user[1];
            $appId = $user[2];
            if($userType == "DOC"){
                $chkLog = $this->RingCMSModel->chkCallLogData($appId);
                // print_r($chkLog);exit;
                $chksession = $this->RingCMSModel->chkTelecallingSession($appId);
                //print_r($chksession);exit;
                if(!isset($chksession) && empty($chksession)){
                    $SessionId = $appId."_".time();
                    $AppointmentId = $appId;
                    $EnrollData = $this->RingCMSModel->enrollmentDatabyAppointmentId($AppointmentId);
                    if($EnrollData){
                        $EnrollmentId = $EnrollData->Id;
                        $AppointmentId = $EnrollData->AppointmentId;
                        $PractitionerId = $EnrollData->PrimaryPractitionerId;
                        $sessArr = array( 
                            "EnrollmentId"=>$EnrollmentId,
                            "AppointmentId"=>$AppointmentId,
                            "SessionId"=> $SessionId,
                            "PractitionerId"=>$PractitionerId
                        );
                    $this->RingCMSModel->InsertTeleSession($sessArr);    
                    }
                        
                }
                if(!isset($chkLog) && empty($chkLog)){
                    $AppointmentId = $appId;
                    $EnrollData = $this->RingCMSModel->enrollmentDatabyAppointmentId($AppointmentId);
                    if($EnrollData){
                        $PatientId = $EnrollData->PatientId;
                        $EnrollmentId = $EnrollData->Id;
                        $AppointmentId = $EnrollData->AppointmentId;
                        $TenantId = $EnrollData->TenantId;
                        $PractitionerId = $EnrollData->PrimaryPractitionerId;
                        $currentDateTime = date('Y-m-d H:i:s');
                        $DoctorCallStartTime = $currentDateTime;
                        // $DoctorCallEndTime = $currentDateTime;
                        // $PatientCallStartTime = $currentDateTime;
                        // $PatientCallEndTime = $currentDateTime;
                        // $callDuration = 0;
                        // $CallStatus = 'NULL';
                        // $Payment = 'NULL';

                        $insertArr = array( 
                            "PatientId"=> $PatientId,
                            "EnrollmentId"=>$EnrollmentId,
                            "AppointmentId"=>$AppointmentId,
                            "TenantId"=> $TenantId,
                            "PractitionerId"=>$PractitionerId,
                            "DoctorCallStartTime"=>$DoctorCallStartTime
                            // "DoctorCallEndTime"=> $DoctorCallEndTime,
                            // "PatientCallStartTime"=>$PatientCallStartTime,
                            // "PatientCallEndTime"=>$PatientCallEndTime,
                            // "callDuration"=> $callDuration,
                            // "CallStatus"=>$CallStatus,
                            // "Payment"=>$Payment
                        );        
                        $result = $this->RingCMSModel->InsertCallLog($insertArr);       
                        if($result)             
                        {
                            $response['response_code'] = 1;
                            $response['response_message'] = 'Success';
                        }
                        else
                        {
                            $response['response_code'] = 2;
                            $response['response_message'] = 'Failed';
                        }
                    }
                    else
                    {
                        $response['response_code'] = 4;
                        $response['response_message'] = 'Enrollment data not found';
                    }           
                }
            }else if($userType == "PAT"){
                $chkLog = $this->RingCMSModel->chkCallLogData($appId);
                if(isset($chkLog) && !empty($chkLog)){
                    $currentDateTime = date('Y-m-d H:i:s');
                    $PatientCallStartTime = $currentDateTime;

                    $updateArr = array( 
                        "PatientCallStartTime"=>$PatientCallStartTime
                    );
                    $result1 = $this->RingCMSModel->updatePatientCallLog($updateArr,$chkLog->CallLogsId);
                    if($result1)             
                    {
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Success';
                    }
                    else
                    {
                        $response['response_code'] = 2;
                        $response['response_message'] = 'Failed';
                    }
                }
            }else{
                $response['response_code'] = 5;
                $response['response_message'] = 'User type not found';
            }
                           
        }
        else 
        {
            $response['response_code'] = 3;
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    public function getDoctorScheduleOrRemainingTime(){
        if($_POST['appId'])
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $user = explode("_",$_POST['appId']);
            $userType = $user[0];
            $userId = $user[1];
            $appId = $user[2];
            if($userType == "DOC"){
                $chksession = $this->RingCMSModel->chkTelecallingSession($appId);
                if(isset($chksession) && !empty($chksession)){
                    $appData = $this->RingCMSModel->appointmentDataById($appId);
                    $currentDateTime = date('H:i:s');
                    // print_r($appData);exit;
                    $endtime = explode(' ',$appData->ToTime);
                    $PatientCallEndTime = $endtime[1];
                    $startTime  = new DateTime($currentDateTime);
                    $endTime    = new DateTime($PatientCallEndTime);
                    // $remainingTime = $PatientCallEndTime - $currentDateTime;
                    // $diff = $startTime->diff($endTime);
                    $appointmentDuration = $this->RingCMSModel->getAppointmentDurationByPracId($userId);
                    if($appointmentDuration){
                        $durationInt = explode(" ",$appointmentDuration->Duration);
                        $durationInt1 = $durationInt[0]*60;
                    }else{
                         $durationInt1 = 1200;
                    }
                    $seconds = $endTime->getTimestamp() - $startTime->getTimestamp();
                   
                    if(($seconds > 0) && ($seconds < $durationInt1)){
                        $result = $seconds;
                    }else{
                        $result = $seconds;
                    }
                }else{
                    $appointmentDuration = $this->RingCMSModel->getAppointmentDurationByPracId($userId);
                    if($appointmentDuration){
                        $durationInt = explode(" ",$appointmentDuration->Duration);
                        $result = $durationInt[0]*60;
                    }else{
                        $result = 15*60;
                    }
                }
                    if($result)             
                    {
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Success';
                        $response['response_data'] = $result;
                    }
                    else
                    {
                        $response['response_code'] = 2;
                        $response['response_message'] = 'Failed';
                        $response['response_data'] = -300;
                    }
            }else{
                $response['response_code'] = 5;
                $response['response_message'] = 'User type not found';
            }
                           
        }
        else 
        {
            $response['response_code'] = 3;
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    public function EndCallLog()
    {
        // print_r($_POST['appId']);exit;
        // $data = json_decode(file_get_contents('php://input'));
        if($_POST['appId'])
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $user = explode("_",$_POST['appId']);
            $userType = $user[0];
            $userId = $user[1];
            $appId = $user[2];
            if($userType == "DOC"){
                $chkLog = $this->RingCMSModel->chkCallLogData($appId);
                if(isset($chkLog) && !empty($chkLog->PatientCallStartTime)){
                    $currentDateTime = date('Y-m-d H:i:s');
                    $PatientCallStartTime = $chkLog->PatientCallStartTime;
                    $start = strtotime($PatientCallStartTime);
                    $end = strtotime($currentDateTime);
                    $durInSec = $end - $start;
                    $duration = intval($durInSec / 60);
                    $updateArr = array( 
                        "DoctorCallEndTime"=>$currentDateTime,
                        "callDuration"=>$duration
                    );
                    $result = $this->RingCMSModel->updatePatientCallLog($updateArr,$chkLog->CallLogsId);
                    if($result)             
                    {
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Success';
                    }
                    else
                    {
                        $response['response_code'] = 2;
                        $response['response_message'] = 'Failed';
                    }
                }
            }else if($userType == "PAT"){
                $chkLog = $this->RingCMSModel->chkCallLogData($appId);
                if(isset($chkLog) && !empty($chkLog->PatientCallStartTime)){
                    $currentDateTime = date('Y-m-d H:i:s');
                    $PatientCallStartTime = $chkLog->PatientCallStartTime;
                    $start = strtotime($PatientCallStartTime);
                    $end = strtotime($currentDateTime);

                    $duration = ($end - $start) / 60;
                    $updateArr = array( 
                        "PatientCallEndTime"=>$currentDateTime,
                        "callDuration"=>$duration
                    );
                    $result1 = $this->RingCMSModel->updatePatientCallLog($updateArr,$chkLog->CallLogsId);
                    if($result1)             
                    {
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Success';
                    }
                    else
                    {
                        $response['response_code'] = 2;
                        $response['response_message'] = 'Failed';
                    }
                }
            }else{
                $response['response_code'] = 5;
                $response['response_message'] = 'User type not found';
            }
                           
        }
        else 
        {
            $response['response_code'] = 3;
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    public function CheckDoctorCallAvailablity()
    {
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $AppointmentId = $data->AppointmentId;
            $chkLog = $this->RingCMSModel->chkCallLogData($AppointmentId); 
            if($chkLog)             
            {
                $response['response_code'] = 1;
                $response['response_message'] = 'Success';
                $response['CallLogsId'] = $chkLog->CallLogsId;
            }
            else
            {
                $response['response_code'] = 2;
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

    public function updatePatientCallLog()
    {
        $data = json_decode(file_get_contents('php://input'));  
        date_default_timezone_set("asia/Kuala_Lumpur");      
        if($data)
        {
            $appId = $data->AppointmentId;
            $chkLog = $this->RingCMSModel->chkCallLogData($appId);
            if(isset($chkLog)){
                $currentDateTime = date('Y-m-d H:i:s');
                $PatientCallStartTime = $currentDateTime;

                $updateArr = array( 
                    "PatientCallStartTime"=>$PatientCallStartTime
                );
                $result = $this->RingCMSModel->updatePatientCallLog($updateArr,$chkLog->CallLogsId);
                if($result)             
                {
                    $response['response_code'] = 1;
                    $response['response_message'] = 'Success';
                }
                else
                {
                    $response['response_code'] = 2;
                    $response['response_message'] = 'Failed';
                }
            }
            else 
            {
                $response['response_code'] = 4;
                $response['response_message'] = 'call log not found';
            }
        }
        else 
        {
            $response['response_code'] = 3;
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    public function updateAppointmentPaymentData(){
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        $PatientId = $data->PatientId;
        $AppointmentId = $data->AppointmentId;
        $AppPaymentId = $data->AppPaymentId;
        $updateArray = array(         
            "AppointmentId"=>$AppointmentId                              
        );
        $result = $this->RingCMSModel->updateAppointmentPaymentData($updateArray,$PatientId,$AppPaymentId);                  
        if($result)             
        {
            $response['response_code']=1;
            $response['response_message']='Sucess';
            $response['data']=$result;
        }
        else
        {
            $response['response_code']=2;
            $response['response_message']='Failed';           
        }        
        echo json_encode($response); exit;
    }

    public function saveCallStartDataInTable()
    {
        //print_r($_POST);
        if($_POST['RoomData'])
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $user = explode("_",$_POST['RoomData']);
            $userType = $user[0];
            $userId = $user[1];
            $appId = $user[2];
            $memberId = $userId;
            $appointmentId = isset($appId)?$appId:0;
            $isStart = 1;
            $isEnd = 0;
            $insertDate = date('Y-m-d H:i:s');
            if($userType == "DOC"){
                $memberType = "DOCTOR"; 
            }else{
                $memberType = "PATIENT"; 
            }
            $insertArr = array( 
                "MemberId"=> $memberId,
                "AppointmentId"=>$appointmentId,
                "IsStart"=>$isStart,
                "IsEnd"=> $isEnd,
                "InsertDate"=>$insertDate,
                "MemberType"=>$memberType
            );        
            $result = $this->RingCMSModel->InsertTeleCallLog($insertArr);       
            if($result)             
            {
                $response['response_code'] = 1;
                $response['response_message'] = 'Success';
            }
            else
            {
                $response['response_code'] = 2;
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

    public function saveCallEndDataInTable()
    {
        if($_POST['RoomData'])
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $user = explode("_",$_POST['RoomData']);
            $userType = $user[0];
            $userId = $user[1];
            $appId = $user[2];
            $memberId = $userId;
            $appointmentId = isset($appId)?$appId:0;
            $isStart = 0;
            $isEnd = 1;
            $insertDate = date('Y-m-d H:i:s');
            if($userType == "DOC"){
                $memberType = "DOCTOR"; 
            }else{
                $memberType = "PATIENT"; 
            }
            $insertArr = array( 
                "MemberId"=> $memberId,
                "AppointmentId"=>$appointmentId,
                "IsStart"=>$isStart,
                "IsEnd"=> $isEnd,
                "InsertDate"=>$insertDate,
                "MemberType"=>$memberType
            );        
            $result = $this->RingCMSModel->InsertTeleCallLog($insertArr);       
            if($result)             
            {
                $response['response_code'] = 1;
                $response['response_message'] = 'Success';
            }
            else
            {
                $response['response_code'] = 2;
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

    public function CheckLastTransactionforAppointment(){
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        $PatientId = $data->PatientId;
        $PractitionerId = $data->PractitionerId;
        $result = $this->RingCMSModel->CheckLastTransactionforAppointment($PatientId,$PractitionerId);                  
        if($result)             
        {
            $response['response_code']=1;
            $response['response_message']='Sucess';
            $response['data']=$result;
        }
        else
        {
            $response['response_code']=2;
            $response['response_message']='Failed';           
        }        
        echo json_encode($response); exit;
    }

    public function CheckLastTransactionforAppointmentIOS(){
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        $PatientId = $data->PatientId;
        $PractitionerId = $data->PractitionerId;
        $timeString = $data->timeString;
        $timeZone = $data->timeZone;
        //$indianTime = $data->timeString;
        
        // $date = DateTime::createFromFormat("Y-m-d H:i:s.u", $indianTime, new DateTimeZone("Asia/Kolkata"));

        // $date->setTimezone(new DateTimeZone("Asia/Kuala_Lumpur"));

        // $malaysiaTime = $date->format("Y-m-d H:i:s.v");
        /***************************************************/
        $utcTime = $timeZone; // UTC time
        $utcTimezone = new DateTimeZone("UTC");
        $localTimezone = new DateTimeZone("Asia/Kuala_Lumpur"); // Change to your local timezone

        $date = new DateTime($utcTime, $utcTimezone);
        $date->setTimezone($localTimezone);

        $malaysiaTime = $date->format("Y-m-d H:i:s.v");
        //echo $malaysiaTime; exit;
        $result = $this->RingCMSModel->CheckLastTransactionforAppointmentIOS($PatientId,$PractitionerId,$malaysiaTime);                  
        if($result)             
        {
            $response['response_code']=1;
            $response['response_message']='Sucess';
            $response['data']=$result;
        }
        else
        {
            $response['response_code']=2;
            $response['response_message']='Failed';           
        }        
        echo json_encode($response); exit;
    }

    public function insertCMSReportDownloadUpdate(){
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $PatientId = $data->PatientId;
            $AppointmentId = $data->AppointmentId;
            $EnrollmentId = $data->EnrollmentId;
            $CategoryName = $data->CategoryName;
            $isReportDownloaded = 1;
            $insertArr = array( 
                "AppointmentId"=> $AppointmentId,
                "EnrollmentId"=>$EnrollmentId,
                "PatientId"=>$PatientId,
                "CategoryName"=> $CategoryName,
                "isReportDownloaded"=>$isReportDownloaded
            );
            $insert = $this->RingCMSModel->insertCMSReportDownloadUpdate($insertArr);                  
            if($insert)             
            {
                $response['response_code']=1;
                $response['response_message']='Sucess';
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
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }


    function TimeSlotListForPostmanTest(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $weekArr = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
            $location_id = $data->location_id; 
            $doctor_id = $data->doctor_id;
            $appointment_date = $data->appointment_date;
            $appointmentDate = $appointment_date;
            $bookedTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Booked");
            // echo "<pre>"; print_r($bookedTimeForDoc);exit;
            $scheduleTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Schedule");
            $doctorLeaves = $this->RingCMSModel->getDoctorLeave($doctor_id,$appointment_date,$location_id);

            if(!empty($doctorLeaves))
            $leaveArray = $this->convertLeaveArrayTo12HourFormat($doctorLeaves);
            else  $leaveArray = [] ;
              
           // $schedule = $scheduleTimeForDoc[0]; // From your array

            $allSlots = [];
            $bookedSlots = $this->convertBookedToSlotLabels($bookedTimeForDoc, '24');

            
            
            foreach ($scheduleTimeForDoc as $shift) {
                $slots = $this->generateDoctorSlotsForAppointmentDate($shift->FromTime, $shift->ToTime, $appointment_date ,15, '24'); 
                
                $slots = $this->markBookedSlots($slots, $bookedSlots);

                if(!empty( $doctorLeaves))
                $slots = $this->markLeaveSlots($slots, $leaveArray, '24');
                $slots = $this->markNearTermSlotsUnavailable($slots, 10, '24'); // Disable slots <20 min

                $allSlots = array_merge($allSlots, $slots);
            }

            // Final result
            //print_r($allSlots);

           
                if($allSlots)
                {
                    $response['response_code'] = '1';
                    $response['response_message'] = 'Success';
                    $response['response_data'] = $allSlots;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function TimeSlotList14May25(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $weekArr = array("1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday","7"=>"Sunday");
            $location_id = $data->location_id; 
            $doctor_id = $data->doctor_id;
            $appointment_date = $data->appointment_date;
            $appointmentDate = $appointment_date;
            $bookedTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Booked");
            $scheduleTimeForDoc = $this->RingCMSModel->BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,"Schedule");
            $doctorLeave = $this->RingCMSModel->getDoctorLeave($doctor_id,$appointment_date,$location_id);
            $resultArray = array();
            foreach($scheduleTimeForDoc as $key => $value){
                $startTime = new DateTime($start);
                $endTime = new DateTime($end);
                $interval = new DateInterval('PT' . $interval . 'M'); // e.g., PT15M for 15 minutes

                $slots = [];

                while ($startTime < $endTime) {
                    $slotStart = clone $startTime;
                    $slotEnd = clone $startTime;
                    $slotEnd->add($interval);

                    // Only add if slotEnd does not exceed final end time
                    if ($slotEnd <= $endTime) {
                        $slots[] = $slotStart->format('h:i A') . ' - ' . $slotEnd->format('h:i A');
                    }

                    $startTime->add($interval);
                }

                print_r($slots);
            }
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    // Step 1: Slot Generator
    function generateDoctorSlotsForAppointmentDate($fromTime, $toTime, $appointmentDate, $intervalMinutes = 15, $timeFormat = '24') {
        $format = ($timeFormat === '12') ? 'h:i A' : 'H:i';

        // Extract time parts from original FromTime and ToTime
        $from = new DateTime($fromTime);
        $to = new DateTime($toTime);

        $startTimeOnly = $from->format('H:i:s');
        $endTimeOnly = $to->format('H:i:s');

        // Create new DateTime objects with appointment date
        $start = new DateTime("$appointmentDate $startTimeOnly");
        $end = new DateTime("$appointmentDate $endTimeOnly");

        $slots = [];

        while ($start < $end) {
            $slotStart = $start->format($format);
            $start->modify("+{$intervalMinutes} minutes");
            $slotEnd = $start->format($format);

            $slotLabel = "$appointmentDate $slotStart - $slotEnd";

            $slots[] = [
                'date' => $appointmentDate,
                'start' => $slotStart,
                'end' => $slotEnd,
                'start_time' => $slotStart,
                'end_time' => $slotEnd,
                'slot' => $slotLabel,
                'disabled' => "false"
            ];
        }

        return $slots;
    }

    // Step 2: Mark Booked
    function markBookedSlots($slots, $bookedSlotLabels = []) {  

    
        foreach ($slots as &$slot) {
            if (in_array($slot['slot'], $bookedSlotLabels)) {;
                $slot['disabled'] = "true";
            }
        }
        
        return $slots;
    }

    // Step 3: Mark Leave
    function markLeaveSlots($slots, $leaveArray = [], $timeFormat = '12') {
        $format = ($timeFormat === '12') ? 'h:i A' : 'H:i';

        // Normalize to array if single object
        if (is_object($leaveArray)) {
            $leaveArray = [$leaveArray];
        }

        foreach ($leaveArray as $leave) {
            if (!is_object($leave) || !isset($leave->LeaveDate)) continue;

            $leaveDate = (new DateTime($leave->LeaveDate))->format('Y-m-d');
                // Full-day leave if LeaveTypeId == 1
            $isFullDay = (isset($leave->LeaveTypeId) && $leave->LeaveTypeId == 1) || 
                        (empty($leave->StartTime) && empty($leave->EndTime));

            foreach ($slots as &$slot) {
                if ($slot['date'] !== $leaveDate) continue;

                if ($isFullDay) {
                    $slot['available'] = "false";
                    $slot['disabled'] = "true";
                    $slot['reason'] = 'Full day leave';
                } else {
                    $slotStartDT = new DateTime("{$slot['date']} {$slot['start']}");
                    $slotEndDT   = new DateTime("{$slot['date']} {$slot['end']}");
                    $leaveStartDT = new DateTime($leave->StartTime);
                    $leaveEndDT   = new DateTime($leave->EndTime);

                    if (
                        ($slotStartDT >= $leaveStartDT && $slotStartDT < $leaveEndDT) ||
                        ($slotEndDT > $leaveStartDT && $slotEndDT <= $leaveEndDT)
                    ) {
                        $slot['available'] = "false";
                        $slot['disabled'] = "true";
                        $slot['reason'] = 'Leave time blocked';
                    }
                }
            }
        }

        return $slots;
    }

    function convertBookedToSlotLabels($bookedSchedule, $timeFormat = '24') {
        $bookedSlots = [];
        $format = ($timeFormat === '12') ? 'h:i A' : 'H:i';

        foreach ($bookedSchedule as $booking) {
            if (!isset($booking->AppFromTime, $booking->AppToTime)) continue;

            $from = new DateTime($booking->AppFromTime);
            $to = new DateTime($booking->AppToTime);
            $date = $from->format('Y-m-d');
            $start = $from->format($format);
            $end = $to->format($format);

            $bookedSlots[] = "$date $start - $end";
        }

        return $bookedSlots;
    }

	function convertLeaveArrayTo12HourFormat($leaveArray) {
        // Normalize to array if it's a single object
        if (is_object($leaveArray)) {
            $leaveArray = [$leaveArray];
        }

        $formattedLeaves = [];

        foreach ($leaveArray as $leave) {
            if (!is_object($leave)) continue;

            $formattedLeave = clone $leave; // preserve original object

            // Format StartTime
            if (!empty($leave->StartTime)) {
                $formattedLeave->StartTimeFormatted = (new DateTime($leave->StartTime))->format('h:i A');
            }

            // Format EndTime
            if (!empty($leave->EndTime)) {
                $formattedLeave->EndTimeFormatted = (new DateTime($leave->EndTime))->format('h:i A');
            }

            $formattedLeaves[] = $formattedLeave;
        }

        return $formattedLeaves;
    }

    function markNearTermSlotsUnavailable($slots, $bufferMinutes = 20, $timeFormat = '12') {
        $now = new DateTime(); // Current server time
        $bufferTime = clone $now;
        $bufferTime->modify("+{$bufferMinutes} minutes");

        foreach ($slots as &$slot) {
            $slotStartDT = new DateTime("{$slot['date']} {$slot['start']}");

            if ($slotStartDT <= $bufferTime) {
                $slot['available'] = "false";
                $slot['disabled'] = "true";
                $slot['reason'] = 'Less than 20 min from now';
            }
        }

        return $slots;
    }


    public function CallEndThankYouPage(){
       $this->load->view('pages/thank_you');
    }

    public function upcomingAppointmentsNotification_1Daybefore() {
        date_default_timezone_set("asia/Kuala_Lumpur");
        $now = date('Y-m-d H:i:00');
        /********23 to 24 hours later****/
        $fromTime = date('Y-m-d H:i:00', strtotime($now . ' +23 hours')) . '.000';
        $toTime   = date('Y-m-d H:i:00', strtotime($now . ' +24 hours')) . '.000';
        $checkData = $this->RingCMSModel->getAppointmentsBetween($fromTime, $toTime);
        if($checkData ){
            foreach($checkData as $val){
                // print_r($val);exit;
                $PatientId = $val->PatientId;
                $time = date("h:i A", strtotime($val->FromTime));
                $dateOnly = date("Y-m-d", strtotime($val->AppointmentDate));
                $notification_heading = "Your appointment is coming up";        
                $notification_body = "You have an upcoming appointment scheduled on ".$dateOnly." at ".$time;
                $notification_type = "Appointment";
                $this->android_notification_function($PatientId,$notification_heading,$notification_body,$notification_type);
            }
        }
        
        if($checkData){
            $response['response_code'] = '1';
            $response['response_message'] = 'Success';
            $response['response_data'] = $checkData;
        }else{
            $response['response_code'] = '2';
            $response['response_message'] = 'No upcoming appointments found';
        }
        echo json_encode($response); exit;
    }

    public function upcomingAppointmentsNotification_1Hourbefore() {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $now = date('Y-m-d H:i:00');

        /******** 60 to 75 minutes later ********/
        $fromTime = date('Y-m-d H:i:00', strtotime($now . ' +60 minutes')) . '.000';
        $toTime   = date('Y-m-d H:i:00', strtotime($now . ' +75 minutes')) . '.000';

        $checkData = $this->RingCMSModel->getAppointmentsBetween($fromTime, $toTime);
        if($checkData) {
            foreach ($checkData as $val) {
                // print_r($val);exit;
                $PatientId = $val->PatientId;
                $time = date("h:i A", strtotime($val->FromTime));
                $dateOnly = date("Y-m-d", strtotime($val->AppointmentDate));

                $notification_heading = "Don’t miss your appointment today";        
                $notification_body = "Your appointment with " .$val->TenantName." is coming up at " .$time." today";
                $notification_type = "Appointment";

                $this->android_notification_function($PatientId, $notification_heading, $notification_body, $notification_type);
            }

            $response['response_code'] = '1';
            $response['response_message'] = 'Success';
            $response['response_data'] = $checkData;
        } else {
            $response['response_code'] = '2';
            $response['response_message'] = 'No upcoming appointments found';
        }

        echo json_encode($response); 
        exit;

    }

    function android_notification_function($PatientId,$notification_heading,$notification_body,$notification_type){
        $PatientId = $PatientId;
        $notification_heading = $notification_heading;        
        $notification_body = $notification_body;
        $notification_type = $notification_type;
        $companyName = "";
        if(!isset($PatientId)){
            echo json_encode(array("msg"=>"PatientId not sent")); exit;
        }
        $userType = 0; //0 = Patient, 1 = Doctor
        $checkuserid = $this->WebserviceModel->checkuserid($PatientId,$userType);
        // print_r($checkuserid);exit;
        $token = isset($checkuserid->DeviceId)?$checkuserid->DeviceId:0;
		if(isset($PatientId) && empty($token)){
			$mainProfileId = $this->WebserviceModel->getMainPatientId($PatientId);
			if(isset($mainProfileId->MainProfilePatientId)){
				$checkusertoken = $this->WebserviceModel->checkuserid($mainProfileId->MainProfilePatientId,$userType);
        		$usertoken = isset($checkusertoken->DeviceId)?$checkusertoken->DeviceId:0;
			}else{
				$usertoken = $token;
			}
			
		}else{
			$usertoken = $token;
		}      
        if(isset($checkuserid->Platform) && $checkuserid->Platform == "ios"){
            $message = array(
                        'title' => $notification_heading, 
                        'body' => $notification_body, 
                        'sound' => 'default', 
                        'badge' => '1',
                        'notifictionType' => $notification_type,
                        "notification_heading" =>  $notification_heading,
                        "notification_body" =>  $notification_body
                    );     
            $this->fcm->serviceAccountKeyFile = "ring-4c5e3-firebase-adminsdk-zo3qc-9b789d36b9.json";
            $this->fcm->projectID = "ring-4c5e3";
            $response = $this->fcm->sendNotification($usertoken, $notification_heading, $notification_body, $notification_type, $companyName);
            $insertInTable = $this->InsertInAppNotificationInDB($PatientId, $notification_heading, $notification_body, $notification_type, $companyName, $response, $checkuserid->Platform);
            // print_r($response);exit;
            $notificationArr = array(
                "PatientId" => $PatientId,
                "DeviceID" => $usertoken,
                "notification_body" => $notification_body,
                "NotificationDate" => date("Y-m-d H:i:s"),
                "CreatedDate" => date("Y-m-d H:i:s")
            ); 
            $this->WebserviceModel->InsertNotificationLog($notificationArr);           
        }else{
            $message = array(
                'title' => $notification_heading, 
                'body' => $notification_body, 
                'sound' => 'default', 
                'badge' => '1',
                'click_action'=>'FCM_PLUGIN_ACTIVITY', //For only Android App
                'notifictionType' => $notification_type,
                "notification_heading" =>  $notification_heading,
                "notification_body" =>  $notification_body
            );
            $response = $this->fcm->sendNotification($usertoken, $notification_heading, $notification_body, $notification_type, $companyName);
            $insertInTable = $this->InsertInAppNotificationInDB($PatientId, $notification_heading, $notification_body, $notification_type, $companyName, $response, $checkuserid->Platform);
            // print_r($response); 
            $notificationArr = array(
                "PatientId" => $PatientId,
                "DeviceID" => $token,
                "notification_body" => $notification_body,
                "NotificationDate" => date("Y-m-d H:i:s"),
                "CreatedDate" => date("Y-m-d H:i:s")
                ); 
            $this->WebserviceModel->InsertNotificationLog($notificationArr);      
        }     
    }

    public function InsertInAppNotificationInDB($PatientId, $notification_heading, $notification_body, $notification_type, $companyName, $response, $Platform){
        $insertArray = array(
            "PatientId" => $PatientId,
            "NotificationTitle" => $notification_heading,
            "NotificationBody" => $notification_body,
            "NotificationType" => $notification_type,
            "CompanyName" => $companyName,
            "ResponseString" => $response,
            "DeviceType" => $Platform
        ); 
        $insert = $this->WebserviceModel->InsertInAppNotificationInDB($insertArray);
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }

    public function getQueTokenDataOfPatient() {
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            date_default_timezone_set("asia/Kuala_Lumpur");
            $patientId = $data->patientId;
            $checkData = $this->RingCMSModel->getLastQueOfPatient($patientId);
            if($checkData){
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $checkData;
            }else{
                $response['response_code'] = '2';
                $response['response_message'] = 'No data found';
            }
        }else{
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    /**API 1: Check if user exists in UserMRN table*/
    public function checkUserInUserMRN(){
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $PatientId = isset($data->PatientId) ? $data->PatientId : '';
            $RingGroupId = isset($data->RingGroupId) ? $data->RingGroupId : '';
            if($PatientId == ''){
                $response['response_code'] = '3';
                $response['response_message'] = 'PatientId is required';
                echo json_encode($response); exit;
            }

            $checkData = $this->RingCMSModel->checkUserInUserMRN($PatientId, $RingGroupId);
            if($checkData){
                $response['response_code'] = '1';
                $response['response_message'] = 'User found in UserMRN';
                $response['response_data'] = $checkData;
            }else{
                $response['response_code'] = '2';
                $response['response_message'] = 'User not found in UserMRN';
            }
        }else{
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

   /*** API 2: Check if user exists in PatientMaster table */
    public function checkUserVarificationForConnect(){
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            if(isset($data->Email) && !empty($data->Email)){
                $email = $this->encryptDecrypt("en",$data->Email);
            }else{
                $email = '';
            }
            
            if(isset($data->FirstName) && !empty($data->FirstName)){
                $name = $this->encryptDecrypt("en",$data->FirstName);
            }else{
                $name = '';
            }

            if(isset($data->IdentityNo) && !empty($data->IdentityNo)){
                $passportNo = $this->encryptDecrypt("en",$data->IdentityNo);
            }else{
                $passportNo = '';
            }
            $checkData = $this->RingCMSModel->checkUserInPatientMaster($email, $name, $passportNo);
            if($checkData){
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $checkData;
            }else{
                $response['response_code'] = '2';
                $response['response_message'] = 'User not found';
            }
        }else{
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    // ======================================================
    // API 3: If user found in PatientMaster but not in UserMRN, insert into UserMRN
    // ======================================================
    public function insertUserIfNotInUserMRN(){
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $patientId = $data->PatientId;
            if(isset($data->Email) && !empty($data->Email)){
                $email = $this->encryptDecrypt("en",$data->Email);
            }else{
                $email = '';
            }

            if(isset($data->FirstName) && !empty($data->FirstName)){
                $name = $this->encryptDecrypt("en",$data->FirstName);
            }else{
                $name = '';
            }

            if(isset($data->IdentityNo) && !empty($data->IdentityNo)){
                $passportNo = $this->encryptDecrypt("en",$data->IdentityNo);
            }else{
                $passportNo = '';
            }
            $ringGroupId = isset($data->ringGroupId) ? $data->ringGroupId : '';
            $impId = isset($data->ImpId)?$data->ImpId:1;
            $MRN = $data->MRNno;
            // Step 1: Check PatientMaster
            $patient = $this->RingCMSModel->checkUserInPatientMaster($email, $name, $passportNo, $ringGroupId);
            if(!$patient){
                $response['response_code'] = '4';
                $response['response_message'] = 'User not found';
                echo json_encode($response); exit;
            }

            // Step 2: Check UserMRN
            $exists = $this->RingCMSModel->checkUserInUserMRN($patient['PatientId'], $ringGroupId);
            if($exists){
                $response['response_code'] = '5';
                $response['response_message'] = 'User already exists in UserMRN';
                echo json_encode($response); exit;
            }

            // Step 3: Insert new record
            $insertData = array(
                'MRNNo' => $MRN,
                'RINGID' => $patient['PatientId'],
                'RingGroupId' => $ringGroupId,
                'CMSID' => $patient['PatientId'],
                'ImplementationId'=>$impId,
                'CreatedDate' => date('Y-m-d H:i:s'),
                'IsConnected' => 1
            );

            $insertId = $this->RingCMSModel->insertUserInUserMRN($insertData);

            if($insertId){
                $response['response_code'] = '1';
                $response['response_message'] = 'User inserted successfully in UserMRN';
                $response['response_data'] = ['insertId' => $insertId];
            }else{
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed to insert user in UserMRN';
            }
        }else{
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is null';
        }
        echo json_encode($response); exit;
    }

    function InsertUserVerificationDataTesting(){
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            // {"PatientId":"61211","Email":"kajepi2409@ckuer.com","FirstName":"DASARATH","IdentityNo":"DA212221","ringGroupId":105,"MRNno":"CCM00-PRN-00008"}
            $MRN = $data->MRNno;
            $RINGID = $data->PatientId;
            $impId = isset($data->ImpId)?$data->ImpId:1;
            $CMSID = $data->PatientId;
            $ringGroupId = isset($data->ringGroupId) ? $data->ringGroupId : '';
            $check = $this->RingCMSModel->userVerification($RINGID,$ringGroupId);
            if(isset($check) && !empty($check)){
                $updateArr = array("IsConnected"=>1);
                $update = $this->WebserviceModel->UpdateMrnOfUser($updateArr,$check->Id);
                if($update){
                    $insert = $this->WebserviceModel->checkMrnOfRingUserByRingId($RINGID);
                }
            }else{
                $insertArr = array( 
                    "MRNNo"=>$MRN,
                    "RINGID"=>$RINGID,
                    "CMSID"=>$CMSID,
                    "ImplementationId"=>$impId,
                    "RingGroupId"=>$ringGroupId,
                    "IsConnected"=>1
                );
                $insert = $this->WebserviceModel->InsertMrnOfUser($insertArr);
            }
            if($insert)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $insert;
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
        echo json_encode($response);exit;
    }

    function getUserPRNByPatientId(){
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $patientId = $data->patientId;
            $ringGroupId = isset($data->ringGroupId) ? $data->ringGroupId : '';
            $check = $this->RingCMSModel->getPRNByPatientAndTenants($patientId, $ringGroupId);
            if($check)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $check;
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
        echo json_encode($response);exit;
    }

    function AppointmentListForDoctor(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $doctorId = $data->doctorId;
            $tenantId = $data->tenantId;
            $defaultDate = date("Y-m-d") . " 00:00:00.000";
            if(isset($data->selectDate) && !empty($data->selectDate)){
                $selectDate = $data->selectDate. " 00:00:00.000";
            }else{
                $selectDate = $defaultDate;
            }
            
            $Result["Upcoming"] = $this->RingCMSModel->AppointmentListForDoctor($doctorId,$selectDate,$tenantId);
            // print_r($Result); exit;
            if(isset($Result["Upcoming"])){
                foreach($Result["Upcoming"] as &$canVal){
                    $canVal['PatFirstname'] = $this->encryptDecrypt("dc",$canVal['PatFirstname']);
                    $canVal['PatLastname'] = $this->encryptDecrypt("dc",$canVal['PatLastname']);
                    $canVal['IdentityNo'] = $this->encryptDecrypt("dc",$canVal['IdentityNo']);
                    $canVal['IdentityNoNRIC'] = $this->encryptDecrypt("dc",$canVal['IdentityNoNRIC']);
                    $AppointmentDate = strtotime($canVal['AppointmentDate']);
                    $canVal['AppointmentDate'] = date("Y-m-d", $AppointmentDate);
                    if($canVal['StartTime']){
                        $StartTime = explode(' ',$canVal['StartTime']);
                        $StartTimenew  = new DateTime($StartTime[1]);
                        $canVal['StartTime'] = $StartTimenew->format('h:i A');
                        $canVal['SearchStartTime'] = $StartTimenew->format('H:i');
                    }
                    if($canVal['EndTime']){
                        $EndTime = explode(' ',$canVal['EndTime']);
                        $EndTimenew  = new DateTime($EndTime[1]);
                        $canVal['EndTime'] = $EndTimenew->format('h:i A');
                    }
                    
                }
                unset($canVal);
            }
            
            if($Result)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $Result;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }


    function QueueAppointmentListForDoctor(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $doctorId = $data->doctorId;
            $tenantId = $data->tenantId;
            $defaultDate = date("Y-m-d") . " 00:00:00.000";
            if(isset($data->selectDate) && !empty($data->selectDate)){
                $selectDate = $data->selectDate. " 00:00:00.000";
            }else{
                $selectDate = $defaultDate;
            }
            
            $Result["QueueList"] = $this->RingCMSModel->QueueAppointmentListForDoctor($doctorId,$selectDate,$tenantId);
            // print_r($Result); exit;
            if(isset($Result["QueueList"])){
                foreach($Result["QueueList"] as &$canVal){
                    $canVal['PatFirstname'] = $this->encryptDecrypt("dc",$canVal['PatFirstname']);
                    $canVal['PatLastname'] = $this->encryptDecrypt("dc",$canVal['PatLastname']);
                    $canVal['IdentityNo'] = $this->encryptDecrypt("dc",$canVal['IdentityNo']);
                    $canVal['IdentityNoNRIC'] = $this->encryptDecrypt("dc",$canVal['IdentityNoNRIC']);
                    $AppointmentDate = strtotime($canVal['AppointmentDate']);
                    $canVal['AppointmentDate'] = date("Y-m-d", $AppointmentDate);
                    if($canVal['StartTime']){
                        $StartTime = explode(' ',$canVal['StartTime']);
                        $StartTimenew  = new DateTime($StartTime[1]);
                        $canVal['StartTime'] = $StartTimenew->format('h:i A');
                        $canVal['SearchStartTime'] = $StartTimenew->format('H:i');
                    }
                    if($canVal['EndTime']){
                        $EndTime = explode(' ',$canVal['EndTime']);
                        $EndTimenew  = new DateTime($EndTime[1]);
                        $canVal['EndTime'] = $EndTimenew->format('h:i A');
                    }
                    if($canVal['PatientStatusId']){
                        if($canVal['PatientStatusId'] == 1){
                            $canVal['AppointmentStatus'] = "In Queue";
                        }else if($canVal['PatientStatusId'] == 2){
                            $canVal['AppointmentStatus'] = "In Consultation";
                        }else if($canVal['PatientStatusId'] == 3){
                            $canVal['AppointmentStatus'] = "Completed";
                        }else if($canVal['PatientStatusId'] == 4){
                            $canVal['AppointmentStatus'] = "Pending Billing";
                        }else{
                            $canVal['AppointmentStatus'] = "Unknown";
                        }
                    }
                    
                }
                unset($canVal);
            }
            
            if($Result)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $Result;
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
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function InsertAppointmentIfPatientExists(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $search_prn = isset($data->prn) ? $data->prn : "NULL";
            if(isset($data->mobile_number) && !empty($data->mobile_number)){
                $search_mobile = $this->encryptDecrypt("en", $data->mobile_number);
            } else {
                $search_mobile = "NULL";
            }
            if(isset($data->IdentityNo) && !empty($data->IdentityNo)){
                $search_identity = $this->encryptDecrypt("en", $data->IdentityNo);
            } else {
                $search_identity = "NULL";
            }
            if(isset($data->firstname) && !empty($data->firstname)){
                $search_name = $this->encryptDecrypt("en", $data->firstname);
            } else {
                $search_name = "NULL";
            }

            $foundPatientId = $this->RingCMSModel->findPatientByDetails($search_prn, $search_identity, $search_name, $search_mobile);

            if(!$foundPatientId){
                $response['response_code'] = '2';
                $response['response_message'] = 'Patient not found';
                echo json_encode($response); exit;
            }

            $patientid = $foundPatientId;
            $location_id = $data->location_id;
            $doctor_id = $data->doctor_id;
            $department_id = $data->department_id;
            $appointment_date = $data->appointment_date;
            $from_time = $data->from_time;
            $to_time = $data->to_time;       
            $firstname = $search_name; 
            
            if(isset($data->lastname) && !empty($data->lastname)){
                $lastname = $this->encryptDecrypt("en",$data->lastname);
            }else{
                $lastname = "NULL";
            }
            
            $gender = $data->gender;
            $dob = $data->dob;
            if(isset($dob) && !empty($dob)){
                $ts = strtotime($dob);
                $dob1 = date("Y-m-d", $ts);
            }else{
                $dob1 = NULL;
            }
            $bloodgroup = isset($data->bloodgroup)?$data->bloodgroup:1;
            
            if(isset($data->email) && !empty($data->email)){
                $email = $this->encryptDecrypt("en",$data->email);
            }else{
                $email = "NULL";
            }
            
            $country_id = isset($data->country_id)?$data->country_id:0;
            $state_id = isset($data->state_id)?$data->state_id:0;
            $city_id = isset($data->city_id)?$data->city_id:0;
            $address = isset($data->address)?$data->address:"NULL";
            $pin_code = isset($data->pin_code)?$data->pin_code:0;
            $mob_code = isset($data->mob_code)?$data->mob_code:"NULL";
            $bloodgrouptype = isset($data->bloodgrouptype)?$data->bloodgrouptype:"NULL";
            $isMainPatientID = isset($data->isMainPatientID) ? $data->isMainPatientID : 0;
            $mobile_number = $search_mobile; 
            $appointment_reason_id = $data->appointment_reason_id;
            $remark = $data->remark;
            $IdentificationTypeId = isset($data->IdentificationTypeId) ? $data->IdentificationTypeId : 0;
            $IdentityNo = $search_identity; 
            $Apptype = isset($data->appointmentType)?$data->appointmentType:2;

            $BookAppointment = $this->RingCMSModel->InsertAppointmentDetails($patientid,$location_id,$doctor_id,$department_id,$appointment_date,$from_time,$to_time,$firstname,$lastname,$gender,$dob1,$bloodgroup,$email,$country_id,$state_id,$city_id,$address,$pin_code,$mob_code,$bloodgrouptype,$isMainPatientID,$mobile_number,$appointment_reason_id,$remark,$IdentificationTypeId,$IdentityNo,$Apptype);
            if($BookAppointment)
            {
                if($data->appointmentType == 2){
                    $appPaymentId = $this->RingCMSModel->getAppPaymentId($patientid);
                    if($appPaymentId){
                        $updateArray = array("AppointmentId"=>$BookAppointment->AppointmentId);
                        $result = $this->RingCMSModel->updateAppointmentPaymentData($updateArray,$patientid,$appPaymentId->Id);
                    }
                }
                
                $userName = $data->firstname;
                $formattedDate = date("F d Y", strtotime($appointment_date));
                $formattedTime = date("h:i A", strtotime($from_time));
                $doctordatails = $this->RingCMSModel->getDoctorsDetails($doctor_id);
                $doctorName = $doctordatails->Title." ".$doctordatails->firstName." ".$doctordatails->LastName;
                $tenantdatails = $this->WebserviceModel->getTenantsDetails($location_id);
                $locationName = isset($tenantdatails->TenantName)?$tenantdatails->TenantName:Null;
                $type = "AppointmentBookWithPayment";
                $dataArr = array("userName"=>$userName, "appointmentDate"=>$formattedDate, "appointmentTime"=>$formattedTime, "doctorName"=>$doctorName, "locationName"=>$locationName);
                
                if(isset($data->email) && !empty($data->email)){
                    Utility::callSendMailWithTemplate($data->email,$type,$dataArr);
                }

                // Queue Token Logic
                $token = bin2hex(random_bytes(5));
                $lastQueData = $this->RingCMSModel->getLastQueOfDoctor($doctor_id,$appointment_date);
                if(isset($lastQueData) && !empty($lastQueData)){
                    $lastQueNumber = $lastQueData->TodaySerialNumber + 1;
                }else{
                    $lastQueNumber = 1;
                }
                $queDataArr = array("AppointmentId"=>$BookAppointment->AppointmentId,
                    "PatientId"=>$patientid,
                    "Token"=>$token,
                    "TodaySerialNumber"=>$lastQueNumber,
                    "AppointmentDate"=>$appointment_date,
                    "DoctorId"=>$doctor_id
                );
                $insertQue = $this->RingCMSModel->InsertQuetoken($queDataArr);
                
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $BookAppointment;
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed to insert appointment';
            }
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }

    function SearchPatientForAppointment(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $search_prn = isset($data->prn) ? $data->prn : "NULL";
            if(isset($data->mobile_number) && !empty($data->mobile_number)){
                $search_mobile = $this->encryptDecrypt("en", $data->mobile_number);
            } else {
                $search_mobile = "NULL";
            }
            if(isset($data->IdentityNo) && !empty($data->IdentityNo)){
                $search_identity = $this->encryptDecrypt("en", $data->IdentityNo);
            } else {
                $search_identity = "NULL";
            }
            if(isset($data->firstname) && !empty($data->firstname)){
                $search_name = $this->encryptDecrypt("en", $data->firstname);
            } else {
                $search_name = "NULL";
            }

            $foundPatientId = $this->RingCMSModel->findPatientByDetails2($search_prn, $search_identity, $search_name, $search_mobile);
            if($foundPatientId)
            {
                foreach($foundPatientId as &$Val){
                    if(isset($Val->FullName) && !empty($Val->FullName)){
                        $Val->FullName = $this->encryptDecrypt("dc",$Val->FullName);
                    }
                    if(isset($Val->LastName) && !empty($Val->LastName)){
                        $Val->LastName = $this->encryptDecrypt("dc",$Val->LastName);
                    }
                    if(isset($Val->Email) && !empty($Val->Email)){
                        $Val->Email = $this->encryptDecrypt("dc",$Val->Email);
                    }
                    if(isset($Val->MobileNumber) && !empty($Val->MobileNumber)){
                        $Val->MobileNumber = $this->encryptDecrypt("dc",$Val->MobileNumber);
                    }
                    if(isset($Val->IdentityNo) && !empty($Val->IdentityNo)){
                        $Val->IdentityNo = $this->encryptDecrypt("dc",$Val->IdentityNo);
                    }
                }
                unset($Val);
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $foundPatientId;
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Not found';
            }
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
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

}
?>