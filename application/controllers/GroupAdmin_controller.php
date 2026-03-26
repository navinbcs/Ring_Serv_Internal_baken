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
     * - userId (required) - Group Admin User ID
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

            $result = $this->GroupAdmin_Model->getWeeklyAppointments($userId);

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
     * GET/POST /groupadmin/appointments/status
     * Get appointment status summary for a Group Admin user
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
     *     "totalAppointments": 150,
     *     "totalRegistered": 120,
     *     "totalCancelled": 20,
     *     "totalNoShow": 10,
     *     "weekStart": "2026-01-27",
     *     "weekEnd": "2026-02-02",
     *     "userId": 3527
     *   }
     * }
     */
    public function appointments_status()
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

            $result = $this->GroupAdmin_Model->getAppointmentStatusSummary($userId);

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

            if (!$userId) {
                return $this->json(['status' => 0, 'message' => 'User ID parameter required'], 400);
            }

            $appointments = $this->GroupAdmin_Model->getDetailedAppointments($userId, $startDate, $endDate);

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

            // Convert tenantId to int if provided
            if ($tenantId !== null) {
                $tenantId = (int)$tenantId;
            }

            $result = $this->GroupAdmin_Model->getVisitStatistics($userId, $startDate, $endDate, $tenantId);

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

            // Convert tenantId to int if provided
            if ($tenantId !== null) {
                $tenantId = (int)$tenantId;
            }

            $result = $this->GroupAdmin_Model->getPatientDemographics($userId, $startDate, $endDate, $tenantId);

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
}
