<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Itemmaster_model extends CI_Model
{
    // Use schema-qualified table alias; DB name comes from database.php
    private $table = 'dbo.ItemMaster im';

    // Keep only columns you need on the wire
    private $select_cols = [
        'im.Id',
        'im.Code',
        'im.Description',
        'im.UnitPrice',
        'im.AmountPerUnit',
        'im.ItemType',
        'im.Generic',
        'im.BrandName',
        'im.DrugCategory',
        'im.ItemClass',
        'im.BrandName',
         'im.BillingType',
        // joined ItemClass fields (handy for FE)
        'icm.ID AS ItemClassId',
        'icm.Code AS ItemClassCode',
        'icm.Description AS ItemClassName',
         'dm.Description AS DrugName',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    private function base_query()
    {
        // IMPORTANT: pass $escape = false to avoid CI adding double-quotes
        $this->db->from($this->table, false);

        $this->db->select(implode(',', $this->select_cols), false);

        // Join ItemClassMaster — default: ItemMaster.ItemClass stores the CLASS CODE
        $this->db->join('dbo.ItemClassMaster icm', 'icm.id = im.ItemClass', 'left', false);
        $this->db->join('dbo.DrugMaster dm', 'dm.id = im.DrugCategory', 'left', false);
        // If your ItemMaster.ItemClass actually stores the CLASS ID, use this instead:
        // $this->db->join('dbo.ItemClassMaster icm', 'icm.ID = im.ItemClass', 'left', false);

        // Only active items by default
        $this->db->where('im.IsActive', 1);
    }

    /**
     * Search by free text across Code, Description, Generic, BrandName
     */
    public function search($term, $tenantId = null, $limit = 20, $offset = 0)
    {
        $this->base_query();

        if ($tenantId !== null && $tenantId !== '') {
            $this->db->where('im.TenantId', $tenantId);
        }

        if ($term !== null && $term !== '') {
            $this->db->group_start()
                ->like('im.Code', $term)
                ->or_like('im.Description', $term)
                ->or_like('im.Generic', $term)
                ->or_like('im.BrandName', $term)
            ->group_end();
        }

        $this->db->order_by('im.Description', 'ASC', false);
        $this->db->limit((int)$limit, (int)$offset);

        return $this->db->get()->result_array();
    }

    /**
     * Search primarily by Code (prefix match)
     */
    public function search_by_code($code, $tenantId = null, $limit = 20, $offset = 0)
    {
        $this->base_query();

        if ($tenantId !== null && $tenantId !== '') {
            $this->db->where('im.TenantId', $tenantId);
        }

        if ($code !== null && $code !== '') {
            $this->db->like('im.Code', $code, 'after'); // starts with
        }

        $this->db->order_by('im.Code', 'ASC', false);
        $this->db->limit((int)$limit, (int)$offset);

        return $this->db->get()->result_array();
    }

    public function get_by_id($id, $tenantId = null)
    {
        $this->base_query();
        $this->db->where('im.Id', (int)$id);

        if ($tenantId !== null && $tenantId !== '') {
            $this->db->where('im.TenantId', $tenantId);
        }

        return $this->db->get()->row_array();
    }
}
