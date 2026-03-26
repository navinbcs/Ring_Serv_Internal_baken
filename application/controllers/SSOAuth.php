<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SSOAuth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SSOAuthModel','WebserviceModel'));
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

    public function saveUserToken()
    {        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $UserId = $data->UserId;
            $tenantId = isset($data->TenantId)?$data->TenantId:1632;
            $tokenStr = time()."-".$UserId."-".$tenantId;
           // $token = $this->encryptDecrypt("en",$tokenStr);
            $token = str_replace('/', '-', $this->encryptDecrypt("en", $tokenStr));
        
          //  print_r($token);exit;
            $saveDataArr = array( 
                "UserId"=>$UserId,
                "Token"=>$token,
                "TenantId"=>$tenantId
            );
            $insert = $this->SSOAuthModel->insertUserToken($saveDataArr);
            if($insert)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['token'] = $token;
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

    public function validateToken()
    {        
        $data = json_decode(file_get_contents('php://input'));        
        if($data)
        {
            $token = $data->token;
            $details = $this->SSOAuthModel->fetchUserDetailsByToken($token);

        //   print_r($details); exit ;
             

                $kunci = $this->config->item('thekey');
                $token1['id'] = $details->UserId; 
                $token1['MMCNumber'] = $details->MMCNumber; 
                $token1['UserName'] = $details->DoctorName; 
                $token1['TenantId'] = $details->TenantId; 
                $token1['TenantName'] = $details->TenantName; 
                $token1['RoleId'] = $details->RoleId; 
                $token1['Role'] = $details->Role; 

                
                $date1 = new DateTime();
                $token1['iat'] = $date1->getTimestamp();
                $token1['exp'] = $date1->getTimestamp() + 60 * 60 * 5; 
                $output['token'] = JWT::encode($token1, $kunci);


            if($details)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $details;
                $response['accessToken'] = $output['token'] ;
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

    
    public function sign_in_with_token(){   
        $data = json_decode(file_get_contents('php://input'));
        if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }

       
        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);

     //   print_r( $tokenData); exit ;
        $userId = $tokenData->id;
        $MMCNumber = $tokenData->MMCNumber;
        if($userId)
        {           
            $userData =  $this->SSOAuthModel->fetchUserDetailsByUserId($userId);

            if(isset($data->tenantObj))
                {
                     $userData->TenantId =  $data->tenantObj->TenantId ;
                     $userData->TenantName =  $data->tenantObj->TenantName ;

                    // print_r($tokenData); exit ;

                       $tokenData->TenantId = $data->tenantObj->TenantId; 
                       $tokenData->TenantName = $data->tenantObj->TenantName; 
                       $token = JWT::encode($tokenData, $kunci);
                        $response['accessToken'] =  $token  ;


                
                }else{
                     $userData->TenantId =  $tokenData->TenantId ;
                     $userData->TenantName =  $tokenData->TenantName ;
      
                }

            //    echo $tokenData->TenantId ; exit ;
            $userData->CurrrencyCode =  $this->SSOAuthModel->getCurrencyCodeByTenantId($userData->TenantId);
            
            if($userData )             
            {
                $response['response_code']=1;
                $response['response_message']='Success';
                $response['user_data']=$userData;
            }
            else
            {
                $response['response_code']=2;
                $response['response_message']='Failed';           
            }
        }
        else
        {
            $response['response_code'] = 4;
            $response['response_message'] = 'JWT Token Error';
        }    
        echo json_encode($response); exit;
    }

    public function getDoctorsDetailsAndTenants(){
        $data = json_decode(file_get_contents('php://input'));   
        
        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);
        $id = $tokenData->id;
        $role = isset($tokenData->Role)?$tokenData->Role:'';
       // print_r($tokenData);

        if($data)
        {
           
            $userData = $this->WebserviceModel->getDoctorsDetails( $id,$role);
           //print_r($userData); exit ;
            $userData->tenants = $this->WebserviceModel->getDoctorsTenants( $id);
            if($userData)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $userData;
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


 public function switchTenantAndGenerateToken()
{
    // Decode input
    $data = json_decode(file_get_contents('php://input'));
    if (!$data || empty($data->TenantId)) {
        echo json_encode([
            'response_code'    => '3',
            'response_message' => 'TenantId required'
        ]);
        exit;
    }

    $TenantId = $data->TenantId;

    // Step 1: Decode JWT to get current UserId
    $headers = isset($_SERVER["HTTP_AUTHORIZATION"]) ? $_SERVER["HTTP_AUTHORIZATION"] : '';
    if (!$headers) {
        echo json_encode([
            'response_code'    => '4',
            'response_message' => 'Authorization header missing'
        ]);
        exit;
    }

    $token  = str_replace("Bearer ", "", $headers);
    $kunci  = $this->config->item('thekey');

    try {
        $tokenData = JWT::decode($token, $kunci);
        $UserId    = $tokenData->id;
    } catch (Exception $e) {
        echo json_encode([
            'response_code'    => '5',
            'response_message' => 'Invalid or expired token',
            'error'            => $e->getMessage()
        ]);
        exit;
    }

    // Step 2: Generate temporary token and save
    $tokenStr = time() . "-" . $UserId . "-" . $TenantId;
    $tempToken = $this->encryptDecrypt("en", $tokenStr);

    $saveDataArr = [
        "UserId"   => $UserId,
        "Token"    => $tempToken,
        "TenantId" => $TenantId
    ];
    $insert = $this->SSOAuthModel->insertUserToken($saveDataArr);

    if (!$insert) {
        echo json_encode([
            'response_code'    => '6',
            'response_message' => 'Failed to save token'
        ]);
        exit;
    }

    // Step 3: Fetch user details for new Tenant
    $details = $this->SSOAuthModel->fetchUserDetailsByToken($tempToken);
    if (!$details) {
        echo json_encode([
            'response_code'    => '7',
            'response_message' => 'User details not found for tenant'
        ]);
        exit;
    }

    // Step 4: Generate new JWT with updated Tenant info
    $payload = [
        'id'         => $details->UserId,
        'MMCNumber'  => $details->MMCNumber,
        'UserName'   => $details->DoctorName,
        'TenantId'   => $details->TenantId,
        'TenantName' => $details->TenantName,
        'iat'        => time(),
        'exp'        => time() + 60 * 60 * 5 // valid for 5 hours
    ];

    $newJwt = JWT::encode($payload, $kunci);

    // Step 5: Send back new JWT + updated user detail
    echo json_encode([
        'response_code'    => '1',
        'response_message' => 'Success',
        'accessToken'      => $newJwt,
        'response_data'    => $details
    ]);
    exit;
}

public function switchTenantAndGenerateTokenOfUser()
{
    // Decode input
    $data = json_decode(file_get_contents('php://input'));
    if (!$data || empty($data->TenantId)) {
        echo json_encode([
            'response_code'    => '3',
            'response_message' => 'TenantId required'
        ]);
        exit;
    }

    $TenantId = $data->TenantId;

    // Step 1: Decode JWT to get current UserId
    $headers = isset($_SERVER["HTTP_AUTHORIZATION"]) ? $_SERVER["HTTP_AUTHORIZATION"] : '';
    if (!$headers) {
        echo json_encode([
            'response_code'    => '4',
            'response_message' => 'Authorization header missing'
        ]);
        exit;
    }

    $token  = str_replace("Bearer ", "", $headers);
    $kunci  = $this->config->item('thekey');

    try {
        $tokenData = JWT::decode($token, $kunci);
        $UserId    = $tokenData->id;
    } catch (Exception $e) {
        echo json_encode([
            'response_code'    => '5',
            'response_message' => 'Invalid or expired token',
            'error'            => $e->getMessage()
        ]);
        exit;
    }

    // Step 2: Generate temporary token and save
    $tokenStr = time() . "-" . $UserId . "-" . $TenantId;
    $tempToken = $this->encryptDecrypt("en", $tokenStr);

    $saveDataArr = [
        "UserId"   => $UserId,
        "Token"    => $tempToken,
        "TenantId" => $TenantId
    ];
    $insert = $this->SSOAuthModel->insertUserToken($saveDataArr);

    if (!$insert) {
        echo json_encode([
            'response_code'    => '6',
            'response_message' => 'Failed to save token'
        ]);
        exit;
    }

    // Step 3: Fetch user details for new Tenant
    $details = $this->SSOAuthModel->fetchUserDetailsByToken($tempToken);
    if (!$details) {
        echo json_encode([
            'response_code'    => '7',
            'response_message' => 'User details not found for tenant'
        ]);
        exit;
    }

    // Step 4: Generate new JWT with updated Tenant info
    $payload = [
        'id'         => $details->UserId,
        'MMCNumber'  => $details->MMCNumber,
        'UserName'   => $details->DoctorName,
        'TenantId'   => $details->TenantId,
        'TenantName' => $details->TenantName,
        'iat'        => time(),
        'exp'        => time() + 60 * 60 * 5 // valid for 5 hours
    ];

    $newJwt = JWT::encode($payload, $kunci);

    // Step 5: Send back new JWT + updated user detail
    echo json_encode([
        'response_code'    => '1',
        'response_message' => 'Success',
        'accessToken'      => $newJwt,
        'response_data'    => $details
    ]);
    exit;
}
}