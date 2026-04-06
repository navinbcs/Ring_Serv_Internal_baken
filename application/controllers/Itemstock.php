<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kuala_Lumpur');
class Itemstock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();


        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit;
        } // preflight

        $this->load->model('Itemstock_model', 'stock');
        // If you use tokens, verify here from Authorization header
    }

    /** POST /api/itemstock  -> create stock row + opening history */
    public function create()
    {
       
        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);

        //  print_r( $tokenData); exit ;
        $userId = $tokenData->id;
        $MMCNumber = $tokenData->MMCNumber;
        $data = json_decode($this->input->raw_input_stream, true) ?: [];
        $res = $this->stock->create_stock($data, $userId);
        $this->respond($res, $res['ok'] ? 200 : 400);
    }

    /** GET /api/itemstock?ItemId=&Keyword=&limit=&offset= */
    public function list()
    {

        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);
        // print_r($tokenData); exit;
        $data = json_decode(file_get_contents("php://input"), true);
       //  print_r( $data); exit ;
        $filters = [
            'ItemId' => $this->input->get('ItemId', true),
            'BatchNo' => $this->input->get('BatchNo', true),
            'GRNReference' => $this->input->get('GRNReference', true),
            'ExpiryBefore' => $this->input->get('ExpiryBefore', true),
           // 'Keyword' => $this->input->get('Keyword', true),
            'Keyword' => $_GET['q'],
            'TenantId' => $tokenData->TenantId
        ];

     //  print_r($filters); exit ;
        // Support page/size (frontend) or limit/offset (legacy)
        $size = (int) ($this->input->get('size') ?? $this->input->get('limit') ?? 50);
        $page = (int) ($this->input->get('page') ?? 0);
        $limit = $size;
        $offset = $page * $size;
        $res = $this->stock->list_stocks($filters, $limit, $offset);
        $this->respond(['ok' => true] + $res);
    }

    /** GET /api/itemstock/{id} */
    public function get($id)
    {
        $row = $this->stock->get_stock((int) $id);
        $this->respond($row ? ['ok' => true, 'data' => $row] : ['ok' => false, 'error' => 'Not found'], $row ? 200 : 404);
    }

    /** PUT /api/itemstock/{id}  -> update non-qty fields */
    public function update($id)
    {
        $data = json_decode($this->input->raw_input_stream, true) ?: [];
        $userId = $this->session->userdata('user_id') ?? null;
        $ok = $this->stock->update_stock((int) $id, $this->allowedFields($data), $userId);
        $this->respond(['ok' => $ok], $ok ? 200 : 400);
    }

    /** POST /api/itemstock/{id}/move  -> add history movement (purchase/sale/adjust/...) */
    public function move($id)
    {
        $body = json_decode($this->input->raw_input_stream, true) ?: [];
        $payload = [
            'TranType' => strtoupper(trim($body['TranType'] ?? 'ADJUSTMENT')), // PURCHASE | SALE | ADJUSTMENT | WRITE_OFF | TRANSFER_IN | TRANSFER_OUT
            'QtyChange' => (float) ($body['QtyChange'] ?? 0),                     // +ve adds, -ve reduces
            'RefType' => $body['RefType'] ?? null,
            'RefNo' => $body['RefNo'] ?? null,
            'UnitCurrency' => $body['UnitCurrency'] ?? null,
            'UnitPrice' => isset($body['UnitPrice']) ? (float) $body['UnitPrice'] : null,
            'DiscountPct' => isset($body['DiscountPct']) ? (float) $body['DiscountPct'] : null,
            'Remarks' => $body['Remarks'] ?? null,
        ];
        $userId = $this->session->userdata('user_id') ?? null;

        $res = $this->stock->adjust_stock((int) $id, $payload, $userId);
        $this->respond($res, $res['ok'] ? 200 : 400);
    }

    /** GET /api/itemstock/history?StockId=&ItemId=&limit=&offset= */
    public function history()
    {
        $args = [
            'StockId' => $this->input->get('StockId', true),
            'ItemId' => $this->input->get('ItemId', true),
            'limit' => (int) ($this->input->get('limit') ?? 50),
            'offset' => (int) ($this->input->get('offset') ?? 0),
        ];
        $res = $this->stock->get_history($args);
        $this->respond(['ok' => true] + $res);
    }

    /** GET /api/itemstock/search-items?q=paracetamol */
    public function search_items()
    {
        $q = $this->input->get('q', true) ?? '';
        $items = $this->stock->search_items($q);
        $this->respond(['ok' => true, 'items' => $items]);
    }

    /** DELETE /api/itemstock/{id} */
    public function delete($id)
    {
        $userId = $this->session->userdata('user_id') ?? null;
        $ok = $this->stock->delete_stock((int) $id, $userId);
        $this->respond(['ok' => $ok], $ok ? 200 : 400);
    }

    // --- helpers ---
    private function allowedFields(array $in)
    {
        $allowed = [
            'ItemId',
            'BrandName',
            'ItemTypeName',
            'DrugName',
            'ItemClass',
            'BillingType',
            'BatchNo',
            'InitialQty',
            'AvailableQty',
            'ExpiryDate',
            'PurchaseCurrency',
            'PurchasePrice',
            'SalesCurrency',
            'SalesPrice',
            'GRNReference',
            'DiscountPct',
            'Remarks'
        ];
        $out = [];
        foreach ($allowed as $k)
            if (array_key_exists($k, $in))
                $out[$k] = $in[$k];
        return $out;
    }
    private function respond($data, $code = 200)
    {
        http_response_code($code);
        echo json_encode($data);
    }

    // GET /api/stock/available?itemId=123&tenantId=1631
    public function available()
    {
        $itemId   = (int)$this->input->get('itemId');
        $tenantId = (int)$this->input->get('tenantId');

        if (!$itemId) {
            return $this->output->set_status_header(400)
                                ->set_output(json_encode(['error' => 'itemId required']));
        }

        $qty = $this->stock->get_latest_after_qty($itemId, $tenantId);
        $batchList = $this->stock->get_item_batchwise_details($itemId, $tenantId);
       
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array("AvlQty"=>$qty,"BatchList"=>$batchList)));
    }


     public function check_batch() {
        $itemId = (int)$this->input->get('itemId');
        $batch = trim((string)$this->input->get('batch'));
        $tenantId = (int)$this->input->get('tenantId');
        $excludeStockId = (int)$this->input->get('excludeStockId');

        if (!$itemId || $batch === '') {
            return $this->output->set_status_header(400)
                ->set_output(json_encode(['error'=>'itemId and batch required']));
        }

        $exists = $this->stock->batch_exists($itemId, $batch, $tenantId ?: null, $excludeStockId ?: null);
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['exists' => $exists]));
    }


     public function StockMovement()
    {
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            echo json_encode(['status' => 'ok']); return;
        }

        $headers = $_SERVER["HTTP_AUTHORIZATION"];
        $token = str_replace("Bearer ", "", $headers);
        $kunci = $this->config->item('thekey');
        $tokenData = JWT::decode($token, $kunci);
       // print_r($tokenData); exit;

        $batchNo  = trim((string)$this->input->get('batchId', TRUE));
        $tenantId =  $tokenData->TenantId;
        $dateFrom = trim((string)$this->input->get('dateFrom', TRUE));
        $dateTo   = trim((string)$this->input->get('dateTo',   TRUE));
        $limit    = (int)($this->input->get('limit',  TRUE) ?? 200);
        $offset   = (int)($this->input->get('offset', TRUE) ?? 0);

        if ($batchNo === '') {
            $this->output->set_status_header(400)
                ->set_output(json_encode(['status'=>'error','message'=>'Provide batchNo']));
            return;
        }

        $opts = [
            'tenantId' => $tenantId,
            'dateFrom' => $dateFrom ?: null,
            'dateTo'   => $dateTo   ?: null,
            'limit'    => $limit,
            'offset'   => $offset,
        ];

        try {
            $rows  = $this->stock->get_by_batch_no($batchNo, $opts);
            $total = $this->stock->count_by_batch_no($batchNo, $opts);
            $isBatchActive = $this->stock->getIsActiveByBatchNo($batchNo);

            $this->output->set_output(json_encode([
                'status' => 'ok',
                'rows'   => $rows,
                'meta'   => [
                    'total'   => $total,
                    'limit'   => $limit,
                    'offset'  => $offset,
                    'batchNo' => $batchNo,
                    'tenantId'=> $tenantId ?: null,
                    'dateFrom'=> $opts['dateFrom'],
                    'dateTo'  => $opts['dateTo'],
                    'isBatchActive'=>$isBatchActive
                ]
            ]));
        } catch (Throwable $e) {
            $this->output->set_status_header(500)
                ->set_output(json_encode(['status'=>'error','message'=>$e->getMessage()]));
        }
    }

 public function MovementAdd()
{
    if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
        echo json_encode(['status' => 'ok']); return;
    }

    $input = json_decode($this->input->raw_input_stream, true) ?: [];
  //  print_r($input ); exit ;
    $itemId    = (int)($input['itemId'] ?? 0);
    $batchNo   = trim((string)($input['batchNo'] ?? ''));
    $tenantId  = isset($input['tenantId']) ? (int)$input['tenantId'] : null; // only if ItemStock has TenantId
    $tranType  = strtoupper(trim((string)($input['tranType'] ?? '')));
    $qtyChange = (float)($input['qtyChange'] ?? 0.0);
    $refType   = $input['refType'] ?? null;
    $refNo     = $input['refNo'] ?? null;
    $remarks   = $input['remarks'] ?? null;
    $unitCurrency = $input['unitCurrency'] ?? null;
    $unitPrice    = isset($input['unitPrice']) ? (float)$input['unitPrice'] : null;
    $discountPct  = isset($input['discountPct']) ? (float)$input['discountPct'] : null;
    $billId       = isset($input['billId']) ? (int)$input['billId'] : null;

    // Basic validation
    $allowed = ['OPENING','PURCHASE','SALE','ADJUSTMENT','WRITE_OFF','TRANSFER_IN','TRANSFER_OUT'];
    if ($itemId <= 0 || $batchNo === '' || $tranType === '' || $qtyChange == 0.0) {
        return $this->output->set_status_header(400)
            ->set_output(json_encode(['status'=>'error','message'=>'itemId, batchNo, tranType and non-zero qtyChange are required']));
    }
    if (!in_array($tranType, $allowed, true)) {
        return $this->output->set_status_header(400)
            ->set_output(json_encode(['status'=>'error','message'=>'Invalid tranType']));
    }

    // 1) Resolve StockId for this batch (batchwise)
    $this->db->from('dbo.ItemStock')->where('IsActive', 1)
             ->where('ItemId', $itemId)->where('BatchNo', $batchNo);
    // if (!empty($tenantId) && $this->db->field_exists('TenantId', 'dbo.ItemStock')) {
    //     $this->db->where('TenantId', $tenantId);
    // }
    // Choose a deterministic row if multiples exist (latest)
    $this->db->order_by('InsertDate', 'DESC');
    $stock = $this->db->get()->row_array();
  
   

    if (!$stock) {
        return $this->output->set_status_header(404)
            ->set_output(json_encode(['status'=>'error','message'=>'Batch not found for this Item']));
    }

    $stockId = (int)$stock['StockId'];

    // 2) Compute current available for BeforeQty
    // Prefer using ItemStock.AvailableQty if you have the trigger; else compute from history.
    $useTriggerMaintainedAvailable = true; // set to false if you don’t use the trigger

    // if (False) {
    //     $beforeQty = (float)$stock['AvailableQty'];
    // } else {
        $sql = "SELECT ISNULL(SUM(QtyChange), 0) AS Avl FROM dbo.ItemStockHistory WHERE StockId = ?";
         $beforeQty = (float)$this->db->query($sql, [$stockId])->row()->Avl; 
   // }

    $afterQty = $beforeQty + $qtyChange;

    // Don’t allow negative stock
    if ($afterQty < 0) {
        return $this->output->set_status_header(400)
            ->set_output(json_encode(['status'=>'error','message'=>'Operation would result in negative stock for this batch']));
    }

    // 3) Insert history row with Before/After snapshots
    $row = [
        'StockId'      => $stockId,
        'ItemId'       => $itemId,
        'TenantId'     => $stock['TenantId'],
        'TranType'     => $tranType,
        'BatchNo'      => $batchNo,
        'RefType'      => $refType,
        'RefNo'        => $refNo,
        'QtyChange'    => $qtyChange,
        'UnitCurrency' => $unitCurrency,
        'UnitPrice'    => $unitPrice,
        'DiscountPct'  => $discountPct,
        'Remarks'      => $remarks,
        'BeforeQty'    => $beforeQty,
        'AfterQty'     => $afterQty,
        'BillId'       => $billId,                  // if you added this column
       // 'TranDate'     => date('Y-m-d H:i:s'),      // optional; default exists
     //   'CreatedAt'    => date('Y-m-d H:i:s'),      // optional; default exists
        'CreatedBy'    => 3554                      // TODO: replace with logged-in userId
    ];

    $this->db->trans_begin();
    $this->db->set('TranDate', 'GETDATE()', false);
    $this->db->set('CreatedAt', 'GETDATE()', false);
    $ok = $this->db->insert('dbo.ItemStockHistory', $row);
    if (!$ok) {
        $this->db->trans_rollback();
        return $this->output->set_status_header(500)
            ->set_output(json_encode(['status'=>'error','message'=>'Insert failed']));
    }

    // 4) If you DO NOT have the DB trigger, update ItemStock.AvailableQty here
    if (!$useTriggerMaintainedAvailable) {
        $this->db->set('AvailableQty', $afterQty)
                 ->set('UpdateDate', date('Y-m-d H:i:s'))
                 ->where('StockId', $stockId)
                 ->update('dbo.ItemStock');
        if ($this->db->affected_rows() < 0) {
            $this->db->trans_rollback();
            return $this->output->set_status_header(500)
                ->set_output(json_encode(['status'=>'error','message'=>'Failed to update available qty']));
        }
    }

    $this->db->trans_commit();

    $row['HistoryId'] = (int)$this->db->insert_id();
    // Add batch and expiry back for convenience in response
    $row['BatchNo']   = $stock['BatchNo'];
    $row['ExpiryDate']= $stock['ExpiryDate'];

    return $this->output->set_output(json_encode(['status'=>'ok','row'=>$row]));
}


public function Filters()
{
 if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
        echo json_encode(['status' => 'ok']); return;
    }
    // Get tenant (optional)
    $tenantId = $this->input->get('tenantId', true);

    $filters = $this->stock->get_filter_values($tenantId);
    echo json_encode(['ok' => true, 'data' => $filters]);
}
public function alerts_summary_old()
{

    if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            echo json_encode(['status' => 'ok']); return;
        }

    $headers = $_SERVER["HTTP_AUTHORIZATION"];
    $token = str_replace("Bearer ", "", $headers);
    $kunci = $this->config->item('thekey');
    $tokenData = JWT::decode($token, $kunci);

      
    $tenantId =  $tokenData->TenantId;
    $tenantId = $this->input->get('tenantId', true);
    $res = $this->stock->get_alerts_summary($tenantId);
    echo json_encode(['ok' => true, 'data' => $res]);
}


public function alerts_summary()
{
    if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['ok' => true]));
    }

        $headers = $_SERVER["HTTP_AUTHORIZATION"];
    $token = str_replace("Bearer ", "", $headers);
    $kunci = $this->config->item('thekey');
    $tokenData = JWT::decode($token, $kunci);

      
    $tenantId =  $tokenData->TenantId;

  //  $tenantId = (int) $this->input->get('tenantId') ?: null;

    $itemAlerts  = $this->stock->get_itemwise_alerts($tenantId);
    $batchAlerts = $this->stock->get_batchwise_alerts($tenantId);
    

    $res = [
        'ok'   => true,
        'data' => [
            'item'  => $itemAlerts,   // Low/Out/Not Available  (itemwise)
            'batch' => $batchAlerts,  // ExpiringSoon/Expired   (batchwise)
        ],
    ];

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($res));
}


    public function update_status()
    {
        $payload = json_decode($this->input->raw_input_stream, true);

        $batchNo  = isset($payload['batchNo']) ? $payload['batchNo'] : 0;
        $isActive = isset($payload['IsActive']) ? (int)$payload['IsActive'] : -1;

        if ($batchNo <= 0) {
            return $this->output->set_status_header(400)
                ->set_output(json_encode(['status'=>0, 'message'=>'stockId is required']));
        }

        if (!in_array($isActive, [0, 1], true)) {
            return $this->output->set_status_header(400)
                ->set_output(json_encode(['status'=>0, 'message'=>'isActive must be 0 or 1']));
        }

        // Optional: block update if expired (if you have ExpiryDate in ItemStock)
        // if ($this->stockModel->isExpired($stockId)) { ... }

        $ok = $this->stock->updateStockStatus($batchNo, $isActive);

        if (!$ok) {
            return $this->output->set_status_header(500)
                ->set_output(json_encode(['status'=>0, 'message'=>'Failed to update status']));
        }

        return $this->output->set_output(json_encode([
            'status' => 1,
            'message' => 'Status updated',
            'data' => ['stockId'=>$batchNo, 'isActive'=>$isActive]
        ]));
    }

}
