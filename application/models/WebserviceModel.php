<?php
class WebserviceModel extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


function signUp($data)
{ 
  $result = $this->db->insert("PatientMaster",$data);

   $insert_id = $this->db->insert_id();
  // echo $this->db->last_query();exit;
  return $insert_id;
}

function saveReportData($data)
{

  
  $result = $this->db->insert("EReports",$data);
  // echo $this->db->last_query();exit;
  return $result;
}
public function updateUserData($data,$id){

    $this->db->where('PatientId',$id);
   $result =  $this->db->update('PatientMaster',$data);
//   echo $this->db->last_query();exit;
  return $result;
}
public function getdoctorlist(){
        $this->db->select('*');
        $this->db ->from('hospital_doctor');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getMasterHospitallist(){
        $this->db->select('*');
        $this->db ->from('master_hospital');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getUserData(){
        $this->db->select('*');
        $this->db ->from('PatientMaster');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getMobileCodeIdFromMobileCode($mob_code){
        $this->db->select('ID');
        $this->db->from('CountryMaster');
        $this->db->where('PhoneCode',$mob_code);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
        return $result;
}

public function getUserDataById($user_id){
        $this->db->select('PatientMaster.*, BloodGroupMaster.BloodGroupCode bloodgroup, BloodGroupMaster.BloodGroup bloodgroupDes');
        $this->db ->from('PatientMaster');
        $this->db->join("BloodGroupMaster","BloodGroupMaster.BloodGroupId = PatientMaster.BloodGroupId","LEFT");
        $this->db ->where('PatientId',$user_id);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getPatientAddressById($PatientId){
    $this->db->select('C.CountryDescription Country, S.StateDescription State, CT.CityDescription City');
    $this->db ->from('PatientMaster P');    
    $this->db->join("CountryMaster C","C.ID = P.CountryMasterId","LEFT");
    $this->db->join("StateMaster S","S.ID = P.StateMasterId","LEFT");
    $this->db->join("CityMaster CT","CT.ID = P.CityMasterId","LEFT");
    $this->db ->where('PatientId',$PatientId);
    $result = $this->db ->get()->row();
    return $result;
}

public function getReportlistByUser($user_id){
        $patientData = $this->db->select("p.*,e.id enr_id")
                ->from("PatientMaster as pm")
                ->join("patient p","p.MobilePhone=pm.MobileNumber","left")
                ->join("Enrollment e","p.PatientId=e.PatientId","left")
                ->where("pm.PatientId",$user_id)->get()->row();

    //  print_r($patientData);
    //   echo $this->db->last_query();
    //     exit;

        // $this->db->select('et.*, c.Category  cname, T.TenantName');
        $this->db->select('et.*, T.TenantName');
        $this->db ->from('EreportsTransit et');
        // $this->db->join("CategoryMaster c","c.CategoryId=et.CategoryId");
        $this->db->join("Tenants T","T.TenantId=et.TenantId");
        $this->db ->where('et.PatientMasterId',$user_id);
        $this->db ->where('et.isProcessed',0);
        $this->db ->order_by('et.ReportTransitId','desc');
        $result = $this->db ->get()->result();

   
        
            return $result;
}
public function getReportlistByDoc(){
        $this->db->select('*');
        $this->db ->from('EReports');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getRxReportlistByUser($user_id){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('PatientId',$user_id);
        $this->db ->where('CategoryId','1');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getRxReportlistByDoc(){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('CategoryId','1');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getLabReportlistByUser($user_id){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('PatientId',$user_id);
        $this->db ->where('CategoryId','2');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function getLabReportlistByDoc(){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('CategoryId','2');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}
public function getRadioReportlistByUser($user_id){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('PatientId',$user_id);
        $this->db ->where('CategoryId','3');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}
public function getRadioReportlistByDoc(){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('CategoryId','3');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}
public function getClinicalReportlistByUser($user_id){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('PatientId',$user_id);
        $this->db ->where('CategoryId','4');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function ggetClinicalReportlistByDoc(){
        $this->db->select('*');
        $this->db ->from('EReports');
        $this->db ->where('CategoryId','4');
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}


public function HospitalFilter($name){
        $this->db->select('*');
        $this->db ->from('Tenants');
        $this->db->like('TenantName', $name);
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
}

public function checkOtp($otp){
        $this->db->select('*');
        $this->db ->from('PatientMaster');
        $this->db ->where('OTP',$otp);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
}

public function checkOtpForDoctor($otp){
        $this->db->select('*');
        $this->db ->from('Users');
        $this->db ->where('OTP',$otp);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
}
	
		public function checkDoctorAuth($userName,$password){
			$this->db->select('*');
			$this->db ->from('Users');
			$this->db ->where('Email',$userName);
			$this->db ->where('PasswordHash',$password);
			$result = $this->db ->get()->row();
			return $result;
		}

function checkDuplicateMobileno($mob_code,$mobileno,$email){
    $this->db->select("*");
    $this->db->from('PatientMaster');
    $this->db->where('PatientMaster.MobileCode', $mob_code);
    $this->db->where('PatientMaster.MobileNumber', $mobileno);
    $this->db->or_where('PatientMaster.Email', $email);
    $result = $this->db->get()->result();
    // echo $this->db->last_query();exit;
    return $result;
}

function DuplicateMobileNumber($mobileno){
    $this->db->select("*");
    $this->db->from('PatientMaster');
    $this->db->where('MobileNumber', $mobileno);
    $result = $this->db->get()->result();
    return $result;
}

    public function checkUser($mobile_number,$mob_code){
        $this->db->select('*');
        $this->db ->from('PatientMaster');
        $this->db ->where('MobileNumber',$mobile_number);
         $this->db ->where('MobileCode',$mob_code);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
    }

    public function checkDoctor($mobile_number){
        $this->db->select('*');
        $this->db ->from('Users');
        $this->db ->where('PhoneNumber',$mobile_number);
        $result = $this->db ->get()->row();
        return $result;
    }

        public function checkuserid($id,$userType){
        $this->db->select('*');
        $this->db ->from('Notification');
        $this->db ->where('PatientId',$id);
        $this->db ->where('IsNotify',0);
        $this->db ->where('UserType',$userType);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
    }
    public function updateOtpData($data,$mobile_number,$mob_code){
        $this->db->set('OTP',$data);
        $this->db->where('MobileNumber',$mobile_number);
        $this->db->where('MobileCode',$mob_code);
        $result =  $this->db->update('PatientMaster');
        //   echo $this->db->last_query();exit;
        return $result;
    }

    public function updateOtpDataById($data,$patientId){
        $this->db->set('OTP',$data);
        $this->db->where('PatientId',$patientId);
        $result =  $this->db->update('PatientMaster');
        return $result;
    }

    public function updateDoctorOtpData($data,$mobile_number){
        $this->db->set('OTP',$data);
        $this->db->where('PhoneNumber',$mobile_number);
        $result =  $this->db->update('Users');
        return $result;
    }

    public function check_device_token($patient_id,$device_id){
        return  $this->db->select("DeviceId")->from("Notification")->where('PatientId', $patient_id)->where('DeviceId', $device_id)->get()->row();
    }

    public function updateDeviceToken($id,$device_token,$source){
        if($device_token == null)
        {
            return false;
        }
        else
        {
            $this->db->set('DeviceId', $device_token);
            $this->db->set('Platform', $source);
            $this->db->where('PatientId', $id);
            return $this->db->update("Notification");
        }
    }
	
	public function clear_device_token($patient_id,$userType){        
		$this->db->set('DeviceId', NULL);
		$this->db->where('PatientId', $patient_id);
		$this->db->where('UserType', $userType);
		return $this->db->update("Notification");
    }

    function insertDeviceToken($data)
    {

    return $this->db->insert("Notification",$data);
    }

    function checkLoginDevice($patientId){
         return  $this->db->select("DeviceId")->from("Notification")->where('PatientId', $patientId)->get()->row();
    }

    public function HospitalSearch($distance,$Lat,$long)
    { 
    // $Lat=3.1533861;
    // $long=101.6033901;
    $query = $this->db->query("SELECT * FROM (SELECT *, (((acos(sin(($Lat*pi()/180))*sin((Latitude*pi()/180))+cos(($Lat*pi()/180))*cos((Latitude*pi()/180))*cos((($long-Longitude)*pi()/180)))) *180/pi())*60*1.1515*1.609344) as distance FROM Tenants) Tenants WHERE distance <=".$distance);

        $result = $query->result_array();
        // echo $this->db->last_query();exit;
        // print_r( $result);exit;
        return $result;

    }

    function updateEreportFile($file_id){
    
        $this->db->where("ReportTransitId",$file_id)->update("EreportsTransit",array("IsProcessed"=>1));
    }

    function fileTransferStatusUpdate($fileId,$proccessName){
      return $this->db->where("ReportTransitId",$fileId)->update("EreportsTransit",array($proccessName=>1));
    }

    function updateFileTransferStatus($transitDetailId,$proccessName){
      return $this->db->where("EreportsTransitDetailId",$transitDetailId)->update("EreportsTransitDetail",array($proccessName=>1));
    }

    function getFilesRemainingToDownload($ReportTransitId,$proccessName,$docId){
        $this->db->select("COUNT(EreportsTransitDetailId) as count");
        $this->db->from("EreportsTransitDetail");
        $this->db->where("ReportTransitId",$ReportTransitId);
        $this->db->where("InsertUserId",$docId);
        $this->db->where($proccessName,0);
        $result = $this->db->get()->row();
        return $result;
    }

    function getBloodGrouplist(){

        return  $this->db->select("*")->from("BloodGroupMaster")->get()->result();
    }

    function getSpecialityList(){
        $this->db->select("ID,SpecialityCode,SpecialityDescription");
        $this->db->from("PractitionerSpecialityMaster");
        $this->db->where("IsActive","1");
        $this->db->order_by("SpecialityCode", "ASC");
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function HospitalFilterForSpeciality($specialityId){
        $this->db->distinct();
        $this->db->select('T.*');
        $this->db ->from('Tenants T');       
        $this->db->join("UserTenants UT","UT.TenantId = T.TenantId");
        $this->db->join("Users U","U.UserId = UT.UserId");
        $this->db->join("PractitionerMaster PM","PM.Email = U.Email");
        $this->db->where('PM.SpecialityId',$specialityId);
        $this->db->order_by("T.TenantName", "ASC");
        // $this->db->group_by("T.TenantId");
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function patientSearchByKeyword($keyword){
        $this->db->select('*');
        $this->db ->from('PatientMaster'); 
        $this->db->where('%FullName%',$keyword);
        $result = $this->db ->get()->result();
        return $result;
    }

    function patientSearchByMobileNumber($mobile_number,$mob_code){
        $this->db->select('PatientId,MobileCode,MobileNumber,FullName,Email, BloodGroupMaster.BloodGroupCode bloodgroup, BloodGroupMaster.BloodGroup bloodgroupDes');
        $this->db ->from('PatientMaster'); 
        $this->db->join("BloodGroupMaster","BloodGroupMaster.BloodGroupId = PatientMaster.BloodGroupId","LEFT");
        $this->db->where('MobileNumber',$mobile_number);
        $this->db->where('MobileCode',$mob_code);
        $result = $this->db ->get()->row();
        return $result;
    }    

    function patientSearchByEmail($email){
        // $this->db->select('PatientId,MobileCode,MobileNumber,FullName,Email');
        $this->db->select('*');
        $this->db->from('PatientMaster'); 
        $this->db->where('Email',$email);
        $result = $this->db ->get()->row();
        return $result;
    }

     function GetCampaignData($Campaign){
        $this->db->distinct();
        $this->db->select('Campaign.*,EreportsTransit.PatientMasterId,Notification.DeviceId');
        $this->db ->from('Campaign');
         $this->db->join("EreportsTransit","EreportsTransit.TenantId = Campaign.TenantId");       
        $this->db->join("Notification","Notification.PatientId = EreportsTransit.PatientMasterId");
        $this->db->where('Campaign.CampaignId',$Campaign);
		 $this->db->where('Notification.UserType',0);
		 $this->db->where('Notification.IsCampaignNotify',0);
		 $this->db->where('Notification.IsNotify',0);
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }
     function GetCampaignDataOfNotification(){
		 date_default_timezone_set('Asia/Kuala_Lumpur');
    	$todayDate = date('d-m-Y');
        $this->db->select('Campaign.*,T.TenantName');
        $this->db ->from('Campaign');
        $this->db->join("Tenants T","T.TenantId = Campaign.TenantId","LEFT");
		//$this->db->where('DATEDIFF(day, '.$todayDate.' , date("d-m-Y",Campaign.InsertDate)) BETWEEN 0 AND 30');
        $this->db ->order_by('Campaign.CampaignId','desc');
        $result = $this->db ->get()->result();
         //echo $this->db->last_query();exit;
        return $result;
    }

    function GetReportTransitIdData($ReportTransitId){
        $this->db->select('EreportsTransit.*,Notification.DeviceId');
        $this->db ->from('EreportsTransit');
        $this->db->join("Notification","Notification.PatientId = EreportsTransit.PatientMasterId");
        $this->db->where('EreportsTransit.ReportTransitId',$ReportTransitId);
		$this->db->where('Notification.IsNotify',0);
        $result = $this->db ->get()->result();
        return $result;
    }
    public function GetRingGroupDataWithoutData(){
        $query = $this->db->query(" select TenantId,TenantName From [Tenants] where IsActive = 1");
        $result = $query->result_array();
        return $result;
    }

    public function GetRingGroupData($keyword)
    { 

    // $query = $this->db->query(" select TenantId,TenantName From [Tenants] where IsActive = 1");

    //     $result = $query->result_array();

    //     return $result;
    $this->db->select('TenantId,TenantName');
    $this->db ->from('Tenants');
    $this->db->like('TenantName', $keyword);
    $this->db->where('IsActive',1);
    $this->db->limit(4);
    $result = $this->db ->get()->result();
    // echo $this->db->last_query();exit;
    return $result;

    }
	
	public function getRingGroupMasterData($ringGrpId){
        if(!empty($ringGrpId)){
            $query = $this->db->query(" select RingGroupMasterId,RingGroupName From RingGroupMaster where RingGroupMasterId = ".$ringGrpId); 
        }else{
            $query = $this->db->query(" select RingGroupMasterId,RingGroupName From RingGroupMaster");
        }       
        $result = $query->result_array();
        return $result;
    }

    public function getRingGroupMasterDataWithKeyword($keyword,$ringGrpId)
    { 
		$this->db->select('RingGroupMasterId,RingGroupName');
		$this->db ->from('RingGroupMaster');
		$this->db->like('RingGroupName', $keyword);
        if(!empty($ringGrpId)){
           $this->db->where('RingGroupMasterId', $ringGrpId); 
        }
		$this->db->limit(4);
		$result = $this->db ->get()->result();
		return $result;
    }
	
	public function getRingGroupTanentByRinGrpMasterId($ringGrpMasterId,$keyword)
	{
		$this->db->select('RGT.RingGroupTenantsId,RGT.RingGroupId,T.TenantId,T.TenantCode,T.TenantName');
		$this->db ->from('RingGroupTenants RGT');
		$this->db->join("Tenants T","T.TenantId = RGT.TenantId","LEFT");
		$this->db->like('T.TenantName', $keyword);
		$this->db->where('RGT.RingGroupId', $ringGrpMasterId);
		$result = $this->db ->get()->result();
		return $result;
	}
		
	public function getRingGroupTanentByRinGrpMasterIdWithoutKey($ringGrpMasterId)
	{
		$this->db->select('RGT.RingGroupTenantsId,RGT.RingGroupId,T.TenantId,T.TenantCode,T.TenantName');
		$this->db ->from('RingGroupTenants RGT');
		$this->db->join("Tenants T","T.TenantId = RGT.TenantId","LEFT");
		$this->db->where('RGT.RingGroupId', $ringGrpMasterId);
		$result = $this->db ->get()->result();
		return $result;
	}

        public function GetSpecialtyData($TenantId)
        { 
    $query = $this->db->query("select distinct psm.ID,psm.SpecialityDescription from PractitionerMaster pm inner join Users u on pm.Id = u.LinkUserId and u.IsActive = 1 
  inner join PractitionerSpecialityMaster psm on psm.ID = pm.SpecialityId 
  where u.TenantId =".$TenantId);

        $result = $query->result_array();
        return $result;

    }

     public function GetReferredToDoctorData($TenantId)
        { 
    $query = $this->db->query("select u.UserId, u.DisplayName from PractitionerMaster pm inner join Users u on pm.Id = u.LinkUserId and u.IsActive = 1 
  where u.TenantId =".$TenantId);

        $result = $query->result_array();
        return $result;

    }

    function EreportTransitListViaPatientId($pat_id,$ringGrpId){
        // $this->db->select('ET.ReportTransitId,ET.FileAttachments,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, ET.InsertUserId DoctorId, U.DisplayName doctorName, T.TenantName, C.Category');
        // $this->db->select('ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, ET.InsertUserId DoctorId, U.DisplayName doctorName, T.TenantName');
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $dateNow = date('Y-m-d');
        $intervalDate = date('Y-m-d', time() - (3 * 24 * 60 * 60));
        $this->db->select("ET.PatientMasterId,ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm,ET.IsReferralFormProcessed, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.ReferredToUserId, ET.AddReferral, ET.InsertUserId DoctorId,ET.RingGroup , U.DisplayName doctorName,U.LastName, U.PhoneNumber UserPhoneNumber,T.TenantId, T.TenantName, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, IC.ICDSubCode, IC.ICDSubCodeDescription, PSM.SpecialityDescription DoctorSpeciality , RGT.RingGroupId as RingGroupMasterID, ET.ICD, HM.Description sirname_title,ET.RingGroupId refTenant");
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        // $this->db->join("CategoryMaster C","C.CategoryId = ET.CategoryId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");        
        $this->db->join("ICDMaster IC","IC.Id = ET.IcdMasterId","LEFT");
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        if(!empty($ringGrpId)){
            // $this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
            $this->db->group_start();
            $this->db->where('RGT.RingGroupId',$ringGrpId);
                $this->db->or_group_start();
                            $this->db->where('ET.RingGroup',$ringGrpId);
                $this->db->group_end();           
            $this->db->group_end();
        }
        $this->db->where('ET.PatientMasterId',$pat_id);     
        $this->db->where('ET.InsertDate > ', $intervalDate);
        //$this->db->where('ET.AddReferral',1);
        $this->db->where('ET.IsPatientProcessed',0);
        //$this->db->where('ET.IsDeleted',0);
		$this->db->order_by('ET.ReportTransitId','DESC');
        $this->db->limit(20);
        $result = $this->db ->get()->result();
        return $result;
    }

    function EreportTransitListViaDoctorId($doc_id){
        //$this->db->select('ET.ReportTransitId,ET.FileAttachments,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, U.DisplayName doctorName, T.TenantName, C.Category');
		$this->db->select('ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, ET.InsertUserId DoctorId, U.DisplayName doctorName, T.TenantName');
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        //$this->db->join("CategoryMaster C","C.CategoryId = ET.CategoryId","LEFT");
        $this->db->where('ET.ReferredToUserId',$doc_id);
		//$this->db->where('ET.InsertUserId',$doc_id);
        //$this->db->where('ET.AddReferral',1);
        $this->db->where('ET.IsDoctorProcessed',0);
       // $this->db->where('ET.IsDeleted',0);
		$this->db->order_by('ET.ReportTransitId','DESC');
        $result = $this->db ->get()->result();
        return $result;
    }
    
    function EreportTransitDataById($report_id){
        //$this->db->select('ET.ReportTransitId,ET.FileAttachments,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, U.DisplayName doctorName, U.PhoneNumber, T.TenantName, T.Address,, T.Latitude, T.Longitude, C.Category');
		$this->db->select('ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, U.DisplayName doctorName, U.PhoneNumber, T.TenantName, T.Address');
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        //$this->db->join("CategoryMaster C","C.CategoryId = ET.CategoryId","LEFT");
        $this->db->where('ET.ReportTransitId',$report_id);
        //$this->db->where('ET.AddReferral',1);
        $this->db->where('ET.IsDeleted',0);
		$this->db->order_by('ET.ReportTransitId','DESC');
        $result = $this->db ->get()->result();
        return $result;
    }

    function insertUsersBackupData($insertArr)
    {
        $result = $this->db->insert("BackupUsers",$insertArr);
        return $result;
    }

    function restoreUsersBackupData($UserId,$UserType,$IsRefferal){
        $this->db->select('*');
        $this->db ->from('BackupUsers'); 
        $this->db->where('UserId',$UserId);
        $this->db->where('UserType',$UserType);       
		$this->db->where('IsRefferal',$IsRefferal);
        $this->db->order_by('ID','desc');
        $result = $this->db ->get()->row();
        return $result;
    }

    function updateNotificationStatus($updateDataArray,$PatientId)
    {
        $this->db->where('PatientId',$PatientId);
        $result = $this->db->update('Notification',$updateDataArray);
        return $result;
    }

    function getNotificationStatus($PatientId){
        $this->db->select('PatientId,IsCampaignNotify,IsNotify');
        $this->db ->from('Notification'); 
        $this->db->where('PatientId',$PatientId);
        $result = $this->db ->get()->row();
        return $result;
    }
    function insertProfileSetting($insertArr)
    {
        $result = $this->db->insert("tbl_profile_setting",$insertArr);
        return $result;
    }

    function UpdateProfileSetting($updateArr,$id){    
        $this->db->where('Id',$id);
        $result =  $this->db->update('tbl_profile_setting',$updateArr);  
        return $result; 
    }

    function checkUserSettings($userId,$userType,$field){
        $this->db->select('*');
        $this->db ->from('tbl_profile_setting');
        $this->db ->where('User_id',$userId);
        $this->db ->where('User_type',$userType);
        $this->db ->where('Field',$field);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
    }

    function getUserSettings($userId,$userType){
        $this->db->select('*');
        $this->db ->from('tbl_profile_setting');
        $this->db ->where('User_id',$userId);
        $this->db ->where('User_type',$userType);
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
            return $result;
    }

    function getSyncStatus($userId,$userType,$field){
        $this->db->select('*');
        $this->db ->from('tbl_profile_setting');
        $this->db ->where('User_id',$userId);
        $this->db ->where('User_type',$userType);
        $this->db ->where('Field',$field);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
    }

    function insertUsersChat($insertArr)
    {
        $result = $this->db->insert("Chat",$insertArr);
        $insert_id = $this->db->insert_id();
		return  $insert_id;
    }

    function checkUserBackup($UserId,$UserType,$IsRefferal){
        $this->db->select('*');
        $this->db ->from('BackupUsers');
        $this->db->where('UserId',$UserId);
        $this->db->where('UserType',$UserType);
		$this->db->where('IsRefferal',$IsRefferal);
        $result = $this->db ->get()->row();
        return $result; 
    }
	
	function getChatDataByUserId($senderId,$senderType,$receiverId,$receiverType){
		//$this->db->select('*');
        //$this->db ->from('Chat');
        //$this->db->where('SenderId',$senderId);
        //$this->db->where('SenderType',$senderType);
		//$this->db->where('ReceiverId',$receiverId);
       // $this->db->where('ReceiverType',$receiverType);
        //$result = $this->db ->get()->result();
       // return $result; 
		
		$query=" SELECT * FROM Chat where (SenderId = ".$senderId." and SenderType = '".$senderType."' and  ReceiverId = ".$receiverId." and ReceiverType = '".$receiverType."') or (SenderId = ".$receiverId." and SenderType = '".$receiverType."' and  ReceiverId = ".$senderId." and ReceiverType = '".$senderType."' )";
        $result = $this->db->query($query)->result();
		return $result; 
	}
	
	function getChatDataWithoutChatIdByUserId($chatId,$senderId,$senderType,$receiverId,$receiverType){
	
		$query=" SELECT * FROM Chat where ((SenderId = ".$senderId." and SenderType = '".$senderType."' and  ReceiverId = ".$receiverId." and ReceiverType = '".$receiverType."') or (SenderId = ".$receiverId." and SenderType = '".$receiverType."' and  ReceiverId = ".$senderId." and ReceiverType = '".$senderType."' ) )and Id > ".$chatId."";
        $result = $this->db->query($query)->result();
		//echo $this->db->last_query();exit;
		return $result; 
	}
	
	function updateChatSeenStatus($chatId,$updateArr){
		$this->db->where('ID',$chatId);
        $result = $this->db->update('Chat',$updateArr);
        return $result;
	}

    function getReportTypeAndPatientViaDoctorId($doc_id){
        // $this->db->select('ET.ReportTransitId,ET.InsertDate,ET.Description,P.PatientId,P.FullName,C.Category,T.TenantName');
        $this->db->DISTINCT("P.PatientId");
        //  $this->db->select('ET.ReportTransitId,ET.InsertDate,ET.Description,P.PatientId,P.FullName,T.TenantName');
        $this->db->select('P.PatientId,P.FullName,T.TenantName');
        $this->db ->from('EreportsTransit ET');
        $this->db->join("PatientMaster P","P.PatientId = ET.PatientMasterId","LEFT");
        // $this->db->join("CategoryMaster C","C.CategoryId = ET.CategoryId","LEFT");
		$this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        $this->db->where('ET.InsertUserId',$doc_id);
		//$this->db->group_by('P.PatientId');
        $result = $this->db ->get()->result();
        return $result;
    }

    function getLetestErefFile($doc_id,$patientId){
        $this->db->select('C.Category');
        $this->db ->from('EreportsTransit ET');
        $this->db->join("EreportsTransitDetail ETD","ET.ReportTransitId = ETD.ReportTransitId","LEFT");
        $this->db->join("CategoryMaster C","C.CategoryId = ETD.CategoryId","LEFT");
        $this->db->where('ET.PatientMasterId',$patientId);
        $this->db->where('ET.InsertUserId',$doc_id);
        $this->db->order_by('ETD.EreportsTransitDetailId','desc');
        $result = $this->db->get()->row();
        return $result; 
    }

    function getFileAttachmentByReportTransitId($ReportTransitId,$docId){
        $this->db->select('ETD.*,C.Category');
        $this->db ->from('EreportsTransitDetail ETD');
        $this->db->join("CategoryMaster C","C.CategoryId = ETD.CategoryId","LEFT");
        $this->db->where('ETD.ReportTransitId',$ReportTransitId);
        $this->db->where('ETD.InsertUserId',$docId);
		$this->db->where('ETD.IsPatientProcessed',0);
        $result = $this->db->get()->result();
        return $result;
    }

    function checkDeviceTokenByPatientId($patientId,$deviceId){
        $this->db->select('DeviceId');
        $this->db ->from('Notification');
        $this->db->where('PatientId',$patientId);
        $this->db->where('DeviceId',$deviceId);
        $this->db->where('UserType',0);
        $result = $this->db->get()->row();
        return $result;
    }
	
	function chatListByPatientId($patient_id,$user_type){
		//$this->db->select('*');
        //$this->db ->from('Chat');
        //$this->db->where('SenderId',$patient_id);
        //$this->db->where('SenderType',$user_type);
		//$this->db->or_where('ReceiverId',$patient_id);
        //$this->db->where('ReceiverType',$user_type);
       // $result = $this->db ->get()->result();
        //return $result; 
		
		//$query=" SELECT * FROM Chat where (SenderId = ".$patient_id." and SenderType = '".$user_type."' ) or (ReceiverId = ".$patient_id." and ReceiverType = '".$user_type."' ) ORDER BY ID DESC";
       // $result = $this->db->query($query)->result();
		//return $result; 
		
		$query1=" SELECT DISTINCT ReceiverId  as DoctorId, ReceiverFullName as DoctorName FROM Chat where SenderId = ".$patient_id." and SenderType = '".$user_type."' ";
        $result["receiverDoc"] = $this->db->query($query1)->result();
		$query2=" SELECT DISTINCT SenderId as DoctorId, SenderFullName as DoctorName FROM Chat where ReceiverId = ".$patient_id." and ReceiverType = '".$user_type."' ";
        $result["senderDoc"] = $this->db->query($query2)->result();
		return $result;
	}
	
	function getDoctorIdByReportId($report_id){
		$this->db->select('ET.ReportTransitId, ET.InsertUserId DoctorId, U.DisplayName doctorName');
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
		$this->db->where('ET.ReportTransitId',$report_id);
        $result = $this->db ->get()->row();
        return $result;
	}
	
	function countOfUnreadMsgOfPatient($patient_id,$doctorId){
		$query=" SELECT DISTINCT count(ID) as UnreadChatCount FROM Chat where SenderId = ".$doctorId." and SenderType = 'Doctor' and ReceiverId = ".$patient_id." and ReceiverType = 'Patient' and SeenStatus != 2 ";
        $result = $this->db->query($query)->row();
		return $result; 
	}

    function getRelationMasterDataOfDependent(){
        $this->db->select('Id,Description');
        $this->db ->from('RelationshipMaster');
        $result = $this->db->get()->result();
        return $result;
    }

    function getDependentCount($patient_id){
        $query=" SELECT DISTINCT count(DependentProfileId) as DependentCount FROM DependentProfileDetails where MainProfilePatientId = ".$patient_id."";
        $result = $this->db->query($query)->row();
		return $result;
    }

    function getLastDependentData($patient_id){
        $this->db->select('*');
        $this->db ->from('DependentProfileDetails');
        $this->db->where('MainProfilePatientId',$patient_id);
        $this->db->order_by('DependentProfileId',"DESC");
        $result = $this->db->get()->row();
        return $result;
    }

    function insertdependentProfile($insertArr)
    {
        $result = $this->db->insert("PatientMaster",$insertArr);
        $insert_id = $this->db->insert_id();
		return $insert_id;
    }

    function updateDependentTable($depArr)
    {
        $result = $this->db->insert("DependentProfileDetails",$depArr);
        $insert_id = $this->db->insert_id();
		return $insert_id;
    }
	
	function getDependentListByPatientId($PatientId){
		$this->db->select('D.DependentProfilePatientId, R.Description as Relationship, D.ConvertionStatus as IsConverted');
        $this->db->from('DependentProfileDetails D');
		$this->db->join("RelationshipMaster R","R.Id = D.RelationshipTypeId","LEFT");
		$this->db->where('D.MainProfilePatientId',$PatientId);
        $result = $this->db->get()->result();
        return $result;
	}
	
	function getAllTenants(){
		$this->db->select('TenantId,TenantCode,TenantName');
		$this->db->from('Tenants');
		$this->db->order_by('TenantName','ASC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	function deleteDependentProfile($dependentPatientId){
		$this->db->where('PatientId', $dependentPatientId);
		$result = $this->db->delete('PatientMaster');
		return $result;
	}
	
	function deleteDepDetail($dependentPatientId,$mainPatientId){
		$this->db->where('MainProfilePatientId', $mainPatientId);
		$this->db->where('DependentProfilePatientId', $dependentPatientId);
		$result = $this->db->delete('DependentProfileDetails');
		//echo $this->db->last_query();exit;
		return $result;
	}
	
	function getDependentProfile($dependentPatientId){
		$this->db->select('D.*, R.Description as Relationship, P.*');
        $this->db->from('DependentProfileDetails D');
		$this->db->join("RelationshipMaster R","R.Id = D.RelationshipTypeId","LEFT");
		$this->db->join("PatientMaster P","P.PatientId = D.DependentProfilePatientId","LEFT");
		$this->db->where('D.DependentProfilePatientId',$dependentPatientId);
        $result = $this->db->get()->row();
        return $result;
	}
	
	function updateDependentProfile($updateArray,$dependentPatientId){
		$this->db->where('PatientId',$dependentPatientId);
   		$result =  $this->db->update('PatientMaster',$updateArray);
		return $result;
	}
	
	function updateDependentRelation($depUpdateArr,$mainPatientId,$dependentPatientId){
		$this->db->where('MainProfilePatientId',$mainPatientId);
		$this->db->where('DependentProfilePatientId',$dependentPatientId);
   		$result =  $this->db->update('DependentProfileDetails',$depUpdateArr);
		return $result;
	}
	
	function hospitalSearchForMapSection($cityId,$ringGroupId,$hospital,$speciality,$citINP,$ringGrpINP,$searchSpclINP,$setlat,$setlong){

        if(!empty($setlat) && !empty($setlong)){
            $distanceQuery = "round((6371 * acos(cos(radians($setlat)) * cos(radians(T.Latitude)) * cos(radians($setlong) - radians(T.Longitude)) + sin(radians('$setlat')) * sin(radians(T.Latitude)))),2) AS distance"; 
            $this->db->distinct();
            $this->db->select('T.TenantId,T.TenantName, CONCAT(T.PhoneCode, T.PhoneNumber) AS PhoneNumber,T.Address,T.Latitude,T.Longitude ,'.$distanceQuery );        
        }else{
            $this->db->distinct();
            $this->db->select('T.TenantId,T.TenantName,CONCAT(T.PhoneCode, T.PhoneNumber) AS PhoneNumber,T.Address,T.Latitude,T.Longitude');        
        }
        $this->db ->from('Tenants T');       
        
		if(!empty($speciality) && !empty($searchSpclINP)){
            $this->db->join("UserTenants UT","UT.TenantId = T.TenantId");
            $this->db->join("Users U","U.UserId = UT.UserId");
			$this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId");
			$this->db->where('PM.SpecialityId',$speciality);
		}
		// $this->db->where('T.CountryID',$countryId);
		// $this->db->where('T.StateID',$stateId);
		if(!empty($citINP) && empty($cityId)){
			// $this->db->where('T.CityID',$cityId);
            $cityNm = explode(",",$citINP);
            // print_r($cityNm);
           // $this->db->join("CityMaster CM","CM.ID = T.CityID");
            $this->db->like('T.Address',$cityNm[0]);
            
		}
        if(!empty($cityId)){
			$this->db->where('T.CityID',$cityId);
		}
		if(!empty($ringGroupId) &&  !empty($ringGrpINP)){
			$this->db->join("RingGroupTenants RG","RG.TenantId = T.TenantId");
			$this->db->where('RG.RingGroupId',$ringGroupId);
		}
		if(!empty($hospital)){
			$this->db->like('T.TenantName',$hospital);
		}
        if(!empty($setlat) && !empty($setlong)){
            $this->db->order_by('distance','asc');
        }else{
            $this->db->order_by('T.TenantName','asc');
        }
        $this->db->where('T.IsActive',1);
        $this->db->where('T.RestrictSearch','0');
        // $this->db->or_where('T.RestrictSearch',NULL);
        $result = $this->db->get()->result();

      //  echo $this->db->last_query();
        return $result;
    
	}

    function hospitalSearchForMapSectionCount($cityId,$ringGroupId,$hospital,$speciality,$citINP,$ringGrpINP,$searchSpclINP,$setlat,$setlong){
        $this->db->distinct();
        $this->db->select('T.TenantId');
        $this->db ->from('Tenants T');       
        
		if(!empty($speciality) && !empty($searchSpclINP)){
            $this->db->join("UserTenants UT","UT.TenantId = T.TenantId");
            $this->db->join("Users U","U.UserId = UT.UserId");
			$this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId");
			$this->db->where('PM.SpecialityId',$speciality);
		}
		if(!empty($citINP) && empty($cityId)){
            $cityNm = explode(",",$citINP);
            $this->db->like('T.Address',$cityNm[0]);
            
		}
        if(!empty($cityId)){
			$this->db->where('T.CityID',$cityId);
		}
		if(!empty($ringGroupId) &&  !empty($ringGrpINP)){
			$this->db->join("RingGroupTenants RG","RG.TenantId = T.TenantId");
			$this->db->where('RG.RingGroupId',$ringGroupId);
		}
		if(!empty($hospital)){
			$this->db->like('T.TenantName',$hospital);
		}
        $this->db->where('T.IsActive',1);
        // $this->db->where('T.RestrictSearch','0');
        // $this->db->or_where('T.RestrictSearch',NULL);
        $result = $this->db->get()->result();
        return $result;
    
	}

    function cityAutoSearchByKeyword($keyword){
        $this->db->select("CONCAT_WS(', ', CM.CityDescription, SM.StateDescription, C.CountryDescription) AS Description,CM.ID cityId,");
        // $this->db->select('CM.ID cityId,CONCAT(CM.CityDescription, ',', SM.StateDescription ',', C.CountryDescription) AS Description');
        $this->db ->from('CityMaster CM');
        $this->db->join("StateMaster SM","SM.ID = CM.StateID","LEFT");
        $this->db->join("CountryMaster C","C.ID = SM.CountryID","LEFT");
        $this->db->where("CM.CityDescription LIKE '$keyword%'");
        $this->db->limit(10);
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();
        return $result;
    }

    function specialityAutoSearchByKey($keyword){
        $this->db->select("ID,SpecialityCode,SpecialityDescription");
        $this->db->from("PractitionerSpecialityMaster");
        $this->db->like('SpecialityDescription', $keyword);
        $this->db->where("IsActive","1");
        $this->db->order_by("SpecialityCode", "ASC");
        $this->db->limit(4);
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    public function getUserDataByEmailOrMobile($email,$mobile){
        $this->db->select('*');
        $this->db ->from('PatientMaster');
        $this->db ->where('Email',$email);
        $this->db ->or_where('MobileNumber',$mobile);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
            return $result;
    }

    function getRefReportDoctorDetails($Doc_id,$refTenant)
    {
        $this->db->select("U.DisplayName refDoctorName, U.LastName,  U.PhoneNumber refUserPhoneNumber, T.TenantId, T.TenantName  refTenantName, T.PhoneNumber refTenantPhoneNuber, T.FaxNumber refTenantFaxNumber, T.Address refTenantAddress, PSM.SpecialityDescription refDoctorSpeciality, HM.Description sirname_title");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->where("UT.UserId", $Doc_id);
        $this->db->where("UT.TenantId", $refTenant);
        $result = $this->db->get()->result();
        return $result;
    }
    
    public function ringGroupListByPatientId($patientId)
    { 
        $query = $this->db->query("SELECT DISTINCT RG.RingGroupMasterId, RG.RingGroupName FROM EreportsTransit ETD
            INNER JOIN RingGroupTenants RGT ON RGT.TenantId = ETD.TenantId 
            INNER JOIN RingGroupMaster RG ON RG.RingGroupMasterId = RGT.RingGroupId
            WHERE ETD.PatientMasterId = $patientId
            UNION
            SELECT DISTINCT RG.RingGroupMasterId, RG.RingGroupName FROM EreportsTransit ETD
            INNER JOIN RingGroupMaster RG ON RG.RingGroupMasterId = ETD.RingGroup
            WHERE ETD.PatientMasterId = ".$patientId);
        // echo $this->db->last_query();exit;
        $result = $query->result_array();
        return $result;
    }

    public function checkUserEmailId($email){
        $this->db->select("*");
        $this->db->from('PatientMaster');
        $this->db->where('Email', $email);
        $result = $this->db->get()->row();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function insertSignUpData($data)
    {
        $result = $this->db->insert("PatientMaster",$data);
        $insert_id = $this->db->insert_id();
		return  $insert_id;
    }

    public function updatePatientGmailSignup($patient_id, $UpdDataArray){
        $this->db->where('PatientId',$patient_id);
        $result = $this->db->update('PatientMaster',$UpdDataArray);
        return $result;
    }

    function getDoctorsDetails($doctor_id,$role=''){
        $this->db->select('U.UserId, U.Username, U.DisplayName, U.Email, U.PhoneNumber, PM.PractitionerCode, PM.MMCNumber, PM.IcNumber, PSM.SpecialityDescription');
        $this->db ->from('Users U');
        if($role =='Doctor')
        $this->db->where('U.UserId',$doctor_id);
        $this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.Id = PM.SpecialityId");
        $result = $this->db ->get()->row();

        //echo $this->db->last_query(); exit;
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

    function getTenantsDetails($tenant_id){
		$this->db->select("T.TenantId, T.TenantName, T.TenantCode, T.TenantNumber, T.PhoneNumber, T.FaxNumber, T.PhoneCode, T.FaxCode, T.Address, T.PostCode, TT.TenantType, C.CountryDescription Country, S.StateDescription State, CT.CityDescription City");
        $this->db->from("Tenants T");
        $this->db->join("CountryMaster C","C.ID = T.CountryID","LEFT");
        $this->db->join("StateMaster S","S.ID = T.StateID","LEFT");
        $this->db->join("CityMaster CT","CT.ID = T.CityID","LEFT");
        $this->db->join("TenantType TT","TT.TenantTypeId = T.TenantTypeId","LEFT");
        $this->db->where("T.TenantId", $tenant_id);
        $result = $this->db->get()->row();
        return $result;
	}

    // function tenantsSearchDataByKeywords($keyword){
    //     $this->db->select('TenantId,TenantName,Address');
    //     $this->db ->from('Tenants');
    //     $this->db->like('TenantName', $keyword);
    //     $this->db->where('IsActive',1);
    //     $this->db->limit(5);
    //     $result = $this->db ->get()->result();
    //     return $result;
    // }

    function tenantsSearchDataByKeywords($keyword){
        $this->db->select("T.TenantId, T.TenantName, T.TenantCode, T.TenantNumber, T.PhoneNumber, T.FaxNumber, T.Address, T.PostCode, T.TenantTypeId, TT.TenantType, C.CountryDescription Country, S.StateDescription State, CT.CityDescription City");
        $this->db->from("Tenants T");
        $this->db->join("CountryMaster C","C.ID = T.CountryID","LEFT");
        $this->db->join("StateMaster S","S.ID = T.StateID","LEFT");
        $this->db->join("CityMaster CT","CT.ID = T.CityID","LEFT");
        $this->db->join("TenantType TT","TT.TenantTypeId = T.TenantTypeId","LEFT");
        $this->db->like('T.TenantName', $keyword);
        $this->db->where('T.IsActive',1);
        $this->db->limit(5);
        $result = $this->db ->get()->result();
        return $result;
    }

    function facilityMasterData(){
        $this->db->select('TenantTypeId FacilityTypeId,TenantType FacilityTypeName');
        $this->db ->from('TenantType');
        $result = $this->db ->get()->result();
        return $result;
    }

    function GetCampaignDataOfNotificationWithFilter($cityId,$ringGroupId,$tenantId){
		 date_default_timezone_set('Asia/Kuala_Lumpur');
    	$todayDate = date('d-m-Y');
        $this->db->select('Campaign.*,T.TenantName');
        $this->db ->from('Campaign');
        $this->db->join("Tenants T","T.TenantId = Campaign.TenantId","LEFT");
        if(!empty($cityId)){
			$this->db->where('T.CityID',$cityId);
		}
		if(!empty($ringGroupId)){
			$this->db->join("RingGroupTenants RG","RG.TenantId = T.TenantId");
			$this->db->where('RG.RingGroupId',$ringGroupId);
		}
		if(!empty($tenantId)){
			$this->db->where('Campaign.TenantId',$tenantId);
		}
		$this->db ->order_by('Campaign.CampaignId','desc');
        $result = $this->db ->get()->result();
         //echo $this->db->last_query();exit;
        return $result;
    }

    public function doctorLoginWithUserId($user_id){
        $this->db->select('*');
        $this->db ->from('Users');
        $this->db ->where('UserId',$user_id);
        $result = $this->db ->get()->row();
        return $result;
    }

   public function checkUserExistance($PatientId,$MobileCode,$MobileNumber,$Otp){
        $this->db->select('PatientId');
        $this->db ->from('PatientMaster');
        $this->db ->where('PatientId',$PatientId);
        $this->db ->where('MobileCode',$MobileCode);
        $this->db ->where('MobileNumber',$MobileNumber);
        $this->db ->where('OTP',$Otp);
        $result = $this->db ->get()->row();
        // echo $this->db->last_query();exit;
        return $result;
    }

    public function deletePatientBackup($PatientId){
        $this->db->where('UserId', $PatientId);
        $this->db->where('UserType', 'Patient');
        $result = $this->db->delete('BackupUsers');
        return $result; 
    }
    public function deleteUserDevice($PatientId,$UserType){
        $this->db->where('PatientId', $PatientId);
        $this->db->where('UserType', $UserType);
        $result = $this->db->delete('Notification');
        return $result; 
    }

    function getEreportTransitIdForDeletion($pat_id){
        $this->db->select("ReportTransitId");
        $this->db ->from('EreportsTransit');
        $this->db->where('PatientMasterId',$pat_id);
        $result = $this->db ->get()->result();
        return $result;
    }

    function deleteReportDetails($ReportTransitId,$table){
        $this->db->where('ReportTransitId', $ReportTransitId);
        $result = $this->db->delete($table);
        return $result;
    }

    function deleteNotifications($ReportTransitId,$table){
        $this->db->where('ReportTransitId', $ReportTransitId);
        $result = $this->db->delete("Alerts");
        return $result;
    }
    
    function refferalVisitNotesByPatientId($pat_id,$ringGrpId){
        $this->db->select("ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.ReferredToUserId , ET.ReferralICD  ,  ET.AddReferral, ET.InsertUserId DoctorId, U.DisplayName doctorName, U.LastName, U.PhoneNumber UserPhoneNumber, PSM.SpecialityDescription DoctorSpeciality,T.TenantId, T.TenantName, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, IC.ICDSubCode, IC.ICDSubCodeDescription DiagnosisName, PSM.SpecialityDescription DoctorSpeciality, ET.EReferralStatus, ET.VisitNotes, ET.Treatment, ET.Diagnosis , ET.Diagnosis ,ET.RingGroup , RGT.RingGroupId as RingGroupMasterID, HM.Description sirname_title,ET.RingGroupId refTenant");
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = U.TenantId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");        
        $this->db->join("ICDMaster IC","IC.Id = ET.Diagnosis","LEFT");   
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        $this->db->where('ET.PatientMasterId',$pat_id);
        if(!empty($ringGrpId)){
            $this->db->where('ET.RingGroup',$ringGrpId);
        }
        $this->db->where('ET.AddReferral',1);
        $this->db->where('ET.IsDoctorProcessed',0);
        $this->db->where('ET.EReferralStatus','Completed');
		$this->db->order_by('ET.ReportTransitId','DESC');
        $result = $this->db ->get()->result();
        return $result;
    }

    function getFileAttachmentByReportTransitIdForVisitNot($ReportTransitId,$ReferredToUserId){
        $this->db->select('ETD.*,C.Category');
        $this->db ->from('EreportsTransitDetail ETD');
        $this->db->join("CategoryMaster C","C.CategoryId = ETD.CategoryId","LEFT");
        $this->db->where('ETD.ReportTransitId',$ReportTransitId);
        $this->db->where('ETD.InsertUserId',$ReferredToUserId);
		$this->db->where('ETD.IsPatientProcessed',0);
        $this->db->where('ETD.IsDoctorProcessed',0);
        $result = $this->db->get()->result();
        return $result;
    }
	
	function getDoctorFromTenant($tenantId,$specialityId)
    {
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, U.SecondarySpecialityId, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PSM.SpecialityDescription DoctorSpeciality, HM.Description as Prefix");
        //UserPhoneNumber U.PhoneNumber
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");
        
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        // if(!in_array($tenantId, [1631, 1632, 1633])){ 
            $this->db->join("DoctorImplementation DI","U.UserId = DI.RingDoctorId","LEFT");
        // }
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->where("UT.TenantId", $tenantId);
        $this->db->where("UR.RoleId", 12);
        $this->db->where("U.IsActive", 1);
        //$this->db->where("U.IsDeleted !=", 1);
		if(is_numeric($specialityId)){
			$this->db->where("PM.SpecialityId", $specialityId);
		}
        // if(!in_array($tenantId, [1631, 1632, 1633])){ 
            $this->db->where("DI.Scheduled", 1);
            $this->db->where("DI.TenantId", $tenantId);
        // }
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }
	
	function getDoctorFromTenantSec($DoctorId,$tenantId,$specialityId)
    {
		$this->db->distinct('DoctorSpeciality');
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PSM.SpecialityDescription DoctorSpeciality");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = U.SecondarySpecialityId","LEFT");
        $this->db->where("UT.TenantId", $tenantId);
		$this->db->where("U.UserId", $DoctorId);
        $this->db->where("U.SecondarySpecialityId", $specialityId);
        $this->db->where("U.IsActive", 1);
        $result = $this->db->get()->row();
        return $result;
    }


    function tenantsSearchDataByHospitalName($hospital){
        $this->db->select("T.TenantId, T.TenantName, T.TenantCode, T.TenantNumber, T.PhoneNumber, T.FaxNumber, T.Address, T.PostCode, T.TenantTypeId, TT.TenantType, C.CountryDescription Country, S.StateDescription State, CT.CityDescription City");
        $this->db->from("Tenants T");
        $this->db->join("CountryMaster C","C.ID = T.CountryID","LEFT");
        $this->db->join("StateMaster S","S.ID = T.StateID","LEFT");
        $this->db->join("CityMaster CT","CT.ID = T.CityID","LEFT");
        $this->db->join("TenantType TT","TT.TenantTypeId = T.TenantTypeId","LEFT");
        $this->db->like('T.TenantName', $hospital);
        $this->db->where('T.IsActive',1);
        $result = $this->db ->get()->row();
        return $result;
    }

	
	function getRingGrpByTenantId($TenantId){
        $this->db->select('RingGroupTenantsId,RingGroupId');
		$this->db->from('RingGroupTenants');
		$this->db->where('TenantId', $TenantId);
		$result = $this->db ->get()->row();
		return $result;
    }
    function getCategoryIdByCategoryName($catName){
        $this->db->select("*");
        $this->db->from('CategoryMaster');
        $this->db->like('Category', $catName);
        $this->db->where('IsActive',1);
        $result = $this->db->get()->row();
        return $result;
    }


    function getCountryListForDropDown(){
        $this->db->select('ID as Id,CountryDescription as Country,PhoneCode,CountryCode');
		$this->db->from('CountryMaster');
        $this->db->where('IsActive', 1);
        $this->db->order_by('CountryDescription','ASC');
		$result = $this->db ->get()->result();

       // print_r($result); exit;
		return $result;
    }
	
	function insertBackupDataInReportTable($data)
	{ 
	  $result = $this->db->insert("PatientBackupReport",$data);
	  $insert_id = $this->db->insert_id();
	  return $insert_id;
	}
		
	function insertDetailsInFileTable($data)
	{ 
	  $result = $this->db->insert("PatientBackupFiles",$data);
	  $insert_id = $this->db->insert_id();
	  return $insert_id;
	}
	
	function insertSession($data)
	{ 
	  $result = $this->db->insert("PatientBackup",$data);
	  $insert_id = $this->db->insert_id();
	  return $insert_id;
	}
	
	public function chkSessionForBackup($sessionTimestamp){
		$this->db->select('*');
		$this->db->from('PatientBackup');
		$this->db->where('SessionTimestamp',$sessionTimestamp);
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function chkSessionForBackupForCreateZip($SessionId,$UserId){
		$this->db->select('*');
		$this->db->from('PatientBackup');
		$this->db->where('SessionTimestamp',$SessionId);
		$this->db->where('UserID',$UserId);
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getReportDataForBackup($UserId, $BackupID){
		$this->db->select('*');
		$this->db->from('PatientBackupReport');
		$this->db->where('BackupID',$BackupID);
		$this->db->where('UserId',$UserId);
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getReportFileDetailsForBackup($UserId, $BackupID){
		$this->db->select('*');
		$this->db->from('PatientBackupFiles');
		$this->db->where('BackupID',$BackupID);
		$this->db->where('UserId',$UserId);
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function userDataByUserId($user_id){
        $this->db->select('PatientMaster.*, BloodGroupMaster.BloodGroupCode bloodgroup, BloodGroupMaster.BloodGroup bloodgroupDes');
        $this->db ->from('PatientMaster');
        $this->db->join("BloodGroupMaster","BloodGroupMaster.BloodGroupId = PatientMaster.BloodGroupId","LEFT");
        $this->db ->where('PatientId',$user_id);
        $result = $this->db ->get()->row();
            return $result;
	}
	
	public function getMainPatientId($PatientId){
		$this->db->select('MainProfilePatientId');
		$this->db->from('DependentProfileDetails');
		$this->db->where('DependentProfilePatientId',$PatientId);
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function checkDuplicateEntryForBackup($table,$fieldname,$fieldVal,$BackupID,$insertSession){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($fieldname,$fieldVal);
		$this->db->where($BackupID,$insertSession);
		$result = $this->db->get()->row();
		return $result;
	}

    function doctorSearchDataForHIS($DoctorName,$MMCNumber){        
        $this->db->select('U.*');
			$this->db ->from('Users U');
            $this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId","LEFT");
			// $this->db->like('U.Username',$DoctorName);
            if(!empty($DoctorName) && !empty($MMCNumber)){
                $this->db->group_start();
                $this->db->where('PM.MMCNumber',$MMCNumber); 
                $this->db->like('U.Username',$DoctorName);    
                $this->db->group_end();
            }else if(empty($DoctorName) && !empty($MMCNumber)){
                $this->db->group_start();
                $this->db->where('PM.MMCNumber',$MMCNumber);   
                $this->db->group_end();
            }else if(!empty($DoctorName) && empty($MMCNumber)){
                $this->db->group_start();
                $this->db->like('U.Username',$DoctorName);   
                $this->db->group_end();
            }else{
                $this->db->like('U.Username',$DoctorName);
                $this->db->where('PM.MMCNumber',$MMCNumber);               
            }
			// $this->db->or_where('PM.MMCNumber',$MMCNumber);
			$result = $this->db ->get()->row();
			return $result;
    }

    function tenantsSearchDataForHIS($HospitalName,$docId){
        $this->db->select("T.TenantId, T.TenantName, T.TenantCode, T.TenantNumber, T.PhoneNumber, T.FaxNumber, T.Address, T.PostCode, T.TenantTypeId, TT.TenantType, C.CountryDescription Country, S.StateDescription State, CT.CityDescription City");
        $this->db->from("Tenants T");
        $this->db->join("CountryMaster C","C.ID = T.CountryID","LEFT");
        $this->db->join("StateMaster S","S.ID = T.StateID","LEFT");
        $this->db->join("CityMaster CT","CT.ID = T.CityID","LEFT");
        $this->db->join("TenantType TT","TT.TenantTypeId = T.TenantTypeId","LEFT");
        $this->db->join("UserTenants UT","UT.TenantId = T.TenantId","LEFT");
        if(!empty($HospitalName)){
            $this->db->group_start();
            $this->db->like('T.TenantName', $HospitalName);
            $this->db->group_end();
        }else{
            $this->db->group_start();
            $this->db->where('UT.UserId', $docId);
            $this->db->group_end();
        }       
        $this->db->where('T.IsActive',1);
        $result = $this->db ->get()->row();
        return $result;
    }
    
    public function getWorkingScheduleOfTenant($TenantId){
        $this->db->select('TW.*, DM.DayName');
        $this->db ->from('TenantWorkingHours TW');
        $this->db->join("DayMaster DM","DM.DayId = TW.DayMasterId","LEFT");
        $this->db ->where('TW.TenantId',$TenantId);
        $result = $this->db ->get()->result();
        return $result;
	}

    function FetchMixPDFOfMRDTDocument($patId,$ringGrpId,$startDate,$endDate){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $startDate = date('Y-m-d h:i:s',strtotime($startDate));
        $endDate = date('Y-m-d h:i:s',strtotime($endDate));
        $this->db->select('ETD.FileAttachments,ET.InsertDate');
        $this->db->from('EreportsTransitDetail ETD');
        $this->db->join("EreportsTransit ET","ET.ReportTransitId = ETD.ReportTransitId","LEFT");
        $this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        
        if(!empty($ringGrpId)){
            $this->db->group_start();
            $this->db->where('RGT.RingGroupId',$ringGrpId);
                $this->db->or_group_start();
                            $this->db->where('ET.RingGroup',$ringGrpId);
                $this->db->group_end();           
            $this->db->group_end();
        }
        $this->db->where('ET.PatientMasterId',$patId);  
        $this->db->where('ET.InsertDate > ', $startDate);
        $this->db->where('ET.InsertDate < ', $endDate);
        $result = $this->db ->get()->result();
        return $result;
    }

    function FetchMixPDFOfMRDTDocument_new($patId,$ringGrpId,$startDate,$endDate){
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $startDate = date('Y-m-d h:i:s',strtotime($startDate));
        $endDate = date('Y-m-d h:i:s',strtotime($endDate));
        $this->db->select("ET.PatientMasterId,ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.ReferredToUserId, ET.AddReferral, ET.InsertUserId DoctorId,ET.RingGroup , U.DisplayName doctorName, U.PhoneNumber UserPhoneNumber,T.TenantId, T.TenantName, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, IC.ICDSubCode, IC.ICDSubCodeDescription, PSM.SpecialityDescription DoctorSpeciality , RGT.RingGroupId as RingGroupMasterID, ET.ICD");
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("ICDMaster IC","IC.Id = ET.IcdMasterId","LEFT");
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        if(!empty($ringGrpId)){
            $this->db->group_start();
            $this->db->where('RGT.RingGroupId',$ringGrpId);
                $this->db->or_group_start();
                            $this->db->where('ET.RingGroup',$ringGrpId);
                $this->db->group_end();           
            $this->db->group_end();
        }
        $this->db->where('ET.PatientMasterId',$patId);  
        $this->db->where('ET.InsertDate > ', $startDate);
        $this->db->where('ET.InsertDate < ', $endDate);
        $result = $this->db ->get()->result();
        return $result;
    }

    function getFileAttachmentByReportTransitIdForPdf($ReportTransitId){
        $this->db->select('ETD.*,C.Category');
        $this->db ->from('EreportsTransitDetail ETD');
        $this->db->join("CategoryMaster C","C.CategoryId = ETD.CategoryId","LEFT");
        $this->db->where('ETD.ReportTransitId',$ReportTransitId);
        $result = $this->db->get()->result();
        return $result;
    }

    function chkCRUser($userId){
        $this->db->select("*");
        $this->db->from('CloseRingUser');
        $this->db->where('UserId', $userId);
        $result = $this->db->get()->row();
        return $result;
    }

    public function chkSession($SessionId,$UserId){
		$this->db->select('*');
		$this->db->from('PatientBackup');
		$this->db->where('SessionTimestamp',$SessionId);
		$this->db->where('UserID',$UserId);
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getReportDataForPDFCreation($UserId, $ID){
		$this->db->select('*');
		$this->db->from('PatientBackupReport');
		$this->db->where('BackupID',$ID);
		$this->db->where('UserId',$UserId);
        $this->db->order_by('InsertDate',"desc");
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function getReportFileDetailsForPDFCreation($UserId, $ID){
		$this->db->select('*');
		$this->db->from('PatientBackupFiles');
		$this->db->where('BackupID',$ID);
		$this->db->where('UserId',$UserId);
		$result = $this->db->get()->result();
		return $result;
	}

    public function ringGroupListByPatientIdNew($patientId)
    { 
        // $query = $this->db->query("SELECT DISTINCT RG.RingGroupMasterId, RG.RingGroupName FROM MRDT_Mappings MM
        //     INNER JOIN RingGroupMaster RG ON RG.RingGroupMasterId = MM.RingGroupID
        //     WHERE MM.PatientID = ".$patientId);

            
        // echo $this->db->last_query();exit;
        // $result = $query->result_array();
        // return $result;

        $this->db->distinct();
        $this->db->select('RG.RingGroupMasterId, RG.RingGroupName');
        $this->db ->from('MRDT_Mappings MM');       
        $this->db->join("RingGroupMaster RG","RG.RingGroupMasterId = MM.RingGroupID");
        $this->db->where('MM.PatientID',$patientId);
        $result = $this->db ->get()->result();
       // echo $this->db->last_query();exit;
        return $result;
    }

    
    function insertTimelineForDeleteFile($insertArr)
	{ 
	  $result = $this->db->insert("FileExpiryTime",$insertArr);
	  $insert_id = $this->db->insert_id();
	  return $insert_id;
	}

    function getGenderMasterData(){
        $this->db->select('Id,Description,MalayDescription');
		$this->db->from('GenderMaster');
		$result = $this->db->get()->result();
		return $result;
    }

    function getRunningCommentry(){
        $this->db->select('*');
		$this->db->from('RunningCommentry');
        $this->db->where('isDeleted',0);
		$result = $this->db->get()->result();
		return $result;
    }

    function updateEreferralFormInReportTable($patientId,$reportTransitId,$updateArr){
        $this->db->set('IsReferralFormProcessed', 1);
        $this->db->where('ReportTransitId',$reportTransitId);
        $this->db->where('PatientMasterId',$patientId);
        $result =  $this->db->update('EreportsTransit');
        return $result;
    }

    function getDateOfBirthOfPatient($patientId){
        $this->db->select('DateOfBirth');
		$this->db->from('PatientMaster');
        $this->db->where('PatientId',$patientId);
		$result = $this->db->get()->row();
		return $result;
    }

    function getCountryFlagAndCode($mobCode){
        $this->db->select('*');
		$this->db->from('CountryMaster');
        $this->db->where('PhoneCode',$mobCode);
		$result = $this->db->get()->row();
		return $result;
    }

    function insertDetailsInExtraBackupTable($data)
	{ 
	  $result = $this->db->insert("PatientBackupExtraReport",$data);
	  $insert_id = $this->db->insert_id();
	  return $insert_id;
	}

    public function getExtraReportDataForBackup($UserId, $BackupID){
		$this->db->select('*');
		$this->db->from('PatientBackupExtraReport');
		$this->db->where('BackupID',$BackupID);
		$this->db->where('UserId',$UserId);
		$result = $this->db->get()->row();
		return $result;
	}

    public function chkAvailableFileForProfiles($patientId){
        $intervalDate = date('Y-m-d', time() - (3 * 24 * 60 * 60));
        $this->db->select("count('ReportTransitId') as count");
		$this->db->from('EreportsTransit');
        $this->db->where('PatientMasterId',$patientId);
        $this->db->where('InsertDate > ', $intervalDate);
        $this->db->where('IsPatientProcessed', 0);
		$result = $this->db->get()->row();
        // echo $this->db->last_query();exit;
		return $result;
    }

    function ICD_search($keyword){
        $this->db->select("Id,ICDSubCode,ICDSubCodeDescription");
        $this->db->from('ICDMaster');
        $this->db->like('ICDSubCodeDescription', $keyword);
        $this->db->limit(50);
        $result = $this->db->get()->result();
        return $result;
    }

    public function advertiseListing($patientId,$ringGroup,$currentDate){
        $this->db->select('A.*,AC.CountryId as CountryMasterId');
		$this->db->from('Advertisements A');
        $this->db->join("AdvertisementsCountryList AC","AC.AdvertisementId = A.AdvertisementId");
        $this->db->where('A.RingGroupId',$ringGroup);
        $this->db->where('A.IsPublished',1);
        $this->db->where('A.IsActive',1);
        $this->db->where('A.IsDeleted',0);
        $this->db->order_by('A.InsertDate','DESC');
		$result = $this->db->get()->result();
		return $result;
    }

    public function advertiseListingWithCompany($patientId,$ringGroup,$currentDate,$companyName){
        $this->db->select('A.*,AC.CountryId as CountryMasterId');
		$this->db->from('Advertisements A');
        $this->db->join("AdvertisementsCountryList AC","AC.AdvertisementId = A.AdvertisementId");
        $this->db->where('A.RingGroupId',$ringGroup);
        $this->db->where('A.CustomerCompanyName',$companyName);
        $this->db->where('A.IsPublished',1);
        $this->db->where('A.IsActive',1);
        $this->db->where('A.IsDeleted',0);
        $this->db->order_by('A.InsertDate','DESC');
		$result = $this->db->get()->result();
		return $result;
    }

    public function advertiseListingUniversal($patientId,$currentDate){
        $this->db->select('A.*,AC.CountryId as CountryMasterId');
		$this->db->from('Advertisements A');
        $this->db->join("AdvertisementsCountryList AC","AC.AdvertisementId = A.AdvertisementId");
        $this->db->where('A.IsPublished',1);
        $this->db->where('A.IsActive',1);
        $this->db->where('A.IsDeleted',0);
        $this->db->order_by('A.InsertDate','DESC');
		$result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
		return $result;
    }

    public function advertiseListingUniversalWithCompany($patientId,$currentDate,$companyName){
        $this->db->select('A.*,AC.CountryId as CountryMasterId');
	    $this->db->from('Advertisements A');
        $this->db->join("AdvertisementsCountryList AC","AC.AdvertisementId = A.AdvertisementId");
        $this->db->where('A.CustomerCompanyName',$companyName);
        $this->db->where('A.IsPublished',1);
        $this->db->where('A.IsActive',1);
        $this->db->where('A.IsDeleted',0);
        $this->db->order_by('A.InsertDate','DESC');
		$result = $this->db->get()->result();
		return $result;
    }

    function Advertise_search($keyword,$ringGroup,$currentDate){
        $this->db->select('A.*,AC.CountryId as CountryMasterId');
        $this->db->from('Advertisements A');
        $this->db->join("AdvertisementsCountryList AC","AC.AdvertisementId = A.AdvertisementId");
        $this->db->group_start();
        $this->db->where("A.CustomerCompanyName LIKE '%".$keyword."%' ");
        $this->db->or_where("A.NotificationHeading LIKE '%".$keyword."%' ");
        $this->db->or_where("A.NotificationBody LIKE '%".$keyword."%' ");
        $this->db->group_end();
        $this->db->where('A.RingGroupId',$ringGroup);
        // $this->db->where('StartDate <= ', $currentDate);
        // $this->db->where('EndDate >= ', $currentDate);
        $this->db->where('A.IsPublished',1);
        $this->db->where('A.IsActive',1);
        $this->db->where('A.IsDeleted',0);
        $this->db->order_by('A.InsertDate','DESC');
        $this->db->limit(50);
        $result = $this->db->get()->result();
        return $result;
    }

    function Advertise_search_universal($keyword,$currentDate){
        $this->db->select('A.*,AC.CountryId as CountryMasterId');
        $this->db->from('Advertisements A');
        $this->db->join("AdvertisementsCountryList AC","AC.AdvertisementId = A.AdvertisementId");
        $this->db->group_start();
        $this->db->where("A.CustomerCompanyName LIKE '%".$keyword."%' ");
        $this->db->or_where("A.NotificationHeading LIKE '%".$keyword."%' ");
        $this->db->or_where("A.NotificationBody LIKE '%".$keyword."%' ");
        $this->db->group_end();
        $this->db->where('A.IsPublished',1);
        $this->db->where('A.IsActive',1);
        $this->db->where('A.IsDeleted',0);
        $this->db->order_by('A.InsertDate','DESC');
        $this->db->limit(50);
        $result = $this->db->get()->result();
        //echo $this->db->last_query();exit;
        return $result;
    }

    function AdvertiseMsgInbox($companyName,$ringGroup){
        $this->db->select('*');
		$this->db->from('Advertisements');
        $this->db->where('CustomerCompanyName',$companyName);
        $this->db->where('RingGroupId',$ringGroup);
        $this->db->where('IsPublished',1);
        $this->db->order_by('InsertDate','DESC');
		$result = $this->db->get()->result();
		return $result;
    }

    function InsertMrnOfUser($dataArr){
        $result = $this->db->insert("UserMRN",$dataArr);
        $insert_id = $this->db->insert_id();

        $this->db->select('Id,RINGID,CMSID,MRNNo');
		$this->db->from('UserMRN');
        $this->db->where('Id',$insert_id);
		$data = $this->db->get()->row();
        return $data;
    }

    function checkMrnOfRingUser($RingId,$CMSId){
        $this->db->select('Id,RINGID,CMSID,MRNNo');
		$this->db->from('UserMRN');
        $this->db->where('RINGID',$RingId);
        $this->db->where('CMSID',$CMSId);
		$result = $this->db->get()->row();
        return $result;
    }

    
    function insertReportDataOfSCMS($insertArr){
        
        $result = $this->db->insert("CMS_Report",$insertArr);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function searchIdOfGivenString($keyword,$table,$strCol){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($strCol." = '".$keyword."' ");
        $result = $this->db->get()->row();
        return $result;
    }

    
    function GetCMSReportDataOfPatient($ringId, $ImpId){
        $this->db->select("*");
        $this->db->from("CMS_Report");
        $this->db->where('RingId',$ringId);
        $this->db->where('ImplementationId',$ImpId);
        $this->db->where('IsDownloaded',0);
        $result = $this->db->get()->result();
        return $result;
    }

    public function CMSReportStatusUpdate($fileId,$updateArr){
        $this->db->where('Id',$fileId);
        $result =  $this->db->update('CMS_Report',$updateArr);
        return $result;
    }   

    function DoctorImpData($insertArr){
        
        $result = $this->db->insert("DoctorImplementation",$insertArr);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function getUserDataForCMS($MRN,$mob_code,$mobile_number,$email){
        $this->db->select('PatientMaster.*, BloodGroupMaster.BloodGroupCode bloodgroup, BloodGroupMaster.BloodGroup bloodgroupDes');
        $this->db ->from('PatientMaster');
        $this->db->join("BloodGroupMaster","BloodGroupMaster.BloodGroupId = PatientMaster.BloodGroupId","LEFT");
        // if(!empty($MRN)){
        //     $this->db->where('MRNo',$MRN);
        // }
        if(!empty($mob_code) && !empty($mobile_number)){
            $this->db->where('PatientMaster.MobileCode',$mob_code);
             $this->db->where('PatientMaster.MobileNumber',$mobile_number);
        }
        if($email){
            $this->db->where('PatientMaster.Email',$email);
        }        
        $result = $this->db ->get()->row();
        //  echo $this->db->last_query();exit;
            return $result;
    }

    function getTenantByname($keyword){
        $this->db->select('TenantId,TenantName');
        $this->db->from('Tenants');
        $this->db->where('TenantName', $keyword);
        $this->db->where('IsActive',1);
        $result = $this->db ->get()->row();
        return $result;
    }

    function userVerification($ringId,$impId){
        $this->db->select("*");
        $this->db->from("UserMRN");
        $this->db->where('RINGID',$ringId);
        $this->db->where('ImplementationId',$impId);
        $result = $this->db->get()->row();
        return $result;
    }

    function userVerificationForRingConnect($ringId,$impId,$ringGroupId){
        $this->db->select("*");
        $this->db->from("UserMRN");
        $this->db->where('RINGID',$ringId);
        $this->db->where('RingGroupId',$ringGroupId);
        $this->db->where('ImplementationId',$impId);
        $result = $this->db->get()->row();
        return $result;
    }

    function findDuplicateUser($mob_code,$mobileno,$email){
        $this->db->select("*");
        $this->db->from('PatientMaster');
        $this->db->where('MobileCode', $mob_code);
        $this->db->where('MobileNumber', $mobileno);
        $this->db->where('Email', $email);
        $result = $this->db->get()->row();
        // echo $this->db->last_query();exit;
        return $result;
    }
    
    function findDuplicateUserbyMobile($mob_code,$mobile_number){
        $this->db->select("*");
        $this->db->from('PatientMaster');
        $this->db->where('MobileCode', $mob_code);
        $this->db->where('MobileNumber', $mobile_number);
        $result = $this->db->get()->row();
        return $result;
    }

    
    function findDuplicateUserbyEmail($email){
        $this->db->select("*");
        $this->db->from('PatientMaster');
        $this->db->where('Email', $email);
        $result = $this->db->get()->row();
        return $result;
    }

    function getUserDataForCMSCopy($mob_code,$mobile_number,$email){
        $this->db->select('*');
        $this->db ->from('PatientMaster');
        if(!empty($mob_code) && !empty($mobile_number)){
            // $this->db->where('MobileCode',$mob_code);
             $this->db->where('MobileNumber',$mobile_number);
        }
        if($email){
            $this->db->where('Email',$email);
        }        
        $result = $this->db ->get()->row();
        //  echo $this->db->last_query();exit;
            return $result;
    }

    
    public function updateDependentCovertionStatus($mainPatientId,$dependentPatientId,$updateArr){
        $this->db->where('MainProfilePatientId',$mainPatientId);
        $this->db->where('DependentProfilePatientId',$dependentPatientId);
        $result =  $this->db->update('DependentProfileDetails',$updateArr);
        return $result;
    }  

    function getReportsCount1($pat_id,$ringGrpId){
        // $this->db->select('ET.ReportTransitId,ET.FileAttachments,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, ET.InsertUserId DoctorId, U.DisplayName doctorName, T.TenantName, C.Category');
        // $this->db->select('ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, ET.InsertUserId DoctorId, U.DisplayName doctorName, T.TenantName');
        // print_r($pat_id);exit;
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $dateNow = date('Y-m-d');
        $intervalDate = date('Y-m-d', time() - (3 * 24 * 60 * 60));
        $this->db->distinct();
        $this->db->select("ET.ReportTransitId");
        $this->db->from('EreportsTransit ET');
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        if(!empty($ringGrpId)){
            // $this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
            $this->db->group_start();
            $this->db->where('RGT.RingGroupId',$ringGrpId);
                $this->db->or_group_start();
                            $this->db->where('ET.RingGroup',$ringGrpId);
                $this->db->group_end();           
            $this->db->group_end();
        }
        $this->db->where('ET.PatientMasterId',$pat_id);     
        $this->db->where('ET.InsertDate > ', $intervalDate);
        $this->db->where('ET.IsPatientProcessed',0);
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function getReportsCount2($pat_id,$ringGrpId){
        $this->db->distinct();
        $this->db->select("ET.ReportTransitId");
        $this->db ->from('EreportsTransit ET');
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        $this->db->where('ET.PatientMasterId',$pat_id);
        if(!empty($ringGrpId)){
            $this->db->where('ET.RingGroup',$ringGrpId);
        }
        $this->db->where('ET.AddReferral',1);
        $this->db->where('ET.IsDoctorProcessed',0);
        $this->db->where('ET.EReferralStatus','Completed');
        $result = $this->db ->get()->result();
        return $result;
    }

    function getReportsCount3($pat_id){
        $this->db->distinct();
        $this->db->select("Id");
        $this->db->from("CMS_Report");
        $this->db->where('RingId',$pat_id);
        $this->db->where('ImplementationId',1);
        $this->db->where('IsDownloaded',0);
        $result = $this->db->get()->result();
        return $result;
    }

    function EreportForTransferUpdate($pat_id){
        $this->db->select("ReportTransitId");
        $this->db->from('EreportsTransit');
        $this->db->where('PatientMasterId',$pat_id);
        $this->db->where('IsPatientProcessed',0);
        $result = $this->db->get()->result();
        return $result;
    }
   
    function updateReportDetails($ReportTransitId,$newPatientId,$table){
        $this->db->set('PatientMasterId',$newPatientId);
        $this->db->where('ReportTransitId', $ReportTransitId);
        $result =  $this->db->update($table);
        return $result;
    }

    function CMSreportForTransferUpdate($oldPatientId){
        $this->db->select("Id");
        $this->db->from("CMS_Report");
        $this->db->where('RingId',$oldPatientId);
        $this->db->where('ImplementationId',1);
        $this->db->where('IsDownloaded',0);
        $result = $this->db->get()->result();
        return $result;
    }

    function updateCMSReportPatient($Id,$newPatientId,$table){
        $this->db->set('RingId',$newPatientId);
        $this->db->where('Id', $Id);
        $result =  $this->db->update($table);
        return $result;
    }

    function InsertNotificationLog($notificationArr){
        $result = $this->db->insert("AppointmentNotificationLogs",$notificationArr);
        //echo $this->db->last_query();
	    return $result;
    }

    function checkMrnOfRingUserByRingId($RingId){
        $this->db->select('Id,RINGID,CMSID,MRNNo');
		$this->db->from('UserMRN');
        $this->db->where('RINGID',$RingId);
		$result = $this->db->get()->row();
        return $result;
    }

    function UpdateMrnOfUser($updateArr,$id){
        $this->db->where('Id',$id);
        $result =  $this->db->update('UserMRN',$updateArr);
        return $result;
    }

    function userVerificationForTesting($ringId,$impId){
        $this->db->select("*");
        $this->db->from("UserMRN");
        $this->db->where('RINGID',$ringId);
        $this->db->where('IsConnected',1);
        $this->db->where('ImplementationId',$impId);
        $result = $this->db->get()->row();
        return $result;
    }

    function doctorSearch($mmcn){
        $this->db->select("U.UserId");
        $this->db->from("Users U");
		$this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
		$this->db->where('PM.MMCNumber',$mmcn);
        $result = $this->db->get()->row();
        return $result;
    }

    function getPractitionerId($userId){
        $this->db->select("U.UserId");
        $this->db->from("Users U");
		$this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
		$this->db->where('U.UserId',$userId);
        $result = $this->db->get()->row();
        return $result;
    }

    function tenantsSearchDataByKeywordsNew($keyword){
        $this->db->select("*");
        $this->db->from("Tenants");
        $this->db->like('TenantName', $keyword);
        $this->db->where('IsActive',1);
        $result = $this->db->get()->row();
        return $result;
    }

    function chkImpExist($DoctorID,$locationid){
        $this->db->select("*");
        $this->db->from("DoctorImplementation");
		$this->db->where('CmsDoctorId',$DoctorID);
		$this->db->where('LocationId',$locationid);
        $result = $this->db->get()->row();
        return $result;
    }

    function chkImpAvlByDoctorId($DoctorID){
        $this->db->select("*");
        $this->db->from("DoctorImplementation");
		$this->db->where('CmsDoctorId',$DoctorID);
        $result = $this->db->get()->result();
        return $result;
    }

    function lastInstertedId(){
		$this->db->select('UserId,TenantId');
		$this->db->from('Users');
		$this->db->order_by('UserId',"desc");
		$this->db->limit(1);
		$result = $this->db->get()->row();
		return $result;
	}

    function userConnectionStatus($ringId,$impId){
        $this->db->select("*");
        $this->db->from("UserMRN");
        $this->db->where('RINGID',$ringId);
        $this->db->where('ImplementationId',$impId);
        $result = $this->db->get()->row();
        return $result;
    }

    function userConnectionStatusForRingConnect($ringId,$impId,$ringGroupId){
        $this->db->select("*");
        $this->db->from("UserMRN");
        $this->db->where('RINGID',$ringId);
        $this->db->where('RingGroupId',$ringGroupId);
        $this->db->where('ImplementationId',$impId);
        $result = $this->db->get()->row();
        return $result;
    }

    function chkDoctorImp($doctorId,$ImpId){
        $this->db->select("*");
        $this->db->from("DoctorImplementation");
        $this->db->where('CmsDoctorId',$doctorId);
        $this->db->where('ImplementationId',$ImpId);
        $result = $this->db->get()->row();
        return $result;
    }
    

    function updateUserTable($DocRingId,$updateArr){
        $this->db->where('UserId',$DocRingId);
        $result =  $this->db->update('Users',$updateArr);
        return $result;
    }

    function updatePractitionerTable($id,$updateArr){
        $this->db->where('Id',$id);
        $result =  $this->db->update('PractitionerMaster',$updateArr);
        return $result;
    }
   
    function deleteImpData($doctorId,$LocationId){
		$this->db->where('CmsDoctorId', $doctorId);
        $this->db->where('LocationId', $LocationId);
		$result = $this->db->delete('DoctorImplementation');
		return $result;
	}

    function updateDocSchedule($doctorId,$LocationId,$updateArr){
		$this->db->where('CmsDoctorId', $doctorId);
        $this->db->where('LocationId', $LocationId);
		$result = $this->db->update('DoctorImplementation',$updateArr);
		return $result;
	}

    function InsertHospitalData($HosInsertArr)
    {
        $result = $this->db->insert("Tenants",$HosInsertArr);
        $insert_id = $this->db->insert_id();
		return  $insert_id;
    }

    function InsertUserTenant($userTenantArr)
    {
        $result = $this->db->insert("UserTenants",$userTenantArr);
        $insert_id = $this->db->insert_id();
		return  $insert_id;
    }

    function chkUserTenant($DocRingId,$TenantId){
        $this->db->select("Id");
        $this->db->from("UserTenants");
        $this->db->where('UserId',$DocRingId);
        $this->db->where('TenantId',$TenantId);
        $result = $this->db->get()->row();
        return $result;
    }

    function UpdateHospitalData($HospitalRingId,$HosUpdateArr)
    {
        $this->db->where('TenantId',$HospitalRingId);
        $result =  $this->db->update('Tenants',$HosUpdateArr);
        return $result;
    }

    function chkLocationImp($locationId,$ImpId){
        $this->db->select("*");
        $this->db->from("DoctorImplementation");
        $this->db->where('LocationId',$locationId);
        $this->db->where('ImplementationId',$ImpId);
        $result = $this->db->get()->row();
        return $result;
    }

    function deleteLocData($locationId,$ImpId){
		$this->db->where('LocationId',$locationId);
        $this->db->where('ImplementationId',$ImpId);
		$result = $this->db->delete('DoctorImplementation');
		return $result;
	}

    function updateInUserTable($RingDoctorId,$userUpdateArr)
    {
        $this->db->where('UserId',$RingDoctorId);
        $result =  $this->db->update('Users',$userUpdateArr);
        return $result;
    }

    function getPhoneCodeId($TenantPhoneCode){
        $this->db->select("ID");
        $this->db->from("CountryMaster");
        $this->db->where('PhoneCode',$TenantPhoneCode);
        $this->db->or_where('PhoneCode',"+".$TenantPhoneCode);
        $result = $this->db->get()->row();
        return $result;
    }

    function saveFinancialReportOfPatient($insertArr)
    {
        $result = $this->db->insert("CMSReportTransaction",$insertArr);
        $insert_id = $this->db->insert_id();
	    return  $insert_id;
    }

    function CMSNameList(){
        $this->db->select("Id ImplementationId,GroupName CMS_Name");
        $this->db->from("Implementation");
        $result = $this->db->get()->result();
        return $result;
    }

    function getBillingData($cms_name,$start_date,$end_date){
        $this->db->select("*");
        $this->db->from("CMSReportTransaction");
        $this->db->where("RecordType","BILLING");
        $this->db->where('CreateDate >=', $start_date);
        $this->db->where('CreateDate <=', $end_date);
        if(!empty($cms_name)){
            $this->db->where('CMSName',$cms_name);
        }else{
            $this->db->limit(10);
        }
        $this->db->order_by('Id','DESC');
        $result = $this->db->get()->result();
        return $result;
    }

    function getMRDTData($cms_name,$start_date,$end_date){
        $this->db->select("PatientName");
        $this->db->from("CMSReportTransaction");
        //$this->db->where("RecordType !=","BILLING");
        if(!empty($cms_name)){
            $this->db->where('CMSName',$cms_name);
        }
        $this->db->where('CreateDate >=', $start_date);
        $this->db->where('CreateDate <=', $end_date);
        //$this->db->group_by(array("PatientName", "HospitalName","CreateDate"));
        $this->db->group_by(array("PatientName", "HospitalName"));
        $result = $this->db->get()->result();
        return $result;
    }

    function getMRDTUserData($cms_name,$start_date,$end_date){
	    $this->db->distinct();
        $this->db->select("PatientId");
        $this->db->from("PatientMaster");
        $this->db->where('InsertDate >=', $start_date);
        $this->db->where('InsertDate <=', $end_date);
        $result = $this->db->get()->result();
        //echo $this->db->last_query();
        return $result;
    }

    

    function getIntegratedUser($cms_name,$startDate,$endDate){
        $this->db->select("count(Id) as Id");
        $this->db->from("UserMRN");
        $this->db->where('CreatedDate >=', $startDate);
        $this->db->where('CreatedDate <=', $endDate);
        $this->db->where('ImplementationId', 1);
        $result = $this->db->get()->row();
        return $result;
    }

    function getAllMRDTData($cms_name,$start_date,$end_date){
	    $this->db->select("*");
        $this->db->from("CMSReportTransaction");
        if(!empty($cms_name)){
            $this->db->where('CMSName',$cms_name);
        }
        $this->db->where('CreateDate >=', $start_date);
        $this->db->where('CreateDate <=', $end_date);
        $this->db->order_by('Id','DESC');
        $result = $this->db->get()->result();
        return $result;
    }

    
    function getpermaiMRDTData($startDate,$endDate){
        $this->db->select("*");
        $this->db->from("EreportsTransit");
        $this->db->where('InsertDate >=', $startDate);
        $this->db->where('InsertDate <=', $endDate);
        $result = $this->db->get()->result();
        return $result;
    }

    function getFinancialReportInvoiceData($cms_name){
	    $this->db->select("*");
        $this->db->from("CMSTransactionInvoice");
        if(!empty($cms_name)){
            $this->db->where('CmsName',$cms_name);
        }
        //$this->db->where('CreateDate >=', $start_date);
        //$this->db->where('CreateDate <=', $end_date);
        $this->db->order_by('Id','DESC');
        $result = $this->db->get()->result();
        return $result;
    }
    
    public function getDyanamicCalender($doctorId,$month,$year)
    { 
        $query1 = $this->db->query("DROP TABLE IF EXISTS trn_doctor_available_forring ;
        CREATE TABLE trn_doctor_available_forring (
        CurrentDate date, Day bigint, Month bigint,	Year bigint , DayOfWeek nvarchar (50)
        );
        WITH DateSequence AS 
        (
            SELECT CAST(GETDATE() AS DATE) AS CurrentDate 
            UNION ALL
            SELECT DATEADD(DAY, 1, CurrentDate) 
            FROM DateSequence
        WHERE DATEADD(DAY, 1, CurrentDate) <= DATEADD(YEAR, 1, CAST(GETDATE() AS DATE))
        )

        INSERT INTO trn_doctor_available_forring (CurrentDate,Day,Month,Year,DayOfWeek)
        SELECT 
            CurrentDate,
            DAY(CurrentDate) AS Day,
            MONTH(CurrentDate) AS Month,
            YEAR(CurrentDate) AS Year,
            DATENAME(WEEKDAY, CurrentDate) AS DayOfWeek 

        FROM DateSequence 
        OPTION (MAXRECURSION 0) 

        SELECT T.CurrentDate,T.Day,T.Month,T.Year,T.DayOfWeek, D.dayid , M.payableid , M.departmentid, M.avalable
        FROM trn_doctor_available_forring T
        JOIN enum_daymaster D ON D.day = T.DayOfWeek
        LEFT JOIN
        (
        SELECT DISTINCT PM.payableid ,ISNULL(PS.locationid,0)locationid ,ISNULL(PS.departmentid,0)departmentid , D.dayid , CASE WHEN PSD.dayid IS NULL THEN 0 ELSE 1 END avalable
        FROM  mst_payablemaster PM 
        CROSS JOIN enum_daymaster D 
        LEFT JOIN mst_payableschedule PS ON PM.payableid=PS.payableid
        LEFT JOIN mst_payablescheduledetail PSD ON PS.payscheduleid=PSD.payscheduleid
        WHERE PM.payabletypeid = 1

        ) M ON D.dayid = M.dayid
        WHERE M.payableid = ".$doctorId." AND T.Year = ".$year." AND T.Month = ".$month."
        ORDER BY T.CurrentDate , M.payableid ");
        $query1->result_array();
        return $result;
    }

    function PermaiMRDTViaPatientId($pat_id,$ringGrpId){
        date_default_timezone_set('UTC');
        $dateNow = date('Y-m-d');
        $intervalDate = date('Y-m-d h:i:s.000', time() - (1 * 30));
        //print_r($intervalDate);exit;
        $this->db->select("P.PatientId,P.MobileCode pMobileCode,P.MobileNumber pMobileNumber,P.FullName pFname,P.LastName pLname,P.Email pEmail,ET.PatientMasterId,ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm,ET.IsReferralFormProcessed, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.ReferredToUserId, ET.AddReferral, ET.InsertUserId DoctorId,ET.RingGroup , U.DisplayName doctorName,U.LastName, U.PhoneNumber UserPhoneNumber,T.TenantId, T.TenantName, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, IC.ICDSubCode, IC.ICDSubCodeDescription, PSM.SpecialityDescription DoctorSpeciality , RGT.RingGroupId as RingGroupMasterID, ET.ICD, HM.Description sirname_title,ET.RingGroupId refTenant");
        $this->db ->from('EreportsTransit ET');
        $this->db->join("PatientMaster P","P.PatientId = ET.PatientMasterId","LEFT");
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");        
        $this->db->join("ICDMaster IC","IC.Id = ET.IcdMasterId","LEFT");
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        if(!empty($ringGrpId)){
            $this->db->group_start();
            $this->db->where('RGT.RingGroupId',$ringGrpId);           
            $this->db->group_end();
        }
        $this->db->where('ET.PatientMasterId',$pat_id);     
        // $this->db->where('ET.InsertDate > ', $intervalDate);
        $this->db->where('ET.IsPatientProcessed',0);
		$this->db->order_by('ET.ReportTransitId','DESC');
        $result = $this->db ->get()->row();
        return $result;
    }

    function getAppDownTime(){
        $this->db->select("Id,Title,ShortDescription,LongDescription,Greeting,StartDate,EndDate,IsActive,InsertDate");
        $this->db->from("AppDownTime");
        $this->db->where("IsActive",1);
        $result = $this->db->get()->row();
        return $result;
    }

    function getPremiumServiceMasterData(){
        $this->db->select("*");
        $this->db->from("PremiumServicesMaster");
        $result = $this->db->get()->result();
        return $result;
    }

    function getPremiumServiceDetailsById($Id){
        $this->db->select("*");
        $this->db->from("PremiumDetails");
        $this->db->where('PremiumServicesMasterId',$Id);
        $result = $this->db->get()->result();
        return $result;
    }

    function getSubscriptionPackData($packID,$detailID){
        $this->db->select("PSM.PremiumServicesMasterId As packId, PD.*");
        $this->db->from("PremiumDetails PD");
        $this->db->join("PremiumServicesMaster PSM","PSM.PremiumServicesMasterId = PD.PremiumServicesMasterId","LEFT");
        $this->db->where('PSM.PremiumServicesMasterId',$packID);
        $this->db->where('PD.PremiumDetailsId',$detailID);
        $result = $this->db->get()->row();
        return $result;
    }

    function insertTransactionData($insertArr)
    {
        $result = $this->db->insert("PremiumSubscriptionTransaction",$insertArr);
        return $result;
    }
    function insertSubscriptionData($subscriptionArray)
    {
        $result = $this->db->insert("PatientPremiumSubscription",$subscriptionArray);
        return $result;
    }
    
    function checkUserPremiumSubscription($PatientId){
        $this->db->select("PS.*,PD.NormalPrice,PD.PromotionPrice,PD.Discount");
        $this->db->from("PatientPremiumSubscription PS");
        // $this->db->join("PremiumServicesMaster PSM","PSM.PremiumServicesMasterId = PS.PackageId","LEFT");
        $this->db->join("PremiumDetails PD","PD.PremiumDetailsId = PS.PremiumDetailsId","LEFT");
        $this->db->where('PS.PatientId',$PatientId);
        $this->db->order_by("PS.Id","DESC");
        $result = $this->db->get()->result();
        return $result;
    }

    function getLastSubscriptionTransactionOfPatient($PatientId){
        $this->db->select("*");
        $this->db->from("PremiumSubscriptionTransaction");
        $this->db->where('PatientId',$PatientId);
        $this->db->order_by('Id','DESC');
        $this->db->limit(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function unsubscribePatientSubscription($PatientId,$PackageId,$updateArr)
    {
        $this->db->where('PatientId',$PatientId);
        $this->db->where('PackageId',$PackageId);
        $result = $this->db->update('PatientPremiumSubscription',$updateArr);
        return $result;
    }

    function getSubscriptionPremiumBenefits($Id){
        $this->db->select("*");
        $this->db->from("PremiumBenefits");
        $this->db->where('PremiumServicesMasterId',$Id);
        $result = $this->db->get()->result();
        return $result;
    }

    function checkUsersLastPremiumSubscription($PatientId){
        $this->db->select("*");
        $this->db->from("PatientPremiumSubscription");
        $this->db->where('PatientId',$PatientId);
        $this->db->order_by("Id","DESC");
        $this->db->limit(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function checkLoginDeviceNew($patientId){
        return  $this->db->select("DeviceUniqeId")->from("Notification")->where('PatientId', $patientId)->get()->row();
    }
    public function updateDeviceTokenNew($id,$device_token,$source,$DeviceUniqeId){
        if($device_token == null)
        {
            return false;
        }
        else
        {
            $this->db->set('DeviceId', $device_token);
            $this->db->set('DeviceUniqeId', $DeviceUniqeId);
            $this->db->set('Platform', $source);
            $this->db->where('PatientId', $id);
            return $this->db->update("Notification");
        }
    }
    public function check_device_token_new($patient_id,$device_id){
        return  $this->db->select("DeviceUniqeId")->from("Notification")->where('PatientId', $patient_id)->where('DeviceUniqeId', $device_id)->get()->row();
    }
    function checkDeviceTokenByPatientIdNew($patientId,$deviceId){
        $this->db->select('DeviceId,DeviceUniqeId');
        $this->db ->from('Notification');
        $this->db->where('PatientId',$patientId);
        $this->db->where('DeviceUniqeId',$deviceId);
        $this->db->where('UserType',0);
        $result = $this->db->get()->row();
        return $result;
    }

    function geVoucherListing($patientId,$currentDate,$CountryMasterId){
        $this->db->select('*');
        $this->db->from('Vouchers');
        $this->db->where('CountryMasterId',$CountryMasterId);
        $this->db->where('IsActive',1);
        $this->db->where('IsDeleted',0);
        $this->db->order_by('VoucherId',"DESC");
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function checkpremiumUser($patientId){
        $this->db->select('MembershipId');
        $this->db ->from('PatientMaster');
        $this->db->where('PatientId',$patientId);
        $result = $this->db->get()->row();
        return $result;
    }

    function geVoucherDataById($Id){
        $this->db->select('*');
        $this->db->from('Vouchers');
        $this->db->where('VoucherId',$Id);
        $result = $this->db->get()->row();
        return $result;
    }

    function insertAppointmentPaymentTransaction($insertArr)
    {
        $result = $this->db->insert("AppointmentPaymentTransaction",$insertArr);
        return $result;
    }

    function getRefferedclinicData($reportTransitId){
        //$this->db->select('ET.ReportTransitId,ET.FileAttachments,ET.InsertDate,ET.Description,ET.EreferralForm, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.AddReferral, U.DisplayName doctorName, U.PhoneNumber, T.TenantName, T.Address,, T.Latitude, T.Longitude, C.Category');
		$this->db->select('ET.ReportTransitId, T.TenantName, T.Address, T.Latitude, T.Longitude, P.FullName, P.LastName');
        $this->db->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.ReferredToUserId","LEFT");
        $this->db->join("UserTenants UT","UT.UserId = U.UserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");
        $this->db->join("PatientMaster P","P.PatientId = ET.PatientMasterId","LEFT");
        $this->db->where('ET.ReportTransitId',$reportTransitId);
        $this->db->where('ET.AddReferral',1);
        $this->db->where('ET.IsDeleted',0);
        $result = $this->db->get()->row();
        return $result;
    }

    function insertChangeEmailRequest($insertArr)
    {
        $result = $this->db->insert("ChangeEmailRequest",$insertArr);
        $insert_id = $this->db->insert_id();
		return $insert_id;
    }

    function getChangeEmailRequestStatus($Id){
        $this->db->select('*');
        $this->db->from('ChangeEmailRequest');
        $this->db->where('Id',$Id);
        $result = $this->db->get()->row();
        return $result;
    }

    function updateEmailChangeStatus($updateArr,$Id){
        $this->db->where('Id',$Id);
        $result =  $this->db->update('ChangeEmailRequest',$updateArr);
        return $result;
    }

    function EreportTransitListByReportTransitId($ReportTransitId,$DoctorId){
        
        $this->db->select("ET.PatientMasterId,ET.ReportTransitId,ET.InsertDate,ET.Description,ET.EreferralForm,ET.IsReferralFormProcessed, ET.IsProcessed, ET.IsDoctorProcessed, ET.IsPatientProcessed, ET.ReferredToUserId, ET.AddReferral, ET.InsertUserId DoctorId,ET.RingGroup , U.DisplayName doctorName,U.LastName, U.PhoneNumber UserPhoneNumber,T.TenantId, T.TenantName, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, IC.ICDSubCode, IC.ICDSubCodeDescription, PSM.SpecialityDescription DoctorSpeciality , RGT.RingGroupId as RingGroupMasterID, ET.ICD, HM.Description sirname_title,ET.RingGroupId refTenant");
        $this->db ->from('EreportsTransit ET');
        $this->db->join("Users U","U.UserId = ET.InsertUserId","LEFT");
        $this->db->join("Tenants T","T.TenantId = ET.TenantId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");        
        $this->db->join("ICDMaster IC","IC.Id = ET.IcdMasterId","LEFT");
		$this->db->join("RingGroupTenants RGT","RGT.TenantId = ET.TenantId","LEFT");
        $this->db->where('ET.ReportTransitId',$ReportTransitId);
        $this->db->where('ET.ReferredToUserId',$DoctorId);
        $result = $this->db ->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function getFileAttachmentByReportTransitIdNew($ReportTransitId,$docId){
        $this->db->select('ETD.*,C.Category');
        $this->db ->from('EreportsTransitDetail ETD');
        $this->db->join("CategoryMaster C","C.CategoryId = ETD.CategoryId","LEFT");
        $this->db->where('ETD.ReportTransitId',$ReportTransitId);
        $this->db->where('ETD.InsertUserId',$docId);
        $result = $this->db->get()->result();
        return $result;
    }

    function getDoctorFromTenantForUniversal($tenantId,$specialityId)
    {
        $this->db->distinct("DoctorId");
        $this->db->select("U.UserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, T.PhoneNumber AS UserPhoneNumber, U.SecondarySpecialityId, T.TenantId, T.TenantName  TenantName, T.PhoneCode, T.FaxCode, T.PhoneNumber TenantPhoneNuber, T.FaxNumber TenantFaxNumber, T.Address TenantAddress, PM.SpecialityId, PSM.SpecialityDescription DoctorSpeciality, HM.Description as Prefix");
        $this->db->from("UserTenants UT");
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");       
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.ID = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->where("UR.RoleId", 12);
        $this->db->where("U.IsActive", 1);
        $this->db->where("UT.TenantId", $tenantId);
		if(is_numeric($specialityId)){
			$this->db->where("PM.SpecialityId", $specialityId);
		}
        $result = $this->db->get()->result();
        // echo $this->db->last_query();exit;
        return $result;
    }

    function updateBackupDownloadStatus($patientId,$backupId,$updateArray)
    {
        $this->db->where('UserID',$patientId);
        $this->db->where('BackupID',$backupId);
        $result = $this->db->update('PatientBackup',$updateArray);
        return $result;
    }

    function InsertInAppNotificationInDB($insertArray){
        $result = $this->db->insert("InAppNotifications",$insertArray);
        $insert_id = $this->db->insert_id();
	    return $insert_id;
    }

    function InAppNotificationListOfPatient($PatientId){
        $this->db->select('*');
        $this->db->from('InAppNotifications');
        $this->db->where('PatientId',$PatientId);
        $result = $this->db->get()->result();
        return $result;
    }

    function updateInAppNotificationReadStatus($Id,$updateArr){
        $this->db->where('Id',$Id);
        $result = $this->db->update('InAppNotifications',$updateArr);
        return $result;
    }

    function countOfInAPPNotification($PatientId){
        $this->db->select("count(Id) as count");
        $this->db->from("InAppNotifications");
        $this->db->where('PatientId',$PatientId);
        $this->db->where('ReadStatus',0);
        $result = $this->db ->get()->row();
        return $result;
    }

    function deleteInAppNotification($Id){
        $this->db->where('Id',$Id);
        $result = $this->db->delete('InAppNotifications');
        return $result;
    }

    function insertUserToken($insertArray){
        $result = $this->db->insert("MP_UserToken",$insertArray);
        $insert_id = $this->db->insert_id();
	    return $insert_id;
    }

    function fetchUserDetailsByToken($token)
    {
        $this->db->select("U.UserId, HM.Description sirname_title, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, U.Email, U.PhoneNumber, PM.MMCNumber");
        $this->db->from("MP_UserToken UT");
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");        
		$this->db->where("UT.Token", $token);
        $this->db->where("U.IsActive", 1);
        $result = $this->db->get()->row();
        return $result;
    }

    public function checkPatientById($PatientId){
        $this->db->select('*');
        $this->db ->from('PatientMaster');
        $this->db ->where('PatientId',$PatientId);
        $result = $this->db ->get()->row();
        return $result;
    }

    public function get_doctor_schedule_details($userId, $date) {
        
        $dayOfWeek = date('w', strtotime($date)); 
        $dayMasterId = $dayOfWeek + 1; 
        $this->db->select('DisplayName, Email, PhoneNumber');
        $this->db->from('Users');
        $this->db->where('UserId', $userId);
        $doctorInfo = $this->db->get()->row_array();

        $this->db->select('FromTime, ToTime, TtTime, FtTime, IsSecondarySchedule');
        $this->db->from('DoctorWorkingHours');
        $this->db->where('UserId', $userId);
        $this->db->where('DayMasterId', $dayMasterId);
        $workingHours = $this->db->get()->result_array();

        $this->db->select('
            A.AppointmentNo, 
            A.FromTime, 
            A.ToTime, 
            A.AppointmentDate, 
            A.AppointmentStatusId,
            P.FullName, 
            P.LastName,
            en.id as enrollmentID
        ');
        $this->db->from('Appointment as A');
        $this->db->join('Users as U', 'U.LinkUserId = A.PractitionerId');
        $this->db->join('PatientMaster as P', 'P.PatientId = A.PatientId', 'left');
        $this->db->join('Enrollment as en', 'en.AppointmentId = A.id', 'left');
        $this->db->where('U.UserId', $userId);
        $this->db->where('CAST(A.AppointmentDate AS DATE) =', $date); 
        $this->db->where('A.IsActive', 1);
        $this->db->order_by('A.FromTime', 'ASC');
        $appointments = $this->db->get()->result_array();

        $this->db->select('LeaveTypeId, Remarks, StartTime, EndTime, FtTime, TtTime');
        $this->db->from('UsersLeave');
        $this->db->where('UserId', $userId);
        $this->db->where('CAST(LeaveDate AS DATE) =', $date);
        $leaves = $this->db->get()->result_array();

        return [
            'doctor_id'     => $userId,
            'date'          => $date,
            'working_hours' => $workingHours, 
            'appointments'  => $appointments, 
            'leaves'        => $leaves,       
        ];
    }

    public function get_available_slots($userId, $date, $intervalMinutes = 30) {
        $schedule = $this->get_doctor_schedule_details($userId, $date);

        if (empty($schedule['working_hours'])) {
            return ['status' => false, 'message' => 'Doctor is not working today.'];
        }

        return $schedule; 
    }

    function getEnrollmentDetails($EnrollmentId){
        $this->db->select("E.Id enrollmentId, E.TenantId AS TenantId, E.EncounterNo, E.EnrollmentDate, E.AppointmentId, AP.AppointmentNo, AP.AppointmentDate, AP.FromTime, AP.ToTime, P.PatientId, P.FullName, P.LastName,P.DateOfBirth, G.Description GenderDescription, T.TenantName, T.Address TenantAddress, T.Email AS TenantEmail, T.WebSite AS TenantWebSite, U.DisplayName DoctorFName,U.LastName DoctorLName,PM.PractitionerCode,PM.MMCNumber,PMS.SpecialityDescription Department, PSM_DOC.SpecialityDescription DoctorPrimarySpeciality, PSM_SEC.SpecialityDescription DoctorSecondarySpeciality");
        $this->db->from("Enrollment E");
        $this->db->join("Appointment AP","AP.Id = E.AppointmentId","LEFT");
        $this->db->join("PatientMaster P","P.PatientId = E.PatientId","LEFT");
        $this->db->join("GenderMaster G","G.Id = P.GenderId","LEFT");
        $this->db->join("Tenants T","T.TenantId = E.TenantId","LEFT");
        $this->db->join("Users U","U.LinkUserId = E.PrimaryPractitionerId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.Id = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM_DOC","PSM_DOC.ID = PM.SpecialityId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM_SEC","PSM_SEC.ID = U.SecondarySpecialityId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PMS","PMS.ID = AP.SpecialityId","LEFT");
        $this->db->where("E.Id", $EnrollmentId);
        $result = $this->db->get()->row();
        return $result;
    }

    public function get_doctor_schedule_details_copy($userId, $TenantId, $date) {
        
        $dayOfWeek = date('w', strtotime($date)); 
        $dayMasterId = $dayOfWeek + 1; 
        $this->db->select('DisplayName, Email, PhoneNumber');
        $this->db->from('Users');
        $this->db->where('UserId', $userId);
        $doctorInfo = $this->db->get()->row_array();

        $this->db->select('FromTime, ToTime, TtTime, FtTime, IsSecondarySchedule');
        $this->db->from('DoctorWorkingHours');
        $this->db->where('UserId', $userId);
        $this->db->where('TenantId', $TenantId);
        $this->db->where('DayMasterId', $dayMasterId);
        $workingHours = $this->db->get()->result_array();

        $this->db->select('
            A.AppointmentNo, 
            A.FromTime, 
            A.ToTime, 
            A.AppointmentDate, 
            A.AppointmentStatusId,
            P.FullName, 
            P.LastName,
            en.id as enrollmentID
        ');
        $this->db->from('Appointment as A');
        $this->db->join('Users as U', 'U.LinkUserId = A.PractitionerId');
        $this->db->join('PatientMaster as P', 'P.PatientId = A.PatientId', 'left');
        $this->db->join('Enrollment as en', 'en.AppointmentId = A.id', 'left');
        $this->db->where('U.UserId', $userId);
        $this->db->where('A.TenantId', $TenantId);
        $this->db->where('CAST(A.AppointmentDate AS DATE) =', $date); 
        $this->db->where('A.IsActive', 1);
        $this->db->order_by('A.FromTime', 'ASC');
        $appointments = $this->db->get()->result_array();

        $this->db->select('LeaveTypeId, Remarks, StartTime, EndTime, FtTime, TtTime');
        $this->db->from('UsersLeave');
        $this->db->where('UserId', $userId);
        $this->db->where('TenantId', $TenantId);
        $this->db->where('CAST(LeaveDate AS DATE) =', $date);
        $leaves = $this->db->get()->result_array();

        return [
            'doctor_id'     => $userId,
            'TenantId'      => $TenantId,
            'date'          => $date,
            'working_hours' => $workingHours, 
            'appointments'  => $appointments, 
            'leaves'        => $leaves,       
        ];
    }

    public function get_available_slots_copy($userId, $TenantId, $date, $intervalMinutes = 30) {
        $schedule = $this->get_doctor_schedule_details_copy($userId, $TenantId, $date);

        if (empty($schedule['working_hours'])) {
            return ['status' => false, 'message' => 'Doctor is not working today.'];
        }

        return $schedule; 
    }
}