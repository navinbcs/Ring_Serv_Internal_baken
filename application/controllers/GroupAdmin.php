<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Group Admin API Controller
 * 
 * Provides Group Admin related endpoints:
 * - Get Group Admin users
 * - Get appointments for Group Admin users
 * - Get weekly appointment statistics
 * - Get appointment status summaries
 */
class GroupAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Handle OPTIONS preflight request (CORS headers are in web.config)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
        
        header('Content-Type: application/json');
        $this->load->database();
        $this->load->model('GroupAdmin_Model');
    }

    /**
     * GET/POST /groupadmin/users
     * Get all Group Admin users
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters (optional):
     * - ringGroupId - Filter by Ring Group ID
     * - tenantId - Filter by Tenant ID
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "users": [...]
     *   }
     * }
     */
    public function users()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $ringGroupId = $this->input->get('ringGroupId') ?? $this->input->post('ringGroupId') ?? null;
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;

            $users = $this->GroupAdmin_Model->getGroupAdminUsers($ringGroupId, $tenantId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'users' => $users,
                    'count' => count($users)
                ]
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::users error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/appointments/weekly
     * Get total appointments for this week for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - tenantId (optional) - Filter by specific facility/tenant
     * - startDate (optional) - Start date for date range filter (format: YYYY-MM-DD)
     * - endDate (optional) - End date for date range filter (format: YYYY-MM-DD)
     * 
     * Note: User ID is extracted from JWT token, no need to pass userId parameter
     * If startDate/endDate not provided, defaults to current week (Monday to Sunday)
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "totalAppointments": 150,
     *     "weekStart": "2026-01-27",
     *     "weekEnd": "2026-02-02",
     *     "userId": 3527
     *   }
     * }
     */
    public function appointments_weekly()
    {
        try {
            // Handle OPTIONS request for CORS (same as PackageMasterApi)
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header (same as PackageMasterApi)
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token (same as PackageMasterApi)
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get tenantId from query parameter (optional)
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;

            // Get doctorId from query parameter (optional)
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            $result = $this->GroupAdmin_Model->getWeeklyAppointments($userId, $tenantId, $doctorId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::appointments_weekly error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/appointments/daily
     * Get daily appointment counts for the last 7 days (for trend charts)
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters (optional):
     * - tenantId - Filter by specific tenant/facility
     * - days - Number of days to retrieve (default: 7)
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": [
     *     { "date": "2025-01-25", "count": 45 },
     *     { "date": "2025-01-26", "count": 52 },
     *     ...
     *   ]
     * }
     */
    public function appointments_daily()
    {
        try {
            // Extract JWT token from Authorization header (same as PackageMasterApi)
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token (same as PackageMasterApi)
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get tenantId from query parameter (optional)
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;

            // Get doctorId from query parameter (optional)
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            // Get days parameter (optional, default: 7)
            $days = $this->input->get('days') ?? $this->input->post('days') ?? 7;
            $days = (int)$days;
            if ($days < 1 || $days > 30) {
                $days = 7; // Limit to 1-30 days, default to 7
            }

            $result = $this->GroupAdmin_Model->getDailyAppointmentHistory($userId, $tenantId, $days, $doctorId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::appointments_daily error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/appointments/status
     * Get appointment status summary for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - tenantId (optional) - Filter by specific facility/tenant
     * - startDate (optional) - Start date for date range filter (format: YYYY-MM-DD)
     * - endDate (optional) - End date for date range filter (format: YYYY-MM-DD)
     * 
     * Note: User ID is extracted from JWT token, no need to pass userId parameter
     * If startDate/endDate not provided, defaults to current week (Monday to Sunday)
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "totalAppointments": 150,
     *     "totalRegistered": 120,
     *     "totalCancelled": 20,
     *     "totalNoShow": 10,
     *     "startDate": "2026-01-27",
     *     "endDate": "2026-02-02",
     *     "userId": 3527
     *   }
     * }
     */
    public function appointments_status()
    {
        try {
            // Handle OPTIONS request for CORS (same as PackageMasterApi)
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header (same as PackageMasterApi)
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token (same as PackageMasterApi)
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get tenantId from query parameter (optional)
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;

            // Get doctorId from query parameter (optional)
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            // Get date range from query parameters (optional)
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;

            $result = $this->GroupAdmin_Model->getAppointmentStatusSummary($userId, $tenantId, $startDate, $endDate, $doctorId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::appointments_status error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/appointments/detailed
     * Get detailed appointments list for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - userId (required) - Group Admin User ID
     * - startDate (optional) - Start date (default: Monday of this week)
     * - endDate (optional) - End date (default: Sunday of this week)
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "appointments": [...],
     *     "count": 150
     *   }
     * }
     */
    public function appointments_detailed()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $userId = $this->input->get('userId') ?? $this->input->post('userId') ?? null;
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID parameter required'], 400);
            }

            // Convert tenantId to int if provided, otherwise null
            $tenantId = $tenantId !== null ? (int)$tenantId : null;

            $appointments = $this->GroupAdmin_Model->getDetailedAppointments($userId, $startDate, $endDate, $tenantId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'appointments' => $appointments,
                    'count' => count($appointments)
                ]
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::appointments_detailed error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/check
     * Check if a user is a Group Admin
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - userId (required) - User ID to check
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "userId": 3527,
     *     "isGroupAdmin": true
     *   }
     * }
     */
    public function check()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $userId = $this->input->get('userId') ?? $this->input->post('userId') ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID parameter required'], 400);
            }

            $isGroupAdmin = $this->GroupAdmin_Model->isGroupAdmin($userId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'userId' => $userId,
                    'isGroupAdmin' => $isGroupAdmin
                ]
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::check error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/visits/statistics
     * Get visit statistics (Total Visits, New Patient Visits, Repeat Patient Visits)
     * for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - userId (required) - Group Admin User ID
     * - startDate (optional) - Start date (default: Monday of this week)
     * - endDate (optional) - End date (default: Sunday of this week)
     * - tenantId (optional) - Filter by specific tenant
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "totalVisits": 150,
     *     "newPatientVisits": 45,
     *     "repeatPatientVisits": 105,
     *     "totalUniquePatients": 120,
     *     "totalNewPatients": 45,
     *     "totalRepeatPatients": 75,
     *     "startDate": "2026-01-27",
     *     "endDate": "2026-02-02",
     *     "userId": 3527,
     *     "numberOfTenants": 3
     *   }
     * }
     */
    public function visits_statistics()
    {
        try {
            // Handle OPTIONS request for CORS (same as PackageMasterApi)
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header (same as PackageMasterApi)
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token (same as PackageMasterApi)
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get date range and tenantId from query parameters (optional)
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;

            $result = $this->GroupAdmin_Model->getVisitStatistics($userId, $startDate, $endDate, $tenantId);
            
            // Add debug info to response
            $result['debug'] = [
                'userId' => $userId,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'tenantId' => $tenantId
            ];

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::visits_statistics error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/visits/statistics/by-tenant
     * Get visit statistics grouped by tenant for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - userId (required) - Group Admin User ID
     * - startDate (optional) - Start date (default: Monday of this week)
     * - endDate (optional) - End date (default: Sunday of this week)
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "statistics": [
     *       {
     *         "TenantId": 1,
     *         "TenantName": "Main Hospital",
     *         "TotalVisits": 80,
     *         "NewPatientVisits": 25,
     *         "RepeatPatientVisits": 55,
     *         "TotalUniquePatients": 60,
     *         "TotalNewPatients": 25,
     *         "TotalRepeatPatients": 35
     *       },
     *       ...
     *     ],
     *     "count": 3
     *   }
     * }
     */
    public function visits_statistics_by_tenant()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $userId = $this->input->get('userId') ?? $this->input->post('userId') ?? null;
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID parameter required'], 400);
            }

            $statistics = $this->GroupAdmin_Model->getVisitStatisticsByTenant($userId, $startDate, $endDate);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'statistics' => $statistics,
                    'count' => count($statistics)
                ]
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::visits_statistics_by_tenant error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/patients/demographics
     * Get patient demographics overview (Gender Distribution and Age Group Distribution)
     * for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - userId (required) - Group Admin User ID
     * - startDate (optional) - Start date (filter patients who visited in this period)
     * - endDate (optional) - End date (filter patients who visited in this period)
     * - tenantId (optional) - Filter by specific tenant
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "genderDistribution": [
     *       {
     *         "GenderId": 1,
     *         "GenderName": "Male",
     *         "PatientCount": 120,
     *         "Percentage": 60.00
     *       },
     *       {
     *         "GenderId": 2,
     *         "GenderName": "Female",
     *         "PatientCount": 80,
     *         "Percentage": 40.00
     *       }
     *     ],
     *     "ageGroupDistribution": [
     *       {
     *         "AgeGroup": "0-18",
     *         "PatientCount": 30,
     *         "Percentage": 15.00
     *       },
     *       {
     *         "AgeGroup": "19-30",
     *         "PatientCount": 50,
     *         "Percentage": 25.00
     *       },
     *       {
     *         "AgeGroup": "31-50",
     *         "PatientCount": 60,
     *         "Percentage": 30.00
     *       },
     *       {
     *         "AgeGroup": "51-65",
     *         "PatientCount": 40,
     *         "Percentage": 20.00
     *       },
     *       {
     *         "AgeGroup": "65+",
     *         "PatientCount": 20,
     *         "Percentage": 10.00
     *       }
     *     ],
     *     "totalPatients": 200,
     *     "startDate": null,
     *     "endDate": null,
     *     "userId": 3527,
     *     "numberOfTenants": 3
     *   }
     * }
     */
    public function patients_demographics()
    {
        try {
            // Handle OPTIONS request for CORS (same as PackageMasterApi)
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header (same as PackageMasterApi)
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token (same as PackageMasterApi)
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get date range and tenantId from query parameters (optional)
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;
            
            // Get doctorId from query parameter (optional)
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            $result = $this->GroupAdmin_Model->getPatientDemographics($userId, $startDate, $endDate, $tenantId, $doctorId);
            
            // Add debug info to response
            $result['debug'] = [
                'userId' => $userId,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'tenantId' => $tenantId
            ];

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::patients_demographics error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/hospitals
     * Get total hospitals (tenants) for a Group Admin user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - userId (required) - Group Admin User ID
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "totalHospitals": 5,
     *     "activeHospitals": 4,
     *     "inactiveHospitals": 1,
     *     "userId": 3857,
     *     "hospitals": [
     *       {
     *         "TenantId": 1,
     *         "TenantName": "Main Hospital",
     *         "TenantCode": "MH001",
     *         "IsActive": 1,
     *         "RingGroupId": 1,
     *         "RingGroupName": "Group A"
     *       },
     *       ...
     *     ]
     *   }
     * }
     */
    public function hospitals()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $userId = $this->input->get('userId') ?? $this->input->post('userId') ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID parameter required'], 400);
            }

            $result = $this->GroupAdmin_Model->getTotalHospitals($userId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::hospitals error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/locations
     * Get user locations (tenants) - Similar to LocationSelector
     * Returns locations from UserTenants table directly
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Note: User ID is extracted from JWT token, no need to pass userId parameter
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "totalLocations": 5,
     *     "activeLocations": 4,
     *     "inactiveLocations": 1,
     *     "userId": 3857,
     *     "locations": [...]
     *   }
     * }
     */
    public function locations()
    {
        try {
            // Handle OPTIONS request for CORS (same as PackageMasterApi)
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header (same as PackageMasterApi)
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token (same as PackageMasterApi)
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            // PackageMasterApi uses: $tokenData->UserId (line 313) or $tokenData->id (line 115, 390)
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Log the request for debugging
            error_log("GroupAdmin::locations - UserId from JWT token: $userId");

            $result = $this->GroupAdmin_Model->getUserLocations($userId);

            // Log the result for debugging
            error_log("GroupAdmin::locations - UserId: $userId, Total Locations: " . ($result['totalLocations'] ?? 0));
            if (isset($result['locations']) && is_array($result['locations'])) {
                error_log("GroupAdmin::locations - Locations count: " . count($result['locations']));
                foreach ($result['locations'] as $idx => $loc) {
                    error_log("GroupAdmin::locations - Location $idx: TenantId=" . ($loc['TenantId'] ?? 'N/A') . ", TenantName=" . ($loc['TenantName'] ?? 'N/A'));
                }
            }

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $result
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::locations error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/slots
     * Get Utilised Slots Comparison data (current period vs previous period)
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - startDate (optional) - Current period start date (YYYY-MM-DD), defaults to Monday of this week
     * - endDate (optional) - Current period end date (YYYY-MM-DD), defaults to Sunday of this week
     * - periodType (optional, default: 'WEEK') - 'WEEK', 'MONTH', 'YEAR', 'CUSTOM'
     * - tenantId (optional) - Filter by facility
     * - doctorId (optional) - Filter by doctor
     * 
     * Note: User ID is extracted from JWT token, no need to pass userId parameter
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "availableFuture": 95,
     *     "totalSlots": 520,
     *     "utilised": 380,
     *     "utilisedPrev": 365,
     *     "utilisationRate": 73.1,
     *     "utilisationRatePrev": 70.2,
     *     "currentStartDate": "2026-02-02",
     *     "currentEndDate": "2026-02-08",
     *     "previousStartDate": "2026-01-26",
     *     "previousEndDate": "2026-02-01"
     *   }
     * }
     */
    public function slots()
    {
        try {
            // Handle OPTIONS request for CORS
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get optional parameters
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;
            $periodType = $this->input->get('periodType') ?? $this->input->post('periodType') ?? 'WEEK';
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;
            
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            // Normalize dates
            if ($startDate) {
                $startDate = date('Y-m-d', strtotime($startDate));
            }
            if ($endDate) {
                $endDate = date('Y-m-d', strtotime($endDate));
            }
            
            // Calculate date range if not provided (default to this week)
            if (!$startDate || !$endDate) {
                $today = date('Y-m-d');
                $dayOfWeek = date('w', strtotime($today));
                
                if ($dayOfWeek == 0) {
                    $startDate = date('Y-m-d', strtotime($today . ' -6 days'));
                } else {
                    $startDate = date('Y-m-d', strtotime($today . ' -' . ($dayOfWeek - 1) . ' days'));
                }
                
                $endDate = date('Y-m-d', strtotime($startDate . ' +6 days'));
            }

            // Get tenant IDs
            if ($tenantId !== null) {
                $tenantIds = [$tenantId];
            } else {
                $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($userId);
            }
            
            if (empty($tenantIds)) {
                return $this->json([
                    'ok' => false,
                    'message' => 'No tenants found for this user'
                ], 400);
            }
            
            // Use first tenant ID if multiple tenants (or use provided tenantId)
            $responseTenantId = $tenantId ?? $tenantIds[0];
            
            // Calculate capacity with daily breakdown
            $capacity = $this->GroupAdmin_Model->calculateSlotCapacityWithDailyBreakup($startDate, $endDate, $tenantIds, $doctorId);

        //    print_r("Calculated capacity: " . json_encode($capacity)); exit ;

            // Return in the requested format
            return $this->json([
                'ok' => true,
                'tenantId' => $responseTenantId,
                'fromDate' => $startDate,
                'toDate' => $endDate,
                'capacity' => $capacity
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::slots error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/doctors
     * Get doctors/practitioners by tenant/facility
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - tenantId (required) - Tenant/Facility ID
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": [
     *     {
     *       "Id": 81,
     *       "PractitionerName": "Dr. John Doe"
     *     },
     *     {
     *       "Id": 82,
     *       "PractitionerName": "Dr. Jane Smith"
     *     }
     *   ]
     * }
     */
    public function doctors()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;

            if (!$tenantId) {
                return $this->json(['status' => 0, 'message' => 'Tenant ID parameter required'], 400);
            }

            $doctors = $this->GroupAdmin_Model->getDoctorsByTenant($tenantId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $doctors
            ]);

        } catch (Exception $e) {
            error_log("GroupAdmin::doctors error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/reports/appointment-metrics
     * Export Appointment Metrics Report (Excel, CSV, or PDF)
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - format (required) - Export format: 'excel', 'csv', or 'pdf'
     * - startDate (optional) - Start date (YYYY-MM-DD)
     * - endDate (optional) - End date (YYYY-MM-DD)
     * - tenantId (optional) - Filter by facility
     * - doctorId (optional) - Filter by doctor
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "downloadUrl": "http://example.com/reports/appointment_metrics_2026-02-02_2026-02-08.xlsx"
     *   }
     * }
     */
    public function reports_appointment_metrics()
    {
        try {
            // Handle OPTIONS request for CORS
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get parameters
            $format = strtolower($this->input->get('format') ?? $this->input->post('format') ?? '');
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            // Validate format
            if (!in_array($format, ['excel', 'csv', 'pdf'])) {
                return $this->json(['status' => 0, 'message' => 'Invalid format. Must be excel, csv, or pdf'], 400);
            }

            // Generate report file
            $filePath = $this->GroupAdmin_Model->exportAppointmentMetricsReport(
                $userId,
                $format,
                $startDate,
                $endDate,
                $tenantId,
                $doctorId
            );

            // Serve file directly with proper MIME type detection
            $this->serveReportFile($filePath, $format);

        } catch (Exception $e) {
            error_log("GroupAdmin::reports_appointment_metrics error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET/POST /groupadmin/reports/visit-metrics
     * Export Visit Metrics Report (Excel, CSV, or PDF)
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Query Parameters:
     * - format (required) - Export format: 'excel', 'csv', or 'pdf'
     * - startDate (optional) - Start date (YYYY-MM-DD)
     * - endDate (optional) - End date (YYYY-MM-DD)
     * - tenantId (optional) - Filter by facility
     * - doctorId (optional) - Filter by doctor
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "downloadUrl": "http://example.com/reports/visit_metrics_2026-02-02_2026-02-08.xlsx"
     *   }
     * }
     */
    public function reports_visit_metrics()
    {
        try {
            // Handle OPTIONS request for CORS
            if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
                echo json_encode(['status' => 1, 'message' => 'ok', 'data' => []]);
                exit;
            }

            // Extract JWT token from Authorization header
            $headers = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            $token = str_replace('Bearer ', '', $headers);
            
            if (empty($token)) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode JWT token
            $kunci = $this->config->item('thekey');
            $tokenData = JWT::decode($token, $kunci);
            
            if (!$tokenData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            // Get userId from JWT token
            $userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? $tokenData->id ?? null;

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
            }

            // Get parameters
            $format = strtolower($this->input->get('format') ?? $this->input->post('format') ?? '');
            $startDate = $this->input->get('startDate') ?? $this->input->post('startDate') ?? null;
            $endDate = $this->input->get('endDate') ?? $this->input->post('endDate') ?? null;
            $tenantId = $this->input->get('tenantId') ?? $this->input->post('tenantId') ?? null;
            $tenantId = $tenantId !== null ? (int)$tenantId : null;
            $doctorId = $this->input->get('doctorId') ?? $this->input->post('doctorId') ?? null;
            $doctorId = ($doctorId !== null && (int)$doctorId > 0) ? (int)$doctorId : null;

            // Validate format
            if (!in_array($format, ['excel', 'csv', 'pdf'])) {
                return $this->json(['status' => 0, 'message' => 'Invalid format. Must be excel, csv, or pdf'], 400);
            }

            // Generate report file
            $filePath = $this->GroupAdmin_Model->exportVisitMetricsReport(
                $userId,
                $format,
                $startDate,
                $endDate,
                $tenantId,
                $doctorId
            );

            // Serve file directly with proper MIME type detection
            $this->serveReportFile($filePath, $format);

        } catch (Exception $e) {
            error_log("GroupAdmin::reports_visit_metrics error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Helper: Get authorization token from header
     */
    private function getAuthToken()
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['Authorization'])) {
            $auth = $_SERVER['Authorization'];
        } else {
            $headers = $this->input->request_headers();
            $auth = $headers['Authorization'] ?? null;
        }
        
        if ($auth) {
            $token = str_replace("Bearer ", "", $auth);
            return trim($token);
        }
        
        return null;
    }

    /**
     * Helper: Validate JWT token
     */
    private function validateToken($token)
    {
        try {
            $jwtPath = APPPATH . 'third_party/google-api-php-client/vendor/firebase/php-jwt/src/';
            
            require_once $jwtPath . 'JWT.php';
            require_once $jwtPath . 'Key.php';
            
            $kunci = $this->config->item('thekey');
            
            if (!$kunci) {
                error_log("JWT key not found in config");
                return null;
            }
            
            $tokenData = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($kunci, 'HS256'));
            
            $userData = new \stdClass();
            $userData->userId = $tokenData->UserId ?? $tokenData->userid ?? $tokenData->userId ?? null;
            $userData->tenantId = $tokenData->TenantId ?? $tokenData->tenantid ?? $tokenData->tenantId ?? null;
            $userData->username = $tokenData->Username ?? $tokenData->username ?? '';
            $userData->displayName = $tokenData->DisplayName ?? $tokenData->displayname ?? $userData->username;
            
            return $userData;
            
        } catch (\Exception $e) {
            error_log("Token validation error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper: Return JSON response
     */
    private function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Helper: Get MIME type for file format
     */
    /**
     * Serve report file with proper MIME type detection
     */
    private function serveReportFile($filePath, $format)
    {
        if (!file_exists($filePath)) {
            return $this->json(['status' => 0, 'message' => 'Report file not found'], 404);
        }
        
        $fileName = basename($filePath);
        
        // Detect actual file type from extension (in case CSV fallback was used for Excel)
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if ($fileExtension === 'csv' && $format === 'excel') {
            // CSV fallback was used, set CSV MIME type
            $mimeType = 'text/csv';
        } else {
            $mimeType = $this->getMimeType($format);
        }
        
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        readfile($filePath);
        exit;
    }
    
    private function getMimeType($format)
    {
        switch (strtolower($format)) {
            case 'excel':
            case 'xlsx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'csv':
                return 'text/csv';
            case 'pdf':
                return 'application/pdf';
            default:
                return 'application/octet-stream';
        }
    }
}
