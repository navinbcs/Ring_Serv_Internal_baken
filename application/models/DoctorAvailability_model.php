<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DoctorAvailability_model extends CI_Model
{
    public function getAvailability(int $tenantId, int $doctorId, string $date, string $flag)
    {
        // 1) Tenant working hours
        $tenantHours = $this->callProc('usp_GetTenantWorkingHours', [
            'TenantId' => $tenantId,
            'ExecFlag' => $flag,
            'AppointmentDate' => $date
        ]);

        // 2) Doctor working hours + duration
        $doctorHours = $this->callProc('usp_GetDoctorWorkingHours', [
            'DoctorId' => $doctorId,
            'TenantId' => $tenantId,
            'ExecFlag' => $flag,
            'AppointmentDate' => $date
        ]);

        // 3) Booked slots
        $booked = $this->callProc('usp_GetDoctorBookedslots', [
            'DoctorId' => $doctorId,
            'AppointmentDate' => $date
        ]);

        // 4) Leaves/Holidays
        $tenantLeave = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
            'TenantId' => $tenantId,
            'DoctorId' => $doctorId,
            'Flag' => 'Tenant'
        ]);

        $doctorLeave = $this->callProc('Usp_GetTenantandUsersLeaveAndHolidays', [
            'TenantId' => $tenantId,
            'DoctorId' => $doctorId,
            'Flag' => 'Doctor'
        ]);

        $duration = $this->parseDurationMinutes($doctorHours);
        if ($duration <= 0) $duration = 30;

        if ($this->isHolidayOrLeave($tenantLeave) || $this->isHolidayOrLeave($doctorLeave)) {
            return [
                'date' => $date,
                'doctor_id' => $doctorId,
                'duration_minutes' => $duration,
                'slots' => [],
                'note' => 'Doctor/Tenant not available due to holiday/leave'
            ];
        }

        $blocks = $this->extractWorkingWindowBlocks($doctorHours, $tenantHours);
        if (empty($blocks)) {
            return [
                'date' => $date,
                'doctor_id' => $doctorId,
                'duration_minutes' => $duration,
                'slots' => [],
                'note' => 'Working hours not configured'
            ];
        }

        $slots = [];
        foreach ($blocks as [$start, $end]) {
            if ($start && $end) {
                $slots = array_merge($slots, $this->generateSlots($start, $end, $duration));
            }
        }
        $slots = $this->markBookedSlots($slots, $booked);

        $firstStart = $blocks[0][0] ?? null;
        $lastEnd = $blocks[count($blocks) - 1][1] ?? null;
        return [
            'date' => $date,
            'doctor_id' => $doctorId,
            'duration_minutes' => $duration,
            'working_start' => $firstStart,
            'working_end' => $lastEnd,
            'slots' => $slots
        ];
    }

    /* ---------- helpers (unchanged) ---------- */

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

    private function parseDurationMinutes(array $doctorHours): int
    {
        if (empty($doctorHours)) return 0;
        $row = $doctorHours[0];

        foreach (['Duration','AppointmentDuration','SlotDuration','DurationInMinutes'] as $k) {
            if (!empty($row[$k])) {
                if (is_numeric($row[$k])) return (int)$row[$k];
                if (preg_match('/(\d+)/', $row[$k], $m)) return (int)$m[1];
            }
        }
        return 0;
    }

    /**
     * Extract all working window blocks from doctor hours, intersected with tenant hours.
     * Supports split schedules (e.g. 09:00-16:20 and 18:40-23:00).
     */
    private function extractWorkingWindowBlocks(array $doctorHours, array $tenantHours): array
    {
        $tenantStart = $this->normTime($this->findTime($tenantHours, ['FromTime','StartTime','WorkingFrom']));
        $tenantEnd   = $this->normTime($this->findTime($tenantHours, ['ToTime','EndTime','WorkingTo']));

        if (!$tenantStart || !$tenantEnd) {
            $tenantStart = null;
            $tenantEnd   = null;
        }

        $blocks = [];
        foreach ($doctorHours as $row) {
            $start = $this->normTime($this->findTimeInRow($row, ['FromTime','StartTime','WorkingFrom']));
            $end   = $this->normTime($this->findTimeInRow($row, ['ToTime','EndTime','WorkingTo']));
            if (!$start || !$end) continue;

            if ($tenantStart && $tenantEnd) {
                $start = $this->maxTime($start, $tenantStart);
                $end   = $this->minTime($end, $tenantEnd);
            }
            if ($start && $end && $start < $end) {
                $blocks[] = [$start, $end];
            }
        }

        if (empty($blocks) && $doctorHours) {
            $start = $this->normTime($this->findTime($doctorHours, ['FromTime','StartTime','WorkingFrom']));
            $end   = $this->normTime($this->findTime($doctorHours, ['ToTime','EndTime','WorkingTo']));
            if ($start && $end) {
                $blocks[] = [$start, $end];
            }
        }
        if (empty($blocks) && $tenantStart && $tenantEnd) {
            $blocks[] = [$tenantStart, $tenantEnd];
        }
        return $blocks;
    }

    private function findTimeInRow(array $row, array $keys): ?string
    {
        foreach ($keys as $k) {
            if (!empty($row[$k])) return (string)$row[$k];
        }
        return null;
    }

    private function maxTime(string $a, string $b): string
    {
        $tsA = strtotime("1970-01-01 $a");
        $tsB = strtotime("1970-01-01 $b");
        return $tsA >= $tsB ? $a : $b;
    }

    private function minTime(string $a, string $b): string
    {
        $tsA = strtotime("1970-01-01 $a");
        $tsB = strtotime("1970-01-01 $b");
        return $tsA <= $tsB ? $a : $b;
    }

    private function extractWorkingWindow(array $doctorHours, array $tenantHours): array
    {
        $blocks = $this->extractWorkingWindowBlocks($doctorHours, $tenantHours);
        if (empty($blocks)) return [null, null];
        return [$blocks[0][0], $blocks[count($blocks) - 1][1]];
    }

    private function findTime(array $rows, array $keys): ?string
    {
        if (empty($rows)) return null;
        foreach ($keys as $k) {
            if (!empty($rows[0][$k])) return (string)$rows[0][$k];
        }
        return null;
    }

    private function normTime(?string $t): ?string
    {
        if (!$t || !trim($t)) return null;
        $t = trim($t);
        $ts = strtotime("1970-01-01 $t");
        if ($ts !== false) {
            return date('H:i', $ts);
        }
        if (preg_match('/^(\d{1,2}):(\d{2})/', $t, $m)) {
            return str_pad($m[1], 2, '0', STR_PAD_LEFT) . ':' . $m[2];
        }
        return $t;
    }

    private function generateSlots(string $start, string $end, int $duration): array
    {
        $slots = [];
        $cur = strtotime("1970-01-01 $start");
        $endTs = strtotime("1970-01-01 $end");

        while (($cur + ($duration * 60)) <= $endTs) {
            $slots[] = [
                'from' => date('H:i', $cur),
                'to'   => date('H:i', $cur + ($duration * 60)),
                'status' => 'AVAILABLE'
            ];
            $cur += ($duration * 60);
        }
        return $slots;
    }

    private function markBookedSlots(array $slots, array $booked): array
    {
        foreach ($slots as &$s) {
            foreach ($booked as $b) {
                $bf = $this->normTime($b['FromTime'] ?? null);
                $bt = $this->normTime($b['ToTime'] ?? null);
                if ($bf && $bt && $s['from'] < $bt && $s['to'] > $bf) {
                    $s['status'] = 'BOOKED';
                    break;
                }
            }
        }
        return $slots;
    }

    private function isHolidayOrLeave(array $rows): bool
    {
        if (empty($rows)) return false;
        foreach (['IsHoliday','IsLeave','IsOnLeave'] as $k) {
            if (isset($rows[0][$k]) && (int)$rows[0][$k] === 1) return true;
        }
        return false; // Only treat as leave when flag is explicitly 1
    }
}
