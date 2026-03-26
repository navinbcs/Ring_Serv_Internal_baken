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
              AND ISNULL(i.IsActive,1) = 1
        ";

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
}
