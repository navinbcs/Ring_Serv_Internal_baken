<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Appointment_model');
        $this->load->model('NotificationLog_model');
       // $this->load->model('Notification_model');
    }

public function send_appointment_reminders()
{
    $this->load->helper('fcm'); // make sure fcm_helper is loaded

    $appointments = $this->Appointment_model->get_upcoming_appointments_with_tokens();
  
    $results = [];
    foreach ($appointments as $row) {
        
        if (!$this->NotificationLog_model->is_notification_sent($row->AppointmentId, 'Reminder')) {

            $time = date("h:i A", strtotime($row->FromTime ?? $row->FromTime));
            $date = date("d-m-Y", strtotime($row->FromTime));
            $message = "Reminder: You have an appointment at $time on $date. Please be on time.";

            $status = 'Success';
            $response = 'Sent successfully';

            try {
                $response = send_fcm_notification(
                    $row->FcmToken,
                    "Appointment Reminder",
                    $message,
                    ['appointment_id' => $row->AppointmentId],
                    $row->Platform // <- 'android' or 'ios'
                );
                $status = $response['status'];
            } catch (Exception $e) {
                $status = 'Failed';
                $response = $e->getMessage();
            }

            // Log the notification
           $this->NotificationLog_model->log_notification(
                $row->AppointmentId,
                $row->PatientId,
                $message,
                'FCM',
                'Reminder',
                $status,
                is_array($response) ? json_encode($response) : $response
            );
            

                // For API response
            // $results[] = [
            //     'AppointmentId' => $row->AppointmentId,
            //     'PatientId' => $row->PatientId,
            //     'Status' => $status,
            //     'Message' => $responseMessage
            // ];
        }
    }
  $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
            'status' => 'success',
          //  'reminders_sent' => count($results),
          //  'data' => $results
        ]));
}


public function ping()
{
    echo json_encode(['status' => 'ok']);
}

}
