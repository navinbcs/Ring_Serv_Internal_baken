<?php
class NotificationLog_model extends CI_Model
{
    public function log_notification($appointmentId, $patientId, $message, $method, $status, $response)
    {
        $data = [
            'AppointmentId' => $appointmentId,
            'PatientId' => $patientId,
            'NotificationMessage' => $message,
            'NotificationMethod' => $method,
            'Status' => $status,
            'NotificationType' => $status,
            'Response' => $response,
            'CreatedAt' => date('Y-m-d H:i:s'),
            'CreatedBy' => 1 // Optional: use session user id if needed
        ];

        $this->db->insert('AppointmentNotificationLog', $data);
    }

public function is_notification_sent($appointmentId, $type)
{
    $this->db->from('AppointmentNotificationLog');
    $this->db->where('AppointmentId', $appointmentId);
    $this->db->where('NotificationType', $type);
    return $this->db->count_all_results() > 0;
}

public function get_active_fcm_token($patientId, $platform = null)
{
    $this->db->select('DeviceId');
    $this->db->from('Notification');
    $this->db->where('PatientId', $patientId);
    $this->db->where('IsActive', 1);
    $this->db->where('IsNotify', 1);
    
    if (!empty($platform)) {
        $this->db->where('Platform', $platform);
    }

    $this->db->order_by('InsertDate', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get();
    $row = $query->row();

    return $row ? $row->DeviceId : null;
}


}
