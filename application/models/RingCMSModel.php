<?php
class RingCMSModel extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function DoctorDetails($firstName,$departmentId)
    { 
        $sp = 'EXEC usp_DoctorDetails';
		$query = $this->db->query(" $sp '".$firstName."',NULL ");
		$result = $query->result();
        // echo $this->db->last_query();exit;
		return $result;
    }
    
    function GetCMSDoctorDynamicCalendar($doctorId,$department_id,$year)
    { 
        $sp = 'EXEC usp_GetCMSDoctorDynamicCalendar';
		$query = $this->db->query(" $sp NULL,".$doctorId.",'".$year."' ");
		$result = $query->result();
		return $result;
    }
    
    function AppointmentListForRing($Ringid,$flag)
    { 
        $sp = 'EXEC usp_AppointmentListForRing';
		$query = $this->db->query(" $sp ".$Ringid.",".$flag." ");
		$result = $query->result();
		return $result;
    }

    function InsertAppointmentDetails11111($patientid,$location_id,$doctor_id,$department_id,$appointment_date,$from_time,$to_time,$firstname,$lastname,$gender,$dob1,$bloodgroup,$email,$country_id,$state_id,$city_id,$address,$pin_code,$mob_code,$bloodgrouptype,$isMainPatientID,$mobile_number,$appointment_reason_id,$remark,$IdentificationTypeId,$IdentityNo)
    { 
        $sp = 'DECLARE @OutPatientId INT, @OutAppointmentId INT; EXEC usp_InsertAppointmentDetails';
		$query = $this->db->query(" $sp ".$patientid.",".$location_id.",".$doctor_id.",".$department_id.",'".$appointment_date."','".$from_time."','".$to_time."','".$firstname."','".$lastname."',".$gender.",'".$dob1."',".$bloodgroup.",'".$email."',".$country_id.",".$state_id.",".$city_id.",'".$address."','".$pin_code."','".$mob_code."','".$bloodgrouptype."',".$isMainPatientID.",'".$mobile_number."',0,'".$remark."',".$IdentificationTypeId.",'".$IdentityNo."',@OutPatientId OUTPUT,@OutAppointmentId OUTPUT ");
		//$result = $query->result();
        // echo $this->db->last_query();exit;
         $query = $this->db->query("SELECT @OutPatientId AS PatientId, @OutAppointmentId AS AppointmentId");
        // return $result->AppointmentId;
		return $result;
        //return $result->AppointmentId;
    }

    public function InsertAppointmentDetails($patientid, $location_id, $doctor_id, $department_id, $appointment_date, $from_time, $to_time, $firstname, $lastname, $gender, $dob1, $bloodgroup, $email, $country_id, $state_id, $city_id, $address, $pin_code, $mob_code, $bloodgrouptype, $isMainPatientID, $mobile_number, $appointment_reason_id, $remark, $IdentificationTypeId, $IdentityNo, $Apptype)
    {
        // Prepare stored procedure call with OUTPUT parameters
        // $sql = "DECLARE @OutPatientId INT, @OutAppointmentId INT; 
        //         EXEC usp_InsertAppointmentDetails ".$patientid.",".$location_id.",".$doctor_id.",".$department_id.",'".$appointment_date."','".$from_time."','".$to_time."','".$firstname."','".$lastname."',".$gender.",'".$dob1."',".$bloodgroup.",'".$email."',".$country_id.",".$state_id.",".$city_id.",'".$address."','".$pin_code."','".$mob_code."','".$bloodgrouptype."',".$isMainPatientID.",'".$mobile_number."',0,'".$remark."',".$IdentificationTypeId.",'".$IdentityNo."','".$Apptype."', @OutPatientId OUTPUT, @OutAppointmentId OUTPUT;
        //         SELECT @OutPatientId AS PatientId, @OutAppointmentId AS AppointmentId;";
         $sql = "EXEC usp_InsertAppointmentDetails ".$patientid.",".$location_id.",".$doctor_id.",".$department_id.",'".$appointment_date."','".$from_time."','".$to_time."','".$firstname."','".$lastname."',".$gender.",'".$dob1."',".$bloodgroup.",'".$email."',".$country_id.",".$state_id.",".$city_id.",'".$address."','".$pin_code."','".$mob_code."','".$bloodgrouptype."',".$isMainPatientID.",'".$mobile_number."',0,'".$remark."',".$IdentificationTypeId.",'".$IdentityNo."','".$Apptype."'";
        // echo $sql; exit; // Execute the stored procedure with parameter binding to prevent SQL injection
        $query = $this->db->query($sql);

        // Fetch the output parameters
        $result = $query->row();

        $query1 = $this->db->query("SELECT TOP (1) Id as AppointmentId FROM Appointment ORDER BY Id DESC");
        return $query1->row();
    }


    function getDoctorFromTenant($specialityId,$dayId)
    {
        $this->db->distinct("U.UserId");
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, U.SecondarySpecialityId, T.TenantId, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PM.SpecialityId, PSM.SpecialityDescription DoctorSpeciality, HM.Description as Prefix");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");       
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        // $this->db->join("DoctorImplementation DI","U.UserId = DI.RingDoctorId","LEFT");
        $this->db->join("DoctorWorkingHours DW","DW.UserId = U.UserId","LEFT");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->where("UR.RoleId", 12);
        $this->db->where("U.IsActive", 1);
		$this->db->where("PM.SpecialityId", $specialityId);
        $this->db->where("DW.DayMasterId", $dayId);
        // $this->db->group_by("DoctorId");
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function getDoctorFromTenantForUniversal($dayId)
    {
        $this->db->distinct("U.UserId");
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, U.SecondarySpecialityId, T.TenantId, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PM.SpecialityId, PSM.SpecialityDescription DoctorSpeciality, HM.Description as Prefix");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");       
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        // $this->db->join("DoctorImplementation DI","U.UserId = DI.RingDoctorId","LEFT");
        $this->db->join("DoctorWorkingHours DW","DW.UserId = U.UserId","LEFT");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->where("UR.RoleId", 12);
        $this->db->where("U.IsActive", 1);
        $this->db->where("DW.DayMasterId", $dayId);
        // $this->db->group_by("DoctorId");
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function getDoctorFromTenantSec($DoctorId,$specialityId)
    {
		$this->db->distinct('DoctorSpeciality');
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PSM.SpecialityDescription DoctorSpeciality");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = U.SecondarySpecialityId","LEFT");
		$this->db->where("U.UserId", $DoctorId);
        $this->db->where("U.SecondarySpecialityId", $specialityId);
        $this->db->where("U.IsActive", 1);
        $result = $this->db->get()->row();
        return $result;
    }

    function RescheduleAppointment($appointmentid,$appointmentdate,$fromtime,$totime,$remarks,$appointmentreason)
    { 
        $sp = 'EXEC usp_RescheduleAppointment';
		$query = $this->db->query(" $sp ".$appointmentid.",'".$appointmentdate."','".$fromtime."','".$totime."','".$appointmentreason."','".$remarks."' ");
		$result = $query->result();
		return $result;
    }

    function CancelAppointment($appointmentid,$appcancelreason)
    { 
        $sp = 'EXEC usp_CancelAppointment';
		$query = $this->db->query(" $sp ".$appointmentid.",'".$appcancelreason."' ");
		$result = $query->result();
		return $result;
    }

    function BookedTimeSlotForDoc($location_id,$doctor_id,$appointment_date,$flag)
    { 
        $sp = 'EXEC usp_DoctorTimeSlotListNew';
		$query = $this->db->query(" $sp ".$location_id.",".$doctor_id.",'".$appointment_date."','".$flag."' ");
		$result = $query->result();
        // echo $this->db->last_query();exit;
		return $result;
    }

    function getConfirmStatus($appointmentId)
    {
		$this->db->select("*");
        $this->db->from("Enrollment");
		$this->db->where("AppointmentId", $appointmentId);
        $result = $this->db->get()->row();
        return $result;
    }

    function appointmentDataById($Id){
		$this->db->select("*");
        $this->db->from("Appointment");
		$this->db->where("Id", $Id);
        $result = $this->db->get()->row();
        return $result;
	}

    function getDoctorsDetails($doctor_id){
        $this->db->select('U.UserId, U.LinkUserId, HM.Description Title, U.Username, U.DisplayName firstName, U.LastName, U.Email, U.PhoneNumber, PM.PractitionerCode, PM.MMCNumber, PM.IcNumber, PSM.SpecialityDescription');
        $this->db ->from('Users U');
        $this->db->where('U.LinkUserId',$doctor_id);
        $this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.Id = PM.SpecialityId");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId");
        $result = $this->db ->get()->row();
        return $result;
    }

    function getDoctorsTenants($doctor_id){
		$this->db->select("T.TenantId , T.TenantName , TT.TenantType");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");
        $this->db->join("TenantType TT","TT.TenantTypeId = T.TenantTypeId","LEFT");
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->where("UT.UserId", $doctor_id);
        $result = $this->db->get()->result();
        return $result;
	}

    function getEnrollmentDetails($enrollment_Id){
        $this->db->select("E.Id enrollmentId, E.EncounterNo, E.EnrollmentDate, E.AppointmentId, AP.AppointmentNo, AP.AppointmentDate, AP.FromTime, AP.ToTime, P.PatientId, P.FullName, P.LastName, T.TenantName");
        $this->db->from("Enrollment E");
        $this->db->join("Appointment AP","AP.Id = E.AppointmentId","LEFT");
        $this->db->join("PatientMaster P","P.PatientId = E.PatientId","LEFT");
        $this->db->join("Tenants T","T.TenantId = E.TenantId","LEFT");
        $this->db->where("E.Id", $enrollment_Id);
        $result = $this->db->get()->row();
        return $result;
    }

    function UserDataByAppointmentId($appointmentid){
        $this->db->select("AP.AppointmentNo, AP.AppointmentDate appointmentDate, AP.FromTime appointmentTime, AP.ToTime, P.PatientId, P.Email, P.FullName firstname, P.LastName, T.TenantName locName, T.Address locationAddress, U.DisplayName DoctorFName,U.LastName DoctorLName");
        $this->db->from("Appointment AP");
        $this->db->join("PatientMaster P","P.PatientId = AP.PatientId","LEFT");
        $this->db->join("Tenants T","T.TenantId = AP.TenantId","LEFT");
        $this->db->join("Users U","U.LinkUserId = AP.PractitionerId","LEFT");
        $this->db->where("AP.Id", $appointmentid);
        $result = $this->db->get()->row();
        return $result;
    }
    
    function InsertCallLog($insertArr){
        $result = $this->db->insert("CallLogs",$insertArr);
        return $result;
    }

    function enrollmentDatabyAppointmentId($AppointmentId){
        $this->db->select("*");
        $this->db->from("Enrollment");
        $this->db->where("AppointmentId", $AppointmentId);
        $result = $this->db->get()->row();
        return $result;
    }

    function getAppointmentDuration($UserId){
        $this->db->select("U.DoctorDurationId, DD.Duration");
        $this->db->from("Users U");
        $this->db->join("DoctorDurationMaster DD","DD.DoctorDurationMasterId = U.DoctorDurationId","LEFT");
        $this->db->where("U.UserId", $UserId);
        $result = $this->db->get()->row();
        return $result;
    }

    function getAppointmentDurationByPracId($pracId){
        $this->db->select("U.DoctorDurationId, DD.Duration");
        $this->db->from("Users U");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("DoctorDurationMaster DD","DD.DoctorDurationMasterId = U.DoctorDurationId","LEFT");
        $this->db->where("PM.ID", $pracId);
        $result = $this->db->get()->row();
        return $result;
    }

    function getAppPaymentId($PatientId){
        $this->db->select("Id");
        $this->db->from("AppointmentPaymentTransaction");
        $this->db->where("PatientId", $PatientId);
        $this->db->order_by("Id", "DESC");
        $this->db->LIMIT(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function updateAppointmentPaymentData($updateArray,$PatientId,$AppPaymentId){
        $this->db->where('Id',$AppPaymentId);
        $this->db->where('PatientId',$PatientId);
        $result = $this->db->update('AppointmentPaymentTransaction',$updateArray);
        return $result;
    }

    function chkCallLogData($appId){
        $this->db->select("CallLogsId,PatientCallStartTime");
        $this->db->from("CallLogs");
        $this->db->where("AppointmentId", $appId);
        $result = $this->db->get()->row();
        return $result;
    }

    function chkTelecallingSession($appId){
        $this->db->select("Id");
        $this->db->from("TelecallingSession");
        $this->db->where("AppointmentId", $appId);
        $result = $this->db->get()->row();
        //echo $this->db->last_query();exit;
        return $result;
    }
     function InsertTeleSession($sessArr){
        $result = $this->db->insert("TelecallingSession",$sessArr);
        return $result;
     }

    function updatePatientCallLog($updateArr,$CallLogsId){
        $this->db->where('CallLogsId',$CallLogsId);
        $result = $this->db->update('CallLogs',$updateArr);
        return $result;
    }

    function InsertTeleCallLog($insertArr){
        $result = $this->db->insert("TeleCallLogs",$insertArr);
        return $result;
    }

    function CheckLastTransactionforAppointment($PatientId,$PractitionerId){
        $this->db->select("*");
        $this->db->from("AppointmentPaymentTransaction");
        $this->db->where("PatientId", $PatientId);
        $this->db->where("PractitionerId", $PractitionerId);
        
        $this->db->order_by("Id", "DESC");
        $this->db->LIMIT(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function getDoctorLeave($doctor_id,$appointDate,$location_id){
        $this->db->select("UL.*");
        $this->db->from("UsersLeave UL");
        $this->db->join("Users U","U.UserId = UL.UserId","LEFT");
        $this->db->where("U.LinkUserId", $doctor_id);
        $this->db->where("UL.LeaveDate", $appointDate);
        $this->db->where("UL.TenantId", $location_id);
        $result = $this->db->get()->row();
        //echo $this->db->last_query();exit;
        return $result;
    }

    function CheckLastTransactionforAppointmentIOS($PatientId,$PractitionerId,$timeString){
        $this->db->select("*");
        $this->db->from("AppointmentPaymentTransaction");
        $this->db->where("PatientId", $PatientId);
        $this->db->where("PractitionerId", $PractitionerId);
        $this->db->where("InsertDate >", $timeString);
        $this->db->order_by("Id", "DESC");
        $this->db->LIMIT(1);
        $result = $this->db->get()->row();
        //echo $this->db->last_query();exit;
        return $result;
    }

    function insertCMSReportDownloadUpdate($insertArr){
        $result = $this->db->insert("CMSReportTransactions",$insertArr);
        return $result;
    }

    public function getAppointmentsBetween($fromTime, $toTime) {
        $this->db->select('A.PatientId,A.AppointmentDate,A.TenantId,A.FromTime,T.TenantName');
        $this->db->from('Appointment A');
        $this->db->join("Tenants T","T.TenantId = A.TenantId","LEFT");
        $this->db->where('A.FromTime >=', $fromTime);
        $this->db->where('A.FromTime <', $toTime);
        $query = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $query;
    }

    function InsertQuetoken($insertArr){
        $result = $this->db->insert("AppointmentQueToken",$insertArr);
        return $result;
    }

    function getLastQueOfDoctor($doctor_id,$date){
        $this->db->select("*");
        $this->db->from("AppointmentQueToken");
        $this->db->where("DoctorId", $doctor_id);
        $this->db->where("AppointmentDate =", $date);
        // $this->db->where("InsertDate >=", "CAST(GETDATE() AS DATE)", false);
        // $this->db->where("InsertDate <", "DATEADD(DAY, 1, CAST(GETDATE() AS DATE))", false);
        $this->db->order_by("Id", "DESC");
        $this->db->LIMIT(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function getLastQueOfPatient($patientId){
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("AppointmentQueToken");
        $this->db->where("PatientId", $patientId);        
        $this->db->where("AppointmentDate =", $date);
        // $this->db->where("InsertDate >=", "CAST(GETDATE() AS DATE)", false);
        // $this->db->where("InsertDate <", "DATEADD(DAY, 1, CAST(GETDATE() AS DATE))", false);
        $this->db->order_by("Id", "DESC");
        $result = $this->db->get()->result();
        return $result;
    }

    public function checkUserInUserMRN($PatientId, $RingGroupId){
        $this->db->from('UserMRN');
        $this->db->where('RINGID', $PatientId);
        if($RingGroupId != '') $this->db->where('RingGroupId', $RingGroupId);
        return $this->db->get()->row_array();
    }

    // Check in PatientMaster table
    public function checkUserInPatientMaster($email, $name, $passportNo){
        $this->db->from('PatientMaster');
        $this->db->where('Email', $email);
        $this->db->where('FullName', $name);
        $this->db->where('IdentityNo', $passportNo);
        return $this->db->get()->row_array();
    }

    // Insert in UserMRN table
    public function insertUserInUserMRN($data){
        $this->db->insert('UserMRN', $data);
        return $this->db->insert_id();
    }

    function userVerification($ringId,$ringGroupId){
        $this->db->select("*");
        $this->db->from("UserMRN");
        $this->db->where('RINGID',$ringId);
        if($ringGroupId != '') $this->db->where('RingGroupId',$ringGroupId);
        $result = $this->db->get()->row();
        return $result;
    }

    public function getPRNByPatientAndTenants($patientId, $ringGroupId)
    {
        $this->db->select('E.PRN, E.PatientId, E.TenantId');
        $this->db->from('Enrollment E');  
        $this->db->join("RingGroupTenants RT","RT.TenantId = E.TenantId","LEFT");
        $this->db->where('E.PatientId', $patientId);
        $this->db->where('RT.RingGroupId', $ringGroupId);
        $result = $this->db->get()->row();
        return $result;
    }

    public function AppointmentListForDoctor($doctorId,$selectDate,$tenantId){
        $query = $this->db->query(" select App.Id as ID,        
        U.DisplayName+' '+isnull(U.LastName,'') as DoctorName,        
        App.PractitionerId as DoctorID,        
        App.PatientId as PatientID,        
        Null as HIEID,        
        App.AppointmentDate,        
        App.FromTime as StartTime,        
        App.ToTime as EndTime,        
        P.FullName as PatFirstname,        
        P.LastName as PatLastname,        
        1 as Status,        
        App.AppointmentType as bookingType,        
        P.IdentificationTypeId,        
        P.IdentityNo,        
        P.IdentityNo as IdentityNoNRIC,        
        NULL as IsNonPP,        
        NULL as AddedBy,        
        App.AppointmentReason as reason,        
        NULL as appointmentreasonid,        
        T.TenantName as HospitalName,        
        T.TenantId as locationid,        
        App.Remarks,        
        T.PhoneNumber as HospitalMobNumber,        
        NULL as SearchDate,        
        NULL as SearchTime,        
        NULL as SearchStartTime,        
        NULL as DepartmentId,        
        NULL as DepartmentDesc,        
        App.PractitionerId as ServiceProviderID,        
        NULL as appCount,        
        NULL as isacknowledge,        
        NULL as isenabled,        
        NULL as ticketnumber,        
        NULL as cancelledapt,                                                              
        NULL as appcancelreason,        
        NULL as visitmark,        
        NULL as bookingtype,        
        NULL as isReportGenerated,        
        App.PatientId as ringId,        
        App.AppointmentDate as appointmentDateTime  ,  
        PSM.ID as SpecialityId,  
        PSM.SpecialityDescription ,  
        PSM1.ID As SecondarySpecialityId,  
        PSM1.SpecialityDescription as SecondarySpecialityDescription  ,
        T.Latitude as Latitude , T.Longitude
        from Appointment App        
        INNER JOIN Users U ON App.PractitionerId = U.LinkUserId        
        INNER JOIN PatientMaster P on App.PatientId = P.PatientId        
        INNER JOIN Tenants T on App.TenantId = T.TenantId    
        LEFT JOIN PractitionerSpecialityMaster PSM on U.SpecialityId = PSM.ID  
        LEFT JOIN PractitionerSpecialityMaster PSM1 on U.SecondarySpecialityId = PSM.ID  
        
        where App.AppointmentStatusId = 3 AND App.AppointmentDate = '".$selectDate."' AND T.TenantId = ".$tenantId." AND U.UserId = ".$doctorId );   
        $result = $query->result_array(); 
        // echo $this->db->last_query();exit;
        return $result;
    }

    public function QueueAppointmentListForDoctor($doctorId,$selectDate,$tenantId){
        $query = $this->db->query(" select App.Id as ID,        
        U.DisplayName+' '+isnull(U.LastName,'') as DoctorName,        
        App.PractitionerId as DoctorID,        
        App.PatientId as PatientID,        
        Null as HIEID,        
        App.AppointmentDate,        
        App.FromTime as StartTime,        
        App.ToTime as EndTime, 
        E.EncounterNo, 
        E.PRN,
        E.PatientStatusId,   
        P.FullName as PatFirstname,        
        P.LastName as PatLastname,        
        1 as Status,        
        App.AppointmentType as bookingType,        
        P.IdentificationTypeId,        
        P.IdentityNo,        
        P.IdentityNo as IdentityNoNRIC,        
        NULL as IsNonPP,        
        NULL as AddedBy,        
        App.AppointmentReason as reason,        
        NULL as appointmentreasonid,        
        T.TenantName as HospitalName,        
        T.TenantId as locationid,        
        App.Remarks,        
        T.PhoneNumber as HospitalMobNumber,        
        NULL as SearchDate,        
        NULL as SearchTime,        
        NULL as SearchStartTime,        
        NULL as DepartmentId,        
        NULL as DepartmentDesc,        
        App.PractitionerId as ServiceProviderID,        
        NULL as appCount,        
        NULL as isacknowledge,        
        NULL as isenabled,        
        NULL as ticketnumber,        
        NULL as cancelledapt,                                                              
        NULL as appcancelreason,        
        NULL as visitmark,        
        NULL as bookingtype,        
        NULL as isReportGenerated,        
        App.PatientId as ringId,        
        App.AppointmentDate as appointmentDateTime  ,  
        PSM.ID as SpecialityId,  
        PSM.SpecialityDescription ,  
        PSM1.ID As SecondarySpecialityId,  
        PSM1.SpecialityDescription as SecondarySpecialityDescription  ,
        T.Latitude as Latitude , T.Longitude
        from Appointment App
        LEFT JOIN Enrollment E on E.AppointmentId = App.Id          
        INNER JOIN Users U ON App.PractitionerId = U.LinkUserId        
        INNER JOIN PatientMaster P on App.PatientId = P.PatientId        
        INNER JOIN Tenants T on App.TenantId = T.TenantId    
        LEFT JOIN PractitionerSpecialityMaster PSM on U.SpecialityId = PSM.ID  
        LEFT JOIN PractitionerSpecialityMaster PSM1 on U.SecondarySpecialityId = PSM.ID  
        
        where E.PatientStatusId != '' AND App.AppointmentDate = '".$selectDate."' AND T.TenantId = ".$tenantId." AND U.UserId = ".$doctorId );   
        $result = $query->result_array(); 
        // echo $this->db->last_query();exit;
        return $result;
    }

    public function findPatientByDetails2($prn, $identityNo, $fullName, $mobileNumber)
    {
        $this->db->select('*');
        $this->db->from('PatientMaster');
        $this->db->group_start();   
            if(!empty($prn) && $prn != "NULL") {
                $this->db->where('Prn', $prn);
            }
            if(!empty($identityNo) && $identityNo != "NULL") {
                $this->db->or_where('IdentityNo', $identityNo);
            }
            if(!empty($fullName) && $fullName != "NULL") {
                $this->db->or_where('FullName', $fullName);
            }
            if(!empty($mobileNumber) && $mobileNumber != "NULL") {
                $this->db->or_where('MobileNumber', $mobileNumber);
            }    
        $this->db->group_end();
        $this->db->where('IsActive', 1);   
        $query = $this->db->get(); 
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function findPatientByDetails($prn, $identityNo, $fullName, $mobileNumber)
    {
        $this->db->select('PatientId');
        $this->db->from('PatientMaster');
        $this->db->group_start();   
            if(!empty($prn) && $prn != "NULL") {
                $this->db->where('Prn', $prn);
            }
            if(!empty($identityNo) && $identityNo != "NULL") {
                $this->db->or_where('IdentityNo', $identityNo);
            }
            if(!empty($fullName) && $fullName != "NULL") {
                $this->db->or_where('FullName', $fullName);
            }
            if(!empty($mobileNumber) && $mobileNumber != "NULL") {
                $this->db->or_where('MobileNumber', $mobileNumber);
            }    
        $this->db->group_end();
        $this->db->where('IsActive', 1);   
        $query = $this->db->get(); 
        if($query->num_rows() > 0){
            return $query->row()->PatientId;
        } else {
            return false;
        }
    }
}