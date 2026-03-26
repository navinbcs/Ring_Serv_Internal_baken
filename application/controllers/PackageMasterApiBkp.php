<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageMasterApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PackageMaster_model', 'pkg');
        header('Content-Type: application/json');
    }

    // GET:
    // /index.php/FacilityManagement/PackageMasterApi/serviceItem?tenantId=1632&q=para&sort=DisplayText&order=ASC&limit=50&type=ALL
    public function serviceItem()
    {

         if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                $data["status"] = "ok";
                echo json_encode($data);
                exit;
              }


        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);
        $tenantId = $tokenData->TenantId;
     


    //    $tenantId = (int)$this->input->get('tenantId');
        if (!$tenantId) return $this->jsonError('tenantId required');

        $q     = trim($this->input->get('q') ?? '');
        $limit = (int)($this->input->get('limit') ?? 50);
        $sort  = trim($this->input->get('sort') ?? 'DisplayText');
        $order = strtoupper(trim($this->input->get('order') ?? 'ASC'));
        $type  = strtoupper(trim($this->input->get('type') ?? 'ALL')); // ALL|SERVICE|ITEM

        $data = $this->pkg->search_items_union($tenantId, $q, $limit, $sort, $order, $type);
        return $this->jsonOk($data);
    }

    private function jsonOk($data = [], $msg = 'Success')
    {
        echo json_encode(['status' => 1, 'message' => $msg, 'data' => $data]);
        exit;
    }

    private function jsonError($msg)
    {
        echo json_encode(['status' => 0, 'message' => $msg, 'data' => []]);
        exit;
    }
}