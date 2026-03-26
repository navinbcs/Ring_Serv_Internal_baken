<?php 
date_default_timezone_set('Asia/Kolkata');
class Care_connect extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model(array('WebserviceModel'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
    }
//*********START: WEBSERVICE FOR LOGIN***********************


    // function signUpForCareConnect(){        
    //     $data = json_decode(file_get_contents('php://input'));        
    //     if($data)
    //     {
    //         $mn = $data->mobile_number * 1;
    //         $mobile_number = $this->encryptDecrypt("en",$mn);
    //         $mob_code = str_replace(' ', '', $data->mob_code);
    //         $mobileCodeId = $this->WebserviceModel->getMobileCodeIdFromMobileCode($mob_code);
    //         if($mobileCodeId){
    //             $mobileCodeId1 = $mobileCodeId->ID;
    //         }else{
    //             $mobileCodeId1 = NULL;
    //         }
    //         $email = $this->encryptDecrypt("en",$data->email);
    //         $saveDataArray = array( 
    //                                 "MobileNumber"=>$mobile_number,
    //                                 "Email"=>$email,
    //                                 "MobileCode"=>$mob_code,
    //                                 "MobileCodeId"=>$mobileCodeId1,
    //                                 "InsertDate"=>date("Y-m-d H:i:s")                                    
    //                                 );
    //         $checkData = $this->WebserviceModel->checkDuplicateMobileno($mob_code,$mobile_number,$email);
    //         if($checkData){
    //             $response['response_code'] = '4';
    //             $response['response_message'] = 'Duplicate Mobile Number Or Email ';                
    //         }
    //         else
    //         {
    //             $getData = $this->WebserviceModel->signUp($saveDataArray);
    //             if(true)
    //             {
    //                 $response['response_code'] = '1';
    //                 $response['response_message'] = 'Success';
    //                 $response['Data'] = $getData;
    //             }
    //             else
    //             {
    //                 $response['response_code'] = '2';
    //                 $response['response_message'] = 'Failed';
    //             }
    //         }
    //     }
    //     else
    //     {
    //         $response['response_code'] = '3';
    //         $response['response_message'] = 'Data is Null';
    //     }
    //     echo json_encode($response);exit;
    // }

    function signUpForCareConnect(){        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $mn = $data->mobile_number * 1;
            $mobile_number = $this->encryptDecrypt("en",$mn);
            $firstname = $data->firstname;
            $fullName = $firstname;
            if(isset($fullName) && !empty($fullName)){
                $full_name = $this->encryptDecrypt("en",$fullName);
            }else{
                $full_name = "";
            } 
            if(isset($data->lastname) && !empty($data->lastname)){
                $lastname = $this->encryptDecrypt("en",$data->lastname);
            }else{
                $lastname = "";
            }
            
            $mob_code = str_replace(' ', '', $data->mob_code);
            $mobileCodeId = $this->WebserviceModel->getMobileCodeIdFromMobileCode($mob_code);
            // print_r($mobileCodeId);exit;
            if($mobileCodeId){
                $mobileCodeId1 = $mobileCodeId->ID;
            }else{
                $mobileCodeId1 = NULL;
            }
            $dob = isset($data->DOB)?$data->DOB:NULL;
            if(isset($dob) && !empty($dob)){
                $ts = strtotime($dob);
                $dob1 = date("Y-m-d H:i:s", $ts);
            }else{
                $dob1 = NULL;
            }
            $email = $this->encryptDecrypt("en",$data->email);
            if(isset($data->bloodgroup) && !empty($data->bloodgroup)){
                $BloodGroupId = $data->bloodgroup;
            }else{
				$BloodGroupId = 16;
			}
            if(isset($data->address) && !empty($data->address)){
                $address = urlencode($data->address);
            }else{
                $address = "";
            }
           
            $country = isset($data->country_id)?$data->country_id:NULL;
            $state = isset($data->state_id)?$data->state_id:NULL;
            $city = isset($data->city_id)?$data->city_id:NULL;
            $pincode = isset($data->pin_code)?$data->pin_code:NULL;
            $gender = isset($data->gender)?$data->gender:1;
            $saveDataArray = array( 
                                    "MobileNumber"=>$mobile_number,
                                    "FullName"=>$full_name,
                                    "LastName"=>$lastname,
                                    "Email"=>$email,
                                    "MobileCode"=>$mob_code,
                                    "BloodGroupId"=>$BloodGroupId,
                                    "Address"=>$address,
                                    "CountryMasterId"=>$country,
                                    "StateMasterId"=>$state,
                                    "CityMasterId"=>$city,
                                    "PinCode"=>$pincode,
                                    "DateOfBirth"=>$dob1,
                                    "GenderId"=>$gender,
                                    "MobileCodeId"=>$mobileCodeId1,
                                    "InsertDate"=>date("Y-m-d H:i:s")                                    
                                    );
                                  // print_r($saveDataArray);exit;
            $checkData = $this->WebserviceModel->checkDuplicateMobileno($mob_code,$mobile_number,$email);
            if($checkData){
                $response['response_code'] = '4';
                $response['response_message'] = 'Duplicate Mobile Number Or Email ';                
            }
            else
            {
                $getData = $this->WebserviceModel->signUp($saveDataArray);
                if(true)
                {
                    $type = "signUpCareConnect";
                    $dataArr = array("name"=>"");
                    $sendMail = Utility::callSendMailWithTemplate($data->email,$type,$dataArr);
                    $response['response_code'] = '1';
                    $response['response_message'] = 'Success';
                    $response['Data'] = $getData;
                }
                else
                {
                    $response['response_code'] = '2';
                    $response['response_message'] = 'Failed';
                }
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

    function getPatientInformation(){ 
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $PatientId = $data->PatientId;
            $PatientData =  $this->WebserviceModel->getUserDataById($PatientId);                                         
            if($PatientData)             
            {
                // print_r($PatientData);exit;
                if(isset($PatientData->FullName) && ($PatientData->FullName != NULL) && isset($PatientData->LastName) && !empty($PatientData->LastName) && isset($PatientData->DateOfBirth) && isset($PatientData->GenderId)){
                    $response['response_code']=4;
                    $response['response_message']='No need Update';
                    $response['user_data']=$PatientData;
                }else{
                    $response['response_code']=1;
                    $response['response_message']='Need Update';
                    $response['user_data']=$PatientData;
                }
                
            }
            else 
            {
                $response["response_code"] = 2;
                $response["response_message"] = "Failed";
            } 
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }      
        echo json_encode($response); exit;    
    }

    public function updatePatientDataForCareConnect(){
        $data = json_decode(file_get_contents('php://input'));
        if($data)
        {
            $user_id = $data->PatientId;
            $BloodGroupId = $data->bloodgroup;        
            // $mn = $data->mobile_number * 1;
            // $mobile_number = $this->encryptDecrypt("en",$mn);
            $firstname = $data->firstname;     
            $lastname =$this->encryptDecrypt("en",$data->lastname);
            $fullName = $firstname;
            $full_name = $this->encryptDecrypt("en",$fullName);
            // $email = $this->encryptDecrypt("en",$data->email);
            $gender = isset($data->gender)?$data->gender:NULL;
            $country = isset($data->country_id)?$data->country_id:NULL;
            $state = isset($data->state_id)?$data->state_id:NULL;
            $city = isset($data->city_id)?$data->city_id:NULL;
            $dob = isset($data->DOB)?$data->DOB:NULL;
            if(isset($dob) && !empty($dob)){
            $ts = strtotime($dob);
            $dob1 = date("Y-m-d H:i:s", $ts);
            }else{
            $dob1 = NULL;
            }
            $address = isset($data->address)?$data->address:NULL;
            if(!empty($address)){
                $Add = urlencode($address);
            }else{
                $Add = NULL;
            }
            $IdentificationType = isset($data->IdentificationType)?$data->IdentificationType:NULL;
            $IdentificationNumber = isset($data->IdentificationNumber)?$data->IdentificationNumber:NULL;
            if(!empty($IdentificationType) && !empty($IdentificationNumber)){
                $IdentificationNumber = $this->encryptDecrypt("en",$data->IdentificationNumber);
            }
            $saveDataArray = array(                                 
                                // "MobileNumber"=>$mobile_number,
                                "FullName"=>$full_name,
                                "LastName"=>$lastname,
                                // "Email"=>$email,
                                // "MobileCode"=>$data->mob_code,
                                "CountryMasterId"=>$country,
                                "StateMasterId"=>$state,
                                "CityMasterId"=>$city,
                                "Address"=>$Add,
                                "BloodGroupId"=>$BloodGroupId,            
                                "DateOfBirth"=>$dob1,          
                                "IdentificationTypeId"=>$IdentificationType,          
                                "IdentityNo"=>$IdentificationNumber,
                                "GenderId"=>$gender,
                                "UpdateDate"=>date("Y-m-d H:i:s")                               
                                );
            $result1 = $this->WebserviceModel->updateUserData($saveDataArray,$user_id);                  
            if($result1)             
            {
                $response['response_code']=1;
                $response['response_message']='Success';
                $response['response_data']=$result1;
            }
            else
            {
                $response['response_code']=2;
                $response['response_message']='Failed';           
            }  
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }      
        echo json_encode($response); exit;
    }

    public function saveDoctorDetailsOnRingServer(){	
		$data = json_decode(file_get_contents('php://input'));
		if($data)
		{
			
            $Action = $data->Action;
            if($Action === "AddDoctor"){
            // echo "<pre>"; print_r($data);exit;
                $hospitalDetails = $data->HospitalDetails;
                // echo "<pre>"; print_r($hospitalDetails);exit;
                $locationId = $hospitalDetails[0]->LocationId;
                $hospitalName = $hospitalDetails[0]->HospitalName;
                $mmcn = $data->DoctorMMCN;
                $doctorId = $data->DoctorCMSId;
                $ImplementationId = $data->ImplementationId;
                $IsScheduled = $hospitalDetails[0]->IsScheduled;
                $url1 = 'https://sitiring.sancyberhad.com:6004//index.php/Api/GetCMSDoctorDetails';
                        $json1 = '{"UserId": "'.$doctorId.'"}';   
                        $headers1 = array('Content-Type: application/json');
                        $curl1 = curl_init();
                        curl_setopt_array($curl1, array(
                        CURLOPT_URL => $url1,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $json1,
                        CURLOPT_HTTPHEADER => $headers1,
                        ));
                        $res1 = curl_exec($curl1);
                        if (curl_errno($curl1)) {
                            $error_msg1 = curl_error($curl1);
                            echo $error_msg1;
                        }
                        curl_close($curl1);
                $docdetail = json_decode($res1);
                $doctorCmsdetail = $docdetail->data;
                $chkDoctor = $this->WebserviceModel->doctorSearch($mmcn); // Check doctor avl in ring db
                $HospitalRingId = $this->WebserviceModel->tenantsSearchDataByKeywordsNew($hospitalName); //find doctor associated hospital
                if(isset($chkDoctor) && isset($HospitalRingId))
                {
                    $insertIntArr = array("ImplementationId"=>1,
                                    "LocationId"=>$locationId,
                                    "CmsDoctorId"=>$doctorId,
                                    "RingDoctorId"=>$chkDoctor->UserId,
                                    "TenantId"=>$HospitalRingId->TenantId,
                                    "Scheduled"=>1
                                );
                    $chkImpExist = $this->WebserviceModel->chkImpExist($doctorId,$locationId);
                    if(!isset($chkImpExist) && empty($chkImpExist)){
                        $updateIntTable = $this->WebserviceModel->DoctorImpData($insertIntArr);
                    }
                    $ResultDocId = $chkDoctor->UserId;
                    // $response['response_code'] = 1;
                    // $response['response_data'] = $chkDoctor->UserId;
                    // $response['response_message'] = 'Doctor saved successfully';
                    
                }
                else
                {
                    $PhoneNumber = isset($data->PhoneNumber)?$data->PhoneNumber:NULL; 
                    // $PhoneCode = isset($data->PhoneCode)?$data->PhoneCode:NULL; 
                    if(isset($data->PhoneCode) && !empty($data->PhoneCode)){
                        $PhoneCode = "+".$data->PhoneCode;
                    }else{
                        $PhoneCode = NULL; 
                    }
                    //$speciality = isset($data->Speciality)?$data->Speciality:NULL; 
                    // if(empty($data->Speciality) || !isset($data->Speciality)){
                    //     $speciality = 0;
                    //     }else{
                    //         $specialityData = $this->WebserviceModel->searchIdOfGivenString($data->Speciality,"PractitionerSpecialityMaster","SpecialityDescription");
                    //         if(isset($specialityData) && !empty($specialityData)){
                    //             $speciality = $specialityData->ID;
                    //         }else{
                    //             $speciality = 1;
                    //         }
                    //     }

                    if(isset($data->Speciality) && !empty($data->Speciality)){
                        if($data->Speciality == "General practitioner"){
                            $speciality = 18;
                        }else if($data->Speciality == "Dentist"){
                            $speciality = 49;
                        }else if($data->Speciality == "Pediatrician"){
                            $speciality = 8;
                        }else if($data->Speciality == "Obstetrics & Gynaecology (O&G)"){
                            $speciality = 9;
                        }else if($data->Speciality == "Aesthetic"){
                            $speciality = 50;
                        }else if($data->Speciality == "Dietitian"){
                            $speciality = 17;
                        }
                    }else{
                        $speciality = 0;
                    }
                    $email = isset($data->EmailID)?$data->EmailID:NULL; 
                    $fname = isset($data->FirstName)?$data->FirstName:NULL;
                    $lname = isset($data->LastName)?$data->LastName:NULL;
                    $user = $fname." ".$lname;
                    $mmcnumber = isset($mmcn)?$mmcn:NULL;
                    // $Password = isset($data->Password)?$data->Password:12345678;
                    if(isset($data->Password) && !empty($data->Password)){
                        $Password = $data->Password;
                    }else{
                        $Password = 12345678; 
                    }
                    $username = isset($user)?$user:NULL;
                    $TenantNumber = $hospitalDetails[0]->HospitalNumber;
                    $TenantAddress = $hospitalDetails[0]->HospitalAddress;
                    $TenantFaxNumber = $hospitalDetails[0]->HospitalFaxNumber;
                    $TenantPhoneCodeDigit = $hospitalDetails[0]->HospitalPhoneCode;
                    $GetPhCodeId = $this->WebserviceModel->getPhoneCodeId($TenantPhoneCodeDigit);
                    if(isset($GetPhCodeId)){
                        $TenantPhoneCode = $GetPhCodeId->ID;
                    }else{
                        $TenantPhoneCode = null;
                    }
                    // print_r($TenantPhoneCode);exit;
                    $TenantPhoneNumber = $hospitalDetails[0]->HospitalPhoneNumber;
                    $TenantName = $hospitalDetails[0]->HospitalName;
                    $TenantPostCode = $hospitalDetails[0]->HospitalPostCode;
                    $TenantCountry = isset($hospitalDetails[0]->HospitalCountry)?$hospitalDetails[0]->HospitalCountry:0;
                    $TenantState = isset($hospitalDetails[0]->HospitalState)?$hospitalDetails[0]->HospitalState:0;
                    $TenantCity = isset($hospitalDetails[0]->HospitalCity)?$hospitalDetails[0]->HospitalCity:0;
                    if(empty($hospitalDetails[0]->HospitalCountry) || !isset($hospitalDetails[0]->HospitalCountry)){
                    $country = 0;
                    }else{
                        $countrydata = $this->WebserviceModel->searchIdOfGivenString($hospitalDetails[0]->HospitalCountry,"CountryMaster","CountryDescription");
                        if(isset($countrydata) && !empty($countrydata)){
                            $country = $countrydata->ID;
                        }else{
                            $country = 0;
                        }
                    }
        
                    if(empty($hospitalDetails[0]->HospitalState) || !isset($hospitalDetails[0]->HospitalState)){
                        $state = 0;
                    }else{
                        $statedata = $this->WebserviceModel->searchIdOfGivenString($hospitalDetails[0]->HospitalState,"StateMaster","StateDescription");
                        if(isset($statedata) && !empty($statedata)){
                            $state = $statedata->ID;
                        }else{
                            $state = 0;
                        }
                    }
                    
                    if(empty($hospitalDetails[0]->HospitalCity) || !isset($hospitalDetails[0]->HospitalCity)){
                        $city = 0;
                    }else{
                        $citydata = $this->WebserviceModel->searchIdOfGivenString($hospitalDetails[0]->HospitalCity,"CityMaster","CityDescription");
                        if(isset($citydata) && !empty($citydata)){
                            $city = $citydata->ID;
                        }else{
                            $city = 0;
                        }
                    }

                    if(empty($doctorCmsdetail->sirname) || !isset($doctorCmsdetail->sirname)){
                        $PrefixId = null;
                    }else{
                        $sirnamedata = $this->WebserviceModel->searchIdOfGivenString($doctorCmsdetail->sirname,"HonorificMaster","Description");
                        if(isset($sirnamedata) && !empty($sirnamedata)){
                            $PrefixId = $sirnamedata->id;
                        }else{
                            $PrefixId = null;
                        }
                    }

                    if(!empty($doctorCmsdetail->genderid) || isset($doctorCmsdetail->genderid)){
                        $genderid = $doctorCmsdetail->genderid;
                    }else{
                        $genderid = null;
                    }

                    $IsScheduled = $hospitalDetails[0]->IsScheduled;
                    $sitiUserName = "CC".$doctorId;
                    $paramJson = '{
                        "PhoneNumber": "'.$PhoneNumber.'",
                        "FacilityTypeId": "2",
                        "TenantCompanyNumber": "'.$TenantNumber.'",
                        "TenantAddress":"'.$TenantAddress.'",
                        "TenantFaxNumber":"'.$TenantFaxNumber.'",
                        "speciality":"'.$speciality.'",
                        "Role": "12",
                        "TenantName":"'.$TenantName.'",
                        "TenantPhoneNumber":"'.$TenantPhoneNumber.'",
                        "email":"'.$email.'",
                        "name":"'.$fname.'",
                        "mmcnumber":"'.$mmcnumber.'",
                        "password":"'.$Password.'",
                        "username":"'.$sitiUserName.'",
                        "TenantCountry":"'.$country.'",
                        "TenantState": "'.$state.'",
                        "TenantCity":"'.$city.'",
                        "TenantPin": "'.$TenantPostCode.'",
                        "TenantPhoneCode": "'.$TenantPhoneCode.'",
                        "PhoneCode":"'.$TenantPhoneCode.'",                       
                        "DisplayName":"'.$fname.'",
                        "GenderId":"'.$genderid.'",
                        "HonorficMasterId":"'.$PrefixId.'",
                        "LastName":"'.$lname.'"
                        }';
                        
                        
                    $url = 'https://internalapi.ring.healthcare/api/Register/IntegrateRegisterDoctor';
                    $json = $paramJson;   
                    // echo $json;exit;
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
                    echo $res;
                    if($res == '{}'){
                        $insert_id = $this->WebserviceModel->lastInstertedId();
                        $insertIntArr = array("ImplementationId"=>"1",
                                "LocationId"=>$locationId,
                                "CmsDoctorId"=>$doctorId,
                                "RingDoctorId"=>$insert_id->UserId,
                                "TenantId"=>$insert_id->TenantId,
                                "Scheduled"=>1
                            );
                        $chkImpExist = $this->WebserviceModel->chkImpExist($doctorId,$locationId);

                        if(!isset($chkImpExist) && empty($chkImpExist)){
                            $updateIntTable = $this->WebserviceModel->DoctorImpData($insertIntArr);
                        }	

                        
                        // $response['response_code'] = 1;
                        // $response['response_data'] = $insert_id->UserId;
                        // $response['response_message'] = 'Doctor saved successfully';		
                        $ResultDocId = $insert_id->UserId;	
                    }
                               
                }
                if($ResultDocId){
                    foreach($hospitalDetails as $hospitalDetailsVal){
                        $locationId1 = $hospitalDetailsVal->LocationId;
                        $hospitalName1 = $hospitalDetailsVal->HospitalName;
                        $HospitalRingId1 = $this->WebserviceModel->tenantsSearchDataByKeywordsNew($hospitalName1);
                        $DocRingId = $ResultDocId;
                        if($HospitalRingId1){
                            $insertIntArr1 = array("ImplementationId"=>$ImplementationId,
                                "LocationId"=>$locationId,
                                "CmsDoctorId"=>$doctorId,
                                "RingDoctorId"=>$DocRingId,
                                "TenantId"=>$HospitalRingId1->TenantId,
                                "Scheduled"=>1
                            );
                            $chkImpExist1 = $this->WebserviceModel->chkImpExist($doctorId,$locationId1);
                            if(!isset($chkImpExist1) && empty($chkImpExist1)){
                                $updateIntTable = $this->WebserviceModel->DoctorImpData($insertIntArr1);
                            }
                            $chkUserTenant = $this->WebserviceModel->chkUserTenant($DocRingId,$HospitalRingId1->TenantId);
                            if(!isset($chkUserTenant) && empty($chkUserTenant)){
                                $userTenantArr = array("UserId"=>$DocRingId,
                                    "TenantId"=>$HospitalRingId1->TenantId
                                );
                                $InsertUserTenant = $this->WebserviceModel->InsertUserTenant($userTenantArr);
                            }
                        }else{
                            $TenantNumber1 = $hospitalDetailsVal->HospitalNumber;
                            $TenantAddress1 = $hospitalDetailsVal->HospitalAddress;
                            $TenantFaxNumber1 = $hospitalDetailsVal->HospitalFaxNumber;
                            $TenantPhoneCodeDigit1 = $hospitalDetailsVal->HospitalPhoneCode;
                            $GetPhCodeId = $this->WebserviceModel->getPhoneCodeId($TenantPhoneCodeDigit1);
                            if(isset($GetPhCodeId)){
                                $TenantPhoneCode1 = $GetPhCodeId->ID;
                            }else{
                                $TenantPhoneCode1 = null;
                            }
                            $TenantPhoneNumber1 = $hospitalDetailsVal->HospitalPhoneNumber;
                            $TenantName1 = $hospitalDetailsVal->HospitalName;
                            $TenantPostCode1 = $hospitalDetailsVal->HospitalPostCode;
                            if(empty($hospitalDetailsVal->HospitalCountry) || !isset($hospitalDetailsVal->HospitalCountry)){
                                $country1 = 0;
                            }else{
                                $countrydata1 = $this->WebserviceModel->searchIdOfGivenString($hospitalDetailsVal->HospitalCountry,"CountryMaster","CountryDescription");
                                if(isset($countrydata1) && !empty($countrydata1)){
                                    $country1 = $countrydata1->ID;
                                }else{
                                    $country1 = 0;
                                }
                            }
                
                            if(empty($hospitalDetailsVal->HospitalState) || !isset($hospitalDetailsVal->HospitalState)){
                                $state1 = 0;
                            }else{
                                $statedata1 = $this->WebserviceModel->searchIdOfGivenString($hospitalDetailsVal->HospitalState,"StateMaster","StateDescription");
                                if(isset($statedata) && !empty($statedata)){
                                    $state1 = $statedata1->ID;
                                }else{
                                    $state1 = 0;
                                }
                            }
                            
                            if(empty($hospitalDetailsVal->HospitalCity) || !isset($hospitalDetailsVal->HospitalCity)){
                                $cit1y = 0;
                            }else{
                                $citydata1 = $this->WebserviceModel->searchIdOfGivenString($hospitalDetailsVal->HospitalCity,"CityMaster","CityDescription");
                                if(isset($citydata1) && !empty($citydata1)){
                                    $city1 = $citydata1->ID;
                                }else{
                                    $city1 = 0;
                                }
                            }
                            $TenantLatitude = $hospitalDetailsVal->HospitalLatitude;
                            $TenantLongitude = $hospitalDetailsVal->HospitalLongitude;
                            $HosInsertArr1 = array("TenantCode"=>$TenantNumber1,
                                "TenantNumber"=>$TenantNumber1,
                                "TenantName"=>$TenantName1,
                                "TenantTypeId"=>2,
                                "PhoneNumber"=>$TenantPhoneNumber1,
                                "Address"=>$TenantAddress1,
                                "CountryID"=>$country1,
                                "StateID"=>$state1,
                                "CityID"=>$city1,
                                "PostCode"=>$TenantPostCode1,
                                "Latitude"=>$TenantLatitude1,
                                "Longitude"=>$TenantLongitude,
                                "IsActive"=>1,
                                "PhoneCode"=>$TenantPhoneCode1
                            );

                            $InsertHospitalData1 = $this->WebserviceModel->InsertHospitalData($HosInsertArr1); 
                            if($InsertHospitalData1){
                                $insertIntArr1 = array("ImplementationId"=>$ImplementationId,
                                    "LocationId"=>$locationId1,
                                    "CmsDoctorId"=>$doctorId,
                                    "RingDoctorId"=>$DocRingId,
                                    "TenantId"=>$InsertHospitalData1,
                                    "Scheduled"=>1
                                );
                                $chkImpExist1 = $this->WebserviceModel->chkImpExist($doctorId,$locationId1);
                                if(!isset($chkImpExist1) && empty($chkImpExist1)){
                                    $updateIntTable = $this->WebserviceModel->DoctorImpData($insertIntArr1);
                                }
                                $chkUserTenant = $this->WebserviceModel->chkUserTenant($DocRingId,$HospitalRingId1->TenantId);
                                if(!isset($chkUserTenant) && empty($chkUserTenant)){
                                    $userTenantArr1 = array("UserId"=>$DocRingId,
                                        "TenantId"=>$InsertHospitalData1
                                    );
                                    $InsertUserTenant = $this->WebserviceModel->InsertUserTenant($userTenantArr1);
                                }
                            }
                        }
                    }
                    $response['response_code'] = 1;
                    $response['response_data'] = $ResultDocId;
                    $response['response_message'] = 'Doctor saved successfully';            
                }
                else{
                    $response['response_code']=2;
                    $response['response_message']='Failed';
                }
            }else if($Action === "UpdateDoctor"){
                $doctorId = $data->DoctorCMSId;
                $ImpId = $data->ImplementationId;
                $HospitalDetailsArr = $data->HospitalDetails;
                $chkDoctorImp = $this->WebserviceModel->chkDoctorImp($doctorId,$ImpId);
                // print_r($chkDoctorImp);exit;
                if(isset($chkDoctorImp) && !empty($chkDoctorImp)){
                    $DocRingId = $chkDoctorImp->RingDoctorId;
                    $PhoneNumber = $data->PhoneNumber; 
                    $PhoneCode = "+".$data->PhoneCode;
                    $email = $data->EmailID; 
                    $fname = $data->FirstName;
                    $lname = $data->LastName;
                    $user = $fname." ".$lname;
                    $mmcn = $data->DoctorMMCN;
                    $IsScheduled = $data->IsScheduled;
                    $updateArr = array("Username"=>"SITI".$doctorId,
                        "Email"=>$email,
                        "PhoneNumber"=>$PhoneNumber,
                        "PhoneCode"=>$PhoneCode,
                        "MMCNumber"=>$mmcn,
                        "DisplayName"=>$fname,
                        "LastName"=>$lname
                    );
                    $updateArr1 = array("PractitionerName"=>$user,
                        "Email"=>$email,
                        "Mobile"=>$PhoneNumber,
                        "MMCNumber"=>$mmcn
                    );
                    // print_r($updateArr);exit;
                    $updateUserTable = $this->WebserviceModel->updateUserTable($DocRingId,$updateArr);   
                    if($updateUserTable){
                        $getPracId = $this->WebserviceModel->getPractitionerId($DocRingId);
                        $updatePractitionerTable = $this->WebserviceModel->updatePractitionerTable($getPracId->LinkUserId,$updateArr1);                       
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Doctor updated successfully';			
                    }else{
                        $response['response_code']=2;
                        $response['response_message']='Failed';
                    }
                }else
                {
                    $response['response_code']=4;
                    $response['response_message']='Doctor not found';
                }
            }else if($Action === "DeactivateDoctor"){
                $doctorId = $data->DoctorCMSId;
                $ImpId = $data->ImplementationId;
                // $LocationId = isset($data->LocationId)?$data->LocationId:1;
                $chkDoctorImp = $this->WebserviceModel->chkImpAvlByDoctorId($doctorId);
                // print_r($chkDoctorImp);exit;
                if($chkDoctorImp){
                    // $deleteImpData = $this->WebserviceModel->deleteImpData($doctorId,$LocationId);
                    $userUpdateArr = array("IsActive"=>0, "IsDeleted"=>1);
                    $updateInUserTable = $this->WebserviceModel->updateInUserTable($chkDoctorImp[0]->RingDoctorId,$userUpdateArr);
                    if($updateInUserTable){
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Doctor Deactivate successfully';			
                    }else{
                        $response['response_code']=2;
                        $response['response_message']='Failed';
                    }
                }
                else
                {
                    $response['response_code']=4;
                    $response['response_message']='Doctor not found';
                }

            }else if($Action === "ReactivateDoctor"){
                $doctorId = $data->DoctorCMSId;
                $ImpId = $data->ImplementationId;
                // $LocationId = isset($data->LocationId)?$data->LocationId:1;
                $chkDoctorImp = $this->WebserviceModel->chkImpAvlByDoctorId($doctorId);
                if($chkDoctorImp){
                    // $deleteImpData = $this->WebserviceModel->deleteImpData($doctorId,$LocationId);
                    $userUpdateArr = array("IsActive"=>1, "IsDeleted"=>0);
                    $updateInUserTable = $this->WebserviceModel->updateInUserTable($chkDoctorImp[0]->RingDoctorId,$userUpdateArr);
                    if($updateInUserTable){
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Doctor Activate successfully';			
                    }else{
                        $response['response_code']=2;
                        $response['response_message']='Failed';
                    }
                }
                else
                {
                    $response['response_code']=4;
                    $response['response_message']='Doctor not found';
                }
            }else if($Action === "ScheduleChange"){
                $doctorId = $data->DoctorCMSId;
                $ImpId = $data->ImplementationId;
                $LocationId = $data->LocationId;
                $IsScheduled = $data->IsScheduled;
                // $chkDoctorImp = $this->WebserviceModel->chkDoctorImp($doctorId,$ImpId);
                // if($chkDoctorImp){
                //     $updateArr = array("Scheduled"=>$IsScheduled);
                //     $updateDocSchedule = $this->WebserviceModel->updateDocSchedule($doctorId,$LocationId,$updateArr);   
                //     if($updateDocSchedule){
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Doctor Schedule updated successfully';			
                //     }else{
                //         $response['response_code']=2;
                //         $response['response_message']='Failed';
                //     }
                // }    

            }else if($Action === "AddLocation"){
                $locationId = $data->LocationId;
                $hospitalName = $data->HospitalName;
                $doctorId = $data->DoctorCMSId;
                $ImplementationId = $data->ImplementationId;
                $HospitalRingId = $this->WebserviceModel->tenantsSearchDataByKeywordsNew($hospitalName);
                $chkDoctorImp = $this->WebserviceModel->chkDoctorImp($doctorId,$ImpId);
                $DocRingId = $chkDoctorImp->RingDoctorId;
                if($HospitalRingId){
                    $insertIntArr = array("ImplementationId"=>$ImplementationId,
                        "LocationId"=>$locationId,
                        "CmsDoctorId"=>$doctorId,
                        "RingDoctorId"=>$DocRingId,
                        "TenantId"=>$HospitalRingId->TenantId,
                        "Scheduled"=>$IsScheduled
                    );
                    $chkImpExist = $this->WebserviceModel->chkImpExist($doctorId,$locationId);
                    if(!isset($chkImpExist) && empty($chkImpExist)){
                        $updateIntTable = $this->WebserviceModel->DoctorImpData($insertIntArr);
                    }
                    $response['response_code'] = 1;
                    $response['response_message'] = 'Location added successfully';
                }else{
                    $TenantNumber = $data->HospitalNumber;
                    $TenantAddress = $data->HospitalAddress;
                    $TenantFaxNumber = $data->HospitalFaxNumber;
                    $TenantPhoneCodeDigit = $data->HospitalPhoneCode;
                    $GetPhCodeId = $this->WebserviceModel->getPhoneCodeId($TenantPhoneCodeDigit);
                    if(isset($GetPhCodeId)){
                        $TenantPhoneCode = $GetPhCodeId->ID;
                    }else{
                        $TenantPhoneCode = null;
                    }
                    $TenantPhoneNumber = $data->HospitalPhoneNumber;
                    $TenantName = $data->HospitalName;
                    $TenantPostCode = $data->HospitalPostCode;
                    if(empty($data->HospitalCountry) || !isset($data->HospitalCountry)){
                        $country = 0;
                    }else{
                        $countrydata = $this->WebserviceModel->searchIdOfGivenString($data->HospitalCountry,"CountryMaster","CountryDescription");
                        if(isset($countrydata) && !empty($countrydata)){
                            $country = $countrydata->ID;
                        }else{
                            $country = 0;
                        }
                    }
        
                    if(empty($data->HospitalState) || !isset($data->HospitalState)){
                        $state = 0;
                    }else{
                        $statedata = $this->WebserviceModel->searchIdOfGivenString($data->HospitalState,"StateMaster","StateDescription");
                        if(isset($statedata) && !empty($statedata)){
                            $state = $statedata->ID;
                        }else{
                            $state = 0;
                        }
                    }
                    
                    if(empty($data->HospitalCity) || !isset($data->HospitalCity)){
                        $city = 0;
                    }else{
                        $citydata = $this->WebserviceModel->searchIdOfGivenString($data->HospitalCity,"CityMaster","CityDescription");
                        if(isset($citydata) && !empty($citydata)){
                            $city = $citydata->ID;
                        }else{
                            $city = 0;
                        }
                    }
                    $TenantLatitude = $data->HospitalLatitude;
                    $TenantLongitude = $data->HospitalLongitude;
                    $HosInsertArr = array("TenantCode"=>$TenantNumber,
                        "TenantNumber"=>$TenantNumber,
                        "TenantName"=>$TenantName,
                        "TenantTypeId"=>2,
                        "PhoneNumber"=>$TenantPhoneNumber,
                        "Address"=>$TenantAddress,
                        "CountryID"=>$country,
                        "StateID"=>$state,
                        "CityID"=>$city,
                        "PostCode"=>$TenantPostCode,
                        "Latitude"=>$TenantLatitude,
                        "Longitude"=>$TenantLongitude,
                        "IsActive"=>1,
                        "PhoneCode"=>$TenantPhoneCode
                    );

                   $InsertHospitalData = $this->WebserviceModel->InsertHospitalData($HosInsertArr); 
                   if($InsertHospitalData){
                        $insertIntArr = array("ImplementationId"=>$ImplementationId,
                            "LocationId"=>$locationId,
                            "CmsDoctorId"=>$doctorId,
                            "RingDoctorId"=>$DocRingId,
                            "TenantId"=>$InsertHospitalData,
                            "Scheduled"=>$IsScheduled
                        );
                        $chkImpExist = $this->WebserviceModel->chkImpExist($doctorId,$locationId);
                        if(!isset($chkImpExist) && empty($chkImpExist)){
                            $updateIntTable = $this->WebserviceModel->DoctorImpData($insertIntArr);
                        }
                        $userTenantArr = array("UserId"=>$DocRingId,
                            "TenantId"=>$InsertHospitalData
                        );
                        $InsertUserTenant = $this->WebserviceModel->InsertUserTenant($userTenantArr); 
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Location added successfully';
                   }else{
                        $response['response_code']=2;
                        $response['response_message']='Failed';
                    }
                }
                	

            }else if($Action === "UpdateLocation"){
                $doctorId = $data->DoctorCMSId;
                $hospitalName = $data->HospitalName;
                $TenantNumber = $data->HospitalNumber;
                $TenantAddress = $data->HospitalAddress;
                $TenantFaxNumber = $data->HospitalFaxNumber;
                $TenantPhoneCode = $data->HospitalPhoneCode;
                $TenantPhoneNumber = $data->HospitalPhoneNumber;
                $TenantName = $data->HospitalName;
                $TenantPostCode = $data->HospitalPostCode;
                if(empty($data->HospitalCountry) || !isset($data->HospitalCountry)){
                    $country = 0;
                }else{
                    $countrydata = $this->WebserviceModel->searchIdOfGivenString($data->HospitalCountry,"CountryMaster","CountryDescription");
                    if(isset($countrydata) && !empty($countrydata)){
                        $country = $countrydata->ID;
                    }else{
                        $country = 0;
                    }
                }
    
                if(empty($data->HospitalState) || !isset($data->HospitalState)){
                    $state = 0;
                }else{
                    $statedata = $this->WebserviceModel->searchIdOfGivenString($data->HospitalState,"StateMaster","StateDescription");
                    if(isset($statedata) && !empty($statedata)){
                        $state = $statedata->ID;
                    }else{
                        $state = 0;
                    }
                }
                
                if(empty($data->HospitalCity) || !isset($data->HospitalCity)){
                    $city = 0;
                }else{
                    $citydata = $this->WebserviceModel->searchIdOfGivenString($data->HospitalCity,"CityMaster","CityDescription");
                    if(isset($citydata) && !empty($citydata)){
                        $city = $citydata->ID;
                    }else{
                        $city = 0;
                    }
                }
                $TenantLatitude = $data->HospitalLatitude;
                $TenantLongitude = $data->HospitalLongitude;
                $HosUpdateArr = array("TenantCode"=>$TenantNumber,
                    "TenantNumber"=>$TenantNumber,
                    "TenantName"=>$TenantName,
                    "TenantTypeId"=>2,
                    "PhoneNumber"=>$TenantPhoneNumber,
                    "Address"=>$TenantAddress,
                    "CountryID"=>$country,
                    "StateID"=>$state,
                    "CityID"=>$city,
                    "PostCode"=>$TenantPostCode,
                    "Latitude"=>$TenantLatitude,
                    "Longitude"=>$TenantLongitude,
                    "IsActive"=>1,
                    "PhoneCode"=>$TenantPhoneCode
                );               
                $HospitalRingId = $this->WebserviceModel->tenantsSearchDataByKeywordsNew($hospitalName);
                if($HospitalRingId){
                    $UpdateHospitalData = $this->WebserviceModel->UpdateHospitalData($HospitalRingId,$HosUpdateArr);
                    if($UpdateHospitalData){
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Location update successfully';
                    }else{
                        $response['response_code']=2;
                        $response['response_message']='Failed';
                    }
                }else{
                    $response['response_code']=4;
                    $response['response_message']='Hospital not found';
                }
                
            }else if($Action === "DeleteLocation"){
                $locationId = $data->LocationId;
                $ImpId = $data->ImplementationId;
                $doctorId = $data->DoctorCMSId;
                $chkLocationImp = $this->WebserviceModel->chkLocationImp($locationId,$ImpId);
                if($chkLocationImp){
                    $deleteLocData = $this->WebserviceModel->deleteLocData($locationId,$ImpId);
                    if($deleteLocData){
                        $response['response_code'] = 1;
                        $response['response_message'] = 'Location Deleted successfully';			
                    }else{
                        $response['response_code']=2;
                        $response['response_message']='Failed';
                    }
                }
                else
                {
                    $response['response_code']=4;
                    $response['response_message']='Doctor not found';
                }
            }			
		}
		else
		{
			$response['response_code']=3;
			$response['response_message']='data is null';
		}
		echo json_encode($response);exit;
	}
}