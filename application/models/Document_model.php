<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model
{
    private $docTable = 'Document';
    private $tplTable = 'TemplateMaster';
    private $enrolmentTable = 'Enrollment';

    public function get_patientId_by_Id($visitId){

       return $this->db->select("PatientId,EnrollmentDate")->from($this->enrolmentTable)->where("id",$visitId)->get()->result_array();
    }
    
    public function get_patientId_by_visitId($visitId){

       return $this->db->select("PatientId")->from($this->enrolmentTable)->where("EncounterNo",$visitId)->get()->result_array();
    }





    public function get_patient_visit_forms(string $patientId): array
    {
        $sql = "
            SELECT
                d.id                                   AS DocId,
                COALESCE(CONVERT(varchar(50), d.patientId), CONVERT(varchar(50), d.patient_Id)) AS PatientId,
                d.patientName                          AS PatientName,
                d.visitId                               AS VisitId,
                d.visitDate                             AS VisitDate,
                d.createdDate                           AS CreatedDate,
                d.isSubmitted                           AS IsSubmitted,
                d.imageFileName                         AS ImageFileName,
                d.templateMaster_Id                     AS TemplateId,
                tm.CompanyName                          AS CompanyName,
                tm.TemplateName                         AS TemplateName,
                CONCAT(U.DisplayName,' ',U.LastName) AS DisplayName,
                tm.actionName                           AS ActionName
            FROM Document d
            JOIN TemplateMaster tm ON tm.id = d.templateMaster_Id
            WHERE COALESCE(CONVERT(varchar(50), d.patientId), CONVERT(varchar(50), d.patient_Id)) = ?
            ORDER BY 
                COALESCE(d.visitDate, CONVERT(datetime,'1900-01-01')) DESC,
                d.createdDate DESC,
                d.id DESC
        ";
        return  $this->db->query($sql, [$patientId])->result_array();  //echo $this->db->last_query(); exit;
    }


public function get_docs_by_enrollment_patient($patientId,$EnrollmentDate)
{
    // $patientId can be INT (e.g., 61993) or VARCHAR if your Enrollment.PatientId is varchar.
    // We match Document.patientId to Enrollment.PRN (your working query),
    // and return enriched fields for UI use.
     $sql = "
        SELECT
            d.id                         AS DocId,
            d.patientId                  AS PatientId,           -- as stored in Document (varchar PRN)
            d.visitId                    AS VisitId,
            d.visitDate                  AS VisitDate,
            d.createdDate                AS CreatedDate,
            d.isSubmitted                AS IsSubmitted,
            d.imageFileName              AS ImageFileName,
            d.templateMaster_Id          AS TemplateId,
          
            tm.TemplateName,
            COALESCE(NULLIF(tm.DisplayName, ''), tm.TemplateName) AS DisplayName,
            CAST(NULLIF(LTRIM(RTRIM(ISNULL(u.DisplayName,'') + ' ' + ISNULL(u.LastName,''))), '') AS NVARCHAR(302)) 
                                                         AS DoctorName,
            tm.CompanyName,

            e.PatientId                  AS EnrollPatientId,     -- Enrollment side (numeric/string id)
            e.PRN                        AS PRN,                 -- the PRN you matched on
            e.EncounterNo   ,                                  -- if you need visit link from Enrollment
            d.createdDate             AS AddedOn
        FROM Document d
        JOIN Enrollment e
          ON d.patientId = e.PRN
        LEFT JOIN TemplateMaster tm
          ON tm.id = d.templateMaster_Id
        LEFT JOIN users u on u.linkuserid = e.PrimaryPractitionerId
        WHERE e.PatientId = ?
        and e.EnrollmentDate= ?
        ORDER BY
            COALESCE(d.visitDate, CONVERT(datetime,'1900-01-01')) DESC,
            d.createdDate DESC,
            d.id DESC
    "; 

     return $this->db->query($sql, [$patientId,$EnrollmentDate])->result_array();

  //   echo $this->db->last_query(); exit;
}

}
