<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Analytics_model extends CI_Model
{
    /**
     * Age/Gender distribution from PatientMaster + Enrollment
     *
     * @param array $filters [
     *   'tenant_id'       => (int|null),     // match on Enrollment.TenantId (or PatientMaster.TenantId if you prefer)
     *   'from_date'       => 'YYYY-MM-DD',   // filter by AdmissionDate >= from_date
     *   'to_date'         => 'YYYY-MM-DD',   // filter by AdmissionDate <= to_date
     *   'active_only'     => bool,           // default true -> Enrollment.IsActive = 1
     * ]
     * @return array[] e.g. [
     *   ['category'=>'0-17', 'Male'=>75, 'Female'=>66],
     *   ...
     * ]
     */
    public function get_age_gender_distribution(array $filters = [])
    {
        $activeOnly = array_key_exists('active_only', $filters) ? (bool)$filters['active_only'] : true;
 
        // Base SQL with bindable WHERE fragments
        $sql = "
            SELECT
                CASE
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 0  AND 17 THEN '0-17'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 18 AND 24 THEN '18-24'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 25 AND 34 THEN '25-34'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 35 AND 44 THEN '35-44'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 45 AND 54 THEN '45-54'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 55 AND 64 THEN '55-64'
                    ELSE '65+'
                END AS category,
                SUM(CASE WHEN p.GenderId = 1 THEN 1 ELSE 0 END) AS Male,      -- 1 = Male
                SUM(CASE WHEN p.GenderId = 2 THEN 1 ELSE 0 END) AS Female     -- 2 = Female
            FROM PatientMaster p
            INNER JOIN Enrollment e ON e.PatientId = p.PatientId
            WHERE 1 = 1
        ";
 
        $binds = [];
 
        if ($activeOnly) {
            $sql .= " AND e.IsActive = 1";
        }
 
        // Optional tenant filter (choose e.TenantId or p.TenantId as per your design)
        if (!empty($filters['tenant_id'])) {
            $sql .= " AND e.TenantId = ?";
            $binds[] = (int)$filters['tenant_id'];
        }
 
        // Optional EnrollmentDate window
        if (!empty($filters['from_date'])) {
            $sql .= " AND CAST(e.EnrollmentDate AS DATE) >= ?";
            $binds[] = $filters['from_date'];
        }
        if (!empty($filters['to_date'])) {
            $sql .= " AND CAST(e.EnrollmentDate AS DATE) <= ?";
            $binds[] = $filters['to_date'];
        }
 
        $sql .= "
            GROUP BY
                CASE
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 0  AND 17 THEN '0-17'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 18 AND 24 THEN '18-24'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 25 AND 34 THEN '25-34'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 35 AND 44 THEN '35-44'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 45 AND 54 THEN '45-54'
                    WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 55 AND 64 THEN '55-64'
                    ELSE '65+'
                END
        ";
 
        // Run
        $query = $this->db->query($sql, $binds);
        $rows  = $query->result_array();
      //  echo $this->db->last_query(); exit ;
 
        // Ensure all buckets exist (even if zero) & keep a consistent order
        $buckets = ['0-17','18-24','25-34','35-44','45-54','55-64','65+'];
        $out = array_fill_keys($buckets, ['Male' => 0, 'Female' => 0]);
 
        foreach ($rows as $r) {
            $cat = $r['category'];
            if (isset($out[$cat])) {
                $out[$cat]['Male']   = (int)$r['Male'];
                $out[$cat]['Female'] = (int)$r['Female'];
            }
        }
 
        // Convert to array of rows like [{category, Male, Female}, ...]
        $final = [];
        foreach ($buckets as $cat) {
            $final[] = [
                'category' => $cat,
                'Male'     => $out[$cat]['Male'],
                'Female'   => $out[$cat]['Female'],
            ];
        }
 
        return $final;
    }
}