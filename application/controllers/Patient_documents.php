<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_documents extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Document_model', 'docs');
    }

    // GET /api/patient/{patientId}/visits
    public function visits($id)
    {
          if($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
          
         $visitIDArray = $this->docs->get_patientId_by_Id($id); 
         $PatientId = $visitIDArray[0]["PatientId"]; 
         $EnrollmentDate = $visitIDArray[0]["EnrollmentDate"];
        // flat rows from DB
         $rows = $this->docs->get_docs_by_enrollment_patient($PatientId,$EnrollmentDate);
        

        // build nested: patient -> visits[] -> forms[]
        $out = [
            'status'     => true,
            'patientId'  => $PatientId,
            'patientName'=> null,   // will fill if we see it in data
            'visits'     => []
        ];

        $byVisit = [];

      //  print_r($rows ); exit ;
        foreach ($rows as $r) {
            $vid = (string)$r['VisitId'];

            if (!isset($byVisit[$vid])) {
                $byVisit[$vid] = [
                    'visitId'    => $vid,
                    'visitDate'  => $r['VisitDate'],
                    'forms'      => []
                ];
            }

            // first non-empty patientName we find
            if (!$out['patientName'] && !empty($r['PatientName'])) {
                $out['patientName'] = $r['PatientName'];
            }

            $byVisit[$vid]['forms'][] = [
                'docId'          => (int)$r['DocId'],
                'templateId'     => (int)$r['TemplateId'],
                'templateName'   => $r['TemplateName'],
                'displayName'    => $r['DisplayName'],
                'DoctorName'    => $r['DoctorName'],
                'isSubmitted'    => isset($r['IsSubmitted']) ? (bool)$r['IsSubmitted'] : null,
                'createdDate'    => $r['CreatedDate'],
                'AddedOn'    => $r['AddedOn'],
                
                'imageFileName'  => $r['ImageFileName'],
            ];
        }

        // sort visits newest first (optional)
        usort($byVisit, function($a, $b) {
            return strcmp((string)$b['visitDate'], (string)$a['visitDate']);
        });

        $out['visits'] = array_values($byVisit);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($out));
    }
}
