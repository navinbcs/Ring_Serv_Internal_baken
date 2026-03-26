<?php
class Payment extends CI_Controller
{

   public  $apiKey ;
   public $secretKeyBase64 ;
   public $merchant_code ; 
   public $ringId;

    public function __construct()
    {
        parent::__construct();
        // $this->load->model(array('WebserviceModel'));
        $this->apiKey = "a5d820dcdb1e451a9ad42f8f5390318d";
        $this->secretKeyBase64 = "Fzzp1gJejyh5yJcEZpsHFUGpKXfh22yGI30EOwfGOy8=";
        $this->merchant_code = "229bfbfd79e9470c931f2301435e886d"; 

    }


    public function index(){

        $this->ringID = isset($_GET["ringID"])?$_GET["ringID"]:6612;
        $packID = isset($_GET["packID"])?$_GET["packID"]:1;
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
            'kid' => $this->apiKey
        ];

        // $userData = $this->WebserviceModel->getUserDataById($PatientId);
        // print_r($userData);exit;
        $payload = [
                          "enable_auto_capture" => "false", 
                          "merchant_code" => $this->merchant_code, 
                          "merchant_reference" => "Ring-". $this->ringID."-".time(), 
                          "payment_profile_code" => "", 
                          "instalment_profile_code" => "", 
                          "currency" => "MYR", 
                          "amount" => "300.00", 
                          "description" => "Appointment Booking", 
                          "response_url" => "https://win.k2key.in/testPayment.php", 
                          "payment_update_url" => "", 
                          "callback_url" => "", 
                          "additional_reference" => "AP-GHKL001-240923121229-2698", 
                          "customer" => [
                                "customer_id" =>  $this->ringID, 
                                "customer_name" => "Rajakumar Subbaraja", 
                                "customer_contact_no" => "987654321", 
                                "customer_email" => "rajakumar@sancyberhad.com" 
                             ], 
                          "billing" => [
                                   "billing_address_line_1" => "Address Line 1", 
                                   "billing_address_line_2" => "Address Line 2", 
                                   "billing_address_line_3" => "Address Line 3", 
                                   "billing_address_city" => "Ampang", 
                                   "billing_address_state" => "Selangor", 
                                   "billing_address_postal_code" => "654321", 
                                   "billing_address_country_code" => "MY" 
                                ] 
        ];
      
        // Use the secret key that jwt.io uses, but decode it from base64
        $encodedKey = $this->secretKeyBase64; // Replace with your actual base64-encoded secret
        $key = base64_decode($encodedKey); // Decode the key before using it in hash_hmac
        
        // Generate the JWT
         $jwt = $this->generateJWT($header, $payload, $key); 

        $this->load->view('paymentForm',array("jwt"=>$jwt));

    }

    function customHmac($data, $key) {
        $blockSize = 64; // For SHA-256
        if (strlen($key) > $blockSize) {
            $key = pack('H*', hash('sha256', $key));
        }
        $key = str_pad($key, $blockSize, chr(0)); // Pad with zeros if necessary
    
        $ipad = str_repeat(chr(0x36), $blockSize);
        $opad = str_repeat(chr(0x5C), $blockSize);
    
        $innerHash = hash('sha256', ($key ^ $ipad) . $data, true);
        return hash('sha256', ($key ^ $opad) . $innerHash, true); // Return raw output
    }

    function base64UrlEncode($data) {
        // Encodes data to base64 and makes it URL-safe
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    function sign($data, $key) {
        // Generate HMAC SHA-256 signature with raw output
        return $this->customHmac($data, $key);
    }
    
    function generateJWT($header, $payload, $key) {
        // Base64 URL encode the header and payload
        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));
    
        // Concatenate encoded header and payload with a dot
        $signatureBase = "$headerEncoded.$payloadEncoded";
    
        // Generate the signature
        $signature = $this->sign($signatureBase, $key);
    
        // Base64 URL encode the signature
        $signatureEncoded = $this->base64UrlEncode($signature);
    
        // Return the complete JWT
        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    function successResponse(){
        if(isset($_REQUEST["jwt"])){

            $jwt = $_REQUEST["jwt"];
            $jwtArray=explode(".", $jwt );
        
            echo base64_decode($jwtArray[1]);
        
        }
    }

   


}


