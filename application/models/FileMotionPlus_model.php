<?php
// application/models/FileMotionPlus_model.php
defined('BASEPATH') or exit('No direct script access allowed');

class FileMotionPlus_model extends CI_Model
{
    protected $table = 'FileMotionPlus';
    protected $pk    = 'Id';
    protected $docTable = 'document';
     protected $docTemplateFk  = 'templateMaster_Id';  // <-- change to the actual column
    protected $docVisitFk     = 'VisitId'; 
    public function get_all($limit = 1000, $offset = 0)
    {
        return $this->db
            ->order_by($this->pk, 'DESC')
            ->get($this->table, $limit, $offset)
            ->result_array();
    }
    public function get_by_visit($visitId)
    {
        // Get EncounterNo for the given visit
        $obj = $this->db->select("EncounterNo")
            ->from("Enrollment")
            ->where("id", $visitId)
            ->get()
            ->row();

        $sql = "
            SELECT 
            fp.id  as fileId,
                tm.id AS TemplateId,
                COALESCE(NULLIF(tm.DisplayName, ''), tm.TemplateName) AS TemplateName,
                tm.TemplateName as TName,
                fp.VisitId,
                CASE 
                    WHEN d.id IS NOT NULL THEN 'No' 
                    ELSE 'Yes' 
                END AS [Action],
                CASE 
                    WHEN d.id IS NOT NULL THEN d.id 
                    ELSE NULL 
                END AS DocId
            FROM {$this->table} fp
            JOIN TemplateMaster tm ON tm.id = fp.TemplateId
            LEFT JOIN {$this->docTable} d 
                ON d.{$this->docVisitFk} = fp.VisitId
                AND d.{$this->docTemplateFk} = tm.id
            WHERE fp.VisitId = ?
            ORDER BY tm.TemplateName ASC
        ";

        return $this->db->query($sql, $obj->EncounterNo)->result_array();
    }

    
    public function get($id)
    {
        return $this->db->get_where($this->table, [$this->pk => (int)$id])->row_array();
    }

    public function insert($data)
    {
         $obj =   $this->db->select("EncounterNo")->from("Enrollment")->where("id",$data['VisitId'])->get()->row();
         $data['VisitId'] = $obj->EncounterNo ;
      
        $data['CreationDate'] = isset($data['CreationDate']) && $data['CreationDate'] ? $data['CreationDate'] : date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['UpdateDate'] = isset($data['UpdateDate']) && $data['UpdateDate'] ? $data['UpdateDate'] : date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, [$this->pk => (int)$id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, [$this->pk => (int)$id]);
    }

    

public function get_template_list($id)
{
    
    $sql = "
        SELECT tm.* , e.TenantId
        FROM Enrollment      AS e
        JOIN FormsTenant     AS ft ON ft.TenantId   = e.TenantId
        JOIN TemplateMaster  AS tm ON tm.CompanyName = ft.CompanyName
        WHERE e.Id = ?
        ORDER BY tm.DisplayName ASC
    ";

    return $this->db->query($sql, [$id])->result_array();
}

}
