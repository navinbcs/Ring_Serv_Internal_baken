<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Itemmaster extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model + helpers
        $this->load->model('Itemmaster_model', 'items');
        $this->load->helper(['url', 'security']);
        $this->output->set_content_type('application/json');

        
    }

    /**
     * GET /item-master/search?q=term[&tenantId=][&limit=20][&offset=0]
     * Searches across Code, Description, Generic, BrandName.
     */
public function search()
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
    $q        = $this->input->get('q', TRUE);
    $tenantId = $tokenData->TenantId;
    $limit    = (int) ($this->input->get('limit', TRUE) ?? 20);
    $offset   = (int) ($this->input->get('offset', TRUE) ?? 0);

    // Guard: short search terms return empty
    if ($q !== null && mb_strlen($q) < 2) {
        return $this->output->set_output(json_encode([]));
    }

    $rows = $this->items->search($q, $tenantId, $limit, $offset);

    // Lookup arrays
    $item_types = unserialize(ITEM_TYPES);
    $drug_cat   = unserialize(DRUG_CATEGORIES);

    // If no rows, return empty JSON
    if (empty($rows)) {
        return $this->output->set_output(json_encode([]));
    }

    // Map rows
    $data = array_map(function($r) use ($item_types, $drug_cat) {
        $itemTypeId  = (int) ($r['ItemType'] ?? 0);
        $drugCatId   = (int) ($r['DrugCategory'] ?? 0);
        $billingType = (int) ($r['BillingType'] ?? 0);

        return [
            'id'            => (int) $r['Id'],
            'itemName'      => $r['Description'] ?? '',
            'unitPrice'      => $r['UnitPrice'] ?? '',
            'itemCode'      => $r['Code'] ?? '',
            'brandName'     => $r['BrandName'] ?? '',
            'itemType'      => $item_types[$itemTypeId] ?? '',   // mapped label
            'drugCategory'  => $drugCatId,
            'DrugName'      => $drug_cat[$drugCatId] ?? '',      // mapped label
            'itemClass'     => $r['ItemClass'] ?? '',
            'ItemClassName' => $r['ItemClassName'] ?? '',
            'Generic'       => $r['Generic'] ?? '',
            'BillingType'   => $billingType,
            'BillingName'   => ($billingType === 1 ? 'Billable' : 'Non-Billable'),
        ];
    }, $rows);

    return $this->output->set_output(json_encode($data));
}


        /**
         * GET /item-master/search-by-code?code=PCT[&tenantId=][&limit=20][&offset=0]
         * Autocomplete by code (prefix).
         */
        public function search_by_code()
        {
            $code     = $this->input->get('code', TRUE);
            $tenantId = $this->input->get('tenantId', TRUE);
            $limit    = (int) ($this->input->get('limit', TRUE) ?? 20);
            $offset   = (int) ($this->input->get('offset', TRUE) ?? 0);

            if ($code !== null && mb_strlen($code) < 2) {
                return $this->output->set_output(json_encode([]));
            }

            $rows = $this->items->search_by_code($code, $tenantId, $limit, $offset);

            $data = array_map(function($r) {
                return [
                    'id'           => (int)$r['Id'],
                    'itemName'     => $r['Description'],
                    'itemCode'     => $r['Code'],
                    'brandName'    => $r['BrandName'],
                    'itemType'     => $r['ItemType'],
                    'drugCategory' => $r['DrugCategory'],
                    'itemClass'    => $r['ItemClass'],
                    'billingType'  => $r['BillingType'],
                     'brandName'   => $r['BrandName'],
                    'purchasePrice'=> $r['UnitPrice'] !== null ? (float)$r['UnitPrice'] : null,
                    'salesPrice'   => $r['AmountPerUnit'] !== null ? (float)$r['AmountPerUnit'] : null
                ];
            }, $rows);

            return $this->output->set_output(json_encode($data));
        }

    /**
     * GET /item-master/{id}[?tenantId=]
     */
    public function show($id = null)
    {
        if ($id === null) {
            $this->output->set_status_header(400);
            return $this->output->set_output(json_encode(['error' => 'Missing id']));
        }
        $tenantId = $this->input->get('tenantId', TRUE);

        $row = $this->items->get_by_id($id, $tenantId);
        if (!$row) {
            $this->output->set_status_header(404);
            return $this->output->set_output(json_encode(['error' => 'Not found']));
        }

        $data = [
            'id'           => (int)$row['Id'],
            'itemName'     => $row['Description'],
            'itemCode'     => $row['Code'],
            'brandName'    => $row['BrandName'],
            'itemType'     => $row['ItemType'],
            'drugCategory' => $row['DrugCategory'],
            'itemClass'    => $row['ItemClass'],
            'billingType'  => $row['BillingType'],
            'purchasePrice'=> $row['UnitPrice'] !== null ? (float)$row['UnitPrice'] : null,
            'salesPrice'   => $row['AmountPerUnit'] !== null ? (float)$row['AmountPerUnit'] : null,
            'isActive'     => (int)$row['IsActive'] === 1,
            'tenantId'     => $row['TenantId'],
        ];

        return $this->output->set_output(json_encode($data));
    }
}
