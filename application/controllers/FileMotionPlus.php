<?php
// application/controllers/FileMotionPlus.php
defined('BASEPATH') or exit('No direct script access allowed');

class FileMotionPlus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load essentials
        $this->load->model('FileMotionPlus_model', 'fp');
        $this->load->model('Document_model', 'docs');
        $this->load->library('form_validation');
        $this->output->set_content_type('application/json');
    }

    private function json($ok, $data = null, $message = '')
    {
        $this->output->set_output(json_encode([
            'status'  => (bool)$ok,
            'message' => $message,
            'data'    => $data
        ]));
    }

    // GET /api/filemotionplus
    public function index()
    {
        $items = $this->fp->get_all();
        return $this->json(true, $items);
    }

    // GET /api/filemotionplus/{id}
    public function get($id = null)
    {
        if (!$id) return $this->json(false, null, 'Id is required');
        $row = $this->fp->get($id);
        if (!$row) return $this->json(false, null, 'Record not found');
        return $this->json(true, $row);
    }

    // POST /api/filemotionplus
    public function save()
    {

          if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        // support JSON body
        $payload = json_decode($this->input->raw_input_stream, true);
        if (empty($payload)) $payload = $this->input->post(null, true);

        $this->form_validation->set_data($payload);
        $this->form_validation->set_rules('VisitId', 'VisitId', 'required|integer');
        $this->form_validation->set_rules('PatientId', 'PatientId', 'required|integer');   // must be present
        $this->form_validation->set_rules('EnrollmentId', 'EnrollmentId', 'integer');     // nullable
        $this->form_validation->set_rules('TemplateId', 'TemplateId', 'required|integer');

        if ($this->form_validation->run() === false) {
            return $this->json(false, null, validation_errors("\n"));
        }

        $data = [
            'VisitId'      => (int)$payload['VisitId'],
            'PatientId'    => (int)$payload['PatientId'],
            'EnrollmentId' => isset($payload['EnrollmentId']) && $payload['EnrollmentId'] !== '' ? (int)$payload['EnrollmentId'] : null,
            'TemplateId'   => (int)$payload['TemplateId'],
            // CreationDate auto-filled in model if omitted
        ];
        $oldDebug = $this->db->db_debug;
        $this->db->db_debug = false;
        $this->db->trans_start();
        $id = $this->fp->insert($data);
        $err = $this->db->error();
        if (!empty($id)) {
            $this->db->trans_complete();
        return $this->json(true, ['Id' => $id], 'Created');
        }
        else 
        {
            $this->db->trans_complete();
            return $this->json(false, ['db_error' => $err], 'This template has already been added for this visit');
        }
              

    }

    // PUT /api/filemotionplus/{id}
    public function update($id = null)
    {
        if (!$id) return $this->json(false, null, 'Id is required');

        // Allow method override via POST (_method=PUT) if needed
        if ($this->input->post('_method') === 'PUT') {
            $payload = $this->input->post(null, true);
        } else {
            $payload = json_decode($this->input->raw_input_stream, true);
        }

        if (empty($payload)) return $this->json(false, null, 'No payload');

        $this->form_validation->set_data($payload);
        $this->form_validation->set_rules('VisitId', 'VisitId', 'required|integer');
        $this->form_validation->set_rules('PatientId', 'PatientId', 'required|integer');
        $this->form_validation->set_rules('EnrollmentId', 'EnrollmentId', 'integer');
        $this->form_validation->set_rules('TemplateId', 'TemplateId', 'required|integer');

        if ($this->form_validation->run() === false) {
            return $this->json(false, null, validation_errors("\n"));
        }

        $data = [
            'VisitId'      => (int)$payload['VisitId'],
            'PatientId'    => (int)$payload['PatientId'],
            'EnrollmentId' => isset($payload['EnrollmentId']) && $payload['EnrollmentId'] !== '' ? (int)$payload['EnrollmentId'] : null,
            'TemplateId'   => (int)$payload['TemplateId'],
            // UpdateDate auto-filled in model if omitted
        ];

        $ok = $this->fp->update($id, $data);
        return $this->json($ok, ['Id' => (int)$id], $ok ? 'Updated' : 'Update failed');
    }

    // DELETE /api/filemotionplus/{id}
    public function delete($id = null)
    {

        if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
        if (!$id) return $this->json(false, null, 'Id is required');
        $ok = $this->fp->delete($id);
        return $this->json($ok, null, $ok ? 'Deleted' : 'Delete failed');
    }


    // application/controllers/FileMotionPlus.php

public function by_visit($visitId = null)
{

     if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $data["status"] = "ok";
            echo json_encode($data);
            exit;
        }
    if (!$visitId) return $this->json(false, null, 'VisitId is required');
    $rows = $this->fp->get_by_visit($visitId);
    return $this->json(!empty($rows), $rows, empty($rows) ? 'No records' : '');
}

public function templates_by_visit_with_action($visitId = null)
{
    if (!$visitId) return $this->json(false, null, 'VisitId is required');
    $rows = $this->fp->get_distinct_templates_by_visit_with_action($visitId);
    return $this->json(true, $rows);
}

public function get_templates($visitId = null)
{

   // echo $_GET["id"] ; exit ;
    
    $rows = $this->fp->get_template_list($_GET["id"]);
    return $this->json(true, $rows);
}

}
