<?php
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$clinicName    = $tenant['name'] ?? 'RING Clinic';
$clinicAddress = $tenant['address'] ?? '';
$clinicPhone   = $tenant['phone'] ?? '';
$clinicEmail   = $tenant['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING Clinic – Outpatient Bill</title>
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
        .pill-rx{
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

      td{
   height:100%;
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

        .logo-square{
            width:20px;
            height:20px;
            border-radius:6px;
            background:#0f766e;
        }
    </style>
</head>
<body>
<div class="page-wrap">

    <!-- ===================== PAGE 1 : OUTPATIENT BILL ===================== -->
    <div class="page">

        <!-- HEADER -->
        <table>
            <tr>
                <td style="width:60%;vertical-align:top;">
                    
                    <img src="<?= FCPATH . 'assets/RingLogo.png' ?>" width="80" style="margin-bottom:8px;">
                    
                    <h1><?= e($clinicName) ?></h1>

                    <p class="small muted">
                        <?= e($clinicAddress) ?>,
                        <?= e($tenant['CityDescription'] ?? ''); ?>,
                        <?= e($tenant['StateDescription'] ?? ''); ?>,
                        <?= e($tenant['CountryDescription'] ?? ''); ?>
                        <?php if (!empty($tenant['postcode'])): ?>
                            - <?= e($tenant['postcode']); ?>
                        <?php endif; ?>
                    </p>

                    <p class="small muted mt-8">
                        <?php if ($clinicPhone): ?>
                            Phone: <?= e($clinicPhone) ?>
                        <?php endif; ?>

                        <?php if ($clinicEmail): ?>
                            &nbsp; | &nbsp; Email: <?= e($clinicEmail) ?>
                        <?php endif; ?>
                    </p>

                </td>
                <td style="width:40%;vertical-align:top;" class="right">
                    <span class="pill">OUTPATIENT BILL</span>
                    <p class="mt-8 strong">Consultant</p>
                    <p class="strong">Dr. <?php echo $doctor['name'] ; ?></p>
                    <!-- <p class="small muted">Reg. No: RC-4512</p> -->
                </td>
            </tr>
        </table>

        <!-- TOP INFO CARD (Patient / Visit / Invoice) -->
        <div class="mt-12 card">
            <table>
                <tr>
                    <!-- Patient -->
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Patient</div>
                        <table class="border-none small">
                            <tr>
                                <td>Name</td>
                                <td class="strong"><?php echo $patient['name'] ; ?></td>
                            </tr>
                            <tr>
                                <td>Age / Sex</td>
                                <td class="strong"><?php echo $patient['age'] ; ?> / <?php echo $patient['sex'] ; ?></td>
                            </tr>
                            <tr>
                                <td>MRN</td>
                                <td class="strong"><?php echo $patient['PatientMRN'] ; ?></td>
                            </tr>
                        </table>
                    </td>

                    <!-- Visit -->
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Visit</div>
                        <table class="border-none small">
                            <tr>
                                <td>Visit No</td>
                                <td class="strong"><?php echo $patient['AppointmentNo']; ?></td>
                            </tr>
                            <tr>
                                <td>Visit Date</td>
                                <td class="strong"> <?php echo  $patient['appointmentDate'] ; ?></td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td class="strong"><?php echo  $doctor['deprt'] ; ?></td>
                            </tr>
                        </table>
                    </td>

                    <!-- Invoice -->
                    <td style="width:34%;vertical-align:top;">
                        <div class="section-title">Invoice</div>
                        <table class="border-none small">
                            <tr>
                                <td>Invoice No</td>
                                <td class="strong"><?php echo isset($Presp[0]->InvoiceNo)?$Presp[0]->InvoiceNo:''; ?></td>
                            </tr>
                            <tr>
                                <td>Invoice Date</td>
                                <td class="strong"><?php echo isset($Presp[0]->InvoiceDate)?$Presp[0]->InvoiceDate:''; ?></td>
                            </tr>
                            <tr>
                                <td>Currency</td>
                                <td class="strong"><?php echo $currency ;?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
         <?php  $totalAmt = 0.00 ; $totalDisc = 0.00;  $totalTax = 0.00; ?>
        <!-- LINE ITEMS -->
        <div class="mt-12 ">
            <table>
                <thead>
                <tr>
                    <th style="width:70px;">Code</th>
                    <th >Description</th>
                    <!-- <th style="width:70px;">Strength</th> -->
                    <!-- <th style="width:50px;">Unit</th> -->
                    <th style="width:40px;" class="num">Qty</th>
                    <th style="width:60px;" class="num">Rate</th>
                    <th style="width:60px;" class="num">Tax</th>
                    <th style="width:60px;" class="num">Discount</th>
                    <th style="width:70px;" class="num">Amount</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($Presp as $i=>$p) {  $totalTax +=number_format($Bill[$i]->TaxAmount ?? 0, 2) ;   $totalAmt  += number_format($Bill[$i]->TaxAmount ?? 0, 2) ; $totalDisc += $p->Discount  ;     ?>
                <tr>
                    <td class="mono"><?php echo $p->Code; ?></td>
                    <td><?php echo $p->Description; ?></td>
                    <!-- <td>—</td> -->
                    <!-- <td>1</td> -->
                    <td class="num"><?php echo $p->Quantity; ?></td>
                    <td class="num"><?php echo $p->UnitPrice; ?></td>
                    <td class="num"><?php echo  number_format($Bill[$i]->TaxAmount ?? 0, 2); ?></td>
                    <td class="num"><?php echo  number_format(($p->Discount),2); ?></td>
                    <td class="num"><?php echo  number_format($p->Amount ?? 0, 2); ?></td>
                </tr>
               <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- AMOUNT IN WORDS + TOTALS -->
        <table class="mt-12">
            <tr>
                <td style="width:55%;vertical-align:top;">
                    <div class="card card-soft amount-box">
                        <div class="section-title">Amount in words</div>
                        <p class="mt-8 small">
                           <?php echo amountInWordsMYR(number_format(($totalAmt-$totalDisc),2),$currency); ?>
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
                                <td class="num"><?php echo number_format(($totalTax),2) ; ?>    </td>
                            </tr>
                            <tr class="grand">
                                <td>Balance</td>
                                <td class="num"><?php echo number_format(($totalAmt-$totalDisc),2) ; ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
         <?php $totalPaid=0.00 ; ?>
        <!-- PAYMENTS -->
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
                <?php foreach($payment_detail as $p) {
                    if(trim($p->PaymentMode) !='INSURANCE')  { $totalPaid += $p->PaymentAmount ; }
                    
                    ?>
                <tr>
                    <td  style="width:70px;"><?php echo $p->PaymentMode; ?></td>
                    <td  style="width:100px;"><?php echo $p->BankName; ?></td>
                    <td  style="width:70px;"><?php echo $p->ChequeCardNo; ?></td>
                    <td  style="width:80px;"><?php echo $p->PaymentDate; ?></td>
                    <td   style="width:80px;" class="num"><?php echo $p->PaymentAmount; ?></td>
                </tr>
              <?php }  ?>
              
                </tbody>
            </table>

            <div class="hr"></div>

            <table class="border-none small">
                <tr>
                    <td class="strong">Total Paid - </td>
                    <td class="strong" style="width:400px;"><?php echo amountInWordsMYR(number_format(($totalPaid),2),$currency) ; ?></td> 
                    <td class="num strong"><?php echo number_format(($totalPaid),2) ; ?></td>
                </tr>
            </table>
        </div>

    </div><!-- /page 1 -->

    <!-- mPDF page break -->
    <!-- <pagebreak /> -->

    <!-- ===================== PAGE 2 : PRESCRIPTION & CLINICAL NOTES ===================== -->
   

</div>
</body>
</html>
