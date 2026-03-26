<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING Clinic – Package Bill</title>
    <style>
        /* ✅ PASTE YOUR SAME CSS FROM ring_invoice.php (keep exactly same) */
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
            font-size:11px;
            line-height:1.45;
            color:#0f172a;
        }
        .page{padding:18px;}
        .topbar{display:flex;justify-content:space-between;gap:12px;align-items:flex-start}
        .brand h1{font-size:14px;margin:0}
        .muted{color:#64748b}
        .card{border:1px solid #e2e8f0;border-radius:10px;padding:10px}
        .mt-8{margin-top:8px}
        .mt-12{margin-top:12px}
        .mt-16{margin-top:16px}
        .section-title{font-size:10px;text-transform:uppercase;letter-spacing:.4px;color:#64748b;margin-bottom:6px}
        table{width:100%;border-collapse:collapse;}
        th,td{font-size:11px;padding:5px 6px;vertical-align:top;}
        thead th{font-size:10px;text-transform:uppercase;letter-spacing:.4px;color:#64748b;border-bottom:1px solid #e2e8f0;}
        .border-none td{border:none;padding:3px 0;}
        .strong{font-weight:700}
        .num{text-align:right;white-space:nowrap;}
        .mono{font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;}
        .logo{height:52px;width:auto;object-fit:contain}
        .totals td{padding:4px 0}
        .totals .grand td{font-weight:700;border-top:1px solid #e2e8f0;padding-top:8px}
    </style>
</head>
<body>
<div class="page">

    <!-- TOP -->
    <div class="topbar">
        <div class="brand">
            <h1><?php echo $tenant['name'] ?? ''; ?></h1>
            <div class="muted">
                <?php echo $tenant['address'] ?? ''; ?><br>
                Phone: <?php echo $tenant['phone'] ?? ''; ?> | Email: <?php echo $tenant['email'] ?? ''; ?>
            </div>
            <div class="mt-8 strong" style="font-size:14px;">Package Bill</div>
            <div class="muted">Package: <?php echo $package['PackageName'] ?? ''; ?> (<?php echo $package['PackageCode'] ?? ''; ?>)</div>
        </div>

        <div>
            <?php if (!empty($tenant['logo'])) { ?>
                <img class="logo" src="<?php echo $tenant['logo']; ?>" />
            <?php } ?>
        </div>
    </div>

    <!-- 3 BLOCKS (same like invoice) -->
    <div class="mt-12 card">
        <table class="border-none">
            <tr>
                <!-- Patient -->
                <td style="width:33%;vertical-align:top;">
                    <div class="section-title">Patient</div>
                    <table class="border-none small">
                        <tr>
                            <td>Patient Full Name</td>
                            <td class="strong"><?php echo $patient['PatientFullName'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>MRN</td>
                            <td class="strong"><?php echo $patient['PatientMRN'] ?? ''; ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Visit -->
                <td style="width:33%;vertical-align:top;">
                    <div class="section-title">Visit</div>
                    <table class="border-none small">
                        <tr>
                            <td>Visit No.</td>
                            <td class="strong"><?php echo $visit['VisitNo'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Date of Visit</td>
                            <td class="strong"><?php echo $visit['DateOfVisit'] ?? ''; ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Printing (replaces Invoice block) -->
                <td style="width:34%;vertical-align:top;">
                    <div class="section-title">Printing</div>
                    <table class="border-none small">
                        <tr>
                            <td>Date of Printing</td>
                            <td class="strong"><?php echo $meta['DateOfPrinting'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Printed By</td>
                            <td class="strong"><?php echo $printedBy ?? ''; ?></td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
    </div>

    <!-- LINE ITEMS TABLE -->
    <?php $total = 0.00; ?>
    <div class="mt-12 card">
        <table>
            <thead>
            <tr>
                <th style="width:70px;">Code</th>
                <th>Description</th>
                <th style="width:40px;" class="num">Qty</th>
                <th style="width:60px;" class="num">Rate</th>
                <th style="width:60px;" class="num">Discount</th>
                <th style="width:70px;" class="num">Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach(($items ?? []) as $it) {
                $amount = (float)($it['Amount'] ?? 0);
                $total += $amount;
            ?>
                <tr>
                    <td class="mono"><?php echo $it['Code'] ?? ''; ?></td>
                    <td><?php echo $it['Description'] ?? ''; ?></td>
                    <td class="num"><?php echo $it['Qty'] ?? 1; ?></td>
                    <td class="num"><?php echo number_format((float)($it['Rate'] ?? 0), 2); ?></td>
                    <td class="num"><?php echo number_format((float)($it['Discount'] ?? 0), 2); ?></td>
                    <td class="num"><?php echo number_format($amount, 2); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- TOTALS -->
    <div class="mt-12">
        <table>
            <tr>
                <td style="width:55%"></td>
                <td style="width:45%">
                    <div class="card">
                        <div class="section-title">Totals</div>
                        <table class="totals">
                            <tr>
                                <td>Subtotal</td>
                                <td class="num"><?php echo number_format($total, 2); ?></td>
                            </tr>
                            <tr class="grand">
                                <td>Grand Total</td>
                                <td class="num"><?php echo number_format($total, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
