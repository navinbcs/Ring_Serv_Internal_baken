<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MyDashboard API Controller
 *
 * Serves the New Doctor Dashboard (e.g. overview, KPIs, charts, tables).
 * Endpoints:
 * - GET/POST api/dashboards/new-dr-dashboard/overview
 * - GET/POST api/dashboards/new-dr-dashboard/appointments
 * - GET/POST api/dashboards/new-dr-dashboard/billing
 * - GET/POST api/dashboards/new-dr-dashboard/patient-behavior
 */
class MyDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');
        $this->load->database();
        $this->load->model('GroupAdmin_Model');
        $this->load->model('DoctorAvailability_model');
        $this->load->model('Billing_model');
        require_once APPPATH . 'libraries/EncDecAlgorithm.php';
    }

    /**
     * GET/POST /api/dashboards/new-dr-dashboard/overview
     *
     * Requires: Authorization: Bearer {JWT_TOKEN} — userId (and optionally tenantId) taken from JWT.
     * Query/body params (optional): dateRange, startDate, endDate, tenantId (override JWT tenant)
     *
     * Response: { kpis, appointmentTrend, slotUtilization, upcomingAppointments, topDiagnoses }
     */
    public function overview()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }
            // Resolve doctorId for Group Admin views (guarded)
            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            // If we are viewing someone else's dashboard, don't use JWT displayName
            $effectiveUserDataForName = ($effectiveDoctorId !== null && (string)$effectiveDoctorId === (string)$userId) ? $userData : null;

            $data = $this->getOverviewData($userId, $effectiveDoctorId, $tenantId, $dateRange, $startDate, $endDate, $effectiveUserDataForName);

            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::overview error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            error_log('MyDashboard::overview trace: ' . $e->getTraceAsString());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::overview fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Get Bearer token from Authorization header
     */
    private function getAuthToken()
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['Authorization'])) {
            $auth = $_SERVER['Authorization'];
        } else {
            $headers = $this->input->request_headers();
            $auth = isset($headers['Authorization']) ? $headers['Authorization'] : null;
        }
        if ($auth) {
            $token = str_replace('Bearer ', '', $auth);
            return trim($token);
        }
        return null;
    }

    /**
     * Parse tenantId param to array of integers. Supports single ID or comma-separated (e.g. "1753,1754").
     *
     * @param int|string|null $tenantId
     * @return array Array of integer tenant IDs
     */
    private function parseTenantIds($tenantId)
    {
        if ($tenantId === null || $tenantId === '') {
            return [];
        }
        $s = (string) $tenantId;
        if (strpos($s, ',') !== false) {
            return array_values(array_filter(array_map('intval', explode(',', $s))));
        }
        return [(int) $tenantId];
    }

    /**
     * Validate JWT and return user data (userId, tenantId, etc.).
     * Decode JWT token (same as PackageMasterApi).
     */
    private function validateToken($token)
    {
        try {
            if (empty($token)) {
                error_log('MyDashboard: Empty token provided');
                return null;
            }

            $kunci = $this->config->item('thekey');
            if (!$kunci) {
                error_log('MyDashboard: JWT key not found in config');
                return null;
            }

            if (!class_exists('JWT')) {
                error_log('MyDashboard: JWT class not found - helper may not be loaded');
                return null;
            }

            $tokenData = JWT::decode($token, $kunci);

            if (!$tokenData) {
                error_log('MyDashboard: JWT decode returned null/empty');
                return null;
            }

            // Get userId from JWT token (same pattern as PackageMasterApi)
            $userId = null;
            if (isset($tokenData->UserId)) {
                $userId = $tokenData->UserId;
            } elseif (isset($tokenData->userid)) {
                $userId = $tokenData->userid;
            } elseif (isset($tokenData->userId)) {
                $userId = $tokenData->userId;
            } elseif (isset($tokenData->id)) {
                $userId = $tokenData->id;
            }

            $userData = new \stdClass();
            $userData->userId = $userId;
            $userData->tenantId = null;
            if (isset($tokenData->TenantId)) {
                $userData->tenantId = $tokenData->TenantId;
            } elseif (isset($tokenData->tenantid)) {
                $userData->tenantId = $tokenData->tenantid;
            } elseif (isset($tokenData->tenantId)) {
                $userData->tenantId = $tokenData->tenantId;
            }

           // print_r($tokenData); exit ;
            $userData->username = isset($tokenData->Username) ? $tokenData->Username : (isset($tokenData->username) ? $tokenData->username : '');
            $userData->displayName = isset($tokenData->DisplayName) ? $tokenData->DisplayName : (isset($tokenData->displayname) ? $tokenData->displayname : $userData->username);
            $userData->RoleId = isset($tokenData->RoleId) ? $tokenData->RoleId : (isset($tokenData->RoleId) ? $tokenData->RoleId : $userData->RoleId);
            $userData->Role = isset($tokenData->Role) ? $tokenData->Role : (isset($tokenData->Role) ? $tokenData->Role : $userData->Role);
           
          
            return $userData;
        } catch (\Exception $e) {
            error_log('MyDashboard::validateToken error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return null;
        }
    }


    /**
     * Permission gate for doctorId override.
     * - By default, a doctor can only view their own dashboard (doctorId from JWT userId).
     * - Group Admin users are allowed to request another doctorId via query param.
     *
     * NOTE: This intentionally does NOT validate the target doctorId. It only gates whether
     * the current user can override at all. You can tighten this further by checking the
     * target doctor's tenant mapping if you have such a function/model.
     */
    private function canOverrideDoctorId($currentUserId, $tenantId = null)
    {
        try {
            if (!isset($this->GroupAdmin_Model) || !method_exists($this->GroupAdmin_Model, 'getTenantIdsForGroupAdmin')) {
                return false;
            }

            // Group Admin or roleId 48: must have tenant scope
            $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($currentUserId);
            if (empty($tenantIds) || !is_array($tenantIds)) {
                return false;
            }

            // If specific tenantId(s) provided (single or comma-separated), ensure all are in scope
            if ($tenantId !== null && $tenantId !== '') {
                $requestedIds = $this->parseTenantIds($tenantId);
                if (empty($requestedIds)) {
                    return true;
                }
                $allowedSet = array_flip(array_map('intval', $tenantIds));
                foreach ($requestedIds as $rid) {
                    if (!isset($allowedSet[$rid])) {
                        return false;
                    }
                }
                return true;
            }

            // Group Admin with at least one tenant mapped
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Resolve doctorId from request (query/body) with permission guard.
     *
     * Case A — doctorId sent:
     *   - Group Admin → allow that doctorId
     *   - Not Group Admin → ignore it, use JWT userId
     *
     * Case B — doctorId NOT sent:
     *   - Group Admin (or roleId 48) → return null (ALL doctors, no doctor filter)
     *   - Else → return JWT userId (show only self)
     *
     * doctorFilter = null means "ALL doctors"
     * doctorFilter = 30498 means "Only doctor 30498"
     */
    private function resolveDoctorIdFromRequest($jwtUserId, $tenantId = null)
    {
        $requestedDoctorId = $this->input->get_post('doctorId');
        // doctorId=0 means "All Doctors" (from frontend dropdown)
        if ($requestedDoctorId === null || $requestedDoctorId === '' || $requestedDoctorId === 0 || $requestedDoctorId === '0') {
            // Case B: doctorId NOT sent
            if ($this->canOverrideDoctorId($jwtUserId, $tenantId)) {
                return null; // Group Admin → ALL doctors
            }
            return $jwtUserId; // Else → show only self
        }

        // Case A: doctorId sent
        // Same as logged-in user -> always allowed
        if ((string)$requestedDoctorId === (string)$jwtUserId) {
            return $jwtUserId;
        }

        // Different doctor -> allow only when current user has scope (Group Admin)
        if ($this->canOverrideDoctorId($jwtUserId, $tenantId)) {
            return $requestedDoctorId;
        }

        return $jwtUserId; // Not Group Admin → ignore, use self
    }

    /**
     * For Doctor role: if effectiveDoctorId is null/empty, use JWT userId (show own dashboard).
     * For other roles: return effectiveDoctorId unchanged.
     */
    private function ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId)
    {
        if (isset($userData->Role) && $userData->Role === 'Doctor' && ($effectiveDoctorId === null || $effectiveDoctorId === '')) {
            return isset($userData->userId) ? $userData->userId : $effectiveDoctorId;
        }
        return $effectiveDoctorId;
    }

    /**
     * Build overview payload. Uses GroupAdmin_Model::getAppointmentStatusSummary for KPI counts.
     *
     * @param int $scopeUserId JWT userId - used for tenant scope (getTenantIdsForGroupAdmin)
     * @param int|null $doctorFilter null = ALL doctors, else userId/PractitionerId for specific doctor
     */
    private function getOverviewData($scopeUserId, $doctorFilter = null, $tenantId = null, $dateRange = null, $startDate = null, $endDate = null, $userData = null)
    {
        $kpis = [
            'totalAppointments'       => 0,
            'completedAppointments'   => 0,
            'cancelledAppointments'   => 0,
            'noShowCount'             => 0,
            'totalRegistrations'      => 0,
            'slotUtilization'         => 87.5,
            'avgConsultationDuration' => 18,
            'nextAppointmentTime'     => '2:30 PM',
        ];

        $practitionerId = null;
        if ($doctorFilter !== null && $doctorFilter !== '') {
            // Appointment table stores PractitionerId (PractitionerMaster.Id), not Users.UserId
            $practitionerId = $this->getPractitionerIdByUserId($doctorFilter);
            if ($practitionerId === null || $practitionerId === '') {
                $practitionerId = $doctorFilter;
            }
        }
        $sqlQuery = null;
        
        if ($scopeUserId !== null && $scopeUserId !== '') {
            try {
                $summary = $this->GroupAdmin_Model->getAppointmentStatusSummary(
                    $scopeUserId,
                    $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                    $startDate,
                    $endDate,
                    $practitionerId
                );
                $kpis['totalAppointments']     = (int) (isset($summary['totalAppointments']) ? $summary['totalAppointments'] : 0);
                $kpis['completedAppointments'] = (int) (isset($summary['totalRegistered']) ? $summary['totalRegistered'] : 0);
                $kpis['cancelledAppointments'] = (int) (isset($summary['totalCancelled']) ? $summary['totalCancelled'] : 0);
                $kpis['noShowCount']           = (int) (isset($summary['totalNoShow']) ? $summary['totalNoShow'] : 0);
                $kpis['totalRegistrations']    = (int) (isset($summary['totalRegistered']) ? $summary['totalRegistered'] : 0);
                $totalAppts = $kpis['totalAppointments'];
                $totalReg = $kpis['totalRegistrations'];
                $kpis['slotUtilization'] = $totalAppts > 0 ? round(($totalReg / $totalAppts) * 100, 1) : 0;
                if (isset($summary['debug']) && isset($summary['debug']['sqlQuery'])) {
                    $sqlQuery = $summary['debug']['sqlQuery'];
                }
            } catch (Exception $e) {
                error_log('MyDashboard::getOverviewData - getAppointmentStatusSummary error: ' . $e->getMessage());
            }
        }

        if ($scopeUserId !== null && $scopeUserId !== '') {
            try {
                $avgDuration = $this->GroupAdmin_Model->getAvgConsultationDuration(
                    $scopeUserId,
                    $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                    $startDate,
                    $endDate,
                    $practitionerId
                );
                $kpis['avgConsultationDuration'] = $avgDuration > 0 ? $avgDuration : 18;
            } catch (Exception $e) {
                error_log('MyDashboard::getOverviewData - getAvgConsultationDuration error: ' . $e->getMessage());
            }
        }

        try {
            $upcomingAppointments = $this->getUpcomingAppointments($practitionerId, $tenantId);
            $nextToday = $this->getNextAppointmentOfToday($practitionerId, $tenantId);
            $kpis['nextAppointmentTime'] = ($nextToday !== null && $nextToday !== '') ? $nextToday : '-';
        } catch (Exception $e) {
            error_log('MyDashboard::getOverviewData - getUpcomingAppointments error: ' . $e->getMessage());
            $upcomingAppointments = [];
        }

        $doctorName = 'Doctor';
        if ($userData && isset($userData->displayName) && $userData->displayName) {
            $doctorName = $userData->displayName;
        } elseif ($doctorFilter) {
            $doctorName = $this->getDoctorName($doctorFilter);
        }

        $topDiagnosesResult = $this->getOverviewTopDiagnoses($scopeUserId, $tenantId, $startDate, $endDate, $practitionerId);
        $topDiagnosesData   = isset($topDiagnosesResult['data']) ? $topDiagnosesResult['data'] : [];
        $topDiagnosesQuery  = $topDiagnosesResult['query'] ?? null;
        $topDiagnosesParams = $topDiagnosesResult['params'] ?? [];

        $appointmentTrend = $this->getOverviewAppointmentTrend($scopeUserId, $tenantId, $startDate, $endDate, $practitionerId);
        $slotUtilization = $this->getOverviewSlotUtilization($scopeUserId, $tenantId, $startDate, $endDate, $practitionerId);
        if (isset($slotUtilization['periodTotalSlots']) && isset($slotUtilization['periodBookedSlots']) && $slotUtilization['periodTotalSlots'] > 0) {
            $kpis['slotUtilization'] = round(($slotUtilization['periodBookedSlots'] / $slotUtilization['periodTotalSlots']) * 100, 1);
        }
        $slotUtilization = [
            'labels' => $slotUtilization['labels'],
            'data' => $slotUtilization['data'],
            'periodTotalSlots' => (int) ($slotUtilization['periodTotalSlots'] ?? 0),
            'periodBookedSlots' => (int) ($slotUtilization['periodBookedSlots'] ?? 0),
        ];

        $response = [
            'doctorName' => $doctorName,
            'kpis' => $kpis,
            'appointmentTrend' => $appointmentTrend,
            'slotUtilization' => $slotUtilization,
            'upcomingAppointments' => $upcomingAppointments,
            'topDiagnoses' => $topDiagnosesData,
            'topDiagnosesQuery' => $topDiagnosesQuery,
            'topDiagnosesParams' => $topDiagnosesParams,
        ];

        // Include SQL query in response for debugging (remove later)
        if ($sqlQuery !== null) {
            $response['_debug'] = [
                'sqlQuery' => $sqlQuery,
                'params' => [
                    'scopeUserId' => $scopeUserId,
                    'doctorFilter' => $doctorFilter,
                    'practitionerId' => $practitionerId,
                    'userIdFromJwt' => true,
                    'tenantId' => $tenantId,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ],
            ];
        }

        return $response;
    }

    /**
     * Get appointment trend by weekday for overview chart. Uses GroupAdmin_Model::getAppointmentTrendByWeekday.
     */
    private function getOverviewAppointmentTrend($userId, $tenantId, $startDate, $endDate, $practitionerId)
    {
        try {
            return $this->GroupAdmin_Model->getAppointmentTrendByWeekday(
                $userId,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
        } catch (Exception $e) {
            error_log('MyDashboard::getOverviewAppointmentTrend error: ' . $e->getMessage());
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'series' => [
                    ['name' => 'Created',   'data' => [0, 0, 0, 0, 0, 0, 0]],
                    ['name' => 'Completed', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                    ['name' => 'Cancelled', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                    ['name' => 'No-show',   'data' => [0, 0, 0, 0, 0, 0, 0]],
                ],
            ];
        }
    }

    /**
     * Get slot utilization by weekday for overview chart.
     * Uses (booked slots / total slots) * 100 per weekday.
     * Total slots = from working hours (usp_GetTenantWorkingHours, usp_GetDoctorWorkingHours).
     * Booked slots = from usp_GetDoctorBookedslots.
     * When practitionerId or tenantId is missing, falls back to (completed appointments / total appointments).
     */
    private function getOverviewSlotUtilization($userId, $tenantId, $startDate, $endDate, $practitionerId)
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        // date('w'): 0=Sun, 1=Mon, ..., 6=Sat. Chart order: Mon(0), Tue(1), ..., Sun(6).
        $dowToIndex = function ($dow) {
            return $dow === 0 ? 6 : $dow - 1;
        };

        $resolvedTenantId = $tenantId !== null && $tenantId !== '' ? (int) $tenantId : null;
        if ($resolvedTenantId === null) {
            $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($userId);
            $resolvedTenantId = !empty($tenantIds) ? (int) $tenantIds[0] : null;
        }
        $resolvedPractitionerId = ($practitionerId !== null && $practitionerId !== '' && $practitionerId !== 0)
            ? (int) $practitionerId : null;

        $daysDiff = $startDate && $endDate ? (strtotime($endDate) - strtotime($startDate)) / 86400 + 1 : 0;
        if ($resolvedTenantId !== null && $resolvedPractitionerId !== null && $startDate && $endDate && $daysDiff <= 14) {
            try {
                $totalByDay = [0, 0, 0, 0, 0, 0, 0];
                $bookedByDay = [0, 0, 0, 0, 0, 0, 0];
                $periodTotalSlots = 0;
                $periodBookedSlots = 0;
                $current = strtotime($startDate);
                $end = strtotime($endDate);
                while ($current <= $end) {
                    $date = date('Y-m-d', $current);
                    $dow = (int) date('w', $current); // 0=Sun, 1=Mon, ..., 6=Sat
                    $idx = $dowToIndex($dow);
                    $flag = 'CurrentDay';
                    $avail = $this->DoctorAvailability_model->getAvailability(
                        $resolvedTenantId,
                        $resolvedPractitionerId,
                        $date,
                        $flag
                    );
                    $slots = isset($avail['slots']) ? $avail['slots'] : [];
                    $total = count($slots);
                    $booked = 0;
                    foreach ($slots as $s) {
                        if (isset($s['status']) && strtoupper($s['status']) === 'BOOKED') {
                            $booked++;
                        }
                    }
                    $totalByDay[$idx] += $total;
                    $bookedByDay[$idx] += $booked;
                    $periodTotalSlots += $total;
                    $periodBookedSlots += $booked;
                    $current = strtotime('+1 day', $current);
                }
                $data = [];
                for ($i = 0; $i < 7; $i++) {
                    $data[] = $totalByDay[$i] > 0
                        ? round(($bookedByDay[$i] / $totalByDay[$i]) * 100, 1)
                        : 0;
                }
                return [
                    'labels' => $labels,
                    'data' => $data,
                    'periodTotalSlots' => $periodTotalSlots,
                    'periodBookedSlots' => $periodBookedSlots,
                ];
            } catch (Exception $e) {
                error_log('MyDashboard::getOverviewSlotUtilization DoctorAvailability error: ' . $e->getMessage());
            }
        }

        try {
            return $this->GroupAdmin_Model->getSlotUtilizationByWeekday(
                $userId,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
        } catch (Exception $e) {
            error_log('MyDashboard::getOverviewSlotUtilization fallback error: ' . $e->getMessage());
            return [
                'labels' => $labels,
                'data' => [0, 0, 0, 0, 0, 0, 0],
                'periodTotalSlots' => 0,
                'periodBookedSlots' => 0,
            ];
        }
    }

    /**
     * Get top diagnoses (ICD-10) for overview tab. Uses GroupAdmin_Model::getTopDiagnoses.
     * Returns ['data' => [...], 'query' => string, 'params' => array].
     */
    private function getOverviewTopDiagnoses($userId, $tenantId, $startDate, $endDate, $practitionerId)
    {
        try {
            return $this->GroupAdmin_Model->getTopDiagnoses(
                $userId,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId,
                true  // include query in response
            );
        } catch (Exception $e) {
            error_log('MyDashboard::getOverviewTopDiagnoses error: ' . $e->getMessage());
            return ['data' => [], 'query' => null, 'params' => []];
        }
    }

    /**
     * Map Users.UserId -> Users.LinkUserId (PractitionerMaster.Id).
     * Appointment.PractitionerId references PractitionerMaster.Id, so we must use LinkUserId for filtering.
     */
    private function getPractitionerIdByUserId($userId)
    {
        try {
            if ($userId === null || $userId === '' || $userId === 0) {
                return null;
            }

            $sql = "SELECT TOP 1 u.LinkUserId
                    FROM Users u
                    WHERE u.UserId = ?";
            $query = $this->db->query($sql, [(int)$userId]);
            $row = $query->row();
            if ($row && isset($row->LinkUserId) && $row->LinkUserId !== null && $row->LinkUserId !== '') {
                return (int)$row->LinkUserId;
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getPractitionerIdByUserId error: ' . $e->getMessage());
        }
        return null;
    }

    /**
     * Calculate peak hours: the time window with the most booked appointments in the period.
     * Groups appointments by hour, finds the hour with max count, returns as "10:00 AM - 11:00 AM".
     */
    private function getPeakHours($practitionerId, $tenantId, $startDate, $endDate)
    {
        try {
            if (!$practitionerId || !$startDate || !$endDate) {
                return '10:00 AM - 12:00 PM';
            }
            $sql = "SELECT DATEPART(HOUR, a.FromTime) AS Hour, COUNT(*) AS Cnt
                    FROM Appointment a
                    WHERE a.PractitionerId = ?
                    AND CAST(a.AppointmentDate AS DATE) >= ?
                    AND CAST(a.AppointmentDate AS DATE) <= ?
                    AND a.AppointmentStatusId <> 2
                    AND a.IsActive = 1";
            $params = [(int)$practitionerId, $startDate, $endDate];
            $tenantIds = $this->parseTenantIds($tenantId);
            if (!empty($tenantIds)) {
                $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                $sql .= " AND a.TenantId IN ($ph)";
                $params = array_merge($params, $tenantIds);
            }
            $sql .= " GROUP BY DATEPART(HOUR, a.FromTime) ORDER BY Cnt DESC";
            $q = $this->db->query($sql, $params);
            $rows = $q ? $q->result_array() : [];
            if (empty($rows)) {
                return '10:00 AM - 12:00 PM';
            }
            $peakHour = (int) ($rows[0]['Hour'] ?? 0);
            $startHour = $peakHour;
            $endHour = $peakHour + 1;
            $startStr = $this->formatHour12($startHour);
            $endStr = $this->formatHour12($endHour);
            return $startStr . ' - ' . $endStr;
        } catch (Exception $e) {
            error_log('MyDashboard::getPeakHours error: ' . $e->getMessage());
            return '10:00 AM - 12:00 PM';
        }
    }

    private function formatHour12($hour24)
    {
        $hour24 = (int) $hour24;
        if ($hour24 < 0 || $hour24 > 23) $hour24 = 10;
        $ampm = $hour24 >= 12 ? 'PM' : 'AM';
        $hour12 = $hour24 > 12 ? $hour24 - 12 : ($hour24 == 0 ? 12 : $hour24);
        return sprintf('%d:00 %s', $hour12, $ampm);
    }

    /**
     * Debug: Per-day slot breakdown for date range (to verify 7-day sum).
     */
    private function getSlotUtilizationPerDayBreakdown($tenantId, $doctorId, $startDate, $endDate)
    {
        $breakdown = [];
        $current = strtotime($startDate);
        $end = strtotime($endDate);
        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            try {
                $this->load->model('DoctorAvailability_model');
                $avail = $this->DoctorAvailability_model->getAvailability((int)$tenantId, (int)$doctorId, $date, 'CurrentDay');
                $slots = $avail['slots'] ?? [];
                $booked = 0;
                foreach ($slots as $s) {
                    if (isset($s['status']) && strtoupper($s['status']) === 'BOOKED') {
                        $booked++;
                    }
                }
                $breakdown[] = [
                    'date' => $date,
                    'dayOfWeek' => date('l', $current),
                    'totalSlots' => count($slots),
                    'bookedSlots' => $booked,
                ];
            } catch (Exception $e) {
                $breakdown[] = ['date' => $date, 'error' => $e->getMessage(), 'totalSlots' => 0, 'bookedSlots' => 0];
            }
            $current = strtotime('+1 day', $current);
        }
        $sumTotal = array_sum(array_column($breakdown, 'totalSlots'));
        $sumBooked = array_sum(array_column($breakdown, 'bookedSlots'));
        return [
            'perDay' => $breakdown,
            'sumTotalSlots' => $sumTotal,
            'sumBookedSlots' => $sumBooked,
            'daysInRange' => count($breakdown),
        ];
    }

    /**
     * Slot Heatmap (Day vs Time): utilization % per (day of week, hour).
     * Uses DoctorAvailability slots; aggregates over date range.
     * Returns array of { time, monday, tuesday, ..., sunday } for ApexCharts heatmap.
     */
    private function getSlotHeatmap($tenantId, $doctorId, $startDate, $endDate)
    {
        $dayNames = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $dowToIndex = function ($dow) {
            return $dow === 0 ? 6 : $dow - 1;
        };

        $totalByDayHour = [];
        $bookedByDayHour = [];
        for ($d = 0; $d < 7; $d++) {
            $totalByDayHour[$d] = [];
            $bookedByDayHour[$d] = [];
        }

        $current = strtotime($startDate);
        $end = strtotime($endDate);
        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            $dow = (int) date('w', $current);
            $dayIdx = $dowToIndex($dow);
            try {
                $this->load->model('DoctorAvailability_model');
                $avail = $this->DoctorAvailability_model->getAvailability((int)$tenantId, (int)$doctorId, $date, 'CurrentDay');
                $slots = $avail['slots'] ?? [];
                foreach ($slots as $s) {
                    $from = $s['from'] ?? null;
                    if (!$from || !preg_match('/^(\d{1,2}):/', $from, $m)) continue;
                    $hour = (int) $m[1];
                    if (!isset($totalByDayHour[$dayIdx][$hour])) {
                        $totalByDayHour[$dayIdx][$hour] = 0;
                        $bookedByDayHour[$dayIdx][$hour] = 0;
                    }
                    $totalByDayHour[$dayIdx][$hour]++;
                    if (isset($s['status']) && strtoupper($s['status']) === 'BOOKED') {
                        $bookedByDayHour[$dayIdx][$hour]++;
                    }
                }
            } catch (Exception $e) {
                // skip date on error
            }
            $current = strtotime('+1 day', $current);
        }

        $allHours = [];
        foreach ($totalByDayHour as $hours) {
            $allHours = array_merge($allHours, array_keys($hours));
        }
        $allHours = array_unique($allHours);
        sort($allHours);

        $rows = [];
        foreach ($allHours as $hour) {
            $row = ['time' => $this->formatHour12($hour)];
            for ($d = 0; $d < 7; $d++) {
                $total = $totalByDayHour[$d][$hour] ?? 0;
                $booked = $bookedByDayHour[$d][$hour] ?? 0;
                $pct = $total > 0 ? round(($booked / $total) * 100, 1) : 0;
                $row[$dayNames[$d]] = (int) $pct;
            }
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Debug: Call getAvailability and return slot counts (total, booked) for the date.
     */
    private function getAvailabilityDebug($tenantId, $doctorId, $date)
    {
        try {
            $this->load->model('DoctorAvailability_model');
            $avail = $this->DoctorAvailability_model->getAvailability((int)$tenantId, (int)$doctorId, $date, 'CurrentDay');
            $slots = $avail['slots'] ?? [];
            $bookedCount = 0;
            foreach ($slots as $s) {
                if (isset($s['status']) && strtoupper($s['status']) === 'BOOKED') {
                    $bookedCount++;
                }
            }
            return [
                'date' => $date,
                'totalSlots' => count($slots),
                'bookedSlots' => $bookedCount,
                'note' => 'This is what DoctorAvailability returns for this date.',
            ];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Debug: Direct Appointment table query (same logic as usp_GetDoctorBookedslots).
     */
    private function getAppointmentsForDateDebug($practitionerId, $date)
    {
        try {
            $sql = "SELECT A.Id, A.AppointmentNo, A.AppointmentDate, A.FromTime, A.ToTime, A.AppointmentStatusId
                    FROM Appointment A
                    WHERE CAST(A.AppointmentDate AS DATE) = ?
                    AND A.PractitionerId = ?
                    AND A.AppointmentStatusId <> 2
                    ORDER BY A.FromTime";
            $q = $this->db->query($sql, [$date, (int)$practitionerId]);
            $rows = $q ? $q->result_array() : [];
            return [
                'rowCount' => count($rows),
                'query' => "Appointment WHERE CAST(AppointmentDate AS DATE) = '$date' AND PractitionerId = $practitionerId AND StatusId <> 2",
                'sample' => array_slice($rows, 0, 5),
            ];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Debug: Call usp_GetDoctorBookedslots and return raw result (row count + sample).
     */
    private function getBookedSlotsRaw($doctorId, $appointmentDate)
    {
        try {
            $sql = "EXEC usp_GetDoctorBookedslots @DoctorId = ?, @AppointmentDate = ?";
            $q = $this->db->query($sql, [(int)$doctorId, $appointmentDate]);
            $rows = $q ? $q->result_array() : [];
            return [
                'rowCount' => count($rows),
                'params' => ['DoctorId' => (int)$doctorId, 'AppointmentDate' => $appointmentDate],
                'sample' => array_slice($rows, 0, 5),
            ];
        } catch (Exception $e) {
            return ['error' => $e->getMessage(), 'rowCount' => 0];
        }
    }

    /**
     * Get doctor name from PractitionerMaster or Users table
     * Matches Enrollment pattern: Users LEFT JOIN PractitionerMaster
     */
    private function getDoctorName($doctorId)
    {
        try {
            $sql = "SELECT TOP 1 
                        pm.PractitionerName,
                        u.DisplayName
                    FROM Users u
                    LEFT JOIN PractitionerMaster pm ON u.LinkUserId = pm.Id
                    WHERE u.UserId = ? OR u.LinkUserId = ?";
            $query = $this->db->query($sql, [$doctorId, $doctorId]);
            $row = $query->row();
            if ($row) {
                // Prefer PractitionerName (from PractitionerMaster), fallback to DisplayName (from Users)
                if (isset($row->PractitionerName) && $row->PractitionerName && trim($row->PractitionerName) !== '') {
                    return trim($row->PractitionerName);
                }
                if (isset($row->DisplayName) && $row->DisplayName && trim($row->DisplayName) !== '') {
                    return trim($row->DisplayName);
                }
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getDoctorName error: ' . $e->getMessage());
        }
        return 'Doctor';
    }

    /**
     * Get the next appointment time of today (first upcoming slot where FromTime > current time).
     * Used for the Next Appointment KPI.
     */
    private function getNextAppointmentOfToday($doctorId = null, $tenantId = null)
    {
        if (!$doctorId) {
            return null;
        }
        try {
            $today = date('Y-m-d');
            $now = date('H:i:s');

            $sql = "SELECT TOP 1 a.FromTime
                    FROM Appointment a
                    WHERE a.PractitionerId = ?
                        AND CAST(a.AppointmentDate AS DATE) = ?
                        AND CAST(a.FromTime AS TIME) >= ?
                        AND a.IsActive = 1";

            $params = [$doctorId, $today, $now];

            $tenantIds = $this->parseTenantIds($tenantId);
            if (!empty($tenantIds)) {
                $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                $sql .= " AND a.TenantId IN ($ph)";
                $params = array_merge($params, $tenantIds);
            }

            $sql .= " ORDER BY a.FromTime";

            $query = $this->db->query($sql, $params);
            $row = $query ? $query->row() : null;
            if (!$row || !$row->FromTime) {
                return null;
            }

            $time = $row->FromTime;
            if (is_object($time) && method_exists($time, 'format')) {
                $time = $time->format('H:i:s');
            }
            if (strpos($time, ' ') !== false) {
                $parts = explode(' ', trim($time));
                $time = (count($parts) > 1 && strpos($parts[1], ':') !== false) ? $parts[1] : $parts[0];
            }
            $timeParts = explode(':', $time);
            if (count($timeParts) >= 2) {
                $hours = (int) $timeParts[0];
                $minutes = (int) $timeParts[1];
                $ampm = $hours >= 12 ? 'PM' : 'AM';
                $hours12 = $hours > 12 ? $hours - 12 : ($hours == 0 ? 12 : $hours);
                return sprintf('%d:%02d %s', $hours12, $minutes, $ampm);
            }
            return null;
        } catch (Exception $e) {
            error_log('MyDashboard::getNextAppointmentOfToday error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get upcoming appointments for next 14 days for the doctor.
     * Extended from 2 to 14 days so the Upcoming Appointments table shows future slots.
     */
    private function getUpcomingAppointments($doctorId = null, $tenantId = null)
    {
        if (!$doctorId) {
            return [
                ['time' => '02:30 PM', 'prn' => 'PRN001234', 'name' => 'John Doe', 'type' => 'Physical', 'status' => 'Confirmed'],
                ['time' => '03:00 PM', 'prn' => 'PRN001235', 'name' => 'Jane Smith', 'type' => 'Teleconsultation', 'status' => 'Confirmed'],
                ['time' => '03:30 PM', 'prn' => 'PRN001236', 'name' => 'Bob Johnson', 'type' => 'Physical', 'status' => 'Pending'],
                ['time' => '04:00 PM', 'prn' => 'PRN001237', 'name' => 'Alice Brown', 'type' => 'Teleconsultation', 'status' => 'Confirmed'],
            ];
        }

        try {
            $today = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+14 days'));

            $sql = "SELECT TOP 20
                        CAST(a.AppointmentDate AS DATE) AS AppointmentDate,
                        a.FromTime,
                        p.PRN,
                        p.FullName,
                        p.LastName,
                        a.AppointmentType,
                        asm.AppointmentStatusDescription AS Status
                    FROM Appointment a
                    LEFT JOIN PatientMaster p ON a.PatientId = p.PatientId
                    LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.PractitionerId = ?
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";

            $params = [$doctorId, $today, $endDate];

            $tenantIds = $this->parseTenantIds($tenantId);
            if (!empty($tenantIds)) {
                $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                $sql .= " AND a.TenantId IN ($ph)";
                $params = array_merge($params, $tenantIds);
            }

            $sql .= " ORDER BY a.AppointmentDate, a.FromTime";

            $query = $this->db->query($sql, $params);
            $appointments = [];

            foreach ($query->result() as $row) {
                
                $time = $row->FromTime;
                if ($time) {
                    if (is_object($time) && method_exists($time, 'format')) {
                        $time = $time->format('H:i:s');
                    }
                    if (strpos($time, ' ') !== false) {
                        $parts = explode(' ', trim($time));
                        $time = (count($parts) > 1 && strpos($parts[1], ':') !== false) ? $parts[1] : $parts[0];
                    }
                    $timeParts = explode(':', $time);
                    if (count($timeParts) >= 2) {
                        $hours = (int)$timeParts[0];
                        $minutes = (int)$timeParts[1];
                        $ampm = $hours >= 12 ? 'PM' : 'AM';
                        $hours12 = $hours > 12 ? $hours - 12 : ($hours == 0 ? 12 : $hours);
                        $time = sprintf('%d:%02d %s', $hours12, $minutes, $ampm);
                    } else {
                        $time = 'N/A';
                    }
                } else {
                    $time = 'N/A';
                }

                $type = 'Physical';
                if ($row->AppointmentType) {
                    $apptType = strtolower($row->AppointmentType);
                    if (strpos($apptType, 'tele') !== false || strpos($apptType, 'video') !== false || strpos($apptType, 'online') !== false) {
                        $type = 'Teleconsultation';
                    }
                }

                $status = isset($row->Status) ? $row->Status : 'Pending';
                if (strpos(strtolower($status), 'confirm') !== false) {
                    $status = 'Confirmed';
                } elseif (strpos(strtolower($status), 'pending') !== false || strpos(strtolower($status), 'open') !== false) {
                    $status = 'Pending';
                }

                // Decrypt patient name (FullName = FirstName, LastName = LastName)
                $firstName = '';
                $lastName = '';
                if (isset($row->FullName) && $row->FullName) {
                    $firstName = $this->encryptDecrypt('dc', $row->FullName);
                }
                if (isset($row->LastName) && $row->LastName) {
                    $lastName = $this->encryptDecrypt('dc', $row->LastName);
                }
                $patientName = trim($firstName . ' ' . $lastName);
                if (empty($patientName)) {
                    $patientName = 'Unknown';
                }

                $appointments[] = [
                    'time' => $time,
                    'prn' => isset($row->PRN) ? $row->PRN : 'N/A',
                    'name' => $patientName,
                    'type' => $type,
                    'status' => $status,
                ];
            }

            return $appointments;
        } catch (Exception $e) {
            error_log('MyDashboard::getUpcomingAppointments error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * GET/POST /api/dashboards/new-dr-dashboard/appointments
     *
     * Returns appointments tab data: metrics, charts, and appointment list.
     * Requires: Authorization: Bearer {JWT_TOKEN}
     * Query/body params (optional): dateRange, startDate, endDate, tenantId
     */
    public function appointments()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }

            // Server-side datatable params
            $page = (int)$this->input->get_post('page');
            if ($page < 1) {
                $page = 1;
            }
            $pageSize = (int)$this->input->get_post('pageSize');
            if ($pageSize < 1) {
                $pageSize = 10;
            }
            if ($pageSize > 200) {
                $pageSize = 200;
            }
            $search = trim((string)$this->input->get_post('search'));
            $sortBy = trim((string)$this->input->get_post('sortBy'));
            $sortDir = trim((string)$this->input->get_post('sortDir'));

            // Resolve doctorId for Group Admin views (guarded)
            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            // Get practitionerId from effective doctorId (may already be PractitionerId)
            $practitionerId = $this->getPractitionerIdByUserId($effectiveDoctorId);
            if ($practitionerId === null || $practitionerId === '') {
                $practitionerId = $effectiveDoctorId;
            }

            $data = $this->getAppointmentsData(
                $userId,
                $practitionerId,
                $tenantId,
                $dateRange,
                $startDate,
                $endDate,
                $page,
                $pageSize,
                $search,
                $sortBy,
                $sortDir
            );

            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::appointments error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            error_log('MyDashboard::appointments trace: ' . $e->getTraceAsString());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::appointments fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Build appointments tab payload: metrics, charts, and appointment list
     * @param int $scopeUserId JWT userId - required when practitionerId is null (Group Admin "all doctors")
     * @param int|null $practitionerId null = "all doctors" (aggregate via scopeUserId)
     */
    private function getAppointmentsData($scopeUserId, $practitionerId = null, $tenantId = null, $dateRange = null, $startDate = null, $endDate = null, $page = 1, $pageSize = 10, $search = '', $sortBy = 'date', $sortDir = 'desc')
    {
        // Calculate date range if not provided (default to last 7 days)
        if (!$startDate || !$endDate) {
            $endDate = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime('-7 days'));
        }

        // Get appointment summary for metrics
        // When practitionerId is null (Group Admin), use scopeUserId + null doctorId for aggregate
        $summary = null;
        try {
            $summary = $this->GroupAdmin_Model->getAppointmentStatusSummary(
                $scopeUserId,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
        } catch (Exception $e) {
            error_log('MyDashboard::getAppointmentsData - getAppointmentStatusSummary error: ' . $e->getMessage());
        }
    //   print_r($summary); exit; // Debug: log raw summary data 
        // Calculate metrics
        $totalCreated = isset($summary['totalAppointments']) ? (int)$summary['totalAppointments'] : 0;
        $completed = isset($summary['totalRegistered']) ? (int)$summary['totalRegistered'] : 0;
        $cancelled = isset($summary['totalCancelled']) ? (int)$summary['totalCancelled'] : 0;
        $noShows = isset($summary['totalNoShow']) ? (int)$summary['totalNoShow'] : 0;
        $pending = max(0, $totalCreated - $completed - $cancelled - $noShows);

        $completionRate = $totalCreated > 0 ? round(($completed / $totalCreated) * 100, 1) : 0;
        $cancellationRate = $totalCreated > 0 ? round(($cancelled / $totalCreated) * 100, 1) : 0;
        $noShowRate = $totalCreated > 0 ? round(($noShows / $totalCreated) * 100, 1) : 0;

        // Get appointment type distribution
        $appointmentTypes = $this->getAppointmentTypeDistribution($scopeUserId, $practitionerId, $tenantId, $startDate, $endDate);

        // Get status trend data (weekly breakdown)
        $statusTrend = $this->getStatusTrendData($scopeUserId, $practitionerId, $tenantId, $startDate, $endDate);

        // Get weekly trend data
        $weeklyTrend = $this->getWeeklyTrendData($scopeUserId, $practitionerId, $tenantId, $startDate, $endDate);

        // Get appointment list (server-side paginated)
        $appointmentsResult = $this->getAppointmentList($scopeUserId, $practitionerId, $tenantId, $startDate, $endDate, $page, $pageSize, $search, $sortBy, $sortDir);
        $appointments = isset($appointmentsResult['rows']) ? $appointmentsResult['rows'] : [];
        $total = isset($appointmentsResult['total']) ? (int)$appointmentsResult['total'] : count($appointments);

        $result = [
            'metrics' => [
                'totalCreated' => $totalCreated,
                'completed' => $completed,
                'cancelled' => $cancelled,
                'noShows' => $noShows,
                'pending' => $pending,
                'completionRate' => $completionRate,
                'cancellationRate' => $cancellationRate,
                'noShowRate' => $noShowRate,
            ],
            'appointmentByType' => [
                'physical' => isset($appointmentTypes['physical']) ? (int)$appointmentTypes['physical'] : 0,
                'teleconsultation' => isset($appointmentTypes['teleconsultation']) ? (int)$appointmentTypes['teleconsultation'] : 0,
            ],
            'statusTrend' => $statusTrend,
            'weeklyTrend' => $weeklyTrend,
            'appointments' => $appointments,
            'pagination' => [
                'total' => $total,
                'page' => (int)$page,
                'pageSize' => (int)$pageSize,
            ],
        ];

        if ($summary !== null && isset($summary['debug']) && isset($summary['debug']['sqlQuery'])) {
            $result['_debug'] = [
                'sqlQuery' => $summary['debug']['sqlQuery'],
                'params' => [
                    'scopeUserId' => $scopeUserId,
                    'practitionerId' => $practitionerId,
                    'tenantId' => $tenantId,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'page' => (int)$page,
                    'pageSize' => (int)$pageSize,
                    'search' => $search,
                    'sortBy' => $sortBy,
                    'sortDir' => $sortDir,
                ],
            ];
        }

        return $result;
    }

    /**
     * Get appointment type distribution (Physical vs Teleconsultation)
     * When practitionerId is null (Group Admin), use scopeUserId for tenant/practitioner scope
     */
    private function getAppointmentTypeDistribution($scopeUserId = null, $practitionerId = null, $tenantId = null, $startDate = null, $endDate = null)
    {
        try {
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql = "SELECT a.AppointmentType, COUNT(*) AS Count FROM Appointment a
                        WHERE a.PractitionerId = ? AND CAST(a.AppointmentDate AS DATE) >= ? AND CAST(a.AppointmentDate AS DATE) <= ? AND a.IsActive = 1";
                $params = [$practitionerId, $startDate, $endDate];
                $tenantIds = $this->parseTenantIds($tenantId);
                if (!empty($tenantIds)) {
                    $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                    $sql .= " AND a.TenantId IN ($ph)";
                    $params = array_merge($params, $tenantIds);
                }
                $sql .= " GROUP BY a.AppointmentType";
            } else {
                $tenantIds = ($tenantId !== null && $tenantId !== '') ? $this->parseTenantIds($tenantId) : (($scopeUserId && method_exists($this->GroupAdmin_Model, 'getTenantIdsForGroupAdmin')) ? $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($scopeUserId) : []);
                $practitionerIds = ($scopeUserId && method_exists($this->GroupAdmin_Model, 'getPractitionerIdsForDropdown')) ? $this->GroupAdmin_Model->getPractitionerIdsForDropdown($scopeUserId, $tenantId) : [];
                if (empty($tenantIds) || empty($practitionerIds)) {
                    return ['physical' => 0, 'teleconsultation' => 0];
                }
                $phT = implode(',', array_fill(0, count($tenantIds), '?'));
                $phP = implode(',', array_fill(0, count($practitionerIds), '?'));
                $params = array_merge($tenantIds, [$startDate, $endDate], $practitionerIds);
                $sql = "SELECT a.AppointmentType, COUNT(*) AS Count FROM Appointment a
                        WHERE a.TenantId IN ($phT) AND CAST(a.AppointmentDate AS DATE) >= ? AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.PractitionerId IN ($phP) AND a.IsActive = 1 GROUP BY a.AppointmentType";
            }

            $query = $this->db->query($sql, $params);
            $result = ['physical' => 0, 'teleconsultation' => 0];

            foreach ($query->result() as $row) {
                $type = strtolower($row->AppointmentType ?? '');
                if (strpos($type, 'tele') !== false || strpos($type, 'video') !== false || strpos($type, 'online') !== false) {
                    $result['teleconsultation'] += (int)$row->Count;
                } else {
                    $result['physical'] += (int)$row->Count;
                }
            }

            return $result;
        } catch (Exception $e) {
            error_log('MyDashboard::getAppointmentTypeDistribution error: ' . $e->getMessage());
            return ['physical' => 0, 'teleconsultation' => 0];
        }
    }

    /**
     * Get status trend data (weekly breakdown by status)
     * When practitionerId is null (Group Admin), use GroupAdmin_Model::getAppointmentTrendByWeekday
     */
    private function getStatusTrendData($scopeUserId = null, $practitionerId = null, $tenantId = null, $startDate = null, $endDate = null)
    {
        try {
            if (!$practitionerId && $scopeUserId && method_exists($this->GroupAdmin_Model, 'getAppointmentTrendByWeekday')) {
                $trend = $this->GroupAdmin_Model->getAppointmentTrendByWeekday($scopeUserId, $tenantId, $startDate, $endDate, null);
                if (!empty($trend['series'])) {
                    $completed = $trend['series'][1]['data'] ?? [0, 0, 0, 0, 0, 0, 0];
                    $cancelled = $trend['series'][2]['data'] ?? [0, 0, 0, 0, 0, 0, 0];
                    $noShow = $trend['series'][3]['data'] ?? [0, 0, 0, 0, 0, 0, 0];
                    return [
                        'labels' => $trend['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        'series' => [
                            ['name' => 'Completed', 'data' => $completed],
                            ['name' => 'Cancelled', 'data' => $cancelled],
                            ['name' => 'No-Show', 'data' => $noShow],
                        ],
                    ];
                }
            }
            if (!$practitionerId) {
                return [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'series' => [
                        ['name' => 'Completed', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                        ['name' => 'Cancelled', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                        ['name' => 'No-Show', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                    ],
                ];
            }

            // Get day of week for each appointment date
            // SQL Server: DATEPART(WEEKDAY, date) returns 1=Sunday, 2=Monday, ..., 7=Saturday (default DATEFIRST=7)
            $sql = "SELECT 
                        DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) AS DayOfWeek,
                        asm.AppointmentStatusCode,
                        asm.AppointmentStatusDescription,
                        COUNT(*) AS Count
                    FROM Appointment a
                    LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.PractitionerId = ?
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";

            $params = [$practitionerId, $startDate, $endDate];

            $tenantIds = $this->parseTenantIds($tenantId);
            if (!empty($tenantIds)) {
                $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                $sql .= " AND a.TenantId IN ($ph)";
                $params = array_merge($params, $tenantIds);
            }

            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)), asm.AppointmentStatusCode, asm.AppointmentStatusDescription
                      ORDER BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE))";

            $query = $this->db->query($sql, $params);

            // Initialize arrays for 7 days
            // SQL Server WEEKDAY: 1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thursday, 6=Friday, 7=Saturday
            // Map to Mon(0), Tue(1), Wed(2), Thu(3), Fri(4), Sat(5), Sun(6)
            $completed = [0, 0, 0, 0, 0, 0, 0];
            $cancelled = [0, 0, 0, 0, 0, 0, 0];
            $noShow = [0, 0, 0, 0, 0, 0, 0];

            foreach ($query->result() as $row) {
                $dayOfWeek = (int)$row->DayOfWeek; // 1=Sunday, 2=Monday, ..., 7=Saturday
                // Map: Sun(1)->6, Mon(2)->0, Tue(3)->1, Wed(4)->2, Thu(5)->3, Fri(6)->4, Sat(7)->5
                $dayIndex = ($dayOfWeek == 1) ? 6 : ($dayOfWeek - 2);

                $statusCode = strtoupper($row->AppointmentStatusCode ?? '');
                $statusDesc = strtoupper($row->AppointmentStatusDescription ?? '');
                $count = (int)$row->Count;

                if (in_array($statusCode, ['OPEN', 'CONFIRMED', 'BOOKED', 'REGISTERED', 'SCHEDULED', 'PENDING']) ||
                    strpos($statusDesc, 'OPEN') !== false ||
                    strpos($statusDesc, 'CONFIRMED') !== false ||
                    strpos($statusDesc, 'BOOKED') !== false ||
                    strpos($statusDesc, 'REGISTERED') !== false) {
                    $completed[$dayIndex] += $count;
                } elseif (in_array($statusCode, ['CANCELLED', 'CANCELED', 'CANCEL']) ||
                          strpos($statusDesc, 'CANCELLED') !== false ||
                          strpos($statusDesc, 'CANCELED') !== false ||
                          strpos($statusDesc, 'CANCEL') !== false) {
                    $cancelled[$dayIndex] += $count;
                } elseif (in_array($statusCode, ['NOSHOW', 'NO-SHOW', 'NO_SHOW', 'MISSED', 'ABSENT']) ||
                          strpos($statusDesc, 'NO SHOW') !== false ||
                          strpos($statusDesc, 'NOSHOW') !== false ||
                          strpos($statusDesc, 'MISSED') !== false ||
                          strpos($statusDesc, 'ABSENT') !== false) {
                    $noShow[$dayIndex] += $count;
                }
            }

            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'series' => [
                    ['name' => 'Completed', 'data' => $completed],
                    ['name' => 'Cancelled', 'data' => $cancelled],
                    ['name' => 'No-Show', 'data' => $noShow],
                ],
            ];
        } catch (Exception $e) {
            error_log('MyDashboard::getStatusTrendData error: ' . $e->getMessage());
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'series' => [
                    ['name' => 'Completed', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                    ['name' => 'Cancelled', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                    ['name' => 'No-Show', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                ],
            ];
        }
    }

    /**
     * Get weekly trend data (total appointments per day)
     * When practitionerId is null (Group Admin), use scopeUserId for tenant/practitioner scope
     */
    private function getWeeklyTrendData($scopeUserId = null, $practitionerId = null, $tenantId = null, $startDate = null, $endDate = null)
    {
        try {
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql = "SELECT DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) AS DayOfWeek, COUNT(*) AS Count
                        FROM Appointment a WHERE a.PractitionerId = ? AND CAST(a.AppointmentDate AS DATE) >= ? AND CAST(a.AppointmentDate AS DATE) <= ? AND a.IsActive = 1";
                $params = [$practitionerId, $startDate, $endDate];
                $tenantIds = $this->parseTenantIds($tenantId);
                if (!empty($tenantIds)) {
                    $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                    $sql .= " AND a.TenantId IN ($ph)";
                    $params = array_merge($params, $tenantIds);
                }
            } else {
                $tenantIds = ($tenantId !== null && $tenantId !== '') ? $this->parseTenantIds($tenantId) : (($scopeUserId && method_exists($this->GroupAdmin_Model, 'getTenantIdsForGroupAdmin')) ? $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($scopeUserId) : []);
                $practitionerIds = ($scopeUserId && method_exists($this->GroupAdmin_Model, 'getPractitionerIdsForDropdown')) ? $this->GroupAdmin_Model->getPractitionerIdsForDropdown($scopeUserId, $tenantId) : [];
                if (empty($tenantIds) || empty($practitionerIds)) {
                    return ['labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], 'data' => [0, 0, 0, 0, 0, 0, 0]];
                }
                $phT = implode(',', array_fill(0, count($tenantIds), '?'));
                $phP = implode(',', array_fill(0, count($practitionerIds), '?'));
                $params = array_merge($tenantIds, [$startDate, $endDate], $practitionerIds);
                $sql = "SELECT DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) AS DayOfWeek, COUNT(*) AS Count
                        FROM Appointment a WHERE a.TenantId IN ($phT) AND CAST(a.AppointmentDate AS DATE) >= ? AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.PractitionerId IN ($phP) AND a.IsActive = 1";
            }

            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) ORDER BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE))";

            $query = $this->db->query($sql, $params);

            $data = [0, 0, 0, 0, 0, 0, 0];

            foreach ($query->result() as $row) {
                $dayOfWeek = (int)$row->DayOfWeek;
                // Map: Sun(1)->6, Mon(2)->0, Tue(3)->1, Wed(4)->2, Thu(5)->3, Fri(6)->4, Sat(7)->5
                $dayIndex = ($dayOfWeek == 1) ? 6 : ($dayOfWeek - 2);
                $data[$dayIndex] = (int)$row->Count;
            }

            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => $data,
            ];
        } catch (Exception $e) {
            error_log('MyDashboard::getWeeklyTrendData error: ' . $e->getMessage());
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [0, 0, 0, 0, 0, 0, 0],
            ];
        }
    }

    /**
     * Get appointment list with details
     * When practitionerId is null (Group Admin), use scopeUserId for tenant/practitioner scope
     */
    private function getAppointmentList($scopeUserId = null, $practitionerId = null, $tenantId = null, $startDate = null, $endDate = null, $page = 1, $pageSize = 10, $search = '', $sortBy = 'date', $sortDir = 'desc')
    {
        try {
            $page = (int)$page;
            if ($page < 1) {
                $page = 1;
            }
            $pageSize = (int)$pageSize;
            if ($pageSize < 1) {
                $pageSize = 10;
            }
            if ($pageSize > 200) {
                $pageSize = 200;
            }
            $startRow = (($page - 1) * $pageSize) + 1;
            $endRow = $startRow + $pageSize - 1;

            $sortMap = [
                'id' => 'a.Id',
                'date' => 'CAST(a.AppointmentDate AS DATE)',
                'time' => 'a.FromTime',
                'patient' => 'p.PRN',
                'patientName' => 'p.PRN',
                'patientPRN' => 'p.PRN',
                'type' => 'a.AppointmentType',
                'status' => 'asm.AppointmentStatusDescription',
                'visitCompleted' => 'asm.AppointmentStatusDescription',
            ];
            $orderByExpr = isset($sortMap[$sortBy]) ? $sortMap[$sortBy] : 'CAST(a.AppointmentDate AS DATE)';
            $orderDir = (strtoupper($sortDir) === 'ASC') ? 'ASC' : 'DESC';

            $baseFrom = " FROM Appointment a
                        LEFT JOIN PatientMaster p ON a.PatientId = p.PatientId
                        LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id";

            $where = " WHERE CAST(a.AppointmentDate AS DATE) >= ? AND CAST(a.AppointmentDate AS DATE) <= ? AND a.IsActive = 1";
            $params = [$startDate, $endDate];

            if ($practitionerId !== null && $practitionerId !== '') {
                $where .= " AND a.PractitionerId = ?";
                $params[] = $practitionerId;
                $tenantIds = $this->parseTenantIds($tenantId);
                if (!empty($tenantIds)) {
                    $ph = implode(',', array_fill(0, count($tenantIds), '?'));
                    $where .= " AND a.TenantId IN ($ph)";
                    $params = array_merge($params, $tenantIds);
                }
            } else {
                $tenantIds = ($tenantId !== null && $tenantId !== '')
                    ? $this->parseTenantIds($tenantId)
                    : (($scopeUserId && method_exists($this->GroupAdmin_Model, 'getTenantIdsForGroupAdmin'))
                        ? $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($scopeUserId)
                        : []);

                $practitionerIds = ($scopeUserId && method_exists($this->GroupAdmin_Model, 'getPractitionerIdsForDropdown'))
                    ? $this->GroupAdmin_Model->getPractitionerIdsForDropdown($scopeUserId, $tenantId)
                    : [];

                if (empty($tenantIds) || empty($practitionerIds)) {
                    return ['rows' => [], 'total' => 0];
                }

                $phT = implode(',', array_fill(0, count($tenantIds), '?'));
                $phP = implode(',', array_fill(0, count($practitionerIds), '?'));

                $where .= " AND a.TenantId IN ($phT) AND a.PractitionerId IN ($phP)";
                $params = array_merge($params, $tenantIds, $practitionerIds);
            }

            if ($search !== null && $search !== '') {
                $where .= " AND (p.PRN LIKE ? OR CAST(a.Id AS VARCHAR(50)) LIKE ? OR a.AppointmentType LIKE ? OR asm.AppointmentStatusDescription LIKE ?)";
                $like = '%' . $search . '%';
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
            }

            $countSql = "SELECT COUNT(1) AS Total" . $baseFrom . $where;
            $countQuery = $this->db->query($countSql, $params);
         //   echo $this->db->last_query(); exit ;
            $total = 0;
            if ($countQuery && $countQuery->num_rows() > 0) {
                $total = (int)$countQuery->row()->Total;
            }

            if ($total === 0) {
                return ['rows' => [], 'total' => 0];
            }

            $selectCols = "a.Id AS AppointmentId, CAST(a.AppointmentDate AS DATE) AS AppointmentDate, a.FromTime,
                        p.PRN, p.FullName, p.LastName, a.AppointmentType, asm.AppointmentStatusDescription AS Status";

            $dataSql = "SELECT AppointmentId, AppointmentDate, FromTime, PRN, FullName, LastName, AppointmentType, Status
                        FROM (
                            SELECT $selectCols,
                                   ROW_NUMBER() OVER (ORDER BY $orderByExpr $orderDir, a.Id DESC) AS RowNum"
                        . $baseFrom . $where .
                        ") AS Paged
                        WHERE Paged.RowNum BETWEEN ? AND ?
                        ORDER BY Paged.RowNum";

            $dataParams = $params;
            $dataParams[] = $startRow;
            $dataParams[] = $endRow;

            $query = $this->db->query($dataSql, $dataParams);
      //      echo $this->db->last_query(); exit ;
            $appointments = [];

            foreach ($query->result() as $row) {
                // Format time
                $time = $row->FromTime;
                if ($time) {
                    if (is_object($time) && method_exists($time, 'format')) {
                        $time = $time->format('H:i:s');
                    }
                    if (strpos($time, ' ') !== false) {
                        $parts = explode(' ', trim($time));
                        $time = (count($parts) > 1 && strpos($parts[1], ':') !== false) ? $parts[1] : $parts[0];
                    }
                    $timeParts = explode(':', $time);
                    if (count($timeParts) >= 2) {
                        $hours = (int)$timeParts[0];
                        $minutes = (int)$timeParts[1];
                        $ampm = $hours >= 12 ? 'PM' : 'AM';
                        $hours12 = $hours > 12 ? $hours - 12 : ($hours == 0 ? 12 : $hours);
                        $time = sprintf('%d:%02d %s', $hours12, $minutes, $ampm);
                    } else {
                        $time = 'N/A';
                    }
                } else {
                    $time = 'N/A';
                }

                // Determine type
                $type = 'Physical';
                if ($row->AppointmentType) {
                    $apptType = strtolower($row->AppointmentType);
                    if (strpos($apptType, 'tele') !== false || strpos($apptType, 'video') !== false || strpos($apptType, 'online') !== false) {
                        $type = 'Teleconsultation';
                    }
                }

                // Determine status
                $status = isset($row->Status) ? $row->Status : 'Pending';
                $statusUpper = strtoupper($status);
                // if (strpos($statusUpper, 'COMPLETED') !== false || strpos($statusUpper, 'REGISTERED') !== false) {
                //     $status = 'Completed';
                // } elseif (strpos($statusUpper, 'CANCELLED') !== false || strpos($statusUpper, 'CANCELED') !== false || strpos($statusUpper, 'CANCEL') !== false) {
                //     $status = 'Cancelled';
                // } elseif (strpos($statusUpper, 'NO SHOW') !== false || strpos($statusUpper, 'NOSHOW') !== false || strpos($statusUpper, 'MISSED') !== false) {
                //     $status = 'No-Show';
                // } elseif (strpos($statusUpper, 'CONFIRMED') !== false || strpos($statusUpper, 'BOOKED') !== false) {
                //     $status = 'Confirmed';
                // } else {
                //     $status = 'Pending';
                // }

                // Determine visit completed
                $visitCompleted = ($status === 'Completed');

                // Decrypt patient name (FullName = FirstName, LastName = LastName)
                $firstName = '';
                $lastName = '';
                if (isset($row->FullName) && $row->FullName) {
                    $firstName = $this->encryptDecrypt('dc', $row->FullName);
                }
                if (isset($row->LastName) && $row->LastName) {
                    $lastName = $this->encryptDecrypt('dc', $row->LastName);
                }
                $patientName = trim($firstName . ' ' . $lastName);
                if (empty($patientName)) {
                    $patientName = 'Unknown';
                }

                $appointments[] = [
                    'id' => 'APT' . str_pad((string)$row->AppointmentId, 6, '0', STR_PAD_LEFT),
                    'date' => isset($row->AppointmentDate) ? date('Y-m-d', strtotime($row->AppointmentDate)) : date('Y-m-d'),
                    'time' => $time,
                    'patientPRN' => isset($row->PRN) ? $row->PRN : 'N/A',
                    'patientName' => $patientName,
                    'type' => $type,
                    'status' => $status,
                    'visitCompleted' => $visitCompleted,
                ];
            }

            return ['rows' => $appointments, 'total' => $total];
        } catch (Exception $e) {
            error_log('MyDashboard::getAppointmentList error: ' . $e->getMessage());
            return ['rows' => [], 'total' => 0];
        }
    }


    /**
     * GET/POST /api/dashboards/new-dr-dashboard/billing
     *
     * Returns billing tab data: metrics, payment methods, charts, recent bills.
     * Requires: Authorization: Bearer {JWT_TOKEN}
     * Query/body params (optional): dateRange, startDate, endDate, tenantId
     */
    public function billing()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }

            // Resolve date range (same as appointments/patient-behavior)
            if (!$startDate || !$endDate) {
                $endDate   = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-7 days'));
            }

            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            // Group Admin with no tenant selected (tenantId null/empty/0 = All Facilities): aggregate across all tenants in ring group (RING.Web pattern)
            // When tenantId is comma-separated (e.g. "1753,1754"), parse to array for IN clause
            $tenantIds = null;
            if ($tenantId !== null && $tenantId !== '' && $tenantId !== 0 && $tenantId !== '0') {
                $parsed = $this->parseTenantIds($tenantId);
                if (!empty($parsed)) {
                    $tenantIds = $parsed;
                }
            }
            if ($tenantIds === null && ($tenantId === null || $tenantId === '' || $tenantId === 0 || $tenantId === '0') && isset($this->GroupAdmin_Model) && method_exists($this->GroupAdmin_Model, 'getTenantIdsForGroupAdmin')) {
                $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($userId);
                if (empty($tenantIds) || !is_array($tenantIds)) {
                    $tenantIds = null;
                }
            }

            $data = $this->getBillingData($effectiveDoctorId, $tenantId, $tenantIds, $dateRange, $startDate, $endDate);
            $practitionerId = null;
            if ($effectiveDoctorId !== null && $effectiveDoctorId !== '') {
                $practitionerId = $this->getPractitionerIdByUserId($effectiveDoctorId);
                if ($practitionerId === null || $practitionerId === '') {
                    $practitionerId = $effectiveDoctorId;
                }
            }
            $billingQueries = $this->Billing_model->getBillingQueries($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
            $data['_debug'] = [
                'params' => [
                    'doctorId' => $effectiveDoctorId,
                    'tenantId' => $tenantId,
                    'tenantIds' => $tenantIds,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ],
                'queries' => $billingQueries,
            ];
            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::billing error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            error_log('MyDashboard::billing trace: ' . $e->getTraceAsString());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::billing fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * GET/POST /api/dashboards/new-dr-dashboard/patient-behavior
     *
     * Returns patient behavior tab data: metrics, trend, engagement, cancellation reasons.
     * Requires: Authorization: Bearer {JWT_TOKEN}
     * Query/body params (optional): dateRange, startDate, endDate, tenantId
     */
    public function patient_behavior()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            $doctorId  = $this->input->get_post('doctorId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }
            if (!$startDate || !$endDate) {
                $endDate   = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-7 days'));
            }

            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            $data = $this->getPatientBehaviorData($userId, $effectiveDoctorId, $tenantId, $dateRange, $startDate, $endDate);
            $queries = $data['queries'] ?? [];
            unset($data['queries']);
            $data['_debug'] = [
                'params' => [
                    'scopeUserId' => $userId,
                    'doctorId' => $effectiveDoctorId,
                    'tenantId' => $tenantId,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ],
                'queries' => $queries,
            ];
            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::patient_behavior error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::patient_behavior fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * GET/POST /api/dashboards/new-dr-dashboard/leave-holidays
     *
     * Returns leave & holidays tab data: summary, doctor/clinic/public leave records, monthly trend.
     * Requires: Authorization: Bearer {JWT_TOKEN}
     * Query/body params (optional): dateRange, startDate, endDate, tenantId
     */
    public function leave_holidays()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            $doctorId  = $this->input->get_post('doctorId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }
            if (!$startDate || !$endDate) {
                $endDate   = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-90 days'));
            }

            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            $data = $this->getLeaveHolidaysData($userId, $tenantId, $effectiveDoctorId, $dateRange, $startDate, $endDate);
            $practitionerId = $this->getPractitionerIdByUserId($effectiveDoctorId ?? $userId);
            if ($practitionerId === null || $practitionerId === '') {
                $practitionerId = $effectiveDoctorId ?? $userId;
            }
            $resolvedTenantId = $tenantId !== null && $tenantId !== '' ? (int) $tenantId : null;
            if ($resolvedTenantId === null) {
                $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($userId);
                $resolvedTenantId = !empty($tenantIds) ? (int) $tenantIds[0] : null;
            }
            $leaveQueries = [];
            if ($resolvedTenantId !== null) {
                $leaveQueries['Usp_GetTenantandUsersLeaveAndHolidays_Tenant'] = "EXEC Usp_GetTenantandUsersLeaveAndHolidays @TenantId = $resolvedTenantId, @DoctorId = " . (int)$practitionerId . ", @Flag = 'Tenant'";
                $leaveQueries['Usp_GetTenantandUsersLeaveAndHolidays_Doctor'] = "EXEC Usp_GetTenantandUsersLeaveAndHolidays @TenantId = $resolvedTenantId, @DoctorId = " . (int)$practitionerId . ", @Flag = 'Doctor'";
            }
            $data['_debug'] = [
                'params' => [
                    'userId' => $userId,
                    'doctorId' => $effectiveDoctorId,
                    'tenantId' => $tenantId,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ],
                'queries' => $leaveQueries,
            ];
            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::leave_holidays error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::leave_holidays fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * GET/POST /api/dashboards/new-dr-dashboard/slot-utilization
     *
     * Returns slot utilization tab data: metrics, trend chart, empty slots (stub).
     * Reuses overview slot logic. Requires: Authorization: Bearer {JWT_TOKEN}
     * Query/body params (optional): dateRange, startDate, endDate, tenantId
     */
    public function slot_utilization()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }

            // Slot utilization requires startDate/endDate for DoctorAvailability; default to last 7 days including today
            if (!$startDate || !$endDate) {
                $endDate   = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            // DoctorAvailability supports max 14 days; cap range to avoid fallback that returns 0 total slots
            $daysDiff = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
            if ($daysDiff > 14) {
                $startDate = date('Y-m-d', strtotime($endDate . ' -13 days'));
            }

            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            $practitionerId = null;
            if ($effectiveDoctorId !== null && $effectiveDoctorId !== '') {
                $practitionerId = $this->getPractitionerIdByUserId($effectiveDoctorId);
                if ($practitionerId === null || $practitionerId === '') {
                    $practitionerId = $effectiveDoctorId;
                }
            }
            $resolvedTenantId = $tenantId !== null && $tenantId !== '' ? (int) $tenantId : null;
            if ($resolvedTenantId === null) {
                $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($userId);
                $resolvedTenantId = !empty($tenantIds) ? (int) $tenantIds[0] : null;
            }

            $effectiveUserDataForName = ($effectiveDoctorId !== null && (string)$effectiveDoctorId === (string)$userId) ? $userData : null;
            $overview = $this->getOverviewData($userId, $effectiveDoctorId, $tenantId, $dateRange, $startDate, $endDate, $effectiveUserDataForName);
            $slot = $overview['slotUtilization'] ?? [];
            $kpis = $overview['kpis'] ?? [];

            $totalSlots = (int) ($slot['periodTotalSlots'] ?? 0);
            $bookedSlots = (int) ($slot['periodBookedSlots'] ?? 0);
            $emptySlots = max(0, $totalSlots - $bookedSlots);
            $utilPct = (float) ($kpis['slotUtilization'] ?? 0);

            $data = [
                'metrics' => [
                    'totalSlots' => $totalSlots,
                    'bookedSlots' => $bookedSlots,
                    'emptySlots' => $emptySlots,
                    'utilizationPercentage' => $utilPct,
                    'avgConsultationDuration' => (int) ($kpis['avgConsultationDuration'] ?? 18),
                    'peakHours' => $this->getPeakHours($practitionerId, $resolvedTenantId, $startDate, $endDate),
                ],
                'slotUtilization' => [
                    'labels' => $slot['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => $slot['data'] ?? [0, 0, 0, 0, 0, 0, 0],
                ],
                'slotHeatmap' => ($resolvedTenantId !== null && $practitionerId !== null)
                    ? $this->getSlotHeatmap($resolvedTenantId, $practitionerId, $startDate, $endDate)
                    : [],
                'emptySlots' => [],
                '_debug' => [
                    'jwtUserId' => $userId,
                    'doctorId' => $effectiveDoctorId,
                    'practitionerId' => $practitionerId,
                    'tenantId' => $resolvedTenantId,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'queries' => [
                        'getPractitionerId' => "SELECT TOP 1 u.LinkUserId FROM Users u WHERE u.UserId = " . (int)$userId,
                        'usp_GetTenantWorkingHours' => $resolvedTenantId !== null
                            ? "EXEC usp_GetTenantWorkingHours @TenantId = " . $resolvedTenantId . ", @ExecFlag = 'CurrentDay', @AppointmentDate = '" . $startDate . "'"
                            : '(tenantId null - resolved from getTenantIdsForGroupAdmin)',
                        'usp_GetDoctorWorkingHours' => $resolvedTenantId !== null
                            ? "EXEC usp_GetDoctorWorkingHours @DoctorId = " . (int)$practitionerId . ", @TenantId = " . $resolvedTenantId . ", @ExecFlag = 'CurrentDay', @AppointmentDate = '" . $startDate . "'"
                            : '(tenantId null)',
                        'usp_GetDoctorBookedslots' => "EXEC usp_GetDoctorBookedslots @DoctorId = " . (int)$practitionerId . ", @AppointmentDate = '" . $startDate . "'",
                    'usp_GetDoctorBookedslots_rawResult' => $this->getBookedSlotsRaw($practitionerId, $startDate),
                    'getAvailability_for_first_date' => ($resolvedTenantId !== null && $practitionerId !== null)
                        ? $this->getAvailabilityDebug($resolvedTenantId, $practitionerId, $startDate)
                        : null,
                    'appointment_table_check' => $this->getAppointmentsForDateDebug($practitionerId, $startDate),
                    'perDayBreakdown' => ($resolvedTenantId !== null && $practitionerId !== null)
                        ? $this->getSlotUtilizationPerDayBreakdown($resolvedTenantId, $practitionerId, $startDate, $endDate)
                        : null,
                        'Usp_GetTenantandUsersLeaveAndHolidays' => $resolvedTenantId !== null
                            ? "EXEC Usp_GetTenantandUsersLeaveAndHolidays @TenantId = " . $resolvedTenantId . ", @DoctorId = " . (int)$practitionerId . ", @Flag = 'Tenant'"
                            : '(tenantId null)',
                    ],
                    'note' => 'DoctorAvailability_model calls these per date in range. Example for first date: ' . $startDate,
                ],
            ];

            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::slot_utilization error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::slot_utilization fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * GET/POST /api/dashboards/new-dr-dashboard/clinical-pattern
     *
     * Returns clinical pattern tab data: metrics, ICD-10 diagnoses, medicines, gender/age distribution, trend.
     * Requires: Authorization: Bearer {JWT_TOKEN}
     * Query/body params (optional): dateRange, startDate, endDate, tenantId, doctorId
     */
    public function clinical_pattern()
    {
        try {
            $token = $this->getAuthToken();
            if (!$token) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Token required'], 401);
                return;
            }

            $userData = $this->validateToken($token);
            if (!$userData) {
                $this->json(['status' => 0, 'message' => 'Unauthorized - Invalid token'], 401);
                return;
            }

            $userId = isset($userData->userId) ? $userData->userId : null;
            if (!$userId) {
                $this->json(['status' => 0, 'message' => 'User ID not found in token'], 400);
                return;
            }

            $dateRange = $this->input->get_post('dateRange');
            $startDate = $this->input->get_post('startDate');
            $endDate   = $this->input->get_post('endDate');
            $tenantId  = $this->input->get_post('tenantId');
            if ($tenantId === null || $tenantId === '') {
                $tenantId = isset($userData->tenantId) ? $userData->tenantId : null;
            }

            if (!$startDate || !$endDate) {
                $endDate   = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-30 days'));
            }

            $effectiveDoctorId = $this->resolveDoctorIdFromRequest($userId, $tenantId);
            $effectiveDoctorId = $this->ensureDoctorIdForDoctorRole($userData, $effectiveDoctorId);

            $practitionerId = null;
            if ($effectiveDoctorId !== null && $effectiveDoctorId !== '') {
                $practitionerId = $this->getPractitionerIdByUserId($effectiveDoctorId);
                if ($practitionerId === null || $practitionerId === '') {
                    $practitionerId = $effectiveDoctorId;
                }
            }

            $topDiagnosesResult = $this->getOverviewTopDiagnoses($userId, $tenantId, $startDate, $endDate, $practitionerId);
            $topDiagnosesData   = isset($topDiagnosesResult['data']) ? $topDiagnosesResult['data'] : [];

            $totalDiagnoses = array_sum(array_column($topDiagnosesData, 'count'));
            $icd10Diagnoses = [];
            foreach ($topDiagnosesData as $row) {
                $pct = $totalDiagnoses > 0 ? round(($row['count'] / $totalDiagnoses) * 100, 1) : 0;
                $icd10Diagnoses[] = [
                    'icd10Code'      => (string) ($row['icd10Code'] ?? ''),
                    'diagnosisName'  => (string) ($row['name'] ?? ''),
                    'count'          => (int) ($row['count'] ?? 0),
                    'percentage'     => $pct,
                ];
            }

            $topCount = !empty($icd10Diagnoses) ? $icd10Diagnoses[0]['count'] : 0;
            $visitCount = $this->GroupAdmin_Model->getVisitCountForPeriod($userId, $tenantId, $startDate, $endDate, $practitionerId);
            $avgDiagnosesPerVisit = ($visitCount > 0 && $totalDiagnoses > 0) ? round($totalDiagnoses / $visitCount, 1) : 0;

            $diagnosisByGender = $this->GroupAdmin_Model->getDiagnosisByGender($userId, $tenantId, $startDate, $endDate, $practitionerId);
            $ageDistribution = $this->GroupAdmin_Model->getDiagnosisAgeDistribution($userId, $tenantId, $startDate, $endDate, $practitionerId);
            $diagnosisTrend = $this->GroupAdmin_Model->getDiagnosisTrendByWeekday($userId, $tenantId, $startDate, $endDate, $practitionerId);
            $medicines = $this->GroupAdmin_Model->getTopPrescribedMedicines($userId, $tenantId, $startDate, $endDate, $practitionerId);

            $data = [
                'metrics' => [
                    'totalDiagnoses'        => (int) $totalDiagnoses,
                    'uniqueICD10Codes'      => $this->GroupAdmin_Model->getUniqueIcd10Count($userId, $tenantId, $startDate, $endDate, $practitionerId),
                    'topDiagnosisCount'    => (int) $topCount,
                    'avgDiagnosesPerVisit' => (float) $avgDiagnosesPerVisit,
                ],
                'icd10Diagnoses'    => $icd10Diagnoses,
                'medicines'          => $medicines,
                'diagnosisByGender'  => $diagnosisByGender,
                'ageDistribution'    => $ageDistribution,
                'diagnosisTrend'     => $diagnosisTrend,
            ];

            $this->json($data);
        } catch (Exception $e) {
            error_log('MyDashboard::clinical_pattern error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error: ' . $e->getMessage()], 500);
        } catch (\Error $e) {
            error_log('MyDashboard::clinical_pattern fatal error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            $this->json(['status' => 0, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Build leave-holidays tab payload from Usp_GetTenantandUsersLeaveAndHolidays.
     * Flag 'Tenant' = clinic/public holidays; Flag 'Doctor' = doctor leaves.
     *
     * QUERY (no date filter - fetches all leaves):
     *   EXEC Usp_GetTenantandUsersLeaveAndHolidays @TenantId = ?, @DoctorId = ?, @Flag = 'Tenant'
     *   EXEC Usp_GetTenantandUsersLeaveAndHolidays @TenantId = ?, @DoctorId = ?, @Flag = 'Doctor'
     *
     * ALTERNATIVE direct table query (Doctor Leave from UsersLeave):
     *   SELECT UL.Id, UL.UserId, UL.TenantId, UL.LeaveDate, UL.LeaveTypeId, UL.Remarks,
     *          UL.StartTime, UL.EndTime, UL.FtTime, UL.TtTime
     *   FROM UsersLeave UL
     *   INNER JOIN Users U ON U.UserId = UL.UserId AND U.LinkUserId = ?
     *   WHERE UL.TenantId = ? AND UL.IsActive = 1
     *   ORDER BY UL.LeaveDate DESC
     */
    private function getLeaveHolidaysData($userId, $tenantId, $doctorId, $dateRange, $startDate, $endDate)
    {
        $practitionerId = $this->getPractitionerIdByUserId($doctorId ?? $userId);
        if ($practitionerId === null || $practitionerId === '') {
            $practitionerId = $userId;
        }
        $resolvedTenantId = $tenantId !== null && $tenantId !== '' ? (int) $tenantId : null;
        if ($resolvedTenantId === null) {
            $tenantIds = $this->GroupAdmin_Model->getTenantIdsForGroupAdmin($userId);
            $resolvedTenantId = !empty($tenantIds) ? (int) $tenantIds[0] : null;
        }

        $doctorLeaves   = [];
        $clinicLeaves   = [];
        $publicHolidays = [];
        $monthlyCount   = [];

        if ($resolvedTenantId !== null) {
            $tenantRows = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
                'TenantId' => $resolvedTenantId,
                'DoctorId' => (int) $practitionerId,
                'Flag'    => 'Tenant'
            ]);
            $doctorRows = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
                'TenantId' => $resolvedTenantId,
                'DoctorId' => (int) $practitionerId,
                'Flag'    => 'Doctor'
            ]);

            foreach ($this->filterAndTransformLeaves($tenantRows, null, null, 'Clinic Leave', 'Public Holiday') as $r) {
                if ($r['type'] === 'Public Holiday') {
                    $publicHolidays[] = $r;
                } else {
                    $clinicLeaves[] = $r;
                }
            }
            foreach ($this->filterAndTransformLeaves($doctorRows, null, null, 'Doctor Leave', null) as $r) {
                $doctorLeaves[] = $r;
            }

            $allRecords = array_merge($doctorLeaves, $clinicLeaves, $publicHolidays);
            foreach ($allRecords as $r) {
                $from = $r['fromDate'] ?? null;
                $to   = $r['toDate'] ?? $from;
                $days = (int) ($r['days'] ?? 1);
                $cur  = strtotime($from);
                $endT = strtotime($to);
                while ($cur <= $endT) {
                    $ym = date('Y-m', $cur);
                    $monthlyCount[$ym] = ($monthlyCount[$ym] ?? 0) + 1;
                    $cur = strtotime('+1 day', $cur);
                }
            }
        }

        $today = date('Y-m-d');
        $upcomingEnd = date('Y-m-d', strtotime('+30 days'));
        $upcomingLeaves = 0;
        foreach (array_merge($doctorLeaves, $clinicLeaves, $publicHolidays) as $r) {
            $from = $r['fromDate'] ?? '';
            if ($from >= $today && $from <= $upcomingEnd) {
                $upcomingLeaves++;
            }
        }

        $monthlyTrend = [];
        if (!empty($monthlyCount)) {
            ksort($monthlyCount);
            foreach ($monthlyCount as $ym => $cnt) {
                $monthlyTrend[] = ['month' => date('M Y', strtotime($ym . '-01')), 'daysOff' => (int) $cnt];
            }
        }
        if (empty($monthlyTrend)) {
            $monthlyTrend = [
                ['month' => 'Jan', 'daysOff' => 0], ['month' => 'Feb', 'daysOff' => 0], ['month' => 'Mar', 'daysOff' => 0],
                ['month' => 'Apr', 'daysOff' => 0], ['month' => 'May', 'daysOff' => 0], ['month' => 'Jun', 'daysOff' => 0],
                ['month' => 'Jul', 'daysOff' => 0],
            ];
        }

        $totalDaysOff = array_sum(array_column(array_merge($doctorLeaves, $clinicLeaves, $publicHolidays), 'days'));

        return [
            'summary' => [
                'totalDoctorLeaves'    => count($doctorLeaves),
                'totalClinicLeaves'     => count($clinicLeaves),
                'totalPublicHolidays'   => count($publicHolidays),
                'upcomingLeaves'       => $upcomingLeaves,
                'totalDaysOff'         => $totalDaysOff,
                'affectedAppointments' => 0,
            ],
            'doctorLeaves'   => $doctorLeaves,
            'clinicLeaves'   => $clinicLeaves,
            'publicHolidays' => $publicHolidays,
            'monthlyTrend'   => $monthlyTrend,
        ];
    }

    private function callProc(string $proc, array $params)
    {
        $pairs = [];
        $values = [];
        foreach ($params as $k => $v) {
            $pairs[] = "@$k = ?";
            $values[] = $v;
        }
        $sql = "EXEC $proc " . implode(', ', $pairs);
        $q = $this->db->query($sql, $values);
        return $q ? $q->result_array() : [];
    }

    /**
     * Filter SP rows and transform to LeaveRecord format.
     * When $startDate/$endDate are null, returns ALL records (no date filter).
     */
    private function filterAndTransformLeaves(array $rows, $startDate, $endDate, $defaultType, $altType)
    {
        $result = [];
        $idx = 0;
        foreach ($rows as $row) {
            $leaveDate = isset($row['LeaveDate']) ? date('Y-m-d', strtotime($row['LeaveDate'])) : null;
            if (!$leaveDate) continue;
            if ($startDate !== null && $endDate !== null && ($leaveDate < $startDate || $leaveDate > $endDate)) {
                continue;
            }
            $fromDate = $leaveDate;
            $toDate   = $leaveDate;
            $days     = 1;
            $endCol   = $row['ToDate'] ?? $row['EndDate'] ?? $row['LeaveEndDate'] ?? null;
            if ($endCol) {
                $toDate = date('Y-m-d', strtotime($endCol));
                $days   = max(1, (int) ((strtotime($toDate) - strtotime($fromDate)) / 86400 + 1));
            }
            $type = $defaultType;
            if ($altType && isset($row['IsHoliday']) && (int)$row['IsHoliday'] === 1) {
                $type = $altType;
            }
            $status = 'Approved';
            if (isset($row['Status'])) {
                $s = strtoupper((string)$row['Status']);
                if (strpos($s, 'PEND') !== false) $status = 'Pending';
                elseif (strpos($s, 'UPCOM') !== false || strpos($s, 'FUTURE') !== false) $status = 'Upcoming';
            } elseif ($fromDate > date('Y-m-d')) {
                $status = 'Upcoming';
            }
            $reason = $row['Remarks'] ?? $row['Reason'] ?? $row['Description'] ?? '-';
            $result[] = [
                'id'             => 'LV' . str_pad((string)(++$idx), 5, '0', STR_PAD_LEFT),
                'type'           => $type,
                'fromDate'       => $fromDate,
                'toDate'         => $toDate,
                'days'           => (int) $days,
                'reason'         => $reason,
                'status'         => $status,
                'affectedSlots'  => isset($row['AffectedSlots']) ? (int)$row['AffectedSlots'] : null,
            ];
        }
        return $result;
    }

    /**
     * Build billing tab payload. Delegates to Billing_model (ChargeEntryHeader + PaymentDetails, RING.Web pattern).
     */
    private function getBillingData($doctorId = null, $tenantId = null, $tenantIds = null, $dateRange = null, $startDate = null, $endDate = null)
    {
        if (!$startDate || !$endDate) {
            $endDate   = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime('-7 days'));
        }

        $practitionerId = null;
        if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0 && $doctorId !== '0') {
            $practitionerId = $this->getPractitionerIdByUserId($doctorId);
            if ($practitionerId === null || $practitionerId === '') {
                $practitionerId = $doctorId;
            }
        }

        return $this->Billing_model->getBillingData($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
    }

    /**
     * Build patient-behavior tab payload.
     * New Patients / Repeat Patients: from GroupAdmin_Model::getVisitStatistics (same logic as overview).
     * Cancellation Rate / No-Show Rate: from GroupAdmin_Model::getAppointmentStatusSummary (same as overview KPIs).
     * @param int $scopeUserId JWT userId - required for tenant scope when doctorId is null (Group Admin "all doctors")
     * @param int|null $doctorId effectiveDoctorId - null = "all doctors"
     */
    private function getPatientBehaviorData($scopeUserId, $doctorId = null, $tenantId = null, $dateRange = null, $startDate = null, $endDate = null)
    {
        if (!$startDate || !$endDate) {
            $endDate   = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime('-7 days'));
        }

        $practitionerId = null;
        if ($doctorId !== null && $doctorId !== '') {
            $practitionerId = $this->getPractitionerIdByUserId($doctorId);
            if ($practitionerId === null || $practitionerId === '') {
                $practitionerId = $doctorId;
            }
        }

        // Use scopeUserId for tenant scope (GroupAdmin_Model needs it for getTenantIdsForGroupAdmin when doctorId is null)
        $userIdForScope = ($scopeUserId !== null && $scopeUserId !== '') ? $scopeUserId : $doctorId;

        $queries = [];

        // Cancellation Rate & No-Show Rate (same source as overview KPIs)
        $totalAppointments = 0;
        $totalCancelled   = 0;
        $totalNoShow      = 0;
        try {
            $summary = $this->GroupAdmin_Model->getAppointmentStatusSummary(
                $userIdForScope,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
            $totalAppointments = (int) (isset($summary['totalAppointments']) ? $summary['totalAppointments'] : 0);
            $totalCancelled    = (int) (isset($summary['totalCancelled']) ? $summary['totalCancelled'] : 0);
            $totalNoShow       = (int) (isset($summary['totalNoShow']) ? $summary['totalNoShow'] : 0);
            if (isset($summary['debug']['sqlQuery'])) {
                $queries['getAppointmentStatusSummary'] = $summary['debug']['sqlQuery'];
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getPatientBehaviorData getAppointmentStatusSummary error: ' . $e->getMessage());
        }
        $cancellationRate = $totalAppointments > 0 ? round(($totalCancelled / $totalAppointments) * 100, 1) : 0;
        $noShowRate       = $totalAppointments > 0 ? round(($totalNoShow / $totalAppointments) * 100, 1) : 0;

        // New Patients & Repeat Patients (same source as visit statistics / overview-style)
        $newPatientCount   = 0;
        $repeatPatientCount = 0;
        $totalUniquePatients = 0;
        $totalVisits       = 0;
        try {
            $visitStats = $this->GroupAdmin_Model->getVisitStatistics(
                $userIdForScope,
                $startDate,
                $endDate,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $practitionerId
            );
            $newPatientCount     = (int) (isset($visitStats['totalNewPatients']) ? $visitStats['totalNewPatients'] : 0);
            $repeatPatientCount  = (int) (isset($visitStats['totalRepeatPatients']) ? $visitStats['totalRepeatPatients'] : 0);
            $totalUniquePatients = (int) (isset($visitStats['totalUniquePatients']) ? $visitStats['totalUniquePatients'] : 0);
            $totalVisits         = (int) (isset($visitStats['totalVisits']) ? $visitStats['totalVisits'] : 0);
            if (isset($visitStats['_sqlQuery'])) {
                $queries['getVisitStatistics'] = $visitStats['_sqlQuery'];
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getPatientBehaviorData getVisitStatistics error: ' . $e->getMessage());
        }

        $totalPatientsInPeriod = $newPatientCount + $repeatPatientCount;
        $repeatPatientPercentage = $totalPatientsInPeriod > 0
            ? round(($repeatPatientCount / $totalPatientsInPeriod) * 100, 1)
            : 0;
        $totalPatients = $totalUniquePatients > 0 ? $totalUniquePatients : $totalPatientsInPeriod;
        $avgVisitsPerPatient = $totalUniquePatients > 0 && $totalVisits > 0
            ? round($totalVisits / $totalUniquePatients, 1)
            : 0;
        $patientRetentionRate = $totalUniquePatients > 0 && $repeatPatientCount >= 0
            ? round(($repeatPatientCount / $totalUniquePatients) * 100, 1)
            : 0;

        // New vs Repeat Patient Trend by weekday + Cancellation vs No-Show by weekday (dynamic)
        $trendData = $this->getPatientBehaviorTrendByWeekday($userIdForScope, $tenantId, $practitionerId, $startDate, $endDate, $queries);

        // Patient Engagement Distribution by visit-count bucket (dynamic)
        $engagementDistribution = [];
        $engagementSql = null;
        try {
            $engResult = $this->GroupAdmin_Model->getEngagementDistribution(
                $userIdForScope,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
            if (isset($engResult['_data'])) {
                $engagementDistribution = $engResult['_data'];
                if (!empty($engResult['_sqlQuery'])) {
                    $queries['getEngagementDistribution'] = $engResult['_sqlQuery'];
                }
            } else {
                $engagementDistribution = $engResult;
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getPatientBehaviorData getEngagementDistribution error: ' . $e->getMessage());
        }
        if (empty($engagementDistribution)) {
            $engagementDistribution = [
                ['visitCount' => '1 visit', 'patients' => 0, 'percentage' => 0],
                ['visitCount' => '2-3 visits', 'patients' => 0, 'percentage' => 0],
                ['visitCount' => '4-5 visits', 'patients' => 0, 'percentage' => 0],
                ['visitCount' => '6-10 visits', 'patients' => 0, 'percentage' => 0],
                ['visitCount' => '10+ visits', 'patients' => 0, 'percentage' => 0],
            ];
        }

        $cancellationReasonsResult = $this->getPatientBehaviorCancellationReasonsWithQuery($userIdForScope, $tenantId, $startDate, $endDate, $practitionerId);
        $cancellationReasons = $cancellationReasonsResult['data'];
        if (!empty($cancellationReasonsResult['sqlQuery'])) {
            $queries['getCancellationReasons'] = $cancellationReasonsResult['sqlQuery'];
        }

        return [
            'metrics' => [
                'newPatientCount'         => $newPatientCount,
                'repeatPatientCount'      => $repeatPatientCount,
                'repeatPatientPercentage' => $repeatPatientPercentage,
                'cancellationRate'         => $cancellationRate,
                'noShowRate'              => $noShowRate,
                'totalPatients'           => $totalPatients,
                'avgVisitsPerPatient'     => $avgVisitsPerPatient,
                'patientRetentionRate'    => $patientRetentionRate,
            ],
            'trendData' => $trendData,
            'engagementDistribution' => $engagementDistribution,
            'cancellationReasons' => $cancellationReasons,
            'queries' => $queries,
        ];
    }

    /**
     * Build New vs Repeat Patient Trend by weekday for the chart.
     * SQL Server DATEPART(WEEKDAY): 1=Sun, 2=Mon, 3=Tue, 4=Wed, 5=Thu, 6=Fri, 7=Sat.
     * Frontend order: Mon, Tue, Wed, Thu, Fri, Sat, Sun.
     */
    private function getPatientBehaviorTrendByWeekday($userId, $tenantId, $practitionerId, $startDate, $endDate, array &$queries = [])
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $dayToIndex = [2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 => 5, 1 => 6]; // weekday -> chart index

        $newByDay = [0, 0, 0, 0, 0, 0, 0];
        $repeatByDay = [0, 0, 0, 0, 0, 0, 0];

        try {
            $rowsResult = $this->GroupAdmin_Model->getVisitStatisticsByWeekday(
                $userId,
                $startDate,
                $endDate,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $practitionerId
            );
            if (!empty($rowsResult['_sqlQuery'])) {
                $queries['getVisitStatisticsByWeekday'] = $rowsResult['_sqlQuery'];
            }
            $rows = isset($rowsResult['_data']) ? $rowsResult['_data'] : $rowsResult;
            foreach ($rows as $r) {
                $idx = isset($dayToIndex[$r['dayOfWeek']]) ? $dayToIndex[$r['dayOfWeek']] : null;
                if ($idx !== null) {
                    $newByDay[$idx] = $r['newPatients'];
                    $repeatByDay[$idx] = $r['repeatPatients'];
                }
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getPatientBehaviorTrendByWeekday error: ' . $e->getMessage());
        }

        $cancelByDay = [0, 0, 0, 0, 0, 0, 0];
        $noShowByDay = [0, 0, 0, 0, 0, 0, 0];
        try {
            $statusResult = $this->GroupAdmin_Model->getAppointmentStatusByWeekday(
                $userId,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
            if (!empty($statusResult['_sqlQuery'])) {
                $queries['getAppointmentStatusByWeekday'] = $statusResult['_sqlQuery'];
            }
            $statusRows = isset($statusResult['_data']) ? $statusResult['_data'] : $statusResult;
            foreach ($statusRows as $r) {
                $idx = isset($dayToIndex[$r['dayOfWeek']]) ? $dayToIndex[$r['dayOfWeek']] : null;
                if ($idx !== null) {
                    $cancelByDay[$idx] = (int) ($r['cancelled'] ?? 0);
                    $noShowByDay[$idx] = (int) ($r['noShow'] ?? 0);
                }
            }
        } catch (Exception $e) {
            error_log('MyDashboard::getPatientBehaviorTrendByWeekday getAppointmentStatusByWeekday error: ' . $e->getMessage());
        }

        $trendData = [];
        for ($i = 0; $i < 7; $i++) {
            $trendData[] = [
                'date'           => $labels[$i],
                'newPatients'    => $newByDay[$i],
                'repeatPatients' => $repeatByDay[$i],
                'cancellations'  => $cancelByDay[$i],
                'noShows'        => $noShowByDay[$i],
            ];
        }
        return $trendData;
    }

    /**
     * Get top cancellation reasons for patient-behavior tab (dynamic from Appointment.AppointmentReason).
     */
    private function getPatientBehaviorCancellationReasons($userId, $tenantId, $startDate, $endDate, $practitionerId)
    {
        $r = $this->getPatientBehaviorCancellationReasonsWithQuery($userId, $tenantId, $startDate, $endDate, $practitionerId);
        return $r['data'];
    }

    private function getPatientBehaviorCancellationReasonsWithQuery($userId, $tenantId, $startDate, $endDate, $practitionerId)
    {
        try {
            $result = $this->GroupAdmin_Model->getCancellationReasons(
                $userId,
                $tenantId !== null && $tenantId !== '' ? $tenantId : null,
                $startDate,
                $endDate,
                $practitionerId
            );
            return [
                'data' => isset($result['_data']) ? $result['_data'] : $result,
                'sqlQuery' => $result['_sqlQuery'] ?? null,
            ];
        } catch (Exception $e) {
            error_log('MyDashboard::getPatientBehaviorCancellationReasons error: ' . $e->getMessage());
            return ['data' => [], 'sqlQuery' => null];
        }
    }

    /**
     * Encrypt/Decrypt helper method
     * @param string $type 'en' for encrypt, 'dc' for decrypt
     * @param string $name The string to encrypt/decrypt
     * @return string
     */
    private function encryptDecrypt($type, $name)
    {
        if (empty($name)) {
            return $name;
        }

        try {
            if ($type == 'en') {
                return EncDecAlgorithm::encrypt($name);
            } else {
                return EncDecAlgorithm::decrypt($name);
            }
        } catch (Exception $e) {
            error_log('MyDashboard::encryptDecrypt error: ' . $e->getMessage());
            return $name;
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
