<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING Clinic – Insurance Invoice</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
            font-size:11px;
            line-height:1.45;
            color:#0f172a;
        }

        .page-wrap{}
        .page{
            padding:24px 26px;
        }

        h1,h2,h3{
            margin:0 0 4px;
        }
        h1{font-size:18px;}
        h2{font-size:13px;}
        h3{font-size:11px;color:#475569;}
        p{margin:2px 0;}
        .muted{color:#64748b;}
        .strong{font-weight:bold;}
        .right{text-align:right;}
        .center{text-align:center;}
        .mt-8{margin-top:8px;}
        .mt-12{margin-top:12px;}
        .mt-16{margin-top:16px;}

        .pill{
            display:inline-block;
            padding:3px 10px;
            border-radius:999px;
            background:#0f766e;
            color:#ffffff;
            font-weight:bold;
            font-size:10px;
        }

        .card{
            border-radius:14px !important;
            border:1px solid #d7e0eb;
            background:#ffffff;
            padding:10px 12px;
        }
        .card-soft{
            background:#f1f5fb;
            border-style:dashed;
        }

        table{width:100%;border-collapse:collapse;}
        th,td{font-size:11px;padding:5px 6px;vertical-align:top;}
        .small{font-size:10px;}
        .num{text-align:right;white-space:nowrap;}
        thead th{
            font-size:10px;
            text-transform:uppercase;
            letter-spacing:0.4px;
            color:#64748b;
            border-bottom:1px solid #d7e0eb;
        }
        tbody td{
            border-bottom:1px solid #edf1f7;
        }
        tbody tr:last-child td{border-bottom:none;}

        .border-none th,
        .border-none td{border:0!important;}

        .amount-box{
            height:70px;
        }

        .totals td{
            border:0!important;
            padding:2px 0;
        }
        .totals td:first-child{
            color:#64748b;
        }
        .totals .grand td{
            border-top:2px solid #0f172a!important;
            font-weight:bold;
            padding-top:4px;
        }

        .section-title{
            font-size:11px;
            font-weight:bold;
            letter-spacing:0.5px;
            text-transform:uppercase;
            color:#64748b;
        }

        .hr{border-bottom:1px solid #d7e0eb;margin:10px 0;}

        .mono{
            font-family:"SF Mono","Roboto Mono",Menlo,monospace;
            font-size:10px;
        }
    </style>
</head>
<body>
<div class="page-wrap">

    <div class="page">

        <?php
        $dashCell = function ($v) {
            return $v === '' ? '—' : htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        };
        $temail = trim((string) ($tenant['email'] ?? ''));
        $tweb = trim((string) ($tenant['website'] ?? ''));
        $thours = trim((string) ($tenant['facility_working_hours'] ?? ''));
        $lic = trim((string) ($doctor['licence_no'] ?? ''));
        $pSp = trim((string) ($doctor['primary_speciality'] ?? ''));
        $sSp = trim((string) ($doctor['secondary_speciality'] ?? ''));
        $sum = $insurance_summary ?? [];
        $covRows = [];
        if (trim((string) ($sum['co_pay_pct'] ?? '')) !== '') {
            $covRows[] = ['Co-Pay %', (string) $sum['co_pay_pct']];
        }
        if (isset($sum['gl_approved']) && $sum['gl_approved'] !== null) {
            $covRows[] = ['GL approved', number_format((float) $sum['gl_approved'], 2)];
        }
        if (trim((string) ($sum['policy_no'] ?? '')) !== '') {
            $covRows[] = ['Policy #', (string) $sum['policy_no']];
        }
        if (isset($sum['co_pay_amt']) && $sum['co_pay_amt'] !== null) {
            $covRows[] = ['Co-Pay amount', number_format((float) $sum['co_pay_amt'], 2)];
        }
        if (trim((string) ($sum['insurance_bill_no'] ?? '')) !== '') {
            $covRows[] = ['Insurance bill no.', (string) $sum['insurance_bill_no']];
        }
        $mrnDisp = trim((string) ($patient_mrn ?? ''));
        ?>

        <table>
            <tr>
                <td style="width:60%;vertical-align:top;">
                    <img src="<?= FCPATH . 'assets/SkeenLogo.png' ?>" width="80" style="margin-bottom:8px;">
                    <h1><?php echo htmlspecialchars($tenant['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h1>
                    <p class="small muted">
                       <?php echo htmlspecialchars($tenant['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p class="small mt-8"><span class="muted">Clinic email</span><br><span class="strong"><?php echo $dashCell($temail); ?></span></p>
                    <p class="small mt-8"><span class="muted">Clinic website</span><br><span class="strong"><?php echo $dashCell($tweb); ?></span></p>
                    <p class="small mt-8"><span class="muted">Facility working hours</span><br><span class="strong"><?php echo $dashCell($thours); ?></span></p>
                </td>
                <td style="width:40%;vertical-align:top;" class="right">
                    <span class="pill">INSURANCE INVOICE</span>
                    <p class="mt-8 strong">Consultant</p>
                    <p class="strong">Dr. <?php echo htmlspecialchars($doctor['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="small mt-8"><span class="muted">Doctor&rsquo;s Licence No.</span><br><span class="strong"><?php echo $dashCell($lic); ?></span></p>
                    <p class="small mt-8"><span class="muted">Primary speciality</span><br><span class="strong"><?php echo $dashCell($pSp); ?></span></p>
                    <p class="small mt-8"><span class="muted">Secondary speciality</span><br><span class="strong"><?php echo $dashCell($sSp); ?></span></p>
                </td>
            </tr>
        </table>

        <div class="mt-12 card">
            <table>
                <tr>
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Patient</div>
                        <table class="border-none small">
                            <tr>
                                <td>Name</td>
                                <td class="strong"><?php echo htmlspecialchars($patient['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td>Age / Sex</td>
                                <td class="strong"><?php echo htmlspecialchars((string)($patient['age'] ?? ''), ENT_QUOTES, 'UTF-8'); ?> / <?php echo htmlspecialchars((string)($patient['sex'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td>MRN</td>
                                <td class="strong"><?php echo $dashCell($mrnDisp); ?></td>
                            </tr>
                        </table>
                    </td>

                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Visit</div>
                        <table class="border-none small">
                            <tr>
                                <td>Visit No</td>
                                <td class="strong"><?php echo htmlspecialchars((string)($patient['AppointmentNo'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td>Visit Date</td>
                                <td class="strong"><?php echo htmlspecialchars((string)($patient['appointmentDate'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        </table>
                    </td>

                    <td style="width:34%;vertical-align:top;">
                        <div class="section-title">Invoice</div>
                        <table class="border-none small">
                            <tr>
                                <td>Invoice No</td>
                                <td class="strong"><?php
                                    $invNo = $invoice_no_display ?? invoice_raw_number_from_first_line(!empty($Presp[0]) ? $Presp[0] : null);
                                    echo htmlspecialchars($invNo === '' ? 'Draft' : $invNo, ENT_QUOTES, 'UTF-8');
                                ?></td>
                            </tr>
                            <tr>
                                <td>Invoice Date</td>
                                <td class="strong"><?php
                                    if (isset($invoice_date_display)) {
                                        echo htmlspecialchars($invoice_date_display, ENT_QUOTES, 'UTF-8');
                                    } else {
                                        $rawNo = invoice_raw_number_from_first_line(!empty($Presp[0]) ? $Presp[0] : null);
                                        $idisp = $rawNo === '' ? '' : invoice_resolve_display_date_from_invoice_date(
                                            null,
                                            !empty($Presp[0]) ? $Presp[0] : null
                                        );
                                        echo htmlspecialchars($idisp, ENT_QUOTES, 'UTF-8');
                                    }
                                ?></td>
                            </tr>
                            <tr>
                                <td>Currency</td>
                                <td class="strong">MYR</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <?php if (!empty($covRows)) { ?>
        <div class="mt-12 card card-soft">
            <div class="section-title">Coverage (insurance)</div>
            <table class="border-none small mt-8">
                <?php foreach ($covRows as $pair) { ?>
                <tr>
                    <td style="width:40%;"><?php echo htmlspecialchars($pair[0], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="strong"><?php echo htmlspecialchars($pair[1], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>

        <?php
            $totalAmt = 0.00;
            $totalDisc = 0.00;
            $totalTax = 0.00;
            $Presp = is_array($Presp ?? null) ? $Presp : [];
        ?>
        <div class="mt-12 card">
            <table>
                <thead>
                <tr>
                    <th style="width:70px;">Code</th>
                    <th>Description</th>
                    <th style="width:40px;" class="num">Qty</th>
                    <th style="width:56px;" class="num">Rate</th>
                    <th style="width:52px;" class="num">Discount</th>
                    <th style="width:56px;" class="num">Amount</th>
                    <th style="width:52px;" class="num">Tax</th>
                    <th style="width:56px;" class="num">Net</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($Presp as $p) {
                        $lineTax = bill_line_tax_amount($p);
                        $billable = bill_line_is_billable($p);
                        if ($billable) {
                            $totalAmt += (float) ($p->Amount ?? 0);
                            $totalDisc += (float) ($p->Discount ?? 0);
                            $totalTax += $lineTax;
                        }
                        $dispRate = $billable ? (float) ($p->UnitPrice ?? 0) : 0.0;
                        $dispDisc = $billable ? (float) ($p->Discount ?? 0) : 0.0;
                        $dispAmt = $billable ? (float) ($p->Amount ?? 0) : 0.0;
                        $dispTax = $billable ? $lineTax : 0.0;
                        $dispNet = $billable ? bill_line_net_amount($p) : 0.0;
                    ?>
                <tr>
                    <td class="mono"><?php echo htmlspecialchars($p->Code ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php
                        echo htmlspecialchars($p->Description ?? '', ENT_QUOTES, 'UTF-8');
                        if (!$billable) {
                            echo ' <span class="muted">(Non-billable)</span>';
                        }
                    ?></td>
                    <td class="num"><?php echo htmlspecialchars((string)($p->Quantity ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="num"><?php echo number_format($dispRate, 2); ?></td>
                    <td class="num"><?php echo number_format($dispDisc, 2); ?></td>
                    <td class="num"><?php echo number_format($dispAmt, 2); ?></td>
                    <td class="num"><?php echo number_format($dispTax, 2); ?></td>
                    <td class="num"><?php echo number_format($dispNet, 2); ?></td>
                </tr>
               <?php }
                    $subAfterDisc = $totalAmt - $totalDisc;
                    $balanceDue = $subAfterDisc + $totalTax;
               ?>
                </tbody>
            </table>
        </div>

        <table class="mt-12">
            <tr>
                <td style="width:55%;vertical-align:top;">
                    <div class="card card-soft amount-box">
                        <div class="section-title">Amount in words</div>
                        <p class="mt-8 small">
                           <?php echo amountInWordsMYR((float) $balanceDue); ?>
                        </p>
                    </div>
                </td>
                <td style="width:45%;vertical-align:top;">
                    <div class="card">
                        <table class="totals small">
                            <tr>
                                <td>Subtotal</td>
                                <td class="num"><?php echo number_format($totalAmt, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="num">-<?php echo number_format($totalDisc, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td class="num"><?php echo number_format($totalTax, 2); ?></td>
                            </tr>
                            <?php
                            $claimDisc = $sum['discount'] ?? null;
                            $claimTax = $sum['total_tax'] ?? null;
                            $claimBill = $sum['total_bill'] ?? null;
                            if ($claimDisc !== null) { ?>
                            <tr>
                                <td>Discount (claim)</td>
                                <td class="num"><?php echo number_format((float) $claimDisc, 2); ?></td>
                            </tr>
                            <?php } ?>
                            <?php if ($claimTax !== null) { ?>
                            <tr>
                                <td>Tax (claim)</td>
                                <td class="num"><?php echo number_format((float) $claimTax, 2); ?></td>
                            </tr>
                            <?php } ?>
                            <?php if ($claimBill !== null) { ?>
                            <tr>
                                <td>Total bill (claim)</td>
                                <td class="num"><?php echo number_format((float) $claimBill, 2); ?></td>
                            </tr>
                            <?php } ?>
                            <tr class="grand">
                                <td>Balance</td>
                                <td class="num"><?php echo number_format($balanceDue, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <?php
        $ipLines = $insurance_patient_lines ?? [];
        if (!empty($ipLines)) {
        ?>
        <div class="mt-16 card">
            <div class="section-title">Patient payable</div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:90px;text-align:left">Date</th>
                    <th style="width:90px;text-align:left">Mode</th>
                    <th>Payor</th>
                    <th style="width:90px;" class="num">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ipLines as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['mode'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['payor'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="num"><?php echo number_format((float)($row['amount'] ?? 0), 2); ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

        <?php
        $icLines = $insurance_carrier_lines ?? [];
        if (!empty($icLines)) {
        ?>
        <div class="mt-16 card">
            <div class="section-title">Insurance payable</div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:90px;text-align:left">Date</th>
                    <th>Payor</th>
                    <th style="width:90px;text-align:left">Mode</th>
                    <th style="width:90px;" class="num">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($icLines as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['payor'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['mode'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="num"><?php echo number_format((float)($row['amount'] ?? 0), 2); ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

        <?php $totalPaid = 0.00; $payment_detail = is_array($payment_detail ?? null) ? $payment_detail : []; ?>
        <div class="mt-16 card">
            <div class="section-title">Payments</div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:70px;text-align:left">Method</th>
                    <th style="width:70px;">Bank Name</th>
                    <th style="width:70px;">Reference</th>
                    <th style="width:70px;">Date </th>
                    <th style="width:80px;" class="num">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($payment_detail as $p) {
                    if (trim((string)($p->PaymentMode ?? '')) !== 'INSURANCE') {
                        $totalPaid += (float) ($p->PaymentAmount ?? 0);
                    }
                    ?>
                <tr>
                    <td style="width:70px;"><?php echo htmlspecialchars((string)($p->PaymentMode ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td style="width:100px;"><?php echo htmlspecialchars((string)($p->BankName ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td style="width:70px;"><?php echo htmlspecialchars((string)($p->ChequeCardNo ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td style="width:80px;"><?php echo htmlspecialchars((string)($p->PaymentDate ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td style="width:80px;" class="num"><?php echo htmlspecialchars((string)($p->PaymentAmount ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php } ?>
                </tbody>
            </table>

            <div class="hr"></div>

            <table class="border-none small">
                <tr>
                    <td class="strong">Total Paid</td>
                    <td class="strong" style="width:400px;"><?php echo amountInWordsMYR(number_format($totalPaid, 2)); ?></td>
                    <td class="num strong"><?php echo number_format($totalPaid, 2); ?></td>
                </tr>
            </table>
        </div>

    </div>

</div>
</body>
</html>
