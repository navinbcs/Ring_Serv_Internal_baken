<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('send_fcm_notification')) {
function send_fcm_notification(
    $fcmToken,
    $title,
    $body,
    $data = [],
    $platform = 'android'
) {
    $CI =& get_instance();
       $notification_type = 'Reminder';
      $sender = 'Ring App';

    // Select correct JSON file based on platform
    if ($platform === 'ios') {
        $projectId = 'converge-56dbd';
        $keyFile = APPPATH . 'third_party/keys/converge-56dbd-firebase-ios.json';
    } else {
        $projectId = 'converge-56dbd';
        $keyFile = APPPATH . 'third_party/keys/converge-56dbd-firebase-android.json';
    }

    $CI->load->library('fcm', [
        'serviceAccountKeyFile' => $keyFile,
        'projectID' => $projectId
    ]);

   

    try {
          
        $response = $CI->fcm->sendNotification($fcmToken, $title, $body,$notification_type,$sender); // ✅ corrected call
        log_message('info', "FCM sent to $platform: " . json_encode($response));
        echo  "FCM sent to $platform: " . json_encode($response) ;
        return ['status' => 'Success', 'response' => $response];
    } catch (Exception $e) {
        echo  "FCM failed: " . $e->getMessage() ;
        log_message('error', "FCM failed: " . $e->getMessage());
        return ['status' => 'Failed', 'error' => $e->getMessage()];
    }
}

}
