<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Group Admin Model
 * 
 * Handles Group Admin related database operations:
 * - Get Group Admin users
 * - Get appointments for Group Admin users
 * - Calculate weekly statistics
 * - Get appointment status summaries
 */
class GroupAdmin_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Resolve tenant IDs from tenantId param.
     * Supports: single int, comma-separated string (e.g. "1753,1754"), or null.
     * When null/empty, returns getTenantIdsForGroupAdmin($userId).
     *
     * @param int $userId Group Admin User ID
     * @param int|string|null $tenantId Single tenant ID, comma-separated IDs, or null
     * @return array Array of integer tenant IDs
     */
    private function resolveTenantIds($userId, $tenantId = null)
    {
        if ($tenantId === null || $tenantId === '') {
            return $this->getTenantIdsForGroupAdmin($userId);
        }
        $tenantIdStr = (string) $tenantId;
        if (strpos($tenantIdStr, ',') !== false) {
            $ids = array_map('intval', array_filter(explode(',', $tenantIdStr)));
            return array_values(array_filter($ids));
        }
        return [(int) $tenantId];
    }

    /**
     * Get all Group Admin users
     * 
     * @param int|null $ringGroupId Filter by Ring Group ID
     * @param int|null $tenantId Filter by Tenant ID
     * @return array
     */
    public function getGroupAdminUsers($ringGroupId = null, $tenantId = null)
    {
        try {
            $sql = "SELECT DISTINCT
                        u.UserId,
                        u.Username,
                        u.DisplayName,
                        u.Email,
                        u.PhoneNumber,
                        u.IsActive,
                        ut.TenantId,
                        t.TenantName,
                        t.TenantCode,
                        rgt.RingGroupId,
                        rgm.RingGroupName,
                        r.RoleName,
                        r.RoleId
                    FROM Users u
                    INNER JOIN UserRoles ur ON u.UserId = ur.UserId
                    INNER JOIN Roles r ON ur.RoleId = r.RoleId
                    LEFT JOIN UserTenants ut ON u.UserId = ut.UserId
                    LEFT JOIN RingGroupTenants rgt ON ut.TenantId = rgt.TenantId
                    LEFT JOIN RingGroupMaster rgm ON rgt.RingGroupId = rgm.RingGroupMasterId
                    LEFT JOIN Tenants t ON ut.TenantId = t.TenantId
                    WHERE r.RoleName = 'Group Admin'
                        AND u.IsActive = 1
                        AND r.IsActive = 1";
            
            $params = [];
            
            if ($ringGroupId !== null) {
                $sql .= " AND rgt.RingGroupId = ?";
                $params[] = $ringGroupId;
            }
            
            if ($tenantId !== null) {
                $sql .= " AND ut.TenantId = ?";
                $params[] = $tenantId;
            }
            
            $sql .= " ORDER BY u.DisplayName, t.TenantName";
            
            $query = $this->db->query($sql, $params);
            
            return $query->result_array();
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getGroupAdminUsers error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if a user is a Group Admin
     * 
     * @param int $userId User ID to check
     * @return bool
     */
    public function isGroupAdmin($userId)
    {
        try {
            $sql = "SELECT COUNT(*) as RoleCount
                    FROM UserRoles ur
                    INNER JOIN Roles r ON ur.RoleId = r.RoleId
                    WHERE ur.UserId = ?
                        AND r.RoleName = 'Group Admin'
                        AND r.IsActive = 1";
            
            $query = $this->db->query($sql, [$userId]);
            
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->RoleCount > 0;
            }
            
            return false;
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::isGroupAdmin error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get weekly appointments for a Group Admin user
     * 
     * @param int $userId Group Admin User ID
     * @return array
     */
    public function getWeeklyAppointments($userId, $tenantId = null, $doctorId = null)
    {
        try {
            // Calculate this week (Monday to Sunday)
            $today = date('Y-m-d');
            $dayOfWeek = date('w', strtotime($today)); // 0 = Sunday, 1 = Monday, etc.
            
            // Calculate Monday of this week
            if ($dayOfWeek == 0) {
                // If today is Sunday, go back 6 days
                $weekStart = date('Y-m-d', strtotime($today . ' -6 days'));
            } else {
                // Go back (dayOfWeek - 1) days to get Monday
                $weekStart = date('Y-m-d', strtotime($today . ' -' . ($dayOfWeek - 1) . ' days'));
            }
            
            // Calculate Sunday of this week
            $weekEnd = date('Y-m-d', strtotime($weekStart . ' +6 days'));
            
            // If specific tenantId is provided (single or comma-separated), use it
            // Otherwise, get all tenant IDs for this Group Admin user's ring groups
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [
                    'totalAppointments' => 0,
                    'weekStart' => $weekStart,
                    'weekEnd' => $weekEnd,
                    'userId' => $userId,
                    'numberOfTenants' => 0
                ];
            }
            
            // Build IN clause
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            $sql = "SELECT COUNT(*) AS TotalAppointments
                    FROM Appointment a
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            
            $params = array_merge($tenantIds, [$weekStart, $weekEnd]);
            
            // Add doctor filter if provided
            if ($doctorId !== null) {
                $sql .= " AND a.PractitionerId = ?";
                $params[] = $doctorId;
            }
            
            $query = $this->db->query($sql, $params);
            
            $totalAppointments = 0;
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $totalAppointments = (int)$row->TotalAppointments;
            }
            
            return [
                'totalAppointments' => $totalAppointments,
                'weekStart' => $weekStart,
                'weekEnd' => $weekEnd,
                'userId' => $userId,
                'numberOfTenants' => count($tenantIds)
            ];
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getWeeklyAppointments error: " . $e->getMessage());
            return [
                'totalAppointments' => 0,
                'weekStart' => date('Y-m-d'),
                'weekEnd' => date('Y-m-d'),
                'userId' => $userId,
                'numberOfTenants' => 0,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get daily appointment counts for the last 7 days
     * Returns appointment counts grouped by date for trend charts
     * 
     * @param int $userId Group Admin User ID
     * @param int|null $tenantId Optional: Filter by specific tenant/facility
     * @param int $days Number of days to retrieve (default: 7)
     * @return array Array with date and count for each day
     */
    public function getDailyAppointmentHistory($userId, $tenantId = null, $days = 7, $doctorId = null)
    {
        try {
            // If specific tenantId is provided (single or comma-separated), use it
            // Otherwise, get all tenant IDs for this Group Admin user's ring groups
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [];
            }
            
            // Calculate date range (last N days including today)
            $endDate = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime("-$days days"));
            
            // Build IN clause
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            // Get daily counts grouped by date
            $sql = "SELECT 
                        CAST(a.AppointmentDate AS DATE) AS AppointmentDate,
                        COUNT(*) AS Count
                    FROM Appointment a
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            
            // Add doctor filter if provided
            if ($doctorId !== null) {
                $sql .= " AND a.PractitionerId = ?";
                $params[] = $doctorId;
            }
            
            $sql .= " GROUP BY CAST(a.AppointmentDate AS DATE)
                      ORDER BY CAST(a.AppointmentDate AS DATE) ASC";
            
            $query = $this->db->query($sql, $params);
            
            $dailyData = [];
            $resultArray = $query->result_array();
            
            // Create a map of dates to counts
            $dateCountMap = [];
            foreach ($resultArray as $row) {
                $dateCountMap[$row['AppointmentDate']] = (int)$row['Count'];
            }
            
            // Fill in all days in the range (including days with 0 appointments)
            $currentDate = strtotime($startDate);
            $endTimestamp = strtotime($endDate);
            
            while ($currentDate <= $endTimestamp) {
                $dateStr = date('Y-m-d', $currentDate);
                $dailyData[] = [
                    'date' => $dateStr,
                    'count' => isset($dateCountMap[$dateStr]) ? $dateCountMap[$dateStr] : 0
                ];
                $currentDate = strtotime('+1 day', $currentDate);
            }
            
            return $dailyData;
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDailyAppointmentHistory error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get appointment status summary for a Group Admin user
     * 
     * @param int $userId Group Admin User ID
     * @param int|null $tenantId Optional: Filter by specific tenant/facility
     * @param string|null $startDate Optional: Start date for date range (format: YYYY-MM-DD)
     * @param string|null $endDate Optional: End date for date range (format: YYYY-MM-DD)
     * @return array
     */
    public function getAppointmentStatusSummary($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            // Normalize date inputs (remove time component if present, ensure YYYY-MM-DD format)
            // Handle empty strings, null, or invalid dates
            if ($startDate && $startDate !== '' && $startDate !== 'null') {
                $startDateParsed = strtotime($startDate);
                if ($startDateParsed !== false) {
                    $startDate = date('Y-m-d', $startDateParsed);
                } else {
                    $startDate = null;
                }
            } else {
                $startDate = null;
            }
            
            if ($endDate && $endDate !== '' && $endDate !== 'null') {
                $endDateParsed = strtotime($endDate);
                if ($endDateParsed !== false) {
                    $endDate = date('Y-m-d', $endDateParsed);
                } else {
                    $endDate = null;
                }
            } else {
                $endDate = null;
            }
            
            // Calculate date range if not provided (default to this week)
            if (!$startDate || !$endDate) {
                $today = date('Y-m-d');
                $dayOfWeek = date('w', strtotime($today)); // 0 = Sunday, 1 = Monday, etc.
                
                if ($dayOfWeek == 0) {
                    // If today is Sunday, go back 6 days to get Monday
                    $startDate = date('Y-m-d', strtotime($today . ' -6 days'));
                } else {
                    // Go back (dayOfWeek - 1) days to get Monday
                    $startDate = date('Y-m-d', strtotime($today . ' -' . ($dayOfWeek - 1) . ' days'));
                }
                
                $endDate = date('Y-m-d', strtotime($startDate . ' +6 days'));
            }
            
            // Log date range for debugging
            error_log("GroupAdmin_Model::getAppointmentStatusSummary - UserId: $userId, StartDate: $startDate, EndDate: $endDate, TenantId: " . ($tenantId ?? 'null') . ", DoctorId: " . ($doctorId ?? 'null'));
            
            // If specific tenantId is provided (single or comma-separated), use it
            // Otherwise, get all tenant IDs for this Group Admin user's ring groups
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [
                    'totalAppointments' => 0,
                    'totalRegistered' => 0,
                    'totalCancelled' => 0,
                    'totalNoShow' => 0,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'userId' => $userId
                ];
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            // Doctor filter: specific doctor OR all doctors from dropdown list
            $practitionerIds = [];
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $practitionerIds = [(int)$doctorId];
            } else {
                // "All doctors" = filter by doctors in dropdown list (same as getDoctorsByTenant)
                $practitionerIds = $this->getPractitionerIdsForDropdown($userId, $tenantId);
            }
            
            // Get appointments with status
            $sql = "SELECT 
                        a.AppointmentStatusId,
                        asm.AppointmentStatusCode,
                        asm.AppointmentStatusDescription,
                        COUNT(*) AS Count
                    FROM Appointment a
                    INNER JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            
            // Add doctor filter: PractitionerId IN (dropdown doctors) or = single doctor
            if (!empty($practitionerIds)) {
                $ph = implode(',', array_fill(0, count($practitionerIds), '?'));
                $sql .= " AND a.PractitionerId IN ($ph)";
                $params = array_merge($params, $practitionerIds);
            } else {
                // No doctors in dropdown -> return empty
                return [
                    'totalAppointments' => 0,
                    'totalRegistered' => 0,
                    'totalCancelled' => 0,
                    'totalNoShow' => 0,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'userId' => $userId
                ];
            }
            
            $sql .= " GROUP BY a.AppointmentStatusId, asm.AppointmentStatusCode, asm.AppointmentStatusDescription";
            
            // Build SQL query string with actual parameter values for debugging
            $debugSql = $sql;
            // Replace IN clause placeholders with actual tenant IDs
            $debugSql = str_replace('IN (' . $placeholders . ')', 'IN (' . implode(',', $tenantIds) . ')', $debugSql);
            // Replace date placeholders
            $debugSql = str_replace('>= ?', ">= '" . $startDate . "'", $debugSql);
            $debugSql = str_replace('<= ?', "<= '" . $endDate . "'", $debugSql);
            // Replace PractitionerId IN placeholder for debug
            if (!empty($practitionerIds)) {
                $ph = implode(',', array_fill(0, count($practitionerIds), '?'));
                $debugSql = str_replace("a.PractitionerId IN ($ph)", 'a.PractitionerId IN (' . implode(',', $practitionerIds) . ')', $debugSql);
            }
            
            // First, verify if there are any appointments in this date range (for debugging)
            $verifySql = "SELECT COUNT(*) AS TotalCount, 
                          MIN(CAST(a.AppointmentDate AS DATE)) AS MinDate, 
                          MAX(CAST(a.AppointmentDate AS DATE)) AS MaxDate
                          FROM Appointment a
                          WHERE a.TenantId IN ($placeholders)
                          AND CAST(a.AppointmentDate AS DATE) >= ?
                          AND CAST(a.AppointmentDate AS DATE) <= ?
                          AND a.IsActive = 1";
            $verifyParams = array_merge($tenantIds, [$startDate, $endDate]);
            if (!empty($practitionerIds)) {
                $ph = implode(',', array_fill(0, count($practitionerIds), '?'));
                $verifySql .= " AND a.PractitionerId IN ($ph)";
                $verifyParams = array_merge($verifyParams, $practitionerIds);
            }
            $verifyQuery = $this->db->query($verifySql, $verifyParams);
            $verifyResult = $verifyQuery->row();
            error_log("GroupAdmin_Model::getAppointmentStatusSummary - Verification: Total appointments in range: " . ($verifyResult->TotalCount ?? 0) . ", MinDate: " . ($verifyResult->MinDate ?? 'N/A') . ", MaxDate: " . ($verifyResult->MaxDate ?? 'N/A'));
            
            $query = $this->db->query($sql, $params);
            
            // Log the actual SQL query being executed for debugging
            error_log("GroupAdmin_Model::getAppointmentStatusSummary - SQL Query: " . $debugSql);
            error_log("GroupAdmin_Model::getAppointmentStatusSummary - Query Parameters: " . json_encode($params));
            
            $totalAppointments = 0;
            $totalRegistered = 0;
            $totalCancelled = 0;
            $totalNoShow = 0;
            
            $rowCount = 0;
            foreach ($query->result() as $row) {
                $rowCount++;
                $count = (int)$row->Count;
                $totalAppointments += $count;
                
                $statusCode = strtoupper($row->AppointmentStatusCode);
                $statusDesc = strtoupper($row->AppointmentStatusDescription);
                
                error_log("GroupAdmin_Model::getAppointmentStatusSummary - Row $rowCount: StatusCode=$statusCode, StatusDesc=$statusDesc, Count=$count");
                
                // Categorize by status
                if (in_array($statusCode, ['OPEN', 'CONFIRMED', 'BOOKED', 'REGISTERED', 'SCHEDULED', 'PENDING']) ||
                    strpos($statusDesc, 'OPEN') !== false ||
                    strpos($statusDesc, 'CONFIRMED') !== false ||
                    strpos($statusDesc, 'BOOKED') !== false ||
                    strpos($statusDesc, 'REGISTERED') !== false) {
                    $totalRegistered += $count;
                } elseif (in_array($statusCode, ['CANCELLED', 'CANCELED', 'CANCEL']) ||
                          strpos($statusDesc, 'CANCELLED') !== false ||
                          strpos($statusDesc, 'CANCELED') !== false ||
                          strpos($statusDesc, 'CANCEL') !== false) {
                    $totalCancelled += $count;
                } elseif (in_array($statusCode, ['NOSHOW', 'NO-SHOW', 'NO_SHOW', 'MISSED', 'ABSENT']) ||
                          strpos($statusDesc, 'NO SHOW') !== false ||
                          strpos($statusDesc, 'NOSHOW') !== false ||
                          strpos($statusDesc, 'MISSED') !== false ||
                          strpos($statusDesc, 'ABSENT') !== false) {
                    $totalNoShow += $count;
                }
            }
            
            error_log("GroupAdmin_Model::getAppointmentStatusSummary - Result: Total=$totalAppointments, Registered=$totalRegistered, Cancelled=$totalCancelled, NoShow=$totalNoShow");
            
            return [
                'totalAppointments' => $totalAppointments,
                'totalRegistered' => $totalRegistered,
                'totalCancelled' => $totalCancelled,
                'totalNoShow' => $totalNoShow,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'userId' => $userId,
                'debug' => [
                    'sqlQuery' => $debugSql,
                    'tenantIds' => $tenantIds,
                    'paramCount' => count($params),
                    'startDate' => $startDate,
                    'endDate' => $endDate
                ]
            ];
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getAppointmentStatusSummary error: " . $e->getMessage());
            return [
                'totalAppointments' => 0,
                'totalRegistered' => 0,
                'totalCancelled' => 0,
                'totalNoShow' => 0,
                'startDate' => $startDate ?? date('Y-m-d'),
                'endDate' => $endDate ?? date('Y-m-d'),
                'userId' => $userId,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get average consultation duration (minutes) from completed appointments.
     * Uses FromTime and ToTime; same tenant/practitioner scope as getAppointmentStatusSummary.
     * Returns 0 if no valid appointments with duration.
     */
    public function getAvgConsultationDuration($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-7 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return 0;
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $practitionerIds = [(int)$doctorId];
            } else {
                $practitionerIds = $this->getPractitionerIdsForDropdown($userId, $tenantId);
            }
            if (empty($practitionerIds)) {
                return 0;
            }
            $ph = implode(',', array_fill(0, count($practitionerIds), '?'));
            $params = array_merge($params, $practitionerIds);
            $sql = "SELECT ISNULL(AVG(DATEDIFF(MINUTE, a.FromTime, a.ToTime)), 0) AS AvgMinutes
                    FROM Appointment a
                    INNER JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1
                        AND a.FromTime IS NOT NULL
                        AND a.ToTime IS NOT NULL
                        AND CAST(a.ToTime AS TIME) >= CAST(a.FromTime AS TIME)
                        AND (
                            UPPER(asm.AppointmentStatusCode) IN ('OPEN', 'CONFIRMED', 'BOOKED', 'REGISTERED', 'SCHEDULED', 'PENDING')
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%OPEN%'
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%CONFIRMED%'
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%BOOKED%'
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%REGISTERED%'
                        )
                        AND a.PractitionerId IN ($ph)";
            $query = $this->db->query($sql, $params);
            $row = $query ? $query->row() : null;
            $avg = $row ? (float) $row->AvgMinutes : 0;
            return (int) round($avg);
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getAvgConsultationDuration error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get detailed appointments list for a Group Admin user
     * 
     * @param int $userId Group Admin User ID
     * @param string|null $startDate Start date (default: Monday of this week)
     * @param string|null $endDate End date (default: Sunday of this week)
     * @return array
     */
    public function getDetailedAppointments($userId, $startDate = null, $endDate = null, $tenantId = null)
    {
        try {
            // Calculate date range if not provided
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
            
            // If specific tenantId is provided (single or comma-separated), use it
            // Otherwise, get all tenant IDs for this Group Admin user's ring groups
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [];
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            $sql = "SELECT 
                        a.Id AS AppointmentId,
                        a.AppointmentNo,
                        CAST(a.AppointmentDate AS DATE) AS AppointmentDate,
                        a.FromTime,
                        a.ToTime,
                        a.TenantId,
                        t.TenantName,
                        t.TenantCode,
                        a.PatientId,
                        p.FullName AS PatientName,
                        p.PRN AS PatientPRN,
                        a.PractitionerId,
                        pm.PractitionerName AS DoctorName,
                        pm.PractitionerCode AS DoctorCode,
                        a.AppointmentStatusId,
                        asm.AppointmentStatusDescription,
                        a.AppointmentReason,
                        a.Remarks,
                        rgm.RingGroupMasterId AS RingGroupId,
                        rgm.RingGroupName
                    FROM Appointment a
                    INNER JOIN Tenants t ON a.TenantId = t.TenantId
                    LEFT JOIN PatientMaster p ON a.PatientId = p.PatientId
                    LEFT JOIN PractitionerMaster pm ON a.PractitionerId = pm.Id
                    LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    LEFT JOIN RingGroupTenants rgt ON a.TenantId = rgt.TenantId
                    LEFT JOIN RingGroupMaster rgm ON rgt.RingGroupId = rgm.RingGroupMasterId
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1
                    ORDER BY a.AppointmentDate, a.FromTime, t.TenantName";
            
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            
            $query = $this->db->query($sql, $params);
            
            return $query->result_array();
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDetailedAppointments error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all tenant IDs for a Group Admin user's ring groups
     * 
     * @param int $userId Group Admin User ID
     * @return array Array of tenant IDs
     */
    public function getTenantIdsForGroupAdmin($userId)
    {
        try {
            // Step 1: Get TenantId(s) for the Group Admin user
            $sql1 = "SELECT DISTINCT ut.TenantId
                     FROM UserTenants ut
                     WHERE ut.UserId = ?";
            
            $query1 = $this->db->query($sql1, [$userId]);
            $userTenantIds = [];
            
            foreach ($query1->result() as $row) {
                $userTenantIds[] = $row->TenantId;
            }
            
            if (empty($userTenantIds)) {
                return [];
            }
            
            // Step 2: Get RingGroupIds for those tenants
            $placeholders1 = implode(',', array_fill(0, count($userTenantIds), '?'));
            
            $sql2 = "SELECT DISTINCT rgt.RingGroupId
                     FROM RingGroupTenants rgt
                     WHERE rgt.TenantId IN ($placeholders1)";
            
            $query2 = $this->db->query($sql2, $userTenantIds);
            $ringGroupIds = [];
            
            foreach ($query2->result() as $row) {
                $ringGroupIds[] = $row->RingGroupId;
            }
            
            if (empty($ringGroupIds)) {
                return [];
            }
            
            // Step 3: Get all TenantIds in those RingGroups
            $placeholders2 = implode(',', array_fill(0, count($ringGroupIds), '?'));
            
            $sql3 = "SELECT DISTINCT rgt.TenantId
                     FROM RingGroupTenants rgt
                     WHERE rgt.RingGroupId IN ($placeholders2)";
            
            $query3 = $this->db->query($sql3, $ringGroupIds);
            $allTenantIds = [];
            
            foreach ($query3->result() as $row) {
                $allTenantIds[] = $row->TenantId;
            }

          // print_r($allTenantIds);  exit;// Debugging output 
            
            return $allTenantIds;
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getTenantIdsForGroupAdmin error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get visit statistics for a Group Admin user
     * Returns total visits, new patient visits, and repeat patient visits
     * 
     * @param int $userId Group Admin User ID
     * @param string|null $startDate Start date (default: Monday of this week)
     * @param string|null $endDate End date (default: Sunday of this week)
     * @param int|null $tenantId Optional: Filter by specific tenant
     * @return array
     */
    public function getVisitStatistics($userId, $startDate = null, $endDate = null, $tenantId = null, $doctorId = null)
    {
        try {
            // Calculate date range if not provided (default to this week)
            if (!$startDate || !$endDate) {
                $today = date('Y-m-d');
                $dayOfWeek = date('w', strtotime($today)); // 0 = Sunday, 1 = Monday, etc.
                
                if ($dayOfWeek == 0) {
                    // If today is Sunday, go back 6 days
                    $startDate = date('Y-m-d', strtotime($today . ' -6 days'));
                } else {
                    // Go back (dayOfWeek - 1) days to get Monday
                    $startDate = date('Y-m-d', strtotime($today . ' -' . ($dayOfWeek - 1) . ' days'));
                }
                
                $endDate = date('Y-m-d', strtotime($startDate . ' +6 days'));
            }
            
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [
                    'totalVisits' => 0,
                    'newPatientVisits' => 0,
                    'repeatPatientVisits' => 0,
                    'totalUniquePatients' => 0,
                    'totalNewPatients' => 0,
                    'totalRepeatPatients' => 0,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'userId' => $userId,
                    'numberOfTenants' => 0
                ];
            }
            
            // If specific tenant filter was provided, validate all are in scope
            if ($tenantId !== null && $tenantId !== '') {
                $allowedIds = $this->getTenantIdsForGroupAdmin($userId);
                $tenantIds = array_values(array_intersect($tenantIds, $allowedIds));
                if (empty($tenantIds)) {
                    return [
                        'totalVisits' => 0,
                        'newPatientVisits' => 0,
                        'repeatPatientVisits' => 0,
                        'totalUniquePatients' => 0,
                        'totalNewPatients' => 0,
                        'totalRepeatPatients' => 0,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'userId' => $userId,
                        'numberOfTenants' => 0
                    ];
                }
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            // Query to get visit statistics with new/repeat patient detection
            // A patient is "New" if this is their FIRST enrollment EVER (across all tenants)
            // A patient is "Repeat" if they have had ANY previous enrollment
            $sql = "WITH VisitData AS (
                        SELECT 
                            e.Id AS EnrollmentId,
                            e.PatientId,
                            e.EnrollmentDate AS VisitDate,
                            e.TenantId,
                            CASE 
                                WHEN EXISTS (
                                    SELECT 1 
                                    FROM Enrollment e2 
                                    WHERE e2.PatientId = e.PatientId 
                                        AND CAST(e2.EnrollmentDate AS DATE) < CAST(e.EnrollmentDate AS DATE)
                                        AND e2.IsActive = 1
                                ) THEN 0  -- Repeat Patient (has previous enrollment)
                                ELSE 1    -- New Patient (first enrollment ever)
                            END AS IsNewPatient
                        FROM Enrollment e
                        WHERE CAST(e.EnrollmentDate AS DATE) >= ?
                            AND CAST(e.EnrollmentDate AS DATE) <= ?
                            AND e.IsActive = 1
                            AND e.TenantId IN ($placeholders)";
            
            $params = array_merge([$startDate, $endDate], $tenantIds);
            
            // Add doctor filter if provided - filter by patients who had appointments with this doctor
            if ($doctorId !== null) {
                $sql .= " AND EXISTS (
                    SELECT 1 
                    FROM Appointment a 
                    WHERE a.PatientId = e.PatientId 
                        AND a.PractitionerId = ?
                        AND CAST(a.AppointmentDate AS DATE) = CAST(e.EnrollmentDate AS DATE)
                        AND a.IsActive = 1
                )";
                $params[] = $doctorId;
            }
            
            $sql .= "
                    )
                    SELECT 
                        COUNT(*) AS TotalVisits,
                        SUM(CASE WHEN IsNewPatient = 1 THEN 1 ELSE 0 END) AS NewPatientVisits,
                        SUM(CASE WHEN IsNewPatient = 0 THEN 1 ELSE 0 END) AS RepeatPatientVisits,
                        COUNT(DISTINCT PatientId) AS TotalUniquePatients,
                        COUNT(DISTINCT CASE WHEN IsNewPatient = 1 THEN PatientId ELSE NULL END) AS TotalNewPatients,
                        COUNT(DISTINCT CASE WHEN IsNewPatient = 0 THEN PatientId ELSE NULL END) AS TotalRepeatPatients
                    FROM VisitData";
            
            // Build debug SQL for logging
            $debugSql = $sql;
            $debugSql = str_replace('IN (' . $placeholders . ')', 'IN (' . implode(',', $tenantIds) . ')', $debugSql);
            $debugSql = str_replace('>= ?', ">= '" . $startDate . "'", $debugSql);
            $debugSql = str_replace('<= ?', "<= '" . $endDate . "'", $debugSql);
            
            error_log("GroupAdmin_Model::getVisitStatistics SQL: " . $debugSql);
            error_log("GroupAdmin_Model::getVisitStatistics Params: " . json_encode($params));
            
            $query = $this->db->query($sql, $params);
          //  echo $this->db->last_query(); // Debugging output
           // exit ;
            
            $result = [
                'totalVisits' => 0,
                'newPatientVisits' => 0,
                'repeatPatientVisits' => 0,
                'totalUniquePatients' => 0,
                'totalNewPatients' => 0,
                'totalRepeatPatients' => 0,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'userId' => $userId,
                'numberOfTenants' => count($tenantIds)
            ];
            
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $totalVisits = (int)($row->TotalVisits ?? 0);
                $newPatientVisits = (int)($row->NewPatientVisits ?? 0);
                $repeatPatientVisits = (int)($row->RepeatPatientVisits ?? 0);
                
                // Ensure data consistency: RepeatPatientVisits = TotalVisits - NewPatientVisits
                // This ensures the math is always correct
                $calculatedRepeatVisits = $totalVisits - $newPatientVisits;
                
                $result['totalVisits'] = $totalVisits;
                $result['newPatientVisits'] = $newPatientVisits;
                $result['repeatPatientVisits'] = $calculatedRepeatVisits; // Use calculated value
                $result['totalUniquePatients'] = (int)($row->TotalUniquePatients ?? 0);
                $result['totalNewPatients'] = (int)($row->TotalNewPatients ?? 0);
                $result['totalRepeatPatients'] = (int)($row->TotalRepeatPatients ?? 0);
                
                // Log for debugging
                error_log("GroupAdmin_Model::getVisitStatistics Raw Result - TotalVisits: " . $totalVisits . 
                         ", NewPatientVisits: " . $newPatientVisits . 
                         ", RepeatPatientVisits (raw): " . $repeatPatientVisits . 
                         ", RepeatPatientVisits (calculated): " . $calculatedRepeatVisits);
                error_log("GroupAdmin_Model::getVisitStatistics Final Result: " . json_encode($result));
            } else {
                error_log("GroupAdmin_Model::getVisitStatistics: No rows returned");
            }
            $result['_sqlQuery'] = $debugSql;
            return $result;
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getVisitStatistics error: " . $e->getMessage());
            return [
                'totalVisits' => 0,
                'newPatientVisits' => 0,
                'repeatPatientVisits' => 0,
                'totalUniquePatients' => 0,
                'totalNewPatients' => 0,
                'totalRepeatPatients' => 0,
                'startDate' => $startDate ?? date('Y-m-d'),
                'endDate' => $endDate ?? date('Y-m-d'),
                'userId' => $userId,
                'numberOfTenants' => 0,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get new vs repeat patient trend by day of week (for patient-behavior chart).
     * Same VisitData logic as getVisitStatistics; grouped by DATEPART(WEEKDAY, VisitDate).
     * Returns array keyed by weekday 1-7 (SQL Server: 1=Sun, 2=Mon, ..., 7=Sat) with newPatients, repeatPatients.
     *
     * @param int $userId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param int|null $tenantId
     * @param int|null $doctorId PractitionerId for doctor filter
     * @return array [ ['dayOfWeek' => 1, 'newPatients' => n, 'repeatPatients' => n], ... ]
     */
    public function getVisitStatisticsByWeekday($userId, $startDate = null, $endDate = null, $tenantId = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $today = date('Y-m-d');
                $endDate = $today;
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }

            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['_data' => $this->emptyVisitStatisticsByWeekday(), '_sqlQuery' => null];
            }

            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $sql = "WITH VisitData AS (
                        SELECT 
                            e.Id AS EnrollmentId,
                            e.PatientId,
                            e.EnrollmentDate AS VisitDate,
                            e.TenantId,
                            CASE 
                                WHEN EXISTS (
                                    SELECT 1 
                                    FROM Enrollment e2 
                                    WHERE e2.PatientId = e.PatientId 
                                        AND CAST(e2.EnrollmentDate AS DATE) < CAST(e.EnrollmentDate AS DATE)
                                        AND e2.IsActive = 1
                                ) THEN 0
                                ELSE 1
                            END AS IsNewPatient
                        FROM Enrollment e
                        WHERE CAST(e.EnrollmentDate AS DATE) >= ?
                            AND CAST(e.EnrollmentDate AS DATE) <= ?
                            AND e.IsActive = 1
                            AND e.TenantId IN ($placeholders)";
            $params = array_merge([$startDate, $endDate], $tenantIds);
            if ($doctorId !== null && $doctorId !== '') {
                $sql .= " AND EXISTS (
                    SELECT 1 
                    FROM Appointment a 
                    WHERE a.PatientId = e.PatientId 
                        AND a.PractitionerId = ?
                        AND CAST(a.AppointmentDate AS DATE) = CAST(e.EnrollmentDate AS DATE)
                        AND a.IsActive = 1
                )";
                $params[] = $doctorId;
            }
            $sql .= "
                    )
                    SELECT 
                        DATEPART(WEEKDAY, VisitDate) AS DayOfWeek,
                        SUM(CASE WHEN IsNewPatient = 1 THEN 1 ELSE 0 END) AS NewPatients,
                        SUM(CASE WHEN IsNewPatient = 0 THEN 1 ELSE 0 END) AS RepeatPatients
                    FROM VisitData
                    GROUP BY DATEPART(WEEKDAY, VisitDate)
                    ORDER BY DATEPART(WEEKDAY, VisitDate)";

            $debugSql = $sql;
            $debugSql = str_replace('IN (' . $placeholders . ')', 'IN (' . implode(',', $tenantIds) . ')', $debugSql);
            $debugSql = str_replace('>= ?', ">= '$startDate'", $debugSql);
            $debugSql = str_replace('<= ?', "<= '$endDate'", $debugSql);
            if ($doctorId !== null && $doctorId !== '') {
                $debugSql = str_replace(' AND a.PractitionerId = ?', ' AND a.PractitionerId = ' . (int)$doctorId, $debugSql);
            }
            $query = $this->db->query($sql, $params);
            $out = [];
            foreach ($query->result() as $row) {
                $out[] = [
                    'dayOfWeek'     => (int) $row->DayOfWeek,
                    'newPatients'   => (int) $row->NewPatients,
                    'repeatPatients'=> (int) $row->RepeatPatients,
                ];
            }
            return ['_data' => $out, '_sqlQuery' => $debugSql];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getVisitStatisticsByWeekday error: " . $e->getMessage());
            return ['_data' => $this->emptyVisitStatisticsByWeekday(), '_sqlQuery' => null];
        }
    }

    private function emptyVisitStatisticsByWeekday()
    {
        return [];
    }

    /**
     * Get appointment trend by weekday: Created, Completed, Cancelled, No-show counts per Mon-Sun.
     * Same status logic as getAppointmentStatusSummary. Returns arrays for chart.
     */
    public function getAppointmentTrendByWeekday($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return $this->emptyAppointmentTrendByWeekday();
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $params[] = (int) $doctorId;
            }

            $sql = "SELECT 
                        DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) AS DayOfWeek,
                        asm.AppointmentStatusCode,
                        asm.AppointmentStatusDescription,
                        COUNT(*) AS Cnt
                    FROM Appointment a
                    INNER JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND a.PractitionerId = ?";
            }
            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)), asm.AppointmentStatusCode, asm.AppointmentStatusDescription
                      ORDER BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE))";

            $query = $this->db->query($sql, $params);
            $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $dayToIndex = [2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 => 5, 1 => 6];
            $created = [0, 0, 0, 0, 0, 0, 0];
            $completed = [0, 0, 0, 0, 0, 0, 0];
            $cancelled = [0, 0, 0, 0, 0, 0, 0];
            $noShow = [0, 0, 0, 0, 0, 0, 0];

            foreach ($query->result() as $row) {
                $idx = isset($dayToIndex[$row->DayOfWeek]) ? $dayToIndex[$row->DayOfWeek] : null;
                if ($idx === null) continue;
                $cnt = (int) $row->Cnt;
                $code = strtoupper($row->AppointmentStatusCode ?? '');
                $desc = strtoupper($row->AppointmentStatusDescription ?? '');
                $created[$idx] += $cnt;
                if (in_array($code, ['OPEN', 'CONFIRMED', 'BOOKED', 'REGISTERED', 'SCHEDULED', 'PENDING']) ||
                    strpos($desc, 'OPEN') !== false || strpos($desc, 'CONFIRMED') !== false ||
                    strpos($desc, 'BOOKED') !== false || strpos($desc, 'REGISTERED') !== false) {
                    $completed[$idx] += $cnt;
                } elseif (in_array($code, ['CANCELLED', 'CANCELED', 'CANCEL']) ||
                          strpos($desc, 'CANCELLED') !== false || strpos($desc, 'CANCELED') !== false || strpos($desc, 'CANCEL') !== false) {
                    $cancelled[$idx] += $cnt;
                } elseif (in_array($code, ['NOSHOW', 'NO-SHOW', 'NO_SHOW', 'MISSED', 'ABSENT']) ||
                          strpos($desc, 'NO SHOW') !== false || strpos($desc, 'NOSHOW') !== false ||
                          strpos($desc, 'MISSED') !== false || strpos($desc, 'ABSENT') !== false) {
                    $noShow[$idx] += $cnt;
                }
            }

            return [
                'labels' => $labels,
                'series' => [
                    ['name' => 'Created',   'data' => $created],
                    ['name' => 'Completed', 'data' => $completed],
                    ['name' => 'Cancelled', 'data' => $cancelled],
                    ['name' => 'No-show',   'data' => $noShow],
                ],
            ];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getAppointmentTrendByWeekday error: " . $e->getMessage());
            return $this->emptyAppointmentTrendByWeekday();
        }
    }

    private function emptyAppointmentTrendByWeekday()
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        return [
            'labels' => $labels,
            'series' => [
                ['name' => 'Created',   'data' => [0, 0, 0, 0, 0, 0, 0]],
                ['name' => 'Completed', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                ['name' => 'Cancelled', 'data' => [0, 0, 0, 0, 0, 0, 0]],
                ['name' => 'No-show',   'data' => [0, 0, 0, 0, 0, 0, 0]],
            ],
        ];
    }

    /**
     * Get slot utilization % by weekday. Uses (completed appointments / total appointments) * 100 per day.
     * Returns ['labels' => Mon-Sun, 'data' => [pct, ...]].
     */
    public function getSlotUtilizationByWeekday($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [0, 0, 0, 0, 0, 0, 0],
                    'periodTotalSlots' => 0,
                    'periodBookedSlots' => 0,
                ];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $params[] = (int) $doctorId;
            }

            $sql = "SELECT 
                        DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) AS DayOfWeek,
                        COUNT(*) AS Total,
                        SUM(CASE 
                            WHEN UPPER(asm.AppointmentStatusCode) IN ('OPEN', 'CONFIRMED', 'BOOKED', 'REGISTERED', 'SCHEDULED', 'PENDING')
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%OPEN%'
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%CONFIRMED%'
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%BOOKED%'
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%REGISTERED%'
                            THEN 1 ELSE 0 
                        END) AS Completed
                    FROM Appointment a
                    INNER JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND a.PractitionerId = ?";
            }
            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE))
                      ORDER BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE))";

            $query = $this->db->query($sql, $params);
            $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $dayToIndex = [2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 => 5, 1 => 6];
            $data = [0, 0, 0, 0, 0, 0, 0];
            $periodTotalSlots = 0;
            $periodBookedSlots = 0;
            foreach ($query->result() as $row) {
                $idx = isset($dayToIndex[$row->DayOfWeek]) ? $dayToIndex[$row->DayOfWeek] : null;
                if ($idx === null) continue;
                $total = (int) $row->Total;
                $completed = (int) $row->Completed;
                $periodTotalSlots += $total;
                $periodBookedSlots += $completed;
                $data[$idx] = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
            }
            return [
                'labels' => $labels,
                'data' => $data,
                'periodTotalSlots' => $periodTotalSlots,
                'periodBookedSlots' => $periodBookedSlots,
            ];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getSlotUtilizationByWeekday error: " . $e->getMessage());
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [0, 0, 0, 0, 0, 0, 0],
                'periodTotalSlots' => 0,
                'periodBookedSlots' => 0,
            ];
        }
    }

    /**
     * Get top diagnoses (ICD-10) by count for the given tenant(s) and date range.
     * Uses EreportsTransit + ICDMaster. Optional practitioner filter via Users.LinkUserId.
     * Returns [ 'data' => [...], 'query' => string ] when $includeQuery is true, else just the data array.
     */
    public function getTopDiagnoses($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null, $includeQuery = false)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-30 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return $includeQuery ? ['data' => [], 'query' => null] : [];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $params[] = (int) $doctorId;
            }

            $sql = "SELECT TOP 10
                        IC.ICDSubCode AS icd10Code,
                        ISNULL(IC.ICDSubCodeDescription, '') AS name,
                        COUNT(*) AS count
                    FROM EreportsTransit ET
                    INNER JOIN ICDMaster IC ON IC.Id = ET.IcdMasterId
                    LEFT JOIN Users U ON U.UserId = ET.InsertUserId
                    WHERE ET.TenantId IN ($placeholders)
                        AND CAST(ET.InsertDate AS DATE) >= ?
                        AND CAST(ET.InsertDate AS DATE) <= ?
                        AND ET.IcdMasterId IS NOT NULL AND ET.IcdMasterId <> 0";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND U.LinkUserId = ?";
            }
            $sql .= " GROUP BY IC.ICDSubCode, IC.ICDSubCodeDescription
                      ORDER BY COUNT(*) DESC";

            $query = $this->db->query($sql, $params);
            $out = [];
            foreach ($query->result() as $row) {
                $out[] = [
                    'icd10Code' => (string) ($row->icd10Code ?? ''),
                    'name'      => (string) ($row->name ?? ''),
                    'count'     => (int) ($row->count ?? 0),
                ];
            }
            if ($includeQuery) {
                return ['data' => $out, 'query' => $sql, 'params' => $params];
            }
            return $out;
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getTopDiagnoses error: " . $e->getMessage());
            return $includeQuery ? ['data' => [], 'query' => null] : [];
        }
    }

    /**
     * Get visit count for period (Enrollment records) for clinical pattern avgDiagnosesPerVisit.
     */
    public function getVisitCountForPeriod($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                return 1;
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return 1;
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            $sql = "SELECT COUNT(*) AS Cnt FROM Enrollment e WHERE e.TenantId IN ($placeholders) AND CAST(e.EnrollmentDate AS DATE) >= ? AND CAST(e.EnrollmentDate AS DATE) <= ? AND e.IsActive = 1";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND EXISTS (SELECT 1 FROM Appointment a WHERE a.PatientId = e.PatientId AND CAST(a.AppointmentDate AS DATE) = CAST(e.EnrollmentDate AS DATE) AND a.PractitionerId = ? AND a.IsActive = 1)";
                $params[] = (int) $doctorId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q ? $q->row() : null;
            return $row && isset($row->Cnt) ? max(1, (int) $row->Cnt) : 1;
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getVisitCountForPeriod error: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Get unique ICD-10 code count for clinical pattern metrics.
     */
    public function getUniqueIcd10Count($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-30 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return 0;
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            $sql = "SELECT COUNT(DISTINCT IC.ICDSubCode) AS Cnt FROM EreportsTransit ET INNER JOIN ICDMaster IC ON IC.Id = ET.IcdMasterId LEFT JOIN Users U ON U.UserId = ET.InsertUserId WHERE ET.TenantId IN ($placeholders) AND CAST(ET.InsertDate AS DATE) >= ? AND CAST(ET.InsertDate AS DATE) <= ? AND ET.IcdMasterId IS NOT NULL AND ET.IcdMasterId <> 0";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND U.LinkUserId = ?";
                $params[] = (int) $doctorId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q ? $q->row() : null;
            return $row && isset($row->Cnt) ? (int) $row->Cnt : 0;
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getUniqueIcd10Count error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get diagnosis count by gender (male, female, other) for clinical pattern.
     * EreportsTransit has PatientMasterId; PatientMaster has GenderId.
     */
    public function getDiagnosisByGender($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-30 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['male' => 0, 'female' => 0, 'other' => 0];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            $sql = "SELECT LOWER(ISNULL(g.Description, 'Other')) AS GenderDesc, COUNT(*) AS Cnt
                    FROM EreportsTransit ET
                    INNER JOIN ICDMaster IC ON IC.Id = ET.IcdMasterId
                    LEFT JOIN PatientMaster p ON p.PatientId = ET.PatientMasterId
                    LEFT JOIN GenderMaster g ON p.GenderId = g.Id
                    LEFT JOIN Users U ON U.UserId = ET.InsertUserId
                    WHERE ET.TenantId IN ($placeholders) AND CAST(ET.InsertDate AS DATE) >= ? AND CAST(ET.InsertDate AS DATE) <= ? AND ET.IcdMasterId IS NOT NULL AND ET.IcdMasterId <> 0";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND U.LinkUserId = ?";
                $params[] = (int) $doctorId;
            }
            $sql .= " GROUP BY LOWER(ISNULL(g.Description, 'Other'))";
            $q = $this->db->query($sql, $params);
            $male = $female = $other = 0;
            foreach ($q ? $q->result() : [] as $row) {
                $desc = strtolower(trim($row->GenderDesc ?? 'other'));
                $cnt = (int) ($row->Cnt ?? 0);
                if (strpos($desc, 'male') !== false && $desc !== 'female') {
                    $male += $cnt;
                } elseif (strpos($desc, 'female') !== false) {
                    $female += $cnt;
                } else {
                    $other += $cnt;
                }
            }
            return ['male' => $male, 'female' => $female, 'other' => $other];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDiagnosisByGender error: " . $e->getMessage());
            return ['male' => 0, 'female' => 0, 'other' => 0];
        }
    }

    /**
     * Get diagnosis count by age group for clinical pattern chart.
     */
    public function getDiagnosisAgeDistribution($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        $labels = ['0-10', '11-20', '21-30', '31-40', '41-50', '51-60', '60+'];
        $data = [0, 0, 0, 0, 0, 0, 0];
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-30 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['labels' => $labels, 'data' => $data];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            $sql = "SELECT
                        CASE
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 0 AND 10 THEN 0
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 11 AND 20 THEN 1
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 21 AND 30 THEN 2
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 31 AND 40 THEN 3
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 41 AND 50 THEN 4
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 51 AND 60 THEN 5
                            ELSE 6
                        END AS AgeIdx,
                        COUNT(*) AS Cnt
                    FROM EreportsTransit ET
                    INNER JOIN ICDMaster IC ON IC.Id = ET.IcdMasterId
                    LEFT JOIN PatientMaster p ON p.PatientId = ET.PatientMasterId
                    LEFT JOIN Users U ON U.UserId = ET.InsertUserId
                    WHERE ET.TenantId IN ($placeholders) AND CAST(ET.InsertDate AS DATE) >= ? AND CAST(ET.InsertDate AS DATE) <= ? AND ET.IcdMasterId IS NOT NULL AND ET.IcdMasterId <> 0 AND p.DateOfBirth IS NOT NULL";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND U.LinkUserId = ?";
                $params[] = (int) $doctorId;
            }
            $sql .= " GROUP BY CASE WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 0 AND 10 THEN 0 WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 11 AND 20 THEN 1 WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 21 AND 30 THEN 2 WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 31 AND 40 THEN 3 WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 41 AND 50 THEN 4 WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 51 AND 60 THEN 5 ELSE 6 END";
            $q = $this->db->query($sql, $params);
            foreach ($q ? $q->result() : [] as $row) {
                $idx = (int) ($row->AgeIdx ?? 0);
                if ($idx >= 0 && $idx <= 6) {
                    $data[$idx] = (int) ($row->Cnt ?? 0);
                }
            }
            return ['labels' => $labels, 'data' => $data];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDiagnosisAgeDistribution error: " . $e->getMessage());
            return ['labels' => $labels, 'data' => $data];
        }
    }

    /**
     * Get diagnosis count by weekday for clinical pattern trend chart.
     * SQL Server: 1=Sun, 2=Mon, ..., 7=Sat. Frontend expects Mon..Sun order.
     */
    public function getDiagnosisTrendByWeekday($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $dowMap = [2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 => 5, 1 => 6];
        $data = [0, 0, 0, 0, 0, 0, 0];
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['labels' => $labels, 'data' => $data];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            $sql = "SELECT DATEPART(WEEKDAY, CAST(ET.InsertDate AS DATE)) AS DayOfWeek, COUNT(*) AS Cnt
                    FROM EreportsTransit ET
                    INNER JOIN ICDMaster IC ON IC.Id = ET.IcdMasterId
                    LEFT JOIN Users U ON U.UserId = ET.InsertUserId
                    WHERE ET.TenantId IN ($placeholders) AND CAST(ET.InsertDate AS DATE) >= ? AND CAST(ET.InsertDate AS DATE) <= ? AND ET.IcdMasterId IS NOT NULL AND ET.IcdMasterId <> 0";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND U.LinkUserId = ?";
                $params[] = (int) $doctorId;
            }
            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(ET.InsertDate AS DATE))";
            $q = $this->db->query($sql, $params);
            foreach ($q ? $q->result() : [] as $row) {
                $dow = (int) ($row->DayOfWeek ?? 1);
                $idx = isset($dowMap[$dow]) ? $dowMap[$dow] : 6;
                $data[$idx] = (int) ($row->Cnt ?? 0);
            }
            return ['labels' => $labels, 'data' => $data];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDiagnosisTrendByWeekday error: " . $e->getMessage());
            return ['labels' => $labels, 'data' => $data];
        }
    }

    /**
     * Get top prescribed medicines for clinical pattern. Returns empty if no prescription table/SP.
     */
    public function getTopPrescribedMedicines($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            return [];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getTopPrescribedMedicines error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get cancelled and no-show counts by day of week for patient-behavior chart.
     * Same status logic as getAppointmentStatusSummary. Returns [ ['dayOfWeek'=>1, 'cancelled'=>n, 'noShow'=>n], ... ].
     */
    public function getAppointmentStatusByWeekday($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['_data' => [], '_sqlQuery' => null];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $doctorParam = (int) $doctorId;
            } else {
                $doctorParam = null;
            }

            $sql = "SELECT 
                        DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)) AS DayOfWeek,
                        asm.AppointmentStatusCode,
                        asm.AppointmentStatusDescription,
                        COUNT(*) AS Cnt
                    FROM Appointment a
                    INNER JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            if ($doctorParam !== null) {
                $sql .= " AND a.PractitionerId = ?";
                $params[] = $doctorParam;
            }
            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE)), asm.AppointmentStatusCode, asm.AppointmentStatusDescription
                      ORDER BY DATEPART(WEEKDAY, CAST(a.AppointmentDate AS DATE))";

            $debugSql = $sql;
            $debugSql = str_replace('IN (' . $placeholders . ')', 'IN (' . implode(',', $tenantIds) . ')', $debugSql);
            $debugSql = str_replace('>= ?', ">= '$startDate'", $debugSql);
            $debugSql = str_replace('<= ?', "<= '$endDate'", $debugSql);
            if ($doctorParam !== null) {
                $debugSql = preg_replace('/ AND a\.PractitionerId = \?/', ' AND a.PractitionerId = ' . $doctorParam, $debugSql, 1);
            }
            $query = $this->db->query($sql, $params);
            $byDay = [];
            foreach ($query->result() as $row) {
                $day = (int) $row->DayOfWeek;
                if (!isset($byDay[$day])) {
                    $byDay[$day] = ['dayOfWeek' => $day, 'cancelled' => 0, 'noShow' => 0];
                }
                $code = strtoupper($row->AppointmentStatusCode ?? '');
                $desc = strtoupper($row->AppointmentStatusDescription ?? '');
                $cnt = (int) $row->Cnt;
                if (in_array($code, ['CANCELLED', 'CANCELED', 'CANCEL']) ||
                    strpos($desc, 'CANCELLED') !== false || strpos($desc, 'CANCELED') !== false || strpos($desc, 'CANCEL') !== false) {
                    $byDay[$day]['cancelled'] += $cnt;
                } elseif (in_array($code, ['NOSHOW', 'NO-SHOW', 'NO_SHOW', 'MISSED', 'ABSENT']) ||
                          strpos($desc, 'NO SHOW') !== false || strpos($desc, 'NOSHOW') !== false ||
                          strpos($desc, 'MISSED') !== false || strpos($desc, 'ABSENT') !== false) {
                    $byDay[$day]['noShow'] += $cnt;
                }
            }
            return ['_data' => array_values($byDay), '_sqlQuery' => $debugSql];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getAppointmentStatusByWeekday error: " . $e->getMessage());
            return ['_data' => [], '_sqlQuery' => null];
        }
    }

    /**
     * Get patient engagement distribution: count of patients by visit-count bucket (1, 2-3, 4-5, 6-10, 10+)
     * for the given practitioner and date range. Returns [ ['visitCount'=>'1 visit', 'patients'=>n, 'percentage'=>p], ... ].
     */
    public function getEngagementDistribution($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['_data' => $this->defaultEngagementDistribution(), '_sqlQuery' => null];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $params[] = (int) $doctorId;
            }

            $sql = "WITH PatientVisits AS (
                        SELECT a.PatientId, COUNT(*) AS VisitCount
                        FROM Appointment a
                        WHERE a.TenantId IN ($placeholders)
                            AND CAST(a.AppointmentDate AS DATE) >= ?
                            AND CAST(a.AppointmentDate AS DATE) <= ?
                            AND a.IsActive = 1";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND a.PractitionerId = ?";
            }
            $sql .= "
                        GROUP BY a.PatientId
                    )
                    SELECT 
                        CASE 
                            WHEN VisitCount = 1 THEN 1
                            WHEN VisitCount <= 3 THEN 2
                            WHEN VisitCount <= 5 THEN 3
                            WHEN VisitCount <= 10 THEN 4
                            ELSE 5
                        END AS Bucket,
                        COUNT(*) AS Patients
                    FROM PatientVisits
                    GROUP BY 
                        CASE 
                            WHEN VisitCount = 1 THEN 1
                            WHEN VisitCount <= 3 THEN 2
                            WHEN VisitCount <= 5 THEN 3
                            WHEN VisitCount <= 10 THEN 4
                            ELSE 5
                        END
                    ORDER BY Bucket";

            $debugSql = $sql;
            $debugSql = str_replace('IN (' . $placeholders . ')', 'IN (' . implode(',', $tenantIds) . ')', $debugSql);
            $debugSql = str_replace('>= ?', ">= '$startDate'", $debugSql);
            $debugSql = str_replace('<= ?', "<= '$endDate'", $debugSql);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $debugSql = str_replace(" AND a.PractitionerId = ?", ' AND a.PractitionerId = ' . (int)$doctorId, $debugSql);
            }
            $query = $this->db->query($sql, $params);
            $bucketLabels = [1 => '1 visit', 2 => '2-3 visits', 3 => '4-5 visits', 4 => '6-10 visits', 5 => '10+ visits'];
            $counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
            foreach ($query->result() as $row) {
                $b = (int) $row->Bucket;
                if (isset($counts[$b])) {
                    $counts[$b] = (int) $row->Patients;
                }
            }
            $total = array_sum($counts);
            $out = [];
            foreach ([1, 2, 3, 4, 5] as $b) {
                $patients = $counts[$b];
                $pct = $total > 0 ? round(($patients / $total) * 100, 1) : 0;
                $out[] = [
                    'visitCount' => $bucketLabels[$b],
                    'patients'   => $patients,
                    'percentage' => $pct,
                ];
            }
            return ['_data' => $out, '_sqlQuery' => $debugSql];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getEngagementDistribution error: " . $e->getMessage());
            return ['_data' => $this->defaultEngagementDistribution(), '_sqlQuery' => null];
        }
    }

    private function defaultEngagementDistribution()
    {
        return [
            ['visitCount' => '1 visit', 'patients' => 0, 'percentage' => 0],
            ['visitCount' => '2-3 visits', 'patients' => 0, 'percentage' => 0],
            ['visitCount' => '4-5 visits', 'patients' => 0, 'percentage' => 0],
            ['visitCount' => '6-10 visits', 'patients' => 0, 'percentage' => 0],
            ['visitCount' => '10+ visits', 'patients' => 0, 'percentage' => 0],
        ];
    }

    /**
     * Get top cancellation reasons for cancelled appointments in the date range.
     * Same tenant/practitioner/date and cancelled-status logic as getAppointmentStatusSummary.
     * Returns [ ['reason' => string, 'count' => int, 'percentage' => float], ... ] up to 10 rows.
     */
    public function getCancellationReasons($userId, $tenantId = null, $startDate = null, $endDate = null, $doctorId = null)
    {
        try {
            if (!$startDate || !$endDate) {
                $endDate = date('Y-m-d');
                $startDate = date('Y-m-d', strtotime('-6 days'));
            }
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return ['_data' => [], '_sqlQuery' => null];
            }
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $params[] = (int) $doctorId;
            }

            $sql = "SELECT 
                        COALESCE(NULLIF(LTRIM(RTRIM(a.AppointmentReason)), ''), 'Other') AS Reason,
                        COUNT(*) AS Cnt
                    FROM Appointment a
                    INNER JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1
                        AND (
                            UPPER(asm.AppointmentStatusCode) IN ('CANCELLED', 'CANCELED', 'CANCEL')
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%CANCELLED%'
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%CANCELED%'
                            OR UPPER(asm.AppointmentStatusDescription) LIKE '%CANCEL%'
                        )";
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $sql .= " AND a.PractitionerId = ?";
            }
            $sql .= " GROUP BY COALESCE(NULLIF(LTRIM(RTRIM(a.AppointmentReason)), ''), 'Other')
                      ORDER BY COUNT(*) DESC";

            $debugSql = $sql;
            $debugSql = str_replace('IN (' . $placeholders . ')', 'IN (' . implode(',', $tenantIds) . ')', $debugSql);
            $debugSql = str_replace('>= ?', ">= '$startDate'", $debugSql);
            $debugSql = str_replace('<= ?', "<= '$endDate'", $debugSql);
            if ($doctorId !== null && $doctorId !== '' && $doctorId !== 0) {
                $debugSql = preg_replace('/ AND a\.PractitionerId = \?/', ' AND a.PractitionerId = ' . (int)$doctorId, $debugSql, 1);
            }
            $query = $this->db->query($sql, $params);
            $rows = [];
            foreach ($query->result() as $row) {
                $rows[] = ['reason' => (string) $row->Reason, 'count' => (int) $row->Cnt];
            }
            $total = array_sum(array_column($rows, 'count'));
            $out = [];
            $limit = 10;
            foreach (array_slice($rows, 0, $limit) as $r) {
                $pct = $total > 0 ? round(($r['count'] / $total) * 100, 1) : 0;
                $out[] = [
                    'reason'     => $r['reason'],
                    'count'      => $r['count'],
                    'percentage' => $pct,
                ];
            }
            return ['_data' => $out, '_sqlQuery' => $debugSql];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getCancellationReasons error: " . $e->getMessage());
            return ['_data' => [], '_sqlQuery' => null];
        }
    }

    /**
     * Get visit statistics by tenant for a Group Admin user
     * 
     * @param int $userId Group Admin User ID
     * @param string|null $startDate Start date (default: Monday of this week)
     * @param string|null $endDate End date (default: Sunday of this week)
     * @return array
     */
    public function getVisitStatisticsByTenant($userId, $startDate = null, $endDate = null)
    {
        try {
            // Calculate date range if not provided
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
            
            // Get all tenant IDs for this Group Admin user's ring groups
            $tenantIds = $this->getTenantIdsForGroupAdmin($userId);
            
            if (empty($tenantIds)) {
                return [];
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            $sql = "WITH VisitData AS (
                        SELECT 
                            e.Id AS EnrollmentId,
                            e.PatientId,
                            e.TenantId,
                            t.TenantName,
                            CASE 
                                WHEN EXISTS (
                                    SELECT 1 
                                    FROM Enrollment e2 
                                    WHERE e2.PatientId = e.PatientId 
                                        AND e2.EnrollmentDate < e.EnrollmentDate
                                        AND e2.IsActive = 1
                                ) THEN 0
                                ELSE 1
                            END AS IsNewPatient
                        FROM Enrollment e
                        LEFT JOIN Tenants t ON e.TenantId = t.TenantId
                        WHERE CAST(e.EnrollmentDate AS DATE) >= ?
                            AND CAST(e.EnrollmentDate AS DATE) <= ?
                            AND e.IsActive = 1
                            AND e.TenantId IN ($placeholders)
                    )
                    SELECT 
                        TenantId,
                        TenantName,
                        COUNT(*) AS TotalVisits,
                        SUM(IsNewPatient) AS NewPatientVisits,
                        COUNT(*) - SUM(IsNewPatient) AS RepeatPatientVisits,
                        COUNT(DISTINCT PatientId) AS TotalUniquePatients,
                        SUM(IsNewPatient) AS TotalNewPatients,
                        COUNT(DISTINCT PatientId) - SUM(IsNewPatient) AS TotalRepeatPatients
                    FROM VisitData
                    GROUP BY TenantId, TenantName
                    ORDER BY TotalVisits DESC";
            
            // Initialize params with startDate, endDate, then add tenantIds
            $params = [$startDate, $endDate];
            $params = array_merge($params, $tenantIds);
            
            $query = $this->db->query($sql, $params);
            
            return $query->result_array();
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getVisitStatisticsByTenant error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get patient demographics overview (Gender Distribution and Age Group Distribution)
     * for a Group Admin user
     * 
     * @param int $userId Group Admin User ID
     * @param string|null $startDate Start date (optional: filter patients who visited in this period)
     * @param string|null $endDate End date (optional: filter patients who visited in this period)
     * @param int|null $tenantId Optional: Filter by specific tenant
     * @return array
     */
    public function getPatientDemographics($userId, $startDate = null, $endDate = null, $tenantId = null, $doctorId = null)
    {
        try {
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [
                    'genderDistribution' => [],
                    'ageGroupDistribution' => [],
                    'totalPatients' => 0,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'userId' => $userId
                ];
            }
            
            // If specific tenant filter was provided, validate all are in scope
            if ($tenantId !== null && $tenantId !== '') {
                $allowedIds = $this->getTenantIdsForGroupAdmin($userId);
                $tenantIds = array_values(array_intersect($tenantIds, $allowedIds));
                if (empty($tenantIds)) {
                    return [
                        'genderDistribution' => [],
                        'ageGroupDistribution' => [],
                        'totalPatients' => 0,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'userId' => $userId
                    ];
                }
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            // Build base WHERE clause for patients (without FROM clause)
            $baseWhere = "WHERE p.IsActive = 1
                           AND p.TenantId IN ($placeholders)";
            
            $params = $tenantIds;
            
            // If date range is provided, filter by patients who had appointments in that period
            if ($startDate && $endDate) {
                $baseWhere .= " AND EXISTS (
                    SELECT 1 
                    FROM Appointment a 
                    WHERE a.PatientId = p.PatientId 
                      AND CAST(a.AppointmentDate AS DATE) >= ?
                      AND CAST(a.AppointmentDate AS DATE) <= ?
                      AND a.IsActive = 1
                      AND a.TenantId IN ($placeholders)";
                $params[] = $startDate;
                $params[] = $endDate;
                // Add tenantIds again for the appointment filter
                $params = array_merge($params, $tenantIds);
                
                // Add doctor filter if provided
                if ($doctorId !== null) {
                    $baseWhere .= " AND a.PractitionerId = ?";
                    $params[] = $doctorId;
                }
                
                $baseWhere .= "
                )";
            } elseif ($doctorId !== null) {
                // If no date range but doctor filter is provided, filter by patients who had appointments with this doctor
                $baseWhere .= " AND EXISTS (
                    SELECT 1 
                    FROM Appointment a 
                    WHERE a.PatientId = p.PatientId 
                        AND a.PractitionerId = ?
                        AND a.IsActive = 1
                        AND a.TenantId IN ($placeholders)";
                $params[] = $doctorId;
                // Add tenantIds again for the appointment filter
                $params = array_merge($params, $tenantIds);
                
                $baseWhere .= "
                )";
            }
            
            // Get total count first for percentage calculation
            $totalCountSql = "SELECT COUNT(*) AS TotalCount FROM PatientMaster p $baseWhere";
            $totalCountQuery = $this->db->query($totalCountSql, $params);
            $totalCount = 0;
            if ($totalCountQuery->num_rows() > 0) {
                $totalCount = (int)$totalCountQuery->row()->TotalCount;
            }
            
            // Get Gender Distribution
            $genderSql = "SELECT 
                            p.GenderId,
                            g.Description AS GenderName,
                            COUNT(*) AS PatientCount
                          FROM PatientMaster p
                          LEFT JOIN GenderMaster g ON p.GenderId = g.Id
                          $baseWhere
                          GROUP BY p.GenderId, g.Description
                          ORDER BY PatientCount DESC";
            
            $genderQuery = $this->db->query($genderSql, $params);
            $genderResults = $genderQuery->result_array();
            
            // Calculate percentages
            $genderDistribution = [];
            foreach ($genderResults as $row) {
                $percentage = $totalCount > 0 ? round(($row['PatientCount'] / $totalCount) * 100, 2) : 0;
                $genderDistribution[] = [
                    'GenderId' => $row['GenderId'],
                    'GenderName' => $row['GenderName'] ?? 'Unknown',
                    'PatientCount' => (int)$row['PatientCount'],
                    'Percentage' => $percentage
                ];
            }
            
            // Get Age Group Distribution
            $ageSql = "SELECT 
                        CASE 
                            WHEN p.DateOfBirth IS NULL THEN 'Unknown'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) < 0 THEN 'Invalid'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 0 AND 18 THEN '0-18'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 19 AND 30 THEN '19-30'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 31 AND 50 THEN '31-50'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 51 AND 65 THEN '51-65'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) > 65 THEN '65+'
                            ELSE 'Unknown'
                        END AS AgeGroup,
                        COUNT(*) AS PatientCount
                      FROM PatientMaster p
                      $baseWhere
                      GROUP BY 
                        CASE 
                            WHEN p.DateOfBirth IS NULL THEN 'Unknown'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) < 0 THEN 'Invalid'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 0 AND 18 THEN '0-18'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 19 AND 30 THEN '19-30'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 31 AND 50 THEN '31-50'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) BETWEEN 51 AND 65 THEN '51-65'
                            WHEN DATEDIFF(YEAR, p.DateOfBirth, GETDATE()) > 65 THEN '65+'
                            ELSE 'Unknown'
                        END";
            
            $ageQuery = $this->db->query($ageSql, $params);
            $ageResults = $ageQuery->result_array();
            
            // Calculate percentages and sort
            $ageGroupDistribution = [];
            foreach ($ageResults as $row) {
                $percentage = $totalCount > 0 ? round(($row['PatientCount'] / $totalCount) * 100, 2) : 0;
                $ageGroupDistribution[] = [
                    'AgeGroup' => $row['AgeGroup'],
                    'PatientCount' => (int)$row['PatientCount'],
                    'Percentage' => $percentage
                ];
            }
            
            // Sort age groups
            usort($ageGroupDistribution, function($a, $b) {
                $order = ['0-18' => 1, '19-30' => 2, '31-50' => 3, '51-65' => 4, '65+' => 5, 'Unknown' => 6, 'Invalid' => 7];
                $orderA = $order[$a['AgeGroup']] ?? 99;
                $orderB = $order[$b['AgeGroup']] ?? 99;
                return $orderA <=> $orderB;
            });
            
            // Get total patient count
            $totalSql = "SELECT COUNT(*) AS TotalPatients FROM PatientMaster p $baseWhere";
            $totalQuery = $this->db->query($totalSql, $params);
            $totalPatients = 0;
            if ($totalQuery->num_rows() > 0) {
                $totalPatients = (int)$totalQuery->row()->TotalPatients;
            }
            
            return [
                'genderDistribution' => $genderDistribution,
                'ageGroupDistribution' => $ageGroupDistribution,
                'totalPatients' => $totalPatients,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'userId' => $userId,
                'numberOfTenants' => count($tenantIds)
            ];
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getPatientDemographics error: " . $e->getMessage());
            return [
                'genderDistribution' => [],
                'ageGroupDistribution' => [],
                'totalPatients' => 0,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'userId' => $userId,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get total hospitals (tenants) for a Group Admin user
     * 
     * @param int $userId Group Admin User ID
     * @return array
     */
    public function getTotalHospitals($userId)
    {
        try {
            // Get all tenant IDs for this Group Admin user's ring groups
            $tenantIds = $this->getTenantIdsForGroupAdmin($userId);
            
            if (empty($tenantIds)) {
                return [
                    'totalHospitals' => 0,
                    'activeHospitals' => 0,
                    'inactiveHospitals' => 0,
                    'userId' => $userId,
                    'hospitals' => []
                ];
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            // Get hospital details
            $sql = "SELECT 
                        t.TenantId,
                        t.TenantName,
                        t.TenantCode,
                        t.IsActive,
                        t.PhoneNumber,
                        t.Email,
                        t.Address,
                        rgm.RingGroupMasterId AS RingGroupId,
                        rgm.RingGroupName
                    FROM Tenants t
                    LEFT JOIN RingGroupTenants rgt ON t.TenantId = rgt.TenantId
                    LEFT JOIN RingGroupMaster rgm ON rgt.RingGroupId = rgm.RingGroupMasterId
                    WHERE t.TenantId IN ($placeholders)
                    ORDER BY t.TenantName";
            
            $query = $this->db->query($sql, $tenantIds);
            $hospitals = $query->result_array();
            
            $activeCount = 0;
            $inactiveCount = 0;
            
            foreach ($hospitals as $hospital) {
                if ($hospital['IsActive'] == 1) {
                    $activeCount++;
                } else {
                    $inactiveCount++;
                }
            }
            
            return [
                'totalHospitals' => count($hospitals),
                'activeHospitals' => $activeCount,
                'inactiveHospitals' => $inactiveCount,
                'userId' => $userId,
                'hospitals' => $hospitals
            ];
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getTotalHospitals error: " . $e->getMessage());
            return [
                'totalHospitals' => 0,
                'activeHospitals' => 0,
                'inactiveHospitals' => 0,
                'userId' => $userId,
                'hospitals' => [],
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get user locations (tenants) - Similar to LocationSelector GetUserLocationDetails
     * Returns locations from UserTenants table directly (not just ring groups)
     * 
     * @param int $userId User ID
     * @return array
     */
    public function getUserLocations($userId)
    {
        try {
            // Use the same stored procedure as LocationSelector: GetUserLocationDetails
            // This ensures we get the exact same locations that LocationSelector shows
            $sql = "EXEC GetUserLocationDetails @UserId = ?";
            
            $query = $this->db->query($sql, [$userId]);
            $locations = $query->result_array();
            
            // Log for debugging
            error_log("GroupAdmin_Model::getUserLocations - UserId: $userId, Found " . count($locations) . " locations");
            if (count($locations) > 0) {
                error_log("Sample location: " . json_encode($locations[0]));
            }
            
            // The stored procedure returns locations with these fields:
            // Id, UserId, UserName, TenantId, TenantCode, TenantName, isCurrentLocation, RingGroupName
            // All returned locations should be active (stored procedure filters by IsActive = 1)
            
            $activeCount = count($locations); // All locations from stored procedure are active
            $inactiveCount = 0;
            
            // Map the stored procedure result to our expected format
            // GetUserLocationDetails returns: Id, UserId, UserName, TenantId, TenantCode, TenantName, isCurrentLocation, RingGroupName
            $mappedLocations = [];
            foreach ($locations as $location) {
                // Get RingGroupId separately if needed (from RingGroupTenants)
                $ringGroupId = null;
                if (!empty($location['RingGroupName']) && $location['RingGroupName'] !== 'No Ring Group') {
                    // Try to get RingGroupId from RingGroupMaster if needed
                    // For now, we'll just use the data from stored procedure
                }
                
                $mappedLocations[] = [
                    'Id' => $location['Id'] ?? null,
                    'UserId' => $location['UserId'] ?? $userId,
                    'UserName' => $location['UserName'] ?? $location['Username'] ?? null,
                    'TenantId' => $location['TenantId'] ?? null,
                    'TenantCode' => $location['TenantCode'] ?? null,
                    'TenantName' => $location['TenantName'] ?? null,
                    'isCurrentLocation' => isset($location['isCurrentLocation']) ? 
                        ($location['isCurrentLocation'] == 1 || $location['isCurrentLocation'] === true || $location['isCurrentLocation'] === '1') : 0,
                    'RingGroupName' => $location['RingGroupName'] ?? 'No Ring Group',
                    'IsActive' => 1, // All locations from stored procedure are active
                    'RingGroupId' => $ringGroupId
                ];
            }
            
            return [
                'totalLocations' => count($mappedLocations),
                'activeLocations' => $activeCount,
                'inactiveLocations' => $inactiveCount,
                'userId' => $userId,
                'locations' => $mappedLocations
            ];
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getUserLocations error: " . $e->getMessage());
            return [
                'totalLocations' => 0,
                'activeLocations' => 0,
                'inactiveLocations' => 0,
                'userId' => $userId,
                'locations' => [],
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get PractitionerIds that appear in the doctor dropdown for Group Admin.
     * Same source as getDoctorsByTenant - ensures "All doctors" filter matches dropdown list.
     *
     * @param int $userId Group Admin User ID
     * @param int|null $tenantId If set, doctors from that tenant only; if null, from all tenants in scope
     * @return array Array of PractitionerMaster.Id values
     */
    public function getPractitionerIdsForDropdown($userId, $tenantId = null)
    {
        try {
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            if (empty($tenantIds)) {
                return [];
            }
            $allIds = [];
            $seen = [];
            foreach ($tenantIds as $tid) {
                $doctors = $this->getDoctorsByTenant($tid);
                foreach ($doctors as $d) {
                    $id = isset($d['Id']) ? (int)$d['Id'] : (isset($d['id']) ? (int)$d['id'] : null);
                    if ($id !== null && $id > 0 && !isset($seen[$id])) {
                        $seen[$id] = true;
                        $allIds[] = $id;
                    }
                }
            }
            return $allIds;
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getPractitionerIdsForDropdown error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get doctors/practitioners by tenant/facility
     * Uses stored procedure usp_getPractitionerList
     * 
     * @param int $tenantId Tenant/Facility ID
     * @return array
     */
    public function getDoctorsByTenant($tenantId)
    {
        try {
            // Use stored procedure usp_getPractitionerList (same as .NET API)
            // SQL Server stored procedure syntax
            $sql = "EXEC usp_getPractitionerList @TenantId = ?";
            
            $query = $this->db->query($sql, [$tenantId]);
            $doctors = $query->result_array();
            
            return $doctors;
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDoctorsByTenant error: " . $e->getMessage());
            // Fallback: Try direct SQL query if stored procedure fails
            try {
                $sql = "SELECT DISTINCT
                            PM.Id,
                            PM.PractitionerName
                        FROM PractitionerMaster PM
                        INNER JOIN PractitionerSpecialityDetails PSD ON PM.Id = PSD.PractitionerMasterId
                        WHERE PSD.TenantId = ?
                            AND PM.IsActive = 1
                            AND PSD.IsActive = 1
                        ORDER BY PM.PractitionerName";
                
                $query = $this->db->query($sql, [$tenantId]);
                return $query->result_array();
            } catch (Exception $e2) {
                error_log("GroupAdmin_Model::getDoctorsByTenant fallback error: " . $e2->getMessage());
                return [];
            }
        }
    }

    /**
     * Helper: Call stored procedure with named parameters
     * @param string $procName Stored procedure name
     * @param array $params Associative array of parameter name => value
     * @return array Result array
     */
    private function callProc($procName, $params)
    {
        try {
            $pairs = [];
            $values = [];
            foreach ($params as $k => $v) {
                $pairs[] = "@$k = ?";
                $values[] = $v;
            }
            $sql = "EXEC $procName " . implode(', ', $pairs);
            $query = $this->db->query($sql, $values);
            return $query ? $query->result_array() : [];
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::callProc($procName) error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Calculate slot capacity based on working hours and duration
     * Similar to AppointmentDialog.ts slot calculation logic
     * 
     * @param string $startDate Start date (YYYY-MM-DD)
     * @param string $endDate End date (YYYY-MM-DD)
     * @param array $tenantIds Array of tenant IDs
     * @param int|null $doctorId Optional: Filter by doctor
     * @return array ['totalSlots' => int, 'utilised' => int]
     */
    private function calculateSlotCapacity($startDate, $endDate, $tenantIds, $doctorId = null)
    {
        $totalSlots = 0;
        
        // Fetch holidays/leaves for all tenants and doctors in the date range
        $holidays = $this->getHolidaysAndLeaves($startDate, $endDate, $tenantIds, $doctorId);
        
        // Iterate through each day in the date range
        $currentDate = new DateTime($startDate);
        $end = new DateTime($endDate);
        
        while ($currentDate <= $end) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayOfWeek = (int)$currentDate->format('w'); // 0 = Sunday, 1 = Monday, etc.
            $dayId = $dayOfWeek == 0 ? 7 : $dayOfWeek; // Convert to 1-7 (Monday=1, Sunday=7)
            
            foreach ($tenantIds as $tid) {
                // Get tenant working hours for this day
                $tenantHours = $this->callProc('usp_GetTenantWorkingHours', [
                    'TenantId' => $tid,
                    'ExecFlag' => 'CurrentDay',
                    'AppointmentDate' => $dateStr
                ]);
                
                if (empty($tenantHours)) {
                    continue; // No working hours for this tenant on this day
                }
                
                // Filter by day (check DayMasterId or DayId field)
                $tenantDayHours = array_filter($tenantHours, function($h) use ($dayId) {
                    $dayMasterId = $h['DayMasterId'] ?? $h['DayId'] ?? null;
                    return $dayMasterId == $dayId;
                });
                
                if (empty($tenantDayHours)) {
                    continue;
                }
                
                // Get doctors for this tenant (or specific doctor if provided)
                $doctors = [];
                if ($doctorId !== null) {
                    $doctors = [$doctorId];
                } else {
                    // Get all active doctors for this tenant
                    $doctorsSql = "SELECT DISTINCT PM.Id 
                                   FROM PractitionerMaster PM
                                   INNER JOIN PractitionerSpecialityDetails PSD ON PM.Id = PSD.PractitionerMasterId
                                   WHERE PSD.TenantId = ? AND PM.IsActive = 1 AND PSD.IsActive = 1";
                    $doctorsResult = $this->db->query($doctorsSql, [$tid])->result_array();
                    $doctors = array_column($doctorsResult, 'Id');
                }
                
                if (empty($doctors)) {
                    continue;
                }
                
                // Calculate slots for each doctor
                foreach ($doctors as $docId) {
                    // Check if this date is a full-day holiday for tenant or doctor
                    $isFullDayHoliday = $this->isFullDayHoliday($dateStr, $tid, $docId, $holidays);
                    if ($isFullDayHoliday) {
                        continue; // Skip this day entirely
                    }
                    
                    // Get custom time-range holidays for this date, tenant, and doctor
                    $customHolidays = $this->getCustomHolidaysForDate($dateStr, $tid, $docId, $holidays);
                    
                    // Get doctor working hours for this day
                    $doctorHours = $this->callProc('usp_GetDoctorWorkingHours', [
                        'DoctorId' => $docId,
                        'TenantId' => $tid,
                        'ExecFlag' => 'CurrentDay',
                        'AppointmentDate' => $dateStr
                    ]);
                    
                    if (empty($doctorHours)) {
                        continue;
                    }
                    
                    // Filter by day
                    $doctorDayHours = array_filter($doctorHours, function($h) use ($dayId) {
                        $dayMasterId = $h['DayMasterId'] ?? $h['DayId'] ?? null;
                        return $dayMasterId == $dayId;
                    });
                    
                    if (empty($doctorDayHours)) {
                        continue;
                    }
                    
                    // Extract duration from first doctor hour record
                    $duration = 30; // Default
                    $firstDoctorSlot = reset($doctorDayHours);
                    $durationStr = $firstDoctorSlot['Duration'] ?? $firstDoctorSlot['AppointmentDuration'] ?? '30';
                    if (preg_match('/(\d+)/', (string)$durationStr, $matches)) {
                        $duration = (int)$matches[1];
                    }
                    
                    // Process each doctor working hour slot
                    foreach ($doctorDayHours as $doctorSlot) {
                        $doctorFromTime = $doctorSlot['FromTime'] ?? $doctorSlot['StartTime'] ?? null;
                        $doctorToTime = $doctorSlot['ToTime'] ?? $doctorSlot['EndTime'] ?? null;
                        
                        if (!$doctorFromTime || !$doctorToTime) {
                            continue;
                        }
                        
                        // Find intersection with each tenant hour slot (handle multiple tenant slots)
                        foreach ($tenantDayHours as $tenantSlot) {
                            $tenantFromTime = $tenantSlot['FromTime'] ?? $tenantSlot['StartTime'] ?? null;
                            $tenantToTime = $tenantSlot['ToTime'] ?? $tenantSlot['EndTime'] ?? null;
                            
                            if (!$tenantFromTime || !$tenantToTime) {
                                continue;
                            }
                            
                            // Find intersection of tenant and doctor hours
                            $slotStart = $this->maxTime($tenantFromTime, $doctorFromTime);
                            $slotEnd = $this->minTime($tenantToTime, $doctorToTime);
                            
                            $startMinutes = $this->timeToMinutes($slotStart);
                            $endMinutes = $this->timeToMinutes($slotEnd);
                            
                            if ($startMinutes >= $endMinutes) {
                                continue; // No overlap
                            }
                            
                            // Calculate slots excluding custom holiday time ranges
                            $slotsInRange = $this->calculateSlotsExcludingHolidays(
                                $startMinutes,
                                $endMinutes,
                                $duration,
                                $customHolidays
                            );
                            $totalSlots += max(0, $slotsInRange);
                        }
                    }
                }
            }
            
            $currentDate->modify('+1 day');
        }
        
        // Count utilised slots (booked appointments with registered status)
        $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
        // Parameter order: startDate, endDate, tenantIds (for IN clause), doctorId (optional)
        $utilisedParams = array_merge([$startDate, $endDate], $tenantIds);
        
        if ($doctorId !== null) {
            $utilisedParams[] = $doctorId;
        }
        
        $utilisedSql = "SELECT COUNT(*) AS Utilised
                        FROM Appointment a
                        LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                        WHERE CAST(a.AppointmentDate AS DATE) >= ?
                            AND CAST(a.AppointmentDate AS DATE) <= ?
                            AND a.IsActive = 1
                            AND a.TenantId IN ($placeholders)
                            AND (
                                UPPER(asm.AppointmentStatusCode) IN ('OPEN', 'CONFIRMED', 'BOOKED', 'REGISTERED', 'SCHEDULED', 'PENDING')
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%REGISTERED%'
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%CONFIRMED%'
                                OR UPPER(asm.AppointmentStatusDescription) LIKE '%BOOKED%'
                            )";
        
        if ($doctorId !== null) {
            $utilisedSql .= " AND a.PractitionerId = ?";
        }
        
        try {
            $utilisedQuery = $this->db->query($utilisedSql, $utilisedParams);
            $utilisedResult = $utilisedQuery->row_array();
            $utilised = (int)($utilisedResult['Utilised'] ?? 0);
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::calculateSlotCapacity - Utilised query error: " . $e->getMessage());
            $utilised = 0;
        }
        
        return [
            'totalSlots' => $totalSlots,
            'utilised' => $utilised
        ];
    }
    
    /**
     * Calculate slot capacity with daily breakdown
     * Returns detailed capacity information including daily slot counts
     * 
     * @param string $startDate Start date (YYYY-MM-DD)
     * @param string $endDate End date (YYYY-MM-DD)
     * @param array $tenantIds Array of tenant IDs
     * @param int|null $doctorId Optional: Filter by doctor
     * @return array Capacity data with daily breakdown
     */
    public function calculateSlotCapacityWithDailyBreakup($startDate, $endDate, $tenantIds, $doctorId = null)
    {
        $totalSlots = 0;
        $dailyBreakup = [];
        $slotMinutes = null; // set from first doctor's duration

        // Normalise doctorId coming from UI ("All Doctors" often passes 0)
        if ($doctorId !== null && (int)$doctorId <= 0) {
            $doctorId = null;
        }
       
        // Validate dates
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        if (empty($tenantIds)) {
            return [
                'slotMinutes' => 30,
                'totalSlots' => 0,
                'utilised' => 0,
                'available' => 0,
                'utilisationRate' => 0,
                'dailyBreakup' => []
            ];
        }

        // Fetch holidays/leaves for all tenants and doctors in the date range
        $holidays = $this->getHolidaysAndLeaves($startDate, $endDate, $tenantIds, $doctorId);

        // Init daily buckets
        $currentDate = new DateTime($startDate);
        $end = new DateTime($endDate);
        while ($currentDate <= $end) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayOfWeek = (int)$currentDate->format('w');
            $dayId = $dayOfWeek == 0 ? 7 : $dayOfWeek;

            $dailyBreakup[$dateStr] = [
                'date' => $dateStr,
                'dayId' => $dayId,
                'slots' => 0,
                'utilised' => 0,
                'available' => 0,
                'utilisationRate' => 0
            ];
            $currentDate->modify('+1 day');
        }

        // ===== SLOT CAPACITY (WORKING HOURS) =====
        $currentDate = new DateTime($startDate);
        $end = new DateTime($endDate);

        while ($currentDate <= $end) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayOfWeek = (int)$currentDate->format('w');
            $dayId = $dayOfWeek == 0 ? 7 : $dayOfWeek;

            $daySlots = 0;

            foreach ($tenantIds as $tid) {
                // Tenant working hours for the day
                $tenantHours = $this->callProc('usp_GetTenantWorkingHours', [
                    'TenantId' => $tid,
                    'ExecFlag' => 'CurrentDay',
                    'AppointmentDate' => $dateStr
                ]);

                if (empty($tenantHours)) {
                    continue;
                }

                $tenantDayHours = array_filter($tenantHours, function ($h) use ($dayId) {
                    $dayMasterId = $h['DayMasterId'] ?? $h['DayId'] ?? null;
                    return (int)$dayMasterId === (int)$dayId;
                });

                if (empty($tenantDayHours)) {
                    continue;
                }

                // Doctors for tenant
                $doctors = [];
                if ($doctorId !== null) {
                    $doctors = [(int)$doctorId];
                } else {
                    $doctorsSql = "SELECT DISTINCT PM.Id
                                   FROM PractitionerMaster PM
                                   INNER JOIN PractitionerSpecialityDetails PSD ON PM.Id = PSD.PractitionerMasterId
                                   WHERE PSD.TenantId = ? AND PM.IsActive = 1 AND PSD.IsActive = 1";
                    $doctorsResult = $this->db->query($doctorsSql, [$tid])->result_array();
                    $doctors = array_map('intval', array_column($doctorsResult, 'Id'));
                }

                if (empty($doctors)) {
                    continue;
                }

                foreach ($doctors as $docId) {
                    // Full day holiday?
                    if ($this->isFullDayHoliday($dateStr, $tid, $docId, $holidays)) {
                        continue;
                    }

                    $customHolidays = $this->getCustomHolidaysForDate($dateStr, $tid, $docId, $holidays);

                    // Doctor working hours for the day
                    $doctorHours = $this->callProc('usp_GetDoctorWorkingHours', [
                        'DoctorId' => $docId,
                        'TenantId' => $tid,
                        'ExecFlag' => 'CurrentDay',
                        'AppointmentDate' => $dateStr
                    ]);

                    if (empty($doctorHours)) {
                        continue;
                    }

                    $doctorDayHours = array_filter($doctorHours, function ($h) use ($dayId) {
                        $dayMasterId = $h['DayMasterId'] ?? $h['DayId'] ?? null;
                        return (int)$dayMasterId === (int)$dayId;
                    });

                    if (empty($doctorDayHours)) {
                        continue;
                    }

                    // Slot duration (minutes)
                    $duration = 30;
                    $firstDoctorSlot = reset($doctorDayHours);
                    $durationStr = $firstDoctorSlot['Duration'] ?? $firstDoctorSlot['AppointmentDuration'] ?? '30';
                    if (preg_match('/(\d+)/', (string)$durationStr, $matches)) {
                        $duration = (int)$matches[1];
                    }
                    if ($slotMinutes === null) {
                        $slotMinutes = $duration;
                    }

                    foreach ($doctorDayHours as $doctorSlot) {
                        $doctorFromTime = $doctorSlot['FromTime'] ?? $doctorSlot['StartTime'] ?? null;
                        $doctorToTime = $doctorSlot['ToTime'] ?? $doctorSlot['EndTime'] ?? null;

                        if (!$doctorFromTime || !$doctorToTime) {
                            continue;
                        }

                        foreach ($tenantDayHours as $tenantSlot) {
                            $tenantFromTime = $tenantSlot['FromTime'] ?? $tenantSlot['StartTime'] ?? null;
                            $tenantToTime = $tenantSlot['ToTime'] ?? $tenantSlot['EndTime'] ?? null;

                            if (!$tenantFromTime || !$tenantToTime) {
                                continue;
                            }

                            // Intersection of tenant + doctor hours
                            $slotStart = $this->maxTime($tenantFromTime, $doctorFromTime);
                            $slotEnd = $this->minTime($tenantToTime, $doctorToTime);

                            $startMinutes = $this->timeToMinutes($slotStart);
                            $endMinutes = $this->timeToMinutes($slotEnd);

                            if ($startMinutes >= $endMinutes) {
                                continue;
                            }

                            $slotsInRange = $this->calculateSlotsExcludingHolidays(
                                $startMinutes,
                                $endMinutes,
                                $duration,
                                $customHolidays
                            );

                            $daySlots += max(0, (int)$slotsInRange);
                        }
                    }
                }
            }

            if (isset($dailyBreakup[$dateStr])) {
                $dailyBreakup[$dateStr]['slots'] = $daySlots;
            }
            $totalSlots += $daySlots;

            $currentDate->modify('+1 day');
        }

        // ===== UTILISATION (BOOKED/REGISTERED APPOINTMENTS) =====
        $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));

        $utilisedSql = "SELECT
                            CAST(a.AppointmentDate AS DATE) AS ApptDate,
                            COUNT(*) AS Utilised
                        FROM Appointment a
                        LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                        WHERE CAST(a.AppointmentDate AS DATE) >= ?
                            AND CAST(a.AppointmentDate AS DATE) <= ?
                            AND a.IsActive = 1
                            AND a.TenantId IN ($placeholders)
                            AND (
                                UPPER(asm.AppointmentStatusCode) IN ('O', 'O', 'N')
                             
                            )";

        $utilisedParams = array_merge([$startDate, $endDate], $tenantIds);

        if ($doctorId !== null) {
            $utilisedSql .= " AND a.PractitionerId = ?";
            $utilisedParams[] = $doctorId;
        }

        $utilisedSql .= " GROUP BY CAST(a.AppointmentDate AS DATE)
                          ORDER BY CAST(a.AppointmentDate AS DATE) ASC";

        $utilisedTotal = 0;

        try {
            $utilisedQuery = $this->db->query($utilisedSql, $utilisedParams);

          
            $utilisedRows = $utilisedQuery->result_array();  

            foreach ($utilisedRows as $r) {
                $d = $r['ApptDate'];
                $c = (int)($r['Utilised'] ?? 0);
                $utilisedTotal += $c;

                if (isset($dailyBreakup[$d])) {
                    $dailyBreakup[$d]['utilised'] = $c;
                }
            }
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::calculateSlotCapacityWithDailyBreakup - Utilised query error: " . $e->getMessage());
        }

        // Final calculations per day
        foreach ($dailyBreakup as $d => &$info) {
            $info['available'] = max(0, (int)$info['slots'] - (int)$info['utilised']);
            $info['utilisationRate'] = ((int)$info['slots'] > 0)
                ? round(((int)$info['utilised'] / (int)$info['slots']) * 100, 1)
                : 0;
        }
        unset($info);

        $available = max(0, (int)$totalSlots - (int)$utilisedTotal);
        $utilisationRate = ((int)$totalSlots > 0) ? round(((int)$utilisedTotal / (int)$totalSlots) * 100, 1) : 0;

        return [
            'slotMinutes' => $slotMinutes ?? 30,
            'totalSlots' => (int)$totalSlots,
            'utilised' => (int)$utilisedTotal,
            'available' => (int)$available,
            'utilisationRate' => (float)$utilisationRate,
            'dailyBreakup' => array_values($dailyBreakup)
        ];
    }

    /**
     * Helper: Convert time string to minutes since midnight
     * @param string $timeStr Time in format "09:00 AM" or "09:00:00"
     * @return int Minutes since midnight
     */
    private function timeToMinutes($timeStr)
{
    if ($timeStr === null) {
        return 0;
    }

    $timeStr = trim((string)$timeStr);
    if ($timeStr === '') {
        return 0;
    }

    // Normalize things like "09:00:00.0000000" -> "09:00:00"
    $timeStr = preg_replace('/\.(\d+)$/', '', $timeStr);

    // Formats handled:
    //  - "09:00 AM" / "9:00 PM"
    //  - "09:00:00" / "09:00"
    if (preg_match('/^(\d{1,2}):(\d{2})(?::\d{2})?\s*(AM|PM)?$/i', $timeStr, $matches)) {
        $hour = (int)$matches[1];
        $minute = (int)$matches[2];
        $period = isset($matches[3]) ? strtoupper($matches[3]) : '';

        if ($period === 'PM' && $hour !== 12) {
            $hour += 12;
        } elseif ($period === 'AM' && $hour === 12) {
            $hour = 0;
        }

        return ($hour * 60) + $minute;
    }

    // Unknown format
    return 0;
}

/**
 * Helper: Get maximum (later) time between two time strings
 (later) time between two time strings
     * @param string $time1 Time string
     * @param string $time2 Time string
     * @return string Later time
     */
    private function maxTime($time1, $time2)
    {
        return $this->timeToMinutes($time1) > $this->timeToMinutes($time2) ? $time1 : $time2;
    }
    
    /**
     * Helper: Get minimum (earlier) time between two time strings
     * @param string $time1 Time string
     * @param string $time2 Time string
     * @return string Earlier time
     */
    private function minTime($time1, $time2)
    {
        return $this->timeToMinutes($time1) < $this->timeToMinutes($time2) ? $time1 : $time2;
    }

    /**
     * Get holidays and leaves for date range
     * 
     * @param string $startDate Start date (YYYY-MM-DD)
     * @param string $endDate End date (YYYY-MM-DD)
     * @param array $tenantIds Array of tenant IDs
     * @param int|null $doctorId Optional: Filter by doctor
     * @return array Array of holiday/leave records
     */
    private function getHolidaysAndLeaves($startDate, $endDate, $tenantIds, $doctorId = null)
    {
        $allHolidays = [];
        
        foreach ($tenantIds as $tid) {
            // Get tenant holidays
            try {
                $tenantHolidays = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
                    'TenantId' => $tid,
                    'DoctorId' => $doctorId ?? 0,
                    'Flag' => 'Tenant'
                ]);
                
                // Filter holidays within date range
                foreach ($tenantHolidays as $holiday) {
                    $leaveDate = isset($holiday['LeaveDate']) ? date('Y-m-d', strtotime($holiday['LeaveDate'])) : null;
                    if ($leaveDate && $leaveDate >= $startDate && $leaveDate <= $endDate) {
                        $holiday['TenantId'] = $tid;
                        $allHolidays[] = $holiday;
                    }
                }
            } catch (Exception $e) {
                error_log("GroupAdmin_Model::getHolidaysAndLeaves - Tenant holiday error: " . $e->getMessage());
            }
            
            // Get doctor holidays if doctorId is provided
            if ($doctorId !== null) {
                try {
                    $doctorHolidays = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
                        'TenantId' => $tid,
                        'DoctorId' => $doctorId,
                        'Flag' => 'Doctor'
                    ]);
                    
                    // Filter holidays within date range
                    foreach ($doctorHolidays as $holiday) {
                        $leaveDate = isset($holiday['LeaveDate']) ? date('Y-m-d', strtotime($holiday['LeaveDate'])) : null;
                        if ($leaveDate && $leaveDate >= $startDate && $leaveDate <= $endDate) {
                            $holiday['TenantId'] = $tid;
                            $holiday['DoctorId'] = $doctorId;
                            $allHolidays[] = $holiday;
                        }
                    }
                } catch (Exception $e) {
                    error_log("GroupAdmin_Model::getHolidaysAndLeaves - Doctor holiday error: " . $e->getMessage());
                }
            } else {
                // If no specific doctor, get holidays for all doctors in this tenant
                $doctorsSql = "SELECT DISTINCT PM.Id 
                               FROM PractitionerMaster PM
                               INNER JOIN PractitionerSpecialityDetails PSD ON PM.Id = PSD.PractitionerMasterId
                               WHERE PSD.TenantId = ? AND PM.IsActive = 1 AND PSD.IsActive = 1";
                $doctorsResult = $this->db->query($doctorsSql, [$tid])->result_array();
                $doctors = array_column($doctorsResult, 'Id');
                
                foreach ($doctors as $docId) {
                    try {
                        $doctorHolidays = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
                            'TenantId' => $tid,
                            'DoctorId' => $docId,
                            'Flag' => 'Doctor'
                        ]);
                        
                        // Filter holidays within date range
                        foreach ($doctorHolidays as $holiday) {
                            $leaveDate = isset($holiday['LeaveDate']) ? date('Y-m-d', strtotime($holiday['LeaveDate'])) : null;
                            if ($leaveDate && $leaveDate >= $startDate && $leaveDate <= $endDate) {
                                $holiday['TenantId'] = $tid;
                                $holiday['DoctorId'] = $docId;
                                $allHolidays[] = $holiday;
                            }
                        }
                    } catch (Exception $e) {
                        error_log("GroupAdmin_Model::getHolidaysAndLeaves - Doctor holiday error: " . $e->getMessage());
                    }
                }
            }
        }
        
        return $allHolidays;
    }
    
    /**
     * Check if a date is a full-day holiday
     * 
     * @param string $dateStr Date string (YYYY-MM-DD)
     * @param int $tenantId Tenant ID
     * @param int $doctorId Doctor ID
     * @param array $holidays Array of holiday records
     * @return bool True if full-day holiday
     */
    private function isFullDayHoliday($dateStr, $tenantId, $doctorId, $holidays)
    {
        foreach ($holidays as $holiday) {
            $leaveDate = isset($holiday['LeaveDate']) ? date('Y-m-d', strtotime($holiday['LeaveDate'])) : null;
            $holidayTenantId = $holiday['TenantId'] ?? null;
            $holidayDoctorId = $holiday['DoctorId'] ?? null;
            $leaveTypeId = isset($holiday['LeaveTypeId']) ? (int)$holiday['LeaveTypeId'] : null;
            
            // Check if this holiday applies to this date, tenant, and doctor
            if ($leaveDate === $dateStr && 
                $holidayTenantId == $tenantId &&
                ($holidayDoctorId == null || $holidayDoctorId == $doctorId) &&
                $leaveTypeId == 1) { // LeaveTypeId = 1 means full-day holiday
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get custom time-range holidays for a specific date
     * 
     * @param string $dateStr Date string (YYYY-MM-DD)
     * @param int $tenantId Tenant ID
     * @param int $doctorId Doctor ID
     * @param array $holidays Array of holiday records
     * @return array Array of custom holiday time ranges in minutes
     */
    private function getCustomHolidaysForDate($dateStr, $tenantId, $doctorId, $holidays)
    {
        $customHolidays = [];
        
        foreach ($holidays as $holiday) {
            $leaveDate = isset($holiday['LeaveDate']) ? date('Y-m-d', strtotime($holiday['LeaveDate'])) : null;
            $holidayTenantId = $holiday['TenantId'] ?? null;
            $holidayDoctorId = $holiday['DoctorId'] ?? null;
            $leaveTypeId = isset($holiday['LeaveTypeId']) ? (int)$holiday['LeaveTypeId'] : null;
            $fromTime = $holiday['FromTime'] ?? null;
            $toTime = $holiday['ToTime'] ?? null;
            
            // Check if this is a custom time-range holiday for this date, tenant, and doctor
            if ($leaveDate === $dateStr && 
                $holidayTenantId == $tenantId &&
                ($holidayDoctorId == null || $holidayDoctorId == $doctorId) &&
                $leaveTypeId == 2 && // LeaveTypeId = 2 means custom time-range holiday
                $fromTime && $toTime) {
                
                $customHolidays[] = [
                    'start' => $this->timeToMinutes($fromTime),
                    'end' => $this->timeToMinutes($toTime)
                ];
            }
        }
        
        return $customHolidays;
    }
    
    /**
     * Calculate slots excluding custom holiday time ranges
     * 
     * @param int $startMinutes Start time in minutes since midnight
     * @param int $endMinutes End time in minutes since midnight
     * @param int $duration Slot duration in minutes
     * @param array $customHolidays Array of custom holiday time ranges
     * @return int Number of slots excluding holidays
     */
    private function calculateSlotsExcludingHolidays($startMinutes, $endMinutes, $duration, $customHolidays)
    {
        if (empty($customHolidays)) {
            // No custom holidays, calculate normally
            return floor(($endMinutes - $startMinutes) / $duration);
        }
        
        // Sort holidays by start time
        usort($customHolidays, function($a, $b) {
            return $a['start'] - $b['start'];
        });
        
        $totalSlots = 0;
        $currentStart = $startMinutes;
        
        foreach ($customHolidays as $holiday) {
            $holidayStart = $holiday['start'];
            $holidayEnd = $holiday['end'];
            
            // If holiday is before our range, skip it
            if ($holidayEnd <= $currentStart) {
                continue;
            }
            
            // If holiday starts after our range, we're done
            if ($holidayStart >= $endMinutes) {
                break;
            }
            
            // Calculate slots before this holiday
            if ($holidayStart > $currentStart) {
                $slotsBeforeHoliday = floor(($holidayStart - $currentStart) / $duration);
                $totalSlots += max(0, $slotsBeforeHoliday);
            }
            
            // Move current start to after this holiday
            $currentStart = max($currentStart, $holidayEnd);
        }
        
        // Calculate remaining slots after all holidays
        if ($currentStart < $endMinutes) {
            $slotsAfterHolidays = floor(($endMinutes - $currentStart) / $duration);
            $totalSlots += max(0, $slotsAfterHolidays);
        }
        
        return $totalSlots;
    }
    
    /**
     * Get Utilised Slots Comparison (current period vs previous period)
     * Uses working hours and duration to calculate actual slot capacity
     * 
     * @param int $userId Group Admin user ID
     * @param string|null $startDate Current period start date (YYYY-MM-DD), null = Monday of this week
     * @param string|null $endDate Current period end date (YYYY-MM-DD), null = Sunday of this week
     * @param string $periodType Period type: 'WEEK', 'MONTH', 'YEAR', 'CUSTOM'
     * @param int|null $tenantId Optional: Filter by facility
     * @param int|null $doctorId Optional: Filter by doctor
     * @return array Slots comparison data
     */
    public function getSlotsComparison($userId, $startDate = null, $endDate = null, $periodType = 'WEEK', $tenantId = null, $doctorId = null)
    {
        try {
            // Calculate current period dates if not provided
            if (!$startDate || !$endDate) {
                $today = date('Y-m-d');
                $dayOfWeek = date('w', strtotime($today)); // 0 = Sunday, 1 = Monday, etc.
                
                // Calculate Monday of this week
                if ($dayOfWeek == 0) {
                    // If today is Sunday, go back 6 days to get Monday
                    $startDate = date('Y-m-d', strtotime('-6 days', strtotime($today)));
                } else {
                    // Go back (dayOfWeek - 1) days to get Monday
                    $startDate = date('Y-m-d', strtotime('-' . ($dayOfWeek - 1) . ' days', strtotime($today)));
                }
                
                // Calculate Sunday of this week
                $endDate = date('Y-m-d', strtotime('+6 days', strtotime($startDate)));
            }
            
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [
                    'availableFuture' => 0,
                    'available' => 0,
                    'totalSlots' => 0,
                    'utilised' => 0,
                    'utilisedPrev' => 0,
                    'utilisationRate' => 0,
                    'utilisationRatePrev' => 0,
                    'currentStartDate' => $startDate,
                    'currentEndDate' => $endDate,
                    'previousStartDate' => '',
                    'previousEndDate' => ''
                ];
            }
            
            // If specific tenant filter was provided, validate all are in scope
            if ($tenantId !== null && $tenantId !== '') {
                $allowedIds = $this->getTenantIdsForGroupAdmin($userId);
                $tenantIds = array_values(array_intersect($tenantIds, $allowedIds));
                if (empty($tenantIds)) {
                    return [
                        'availableFuture' => 0,
                        'available' => 0,
                        'totalSlots' => 0,
                        'utilised' => 0,
                        'utilisedPrev' => 0,
                        'utilisationRate' => 0,
                        'utilisationRatePrev' => 0,
                        'currentStartDate' => $startDate,
                        'currentEndDate' => $endDate,
                        'previousStartDate' => '',
                        'previousEndDate' => ''
                    ];
                }
            }
            
            // ===== CURRENT PERIOD DATA =====
            // Calculate slot capacity based on working hours
            $currentPeriodData = $this->calculateSlotCapacity($startDate, $endDate, $tenantIds, $doctorId);
            $totalSlots = $currentPeriodData['totalSlots'];
            $utilised = $currentPeriodData['utilised'];
            // Available = Total Slots - Utilised (Booking count)
            $available = max(0, $totalSlots - $utilised);
            $utilisationRate = $totalSlots > 0 ? round(($utilised / $totalSlots) * 100 * 10) / 10 : 0;
            
            // ===== PREVIOUS PERIOD DATA =====
            // Calculate previous period dates
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $periodDays = $start->diff($end)->days;
            
            $previousStart = clone $start;
            $previousEnd = clone $start;
            
            switch (strtoupper($periodType)) {
                case 'WEEK':
                    $previousStart->modify('-' . ($periodDays + 1) . ' days');
                    $previousEnd->modify('-1 day');
                    break;
                case 'MONTH':
                    $previousStart->modify('-1 month');
                    $previousEnd->modify('-1 day');
                    break;
                case 'YEAR':
                    $previousStart->modify('-1 year');
                    $previousEnd = clone $end;
                    $previousEnd->modify('-1 year');
                    break;
                default: // CUSTOM
                    $previousStart->modify('-' . ($periodDays + 1) . ' days');
                    $previousEnd->modify('-1 day');
                    break;
            }
            
            $previousStartDate = $previousStart->format('Y-m-d');
            $previousEndDate = $previousEnd->format('Y-m-d');
            
            // Calculate previous period slot capacity based on working hours
            $previousPeriodData = $this->calculateSlotCapacity($previousStartDate, $previousEndDate, $tenantIds, $doctorId);
            $previousTotalSlots = $previousPeriodData['totalSlots'];
            $utilisedPrev = $previousPeriodData['utilised'];
            $utilisationRatePrev = $previousTotalSlots > 0 ? round(($utilisedPrev / $previousTotalSlots) * 100 * 10) / 10 : 0;
            
            // ===== AVAILABLE FUTURE SLOTS =====
            // Calculate future start date (endDate + 1 day)
            // For future slots, we'll calculate for next 30 days (or until end of next period)
            $futureStartDate = date('Y-m-d', strtotime('+1 day', strtotime($endDate)));
            $futureEndDate = date('Y-m-d', strtotime('+30 days', strtotime($futureStartDate))); // Look ahead 30 days
            
            // Calculate future slot capacity based on working hours
            $futurePeriodData = $this->calculateSlotCapacity($futureStartDate, $futureEndDate, $tenantIds, $doctorId);
            $futureTotalSlots = $futurePeriodData['totalSlots'];
            $futureBookedSlots = $futurePeriodData['utilised'];
            $availableFuture = max(0, $futureTotalSlots - $futureBookedSlots);
            
            return [
                'availableFuture' => $availableFuture,
                'available' => $available, // Available = Total Slots - Utilised
                'totalSlots' => $totalSlots,
                'utilised' => $utilised,
                'utilisedPrev' => $utilisedPrev,
                'utilisationRate' => $utilisationRate,
                'utilisationRatePrev' => $utilisationRatePrev,
                'currentStartDate' => $startDate,
                'currentEndDate' => $endDate,
                'previousStartDate' => $previousStartDate,
                'previousEndDate' => $previousEndDate
            ];
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getSlotsComparison error: " . $e->getMessage());
            return [
                'availableFuture' => 0,
                'available' => 0,
                'totalSlots' => 0,
                'utilised' => 0,
                'utilisedPrev' => 0,
                'utilisationRate' => 0,
                'utilisationRatePrev' => 0,
                'currentStartDate' => $startDate ?? '',
                'currentEndDate' => $endDate ?? '',
                'previousStartDate' => '',
                'previousEndDate' => ''
            ];
        }
    }

    /**
     * Export Appointment Metrics Report
     * 
     * @param int $userId Group Admin User ID
     * @param string $format Export format: 'excel', 'csv', or 'pdf'
     * @param string|null $startDate Start date (YYYY-MM-DD)
     * @param string|null $endDate End date (YYYY-MM-DD)
     * @param int|null $tenantId Optional: Filter by facility
     * @param int|null $doctorId Optional: Filter by doctor
     * @return string File path to generated report
     */
    public function exportAppointmentMetricsReport($userId, $format, $startDate = null, $endDate = null, $tenantId = null, $doctorId = null)
    {
        try {
            // Get appointment metrics summary
            $appointmentData = $this->getAppointmentStatusSummary($userId, $tenantId, $startDate, $endDate, $doctorId);
            
            // Get detailed appointments with patient information
            $detailedAppointments = $this->getDetailedAppointmentsForExport($userId, $startDate, $endDate, $tenantId, $doctorId);
            
            // Prepare report data with summary and details
            $reportData = [];
            
            // Header section
            $reportData[] = ['Appointment Metrics Report'];
            $reportData[] = ['Period:', ($startDate && $endDate) ? "$startDate to $endDate" : 'All Time'];
            $reportData[] = ['Generated:', date('Y-m-d H:i:s')];
            $reportData[] = [];
            
            // Summary Metrics section
            $reportData[] = ['SUMMARY METRICS'];
            $reportData[] = ['Metric', 'Value', 'Rate (%)'];
            $reportData[] = ['Total Appointments', $appointmentData['totalAppointments'] ?? 0, ''];
            $reportData[] = ['Registered', $appointmentData['totalRegistered'] ?? 0, $this->calculateRate($appointmentData['totalRegistered'] ?? 0, $appointmentData['totalAppointments'] ?? 0)];
            $reportData[] = ['Cancelled', $appointmentData['totalCancelled'] ?? 0, $this->calculateRate($appointmentData['totalCancelled'] ?? 0, $appointmentData['totalAppointments'] ?? 0)];
            $reportData[] = ['No Show', $appointmentData['totalNoShow'] ?? 0, $this->calculateRate($appointmentData['totalNoShow'] ?? 0, $appointmentData['totalAppointments'] ?? 0)];
            $reportData[] = [];
            
            // Detailed Appointments section
            $reportData[] = ['DETAILED APPOINTMENTS'];
            $reportData[] = [
                'Appointment No',
                'Appointment Date',
                'Time',
                'Patient Name',
                'Patient PRN',
                'Patient Mobile',
                'Patient Email',
                'Doctor Name',
                'Doctor Code',
                'Facility',
                'Status',
                'Reason',
                'Remarks'
            ];
            
            // Add detailed appointment rows
            foreach ($detailedAppointments as $appt) {
                $reportData[] = [
                    $appt['AppointmentNo'] ?? '',
                    $appt['AppointmentDate'] ?? '',
                    ($appt['FromTime'] ?? '') . ($appt['ToTime'] ? ' - ' . $appt['ToTime'] : ''),
                    $appt['PatientName'] ?? '',
                    $appt['PatientPRN'] ?? '',
                    $appt['PatientMobile'] ?? '',
                    $appt['PatientEmail'] ?? '',
                    $appt['DoctorName'] ?? '',
                    $appt['DoctorCode'] ?? '',
                    $appt['TenantName'] ?? '',
                    $appt['AppointmentStatusDescription'] ?? '',
                    $appt['AppointmentReason'] ?? '',
                    $appt['Remarks'] ?? ''
                ];
            }

            // Generate file based on format
            $fileName = 'appointment_metrics_' . ($startDate ? $startDate : 'all') . ($endDate ? '_' . $endDate : '') . '_' . date('YmdHis');
            $filePath = $this->generateReportFile($reportData, 'Appointment Metrics Report', $fileName, $format);

            return $filePath;

        } catch (Exception $e) {
            error_log("GroupAdmin_Model::exportAppointmentMetricsReport error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get detailed appointments for export with patient information
     * 
     * @param int $userId Group Admin User ID
     * @param string|null $startDate Start date (YYYY-MM-DD)
     * @param string|null $endDate End date (YYYY-MM-DD)
     * @param int|null $tenantId Optional: Filter by facility
     * @param int|null $doctorId Optional: Filter by doctor
     * @return array
     */
    private function getDetailedAppointmentsForExport($userId, $startDate = null, $endDate = null, $tenantId = null, $doctorId = null)
    {
        try {
            // Load EncDecAlgorithm library for decrypting patient data
            require_once(APPPATH . 'libraries/EncDecAlgorithm.php');
            
            // Calculate date range if not provided
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
            $tenantIds = $this->resolveTenantIds($userId, $tenantId);
            
            if (empty($tenantIds)) {
                return [];
            }
            
            $placeholders = implode(',', array_fill(0, count($tenantIds), '?'));
            
            $sql = "SELECT 
                        a.Id AS AppointmentId,
                        a.AppointmentNo,
                        CAST(a.AppointmentDate AS DATE) AS AppointmentDate,
                        CASE 
                            WHEN a.FromTime IS NOT NULL THEN CONVERT(VARCHAR(5), CAST(a.FromTime AS TIME), 108)
                            ELSE ''
                        END AS FromTime,
                        CASE 
                            WHEN a.ToTime IS NOT NULL THEN CONVERT(VARCHAR(5), CAST(a.ToTime AS TIME), 108)
                            ELSE ''
                        END AS ToTime,
                        a.TenantId,
                        t.TenantName,
                        t.TenantCode,
                        a.PatientId,
                        p.FullName AS PatientName,
                        p.PRN AS PatientPRN,
                        p.MobileCode AS PatientMobileCode,
                        p.MobileNumber AS PatientMobileNumber,
                        p.Email AS PatientEmail,
                        a.PractitionerId,
                        pm.PractitionerName AS DoctorName,
                        pm.PractitionerCode AS DoctorCode,
                        a.AppointmentStatusId,
                        asm.AppointmentStatusDescription,
                        a.AppointmentReason,
                        a.Remarks,
                        rgm.RingGroupMasterId AS RingGroupId,
                        rgm.RingGroupName
                    FROM Appointment a
                    INNER JOIN Tenants t ON a.TenantId = t.TenantId
                    LEFT JOIN PatientMaster p ON a.PatientId = p.PatientId
                    LEFT JOIN PractitionerMaster pm ON a.PractitionerId = pm.Id
                    LEFT JOIN AppointmentStatusMaster asm ON a.AppointmentStatusId = asm.Id
                    LEFT JOIN RingGroupTenants rgt ON a.TenantId = rgt.TenantId
                    LEFT JOIN RingGroupMaster rgm ON rgt.RingGroupId = rgm.RingGroupMasterId
                    WHERE a.TenantId IN ($placeholders)
                        AND CAST(a.AppointmentDate AS DATE) >= ?
                        AND CAST(a.AppointmentDate AS DATE) <= ?
                        AND a.IsActive = 1";
            
            $params = array_merge($tenantIds, [$startDate, $endDate]);
            
            // Add doctor filter if provided
            if ($doctorId !== null) {
                $sql .= " AND a.PractitionerId = ?";
                $params[] = $doctorId;
            }
            
            $sql .= " ORDER BY a.AppointmentDate, a.FromTime, t.TenantName";
            
            $query = $this->db->query($sql, $params);
            $appointments = $query->result_array();
            
            // Decrypt patient sensitive data and construct PatientMobile
            foreach ($appointments as &$appointment) {
                // Decrypt Patient Name
                if (!empty($appointment['PatientName'])) {
                    $appointment['PatientName'] = EncDecAlgorithm::decrypt($appointment['PatientName']);
                }
                
                // Decrypt Patient Mobile Number and construct PatientMobile field
                $mobileCode = $appointment['PatientMobileCode'] ?? '';
                $mobileNumber = '';
                if (!empty($appointment['PatientMobileNumber'])) {
                    $mobileNumber = EncDecAlgorithm::decrypt($appointment['PatientMobileNumber']);
                }
                
                // Construct PatientMobile field (MobileCode is plain text, MobileNumber is decrypted)
                if (!empty($mobileNumber) && !empty($mobileCode)) {
                    $appointment['PatientMobile'] = $mobileCode . ' ' . $mobileNumber;
                } elseif (!empty($mobileNumber)) {
                    $appointment['PatientMobile'] = $mobileNumber;
                } else {
                    $appointment['PatientMobile'] = '';
                }
                
                // Remove the separate fields as they're not needed in the export
                unset($appointment['PatientMobileCode']);
                unset($appointment['PatientMobileNumber']);
                
                // Decrypt Patient Email
                if (!empty($appointment['PatientEmail'])) {
                    $appointment['PatientEmail'] = EncDecAlgorithm::decrypt($appointment['PatientEmail']);
                }
            }
            unset($appointment); // Break reference
            
            return $appointments;
            
        } catch (Exception $e) {
            error_log("GroupAdmin_Model::getDetailedAppointmentsForExport error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Export Visit Metrics Report
     * 
     * @param int $userId Group Admin User ID
     * @param string $format Export format: 'excel', 'csv', or 'pdf'
     * @param string|null $startDate Start date (YYYY-MM-DD)
     * @param string|null $endDate End date (YYYY-MM-DD)
     * @param int|null $tenantId Optional: Filter by facility
     * @param int|null $doctorId Optional: Filter by doctor
     * @return string File path to generated report
     */
    public function exportVisitMetricsReport($userId, $format, $startDate = null, $endDate = null, $tenantId = null, $doctorId = null)
    {
        try {
            // Get visit statistics data
            $visitData = $this->getVisitStatistics($userId, $startDate, $endDate, $tenantId, $doctorId);
            
            // Prepare report data
            $totalVisits = $visitData['totalVisits'] ?? 0;
            $newPatientVisits = $visitData['newPatientVisits'] ?? 0;
            $repeatPatientVisits = $visitData['repeatPatientVisits'] ?? 0;
            
            $reportData = [
                ['Visit Metrics Report'],
                ['Period:', ($startDate && $endDate) ? "$startDate to $endDate" : 'All Time'],
                ['Generated:', date('Y-m-d H:i:s')],
                [],
                ['Metric', 'Value', 'Rate (%)'],
                ['Total Visits', $totalVisits, '100.0'],
                ['New Patient Visits', $newPatientVisits, $this->calculateRate($newPatientVisits, $totalVisits)],
                ['Repeat Patient Visits', $repeatPatientVisits, $this->calculateRate($repeatPatientVisits, $totalVisits)],
            ];

            // Generate file based on format
            $fileName = 'visit_metrics_' . ($startDate ? $startDate : 'all') . ($endDate ? '_' . $endDate : '') . '_' . date('YmdHis');
            $filePath = $this->generateReportFile($reportData, 'Visit Metrics Report', $fileName, $format);

            return $filePath;

        } catch (Exception $e) {
            error_log("GroupAdmin_Model::exportVisitMetricsReport error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate report file based on format
     * 
     * @param array $data Report data array
     * @param string $title Report title
     * @param string $fileName Base file name (without extension)
     * @param string $format Format: 'excel', 'csv', or 'pdf'
     * @return string File path to generated report
     */
    private function generateReportFile($data, $title, $fileName, $format)
    {
        // Create reports directory if it doesn't exist
        $reportsDir = FCPATH . 'reports/';
        if (!is_dir($reportsDir)) {
            mkdir($reportsDir, 0755, true);
        }

        $filePath = '';

        switch (strtolower($format)) {
            case 'csv':
                $filePath = $reportsDir . $fileName . '.csv';
                $this->generateCSV($data, $filePath);
                break;

            case 'excel':
                $filePath = $reportsDir . $fileName . '.xlsx';
                $actualFilePath = $this->generateExcel($data, $title, $filePath);
                // If CSV fallback was used, the file path might have changed
                if ($actualFilePath !== $filePath && file_exists($actualFilePath)) {
                    $filePath = $actualFilePath;
                }
                break;

            case 'pdf':
                $filePath = $reportsDir . $fileName . '.pdf';
                $this->generatePDF($data, $title, $filePath);
                break;

            default:
                throw new Exception("Unsupported format: $format");
        }

        return $filePath;
    }

    /**
     * Generate CSV file
     */
    private function generateCSV($data, $filePath)
    {
        $file = fopen($filePath, 'w');
        
        foreach ($data as $row) {
            // Escape CSV values
            $escapedRow = array_map(function($cell) {
                $cell = str_replace('"', '""', $cell);
                if (strpos($cell, ',') !== false || strpos($cell, "\n") !== false || strpos($cell, '"') !== false) {
                    return '"' . $cell . '"';
                }
                return $cell;
            }, $row);
            
            fputcsv($file, $escapedRow);
        }
        
        fclose($file);
    }

    /**
     * Generate Excel file (XLSX)
     * Returns the actual file path (may differ if CSV fallback is used)
     */
    private function generateExcel($data, $title, $filePath)
    {
        // Try to use PhpSpreadsheet if available
        if (class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            try {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle('Report');

                // Set data
                $rowNum = 1;
                $summaryEndRow = 0;
                $detailStartRow = 0;
                
                foreach ($data as $rowIndex => $row) {
                    $colNum = 1;
                    foreach ($row as $cell) {
                        $sheet->setCellValueByColumnAndRow($colNum, $rowNum, $cell);
                        $colNum++;
                    }
                    
                    // Detect section headers
                    if (isset($row[0])) {
                        if ($row[0] === 'SUMMARY METRICS') {
                            $sheet->getStyle("A$rowNum")->getFont()->setBold(true)->setSize(12);
                            $rowNum++;
                            continue;
                        } elseif ($row[0] === 'DETAILED APPOINTMENTS') {
                            $summaryEndRow = $rowNum - 1;
                            $detailStartRow = $rowNum;
                            $sheet->getStyle("A$rowNum")->getFont()->setBold(true)->setSize(12);
                        }
                    }
                    
                    // Style summary header row
                    if ($rowIndex === 4 && isset($row[0]) && $row[0] === 'Metric') {
                        $lastCol = $this->getColumnLetter(count($row));
                        $sheet->getStyle("A$rowNum:$lastCol$rowNum")->getFont()->setBold(true);
                        $sheet->getStyle("A$rowNum:$lastCol$rowNum")->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFE0E0E0');
                    }
                    
                    // Style detailed appointments header row
                    if ($detailStartRow > 0 && $rowNum === $detailStartRow + 1) {
                        $lastCol = $this->getColumnLetter(count($row));
                        $sheet->getStyle("A$rowNum:$lastCol$rowNum")->getFont()->setBold(true);
                        $sheet->getStyle("A$rowNum:$lastCol$rowNum")->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFE0E0E0');
                    }
                    
                    $rowNum++;
                }

                // Auto-size columns
                $maxCol = $this->getColumnLetter(max(array_map('count', $data)));
                foreach (range('A', $maxCol) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save($filePath);
                
                // Verify file was created successfully
                if (!file_exists($filePath) || filesize($filePath) === 0) {
                    throw new Exception("Failed to create Excel file or file is empty");
                }
                
                return $filePath;
                
            } catch (Exception $e) {
                error_log("PhpSpreadsheet error: " . $e->getMessage());
                // Fall through to CSV fallback
                return $this->generateCSVFallback($data, $filePath);
            }
        } else {
            // PhpSpreadsheet not available, use CSV fallback
            error_log("PhpSpreadsheet not available. Using CSV fallback for Excel export.");
            return $this->generateCSVFallback($data, $filePath);
        }
    }
    
    /**
     * Generate CSV file as fallback for Excel (when PhpSpreadsheet is not available)
     * Changes file extension to .csv and returns the new file path
     */
    private function generateCSVFallback($data, $filePath)
    {
        // Change extension to .csv for proper CSV file
        $csvFilePath = preg_replace('/\.xlsx$/i', '.csv', $filePath);
        
        // Generate CSV file with correct extension
        $this->generateCSV($data, $csvFilePath);
        
        error_log("CSV file generated as fallback (PhpSpreadsheet not available). File saved to: $csvFilePath");
        
        return $csvFilePath;
    }

    /**
     * Helper: Get Excel column letter from number
     */
    private function getColumnLetter($colNum)
    {
        $letter = '';
        while ($colNum > 0) {
            $colNum--;
            $letter = chr(65 + ($colNum % 26)) . $letter;
            $colNum = intval($colNum / 26);
        }
        return $letter ?: 'A';
    }

    /**
     * Generate Excel XML format (fallback if PhpSpreadsheet not available)
     */
    private function generateExcelXML($data, $filePath)
    {
        $xml = '<?xml version="1.0"?>' . "\n";
        $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        $xml .= ' xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
        $xml .= ' xmlns:x="urn:schemas-microsoft-com:office:excel"' . "\n";
        $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        $xml .= ' xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";
        $xml .= '<Worksheet ss:Name="Report">' . "\n";
        $xml .= '<Table>' . "\n";

        foreach ($data as $row) {
            $xml .= '<Row>' . "\n";
            foreach ($row as $cell) {
                $cell = htmlspecialchars($cell, ENT_XML1);
                $xml .= '<Cell><Data ss:Type="String">' . $cell . '</Data></Cell>' . "\n";
            }
            $xml .= '</Row>' . "\n";
        }

        $xml .= '</Table>' . "\n";
        $xml .= '</Worksheet>' . "\n";
        $xml .= '</Workbook>';

        file_put_contents($filePath, $xml);
    }

    /**
     * Generate PDF file
     */
    private function generatePDF($data, $title, $filePath)
    {
        // Try to use mPDF if available
        if (class_exists('\Mpdf\Mpdf')) {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L', // Landscape for wide tables
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 16,
                'margin_bottom' => 16,
            ]);

            $html = '<h1 style="text-align:center;margin-bottom:10px;">' . htmlspecialchars($title) . '</h1>';
            
            $inSummarySection = false;
            $inDetailSection = false;
            $summaryTableStarted = false;
            $detailTableStarted = false;
            
            foreach ($data as $rowIndex => $row) {
                // Check for section headers
                if (isset($row[0])) {
                    if ($row[0] === 'SUMMARY METRICS') {
                        $inSummarySection = true;
                        $inDetailSection = false;
                        $html .= '<h2 style="margin-top:15px;margin-bottom:5px;font-size:14px;font-weight:bold;">Summary Metrics</h2>';
                        continue;
                    } elseif ($row[0] === 'DETAILED APPOINTMENTS') {
                        $inSummarySection = false;
                        $inDetailSection = true;
                        if ($summaryTableStarted) {
                            $html .= '</table>';
                            $summaryTableStarted = false;
                        }
                        $html .= '<h2 style="margin-top:20px;margin-bottom:5px;font-size:14px;font-weight:bold;">Detailed Appointments</h2>';
                        $html .= '<table border="1" cellpadding="4" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:8px;">';
                        $detailTableStarted = true;
                        continue;
                    }
                }
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                // Start summary table if needed
                if ($inSummarySection && !$summaryTableStarted && isset($row[0]) && $row[0] === 'Metric') {
                    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;">';
                    $summaryTableStarted = true;
                }
                
                // Add table row
                if ($summaryTableStarted || $detailTableStarted) {
                    $html .= '<tr>';
                    $isHeaderRow = ($inSummarySection && $rowIndex === 4) || ($inDetailSection && isset($row[0]) && $row[0] === 'Appointment No');
                    
                    foreach ($row as $cell) {
                        $tag = $isHeaderRow ? 'th' : 'td';
                        $style = $isHeaderRow ? 'background-color:#f0f0f0;font-weight:bold;padding:5px;' : 'padding:4px;';
                        $html .= "<$tag style=\"$style\">" . htmlspecialchars($cell) . "</$tag>";
                    }
                    $html .= '</tr>';
                }
            }
            
            if ($summaryTableStarted || $detailTableStarted) {
                $html .= '</table>';
            }

            $mpdf->WriteHTML($html);
            $mpdf->Output($filePath, 'F');
        } else {
            // Fallback: Use FPDF
            require_once(APPPATH . 'libraries/fpdf/fpdf.php');
            $pdf = new FPDF('L', 'mm', 'A4'); // Landscape orientation
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, $title, 0, 1, 'C');
            $pdf->Ln(5);

            $inSummarySection = false;
            $inDetailSection = false;
            $summaryColWidths = [60, 50, 40];
            $detailColWidths = [30, 25, 20, 40, 25, 30, 35, 35, 20, 30, 25, 30, 30];
            $rowHeight = 6;
            $pdf->SetFont('Arial', '', 9);

            foreach ($data as $rowIndex => $row) {
                // Check for section headers
                if (isset($row[0])) {
                    if ($row[0] === 'SUMMARY METRICS') {
                        $inSummarySection = true;
                        $inDetailSection = false;
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(0, 8, 'Summary Metrics', 0, 1);
                        $pdf->Ln(2);
                        continue;
                    } elseif ($row[0] === 'DETAILED APPOINTMENTS') {
                        $inSummarySection = false;
                        $inDetailSection = true;
                        $pdf->AddPage();
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(0, 8, 'Detailed Appointments', 0, 1);
                        $pdf->Ln(2);
                        continue;
                    }
                }
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                $colWidths = $inDetailSection ? $detailColWidths : $summaryColWidths;
                $isHeaderRow = ($inSummarySection && isset($row[0]) && $row[0] === 'Metric') || 
                              ($inDetailSection && isset($row[0]) && $row[0] === 'Appointment No');
                
                if ($isHeaderRow) {
                    $pdf->SetFont('Arial', 'B', 8);
                } else {
                    $pdf->SetFont('Arial', '', 7);
                }

                foreach ($row as $colIndex => $cell) {
                    $width = $colWidths[$colIndex] ?? 30;
                    $pdf->Cell($width, $rowHeight, substr($cell, 0, 20), 1, 0, 'L');
                }
                $pdf->Ln();
            }

            $pdf->Output('F', $filePath);
        }
    }

    /**
     * Calculate percentage rate
     */
    private function calculateRate($value, $total)
    {
        if ($total == 0) {
            return '0.0';
        }
        return number_format(($value / $total) * 100, 1);
    }
}
