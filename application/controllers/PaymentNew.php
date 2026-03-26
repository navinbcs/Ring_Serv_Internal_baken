<?php
class PaymentNew extends CI_Controller
{

   public  $apiKey ;
   public $secretKeyBase64 ;
   public $merchant_code ; 
   public $ringId;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('WebserviceModel'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');
        $this->load->library('fcm', [
            'serviceAccountKeyFile' => 'ring-ee756-firebase-adminsdk-44fhx-9cb3b06973.json', // Replace with the path to your service account key file
            'projectID' => 'ring-ee756'
        ]);
        $this->apiKey = "a5d820dcdb1e451a9ad42f8f5390318d";
        $this->secretKeyBase64 = "Fzzp1gJejyh5yJcEZpsHFUGpKXfh22yGI30EOwfGOy8=";
        $this->merchant_code = "229bfbfd79e9470c931f2301435e886d"; 

    }


    public function index(){
// print_r($_GET["plan"]);exit;
        // $this->ringID = isset($_GET["ringID"])?$_GET["ringID"]:6612;
        $ringId = isset($_GET["ringID"])?$_GET["ringID"]:6612;
        $packID = isset($_GET["packID"])?$_GET["packID"]:1;
        $detailID = isset($_GET["detailID"])?$_GET["detailID"]:1;
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
            'kid' => $this->apiKey
        ];

        $userData = $this->WebserviceModel->getUserDataById($ringId);
        if(isset($userData) && !empty($userData)){
            $userData->FirstName = $this->encryptDecrypt("dc",$userData->FullName);
            $userData->LastName = $this->encryptDecrypt("dc",$userData->LastName);
            $userData->FullName = $userData->FirstName." ". $userData->LastName;
            $userData->Email = $this->encryptDecrypt("dc",$userData->Email);
            $userData->MobileNumber = $this->encryptDecrypt("dc",$userData->MobileNumber);
            if(isset($userData->Address) && !empty($userData->Address)){
                $userData->Address = urldecode($userData->Address);
            }else{
                $userData->Address = "";
            }
            
            if(isset($userData->DateOfBirth) && !empty($userData->DateOfBirth)){
                $userData->DateOfBirth = $userData->DateOfBirth;
            }else{
                $userData->DateOfBirth = "2000-01-01 00:00:00.000";
            }
            $mobileCo = trim($userData->MobileCode);
            $getContCode = $this->WebserviceModel->getCountryFlagAndCode($mobileCo);
            if($getContCode){
                $userData->CountryCode = $getContCode->CountryCode;
            }else{
                    $userData->CountryCode = "";
            }

            if(empty($userData->StateMasterId) || !isset($userData->StateMasterId)){
                $userData->state = NULL;
            }else{
                $statedata = $this->WebserviceModel->searchIdOfGivenString($userData->StateMasterId,"StateMaster","ID");
				if(isset($statedata) && !empty($statedata)){
                    $userData->state = $statedata->StateDescription;
                }else{
                    $userData->state = NULL;
                }
			}
            
            if(empty($userData->CityMasterId) || !isset($userData->CityMasterId)){
                $userData->city = NULL;
            }else{
                $citydata = $this->WebserviceModel->searchIdOfGivenString($userData->CityMasterId,"CityMaster","ID");
				if(isset($citydata) && !empty($citydata)){
                    $userData->city = $citydata->CityDescription;
                }else{
                    $userData->city = NULL;
                }
			}
            
        }else{
            $userData = "";
        }
        // echo "<pre>"; print_r($userData);exit;
        $packageDetails = $this->WebserviceModel->getSubscriptionPackData($packID,$detailID);
        if(!isset($packageDetails)){
            $response['response_code'] = '5';
            $response['response_message'] = 'Package not available';
            echo json_encode($response);exit;
        }
        //echo "<pre>"; print_r($packageDetails);exit;
        $payload = [
                          "enable_auto_capture" => "false", 
                          "merchant_code" => $this->merchant_code, 
                          "merchant_reference" => "Ring-". $ringId."-".time(), 
                          "payment_profile_code" => "", 
                          "instalment_profile_code" => "", 
                          "currency" => "MYR", 
                          "amount" => $packageDetails->NormalPrice, 
                          "description" => "Premium Subscription", 
                          "response_url" => "https://apimobile.ring.healthcare:5026/Ring_Dev/index.php/PaymentNew/successResponse", 
                          "payment_update_url" => "", 
                          "callback_url" => "", 
                        //   "additional_reference" => "AP-GHKL001-240923121229-2698", 
                        "additional_reference" => $ringId."-".$packID."-".$packageDetails->PremiumServiceType."-".$detailID,
                          "customer" => [
                                "customer_id" =>  $ringId, 
                                "customer_name" => $userData->FullName, 
                                "customer_contact_no" => $userData->MobileNumber, 
                                "customer_email" => $userData->Email 
                             ], 
                          "billing" => [
                                //    "billing_address_line_1" => "Address Line 1", 
                                //    "billing_address_line_2" => "Address Line 2", 
                                //    "billing_address_line_3" => "Address Line 3", 
                                   "billing_address_city" => $userData->city,
                                   "billing_address_state" => $userData->state, 
                                   "billing_address_postal_code" => isset($userData->PinCode)?$userData->PinCode:"50001", 
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
            $jwtDataArray = json_decode(base64_decode($jwtArray[1]));
            //echo "<pre>"; print_r($jwtDataArray);exit;
            $transactionData = $jwtDataArray->transaction;
            $additionalData = $jwtDataArray->additional_reference;
            $additionalVals = explode("-",$additionalData);
            //print_r($additionalVals[2]);exit;
            if(isset($additionalVals[2]) && ($additionalVals[2] == 1)){
                $duration = "Monthly";
            }else if(isset($additionalVals[2]) && ($additionalVals[2] == 2)){
                $duration = "Half Yearly";
            }else if(isset($additionalVals[2]) && ($additionalVals[2] == 3)){
                $duration = "Yearly";
            }
            //print_r($transactionData);exit;
            //print_r($duration);exit;
            if($transactionData->result_code == 0 && $transactionData->payment_status == "SALES"){
                
                $cardData = $jwtDataArray->card;
                $insertArr = array(
                    "PatientId"=>$additionalVals[0],
                    "packageId"=>$additionalVals[1],
                    "TransactionReference"=>$transactionData->transaction_reference,
                    "PaymentStatus"=>$transactionData->payment_status,
                    "Status"=>1,
                    "Amount"=>$transactionData->amount,
                    "Currency"=>$transactionData->currency,
                    "TransactionTimestamp"=>$transactionData->transaction_timestamp,
                    // "CardScheme"=>$cardData->card_scheme,
                    // "CardLastFour"=>$cardData->card_last_four,
                    // "CardBankName"=>$cardData->card_bank_name,
                    // "MerchantCode"=>$jwtDataArray->merchant_code,
                    "ResultDescription"=>$transactionData->result_description,
                    "PremiumServiceType"=>$additionalVals[2],
                    "ServiceDuration"=>$duration,
                    "PremiumDetailsId" =>$additionalVals[3]
                );
                //print_r($additionalVals[0]);exit;
                $patientId = $additionalVals[0];
                $checkUserSubs = $this->WebserviceModel->checkUsersLastPremiumSubscription($patientId);
                if($checkUserSubs){
                    $startDate = $checkUserSubs->EndDate;
                    $timeS = strtotime($startDate);
                    if($duration == "Monthly"){
                        $endDate = date("Y-m-d H:i:s", strtotime("+1 month", $timeS));
                    }else if($duration == "Half Yearly"){
                        $endDate = date("Y-m-d H:i:s", strtotime("+6 month", $timeS));
                    }else if($duration == "Yearly"){
                        $endDate = date("Y-m-d H:i:s", strtotime("+12 month", $timeS));
                    }
                    
                }else{
                    $startDate = date('Y-m-d H:i:s');
                    $timeS = strtotime($startDate);
                    if($duration == "Monthly"){
                        $endDate = date("Y-m-d H:i:s", strtotime("+1 month", $timeS));
                    }else if($duration == "Half Yearly"){
                        $endDate = date("Y-m-d H:i:s", strtotime("+6 month", $timeS));
                    }else if($duration == "Yearly"){
                        $endDate = date("Y-m-d H:i:s", strtotime("+12 month", $timeS));
                    }

                }
                $subscriptionArray = array(
                    "PatientId"=>$additionalVals[0],
                    "packageId"=>$additionalVals[1],
                    "PremiumServiceType"=>$additionalVals[2],
                    "PremiumDetailsId" =>$additionalVals[3],
                    "StartDate"=>$startDate,
                    "EndDate"=>$endDate
                );
                $membershipId = rand(100000,999999);
                $updateArr = array("MembershipId"=>$membershipId);
                $updateArrSub = array("IsSubscribe"=>1);
                $insert = $this->WebserviceModel->insertTransactionData($insertArr);
                $subscribe = $this->WebserviceModel->insertSubscriptionData($subscriptionArray);
                $checkMembership = $this->WebserviceModel->getUserDataById($patientId);
                if(!isset($checkMembership->MembershipId) && empty($checkMembership->MembershipId)){
                    $updateMemberId = $this->WebserviceModel->updateUserData($updateArr,$patientId);
                }
                $updateSubcribe = $this->WebserviceModel->updateUserData($updateArrSub,$patientId);
                $userData = $this->WebserviceModel->getUserDataById($patientId);
                $FirstName = $this->encryptDecrypt("dc",$userData->FullName);
                $Email = $this->encryptDecrypt("dc",$userData->Email);
                $type = "RingPremiumSuccess";
                $mailArr = array("name"=>$FirstName, "renewal_date"=>$endDate);
               // print_r($mailArr);exit;
                $sendMail = Utility::callSendMailWithTemplate($Email,$type,$mailArr);
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $insertArr;
                $this->load->view('payment_success');
            }else if(($transactionData->result_code = 3900) && ($transactionData->payment_status == "CANCELLED")){
                $insertArr = array(
                    "PatientId"=>$additionalVals[0],
                    "packageId"=>$additionalVals[1],
                    "TransactionReference"=>$transactionData->transaction_reference,
                    "PaymentStatus"=>$transactionData->payment_status,
                    "Status"=>0,
                    "Amount"=>$transactionData->amount,
                    "Currency"=>$transactionData->currency,
                    "TransactionTimestamp"=>$transactionData->transaction_timestamp,
                    // "MerchantCode"=>$jwtDataArray->merchant_code,
                    "ResultDescription"=>$transactionData->result_description,
                    "PremiumServiceType"=>$additionalVals[2],
                    "PremiumDetailsId" =>$additionalVals[3],
                    "ServiceDuration"=>$duration
                );
                $insert = $this->WebserviceModel->insertTransactionData($insertArr);
                $response['response_code'] = '2';
                $response['response_message'] = 'Cancelled';
                $response['response_data'] = $insertArr;
            }else{
                $response['response_code'] = '3';
                $response['response_message'] = 'Failled';
            }
            
        }else{
            $response['response_code'] = '4';
            $response['response_message'] = 'JWT not found';
        }
        // echo json_encode($response);exit;
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

    public function userSubscriptionRecurring(){

        // $this->ringID = isset($_GET["ringID"])?$_GET["ringID"]:6612;
        $ringId = isset($_GET["ringID"])?$_GET["ringID"]:6612;
        $packID = isset($_GET["packID"])?$_GET["packID"]:1;
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
            'kid' => $this->apiKey
        ];

        $userData = $this->WebserviceModel->getUserDataById($ringId);
        if(isset($userData) && !empty($userData)){
            $userData->FirstName = $this->encryptDecrypt("dc",$userData->FullName);
            $userData->LastName = $this->encryptDecrypt("dc",$userData->LastName);
            $userData->FullName = $userData->FirstName." ". $userData->LastName;
            $userData->Email = $this->encryptDecrypt("dc",$userData->Email);
            $userData->MobileNumber = $this->encryptDecrypt("dc",$userData->MobileNumber);
            if(isset($userData->Address) && !empty($userData->Address)){
                $userData->Address = urldecode($userData->Address);
            }else{
                $userData->Address = "";
            }
            
            if(isset($userData->DateOfBirth) && !empty($userData->DateOfBirth)){
                $userData->DateOfBirth = $userData->DateOfBirth;
            }else{
                $userData->DateOfBirth = "2000-01-01 00:00:00.000";
            }
            $mobileCo = trim($userData->MobileCode);
            $getContCode = $this->WebserviceModel->getCountryFlagAndCode($mobileCo);
            if($getContCode){
                $userData->CountryCode = $getContCode->CountryCode;
            }else{
                    $userData->CountryCode = "";
            }

            if(empty($userData->StateMasterId) || !isset($userData->StateMasterId)){
                $userData->state = NULL;
            }else{
                $statedata = $this->WebserviceModel->searchIdOfGivenString($userData->StateMasterId,"StateMaster","ID");
				if(isset($statedata) && !empty($statedata)){
                    $userData->state = $statedata->StateDescription;
                }else{
                    $userData->state = NULL;
                }
			}
            
            if(empty($userData->CityMasterId) || !isset($userData->CityMasterId)){
                $userData->city = NULL;
            }else{
                $citydata = $this->WebserviceModel->searchIdOfGivenString($userData->CityMasterId,"CityMaster","ID");
				if(isset($citydata) && !empty($citydata)){
                    $userData->city = $citydata->CityDescription;
                }else{
                    $userData->city = NULL;
                }
			}
            
        }else{
            $userData = "";
        }
        // echo "<pre>"; print_r($userData);exit;
        $packageDetails = $this->WebserviceModel->getSubscriptionPackData($packID);
        if(!isset($packageDetails)){
            $response['response_code'] = '5';
            $response['response_message'] = 'Package not available';
            echo json_encode($response);exit;
        }
        //echo "<pre>"; print_r($packageDetails);exit;
        $payload = [
                        //   "enable_auto_capture" => "false", 
                        //   "merchant_code" => $this->merchant_code, 
                        //   "merchant_reference" => "Ring-". $ringId."-".time(), 
                        //   "payment_profile_code" => "", 
                        //   "instalment_profile_code" => "", 
                        //   "currency" => "MYR", 
                        //   "amount" => $packageDetails->NormalPrice, 
                        //   "description" => "Premium Subscription", 
                        //   "response_url" => "https://apimobile.ring.healthcare:5026/Ring_Dev/index.php/Payment/successResponse", 
                        //   "payment_update_url" => "", 
                        //   "callback_url" => "", 

                            // "enable_auto_capture"=> "false",
                            // "merchant_code" => $this->merchant_code, 
                            // "merchant_reference" => "Ring-". $ringId."-".time(), 
                            // "payment_profile_code"=> "",
                            // "instalment_profile_code"=> "",
                            // "currency"=> "MYR",
                            // "amount"=> "242.50",
                            // "description"=> "Flight Ticket KL to Sabah",
                            // "response_url"=> "https://apimobile.ring.healthcare:5026/Ring_Dev/index.php/Payment/successResponseSubscription",
                            // "notification_url"=> "",
                            // "payment_update_url"=> "",
                            // "callback_url"=> "",
                            // "additional_reference" => $ringId."-".$packID,
                            // "paymentType"=> 
                            //     [
                            //     "card"=> "true",
                            //     "online_banking"=> "false",
                            //     "ewallet"=> "false"
                            //     ], 
                            // "cardTokenization"=> 
                            //     [ "enable_tokenization"=> "true", 
                            //         "auto_void_auth_transaction"=> "true", 
                            //         "allow_save_new_card"=> "false", 
                            //         "token_reference_id"=> "4NNNd6srNH4yP38WZAvVQP6gbMUvLIgp"
                            //     ], 
                            // "autoBill"=> 
                            //     [ "start_date"=> "24102024", 
                            //         "end_date"=> "", 
                            //         "frequency"=> "1" 
                            //     ], 
                            // "customer" => [
                            //     "customer_id" =>  $ringId, 
                            //     "customer_name" => $userData->FullName, 
                            //     "customer_contact_no" => $userData->MobileNumber, 
                            //     "customer_email" => $userData->Email 
                            //  ],
                            // "billing" => [
                            //     //    "billing_address_line_1" => "Address Line 1", 
                            //     //    "billing_address_line_2" => "Address Line 2", 
                            //     //    "billing_address_line_3" => "Address Line 3", 
                            //        "billing_address_city" => $userData->city,
                            //        "billing_address_state" => $userData->state, 
                            //        "billing_address_postal_code" => isset($userData->PinCode)?$userData->PinCode:"50001", 
                            //        "billing_address_country_code" => isset($userData->CountryCode)?$userData->CountryCode:"MY"
                            //     ]
                        //   "additional_reference" => "AP-GHKL001-240923121229-2698", 

                        
                            "merchant_code" => $this->merchant_code, 
                            "merchant_reference" => "Ring-". $ringId."-".time(), 
                            "currency"=> "MYR",
                            "amount"=> "5.50",
                            "token_reference_id"=> "4NNNd6srNH4yP38WZAvVQP6gbMUvLIgp",
                            "response_url"=> "https://apimobile.ring.healthcare:5026/Ring_Dev/index.php/PaymentNew/successResponseSubscription",
                            "start_date"=> "18052024",
                            "end_date"=> "",
                            "frequency"=> "0",
                            "customer_contact_no"=> "60-129492038",
                            "customer_email"=> "John@gmail.com",
                            "paymentType"=> 
                                [
                                "card"=> "true",
                                "online_banking"=> "false",
                                "ewallet"=> "false"
                                ], 
                            "cardTokenization"=> 
                                [ "enable_tokenization"=> "true", 
                                    "auto_void_auth_transaction"=> "true", 
                                    "allow_save_new_card"=> "false", 
                                    "token_reference_id"=> "4NNNd6srNH4yP38WZAvVQP6gbMUvLIgp"
                                ], 
                            "autoBill"=> 
                                [ "start_date"=> "24102024", 
                                    "end_date"=> "", 
                                    "frequency"=> "1" 
                                ], 
                            "customer" => [
                                "customer_id" =>  $ringId, 
                                "customer_name" => $userData->FullName, 
                                "customer_contact_no" => $userData->MobileNumber, 
                                "customer_email" => $userData->Email 
                             ],
                            "billing" => [
                                //    "billing_address_line_1" => "Address Line 1", 
                                //    "billing_address_line_2" => "Address Line 2", 
                                //    "billing_address_line_3" => "Address Line 3", 
                                   "billing_address_city" => $userData->city,
                                   "billing_address_state" => $userData->state, 
                                   "billing_address_postal_code" => isset($userData->PinCode)?$userData->PinCode:"50001", 
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

    function successResponseSubscription(){
        if(isset($_REQUEST["jwt"])){
            $jwt = $_REQUEST["jwt"];
            $jwtArray=explode(".", $jwt );      
            $jwtDataArray = json_decode(base64_decode($jwtArray[1]));
            echo "<pre>"; print_r($jwtDataArray);exit;
        }
    }

}