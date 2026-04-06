<?php
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

// Data defaults
$tenant      = $tenant ?? [];
$patient     = $patient ?? [];
$visit       = $visit ?? [];
$certificate = $certificate ?? [];
$meta        = $meta ?? [];
$printedBy   = $printedBy ?? 'System';

// Base64 Logo (100% mPDF reliable)
$logoFile = FCPATH . 'assets/SkeenLogo.png';
$logoDataUri = '';
if (file_exists($logoFile)) {
    $imgData = file_get_contents($logoFile);
    $logoDataUri = 'data:image/png;base64,' . base64_encode($imgData);
}

// Pull fields
$clinicName = $tenant['name'] ?? 'RING Clinic';
$clinicAddr = $tenant['address'] ?? '';

$patientName = $patient['PatientFullName'] ?? '—';
$nric        = $patient['ICPassport'] ?? '—';

$consultant  = $visit['Consultant'] ?? '—';

$examOn      = $certificate['ExaminedOn'] ?? ($visit['DateOfVisit'] ?? date('d/m/Y'));
$unfitFrom   = $certificate['UnfitFrom'] ?? $examOn;
$unfitTo     = $certificate['UnfitTo'] ?? $examOn;
$totalDays   = $certificate['TotalDays'] ?? 1;

$printDate   = $meta['DateOfPrinting'] ?? date('d/m/Y H:i:s');

// Date formatting like certificate sample: "22 December 2025"
function prettyDate($d){
    $dt = DateTime::createFromFormat('d/m/Y', $d) ?: DateTime::createFromFormat('d-m-Y', $d);
    return $dt ? $dt->format('d F Y') : $d;
}

$gender = $gender ?? ($tenant['gender'] ?? '');

if ($gender === 'Female') {
    $pronoun = 'She';
    $possessive = 'her';
} elseif ($gender === 'Male') {
    $pronoun = 'He';
    $possessive = 'his';
} else {
    $pronoun = 'The patient';
    $possessive = 'their';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Medical Certificate</title>
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
    thead th{
        font-size:10px;
        text-transform:uppercase;
        letter-spacing:0.4px;
        color:#64748b;
        border-bottom:1px solid #d7e0eb;
    }
    .border-none th,.border-none td{border:0!important;}

    .section-title{
        font-size:11px;
        font-weight:bold;
        letter-spacing:0.5px;
        text-transform:uppercase;
        color:#64748b;
    }

    .hr{border-bottom:1px solid #d7e0eb;margin:10px 0;}
</style>
</head>

<body>
<div class="page-wrap">
<div class="page">

    <!-- HEADER (same as bill) -->
    <table>
        <tr>
            <td style="width:60%;vertical-align:top;">
                <?php if (!empty($logoDataUri)) : ?>
                    <img src="<?php echo $logoDataUri; ?>" width="80" style="margin-bottom:8px;">
                <?php endif; ?>
                <h1><?php echo e($clinicName); ?></h1>
                <p class="small muted"><?php echo e($clinicAddr); ?></p>
            </td>

            <td style="width:40%;vertical-align:top;" class="right">
                <span class="pill">MEDICAL CERTIFICATE</span>

                <p class="mt-8 strong">Consultant</p>
                <p class="strong">Dr. <?php echo e($consultant); ?></p>
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
                            <td>Name</td>
                            <td class="strong"><?php echo e($patientName); ?></td>
                        </tr>
                        <tr>
                            <td>NRIC / Passport</td>
                            <td class="strong"><?php echo e($nric); ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Visit -->
                <td style="width:33%;vertical-align:top;">
                    <div class="section-title">Visit</div>
                    <table class="border-none small">
                        <tr>
                            <td>Examined On</td>
                            <td class="strong"><?php echo e(prettyDate($examOn)); ?></td>
                        </tr>
                        <tr>
                            <td>Unfit From</td>
                            <td class="strong"><?php echo e(prettyDate($unfitFrom)); ?></td>
                        </tr>
                        <tr>
                            <td>Unfit To</td>
                            <td class="strong"><?php echo e(prettyDate($unfitTo)); ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Printing -->
                <td style="width:34%;vertical-align:top;">
                    <div class="section-title">Printing</div>
                    <table class="border-none small">
                        <tr>
                            <td>Total Days</td>
                            <td class="strong"><?php echo (int)$totalDays; ?> day(s)</td>
                        </tr>
                        <tr>
                            <td>Printed By</td>
                            <td class="strong"><?php echo e($printedBy); ?></td>
                        </tr>
                        <tr>
                            <td>Printed On</td>
                            <td class="strong"><?php echo e($printDate); ?></td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
    </div>

    <!-- CERTIFICATE TEXT (same soft card style) -->
    <div class="mt-12 card card-soft">
        <div class="section-title">Certificate Statement</div>

        <p class="mt-12">
            This is to certify that I have examined <span class="strong"><?php echo e($patientName); ?></span>
            (NRIC No: <span class="strong"><?php echo e($nric); ?></span>) on
            <span class="strong"><?php echo e(prettyDate($examOn)); ?></span>
          and found that <span class="strong"><?php echo $pronoun; ?></span>
                is unfit for the proper performance of <?php echo $possessive; ?> duties
            from <span class="strong"><?php echo e(prettyDate($unfitFrom)); ?></span> to
            <span class="strong"><?php echo e(prettyDate($unfitTo)); ?></span>,
            amounting to a total of <span class="strong"><?php echo (int)$totalDays; ?></span> day(s).
        </p>

        <p class="mt-12 small muted">
            *This document is computer-generated and valid without signature if issued digitally.
        </p>
    </div>

    <br /><br />
    <!-- SIGNATURES (billing style) -->
    <table class="mt-16 border-none small">
        <tr>
            <td style="width:50%;vertical-align:bottom;">
                <div class="hr"></div>
                <p class="muted">Date</p>
                <p class="strong"><?php echo e(date('d/m/Y')); ?></p>
            </td>
            <td style="width:50%;vertical-align:bottom;" class="right">
                <div class="hr"></div>
                <p class="muted">Name &amp; Signature of Medical Practitioner</p>
                <p class="strong">Dr. <?php echo e($consultant); ?></p>
            </td>
        </tr>
    </table>


</div>
</div>
</body>
</html>
