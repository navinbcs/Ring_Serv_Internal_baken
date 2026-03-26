<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Billing Model
 *
 * Handles billing/dashboard data from ChargeEntryHeader + PaymentDetails (RING.Web pattern).
 * Tables: ChargeEntryHeader, Enrollment, PaymentDetails, PatientMaster.
 */
class Billing_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (!class_exists('EncDecAlgorithm')) {
            require_once APPPATH . 'libraries/EncDecAlgorithm.php';
        }
    }

    /**
     * Build tenant filter clause for billing queries.
     * Returns ['clause' => string, 'params' => array] or null if no tenant scope.
     * Supports tenantId as single int or comma-separated string (e.g. "1753,1754").
     */
    public function getTenantFilter($tenantId, $tenantIds)
    {
        if (!empty($tenantIds) && is_array($tenantIds)) {
            $ids = array_map('intval', array_filter($tenantIds));
            if (empty($ids)) {
                return null;
            }
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            return ['clause' => 'ceh.TenantId IN ('.$placeholders.')', 'params' => $ids];
        }
        if ($tenantId !== null && $tenantId !== '') {
            $tenantIdStr = (string) $tenantId;
            if (strpos($tenantIdStr, ',') !== false) {
                $ids = array_values(array_filter(array_map('intval', explode(',', $tenantIdStr))));
                if (empty($ids)) {
                    return null;
                }
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                return ['clause' => 'ceh.TenantId IN ('.$placeholders.')', 'params' => $ids];
            }
            return ['clause' => 'ceh.TenantId = ?', 'params' => [(int) $tenantId]];
        }
        return null;
    }

    /**
     * Total Billed = SUM(ChargeEntryHeader.PatientPayable) for period.
     */
    public function getTotalBilled($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return 0;
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT ISNULL(SUM(ceh.PatientPayable), 0) AS Total
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q->row();
            return $row ? (float) $row->Total : 0;
        } catch (Exception $e) {
            error_log('Billing_model::getTotalBilled error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Pending Amount = SUM of (PatientPayable - paid) for each bill in period where amount is still owed.
     * Total Billed = Paid Amount + Pending Amount.
     */
    public function getPendingAmount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return 0;
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT ISNULL(SUM(CASE WHEN ceh.PatientPayable > ISNULL(pay.Paid, 0)
                        THEN ceh.PatientPayable - ISNULL(pay.Paid, 0) ELSE 0 END), 0) AS Total
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    LEFT JOIN (
                        SELECT ChargeEntryHeaderId, SUM(PaymentAmount) AS Paid
                        FROM PaymentDetails
                        WHERE isActive = 1 OR isActive IS NULL
                        GROUP BY ChargeEntryHeaderId
                    ) pay ON pay.ChargeEntryHeaderId = ceh.Id
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q->row();
            return $row ? (float) $row->Total : 0;
        } catch (Exception $e) {
            error_log('Billing_model::getPendingAmount error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Paid Amount = SUM(PaymentDetails.PaymentAmount) for ChargeEntryHeaders in period.
     */
    public function getPaidAmount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return 0;
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT ISNULL(SUM(pd.PaymentAmount), 0) AS Total
                    FROM PaymentDetails pd
                    INNER JOIN ChargeEntryHeader ceh ON pd.ChargeEntryHeaderId = ceh.Id
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1
                      AND (pd.isActive = 1 OR pd.isActive IS NULL)";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q->row();
            return $row ? (float) $row->Total : 0;
        } catch (Exception $e) {
            error_log('Billing_model::getPaidAmount error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Visit count = COUNT of ChargeEntryHeader rows in period.
     */
    public function getVisitCount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return 0;
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT COUNT(ceh.Id) AS Cnt
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q->row();
            return $row ? (int) $row->Cnt : 0;
        } catch (Exception $e) {
            error_log('Billing_model::getVisitCount error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Outstanding bills = count of ChargeEntryHeaders where total paid < PatientPayable.
     */
    public function getOutstandingCount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return 0;
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT COUNT(*) AS Cnt
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    LEFT JOIN (
                        SELECT ChargeEntryHeaderId, SUM(PaymentAmount) AS Paid
                        FROM PaymentDetails
                        WHERE isActive = 1 OR isActive IS NULL
                        GROUP BY ChargeEntryHeaderId
                    ) pay ON pay.ChargeEntryHeaderId = ceh.Id
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1
                      AND ISNULL(ceh.PatientPayable, 0) > ISNULL(pay.Paid, 0)";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $q = $this->db->query($sql, $params);
            $row = $q->row();
            return $row ? (int) $row->Cnt : 0;
        } catch (Exception $e) {
            error_log('Billing_model::getOutstandingCount error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Payment method breakdown: SUM(PaymentAmount) GROUP BY PaymentModeID.
     * RING.Web: 1=Cash, 2=Card, 3=Cheque, 4=Insurance.
     */
    public function getPaymentMethods($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        $labels = [1 => 'Cash', 2 => 'Card', 3 => 'Cheque', 4 => 'Insurance'];
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return [];
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT pd.PaymentModeID, ISNULL(SUM(pd.PaymentAmount), 0) AS Amount
                    FROM PaymentDetails pd
                    INNER JOIN ChargeEntryHeader ceh ON pd.ChargeEntryHeaderId = ceh.Id
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1
                      AND (pd.isActive = 1 OR pd.isActive IS NULL)";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $sql .= " GROUP BY pd.PaymentModeID";
            $q = $this->db->query($sql, $params);
            $rows = $q->result();
            $total = 0;
            foreach ($rows as $r) {
                $total += (float) $r->Amount;
            }
            $out = [];
            foreach ($rows as $r) {
                $amount = (float) $r->Amount;
                $out[] = [
                    'method'     => isset($labels[(int) $r->PaymentModeID]) ? $labels[(int) $r->PaymentModeID] : 'Other',
                    'amount'     => $amount,
                    'percentage' => $total > 0 ? round(($amount / $total) * 100, 1) : 0,
                ];
            }
            return $out;
        } catch (Exception $e) {
            error_log('Billing_model::getPaymentMethods error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Paid vs Pending by day-of-week (Mon–Sun) for trend chart.
     */
    public function getPaidVsPendingTrend($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $paid   = [0, 0, 0, 0, 0, 0, 0];
        $pending = [0, 0, 0, 0, 0, 0, 0];
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return ['labels' => $labels, 'series' => [['name' => 'Paid', 'data' => $paid], ['name' => 'Pending', 'data' => $pending]]];
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT DATEPART(WEEKDAY, CAST(ceh.BillDate AS DATE)) AS DayOfWeek,
                           ISNULL(SUM(ceh.PatientPayable), 0) AS Billed
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    WHERE ".$tenantFilter['clause']." AND CAST(ceh.BillDate AS DATE) >= ? AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(ceh.BillDate AS DATE))";
            $q = $this->db->query($sql, $params);
            foreach ($q->result() as $r) {
                $idx = (int) $r->DayOfWeek;
                $dayIndex = ($idx == 1) ? 6 : $idx - 2;
                if ($dayIndex >= 0 && $dayIndex <= 6) {
                    $pending[$dayIndex] = (float) $r->Billed;
                }
            }
            $params2 = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql2 = "SELECT DATEPART(WEEKDAY, CAST(ceh.BillDate AS DATE)) AS DayOfWeek,
                            ISNULL(SUM(pd.PaymentAmount), 0) AS Paid
                     FROM PaymentDetails pd
                     INNER JOIN ChargeEntryHeader ceh ON pd.ChargeEntryHeaderId = ceh.Id
                     INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                     WHERE ".$tenantFilter['clause']." AND CAST(ceh.BillDate AS DATE) >= ? AND CAST(ceh.BillDate AS DATE) <= ?
                       AND ceh.IsActive = 1 AND (pd.isActive = 1 OR pd.isActive IS NULL)";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql2 .= " AND e.PrimaryPractitionerId = ?";
                $params2[] = $practitionerId;
            }
            $sql2 .= " GROUP BY DATEPART(WEEKDAY, CAST(ceh.BillDate AS DATE))";
            $q2 = $this->db->query($sql2, $params2);
            foreach ($q2->result() as $r) {
                $idx = (int) $r->DayOfWeek;
                $dayIndex = ($idx == 1) ? 6 : $idx - 2;
                if ($dayIndex >= 0 && $dayIndex <= 6) {
                    $paid[$dayIndex]   = (float) $r->Paid;
                    $pending[$dayIndex] = max(0, $pending[$dayIndex] - (float) $r->Paid);
                }
            }
            return [
                'labels' => $labels,
                'series' => [
                    ['name' => 'Paid', 'data' => $paid],
                    ['name' => 'Pending', 'data' => $pending],
                ],
            ];
        } catch (Exception $e) {
            error_log('Billing_model::getPaidVsPendingTrend error: ' . $e->getMessage());
            return ['labels' => $labels, 'series' => [['name' => 'Paid', 'data' => $paid], ['name' => 'Pending', 'data' => $pending]]];
        }
    }

    /**
     * Daily revenue = SUM(PatientPayable) per day-of-week for chart.
     */
    public function getDailyRevenue($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $data   = [0, 0, 0, 0, 0, 0, 0];
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return ['labels' => $labels, 'data' => $data];
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT DATEPART(WEEKDAY, CAST(ceh.BillDate AS DATE)) AS DayOfWeek,
                           ISNULL(SUM(ceh.PatientPayable), 0) AS Revenue
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    WHERE ".$tenantFilter['clause']." AND CAST(ceh.BillDate AS DATE) >= ? AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $sql .= " GROUP BY DATEPART(WEEKDAY, CAST(ceh.BillDate AS DATE))";
            $q = $this->db->query($sql, $params);
            foreach ($q->result() as $r) {
                $idx = (int) $r->DayOfWeek;
                $dayIndex = ($idx == 1) ? 6 : $idx - 2;
                if ($dayIndex >= 0 && $dayIndex <= 6) {
                    $data[$dayIndex] = (float) $r->Revenue;
                }
            }
            return ['labels' => $labels, 'data' => $data];
        } catch (Exception $e) {
            error_log('Billing_model::getDailyRevenue error: ' . $e->getMessage());
            return ['labels' => $labels, 'data' => $data];
        }
    }

    /**
     * Recent bills: ChargeEntryHeader with BillNo, BillDate, PatientPayable, paid sum, status.
     * Patient name decrypted from PatientMaster (FullName/LastName).
     */
    public function getRecentBills($practitionerId, $tenantId, $tenantIds, $startDate, $endDate, $limit = 20)
    {
        $paymentModeLabels = [1 => 'Cash', 2 => 'Card', 3 => 'Cheque', 4 => 'Insurance'];
        try {
            $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
            if ($tenantFilter === null) {
                return [];
            }
            $params = array_merge($tenantFilter['params'], [$startDate, $endDate]);
            $sql = "SELECT ceh.Id, ceh.BillNo, ceh.BillDate, ceh.PatientPayable AS Amount, ceh.PatientId, e.Prn AS PatientPRN,
                           p.FullName, p.LastName,
                           (SELECT ISNULL(SUM(pd2.PaymentAmount), 0) FROM PaymentDetails pd2 WHERE pd2.ChargeEntryHeaderId = ceh.Id AND (pd2.isActive = 1 OR pd2.isActive IS NULL)) AS PaidAmount,
                           (SELECT TOP 1 pd3.PaymentModeID FROM PaymentDetails pd3 WHERE pd3.ChargeEntryHeaderId = ceh.Id AND (pd3.isActive = 1 OR pd3.isActive IS NULL) ORDER BY pd3.PaymentDetailsID DESC) AS LastPaymentModeId
                    FROM ChargeEntryHeader ceh
                    INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id
                    INNER JOIN PatientMaster p ON ceh.PatientId = p.PatientId
                    WHERE ".$tenantFilter['clause']."
                      AND CAST(ceh.BillDate AS DATE) >= ?
                      AND CAST(ceh.BillDate AS DATE) <= ?
                      AND ceh.IsActive = 1";
            if ($practitionerId !== null && $practitionerId !== '') {
                $sql .= " AND e.PrimaryPractitionerId = ?";
                $params[] = $practitionerId;
            }
            $sql .= " ORDER BY ceh.BillDate DESC, ceh.Id DESC";
            if ($this->db->dbdriver === 'sqlsrv' || (isset($this->db->subdriver) && $this->db->subdriver === 'sqlsrv')) {
                $sql = preg_replace('/^SELECT /i', 'SELECT TOP ' . (int) $limit . ' ', $sql, 1);
            } else {
                $sql .= " LIMIT " . (int) $limit;
            }
            $q = $this->db->query($sql, $params);
            $list = [];
            foreach ($q->result() as $row) {
                $amount     = (float) $row->Amount;
                $paid       = (float) $row->PaidAmount;
                $pending    = max(0, $amount - $paid);
                if ($paid >= $amount && $amount > 0) {
                    $status = 'Paid';
                } elseif ($paid > 0) {
                    $status = 'Partial';
                } else {
                    $status = 'Pending';
                }
                try {
                    $firstName = !empty($row->FullName) ? EncDecAlgorithm::decrypt($row->FullName) : '';
                    $lastName  = !empty($row->LastName) ? EncDecAlgorithm::decrypt($row->LastName) : '';
                } catch (Exception $e) {
                    $firstName = $row->FullName ?? '';
                    $lastName  = $row->LastName ?? '';
                }
                $patientName = trim(($firstName ?? '') . ' ' . ($lastName ?? '')) ?: 'Unknown';
                $list[] = [
                    'chargeId'      => (int) $row->Id,
                    'billId'        => $row->BillNo ?: ('BL' . str_pad($row->Id, 8, '0', STR_PAD_LEFT)),
                    'date'          => $row->BillDate ? date('Y-m-d', strtotime($row->BillDate)) : date('Y-m-d'),
                    'patientPRN'    => $row->PatientPRN ?: '',
                    'patientName'   => $patientName,
                    'amount'        => $amount,
                    'paidAmount'    => $paid,
                    'pendingAmount' => $pending,
                    'paymentStatus'=> $status,
                    'paymentMethod' => isset($row->LastPaymentModeId, $paymentModeLabels[(int) $row->LastPaymentModeId]) ? $paymentModeLabels[(int) $row->LastPaymentModeId] : null,
                ];
            }
            return $list;
        } catch (Exception $e) {
            error_log('Billing_model::getRecentBills error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Return SQL queries used by billing (for debug display).
     */
    public function getBillingQueries($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        $tenantFilter = $this->getTenantFilter($tenantId, $tenantIds);
        if ($tenantFilter === null) {
            return [];
        }
        $ids = !empty($tenantIds) && is_array($tenantIds)
            ? array_map('intval', $tenantIds)
            : (($tenantId !== null && $tenantId !== '')
                ? (strpos((string)$tenantId, ',') !== false
                    ? array_values(array_filter(array_map('intval', explode(',', $tenantId))))
                    : [(int) $tenantId])
                : []);
        $ph = !empty($ids) ? implode(',', array_map('intval', $ids)) : '0';
        $pp = $practitionerId !== null && $practitionerId !== '' ? " AND e.PrimaryPractitionerId = " . (int)$practitionerId : '';
        $base = "ceh.TenantId IN ($ph) AND CAST(ceh.BillDate AS DATE) >= '$startDate' AND CAST(ceh.BillDate AS DATE) <= '$endDate' AND ceh.IsActive = 1";
        return [
            'getPaidAmount' => "SELECT ISNULL(SUM(pd.PaymentAmount), 0) AS Total FROM PaymentDetails pd INNER JOIN ChargeEntryHeader ceh ON pd.ChargeEntryHeaderId = ceh.Id INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id WHERE $base$pp AND (pd.isActive = 1 OR pd.isActive IS NULL)",
            'getPendingAmount' => "SELECT ISNULL(SUM(CASE WHEN ceh.PatientPayable > ISNULL(pay.Paid, 0) THEN ceh.PatientPayable - ISNULL(pay.Paid, 0) ELSE 0 END), 0) AS Total FROM ChargeEntryHeader ceh INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id LEFT JOIN (SELECT ChargeEntryHeaderId, SUM(PaymentAmount) AS Paid FROM PaymentDetails WHERE isActive = 1 OR isActive IS NULL GROUP BY ChargeEntryHeaderId) pay ON pay.ChargeEntryHeaderId = ceh.Id WHERE $base$pp",
            'getVisitCount' => "SELECT COUNT(ceh.Id) AS Cnt FROM ChargeEntryHeader ceh INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id WHERE $base$pp",
            'getOutstandingCount' => "SELECT COUNT(*) AS Cnt FROM ChargeEntryHeader ceh INNER JOIN Enrollment e ON ceh.EnrollmentId = e.Id LEFT JOIN (SELECT ChargeEntryHeaderId, SUM(PaymentAmount) AS Paid FROM PaymentDetails WHERE isActive = 1 OR isActive IS NULL GROUP BY ChargeEntryHeaderId) pay ON pay.ChargeEntryHeaderId = ceh.Id WHERE $base$pp AND ISNULL(ceh.PatientPayable, 0) > ISNULL(pay.Paid, 0)",
        ];
    }

    /**
     * Get full billing data for dashboard (metrics, payment methods, charts, recent bills).
     */
    public function getBillingData($practitionerId, $tenantId, $tenantIds, $startDate, $endDate)
    {
        $paidAmount        = $this->getPaidAmount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
        $pendingAmount     = $this->getPendingAmount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
        $totalBilled       = $paidAmount + $pendingAmount;
        $visitCount        = $this->getVisitCount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
        $avgBillPerVisit   = $visitCount > 0 ? round($totalBilled / $visitCount, 2) : 0;
        $collectionRate    = $totalBilled > 0 ? round(($paidAmount / $totalBilled) * 100, 1) : 0;
        $outstandingBills  = $this->getOutstandingCount($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);

        $paymentMethods    = $this->getPaymentMethods($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
        $paidVsPendingTrend = $this->getPaidVsPendingTrend($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
        $dailyRevenue      = $this->getDailyRevenue($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);
        $recentBills       = $this->getRecentBills($practitionerId, $tenantId, $tenantIds, $startDate, $endDate);

        return [
            'metrics' => [
                'totalBilled'      => (float) $totalBilled,
                'paidAmount'       => (float) $paidAmount,
                'pendingAmount'    => (float) $pendingAmount,
                'avgBillPerVisit'  => (float) $avgBillPerVisit,
                'collectionRate'   => (float) $collectionRate,
                'outstandingBills' => (int) $outstandingBills,
            ],
            'paymentMethods'    => $paymentMethods,
            'paidVsPendingTrend' => $paidVsPendingTrend,
            'dailyRevenue'      => $dailyRevenue,
            'recentBills'       => $recentBills,
        ];
    }
}
