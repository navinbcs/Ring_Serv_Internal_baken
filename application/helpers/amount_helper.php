<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function amountInWordsMYR($number)
{
    if (is_string($number)) {
        $number = str_replace(',', '', $number);
    }
    $number = (float) $number;

    $no = floor($number);
    $decimal = round($number - $no, 2) * 100;
    if ($no == 0 && (int) $decimal === 0) {
        return 'Zero Ringgit Only';
    }

    $words = [
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
        20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
        50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
        80 => 'Eighty', 90 => 'Ninety'
    ];

    $digits = ['', 'Hundred', 'Thousand', 'Million', 'Billion'];
    $str = [];
    $i = 0;

    while ($no > 0) {
        $numberPart = $no % 1000;
        $no = floor($no / 1000);

        if ($numberPart) {
            $hundreds = floor($numberPart / 100);
            $remainder = $numberPart % 100;
            $text = '';

            if ($hundreds) {
                $text .= $words[$hundreds] . ' Hundred ';
            }

            if ($remainder < 21) {
                $text .= $words[$remainder];
            } else {
                $text .= $words[floor($remainder / 10) * 10] . ' ' . $words[$remainder % 10];
            }

            $str[] = trim($text) . ' ' . $digits[$i];
        }
        $i++;
    }

    $result = trim(implode(' ', array_reverse($str)));

    $sen = '';
    if ($decimal) {
        $sen = ($decimal < 21)
            ? ' and ' . $words[$decimal] . ' Sen'
            : ' and ' . $words[floor($decimal / 10) * 10] . ' ' . $words[$decimal % 10] . ' Sen';
    }

    return $result . ' Ringgit' . $sen . ' Only';
}

/**
 * Raw BillingType from a bill line (SP row or enriched object). ODBC drivers may lowercase keys.
 * ItemMaster: 1 = billable, 2 = non-billable. Null = unknown (caller defaults to billable).
 */
function bill_row_billing_type_raw($row)
{
    $keys = ['BillingType', 'billingType', 'billingtype'];
    if (is_array($row)) {
        foreach ($keys as $k) {
            if (array_key_exists($k, $row) && $row[$k] !== null && $row[$k] !== '') {
                return $row[$k];
            }
        }

        return null;
    }
    if (is_object($row)) {
        foreach ($keys as $k) {
            if (property_exists($row, $k) || isset($row->$k)) {
                $v = $row->$k;
                if ($v !== null && $v !== '') {
                    return $v;
                }
            }
        }
    }

    return null;
}

/**
 * Whether a bill line counts toward invoice subtotal / balance.
 * ItemMaster.BillingType: 1 = billable, 2 = non-billable. Missing or other values = billable.
 */
function bill_line_is_billable($row): bool
{
    $bt = bill_row_billing_type_raw($row);
    if ($bt === null) {
        return true;
    }

    return (int) $bt !== 2;
}

/** Tax for one bill line (usp_rpt_BillDetails / ChargeEntryDetail-style fields). */
function bill_line_tax_amount($row): float
{
    if (!is_object($row)) {
        return 0.0;
    }
    $v = $row->TaxAmount ?? $row->Tax ?? $row->TaxAmt ?? $row->TaxValue ?? 0;

    return (float) $v;
}

/**
 * Line net (incl. tax, after discount) for display.
 * Prefers NetAmount when present; else Amount - Discount + tax.
 */
function bill_line_net_amount($row): float
{
    if (!is_object($row)) {
        return 0.0;
    }
    if (isset($row->NetAmount) && $row->NetAmount !== '' && $row->NetAmount !== null) {
        return (float) $row->NetAmount;
    }
    $amt = (float) ($row->Amount ?? 0);
    $disc = (float) ($row->Discount ?? 0);
    $tax = bill_line_tax_amount($row);

    return $amt - $disc + $tax;
}

/**
 * Format one raw value for invoice PDF (avoids 01 Jan 1970 from bad strtotime input).
 */
function format_bill_date_value($raw): string
{
    if ($raw === null || $raw === '' || $raw === false) {
        return '';
    }
    if ($raw instanceof DateTimeInterface) {
        return $raw->format('d M Y');
    }
    if (is_object($raw)) {
        if (method_exists($raw, 'format')) {
            try {
                return $raw->format('d M Y');
            } catch (Throwable $e) {
                return '';
            }
        }
        $raw = (string) $raw;
    }
    if (is_numeric($raw)) {
        $n = (float) $raw;
        if ($n <= 0) {
            return '';
        }
        $sec = $n > 10000000000 ? (int) round($n / 1000) : (int) $n;
        if ($sec <= 946684800) {
            return '';
        }
        return date('d M Y', $sec);
    }
    $s = trim((string) $raw);
    if ($s === '' || strcasecmp($s, '0') === 0) {
        return '';
    }

    $ts = strtotime($s);
    if ($ts !== false) {
        $y = (int) date('Y', $ts);
        if ($y >= 1990) {
            return date('d M Y', $ts);
        }
    }

    foreach (['Y-m-d H:i:s.u', 'Y-m-d H:i:s', 'Y-m-d', 'd/m/Y', 'd-m-Y'] as $fmt) {
        $dt = DateTime::createFromFormat($fmt, $s);
        if ($dt instanceof DateTime) {
            $e = DateTime::getLastErrors();
            if (is_array($e) && (($e['warning_count'] ?? 0) > 0 || ($e['error_count'] ?? 0) > 0)) {
                continue;
            }
            $y = (int) $dt->format('Y');
            if ($y >= 1990) {
                return $dt->format('d M Y');
            }
        }
    }

    return '';
}

/**
 * First non-empty valid formatted date from candidates (header, SP row, appointment, etc.).
 */
function invoice_resolve_display_date(...$candidates): string
{
    foreach ($candidates as $raw) {
        $f = format_bill_date_value($raw);
        if ($f !== '') {
            return $f;
        }
    }

    return '';
}

/**
 * Invoice date for bill/PDF: only InvoiceDate / invoiceDate on bill row, then charge header.
 */
function invoice_resolve_display_date_from_invoice_date($hdr, $firstBillRow): string
{
    $invKeys = ['InvoiceDate', 'invoiceDate', 'invoicedate'];

    return invoice_resolve_display_date(
        invoice_first_nonempty_prop($firstBillRow, $invKeys),
        invoice_first_nonempty_prop($hdr, $invKeys)
    );
}

/**
 * First non-null/non-empty property from an object ( tries common DB casings).
 *
 * @param object|null $obj
 */
function invoice_first_nonempty_prop($obj, array $keys)
{
    if (!$obj || !is_object($obj)) {
        return null;
    }
    foreach ($keys as $k) {
        if (!isset($obj->$k)) {
            continue;
        }
        $v = $obj->$k;
        if ($v === null || $v === '') {
            continue;
        }
        return $v;
    }

    return null;
}

/**
 * Trimmed invoice / bill number from first bill-details row (SP or enriched).
 */
function invoice_raw_number_from_first_line($firstBillRow): string
{
    if (!$firstBillRow || !is_object($firstBillRow)) {
        return '';
    }
    foreach (['InvoiceNo', 'invoiceNo', 'BillNo', 'billNo'] as $k) {
        if (!isset($firstBillRow->$k)) {
            continue;
        }
        $s = trim((string) $firstBillRow->$k);
        if ($s !== '') {
            return $s;
        }
    }

    return '';
}
