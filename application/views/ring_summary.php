<?php
// -------------------------
// Helpers
// -------------------------
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

$tenant         = $tenant ?? [];
$patient        = $patient ?? [];
$visit          = $visit ?? [];
$meta           = $meta ?? [];
$printedBy      = $printedBy ?? '';
$allergies      = $allergies ?? [];
$prescriptions  = $prescriptions ?? [];
$medicalHistory = $medicalHistory ?? [];
$progress       = $progress ?? [];
$investigations = $investigations ?? [];

// Logo path - keep same as your bill
$logoPath = FCPATH . 'assets/SkeenLogo.png';
$hasLogo  = !empty($logoPath) && file_exists($logoPath);

// Safe defaults
$clinicName    = $tenant['name'] ?? 'RING Clinic';
$clinicAddress = $tenant['address'] ?? '';
$clinicPhone   = $tenant['phone'] ?? '';
$clinicEmail   = $tenant['email'] ?? '';

$patientName = $patient['PatientFullName'] ?? '—';
$patientAge  = $patient['Age'] ?? '—';
$patientSex  = $patient['Sex'] ?? '—';
$patientMRN  = $patient['PatientMRN'] ?? '—';
$patientIC   = $patient['ICPassport'] ?? '—';
$patientPhone= $patient['Phone'] ?? '—';
$patientAddr = $patient['Address'] ?? '—';

$visitDate   = $visit['DateOfVisit'] ?? '—';
$visitNo     = $visit['VisitNo'] ?? '—';
$consultant  = $visit['Consultant'] ?? '—';

$printDate   = $meta['DateOfPrinting'] ?? date('d/m/Y H:i:s');

$complaints  = $progress['Complaints'] ?? '—';
$diagnosis   = $progress['Diagnosis'] ?? '—';
$pulse       = $progress['Pulse'] ?? '—';
$bp          = $progress['BP'] ?? '—';
$temp        = $progress['Temperature'] ?? '—';
$resp        = $progress['RespiratoryRate'] ?? '—';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?= e($clinicName) ?> – Prescription</title>

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

    /* NOTE: pills + card-radius are OK in your bill; keep same */
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

    .border-none th,
    .border-none td{border:0!important;}

    .section-title{
        font-size:11px;
        font-weight:bold;
        letter-spacing:0.5px;
        text-transform:uppercase;
        color:#64748b;
    }

    .hr{border-bottom:1px solid #d7e0eb;margin:10px 0;}
    .mono{ font-family:"SF Mono","Roboto Mono",Menlo,monospace; font-size:10px; }
</style>
</head>

<body>
<div class="page-wrap">
<div class="page">

    <!-- HEADER -->
    <table>
        <tr>
            <td style="width:60%;vertical-align:top;">
                <?php if ($hasLogo): ?>
                    <img src="<?= e($logoPath) ?>" width="80" style="margin-bottom:8px;">
                <?php endif; ?>
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
                <!-- <p class="small muted mt-8">
                    <?php if ($clinicPhone): ?>Phone: <?= e($clinicPhone) ?><?php endif; ?>
                    <?php if ($clinicEmail): ?> &nbsp; | &nbsp; Email: <?= e($clinicEmail) ?><?php endif; ?>
                </p> -->
            </td>

            <td style="width:40%;vertical-align:top;" class="right">
                <span class="pill-rx">PRESCRIPTION &amp; CLINICAL NOTES</span>
                <p class="mt-8 strong">Consultant</p>
                <p class="strong">Dr. <?= e($consultant) ?></p>
            </td>
        </tr>
    </table>

    <!-- TOP INFO CARD -->
    <div class="mt-12 card">
        <table>
            <tr>
                <!-- Patient -->
                <td style="width:33%;vertical-align:top;">
                    <div class="section-title">Patient</div>
                    <table class="border-none small">
                        <tr>
                            <td>Name</td>
                            <td class="strong"><?= e($patientName) ?></td>
                        </tr>
                        <tr>
                            <td>Age / Sex</td>
                            <td class="strong"><?= e($patientAge) ?> / <?= e($patientSex) ?></td>
                        </tr>
                        <tr>
                            <td>MRN</td>
                            <td class="strong"><?= e($patientMRN) ?></td>
                        </tr>
                        <tr>
                            <td>IC/Passport</td>
                            <td class="strong"><?= e($patientIC) ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Visit -->
                <td style="width:33%;vertical-align:top;">
                    <div class="section-title">Visit</div>
                    <table class="border-none small">
                        <tr>
                            <td>Visit No</td>
                            <td class="strong"><?= e($visitNo) ?></td>
                        </tr>
                        <tr>
                            <td>Visit Date</td>
                            <td class="strong"><?= e($visitDate) ?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td class="strong"><?= e($patientPhone) ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Vitals -->
                <td style="width:34%;vertical-align:top;">
                    <div class="section-title">Vitals</div>
                    <table class="border-none small">
                        <tr>
                            <td>BP</td>
                            <td class="strong"><?= e($bp) ?></td>
                        </tr>
                        <tr>
                            <td>Pulse</td>
                            <td class="strong"><?= e($pulse) ?></td>
                        </tr>
                        <tr>
                            <td>Temp</td>
                            <td class="strong"><?= e($temp) ?></td>
                        </tr>
                        <tr>
                            <td>Resp.</td>
                            <td class="strong"><?= e($resp) ?></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="3" class="small muted" style="padding-top:8px;">
                    <span class="strong">Address:</span> <?= e($patientAddr) ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- CLINICAL NOTES -->
    <div class="mt-12 card card-soft">
        <div class="section-title">Clinical Notes</div>
        <table class="border-none small mt-8">
            <tr>
                <td style="width:120px;" class="muted">Complaints</td>
                <td class="strong"><?= e($complaints) ?></td>
            </tr>
            <tr>
                <td class="muted">Diagnosis</td>
                <td class="strong"><?= e($diagnosis) ?></td>
            </tr>
        </table>
    </div>

    <!-- PRESCRIPTION TABLE (auto repeat) -->
    <div class="mt-12 card">
        <div class="section-title">Prescription</div>

        <table class="mt-8">
            <thead>
                <tr>
                    <th style="width:70px;">Qty</th>
                    <th style="width:190px;">Medicine</th>
                    <th >Strength</th>
                    <th style="width:80px;">Frequency</th>
                    <th style="width:90px;">Duration</th>
                    <th style="width:170px;">Instructions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($prescriptions) && is_array($prescriptions)) : ?>
                <?php foreach ($prescriptions as $rx) : ?>
                    <tr>
                       <td ><?= isset($rx['Quantity']) ? (int)$rx['Quantity'] : '—' ?></td>
                        <td><?= e($rx['Medication'] ?? '—') ?></td>
                        <td><?= e($rx['Strength'] ?? '—') ?></td>
                        <td><?= e($rx['Frequency'] ?? '—') ?></td>
                        <td class="small">
                            <?php
                                $dd = $rx['DurationDays'] ?? '';
                                echo ($dd !== '' && $dd !== null) ? e($dd).' days' : '—';
                            ?>
                        </td>
                        <td class="small"><?= e($rx['Instructions'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="center muted">No prescription items found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ALLERGIES + INVESTIGATIONS -->
 <!-- ALLERGIES -->
<div class="mt-12 card">
    <div class="section-title">Allergies</div>
    <div class="mt-8 small">
        <?php if (!empty($allergies)) : ?>
            <?php foreach ($allergies as $a) : ?>
                <p>
                    • <span class="strong"><?= e($a['Details'] ?? '—') ?></span>
                    <?php if (!empty($a['Severity'])) : ?> (<?= e($a['Severity']) ?>)<?php endif; ?>
                    <?php if (!empty($a['Category'])) : ?> — <?= e($a['Category']) ?><?php endif; ?>
                    <?php if (!empty($a['Remarks'])) : ?> — <?= e($a['Remarks']) ?><?php endif; ?>
                </p>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="muted">No allergies recorded</p>
        <?php endif; ?>
    </div>
</div>

<!-- INVESTIGATIONS -->
<div class="mt-12 card">
    <div class="section-title">Investigations</div>

    <table class="mt-8">
        <thead>
            <tr>
                <th>Test</th>
                <th style="width:120px;">Date/Time</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($investigations)) : ?>
            <?php foreach ($investigations as $inv) : ?>
                <tr>
                    <td><?= e($inv['Type'] ?? '—') ?></td>
                    <td><?= e($inv['DateTime'] ?? '—') ?></td>
                    <td class="small"><?= e($inv['Notes'] ?? '—') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="center muted">No investigations recorded</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

    <!-- MEDICAL HISTORY -->
    <div class="mt-12 card">
        <div class="section-title">Medical History</div>
        <div class="mt-8 small">
            <?php if (!empty($medicalHistory) && is_array($medicalHistory)) : ?>
                <?php foreach ($medicalHistory as $h) : ?>
                    <p>• <?= e($h['DiseaseOrSurgery'] ?? '—') ?>
                        <?php if (!empty($h['DoctorHospital'])) : ?> — <?= e($h['DoctorHospital']) ?><?php endif; ?>
                        <?php if (!empty($h['DateIdentified'])) : ?> (<?= e($h['DateIdentified']) ?>)<?php endif; ?>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="muted">No medical history recorded</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- SIGNATURES -->
    <table class="mt-16 border-none small">
        <tr>
            <td style="width:50%;vertical-align:bottom;">
                <div class="hr"></div>
                <p class="muted">Patient Signature</p>
            </td>
            <td style="width:50%;vertical-align:bottom;" class="right">
                <div class="hr"></div>
                <p class="muted">Doctor’s Signature</p>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="mt-12">
        <table class="border-none small">
            <tr>
                <td class="muted">
                    Printed By: <span class="strong"><?= e($printedBy ?: 'System') ?></span>
                </td>
                <td class="right muted">
                    Printed On: <span class="strong"><?= e($printDate) ?></span>
                </td>
            </tr>
        </table>
    </div>

</div><!-- /page -->
</div><!-- /page-wrap -->
</body>
</html>
