<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageMaster_model extends CI_Model
{
    public function search_items_union($tenantId, $q = '', $limit = 50, $sort = 'DisplayText', $order = 'ASC', $type = 'ALL')
    {
        $limit = (int)$limit;
        if ($limit <= 0 || $limit > 200) $limit = 50;

        // Whitelist sort columns (to prevent SQL injection + ORDER BY errors)
        $allowedSort = [
            'DisplayText'    => 'DisplayText',
            'ItemName'       => 'ItemName',
            'Code'           => 'Code',
            'DepartmentName' => 'DepartmentName',
            'UnitPrice'      => 'UnitPrice',
            'Type'           => 'Type',
        ];

        $sortCol = isset($allowedSort[$sort]) ? $allowedSort[$sort] : 'DisplayText';
        $order   = ($order === 'DESC') ? 'DESC' : 'ASC';
        $type    = in_array($type, ['ALL','SERVICE','ITEM']) ? $type : 'ALL';

        $params = [];
        $like = '';
        if ($q !== '') {
            $like = '%' . $q . '%';
        }

        // ---------- SERVICE QUERY ----------
        $serviceSql = "
            SELECT
                CAST(s.Id AS INT)                 AS RefId,
                CAST(s.Id AS INT)                 AS ServiceId,
                CAST(NULL AS INT)                 AS ItemId,
                s.Code                             AS Code,
                s.Code                             AS ServiceCode,
                s.Description                      AS ItemName,
                s.DepartmentId                     AS DepartmentId,
                d.Description                      AS DepartmentName,
                CAST(s.UnitPrice AS DECIMAL(18,2)) AS UnitPrice,
                CAST(s.TaxPercentage AS DECIMAL(18,2))      AS TaxPercentage,
                CAST(s.DiscountPercentage AS DECIMAL(18,2)) AS DiscountPercentage,
                'SERVICE'                          AS Type,
                (s.Description + ' - ' + s.Code + ' (' + ISNULL(d.Description,'') + ')') AS DisplayText
            FROM dbo.ServiceMaster s
            LEFT JOIN dbo.DepartmentMaster d
                ON d.Id = s.DepartmentId
               AND d.TenantId = s.TenantId
            WHERE s.TenantId = ?
              AND ISNULL(s.IsActive,1) = 1
        ";

        $params[] = (int)$tenantId;

        if ($q !== '') {
            $serviceSql .= " AND (s.Code LIKE ? OR s.Description LIKE ? OR d.Description LIKE ?)";
            $params[] = $like; $params[] = $like; $params[] = $like;
        }

        // ---------- ITEM QUERY ----------
        $itemSql = "
            SELECT
                CAST(i.Id AS INT)                 AS RefId,
                CAST(NULL AS INT)                 AS ServiceId,
                CAST(i.Id AS INT)                 AS ItemId,
                i.Code                             AS Code,
                NULL                               AS ServiceCode,
                i.Description                      AS ItemName,
                CAST(NULL AS INT)                  AS DepartmentId,
                'Item'                             AS DepartmentName,
                CAST(i.UnitPrice AS DECIMAL(18,2)) AS UnitPrice,
                CAST(i.TaxPercentage AS DECIMAL(18,2))      AS TaxPercentage,
                CAST(i.DiscountPercentage AS DECIMAL(18,2)) AS DiscountPercentage,
                'ITEM'                             AS Type,
                (i.Description + ' - ' + i.Code + ' (Item)') AS DisplayText
            FROM dbo.ItemMaster i
            WHERE i.TenantId = ?
             AND ISNULL(i.IsActive,1) = 1 and BillingType=1  ";
       

        $params[] = (int)$tenantId;

        if ($q !== '') {
            $itemSql .= " AND (i.Code LIKE ? OR i.Description LIKE ?)";
            $params[] = $like; $params[] = $like;
        }

        // Include based on type
        $parts = [];
        if ($type === 'ALL' || $type === 'SERVICE') $parts[] = $serviceSql;
        if ($type === 'ALL' || $type === 'ITEM')    $parts[] = $itemSql;

        $unionSql = implode("\nUNION ALL\n", $parts);

        // ORDER BY (avoid duplicate columns)
        $orderBy = "X.{$sortCol} {$order}";
        if ($sortCol !== 'DisplayText') {
            $orderBy .= ", X.DisplayText ASC";
        }

        $sql = "
            SELECT TOP ({$limit}) *
            FROM (
                {$unionSql}
            ) X
            ORDER BY {$orderBy}
        ";

        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    // -------------------------------
    // PackageCode Auto Generator
    // Format: RCKL-0001-A
    // Sequence: 0001..9999 for A then B then C...
    // -------------------------------

    /**
     * Map TenantName -> Prefix
     * Add more mappings if needed.
     */
    private function _tenant_prefix($tenantName)
    {
        $tenantName = trim((string)$tenantName);

        $map = [
            'RING Clinic Kuala Lumpur' => 'RCKL',
        ];

        if (isset($map[$tenantName])) {
            return $map[$tenantName];
        }

        // Fallback: build initials up to 4 chars (e.g., "RING Clinic Pune" => RCP)
        $words = preg_split('/\s+/', preg_replace('/[^A-Za-z0-9 ]/', ' ', $tenantName));
        $abbr = '';
        foreach ($words as $w) {
            $w = trim($w);
            if ($w === '') continue;
            $abbr .= strtoupper(substr($w, 0, 1));
            if (strlen($abbr) >= 4) break;
        }
        return $abbr !== '' ? $abbr : 'GEN';
    }

    /**
     * Get last PackageCode for Facility
     */
    public function get_last_package_code($facilityId)
    {
        $sql = "
            SELECT TOP 1 PackageCode
            FROM dbo.PackageMaster
            WHERE 
               FacilityId = ?
            ORDER BY PackageCode DESC
        ";
        $q = $this->db->query($sql, [(int)$facilityId]);
        $row = $q->row_array();
        
        return $row ? ($row['PackageCode'] ?? null) : null;
    }

    /**
     * Generate next PackageCode for facility based on last code.
     */
    public function get_next_package_code($facilityId, $tenantName)
    {
        $prefix = $this->_tenant_prefix($tenantName);
        $lastCode = $this->get_last_package_code($facilityId);

        // start case
        if (!$lastCode) {
            return sprintf('%s-%04d-%s', $prefix, 1, 'A');
        }

        // expected: PREFIX-0001-A
        if (!preg_match('/-(\d{4})-([A-Z])$/i', $lastCode, $m)) {
            // if existing data not in format, restart sequence safely
            return sprintf('%s-%04d-%s', $prefix, 1, 'A');
        }

        $lastNumber = (int)$m[1];
        $lastLetter = strtoupper($m[2]);
        $letterIndex = ord($lastLetter) - 64; // A=1

        if ($lastNumber < 9999) {
            $newNumber = $lastNumber + 1;
            $newLetterIndex = $letterIndex;
        } else {
            $newNumber = 1;
            $newLetterIndex = $letterIndex + 1;
            if ($newLetterIndex > 26) {
                throw new Exception('PackageCode limit reached (Z). Please extend format (AA/AB) if needed.');
            }
        }

        $newLetter = chr(64 + $newLetterIndex);

        return sprintf('%s-%04d-%s', $prefix, $newNumber, $newLetter);
    }

    /**
     * Insert PackageMaster with auto PackageCode.
     * $payload supports: PackageName, ValidFrom, ValidTo, Status
     */
public function save_package(int $facilityId, string $tenantName, ?int $userId, array $data): array
    {
        $this->db->trans_begin();

        try {
            // 1) Generate PackageCode
            $packageCode = $this->get_next_package_code($facilityId, $tenantName);

            // 2) Insert PackageMaster
            $masterInsert = [
                'FacilityId' => $facilityId,
                'PackageCode' => $packageCode,
                'PackageName' => $data['PackageName'],
                'ValidFrom'   => $data['ValidFrom'] ?? null,
                'ValidTo'     => $data['ValidTo'] ?? null,
                'Duration'    => $data['Duration'] ?? null,
                'Status'      => $data['Status'] ,
                'IsDeleted'   => 0,
                'CreatedBy'   => $userId,
                'CreatedOn'   => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('PackageMaster', $masterInsert);
            $packageId = (int)$this->db->insert_id();

            if ($packageId <= 0) {
                throw new Exception('Failed to insert PackageMaster');
            }

            // 3) Insert PackageItem rows
            foreach (($data['Items'] ?? []) as $row) {  
                //print_r( $row); exit ;

                // map from frontend keys to DB columns
                $itemInsert = [
                    'PackageId' => $packageId,
                    'DepartmentId' => (int)($row['DepartmentId'] ?? 0),
                    'ItemId' => (int)($row['ItemId'] ?? 0),
                    'ServiceId' => (int)($row['ServiceId'] ?? 0),
                    'UnitPrice' => (float)($row['unitPrice'] ?? 0),
                    'Quantity' => (float)($row['quantity'] ?? 0),
                    'PackageDiscount' => (float)($row['discount'] ?? 0),
                    'TaxValue' => (float)($row['tax'] ?? 0),
               //     'TotalPrice' => (float)($row['totalPrice'] ?? 0),
                //    'AmountExcludingTax' => (float)($row['amountExclTax'] ?? 0),
                  //  'NetAmount' => (float)($row['netAmount'] ?? 0),

                    'IsDeleted' => 0,
                    'CreatedBy' => $userId,
                    'CreatedOn' => date('Y-m-d H:i:s'),
                ];

                // basic validation
                // if ($itemInsert['DepartmentId'] <= 0 || $itemInsert['ItemId'] <= 0) {
                //     throw new Exception('Invalid DepartmentId/ItemId in PackageItem');
                // }

                $this->db->insert('PackageItem', $itemInsert); 
                if ($this->db->affected_rows() <= 0) {
                    throw new Exception('Failed to insert PackageItem');
                }
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }

            $this->db->trans_commit();

            return [
                'PackageId' => $packageId,
                'PackageCode' => $packageCode
            ];

        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw $e;
        }
    }


    /**
     * Mark packages as inactive when ValidTo has expired (ValidTo < today).
     * Only affects packages with ValidTo set and Status = 1.
     */
    public function mark_expired_packages_inactive(int $facilityId): int
    {
        $sql = "
            UPDATE dbo.PackageMaster
            SET Status = 0,
                UpdatedOn = ?,
                UpdatedBy = NULL
            WHERE FacilityId = ?
              AND IsDeleted = 0
              AND Status = 1
              AND ValidTo IS NOT NULL
              AND ValidTo != ''
              AND CAST(ValidTo AS DATE) < CAST(GETDATE() AS DATE)
        ";
        $this->db->query($sql, [date('Y-m-d H:i:s'), (int)$facilityId]);
        return $this->db->affected_rows();
    }

     /* ================================
       PACKAGE LIST
    ================================= */
public function get_package_list($facilityId, $search, $status, $limit, $offset)
{
    $agg = "
        (
            SELECT
                PackageId,
                COUNT(*) AS Components,
                SUM(ISNULL(TotalPrice, 0)) AS TotalPrice,
                SUM(ISNULL(TaxValue, 0)) AS TaxValue,
                SUM(ISNULL(AmountExcludingTax, 0)) AS AmountExcludingTax,
                SUM(ISNULL(PackageDiscount, 0)) AS PackageDiscount,
                SUM(ISNULL(NetAmount, 0)) AS NetAmount
            FROM PackageItem
            WHERE IsDeleted = 0
            GROUP BY PackageId
        ) a
    ";

    $this->db->select('
        pm.PackageId,
        pm.PackageCode,
        pm.PackageName,
        pm.Status,
        pm.ValidFrom,
        pm.ValidTo,
        pm.Duration,
        pm.CreatedOn,
        ISNULL(a.Components, 0) AS Components,
        ISNULL(a.TotalPrice, 0) AS TotalPrice,
        ISNULL(a.TaxValue, 0) AS TaxValue,
        ISNULL(a.AmountExcludingTax, 0) AS AmountExcludingTax,
        ISNULL(a.PackageDiscount, 0) AS PackageDiscount,
        ISNULL(a.NetAmount, 0) AS NetAmount
    ', false);

    $this->db->from('PackageMaster pm');
    $this->db->join($agg, 'a.PackageId = pm.PackageId', 'left', false);

    $this->db->where('pm.FacilityId', (int)$facilityId);
    $this->db->where('pm.IsDeleted', 0);

    if (!empty($search)) {
        $this->db->group_start()
            ->like('pm.PackageName', $search)
            ->or_like('pm.PackageCode', $search)
            ->group_end();
    }

    if ($status !== null && $status !== '') {
        $this->db->where('pm.Status', ($status === 'A' || $status == 1) ? 1 : 0);
    }

    $this->db->order_by('pm.PackageId', 'DESC');
    $this->db->limit((int)$limit, (int)$offset);

    return $this->db->get()->result_array();
}


public function update_package_status(int $facilityId, int $packageId, int $status, ?int $userId = null): bool
{
    $this->db->where('PackageId', $packageId);
    $this->db->where('FacilityId', $facilityId);
    $this->db->where('IsDeleted', 0);

    $this->db->update('PackageMaster', [
        'Status'    => $status,
        'UpdatedOn' => date('Y-m-d H:i:s'),
        'UpdatedBy' => $userId
    ]);

    return ($this->db->affected_rows() > 0);
}

public function get_package_details(int $facilityId, int $packageId): array
{
    // 1) master totals (aggregate from PackageItem)
    $sqlMaster = "
        SELECT
            pm.PackageId,
            pm.PackageCode,
            pm.PackageName,
            pm.Status,
            pm.ValidFrom,
            pm.ValidTo,
            pm.Duration,
            pm.CreatedOn,
            ISNULL(a.Components,0) AS Components,
            ISNULL(a.TotalPrice,0) AS TotalPrice,
            ISNULL(a.TaxValue,0) AS TaxValue,
            ISNULL(a.AmountExcludingTax,0) AS AmountExcludingTax,
            ISNULL(a.NetAmount,0) AS NetAmount,
            ISNULL(a.DiscountAmount,0) AS DiscountAmount,
            ISNULL(a.PackageDiscountPct,0) AS PackageDiscountPct
        FROM dbo.PackageMaster pm
        LEFT JOIN (
            SELECT
                PackageId,
                COUNT(*) AS Components,
                SUM(ISNULL(TotalPrice,0)) AS TotalPrice,
                SUM(ISNULL(TaxValue,0)) AS TaxValue,
                SUM(ISNULL(AmountExcludingTax,0)) AS AmountExcludingTax,
                SUM(ISNULL(NetAmount,0)) AS NetAmount,

                SUM(ISNULL(PackageDiscount,0)) AS DiscountAmount,

                CASE
                    WHEN SUM(ISNULL(TotalPrice,0)) = 0 THEN 0
                    ELSE
                        SUM(ISNULL(TotalPrice,0) * ISNULL(PackageDiscount,0) / 100) * 100.0
                        / SUM(ISNULL(TotalPrice,0))
                END AS PackageDiscountPct
            FROM dbo.PackageItem
            WHERE IsDeleted = 0
            GROUP BY PackageId
        ) a ON a.PackageId = pm.PackageId
        WHERE pm.IsDeleted = 0
          AND pm.FacilityId = ?
          AND pm.PackageId  = ?
    ";

    $master = $this->db->query($sqlMaster, [$facilityId, $packageId])->row_array();

    if (!$master) {
        return ['master' => null, 'items' => []];
    }

    // 2) items list (detail)
    $sqlItems = "
        SELECT
            pi.PackageItemId,
            pi.PackageId,
            pi.DepartmentId,
            pi.ItemId,
            pi.UnitPrice,
            pi.Quantity,
            pi.PackageDiscount,
            pi.TaxValue,
            pi.TotalPrice,
            pi.AmountExcludingTax,
            pi.NetAmount,
            sm.Description,
            ISNULL(im.Description, sm.Description) AS ItemName
            
            
        FROM dbo.PackageItem pi
        LEFT JOIN dbo.ItemMaster im ON im.Id = pi.ItemId
        -- if you have service table, join it; else remove next line
        LEFT JOIN dbo.ServiceMaster sm ON sm.Id = pi.ServiceId
        WHERE pi.IsDeleted = 0
          AND pi.PackageId = ?
        ORDER BY pi.PackageItemId ASC
    ";

    $items = $this->db->query($sqlItems, [$packageId])->result_array();

    return [
        'master' => $master,
        'items'  => $items
    ];
}


 public function softDelete($PackageId, $userId)
    {
        if ((int)$PackageId <= 0) {
            return false;
        }

        $this->db->where('PackageId', (int)$PackageId);
        $this->db->where('IsDeleted', 0);

        return $this->db->update('PackageMaster', [
            'IsDeleted' => 1,
            'UpdatedBy' => (int)$userId,
            'UpdatedOn' => date('Y-m-d H:i:s')
        ]);
    }

}
