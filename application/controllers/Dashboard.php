<?php 
class Dashboard extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        ob_clean();
        $this->load->model(array('RingCMSModel','WebserviceModel','DashboardModel','Analytics_model'));
        $config['allowed_types'] = 'pdf|csv';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->load->helper('url', 'form');
        $this->load->library('fcm', [
            'serviceAccountKeyFile' => 'ring-ee756-firebase-adminsdk-44fhx-9cb3b06973.json',
            'projectID' => 'ring-ee756'
        ]);
    }

    public function doctorDetailsAndMoreForDashboard_COPY(){  
        
          // Handle CORS preflight if needed
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['ok' => true]));
            return;
        }
        $data = json_decode(file_get_contents('php://input'));
  
        if(!empty($data))
        $doctorId = isset($data->doctorId)?$data->doctorId:'';
        else
        $doctorId='';

        
        $startDate = $data->dateRange->start ?? null;
        $endDate   = $data->dateRange->end ?? null;

        if (empty($startDate) || empty($endDate)) {
            // Current date
            $now = new DateTime();

            // Start of week (Monday)
            $startOfWeek = (clone $now)->modify('monday this week')->setTime(0, 0, 0);

            // End of week (Today)
            $endOfWeek = (clone $now)->setTime(23, 59, 59);

            $startDate = $startOfWeek->format('Y-m-d');
            $endDate   = $endOfWeek->format('Y-m-d');
        }else{


             

              $startDate =   date("Y-m-d", strtotime($startDate));
              $endDate   = date("Y-m-d", strtotime($endDate));
        }

      //  echo "Start: $startDate, End: $endDate"; exit ;
        $filter = array('from_date'=> date("Y-m-d", strtotime($startDate)),'to_date'=>date("Y-m-d", strtotime($endDate)));
        $resultArr = [];
        if(empty($doctorId)){
        $userData = $this->DashboardModel->getDoctorsDetails($doctorId);
        $resultArr["Userdata"] = $userData; }
        $todayAppointCount = $this->DashboardModel->getTodayAppointmentCount($doctorId);
        $resultArr["TodayAppCount"] = $todayAppointCount->APPCount;
        $remainAppointCount = $this->DashboardModel->getTodayRestAppointmentCount($doctorId, $startDate,$endDate);
        $resultArr["TodayRestAppCount"] = $remainAppointCount->APPCount;
        $appointCount = $this->DashboardModel->getAppointmentCount($doctorId, $startDate,$endDate);
        $resultArr["APPCount"] = $appointCount->APPCount; 
        $enrollCount = $this->DashboardModel->getEnrollmentCount($doctorId, $startDate,$endDate);
        $resultArr["EnrollCount"] = $enrollCount->EnrollCount;
        $unEnrolledCount = $this->DashboardModel->getUnenrolledPatientCount($doctorId,$startDate,$endDate);
        $resultArr["unenrolled_count"] = $unEnrolledCount->unenrolled_count;
        $resultArr["ICD_list"] = $this->DashboardModel->ICDListbyUser($doctorId,$startDate,$endDate);
        $resultArr["patient_demography"] = $this->Analytics_model->get_age_gender_distribution($filter);
        if($resultArr)             
        {
            $response['response_code']=1;
            $response['response_message']='Success';
            $response['data']=$resultArr;
        }
        else
        {
            $response['response_code']=2;
            $response['response_message']='Failed';           
        }   
        echo json_encode($response); exit;
    }

    public function age_gender()
    {
        $data = json_decode(file_get_contents('php://input'));
        // $doctorId = $data->doctorId;
        $this->load->model('Analytics_model');
        $filters = [
            'tenant_id'   => $this->input->get('tenant_id', true), // e.g. ?tenant_id=1730
            'from_date'   => $this->input->get('from_date', true), // e.g. 2025-08-01
            'to_date'     => $this->input->get('to_date', true),   // e.g. 2025-08-31
            'active_only' => true,
        ];
        $details = $this->Analytics_model->get_age_gender_distribution($filters);
        if($details)             
        {
            $response['response_code']=1;
            $response['response_message']='Success';
            $response['data']=$details;
        }
        else
        {
            $response['response_code']=2;
            $response['response_message']='Failed';           
        }   
        echo json_encode($response); exit;
    }
    public function getActiveTanents()
    {
        $q        = trim($this->input->get('q', true) ?? '');
        $page     = (int)($this->input->get('page') ?? 1);
        $pageSize = (int)($this->input->get('pageSize') ?? 20);

        if ($page < 1) $page = 1;
        if ($pageSize < 1 || $pageSize > 50) $pageSize = 20; // cap to avoid abuse
        $offset = ($page - 1) * $pageSize;

        $data  = $this->DashboardModel->getActiveTanents($q, $pageSize, $offset);
        $total = $this->DashboardModel->countActiveTenants($q);

        $response = [
            'response_code'    => 1,
            'response_message' => 'Success',
            'data'             => $data,
            'page'             => $page,
            'pageSize'         => $pageSize,
            'total'            => $total,
            'hasMore'          => ($offset + count($data)) < $total,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function getDoctorsByTanents(){  
        $data = json_decode(file_get_contents('php://input'));
        $tenant = isset($data->TenantId)?$data->TenantId:"";
        if(isset($tenant) && !empty($tenant)){
            $usertData = $this->DashboardModel->getDoctorsByTanents($tenant);
        }else{
            $usertData = $this->DashboardModel->getDoctorsList();
        }
        
        if($usertData)             
        {
            $response['response_code']=1;
            $response['response_message']='Success';
            $response['data']=$usertData;
        }
        else
        {
            $response['response_code']=2;
            $response['response_message']='Failed';          
        }
        echo json_encode($response); exit;
    }

    public function doctorsDashboardStatsForAdmin()
    {   
        $data = json_decode(file_get_contents('php://input'));
        $doctorIds = $data->doctorIds ?? [];  // Expect array of doctorIds
        $userId = $data->userId;
        if (empty($doctorIds)) {
            $response['response_code'] = 2;
            $response['response_message'] = 'Doctor IDs are required';
            echo json_encode($response); exit;
        }

        $startDate = $data->dateRange->start ?? null;
        $endDate   = $data->dateRange->end ?? null;

        if (empty($startDate) || empty($endDate)) {
            $now = new DateTime();
            $startDate = (clone $now)->modify('monday this week')->format('Y-m-d');
            $endDate   = $now->format('Y-m-d');
        }

        $resultArr = [];
        $overallTotals = [
            "TodayAppCount"     => 0,
            "TodayRestAppCount" => 0,
            "APPCount"          => 0,
            "EnrollCount"       => 0,
            "UnenrolledCount"   => 0
        ];
        $resultArr["Userdata"] = $this->DashboardModel->getDoctorsInfo($userId);
        // Loop over doctors
        foreach ($doctorIds as $doctorId) {
            $doctorData = [];
            // $doctorData["Userdata"]          = $this->DashboardModel->getDoctorsInfo($doctorId);
            $doctorData["TodayAppCount"]     = $this->DashboardModel->getTodayAppointments($doctorId)->APPCount;
            $doctorData["TodayRestAppCount"] = $this->DashboardModel->getRemainingAppointments($doctorId)->APPCount;
            $doctorData["APPCount"]          = $this->DashboardModel->getAllAppointments($doctorId)->APPCount;
            $doctorData["EnrollCount"]       = $this->DashboardModel->getAllEnrollments($doctorId)->EnrollCount;
            $doctorData["UnenrolledCount"]   = $this->DashboardModel->getUnenrolledPatients($doctorId,$startDate,$endDate)->UnenrolledCount;

            // $resultArr[$doctorId] = $doctorData;  

            $overallTotals["TodayAppCount"]     += $doctorData["TodayAppCount"];
            $overallTotals["TodayRestAppCount"] += $doctorData["TodayRestAppCount"];
            $overallTotals["APPCount"]          += $doctorData["APPCount"];
            $overallTotals["EnrollCount"]       += $doctorData["EnrollCount"];
            $overallTotals["UnenrolledCount"]   += $doctorData["UnenrolledCount"];
        }
        $resultArr["overall"] = $overallTotals;
        if ($resultArr) {
            $response['response_code']=1;
            $response['response_message']='Success';
            $response['data']=$resultArr;
        } else {
            $response['response_code']=2;
            $response['response_message']='Failed';           
        }   

        echo json_encode($response); exit;
    }


    public function searchDoctorsByTenant()
    {
        // Handle CORS preflight if needed
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['ok' => true]));
            return;
        }

        $raw = json_decode($this->input->raw_input_stream, true) ?: [];

        // Accept both camelCase and PascalCase keys from the frontend
        $tenantId = isset($_GET['tenantId']) ?$_GET['tenantId']:'' ;

        $q    = isset($raw['q'])    ? trim($raw['q'])    : $_GET['q'];
        $page = isset($raw['page']) ? max(1, (int)$raw['page']) : 1;
        $size = isset($raw['size']) ? max(1, min(100, (int)$raw['size'])) : 20;
        $offset = ($page - 1) * $size;

        // if ($tenantId <= 0) {
        //     return $this->_fail('tenantId is required');
        // }

        // Query
        $rows = $this->DashboardModel->getDoctorsByTenants($tenantId, $q, $size, $offset);

        return $this->_ok($rows);
    }

    private function _ok($data)
    {
        $resp = ['response_code' => 1, 'response_message' => 'Success', 'data' => $data];
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }

    private function _fail($msg = 'Failed')
    {
        $resp = ['response_code' => 2, 'response_message' => $msg, 'data' => []];
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }

    public function doctorDetailsAndMoreForDashboard_24Sep25(){  

        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['ok' => true]));
            return;
        }

        $data = json_decode(file_get_contents('php://input'));
        $doctorId = isset($data->tenant->DoctorId) ? $data->tenant->DoctorId : '';
        $tenantId = isset($data->doctor->TenantId) ? $data->doctor->TenantId : '';

        // Date range
        $startDate = isset($data->dateRange->start) ? $data->dateRange->start : null;
        $endDate   = isset($data->dateRange->end)   ? $data->dateRange->end   : null;

        if (empty($startDate) || empty($endDate)) {
            $now = new DateTime();
            $startOfWeek = (clone $now)->modify('monday this week')->setTime(0, 0, 0);
            $endOfWeek   = (clone $now)->setTime(23, 59, 59);

            $startDate = $startOfWeek->format('Y-m-d');
            $endDate   = $endOfWeek->format('Y-m-d');
        } else {
            $startDate = date("Y-m-d", strtotime($startDate));
            $endDate   = date("Y-m-d", strtotime($endDate));
        }

        $filter = [
            'from_date' => $startDate,
            'to_date'   => $endDate
        ];

        if (!empty($doctorId)) {
            // Case 1: Single doctor
            $pracId = $this->DashboardModel->getDoctorPracId($doctorId);
            $resultArr = $this->DashboardModel->getDashboardDataByDoctor($pracId->LinkUserId, $startDate, $endDate, $filter);

        } elseif (!empty($tenantId)) {
            // Case 2: All doctors under tenant
            $resultArr = $this->DashboardModel->getDashboardDataByTenant($tenantId, $startDate, $endDate, $filter);

        } else {
            // Case 3: All doctors
            $resultArr = $this->DashboardModel->getDashboardDataAllDoctors($startDate, $endDate, $filter);
        }

        if ($resultArr) {
            $response = [
                'response_code' => 1,
                'response_message' => 'Success',
                'data' => $resultArr
            ];
        } else {
            $response = [
                'response_code' => 2,
                'response_message' => 'No data found'
            ];
        }

        echo json_encode($response); 
        exit;
    }

    public function doctorDetailsAndMoreForDashboard(){  

        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(['ok' => true]));
            return;
        }

        $data = json_decode(file_get_contents('php://input'));
        $doctorId = isset($data->doctorId) ? $data->doctorId : '';
        $tenantId = isset($data->doctor->TenantId) ? $data->doctor->TenantId : '';

        // Date range
        $startDate = isset($data->dateRange->start) ? $data->dateRange->start : null;
        $endDate   = isset($data->dateRange->end)   ? $data->dateRange->end   : null;

        if (empty($startDate) || empty($endDate)) {
            $now = new DateTime();
            $startOfWeek = (clone $now)->modify('monday this week')->setTime(0, 0, 0);
            $endOfWeek   = (clone $now)->setTime(23, 59, 59);

            $startDate = $startOfWeek->format('Y-m-d');
            $endDate   = $endOfWeek->format('Y-m-d');
        } else {
            $startDate = date("Y-m-d", strtotime($startDate));
            $endDate   = date("Y-m-d", strtotime($endDate));
        }

        $filter = [
            'from_date' => $startDate,
            'to_date'   => $endDate
        ];

      //  print_r( $filter); exit ;
       //  echo $doctorId ; exit ;
        if (!empty($doctorId)) {
            $doctorDetails = $this->DashboardModel->getDoctorDetails($doctorId); 
           //   print_r($doctorDetails); exit ;
          //  echo $doctorDetails->RoleId ; exit ;
            if (!empty($doctorDetails) && $doctorDetails->RoleId == 46) {
                $tenantId = $doctorDetails->TenantId;
                $resultArr = $this->DashboardModel->getDashboardDataByTenant($tenantId, $startDate, $endDate, $filter);

                $billingStats = $this->DashboardModel->getBillingStatsByTenant($tenantId, $startDate, $endDate);
                $resultArr["BillingCompleted"] = $billingStats["BillingCompleted"];
                $resultArr["WaitingQueue"]     = $billingStats["WaitingQueue"];
                $resultArr["InConsultation"] = $billingStats["InConsultation"];
                $resultArr["PendingBilling"]     = $billingStats["PendingBilling"];
                $resultArr["AppointmentCount"] = $billingStats["AppointmentCount"];
            } else {
                 $tenant = $data->tenant; 
                $pracId = $this->DashboardModel->getDoctorPracId($doctorId);
                if(isset($tenant) && !empty($tenant)){
                    $resultArr = $this->DashboardModel->getDashboardDataByDoctorWithTenant($pracId->LinkUserId, $tenant, $startDate, $endDate, $filter);
                }else{
                    $headers = $_SERVER["HTTP_AUTHORIZATION"];
                    $token = str_replace("Bearer ", "", $headers);
                    $kunci = $this->config->item('thekey');
                    $tokenData = JWT::decode($token, $kunci);
                     $tenant = $tokenData->TenantId; 
                  //  print_r($tokenData ); exit ;
                   $resultArr = $this->DashboardModel->getDashboardDataByDoctorWithTenant($pracId->LinkUserId, $tenant, $startDate, $endDate, $filter);
                }
                
            }
            // $pracId = $this->DashboardModel->getDoctorPracId($doctorId);
            // $resultArr = $this->DashboardModel->getDashboardDataByDoctor($pracId->LinkUserId, $startDate, $endDate, $filter);

        } elseif (!empty($tenantId)) {
            // Case 2: All doctors under tenant 
            $resultArr = $this->DashboardModel->getDashboardDataByTenant($tenantId, $startDate, $endDate, $filter);
        } else {
            // Case 3: All doctors
            $resultArr = $this->DashboardModel->getDashboardDataAllDoctors($startDate, $endDate, $filter);
        }
        
        if ($resultArr) {
            $response = [
                'response_code' => 1,
                'response_message' => 'Success',
                'data' => $resultArr
            ];
        } else {
            $response = [
                'response_code' => 2,
                'response_message' => 'No data found'
            ];
        }

        echo json_encode($response); 
        exit;
    }

    public function checkTenantPermission()
    {
        $data = json_decode(file_get_contents('php://input'));
        if($data)
        {
            $tenantId = isset($data->TenantId) ? $data->TenantId : "";
            $UserId = $data->UserId;
            if (empty($tenantId)) {
                $response['response_code'] = 0;
                $response['response_message'] = 'TenantId is required.';
            }
                $ringGroupId = $this->DashboardModel->getRingGroupId($tenantId); 
                  echo json_encode($ringGroupId ); exit ;
                if($ringGroupId){  
                    $isAllowed["TenantPermission"] = $this->DashboardModel->isPermissionAllowed($tenantId,$ringGroupId->ID);
                }
                $userPerm = $this->DashboardModel->getUserPermissionDetails($UserId);

                echo json_encode($ringGroupId ); exit ;
                if($userPerm){
                    $isAllowed["UserPermission"] = $userPerm;
                }else{
                    $isAllowed["UserPermission"] = [];
                }
                if($isAllowed){
                    print_r($isAllowed); exit;
                    $response['response_code'] = 1;
                    $response['response_message'] = 'Success';
                    $response['response_data'] = $isAllowed;
                }else{
                    $response['response_code']=2;
                    $response['response_message']='Failed';
                }
        }
		else
		{
			$response['response_code']=3;
			$response['response_message']='data is null';
		}
        echo json_encode($response);exit;
    }

    public function getUserDataByTenantId(){
        $data = json_decode(file_get_contents('php://input'));       
        if($data)
        {
            $tenantId = $data->tenantId;
            $userData = $this->DashboardModel->getDoctorFromTenant($tenantId);         
            //$tenantDetails = $this->DashboardModel->getTenantsDetails($tenantId);
            if($userData)
            {
                $response['response_code'] = '1';
                $response['response_message'] = 'Success';
                $response['response_data'] = $userData;
                // if($tenantDetails){
                //     $response['Tenant_data'] = $tenantDetails;
                // }
            }
            else
            {
                $response['response_code'] = '2';
                $response['response_message'] = 'Failed';
            }       
        }
        else
        {
            $response['response_code'] = '3';
            $response['response_message'] = 'Data is Null';
        }
        echo json_encode($response);exit;
    }


}