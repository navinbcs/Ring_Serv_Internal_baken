<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VcodeController extends CI_Controller {

    private $apiKey = 'hSdt20xB.HWLI48Y34eTGwUSaFJFwyaozjShq';
    private $accessToken;

    public function generate_vcode_fulldata() {
        $username = 'Sancy@vcode.co.uk';
        $password = '2LwAfR9BePo6';

     // echo  $this->accessToken = $this->loginAndGetToken($username, $password); exit ;

      $this->accessToken = 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI2NmJkYWUzMy1kMzE5LTQ1NDktODRhMi0xMmZkNDA4ZmQwODIiLCJyb2xlcyI6W3siYXV0aG9yaXR5IjoicHVibGljIn1dLCJpc3MiOiJ2cGxhdGZvcm0iLCJqdGkiOiJiYmY0N2ZhYy1jNWYwLTQwOWUtYmI0Ni0xM2JlZjljNWRkYTgiLCJpYXQiOjE3NTAzMTQwMDAsImV4cCI6MTc1MDMxNTIwMH0.quG3v6UKCWKuK4opFt-IfrMbIr1PGOIIg56PpSZ9eH4';
        if (!$this->accessToken) {
            return $this->output->set_output(json_encode(['error' => 'Auth failed']));
        }
 
        // Create rules
        $rule1 = $this->createRule("Clinic Location", 18.5204, 73.8567); 
        $rule2 = $this->createRule("Navin Location", 18.6789, 73.8434);      
        if (!$rule1 || !$rule2) return $this->output->set_output(json_encode(['error' => 'Rule creation failed']));
 
        // Create action
        $action = $this->createAction("Open Referral", "https://ring.web.app/referral?id=XYZ123"); 
        if (!$action) return $this->output->set_output(json_encode(['error' => 'Action creation failed']));

        // Create package
        $package = $this->createPackage("Navin + Clinic Package", $action, [$rule1, $rule2]);
        if (!$package) return $this->output->set_output(json_encode(['error' => 'Package creation failed']));
        
        // Create VCode
        $vcode = $this->createVcode("Generated QR", $package);
        if (!$vcode) return $this->output->set_output(json_encode(['error' => 'VCode creation failed']));

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($vcode));
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

    private function createRule($title, $lat, $lng) {
        $data = [
            "title" => $title,
            "description" => "Geo rule: $title",
            "data" => [
                "type" => "geofence",
                "latitude" => $lat,
                "longitude" => $lng,
                "radius" => 150
            ]
        ];
        $response = $this->callApi("https://api.vplatform.io/rules", $data);
        return $response['uid'] ?? null;
    }

    private function createAction($title, $url) {
        $data = [
            "title" => $title,
            "description" => "Open referral link",
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
}
