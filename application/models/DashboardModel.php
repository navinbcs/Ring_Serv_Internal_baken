<?php
class DashboardModel extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getDoctorsDetails($doctor_id){
        $this->db->select('U.UserId, U.LinkUserId, HM.Description Title, U.Username, U.DisplayName FirstName, U.LastName, U.Email, U.PhoneNumber, PM.PractitionerCode, PM.MMCNumber, PM.IcNumber, PSM.SpecialityDescription, R.RoleId, R.RoleName Role');
        $this->db ->from('Users U');
        $this->db->where('U.LinkUserId',$doctor_id);
        $this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.Id = PM.SpecialityId");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("Roles R","UR.RoleId = R.RoleId","LEFT");
        $result = $this->db ->get()->row();
        return $result;
    }

    function getAppointmentCount($doctorId,$start,$end)
    {
        $this->db->select("count(Id) as APPCount");
        $this->db->from("Appointment");

        if(!empty($doctorId))
        $this->db->where("PractitionerId",$doctorId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    function getAppointmentCountWithTenant($doctorId, $tenantId,$start,$end)
    {
        $this->db->select("count(Id) as APPCount");
        $this->db->from("Appointment");

        if(!empty($doctorId))
        $this->db->where("PractitionerId",$doctorId);
        $this->db->where("TenantId", $tenantId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    function getTodayAppointmentCount($doctorId)
    {
        $start = date('Y-m-d 00:00:00');
        $end   = date('Y-m-d 23:59:59');

        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        if(!empty($doctorId))
        $this->db->where("PractitionerId", $doctorId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    function getTodayAppointmentCountWithTenant($doctorId, $tenantId)
    {   // echo $doctorId ; exit ;
        $start = date('Y-m-d 00:00:00');
        $end   = date('Y-m-d 23:59:59');

        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        if(!empty($doctorId))
        $this->db->where("PractitionerId", $doctorId);
        $this->db->where("TenantId", $tenantId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    function getTodayRestAppointmentCount($doctorId,$start,$end)
    {
        $start = date('Y-m-d h:i:s');
        $end   = date('Y-m-d 23:59:59');
        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        if(!empty($doctorId))
        $this->db->where("PractitionerId", $doctorId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    function getTodayRestAppointmentCountWithTenant($doctorId, $tenantId,$start,$end)
    {
        $start = date('Y-m-d h:i:s');
        $end   = date('Y-m-d 23:59:59');
        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        if(!empty($doctorId))
        $this->db->where("PractitionerId", $doctorId);
        $this->db->where("TenantId", $tenantId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    function getEnrollmentCountWithTenant($doctorId, $tenantId,$start,$end)
    {
        $this->db->select("count(Id) as EnrollCount");
        $this->db->from("Enrollment");

        if(!empty($doctorId))
        $this->db->where("PrimaryPractitionerId",$doctorId);
        $this->db->where("TenantId", $tenantId);
        $this->db->where("EnrollmentDate >=", $start);
        $this->db->where("EnrollmentDate <=", $end);
        $result = $this->db->get()->row();  

       // echo $this->db->last_query(); exit ;
        return $result;
    }

    function getEnrollmentCount($doctorId,$start,$end)
    {
        $this->db->select("count(Id) as EnrollCount");
        $this->db->from("Enrollment");

        if(!empty($doctorId))
        $this->db->where("PrimaryPractitionerId",$doctorId);
        $this->db->where("EnrollmentDate >=", $start);
        $this->db->where("EnrollmentDate <=", $end);
        $result = $this->db->get()->row();
        return $result;
    }

    public function getUnenrolledPatientCount($doctorId,$tenantId,$startDate,$endDate)
    {

        $now = new DateTime();
        $monday = (clone $now)->modify('monday this week')->setTime(0, 0, 0);
        $todayEnd = (clone $now)->setTime(23, 59, 59);

        // Accept strings or DateTime; fallback if null/empty
        $start = $startDate ? new DateTime($startDate) : $monday;
        $end   = $endDate   ? new DateTime($endDate)   : $todayEnd;

        // Ensure full-day bounds
        $start->setTime(0, 0, 0);
        $end->setTime(23, 59, 59);

        $startSql = $start->format('Y-m-d H:i:s');
        $endSql   = $end->format('Y-m-d H:i:s');
        // $this->db->select('COUNT(DISTINCT A.PatientId) as unenrolled_count');
        $this->db->select('COUNT(A.PatientId) as unenrolled_count');
        $this->db->from('Appointment A');
        $this->db->join('Enrollment E', 'A.PatientId = E.PatientId', 'LEFT');

        // $this->db->where('A.PractitionerId', $doctorId);
        $this->db->where('A.AppointmentDate >=', $startSql);  
        $this->db->where('A.AppointmentDate <=', $endSql);    

        $this->db->where('E.PatientId IS NULL'); 

        if(!empty($doctorId))
        $this->db->where("A.PractitionerId",$doctorId);

        if(!empty($tenantId))
        $this->db->where("A.TenantId",$tenantId);
        // $this->db->where("E.PrimaryPractitionerId",$doctorId);
        $result = $this->db->get()->row();
    // echo  $this->db->last_query(); exit ;
        return $result;
    }

    function ICDListbyUser($doctorId,$tenantId,$start,$end){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $this->db->select("ET.PatientMasterId,ET.ReportTransitId,ET.InsertDate, IC.ICDSubCode, IC.ICDSubCodeDescription");
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");     
        $this->db->join("ICDMaster IC","IC.Id = ET.IcdMasterId","LEFT");

         if(!empty($doctorId))
        $this->db->where('U.LinkUserId',$doctorId);
        $this->db->where('ET.IcdMasterId !=', 0);
         $this->db->where('ET.TenantId', $tenantId);
        
        $this->db->where("ET.InsertDate >=", $start);
        $this->db->where("ET.InsertDate <=", $end);
		$this->db->order_by('ET.ReportTransitId','DESC');
        $this->db->limit(10);
        $result = $this->db ->get()->result();
        return $result;
    }

    public function getActiveTanents($q = '', $limit = 20, $offset = 0)
    {
        $this->db->select('T.TenantId, T.TenantCode, T.TenantName')
                ->from('Tenants T')
                ->where('T.IsActive', 1);

        if ($q !== '') {
            $qEsc = $this->db->escape_like_str($q);
            $this->db->group_start()
                    ->like('T.TenantName', $qEsc)
                    ->or_like('T.TenantCode', $qEsc)
                    ->group_end();
        }

        $this->db->order_by('T.TenantName', 'ASC')
                ->limit($limit, $offset);

        return $this->db->get()->result_array();
    }

    public function countActiveTenants($q = '')
    {
        $this->db->from('Tenants T')
                ->where('T.IsActive', 1);

        if ($q !== '') {
            $qEsc = $this->db->escape_like_str($q);
            $this->db->group_start()
                    ->like('T.TenantName', $qEsc)
                    ->or_like('T.TenantCode', $qEsc)
                    ->group_end();
        }

        return (int) $this->db->count_all_results();
    }


public function getDoctorsByTenants($tenant, $q = '', $limit = 50, $offset = 0)
{
    $tenant = (int) $tenant;

    $this->db->distinct(); // avoid dupes from joins
    $this->db->select("
        U.UserId AS DoctorId,
        COALESCE(
            NULLIF(LTRIM(RTRIM(ISNULL(U.DisplayName,'') + ' ' + ISNULL(U.LastName,''))), ''),
            U.Username
        ) AS DoctorName
    ", false); // false => don't escape SQL functions

    $this->db->from("UserTenants UT");
    $this->db->join("Users U", "U.UserId = UT.UserId", "INNER");
    $this->db->join("UserRoles UR", "UR.UserId = U.UserId", "INNER");

    // doctors only
    $this->db->where("UR.RoleId", 12);

    // filter by clinic/tenant
    if(!empty($tenant))
    $this->db->where("UT.TenantId", $tenant);

    // optional search across Username and Full Name
    if ($q !== '') {
        $this->db->group_start();
        $this->db->like("U.Username", $q, 'both'); // normal field
        // LIKE on an expression → don't escape the field string
        $this->db->or_like("LTRIM(RTRIM(ISNULL(U.DisplayName,'') + ' ' + ISNULL(U.LastName,'')))", $q, 'both', false);
        $this->db->group_end();
    }

    $this->db->order_by("DoctorName", "ASC");
    $this->db->limit($limit, $offset);

    return $this->db->get()->result_array();
}


    function getDoctorsList(){
        $this->db->select("U.UserId as DoctorId, U.Username as DoctorName","CAST(NULLIF(LTRIM(RTRIM(ISNULL(U.DisplayName,'') + ' ' + ISNULL(U.LastName,''))), '') ) AS DcN");
        $this->db->from('Users U');
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->where("UR.RoleId", 12);
        $this->db->where('U.IsActive', 1);
        $result = $this->db->get()->result();
        return $result;
    }

    function getDoctorsInfo($doctorId){
        $this->db->select('U.UserId, U.LinkUserId, U.Username, U.DisplayName FirstName, U.LastName, U.Email, U.PhoneNumber, R.RoleId, R.RoleName Role');
        $this->db->from('Users U');
        $this->db->where('U.UserId',$doctorId);
        // $this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId");
        // $this->db->join("PractitionerSpecialityMaster PSM","PSM.Id = PM.SpecialityId");
        // $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("Roles R","UR.RoleId = R.RoleId","LEFT");
        return $this->db->get()->row();
    }

    function getAllAppointments($doctorId)
    {
        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        $this->db->where("PractitionerId",$doctorId);
        return $this->db->get()->row();
    }

    function getTodayAppointments($doctorId)
    {
        $start = date('Y-m-d 00:00:00');
        $end   = date('Y-m-d 23:59:59');

        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        $this->db->where("PractitionerId", $doctorId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        return $this->db->get()->row();
    }

    function getRemainingAppointments($doctorId)
    {
        $start = date('Y-m-d H:i:s');
        $end   = date('Y-m-d 23:59:59');

        $this->db->select("COUNT(Id) as APPCount");
        $this->db->from("Appointment");
        $this->db->where("PractitionerId", $doctorId);
        $this->db->where("AppointmentDate >=", $start);
        $this->db->where("AppointmentDate <=", $end);
        return $this->db->get()->row();
    }

    function getAllEnrollments($doctorId)
    {
        $this->db->select("COUNT(Id) as EnrollCount");
        $this->db->from("Enrollment");
        $this->db->where("PrimaryPractitionerId",$doctorId);
        return $this->db->get()->row();
    }

    public function getUnenrolledPatients($doctorId,$startDate,$endDate)
        {
            $start = new DateTime($startDate);
            $end   = new DateTime($endDate);
            $start->setTime(0,0,0);
            $end->setTime(23,59,59);

            $this->db->select('COUNT(DISTINCT A.PatientId) as UnenrolledCount');
            $this->db->from('Appointment A');
            $this->db->join('Enrollment E', 'A.PatientId = E.PatientId', 'LEFT');

            $this->db->where('A.PractitionerId', $doctorId);
            $this->db->where('A.AppointmentDate >=', $start->format('Y-m-d H:i:s'));
            $this->db->where('A.AppointmentDate <=', $end->format('Y-m-d H:i:s'));
            $this->db->where('E.PatientId IS NULL'); 

            return $this->db->get()->row();
        }

        // Case 1: Single doctor
    public function getDashboardDataByDoctor($doctorId, $startDate, $endDate, $filter,$tenant=0) {
        $resultArr = [];

        $resultArr["Userdata"]          = $this->getDoctorsDetails($doctorId);
        $resultArr["TodayAppCount"]     = $this->getTodayAppointmentCount($doctorId)->APPCount;
        $resultArr["TodayRestAppCount"] = $this->getTodayRestAppointmentCount($doctorId, $startDate, $endDate)->APPCount;
        $resultArr["APPCount"]          = $this->getAppointmentCount($doctorId, $startDate, $endDate)->APPCount;
        $resultArr["EnrollCount"]       = $this->getEnrollmentCount($doctorId, $startDate, $endDate)->EnrollCount;
        $resultArr["unenrolled_count"]  = $this->getUnenrolledPatientCount($doctorId,"", $startDate, $endDate)->unenrolled_count;
        $resultArr["ICD_list"]          = $this->ICDListbyUser($doctorId, $startDate, $endDate,$tenant);
        $resultArr["patient_demography"]= $this->Analytics_model->get_age_gender_distribution($filter);

        return $resultArr;
    }

    public function getDashboardDataByDoctorWithTenant($doctorId, $tenantId, $startDate, $endDate, $filter) {
        $resultArr = [];
       //   print_r( $filter); exit ;
        $resultArr["Userdata"]          = $this->getDoctorsDetails($doctorId);
        $resultArr["TodayAppCount"]     = $this->getTodayAppointmentCountWithTenant($doctorId, $tenantId)->APPCount;
        $resultArr["TodayRestAppCount"] = $this->getTodayRestAppointmentCountWithTenant($doctorId, $tenantId, $filter['from_date'], $filter['to_date'])->APPCount;
        $resultArr["APPCount"]          = $this->getAppointmentCountWithTenant($doctorId, $tenantId,  $filter['from_date'],$filter['to_date'])->APPCount;
        $resultArr["EnrollCount"]       = $this->getEnrollmentCountWithTenant($doctorId, $tenantId,  $filter['from_date'],$filter['to_date'])->EnrollCount;
        $resultArr["unenrolled_count"]  = $this->getUnenrolledPatientCount($doctorId, $tenantId,  $filter['from_date'],$filter['to_date'])->unenrolled_count;
        $resultArr["ICD_list"]          = $this->ICDListbyUser($doctorId, $tenantId,  $filter['from_date'],$filter['to_date']);
        $resultArr["patient_demography"]= $this->Analytics_model->get_age_gender_distribution($filter);

        return $resultArr;
    }

    public function getDoctorPracId($doctorId){
        $this->db->select('U.LinkUserId');
        $this->db->from('Users U');
        $this->db->where('U.LinkUserId',$doctorId);
        return $this->db->get()->row();
    }
    // Case 2: Tenant-wise (sum of all doctors)
    public function getDashboardDataByTenant($tenantId, $startDate, $endDate, $filter) {
        $resultArr = [];

        // All doctors under this tenant
        $doctors = $this->db->select("LinkUserId as DoctorId")
                            ->from("Users")
                            ->where("TenantId", $tenantId)
                            ->where("LinkUserId IS NOT NULL")
                            ->get()->result();

        $aggregate = [
            "TodayAppCount" => 0,
            "TodayRestAppCount" => 0,
            "APPCount" => 0,
            "EnrollCount" => 0,
            "unenrolled_count" => 0,
            "ICD_list" => [],
        ];

        foreach ($doctors as $doc) {
            $docData = $this->getDashboardDataByDoctor($doc->DoctorId, $startDate, $endDate, $filter);

            $aggregate["TodayAppCount"]     += $docData["TodayAppCount"];
            $aggregate["TodayRestAppCount"] += $docData["TodayRestAppCount"];
            $aggregate["APPCount"]          += $docData["APPCount"];
            $aggregate["EnrollCount"]       += $docData["EnrollCount"];
            $aggregate["unenrolled_count"]  += $docData["unenrolled_count"];
            $aggregate["ICD_list"]          = array_merge($aggregate["ICD_list"], $docData["ICD_list"]);
        }

        $aggregate["patient_demography"] = $this->Analytics_model->get_age_gender_distribution($filter);

        return $aggregate;
    }

    // Case 3: All doctors in system
    public function getDashboardDataAllDoctors($startDate, $endDate, $filter) {
        $resultArr = [];

        $doctors = $this->db->select("LinkUserId as DoctorId")
                            ->from("Users")
                            ->where("LinkUserId IS NOT NULL")
                            ->get()->result();

        $aggregate = [
            "TodayAppCount" => 0,
            "TodayRestAppCount" => 0,
            "APPCount" => 0,
            "EnrollCount" => 0,
            "unenrolled_count" => 0,
            "ICD_list" => [],
        ];

        foreach ($doctors as $doc) {
            $docData = $this->getDashboardDataByDoctor($doc->DoctorId, $startDate, $endDate, $filter);

            $aggregate["TodayAppCount"]     += $docData["TodayAppCount"];
            $aggregate["TodayRestAppCount"] += $docData["TodayRestAppCount"];
            $aggregate["APPCount"]          += $docData["APPCount"];
            $aggregate["EnrollCount"]       += $docData["EnrollCount"];
            $aggregate["unenrolled_count"]  += $docData["unenrolled_count"];
            $aggregate["ICD_list"]          = array_merge($aggregate["ICD_list"], $docData["ICD_list"]);
        }

        $aggregate["patient_demography"] = $this->Analytics_model->get_age_gender_distribution($filter);

        return $aggregate;
    }

    public function getDoctorDetails($doctorId) {
        $this->db->select('U.UserId, U.LinkUserId, U.Username, U.DisplayName FirstName, U.LastName, U.Email, U.TenantId, U.PhoneNumber, R.RoleId, R.RoleName Role');
        $this->db->from('Users U');
        $this->db->where('U.LinkUserId',$doctorId);
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("Roles R","UR.RoleId = R.RoleId","LEFT");
        return $this->db->get()->row();  
    }

    public function getBillingStatsByTenant($tenantId, $startDate, $endDate)
    {
        $start = date('Y-m-d 00:00:00', strtotime($startDate));
        $end   = date('Y-m-d 23:59:59', strtotime($endDate));

        //Billing Completed (PatientStatusId = 3)
        $this->db->select("COUNT(Id) as BillingCompleted");
        $this->db->from("Enrollment");
        $this->db->where("TenantId", $tenantId);
        $this->db->where("PatientStatusId", 3);
        $this->db->where("EnrollmentDate >=", $start);
        $this->db->where("EnrollmentDate <=", $end);
        $billingCompleted = $this->db->get()->row()->BillingCompleted;

        //Waiting Queue (PatientStatusId = 1)
        $this->db->select("COUNT(Id) as WaitingQueue");
        $this->db->from("Enrollment");
        $this->db->where("TenantId", $tenantId);
        $this->db->where("PatientStatusId", 1);
        $this->db->where("EnrollmentDate >=", $start);
        $this->db->where("EnrollmentDate <=", $end);
        $waitingQueue = $this->db->get()->row()->WaitingQueue;

        //In Consultation (PatientStatusId = 2)
        $this->db->select("COUNT(Id) as InConsultation");
        $this->db->from("Enrollment");
        $this->db->where("TenantId", $tenantId);
        $this->db->where("PatientStatusId", 2);
        $this->db->where("EnrollmentDate >=", $start);
        $this->db->where("EnrollmentDate <=", $end);
        $InConsultation = $this->db->get()->row()->InConsultation;

        //Pending Billing (PatientStatusId = 4)
        $this->db->select("COUNT(Id) as PendingBilling");
        $this->db->from("Enrollment");
        $this->db->where("TenantId", $tenantId);
        $this->db->where("PatientStatusId", 4);
        $this->db->where("EnrollmentDate >=", $start);
        $this->db->where("EnrollmentDate <=", $end);
        $PendingBilling = $this->db->get()->row()->PendingBilling;

        // Appointment count (based on all doctors in this tenant)
        $appointmentCount = $this->db->select("COUNT(A.Id) as AppointmentCount")
                                    ->from("Appointment A")
                                    ->join("Users U", "U.LinkUserId = A.PractitionerId", "LEFT")
                                    ->where("U.TenantId", $tenantId)
                                    ->where("A.AppointmentDate >=", $start)
                                    ->where("A.AppointmentDate <=", $end)
                                    ->get()->row()->AppointmentCount;

        return [
            "BillingCompleted" => (int)$billingCompleted,
            "WaitingQueue"     => (int)$waitingQueue,
            "InConsultation" => (int)$InConsultation,
            "PendingBilling" => (int)$PendingBilling,
            "AppointmentCount" => (int)$appointmentCount
        ];
    }

    public function isPermissionAllowed($tenantId, $ringGroupId)
    {
        $this->db->select("*");
        $this->db->from('ApplicationSpecialPermission APS');
        // $this->db->join("Tenants T","T.TenantId = APS.TenantId","LEFT");
        // $this->db->join("RingGroupTenants RG","RG.TenantId = T.TenantId");
        $this->db->where('APS.TenantId', $tenantId);
		$this->db->or_where('APS.RingGroupId',$ringGroupId);
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }
 public function getUserPermissionDetails($UserId)
{
     $this->db
        ->select('*')
        ->from('UserPermissions')
        ->where('UserId', $UserId)
        ->like('PermissionKey', ':ViewMenu', 'before')   // matches any value ending with :ViewMenu
        ->where('Granted', 1)                            // keep only granted permissions
        ->get()
        ->result(); echo  $this->db->last_query(); exit ;
}


    public function getRingGroupId($tenantId){
        $this->db->select('RG.RingGroupId ID');
        $this->db->from('RingGroupTenants RG');
        $this->db->where('RG.TenantId', $tenantId);
        $result = $this->db->get()->row();
        return $result;
    }

    function getDoctorFromTenant($tenantId)
    {
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, U.SecondarySpecialityId, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PSM.SpecialityDescription DoctorSpeciality, HM.Description as Prefix");
        
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");      
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->where("UT.TenantId", $tenantId);
        $this->db->where("UR.RoleId", 12);
        $this->db->where("U.IsActive", 1);
        $result = $this->db->get()->result();
        return $result;
    }
}