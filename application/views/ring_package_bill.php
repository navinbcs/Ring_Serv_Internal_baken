<?php

$clinicName    = $tenant['name'] ?? 'RING Clinic';
$clinicAddress = $tenant['address'] ?? '';
$clinicPhone   = $tenant['phone'] ?? '';
$clinicEmail   = $tenant['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING Clinic – Package Bill</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
            font-size:11px;
            line-height:1.45;
            color:#0f172a;
        }
        .page-wrap{}
        .page{ padding:24px 26px; }
        h1,h2,h3{ margin:0 0 4px; }
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
        tbody td{ border-bottom:1px solid #edf1f7; }
        tbody tr:last-child td{border-bottom:none;}
        .border-none th,.border-none td{border:0!important;}

        .amount-box{ height:70px; }

        .totals td{ border:0!important; padding:2px 0; }
        .totals td:first-child{ color:#64748b; }
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

        <!-- HEADER -->
        <table>
            <tr>
                <td style="width:60%;vertical-align:top;">
                    <!-- ✅ For mPDF: use URL, not FCPATH -->
                    <img src="<?php echo base_url('assets/RingLogo.png'); ?>" width="80" style="margin-bottom:8px;">
                    <h1><?php echo $tenant['name'] ?? 'RING Clinic'; ?></h1>
                    <p class="small muted"><?php echo $tenant['address'] ?? ''; ?></p>
                      <p class="small muted mt-8">
                        <?php if ($clinicPhone): ?>Phone: <?= e($clinicPhone) ?><?php endif; ?>
                        <?php if ($clinicEmail): ?> &nbsp; | &nbsp; Email: <?= e($clinicEmail) ?><?php endif; ?>
                    </p>
                </td>
                <td style="width:40%;vertical-align:top;" class="right">
                    <span class="pill">PACKAGE BILL</span>

                    <p class="mt-8 strong">Package</p>
                    <p class="strong">
                        <?php echo ($package['PackageName'] ?? 'Physio Recovery Package'); ?>
                        <?php if(!empty($package['PackageCode'])){ ?>
                            <span class="mono">(<?php echo $package['PackageCode']; ?>)</span>
                        <?php } ?>
                    </p>

                    <p class="small muted">Currency: MYR</p>
                </td>
            </tr>
        </table>

        <!-- TOP INFO CARD (Patient / Visit / Printing) -->
        <div class="mt-12 card">
            <table>
                <tr>

                    <!-- Patient -->
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Patient</div>
                        <table class="border-none small">
                            <tr>
                                <td>Full Name</td>
                                <td class="strong"><?php echo $patient['PatientFullName'] ?? 'Akansha Thakur'; ?></td>
                            </tr>
                            <tr>
                                <td>MRN</td>
                                <td class="strong"><?php echo $patient['PatientMRN'] ?? 'MRN-009812'; ?></td>
                            </tr>
                        </table>
                    </td>

                    <!-- Visit -->
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Visit</div>
                        <table class="border-none small">
                            <tr>
                                <td>Visit No</td>
                                <td class="strong"><?php echo $visit['VisitNo'] ?? 'VST-2026-000145'; ?></td>
                            </tr>
                            <tr>
                                <td>Date of Visit</td>
                                <td class="strong"><?php echo $visit['DateOfVisit'] ?? date('d M Y'); ?></td>
                            </tr>
                        </table>
                    </td>

                    <!-- Printing -->
                    <td style="width:34%;vertical-align:top;">
                        <div class="section-title">Printing</div>
                        <table class="border-none small">
                            <tr>
                                <td>Date of Printing</td>
                                <td class="strong"><?php echo $meta['DateOfPrinting'] ?? date('d M Y, h:i A'); ?></td>
                            </tr>
                            <tr>
                                <td>Printed By</td>
                                <td class="strong"><?php echo $printedBy ?? 'Rahul Sharma'; ?></td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>
        </div>

        <?php $totalAmt = 0.00; $totalDisc = 0.00; $totalTax = 0.00; ?>

        <!-- LINE ITEMS -->
        <!-- <div class="mt-12 card">
            <table>
                <thead>
                <tr>
                    <th style="width:70px;">Code</th>
                    <th>Description</th>
                    <th style="width:60px;">Type</th>
                    <th style="width:40px;" class="num">Qty</th>
                    <th style="width:60px;" class="num">Rate</th>
                    <th style="width:60px;" class="num">Discount</th>
                    <th style="width:60px;" class="num">Tax</th>
                    <th style="width:70px;" class="num">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach(($items ?? []) as $p) {
                    $qty = (float)($p['Qty'] ?? 1);
                    $rate = (float)($p['Rate'] ?? 0);
                    $disc = (float)($p['Discount'] ?? 0);
                    $tax  = (float)($p['Tax'] ?? 0);
                    $amt  = (float)($p['Amount'] ?? (($qty * $rate) - $disc + $tax));

                    $totalAmt  += ($qty * $rate);
                    $totalDisc += $disc;
                    $totalTax  += $tax;
                ?>
                    <tr>
                        <td class="mono"><?php echo $p['Code'] ?? ''; ?></td>
                        <td><?php echo $p['Description'] ?? ''; ?></td>
                        <td><?php echo $p['Type'] ?? ''; ?></td>
                        <td class="num"><?php echo (int)$qty; ?></td>
                        <td class="num"><?php echo number_format($rate, 2); ?></td>
                        <td class="num"><?php echo number_format($disc, 2); ?></td>
                        <td class="num"><?php echo number_format($tax, 2); ?></td>
                        <td class="num"><?php echo number_format($amt, 2); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div> -->

<br />
        <h2 class="pkg-title">Patient Packages</h2>
<div class="mt-12 card">
<table class="pkg-table">
    <thead>
        <tr>
            <th>Package Code</th>
            <th>Package Name</th>
            <th>Package Component(s)</th>
             <th>Total Quantity</th>
            <th>Available Quantity</th>
            <th>Consumed Quantity</th>
             <th>Expiry Date</th>
          
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>BBP</td>
            <td class="pkg-left">Brightening Boost Pack</td>
            <td class="pkg-left"><span class="pkg-link">Facial Cream</span></td>
            <td>5.00</td>
            <td>4.00</td>
            <td>1.00</td>
            <td>02-01-2026</td>
        </tr>

        <tr>
            <td>BBP</td>
            <td class="pkg-left">Brightening Boost Pack</td>
            <td class="pkg-left"><span class="pkg-link">Brightening Laser Toning</span></td>
            <td>5.00</td>
            <td>4.00</td>
            <td>2.00</td>
            <td>02-01-2026</td>
        </tr>

        <tr>
            <td>BBP</td>
            <td class="pkg-left">Brightening Boost Pack</td>
            <td class="pkg-left"><span class="pkg-link">Brightening Serum (Sample)</span></td>
            <td>2.00</td>
            <td>1.00</td>
            <td></td>
            <td>02-01-2026</td>
        </tr>

        <tr>
            <td>YRK</td>
            <td class="pkg-left">Natural Peel</td>
            <td class="pkg-left"><span class="pkg-link">LED Red Light Therapy</span></td>
            <td>10.00</td>
            <td>8.00</td>
            <td></td>
            <td>12-21-2026</td>
        </tr>

        <tr>
            <td>YRK</td>
            <td class="pkg-left">Natural Peel</td>
            <td class="pkg-left"><span class="pkg-link">Facial Scrub</span></td>
            <td>5.00</td>
            <td>4.00</td>
            <td></td>
            <td>12-21-2026</td>
        </tr>

        <tr>
            <td>YRK</td>
            <td class="pkg-left">Natural Peel</td>
            <td class="pkg-left"><span class="pkg-link">Anti-Aging Facial Cream</span></td>
            <td>2.00</td>
            <td>1.00</td>
            <td></td>
            <td>12-21-2026</td>
        </tr>

        <tr>
            <td>YRK</td>
            <td class="pkg-left">Natural Peel</td>
            <td class="pkg-left"><span class="pkg-link">Collagen Mask</span></td>
            <td>10.00</td>
            <td>6.00</td>
            <td></td>
            <td>12-21-2026</td>
        </tr>

        <tr class="pkg-expired">
            <td>BRK001</td>
            <td class="pkg-left">Bundle Sale</td>
            <td class="pkg-left"><span class="pkg-link">Firming Ampoule</span></td>
            <td>6</td>
            <td>1.00</td>
            <td></td>
            <td>01-31-2022</td>
        </tr>
    </tbody>
</table>
</div>
        <!-- AMOUNT IN WORDS + TOTALS -->
        <!-- <table class="mt-12">
            <tr>
                <td style="width:55%;vertical-align:top;">
                    <div class="card card-soft amount-box">
                        <div class="section-title">Amount in words</div>
                        <p class="mt-8 small">
                            <?php
                                $net = ($totalAmt - $totalDisc + $totalTax);
                                // If you already have helper amountInWordsMYR
                                if (function_exists('amountInWordsMYR')) {
                                    echo amountInWordsMYR(number_format($net,2));
                                } else {
                                    echo 'MYR ' . number_format($net,2);
                                }
                            ?>
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
                            <tr class="grand">
                                <td>Balance</td>
                                <td class="num"><?php echo number_format(($totalAmt - $totalDisc + $totalTax), 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table> -->

    </div>
</div>
</body>
</html>
