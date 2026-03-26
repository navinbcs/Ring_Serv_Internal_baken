<?php
class SSOAuthModel extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertUserToken($insertArray){
        $result = $this->db->insert("MP_UserToken",$insertArray);
        $insert_id = $this->db->insert_id();
	    return $insert_id;
    }

    function fetchUserDetailsByToken($token)
    {
        $this->db->select("U.UserId,UT.TenantId,T.TenantName , HM.Description sirname_title, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, U.Email, U.PhoneNumber, PM.MMCNumber, U.LinkUserId DoctorId, PM.IcNumber, PSM.SpecialityDescription, R.RoleId, R.RoleName Role,CM.CurrrencyCode");
        $this->db->from("MP_UserToken UT");
        $this->db->join("Users U","U.UserId = UT.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.Id = PM.SpecialityId",'LEFT');
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("Roles R","UR.RoleId = R.RoleId","LEFT");        
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT");   
        $this->db->join("CountryMaster CM ","CM.Id = T.CountryID","LEFT");
		$this->db->where("UT.Token", $token);
        $this->db->where("U.IsActive", 1);
        $result = $this->db->get()->row();
    // echo $this->db->last_query();
        return $result;
    }

    function fetchUserDetailsByUserId($userId)
    {
        $this->db->select("U.UserId,UT.TenantId,T.TenantName , U.LinkUserId DoctorId, CONCAT(U.DisplayName,' ',U.LastName) AS DoctorName, HM.Description Title, U.Username, U.DisplayName FirstName, U.LastName, U.Email, U.PhoneNumber, PM.PractitionerCode, PM.MMCNumber, PM.IcNumber, PSM.SpecialityDescription, R.RoleId, R.RoleName Role , CM.CurrrencyCode");
        $this->db->from("Users U");
          $this->db->join("MP_UserToken UT","U.UserId = UT.UserId","LEFT");
        $this->db->join("PractitionerMaster PM","PM.ID = U.LinkUserId","LEFT");
        $this->db->join("PractitionerSpecialityMaster PSM","PSM.Id = PM.SpecialityId","LEFT");
        $this->db->join("HonorificMaster HM","HM.id = U.HonorificMasterId","LEFT");
        $this->db->join("UserRoles UR","U.UserId = UR.UserId","LEFT");
        $this->db->join("Roles R","UR.RoleId = R.RoleId","LEFT");    
        $this->db->join("Tenants T","T.TenantId = UT.TenantId","LEFT"); 
        $this->db->join("CountryMaster CM ","CM.Id = T.CountryID","LEFT");
		$this->db->where("U.UserId", $userId);
        $this->db->where("U.IsActive", 1);
        $result = $this->db->get()->row();
        return $result;
    }

function getCurrencyCodeByTenantId($tenantId)
{
    $this->db->select("CM.CurrrencyCode");
    $this->db->from("Tenants T");
    $this->db->join("CountryMaster CM", "CM.Id = T.CountryID", "LEFT");
    
    $this->db->where("T.TenantId", $tenantId);
    $this->db->where("T.IsActive", 1);

    $result = $this->db->get()->row();

    return $result ? $result->CurrrencyCode : null;
}
}