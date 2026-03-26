<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VcodeController extends CI_Controller {

    private $apiKey = 'hSdt20xB.HWLI48Y34eTGwUSaFJFwyaozjShq';
    private $accessToken;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('WebserviceModel'));
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
    }

    public function generate_vcode_fulldata() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            // $username = 'Sancy@vcode.co.uk';
            // $password = '2LwAfR9BePo6';
            //  echo   $this->accessToken = $this->loginAndGetToken($username, $password); exit ;
            // $this->accessToken = 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI2NmJkYWUzMy1kMzE5LTQ1NDktODRhMi0xMmZkNDA4ZmQwODIiLCJyb2xlcyI6W3siYXV0aG9yaXR5IjoicHVibGljIn1dLCJpc3MiOiJ2cGxhdGZvcm0iLCJqdGkiOiIwN2YyMzc0ZS04Nzc1LTQwMmUtOGI0NS01YWY5ZjIwYjc2MGIiLCJpYXQiOjE3NTAzMzI3NTgsImV4cCI6MTc1MDMzMzk1OH0.i-98axG3XBZJg6UMNwpdtSVuIaaSy7hMNIZfK2Aq_bU'; 
            $this->accessToken = $data->accessToken;
            $reportTransitId = $data->reportTransitId;
            $userLat = $data->userLat;
            $userLng = $data->userlng;
            $reportData = $this->WebserviceModel->getRefferedclinicData($reportTransitId);
            $reportData->FullName = $this->encryptDecrypt("dc",$reportData->FullName);    
            $reportData->LastName =$this->encryptDecrypt("dc",$reportData->LastName);
            // print_r($reportData->Longitude);exit;
            // if (!$this->accessToken) {
            if (!isset($this->accessToken)){
                return $this->output->set_output(json_encode(['error' => 'Auth failed']));
            }

            // Create rules
            $rule1 = $this->createRule("Clinic Location", $reportData->Latitude, $reportData->Longitude, $reportTransitId);
            //print_r($rule1);exit;
            $rule2 = $this->createRule($reportData->FullName." Location", $userLat, $userLng, $reportTransitId);
            if (!$rule1 || !$rule2) return $this->output->set_output(json_encode(['error' => 'Rule creation failed']));

            // Create action
            $action = $this->createAction("Open Referral", "https://ring.web.app/referral?id=XYZ123", $reportTransitId);
            if (!$action) return $this->output->set_output(json_encode(['error' => 'Action creation failed']));

            // Create package
            $package = $this->createPackage($reportData->FullName." + Clinic Package", $action, [$rule1, $rule2]);
            if (!$package) return $this->output->set_output(json_encode(['error' => 'Package creation failed']));

            // Create VCode
            $vcode = $this->createVcode("Generated QR", $package);
            if (!$vcode) return $this->output->set_output(json_encode(['error' => 'VCode creation failed']));
            // print_r($vcode); exit;
            // Auto-download QR
            $uti = $vcode['uti'];
            // $qrUrl = "https://api.vplatform.io/vcodes/{$uti}/png";

            // $ch = curl_init($qrUrl);
            // curl_setopt_array($ch, [
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_HTTPHEADER => [
            //         "X-VPLATFORM-API-KEY: {$this->apiKey}",
            //         "Authorization: Bearer {$this->accessToken}"
            //     ]
            // ]);
            // $image = curl_exec($ch);

            //  print_r($image); exit ;
            // curl_close($ch);

            // if ($image) {
            //     $this->output
            //         ->set_content_type('image/png')
            //         ->set_header('Content-Disposition: attachment; filename="vcode_qr.png"')
            //         ->set_output($image);
            // } else {
            //     show_error("QR download failed.");
            // }
            if($vcode)             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['data'] = $vcode;
                //echo json_encode($res);exit;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';    
                //echo json_encode($res);exit;       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
            //echo json_encode($res);exit;
        }
        echo json_encode($res);exit; 
    }

    public function create_vcode_rules_one() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $this->accessToken = $data->accessToken;
            $reportTransitId = $data->reportTransitId;
            $userLat = $data->userLat;
            $userLng = $data->userlng;
            $reportData = $this->WebserviceModel->getRefferedclinicData($reportTransitId);
            $reportData->FullName = $this->encryptDecrypt("dc",$reportData->FullName);   
            if (!isset($this->accessToken)){
                return $this->output->set_output(json_encode(['error' => 'Auth failed']));
            }

            // Create rules
            $rule1 = $this->createRule("Clinic Location", $reportData->Latitude, $reportData->Longitude, $reportTransitId);
            // $rule2 = $this->createRule($reportData->FullName." Location", $userLat, $userLng, $reportTransitId);
            if (!$rule1) return $this->output->set_output(json_encode(['error' => 'Rule creation failed']));
            if(isset($rule1))             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['rule1'] = $rule1;
                // $res['rule2'] = $rule2;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
        }
        echo json_encode($res);exit; 
    }

    public function create_vcode_rules_two() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $this->accessToken = $data->accessToken;
            $reportTransitId = $data->reportTransitId;
            $userLat = $data->userLat;
            $userLng = $data->userlng;
            $reportData = $this->WebserviceModel->getRefferedclinicData($reportTransitId);
            $reportData->FullName = $this->encryptDecrypt("dc",$reportData->FullName);   
            if (!isset($this->accessToken)){
                return $this->output->set_output(json_encode(['error' => 'Auth failed']));
            }

            // Create rules
            // $rule1 = $this->createRule("Clinic Location", $reportData->Latitude, $reportData->Longitude, $reportTransitId);
            $rule2 = $this->createRule($reportData->FullName." Location", $userLat, $userLng, $reportTransitId);
            if (!$rule2) return $this->output->set_output(json_encode(['error' => 'Rule creation failed']));
            if(isset($rule2))             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                // $res['rule1'] = $rule1;
                $res['rule2'] = $rule2;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
        }
        echo json_encode($res);exit; 
    }

    public function create_vcode_action() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $this->accessToken = $data->accessToken;
            $reportTransitId = $data->reportTransitId;
            if (!isset($this->accessToken)){
                return $this->output->set_output(json_encode(['error' => 'Auth failed']));
            }
            $action = $this->createAction("Open Referral", "https://ring.web.app/referral?id=XYZ123", $reportTransitId);
            if (!$action) return $this->output->set_output(json_encode(['error' => 'Action creation failed']));
            if(isset($action))             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['action'] = $action;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
        }
        echo json_encode($res);exit; 
    }

    public function create_vcode_package() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $this->accessToken = $data->accessToken;
            $FullName = $data->fullName;
            $rule1 = $data->rule1;
            $rule2 = $data->rule2;
            $action = $data->action;
            if (!isset($this->accessToken)){
                return $this->output->set_output(json_encode(['error' => 'Auth failed']));
            }
            $package = $this->createPackage($FullName." + Clinic Package", $action, [$rule1, $rule2]);
            if (!$package) return $this->output->set_output(json_encode(['error' => 'Package creation failed']));
            if(isset($package))             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['package'] = $package;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
        }
        echo json_encode($res);exit; 
    }

    public function create_vcode() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $this->accessToken = $data->accessToken;
            $package = $data->package;
            if (!isset($this->accessToken)){
                return $this->output->set_output(json_encode(['error' => 'Auth failed']));
            }
            $vcode = $this->createVcode("Generated QR", $package);
            if (!$vcode) return $this->output->set_output(json_encode(['error' => 'VCode creation failed']));
            // $uti = $vcode['uti'];
            if($vcode)             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['data'] = $vcode;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
        }
        echo json_encode($res);exit; 
    }

    private function loginAndGetToken($email, $password) {
            $ch = curl_init("https://api.vplatform.io/auth/login");
            $headers = [
                "X-VPLATFORM-API-KEY: {$this->apiKey}",
                "Content-Type: application/json",
                "Accept: application/json"
            ];
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER =>$headers,
                CURLOPT_POSTFIELDS => json_encode(["email" => $email, "password" => $password])
            ]);


            
            $response = curl_exec($ch);

            
            curl_close($ch);
            $decoded = json_decode($response, true);
            return $decoded['accessToken'] ?? null;
    }


    private function callApi($url, $data) {
        $headers = [
            "X-VPLATFORM-API-KEY: {$this->apiKey}",
            "Authorization: Bearer {$this->accessToken}",
            "Content-Type: application/json",
            "Accept: application/json"
        ];
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    private function createRule($title, $lat, $lng, $reportTransitId) {
        $data = [
            "title" => $title,
            "reportTransitId" => $reportTransitId,
            "description" => "Geo rule: $title",
            "data" => [
                "type" => "geofence",
                "latitude" => $lat,
                "longitude" => $lng,
                "reportTransitId" => $reportTransitId,
                "radius" => 150
            ]
        ];
        // print_r($data);exit;
        $response = $this->callApi("https://api.vplatform.io/rules", $data);
        //print_r($response);exit;
        return $response['uid'] ?? null;
    }

    private function createAction($title, $url, $reportTransitId) {
        $data = [
            "title" => $title,
            "description" => $reportTransitId,
            "data" => [
                "type" => "url",
                "url" => $url,
                "inapp_browser" => true,
                "append_scandata" => true
            ]
        ];
        $response = $this->callApi("https://api.vplatform.io/actions", $data);
        return $response['uid'] ?? null;
    }

    private function createPackage($title, $actionId, $ruleIds) {
        $data = [
            "title" => $title,
            "description" => "Package with action and rules",
            "actionId" => $actionId,
            "rules" => $ruleIds
        ];
        $response = $this->callApi("https://api.vplatform.io/packages", $data);
        return $response['uid'] ?? null;
    }

    private function createVcode($title, $packageId) {
        $data = [
            "title" => $title,
            "description" => "Generated for full flow",
            "packageIds" => [$packageId],
            "allowAnonymous" => true,
            "appId" => "io.ring.rpa",
            "personalVCode" => false
        ];
        return $this->callApi("https://api.vplatform.io/vcodes", $data);
    }

    public function loginAndGetTokenFromMobile(){
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $email = $data->email;
            $password = $data->password;
            $ch = curl_init("https://api.vplatform.io/auth/login");
            $headers = [
                "X-VPLATFORM-API-KEY: {$this->apiKey}",
                "Content-Type: application/json",
                "Accept: application/json"
            ];
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER =>$headers,
                CURLOPT_POSTFIELDS => json_encode(["email" => $email, "password" => $password])
            ]);           
            $response = curl_exec($ch);           
            curl_close($ch);
            $decoded = json_decode($response, true);
            //print_r($decoded);exit;
            // $decodedRes =  isset($decoded['accessToken'])?$decoded['accessToken']:null;                
            if($decoded)             
            {
                $res['response_code'] =1;
                $res['response_message']='Success';
                $res['data']=$decoded['accessToken'];
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';           
            }       
        }
        else
        {
            $res['response_code']=3;
            $res['response_message']='Data is null'; 
        }        
        echo json_encode($res); exit;

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

    public function generateQRAndDownload() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'));
        if($data){
            $this->accessToken = $data->accessToken;
            $uti = $data->uti;
            $uid = $data->uid;
            $apiKey = 'hSdt20xB.HWLI48Y34eTGwUSaFJFwyaozjShq';
            $qrUrl = "https://api.vplatform.io/vcodes/{$uti}/png";

            $ch = curl_init($qrUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-VPLATFORM-API-KEY: {$apiKey}",
                    "Authorization: Bearer {$this->accessToken}"
                ]
            ]);
            $image = curl_exec($ch);

            // print_r($image); exit ;
            curl_close($ch);
            if ($image) {
                // Set path to save image
                $fileName = 'vcode_qr_' . time() . '.png'; // unique filename
                $savePath = FCPATH . 'upload/qrcodes/' . $fileName; // Full path on server

                // Make sure directory exists
                if (!is_dir(FCPATH . 'upload/qrcodes')) {
                    mkdir(FCPATH . 'upload/qrcodes', 0755, true);
                }

                // Save the image data to file
                file_put_contents($savePath, $image);

                // Build URL to access the image
                $baseUrl = base_url('upload/qrcodes/' . $fileName); // Full URL to access the file

                // Return or echo the URL
                // echo json_encode([
                //     'status' => 'success',
                //     'image_url' => $baseUrl
                // ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Image data is empty'
                ]);
            }
            // else {
            //     show_error("QR download failed.");
            // }
            if($baseUrl)             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['data'] = $baseUrl;
                //echo json_encode($res);exit;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';    
                //echo json_encode($res);exit;       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
            //echo json_encode($res);exit;
        }
        echo json_encode($res);exit; 
    }

    // public function decodeQRImage() {
    //     if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
    //         $data["status"] = "ok";
    //         echo json_encode($data);
    //         exit;
    //     }
    //     if($_FILES){
    //     // print_r($_POST);exit;
    //         $qrImage = $_FILES['file']['tmp_name'];
    //         $qrUrl = "https://imgdecode.vplatform.io/decode";

    //         $curl = curl_init();

    //         curl_setopt_array($curl, array(
    //         CURLOPT_URL => $qrUrl,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($qrImage)),
    //         ));

    //         $response = curl_exec($curl);

    //         curl_close($curl);
    //         $result = json_decode($response, true);
    //         // print_r($result);exit;
    //         $uti = $result['vcodes'][0]['uti'];
    //         // print_r($uti);exit;
    //         if(isset($uti) && !empty($uti)){
    //             $utiDetails = $this->getVcodesList($uti);
    //         }
    //         if($utiDetails)             
    //         {
    //             $rules = $utiDetails[0]['rules'];
    //             // print_r($rules); exit;
    //             $utiDetails[0]['Distances'] = array();
    //             foreach($rules as $ruleVal){
    //                 $distance = $this->calculateDistance($_POST['userLat'], $_POST['userLat'], $ruleVal['data']['latitude'], $ruleVal['data']['longitude'], 'K');
    //                 $distance1 = round($distance, 2) . " km";
    //                 array_push($utiDetails[0]['Distances'],$distance1);
    //             }
    //             $res['response_code'] = 1;
    //             $res['response_message'] = 'Success';
    //             $res['data'] = $utiDetails;
    //             //echo json_encode($res);exit;
    //         }
    //         else
    //         {
    //             $res['response_code']=2;
    //             $res['response_message']='Failed';    
    //             //echo json_encode($res);exit;       
    //         }

    //     }
    //     else
    //     {
    //         $res['response_code'] = '3';
    //         $res['response_message'] = 'Data is Null';
    //         //echo json_encode($res);exit;
    //     }
    //     echo json_encode($res);exit; 
    // }

    // function getVcodesList(){
    function getVcodesList($targetUti){
        $username = 'Sancy@vcode.co.uk';
        $password = '2LwAfR9BePo6';
        $this->accessToken = $this->loginAndGetToken($username, $password);
        $apiKey = 'hSdt20xB.HWLI48Y34eTGwUSaFJFwyaozjShq';
        // $Url = "https://api.vplatform.io/vcodes/".$uti;
        $Url = "https://api.vplatform.io/vcodes/";
        $ch = curl_init($Url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "X-VPLATFORM-API-KEY: {$apiKey}",
                "Authorization: Bearer {$this->accessToken}"
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        //echo "<pre>"; print_r($result);exit;
        // return $result;
        // $targetUti = '03ca0d6414265b01';
        $resArr = array();
        if($result['data']){
            foreach($result['data'] as $val){
                if ($val['uti'] == $targetUti) {
                    // echo "<pre>"; print_r($val);exit;
                    $Url2 = "https://api.vplatform.io/packages/".$val['packageIds'][0];
                    $ch = curl_init($Url2);
                    curl_setopt_array($ch, [
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => [
                            "X-VPLATFORM-API-KEY: {$apiKey}",
                            "Authorization: Bearer {$this->accessToken}"
                        ]
                    ]);
                    $response2 = curl_exec($ch);
                    curl_close($ch);
                    $result2 = json_decode($response2, true);
                    //print_r($result2);exit;
                    array_push($resArr,$result2);
                };
            }
        }
        return $resArr;
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit = 'K') {
        $theta = $lon1 - $lon2;
        $distance = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
                    cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                    cos(deg2rad($theta));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $miles = $distance * 60 * 1.1515;

        // Convert to kilometers or nautical miles
        if ($unit == 'K') {
            return $miles * 1.609344;  // Kilometers
        } elseif ($unit == 'N') {
            return $miles * 0.8684;    // Nautical Miles
        } else {
            return $miles;             // Miles
        }
    }


    public function decodeQRImage() {
        if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        if($_FILES){
            $qrImage = $_FILES['file']['tmp_name'];
            $qrUrl = "https://imgdecode.vplatform.io/decode";
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $qrUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($qrImage)),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($response, true);
            $uti = $result['vcodes'][0];
            if($uti)             
            {
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['response_data'] = $uti;
            }
            else
            {
                $res['response_code']=2;
                $res['response_message']='Failed';       
            }

        }
        else
        {
            $res['response_code'] = '3';
            $res['response_message'] = 'Data is Null';
        }
        echo json_encode($res);exit; 
    }


    public function getVcodesListApp(){
        $data = json_decode(file_get_contents('php://input'));
        if($data)
        {
            $targetUti = $data->uti;
            $this->accessToken = $data->accessToken;
            $apiKey = 'hSdt20xB.HWLI48Y34eTGwUSaFJFwyaozjShq';
            $Url = "https://api.vplatform.io/vcodes/";
            $ch = curl_init($Url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-VPLATFORM-API-KEY: {$apiKey}",
                    "Authorization: Bearer {$this->accessToken}"
                ]
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response, true);
            $resArr['packageId'] = array();
            if($result['data']){
                foreach($result['data'] as $val){
                    // print_r($val['uti']);exit;
                    if ($val['uti'] == $targetUti) {
                        array_push($resArr['packageId'],$val['packageIds'][0]);
                        // $Url2 = "https://api.vplatform.io/packages/".$val['packageIds'][0];
                        // $ch = curl_init($Url2);
                        // curl_setopt_array($ch, [
                        //     CURLOPT_RETURNTRANSFER => true,
                        //     CURLOPT_HTTPHEADER => [
                        //         "X-VPLATFORM-API-KEY: {$apiKey}",
                        //         "Authorization: Bearer {$this->accessToken}"
                        //     ]
                        // ]);
                        // $response2 = curl_exec($ch);
                        // curl_close($ch);
                        // $result2 = json_decode($response2, true);
                        // array_push($resArr,$result2);
                    }
                }
            }
            if($resArr){
                // $rules = $resArr[0]['rules'];
                // $resArr[0]['Distances'] = array();
                // foreach($rules as $ruleVal){
                //     $distance = $this->calculateDistance($_POST['userLat'], $_POST['userLat'], $ruleVal['data']['latitude'], $ruleVal['data']['longitude'], 'K');
                //     $distance1 = round($distance, 2) . " km";
                //     array_push($resArr[0]['Distances'],$distance1);
                // }
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['response_data'] = $resArr;
            }else{
                $res['response_code'] = 2;
                $res['response_message'] = 'Failed';
            }
        }
        else
        {
            $res['response_code'] = 3;
            $res['response_message'] = 'Data is null';
        }
        echo json_encode($res); exit;
    }

    function gettingFinalDistancedata(){
        $data = json_decode(file_get_contents('php://input'));
        if($data)
        {
            $packageId = $data->packageId;
            $userLat = $data->userLat;
            $userLong = $data->userLong;
            $this->accessToken = $data->accessToken;
            $apiKey = 'hSdt20xB.HWLI48Y34eTGwUSaFJFwyaozjShq';
            $Url = "https://api.vplatform.io/packages/".$packageId;
            $ch = curl_init($Url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-VPLATFORM-API-KEY: {$apiKey}",
                    "Authorization: Bearer {$this->accessToken}"
                ]
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response, true);
            if($result){
                // echo "<pre>"; print_r($result['rules']);exit;
                $rules = $result['rules'];
                $result['Distances'] = array();
                foreach($rules as $ruleVal){
                    $distance = $this->calculateDistance($userLat, $userLong, $ruleVal['data']['latitude'], $ruleVal['data']['longitude'], 'K');
                    $distance1 = round($distance, 2);
                    // print_r($distance1);exit;
                    array_push($result['Distances'],$distance1);
                }
                if($result['Distances']){
                    if(($result['Distances'][0] <= 0.5) || ($result['Distances'][1] <= 0.5)){
                        $result['DistancesEnable'] = true;
                    }else{
                        $result['DistancesEnable'] = false;
                    }
                }
                $res['response_code'] = 1;
                $res['response_message'] = 'Success';
                $res['response_data'] = $result;
            }else{
                $res['response_code'] = 2;
                $res['response_message'] = 'Failed';
            }
        }
        else
        {
            $res['response_code'] = 3;
            $res['response_message'] = 'Data is null';
        }
        echo json_encode($res); exit;
    }

}
?>
