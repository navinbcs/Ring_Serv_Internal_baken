<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu API Controller
 * 
 * Provides menu/navigation data for the application based on:
 * - User roles and permissions
 * - Tenant settings
 * - Login type (TCare, Mudah, Permai)
 */
class MenuApi extends CI_Controller
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
        $this->load->model('MenuModel');
    }

    /**
     * GET/POST /menu/list
     * Returns hierarchical menu structure for the logged-in user
     * 
     * Headers required:
     * - Authorization: Bearer {JWT_TOKEN}
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "items": [...],
     *     "activePath": [0, 1, -1, ...],
     *     "loginType": "Permai",
     *     "userName": "John Doe"
     *   }
     * }
     */
    public function list()
    {
        try {
            // Get JWT token from Authorization header
            $token = $this->getAuthToken();
            if (!$token) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
            }

            // Decode and validate token
            $userData = $this->validateToken($token);
            if (!$userData) {
                return $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
            }

            $userId = $userData->userId;
            $tenantId = $userData->tenantId;
            $username = $userData->username;

            // Get login type (TCare, Mudah, or Permai)
            $loginType = $this->MenuModel->getLoginType($tenantId);

            // Get menu items based on login type and permissions
            $menuItems = $this->MenuModel->getMenuItems($userId, $tenantId, $loginType);

            // Get current URL from request (supports both GET and POST)
            $currentUrl = $this->input->get('currentUrl') ?? 
                         $this->input->post('currentUrl') ?? 
                         $this->getJsonInput('currentUrl') ?? 
                         '/';
            
            // Determine active path
            $activePath = $this->MenuModel->getActivePath($menuItems, $currentUrl);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'items' => $menuItems,
                    'activePath' => $activePath,
                    'loginType' => $loginType,
                    'userName' => $userData->displayName ?? $username
                ]
            ]);

        } catch (Exception $e) {
            error_log("MenuApi::list error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * GET /menu/permissions
     * Returns all permissions for the current user
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "permissions": ["Dashboard:View", "Registration:Appointment:View", ...]
     *   }
     * }
     */
    public function permissions()
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

            $userId = $userData->userId;

            // Get all permissions for this user
            $permissions = $this->MenuModel->getUserPermissions($userId);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'permissions' => $permissions
                ]
            ]);

        } catch (Exception $e) {
            error_log("MenuApi::permissions error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * GET /menu/check-permission?permission={permissionKey}
     * Checks if current user has a specific permission
     * 
     * Response:
     * {
     *   "status": 1,
     *   "message": "Success",
     *   "data": {
     *     "hasPermission": true
     *   }
     * }
     */
    public function checkPermission()
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

            $userId = $userData->userId;
            $permissionKey = $this->input->get('permission');

            if (!$permissionKey) {
                return $this->json(['status' => 0, 'message' => 'Permission parameter required'], 400);
            }

            $hasPermission = $this->MenuModel->hasPermission($userId, $permissionKey);

            return $this->json([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'permissionKey' => $permissionKey,
                    'hasPermission' => $hasPermission
                ]
            ]);

        } catch (Exception $e) {
            error_log("MenuApi::checkPermission error: " . $e->getMessage());
            return $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Helper: Get authorization token from header
     */
    private function getAuthToken()
    {
        // Try different methods to get the Authorization header
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['Authorization'])) {
            $auth = $_SERVER['Authorization'];
        } else {
            $headers = $this->input->request_headers();
            $auth = $headers['Authorization'] ?? null;
        }
        
        if ($auth) {
            // Remove "Bearer " prefix
            $token = str_replace("Bearer ", "", $auth);
            return $token;
        }
        
        return null;
    }

    /**
     * Helper: Get JSON input from POST body
     */
    private function getJsonInput($key = null)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if ($key === null) {
            return $input;
        }
        
        return $input[$key] ?? null;
    }

    /**
     * Helper: Validate JWT token (using same method as existing code)
     */
    private function validateToken($token)
    {
        try {
            // Load JWT library from firebase package
            $jwtPath = APPPATH . 'third_party/google-api-php-client/vendor/firebase/php-jwt/src/';
            
            require_once $jwtPath . 'JWT.php';
            require_once $jwtPath . 'Key.php';
            
            // Use the same key as existing code
            $kunci = $this->config->item('thekey');
            
            // Decode token (same as existing code)
            $tokenData = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($kunci, 'HS256'));
            
            // Convert to object with expected properties
            $userData = new \stdClass();
            $userData->userId = $tokenData->UserId ?? $tokenData->userid ?? null;
            $userData->tenantId = $tokenData->TenantId ?? $tokenData->tenantid ?? null;
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
