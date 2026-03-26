<?php
class Appointment_model extends CI_Model
{
    public function get_appointments_next_15_minutes()
    {
        $query = $this->db->query("
            SELECT Id, PatientId, AppointmentDate, FromTime, IsNotificationSent
            FROM Appointment
            WHERE 
                IsActive = 1
                AND AppointmentStatusId = 1
                AND 
                (
                    DATEADD(MINUTE, 0, CAST(AppointmentDate AS DATETIME) + CAST(FromTime AS DATETIME))
                    BETWEEN GETDATE() AND DATEADD(MINUTE, 15, GETDATE())
                )
        ");
        return $query->result();
    }
    function getFutureAppointment(){


        $query = $this->db->query("SELECT *
        FROM Appointment
        WHERE 
            IsActive = 1
            AND AppointmentDate > GETDATE()
        ORDER BY AppointmentDate ASC");
         return $query->result();

    }

    public function mark_notification_sent($appointmentId)
    {
        $this->db->where('Id', $appointmentId);
        $this->db->update('Appointment', ['IsNotificationSent' => 1]);
    }

    public function get_upcoming_appointments_with_tokens()
    {
        $this->db->select('a.Id AS AppointmentId, a.PatientId, a.FromTime, n.DeviceId AS FcmToken, n.Platform');
        $this->db->from('Appointment a');
        $this->db->join('Notification n', 'a.PatientId = n.PatientId');
        $this->db->where('a.IsActive', 1);
        $this->db->where('n.IsActive', 1);
      //  $this->db->where('n.IsNotify', 1);
        $this->db->where('a.FromTime >=', 'GETDATE()', FALSE);
        $this->db->where('a.FromTime <', 'DATEADD(MINUTE, 5, GETDATE())', FALSE);

        // ✅ Exclude appointments already notified (Reminder type)
        $this->db->where("NOT EXISTS (
            SELECT 1 
            FROM AppointmentNotificationLog l 
            WHERE 
                l.AppointmentId = a.Id 
                AND l.NotificationType = 'Reminder' 
                AND l.Status = 'Success'
        )", NULL, FALSE);

       return  $this->db->get()->result();  
    }


}
