<?php defined('BASEPATH') or exit('No direct script access allowed');

class Itemstock_model extends CI_Model
{
   private $stockTable = 'dbo.ItemStock';
   private $historyTable = 'dbo.ItemStockHistory';
   private $itemTable = 'dbo.ItemMaster';

   public function __construct()
   {
      parent::__construct();
      $this->load->database();
   }

   // --- CREATE ---
   public function create_stock(array $data, $userId = null)
   {
      //  print_r($data); exit ;
         $payload = $params = [
         $data['TentId'],
         $data['itemCode']['id'],
         $data['itemCode']['itemCode'],
         $data['itemCode']['itemName'],
         $data['brandName'] ?? null,
         $data['itemType'] ?? null,
         $data['drugCat'] ?? null,
         $data['itemClass'] ?? null,
         $data['billType'] ?? null,
         $data['batch'] ?? null,
         $data['initialStock'],
         $data['availableStock'],
         $data['expiryDate'] ?? null,
         $data['purchaseCurrency'] ?? null,
         $data['purchasePrice'] ?? null,
         $data['salesCurrency'] ?? null,
         $data['salesPrice'] ?? null,
         $data['greRef'] ?? null,
         $data['disPer'] ?? 0,
         $data['remarks'] ?? null,
         isset($data['isActive']) ? (int) $data['isActive'] : 1,
         $data['statusRemark'] ?? null,
         $userId
      ];

      $sql = "EXEC dbo.usp_ItemStock_Create ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
      $q = $this->db->query($sql, $params);
      $row = $q->row_array();
      //  return ['ok' => true, 'StockId' => (int)$row['StockId']];   

      //print_r($row); exit;
      $stockId = (int) $row['StockId'];
      // $this->db->trans_begin();
      // $this->db->insert($this->stockTable, $payload);
      //    if ($this->db->affected_rows() !== 1){ $this->db->trans_rollback(); return ['ok'=>false,'error'=>$this->db->error()]; }

      // $stockId = $this->db->insert_id();
      $tranType = !empty($payload['greRef']) ? 'PURCHASE' : 'OPENING';
      // Opening movement
      $hist = [
         'StockId' => $stockId,
         'TenantId' => $data['TentId'],
         'ItemId' => $data['itemCode']['id'],
         'BatchNo' => $data['batch'],
         'TranType' => 'PURCHASE',
         'RefType' => !empty($data['greRef']) ? 'GRN' : null,
         'RefNo' => $data['greRef'] ?? null,
         'QtyChange' => (float) $data['initialStock'],
         'BeforeQty' => (float) $data['availableStock'],
         'AfterQty' => (float) ($data['availableStock']) + (float) $data['initialStock'],
         'UnitCurrency' => $data['purchaseCurrency'] ?? null,
         'UnitPrice' => $data['purchasePrice'] ?? null,
         'DiscountPct' => $data['disPer'] ?? null,
         'Remarks' => $data['Remarks'] ?? null,
         'CreatedBy' => $userId
      ];
      $this->db->insert($this->historyTable, $hist);

      // echo $this->db->last_query(); exit ;
      /* If you DO NOT have the SQL trigger that updates AvailableQty,
          // then update the stock row here; otherwise remove this block. */
      // $this->db->set('AvailableQty', 'AvailableQty + '.((float)$hist['QtyChange']), false)
      //         ->set('UpdateDate', gmdate('Y-m-d H:i:s'))
      //         ->where('StockId', $stockId)
      //         ->update($this->stockTable);
      // echo $this->db->last_query(); exit ;

      /* Guard against negative (shouldn’t happen on opening/purchase, but safe) */
      $row = $this->db->get_where($this->stockTable, ['StockId' => $stockId])->row_array();

      if ($row && $row['AvailableQty'] < 0) {
         $this->db->trans_rollback();
         return ['ok' => false, 'error' => 'Operation would result in negative stock'];
      }
      //  if ($this->db->affected_rows() !== 1){ $this->db->trans_rollback(); return ['ok'=>false,'error'=>$this->db->error()]; }

      //  if (!$this->db->trans_status()){ $this->db->trans_rollback(); return ['ok'=>false,'error'=>'Tx failed']; }
      //  $this->db->trans_commit();
      return ['ok' => true, 'stock_id' => $stockId];
   }

   // --- READ ---
   public function get_stock($stockId)
   {
      return $this->db->get_where($this->stockTable, ['StockId' => $stockId, 'IsActive' => 1])->row_array();
   }

public function list_stocks($filters = [], $limit = 50, $offset = 0)
{
    $limit  = (int)$limit;
    $offset = (int)$offset;

    // Tenant is mandatory
    $tenantId = isset($filters['TenantId']) ? (int)$filters['TenantId'] : 0;
    if ($tenantId <= 0) {
        return ['total' => 0, 'rows' => []];
    }

    // Build dynamic WHERE (applied to source stocks before grouping)
    // NOTE: your old condition (IsActive = 1 OR IsActive != 1) is ALWAYS TRUE.
    $where = "1=1";

    // If you actually want ONLY active stocks, use:
    // $where .= " AND s.IsActive = 1";

    $where .= " AND s.TenantId = {$tenantId}";

    if (!empty($filters['ItemId'])) {
        $where .= " AND s.ItemId = " . (int)$filters['ItemId'];
    }

    if (!empty($filters['BatchNo'])) {
        $batch = $this->db->escape_like_str($filters['BatchNo']);
        $where .= " AND s.BatchNo LIKE " . $this->db->escape("%{$batch}%");
    }

    if (!empty($filters['GRNReference'])) {
        $grn = $this->db->escape_like_str($filters['GRNReference']);
        $where .= " AND s.GRNReference LIKE " . $this->db->escape("%{$grn}%");
    }

    if (!empty($filters['ExpiryBefore'])) {
        $date = date('Y-m-d', strtotime($filters['ExpiryBefore']));
        $where .= " AND s.ExpiryDate <= " . $this->db->escape($date);
    }

    if (!empty($filters['Keyword'])) {
        $kw = $this->db->escape_like_str($filters['Keyword']);
        $kwLike = $this->db->escape("%{$kw}%");
        $where .= " AND (
            s.ItemName LIKE {$kwLike}
            OR s.BrandName LIKE {$kwLike}
            OR s.ItemTypeName LIKE {$kwLike}
            OR s.DrugName LIKE {$kwLike}
            OR s.ItemClass LIKE {$kwLike}
            OR s.BillingType LIKE {$kwLike}
            OR s.itemCode LIKE {$kwLike}
        )";
    }

    // Main paged query
    $sql = "
        ;WITH SourceStocks AS (
            SELECT *
            FROM dbo.ItemStock s
            WHERE {$where}
        ),
        PerStockQty AS (
            SELECT 
                ss.TenantId,
                ss.ItemId, 
                ss.BatchNo, 
                ss.StockId,
                SUM(ISNULL(h.QtyChange,0)) AS CurrQty
            FROM SourceStocks ss
            LEFT JOIN dbo.ItemStockHistory h 
                ON h.StockId = ss.StockId
            GROUP BY 
                ss.TenantId,
                ss.ItemId, 
                ss.BatchNo, 
                ss.StockId
        ),
        BatchAgg AS (
            SELECT 
                TenantId,
                ItemId, 
                BatchNo, 
                SUM(CurrQty) AS AvlQty
            FROM PerStockQty
            GROUP BY 
                TenantId,
                ItemId, 
                BatchNo
        ),
        LatestPerBatch AS (
            SELECT *
            FROM (
                SELECT 
                    ss.*,
                    ROW_NUMBER() OVER (
                        PARTITION BY ss.TenantId, ss.ItemId, ss.BatchNo
                        ORDER BY ISNULL(ss.UpdateDate, ss.InsertDate) DESC, ss.StockId DESC
                    ) AS rn
                FROM SourceStocks ss
            ) x
            WHERE x.rn = 1
        )
        SELECT
            ba.TenantId,
            ba.ItemId,
            lpb.ItemCode,
            lpb.ItemName,
            lpb.BrandName,
            lpb.ItemTypeName,
            lpb.DrugName,
            lpb.ItemClass,
            lpb.BillingType,
            ba.BatchNo,
            lpb.ExpiryDate,
            lpb.PurchaseCurrency,
            lpb.PurchasePrice,
            lpb.SalesCurrency,
            lpb.SalesPrice,
            ba.AvlQty
        FROM BatchAgg ba
        LEFT JOIN LatestPerBatch lpb
          ON lpb.TenantId = ba.TenantId
         AND lpb.ItemId   = ba.ItemId
         AND lpb.BatchNo  = ba.BatchNo
        ORDER BY ba.BatchNo
        OFFSET {$offset} ROWS FETCH NEXT {$limit} ROWS ONLY;
    ";

    // Count distinct groups for pagination
    $countSql = "
        ;WITH SourceStocks AS (
            SELECT *
            FROM dbo.ItemStock s
            WHERE {$where}
        ),
        DistinctGroups AS (
            SELECT DISTINCT TenantId, ItemId, BatchNo FROM SourceStocks
        )
        SELECT COUNT(*) AS total FROM DistinctGroups;
    ";

    $totalRow = $this->db->query($countSql)->row_array();
    $total = (int)($totalRow['total'] ?? 0);

    $rows = $this->db->query($sql)->result_array();

    // Cast numerics
    foreach ($rows as &$r) {
        $r['AvlQty'] = isset($r['AvlQty']) ? (float)$r['AvlQty'] : 0.0;
        if (isset($r['PurchasePrice'])) $r['PurchasePrice'] = (float)$r['PurchasePrice'];
        if (isset($r['SalesPrice']))    $r['SalesPrice']    = (float)$r['SalesPrice'];
        if (isset($r['TenantId']))      $r['TenantId']      = (int)$r['TenantId'];
        if (isset($r['ItemId']))        $r['ItemId']        = (int)$r['ItemId'];
    }

    return ['total' => $total, 'rows' => $rows];
}



   // --- UPDATE META (not qty) ---
   public function update_stock($stockId, array $data, $userId = null)
   {
      $this->normalize($data);
      $data['UpdateUserId'] = $userId;
      $data['UpdateDate'] = gmdate('Y-m-d H:i:s');
      $this->db->where('StockId', $stockId)->update($this->stockTable, $data);
      return $this->db->affected_rows() >= 0;
   }

   // --- MOVEMENT ---
   public function adjust_stock($stockId, array $move, $userId = null)
   {
      if (!isset($move['QtyChange']) || (float) $move['QtyChange'] == 0)
         return ['ok' => false, 'error' => 'QtyChange required'];

      // find item
      $stock = $this->get_stock($stockId);
      if (!$stock)
         return ['ok' => false, 'error' => 'Stock not found'];

      $hist = [
         'StockId' => $stockId,
         'ItemId' => $stock['ItemId'],
         'TranType' => $move['TranType'] ?? 'ADJUSTMENT',
         'RefType' => $move['RefType'] ?? null,
         'RefNo' => $move['RefNo'] ?? null,
         'QtyChange' => (float) $move['QtyChange'], // +/-
         'UnitCurrency' => $move['UnitCurrency'] ?? null,
         'UnitPrice' => isset($move['UnitPrice']) ? (float) $move['UnitPrice'] : null,
         'DiscountPct' => isset($move['DiscountPct']) ? (float) $move['DiscountPct'] : null,
         'Remarks' => $move['Remarks'] ?? null,
         'CreatedBy' => $userId
      ];

      $this->db->trans_begin();
      $this->db->insert($this->historyTable, $hist);
      if ($this->db->affected_rows() !== 1) {
         $this->db->trans_rollback();
         return ['ok' => false, 'error' => $this->db->error()];
      }

      // If you don't use the DB trigger, update AvailableQty here:
      $this->db->set('AvailableQty', 'AvailableQty + ' . ((float) $hist['QtyChange']), false)
         ->set('UpdateDate', gmdate('Y-m-d H:i:s'))
         ->where('StockId', $stockId)
         ->update($this->stockTable);

      // guard negative
      $neg = $this->db->get_where($this->stockTable, ['StockId' => $stockId])->row_array();
      if ($neg && $neg['AvailableQty'] < 0) {
         $this->db->trans_rollback();
         return ['ok' => false, 'error' => 'Operation would result in negative stock'];
      }

      if (!$this->db->trans_status()) {
         $this->db->trans_rollback();
         return ['ok' => false, 'error' => 'Tx failed'];
      }
      $this->db->trans_commit();
      return ['ok' => true, 'stock_id' => $stockId];
   }

   // --- HISTORY READ ---
   public function get_history($args)
   {
      $limit = (int) ($args['limit'] ?? 50);
      $offset = (int) ($args['offset'] ?? 0);
      $this->db->from($this->historyTable);
      if (!empty($args['StockId']))
         $this->db->where('StockId', (int) $args['StockId']);
      if (!empty($args['ItemId']))
         $this->db->where('ItemId', (int) $args['ItemId']);
      $count = $this->db->count_all_results('', FALSE);
      $this->db->order_by('TranDate', 'DESC')->limit($limit, $offset);
      $rows = $this->db->get()->result_array();
      return ['total' => $count, 'rows' => $rows];
   }

   // --- DELETE ---
   public function delete_stock($stockId, $userId = null)
   {
      $this->db->where('StockId', $stockId)
         ->update($this->stockTable, ['IsActive' => 0, 'UpdateUserId' => $userId, 'UpdateDate' => gmdate('Y-m-d H:i:s')]);
      return $this->db->affected_rows() === 1;
   }

   // --- AUTOCOMPLETE ---
   public function search_items($term)
   {
      $t = trim($term);
      if ($t === '')
         return [];
      // TOP 20 works with sqlsrv
      $sql = "SELECT TOP 20 Id AS ItemId, Code, Description
                FROM {$this->itemTable}
                WHERE IsActive = 1 AND (Code LIKE ? OR Description LIKE ?)
                ORDER BY Code ASC";
      return $this->db->query($sql, ["%$t%", "%$t%"])->result_array();
   }

   private function normalize(array &$d)
   {
      $nullable = [
         'BrandName',
         'ItemTypeName',
         'DrugName',
         'ItemClass',
         'BillingType',
         'BatchNo',
         'ExpiryDate',
         'PurchaseCurrency',
         'PurchasePrice',
         'SalesCurrency',
         'SalesPrice',
         'GRNReference',
         'DiscountPct',
         'Remarks'
      ];
      foreach ($nullable as $f)
         if (array_key_exists($f, $d) && $d[$f] === '')
            $d[$f] = null;
      if (!empty($d['ExpiryDate']))
         $d['ExpiryDate'] = date('Y-m-d', strtotime($d['ExpiryDate']));
   }

   public function get_latest_after_qty($itemId, $tenantId = null)
   {
      $this->db->select('AfterQty')
         ->from('ItemStockHistory')
         ->where('ItemId', (int) $itemId);

      if (!is_null($tenantId)) {
         $this->db->where('TenantId', (int) $tenantId);
      }

      // Latest first
      $this->db->order_by('TranDate', 'DESC')
         ->order_by('HistoryId', 'DESC')
         ->limit(1);

      $row = $this->db->get()->row();
      return $row ? (float) $row->AfterQty : 0.0;
   }

   /**
    * Get all batches for a given ItemId (with live available quantity)
    *
    * @param int $itemId
    * @param int|null $tenantId
    * @return array
    */
   public function get_batches_by_item($itemId, $tenantId = null)
   {
      if (empty($itemId)) {
         return [];
      }

      // Base query - distinct batches
      $this->db->distinct();
      $this->db->select('s.BatchNo, s.StockId, s.ExpiryDate, ISNULL(SUM(h.QtyChange), s.AvailableQty) AS AvlQty', false);
      $this->db->from('dbo.ItemStock s');
      $this->db->join('dbo.ItemStockHistory h', 's.StockId = h.StockId', 'LEFT');
      $this->db->where('s.ItemId', (int) $itemId);
      $this->db->where('s.IsActive', 1);

      // if (!empty($tenantId)) {
      //     $this->db->where('s.TenantId', (int)$tenantId);
      // }

      $this->db->group_by('s.BatchNo, s.StockId, s.ExpiryDate, s.AvailableQty');
      $this->db->order_by('s.BatchNo', 'ASC');

      $query = $this->db->get();
      $arr = $query->result_array();

      // Optionally round or format
      foreach ($arr as &$row) {
         $row['AvlQty'] = (float) $row['AvlQty'];
      }

      return $arr;
   }


   public function get_batchwise_stock_with_meta($itemId, $tenantId = null)
   {
      if (empty($itemId))
         return [];

      // PerStockQty
      $perStockQtySql = "
        SELECT s.ItemId, s.BatchNo, s.StockId,
               SUM(ISNULL(h.QtyChange,0)) AS CurrQty
        FROM dbo.ItemStock s
        LEFT JOIN dbo.ItemStockHistory h ON h.StockId = s.StockId
        WHERE s.IsActive = 1 AND s.ItemId = ?
        " . (!empty($tenantId) ? " AND s.TenantId = ?" : "") . "
        GROUP BY s.ItemId, s.BatchNo, s.StockId
    ";

      // BatchTotals
      $batchTotalsSql = "
        SELECT ItemId, BatchNo, SUM(CurrQty) AS AvlQty
        FROM ($perStockQtySql) ps
        GROUP BY ItemId, BatchNo
    ";

      // LatestStock per batch
      $latestStockSql = "
        SELECT * FROM (
            SELECT s.*,
                   ROW_NUMBER() OVER (
                     PARTITION BY s.ItemId, s.BatchNo
                     ORDER BY ISNULL(s.UpdateDate, s.InsertDate) DESC, s.StockId DESC
                   ) rn
            FROM dbo.ItemStock s
            WHERE s.IsActive = 1 AND s.ItemId = ?
            " . (!empty($tenantId) ? " AND s.TenantId = ?" : "") . "
        ) x WHERE rn = 1
    ";

      $params = [(int) $itemId];
      if (!empty($tenantId))
         $params[] = (int) $tenantId;

      $sql = "
        WITH BatchTotals AS ($batchTotalsSql),
             LatestStock AS ($latestStockSql)
        SELECT
            bt.ItemId,
            bt.BatchNo,
            ls.ExpiryDate,
            ls.PurchasePrice,
            ls.SalesPrice,
            bt.AvlQty
        FROM BatchTotals bt
        LEFT JOIN LatestStock ls
          ON ls.ItemId = bt.ItemId AND ls.BatchNo = bt.BatchNo
        ORDER BY bt.BatchNo
    ";

      $query = $this->db->query($sql, array_merge($params, $params));
      $rows = $query->result_array();
     // echo $this->db->last_query();
      foreach ($rows as &$r)
         $r['AvlQty'] = (float) $r['AvlQty'];
      return $rows;
   }


   public function get_item_batchwise_details($itemId, $tenantId = null)
   {
      if (empty($itemId)) {
         return [];
      }

      // Base parameters
      $params = [(int) $itemId];
      if (!empty($tenantId)) {
         $params[] = (int) $tenantId;
      }

      // Full SQL with CTEs
      $sql = "
        DECLARE @ItemId INT = " . $itemId . ";  -- << set item
         DECLARE @TenantId INT = " . $tenantId . ";
            ;WITH PerStockQty AS (
               SELECT s.ItemId, s.BatchNo, s.StockId,
                     SUM(ISNULL(h.QtyChange,0)) AS CurrQty
               FROM dbo.ItemStock s
               LEFT JOIN dbo.ItemStockHistory h ON h.StockId = s.StockId
               WHERE s.IsActive = 1
                  AND s.ItemId = @ItemId AND s.TenantId = @TenantId
               GROUP BY s.ItemId, s.BatchNo, s.StockId
            ),
            BatchTotals AS (
               SELECT ItemId, BatchNo, SUM(CurrQty) AS AvlQty
               FROM PerStockQty
               GROUP BY ItemId, BatchNo
            ),
            LatestStock AS (
               SELECT *
               FROM (
                  SELECT s.*,
                           ROW_NUMBER() OVER (
                           PARTITION BY s.ItemId, s.BatchNo
                           ORDER BY ISNULL(s.UpdateDate, s.InsertDate) DESC, s.StockId DESC
                           ) AS rn
                  FROM dbo.ItemStock s
                  WHERE s.IsActive = 1
                     AND s.ItemId = @ItemId AND s.TenantId = @TenantId
               ) x
               WHERE x.rn = 1
            )
            SELECT
               bt.ItemId,
               bt.BatchNo,
               ls.ExpiryDate,
               ls.PurchasePrice,
               ls.SalesPrice,
               ls.DiscountPct,  
               bt.AvlQty
            FROM BatchTotals bt
            LEFT JOIN LatestStock ls
            ON ls.ItemId = bt.ItemId AND ls.BatchNo = bt.BatchNo
            ORDER BY bt.BatchNo;

    ";

      // Bind params twice (once for each @ItemId reference)
      $query = $this->db->query($sql, array_merge($params, $params));

      // Format numeric values
      $rows = $query->result_array();

      return $rows;
   }



   public function batch_exists($itemId, $batch, $tenantId = null, $excludeStockId = null)
   {
      $this->db->from('ItemStock')

         ->where('BatchNo', $batch)
         ->where('IsActive', 1); // if you soft-delete/inactivate rows

      // if (!is_null($tenantId)) {
      //     $this->db->where('TenantId', (int)$tenantId);
      // }
      // if (!is_null($excludeStockId)) {
      //     $this->db->where('StockId <>', (int)$excludeStockId);
      // }

      // LIMIT 1 for speed
      //   $this->db->limit(1);
      $row = $this->db->get()->row();
      //    echo $this->db->last_query(); 
      return $row;
   }


   /**
    * Get total available quantity for a particular batch
    * computed from ItemStockHistory (sum of QtyChange)
    *
    * @param string $batchNo   Required BatchNo
    * @param int|null $itemId  Optional ItemId filter
    * @return float            Total available quantity
    */
   public function get_total_available_by_batch($batchNo, $itemId = null)
   {
      if (empty($batchNo)) {
         return 0;
      }

      $this->db->select('SUM(h.QtyChange) AS TotalAvailable', false);
      $this->db->from('dbo.ItemStockHistory h');
      $this->db->join('dbo.ItemStock s', 's.StockId = h.StockId');
      $this->db->where('s.IsActive', 1);
      $this->db->where('s.BatchNo', $batchNo);

      if (!empty($itemId)) {
         $this->db->where('s.ItemId', (int) $itemId);
      }

      $query = $this->db->get();
      $row = $query->row_array();

      return isset($row['TotalAvailable']) ? (float) $row['TotalAvailable'] : 0;
   }


    public function get_by_batch_no(string $batchNo, array $opts = []): array
    {
        if ($batchNo === '') return [];

        $tenantId = isset($opts['tenantId']) ? (int)$opts['tenantId'] : 0;
        $dateFrom = $opts['dateFrom'] ?? null;
        $dateTo   = $opts['dateTo']   ?? null;
        $limit    = isset($opts['limit'])  ? (int)$opts['limit']  : 200;
        $offset   = isset($opts['offset']) ? (int)$opts['offset'] : 0;

        $this->db->select('
            HistoryId, StockId, TenantId, ItemId,
            TranDate, TranType, RefType, RefNo, Remarks,
            QtyChange, UnitCurrency, UnitPrice, DiscountPct,
            Remarks, BeforeQty, AfterQty, CreatedBy, CreatedAt,
            BillId, BatchNo
        ');
        $this->db->from($this->historyTable);
        $this->db->where('BatchNo', $batchNo);

        // if ($tenantId > 0) {
        //     $this->db->where('TenantId', $tenantId);
        // }
        if (!empty($dateFrom)) {
            $this->db->where('TranDate >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $this->db->where('TranDate <=', $dateTo);
        }

        $this->db->order_by('TranDate',  'DESC');
        $this->db->order_by('HistoryId', 'DESC');
        $this->db->limit($limit, $offset);

        $q = $this->db->get();  
        //echo $this->db->last_query(); exit ;
        return $q ? $q->result_array() : [];
    }
/**
     * Count history rows for a given batch number (for pagination).
     * @param string $batchNo
     * @param array  $opts  (optional) ['tenantId'=>int,'dateFrom'=>'YYYY-MM-DD','dateTo'=>'YYYY-MM-DD']
     * @return int
     */
    public function count_by_batch_no(string $batchNo, array $opts = []): int
    {
        if ($batchNo === '') return 0;

        $tenantId = isset($opts['tenantId']) ? (int)$opts['tenantId'] : 0;
        $dateFrom = $opts['dateFrom'] ?? null;
        $dateTo   = $opts['dateTo']   ?? null;

        $this->db->from($this->historyTable);
        $this->db->where('BatchNo', $batchNo);

        if ($tenantId > 0) {
            $this->db->where('TenantId', $tenantId);
        }
        if (!empty($dateFrom)) {
            $this->db->where('TranDate >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $this->db->where('TranDate <=', $dateTo);
        }

        return (int)$this->db->count_all_results();
    }

    /**
 * Fetch distinct filter values (ItemClass, ItemTypeName, DrugName, ExpiryQuick)
 */
public function get_filter_values($tenantId = null)
{   
    $filters = [
        'itemClasses' => [],
        'itemTypes'   => [],
        'drugCats'    => [],
        'expiryQuick' => ['30', '60', '90'] // static quick options
    ];

    // Item Class
    $this->db->distinct();
    $this->db->select('ItemClass');
    $this->db->from('dbo.ItemStock');
    $this->db->where('IsActive', 1);
    if (!empty($tenantId) && $this->db->field_exists('TenantId', 'dbo.ItemStock')) {
        $this->db->where('TenantId', $tenantId);
    }
    $this->db->where('ItemClass IS NOT NULL');
    $this->db->order_by('ItemClass', 'ASC');
    $filters['itemClasses'] = array_column($this->db->get()->result_array(), 'ItemClass');

    // Item Type
    $this->db->distinct();
    $this->db->select('ItemTypeName');
    $this->db->from('dbo.ItemStock');
    $this->db->where('IsActive', 1);
    if (!empty($tenantId) && $this->db->field_exists('TenantId', 'dbo.ItemStock')) {
        $this->db->where('TenantId', $tenantId);
    }
    $this->db->where('ItemTypeName IS NOT NULL');
    $this->db->order_by('ItemTypeName', 'ASC');
    $filters['itemTypes'] = array_column($this->db->get()->result_array(), 'ItemTypeName');

    // Drug Category
    $this->db->distinct();
    $this->db->select('DrugName');
    $this->db->from('dbo.ItemStock');
    $this->db->where('IsActive', 1);
    if (!empty($tenantId) && $this->db->field_exists('TenantId', 'dbo.ItemStock')) {
        $this->db->where('TenantId', $tenantId);
    }
    $this->db->where('DrugName IS NOT NULL');
    $this->db->order_by('DrugName', 'ASC');
    $filters['drugCats'] = array_column($this->db->get()->result_array(), 'DrugName');

    return $filters;
}

public function get_alerts_summary($tenantId = null)
{
    $table = 'dbo.vw_ItemBatchStockA';

    // 1️⃣ Low Stock
    $this->db->from($table);
    $this->db->select('COUNT(*) AS total');
    $this->db->where('BatchStatus', 'Low Stock');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $low = (int)$this->db->get()->row()->total;

    // 2️⃣ Out of Stock
    $this->db->from($table);
    $this->db->select('COUNT(*) AS total');
    $this->db->where('BatchStatus', 'Out of Stock');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $out = (int)$this->db->get()->row()->total;

    // 3️⃣ Expiring Soon & Expired
    $this->db->from($table);
    $this->db->select('COUNT(*) AS total');
    $this->db->where_in('BatchStatus', ['Expiring Soon', 'Expired']);
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $exp = (int)$this->db->get()->row()->total;

    // 4️⃣ Not Available
    $this->db->from($table);
    $this->db->select('COUNT(*) AS total');
    $this->db->where('BatchStatus', 'Not Available');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $notAvailable = (int)$this->db->get()->row()->total;

    // 5️⃣ LIST ALL ALERTS — exclude OK
    $this->db->from($table);
    $this->db->select('StockId, ItemId, ItemCode, ItemName, BatchNo, ExpiryDate, AvailableQty AS stock, BatchStatus AS status');
    $this->db->where_in('BatchStatus', [
        'Low Stock',
        'Out of Stock',
        'Expiring Soon',
        'Expired',
        'Not Available'
    ]);
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $this->db->order_by('BatchStatus', 'ASC');
    $this->db->order_by('ItemName', 'ASC');
    $list = $this->db->get()->result_array();

    return [
        'lowStock'     => $low,
        'outOfStock'   => $out,
        'expiringSoon' => $exp,
        'notAvailable' => $notAvailable,
        'list'         => $list
    ];
}

public function get_itemwise_alertss($tenantId = null, $lowStockThreshold = 10)
{
    $params = [];
    $whereTenant = '';

    if ($tenantId) {
        $whereTenant = '  TenantId = ?';
        $params[] = $tenantId;
    }

    // Item-wise aggregation
    $sql = "
        SELECT
            ItemId,
            ItemCode,
            ItemName,
            TenantId,
            SUM(AvailableQty) AS TotalQty,
            CASE
                WHEN MAX(CASE WHEN BatchStatus = 'Not Available' THEN 1 ELSE 0 END) = 1
                    THEN 'Not Available'
                WHEN SUM(AvailableQty) <= 0
                    THEN 'Out of Stock'
                WHEN SUM(AvailableQty) > 0 AND SUM(AvailableQty) <= {$lowStockThreshold}
                    THEN 'Low Stock'
                ELSE NULL
            END AS Status
        FROM dbo.vw_ItemBatchStockA
        WHERE 1 = 1
        {$whereTenant}
        GROUP BY ItemId, ItemCode, ItemName
        HAVING
            CASE
                WHEN MAX(CASE WHEN BatchStatus = 'Not Available' THEN 1 ELSE 0 END) = 1 THEN 1
                WHEN SUM(AvailableQty) <= 0 THEN 1
                WHEN SUM(AvailableQty) > 0 AND SUM(AvailableQty) <= {$lowStockThreshold} THEN 1
                ELSE 0
            END = 1
        ORDER BY ItemName ASC;
    ";

    $q = $this->db->query($sql, $params);
    $rows = $q->result_array();

    // Counts by status
    $low = $out = $na = 0;
    foreach ($rows as $r) {
        $st = strtolower(trim($r['Status']));
        if ($st === 'low stock')      $low++;
        elseif ($st === 'out of stock') $out++;
        elseif ($st === 'not available') $na++;
    }

    return [
        'lowStock'     => $low,
        'outOfStock'   => $out,
        'notAvailable' => $na,
        'list'         => $rows,
    ];
}

public function get_itemwise_alerts($tenantId = null, $lowStockThreshold = 10)
{
    $tenantId = $tenantId ? (int)$tenantId : null;

    // -----------------------------
    // 1) LOW STOCK + OUT OF STOCK (item-wise from view)
    // -----------------------------
    $params1 = [];
    $whereTenant1 = '';

    if ($tenantId) {
        $whereTenant1 = ' AND TenantId = ?';
        $params1[] = $tenantId;
    }

    $sql1 = "
        SELECT
            
            ItemId,
            ItemCode,
            ItemName,
            SUM(ISNULL(AvailableQty,0)) AS TotalQty,
            CASE
                WHEN SUM(ISNULL(AvailableQty,0)) <= 0 THEN 'Out of Stock'
                WHEN SUM(ISNULL(AvailableQty,0)) > 0 AND SUM(ISNULL(AvailableQty,0)) <= {$lowStockThreshold} THEN 'Low Stock'
                ELSE NULL
            END AS Status
        FROM dbo.vw_ItemBatchStockA
        WHERE 1 = 1
        {$whereTenant1}
        GROUP BY ItemId, ItemCode, ItemName
        HAVING
            (SUM(ISNULL(AvailableQty,0)) <= 0)
            OR (SUM(ISNULL(AvailableQty,0)) > 0 AND SUM(ISNULL(AvailableQty,0)) <= {$lowStockThreshold})
        ORDER BY ItemName ASC;
    ";

    $rows1 = $this->db->query($sql1, $params1)->result_array();


    // -----------------------------
    // 2) NOT AVAILABLE (ItemMaster active but NO history)
    // -----------------------------
    $params2 = [];
    $whereTenant2 = '';

    if ($tenantId) {
        $whereTenant2 = ' AND h.TenantId = ?';
        $params2[] = $tenantId;
    }

     $sql2 = "
        SELECT
            m.Id AS ItemId,
            m.Code As ItemCode,
            m.Description As ItemName,
            CAST(NULL AS DECIMAL(18,3)) AS TotalQty,
            'Not Available' AS Status
        FROM dbo.ItemMaster m
        WHERE m.IsActive = 1
          AND NOT EXISTS (
              SELECT 1
              FROM dbo.ItemStockHistory h
              WHERE h.ItemId = m.Id
              {$whereTenant2}
          ) and m.TenantId= {$tenantId}
        ORDER BY m.Description ASC;
    "; 

    $rows2 = $this->db->query($sql2, $params2)->result_array();

//echo $this->db->last_query(); exit ;
    // -----------------------------
    // 3) Merge (avoid duplicates)
    // If an item is already Low/Out stock, don't add Not Available
    // -----------------------------
    $seen = [];
    foreach ($rows1 as $r) {
        $seen[(int)$r['ItemId']] = true;
    }

    $naFiltered = [];
    foreach ($rows2 as $r) {
        if (!isset($seen[(int)$r['ItemId']])) {
            $naFiltered[] = $r;
        }
    }

    $rows = array_merge($rows1, $naFiltered);


    // -----------------------------
    // 4) Counts
    // -----------------------------
    $low = $out = $na = 0;
    foreach ($rows as $r) {
        $st = strtolower(trim((string)$r['Status']));
        if ($st === 'low stock') $low++;
        elseif ($st === 'out of stock') $out++;
        elseif ($st === 'not available') $na++;
    }

    return [
        'lowStock'     => $low,
        'outOfStock'   => $out,
        'notAvailable' => $na,
        'list'         => $rows,
    ];
}



public function get_batchwise_alerts($tenantId = null)
{
    $table = 'dbo.vw_ItemBatchStockA';

    /* --------------------------------------------------------
        1️⃣  EXPIRED COUNT + LIST
       --------------------------------------------------------*/
    // Count expired
    $this->db->from($table);
    $this->db->select('COUNT(*) AS total');
    $this->db->where('BatchStatus', 'Expired');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $expired = (int)$this->db->get()->row()->total;

    // List expired
    $this->db->from($table);
    $this->db->select('StockId, ItemId, ItemCode, ItemName, BatchNo, ExpiryDate, AvailableQty AS stock, BatchStatus AS status');
    $this->db->where('BatchStatus', 'Expired');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $this->db->order_by('ExpiryDate', 'ASC');
    $expiredList = $this->db->get()->result_array();


    /* --------------------------------------------------------
        2️⃣  EXPIRING SOON COUNT + LIST
       --------------------------------------------------------*/
    // Count expiring soon
    $this->db->from($table);
    $this->db->select('COUNT(*) AS total');
    $this->db->where('BatchStatus', 'Expiring Soon');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $expiringSoon = (int)$this->db->get()->row()->total;

    // List expiring soon
    $this->db->from($table);
    $this->db->select('StockId, ItemId, ItemCode, ItemName, BatchNo, ExpiryDate, AvailableQty AS stock, BatchStatus AS status');
    $this->db->where('BatchStatus', 'Expiring Soon');
    if ($tenantId) $this->db->where('TenantId', $tenantId);
    $this->db->order_by('ExpiryDate', 'ASC');
    $expiringSoonList = $this->db->get()->result_array();


    /* --------------------------------------------------------
        RETURN BOTH LISTS SEPARATELY
       --------------------------------------------------------*/

    return [
        'expired'           => $expired,
        'expiredList'       => $expiredList,

        'expiringSoon'      => $expiringSoon,
        'expiringSoonList'  => $expiringSoonList
    ];
}



public function alerts_summary()
{
    if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['ok' => true]));
    }

    $tenantId = (int) $this->input->get('tenantId') ?: null;

    $itemAlerts  = $this->stock_model->get_itemwise_alerts($tenantId);
    $batchAlerts = $this->stock_model->get_batchwise_alerts($tenantId);

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


public function updateStockStatus($batchNo, $isActive)
    {
        $this->db->where('BatchNo', $batchNo);
        $this->db->set('IsActive', $isActive);

        // Optional audit fields if you have them:
        // $this->db->set('UpdatedOn', date('Y-m-d H:i:s'));
        // $this->db->set('UpdatedBy', $this->session->userdata('username'));

        return $this->db->update('ItemStock');
    }


 public function getIsActiveByBatchNo($batchNo)
    {
        if (empty($batchNo)) {
            return null;
        }

        $row = $this->db
            ->select('IsActive')
            ->from('ItemStock')
            ->where('BatchNo', $batchNo)
            ->limit(1)
            ->get()
            ->row_array();

        return $row ? (int)$row['IsActive'] : null;
    }
}