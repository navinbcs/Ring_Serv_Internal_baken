<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING Clinic – Prescription</title>
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

    <!-- ===================== PAGE 1 : PRESCRIPTION ===================== -->
    <div class="page">

        <!-- HEADER (same layout as outpatient bill / ring_invoice) -->
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
                    <span class="pill">PRESCRIPTION</span>
                    <p class="mt-8 strong">Consultant</p>
                    <p class="strong">Dr. <?php echo htmlspecialchars($doctor['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="small mt-8"><span class="muted">Doctor&rsquo;s Licence No.</span><br><span class="strong"><?php echo $dashCell($lic); ?></span></p>
                    <p class="small mt-8"><span class="muted">Primary speciality</span><br><span class="strong"><?php echo $dashCell($pSp); ?></span></p>
                    <p class="small mt-8"><span class="muted">Secondary speciality</span><br><span class="strong"><?php echo $dashCell($sSp); ?></span></p>
                </td>
            </tr>
        </table>

        <!-- TOP INFO CARD (Patient / Visit / Details) -->
        <div class="mt-12 card">
            <table>
                <tr>
                    <!-- Patient -->
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Patient</div>
                        <table class="border-none small">
                            <tr>
                                <td>Name</td>
                                <td class="strong"><?= htmlspecialchars($patient['PatientFullName'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Age / Sex</td>
                                <td class="strong"><?= htmlspecialchars($patient['Age'] ?? '—') ?> / <?= htmlspecialchars($patient['Sex'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>MRN</td>
                                <td class="strong"><?= htmlspecialchars($patient['PatientMRN'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>IC/Passport No</td>
                                <td class="strong"><?= htmlspecialchars($patient['ICPassport'] ?? '—') ?></td>
                            </tr>
                        </table>
                    </td>

                    <!-- Visit -->
                    <td style="width:33%;vertical-align:top;">
                        <div class="section-title">Visit</div>
                        <table class="border-none small">
                            <tr>
                                <td>Visit No</td>
                                <td class="strong"><?= htmlspecialchars($visit['VisitNo'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Visit Date</td>
                                <td class="strong"><?= htmlspecialchars($visit['DateOfVisit'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Phone No</td>
                                <td class="strong"><?= htmlspecialchars($patient['Phone'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td class="strong"><?= htmlspecialchars($patient['Address'] ?? '—') ?></td>
                            </tr>
                        </table>
                    </td>

                    <!-- Vitals -->
                    <td style="width:34%;vertical-align:top;">
                        <div class="section-title">Vitals</div>
                        <table class="border-none small">
                            <tr>
                                <td>Pulse</td>
                                <td class="strong"><?= htmlspecialchars($progress['Pulse'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Blood Pressure</td>
                                <td class="strong"><?= htmlspecialchars($progress['BP'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Temperature</td>
                                <td class="strong"><?= htmlspecialchars($progress['Temperature'] ?? '—') ?></td>
                            </tr>
                            <tr>
                                <td>Respiration</td>
                                <td class="strong"><?= htmlspecialchars($progress['RespiratoryRate'] ?? '—') ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!-- PRESCRIPTION -->
        <div class="mt-12 card">
            <div class="section-title">Prescription</div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th>Medicine</th>
                    <th style="width:80px;">Strength</th>
                    <th style="width:100px;">Dosage</th>
                    <th style="width:80px;">Duration</th>
                    <th>Instructions</th>
                </tr>
                </thead>
                <tbody>
                  <?php if (!empty($prescriptions)): ?>
                    <?php foreach ($prescriptions as $prescription): ?>
                <tr>
                    <td><?= htmlspecialchars($prescription['Medication'] ?? '') ?></td>
                    <td><?= htmlspecialchars($prescription['Strength'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($prescription['Frequency'] ?? '') ?></td>
                    <td><?= htmlspecialchars($prescription['DurationDays'] ?? '') ?> days</td>
                    <td><?= htmlspecialchars($prescription['Instructions'] ?? '') ?></td>
                </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                <tr>
                    <td colspan="5" class="center muted">No prescriptions recorded</td>
                </tr>
                  <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- ALLERGIES & INVESTIGATIONS -->
        <table class="mt-12">
            <tr>
                <td style="width:50%;vertical-align:top;">
                    <div class="card">
                        <div class="section-title">Allergies</div>
                        <div class="mt-8 small">
                          <?php if (!empty($allergies)): ?>
                            <?php foreach ($allergies as $allergy): ?>
                            <p>
                                <strong><?= htmlspecialchars($allergy['Details'] ?? '') ?></strong> 
                                — <?= htmlspecialchars($allergy['Remarks'] ?? '') ?> 
                                (<?= htmlspecialchars($allergy['Severity'] ?? '') ?>)
                            </p>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <p class="muted">No allergies recorded</p>
                          <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td style="width:50%;vertical-align:top;">
                    <div class="card">
                        <div class="section-title">Investigations</div>
                        <table class="mt-8">
                            <thead>
                            <tr>
                                <th>Test</th>
                                <th style="width:100px;">When</th>
                                <th>Notes</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php if (!empty($investigations)): ?>
                                <?php foreach ($investigations as $investigation): ?>
                            <tr>
                                <td><?= htmlspecialchars($investigation['Type'] ?? '') ?></td>
                                <td><?= htmlspecialchars($investigation['DateTime'] ?? '') ?></td>
                                <td><?= htmlspecialchars($investigation['Notes'] ?? '—') ?></td>
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
                </td>
            </tr>
        </table>

        <!-- MEDICAL HISTORY & COMPLAINTS -->
        <table class="mt-12">
            <tr>
                <td style="width:50%;vertical-align:top;">
                    <div class="card">
                        <div class="section-title">Medical History</div>
                        <div class="mt-8 small">
                          <?php if (!empty($medicalHistory)): ?>
                            <?php foreach ($medicalHistory as $history): ?>
                            <p>
                                <?= htmlspecialchars($history['DiseaseOrSurgery'] ?? '') ?> 
                                — <?= htmlspecialchars($history['DoctorHospital'] ?? '') ?>
                                (<?= htmlspecialchars($history['DateIdentified'] ?? '') ?>)
                            </p>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <p class="muted">No medical history recorded</p>
                          <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td style="width:50%;vertical-align:top;">
                    <div class="card">
                        <div class="section-title">Complaints & Diagnosis</div>
                        <div class="mt-8 small">
                            <p><strong>Complaints:</strong></p>
                            <p><?= htmlspecialchars($progress['Complaints'] ?? '—') ?></p>
                            <?php if (!empty($progress['Diagnosis']) && $progress['Diagnosis'] != '-'): ?>
                            <p class="mt-8"><strong>Diagnosis:</strong></p>
                            <p><?= htmlspecialchars($progress['Diagnosis']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- SIGNATURES -->
        <table class="mt-16">
            <tr>
                <td style="width:50%;vertical-align:bottom;">
                    <div style="border-top:1px solid #d7e0eb;padding-top:8px;">
                        <p class="small muted">Patient Signature</p>
                    </div>
                </td>
                <td style="width:50%;vertical-align:bottom;">
                    <div style="border-top:1px solid #d7e0eb;padding-top:8px;">
                        <p class="small muted">Doctor's Signature</p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- FOOTER -->
        <div class="mt-16">
            <table class="border-none">
                <tr>
                    <td class="small muted">For emergencies call <?= htmlspecialchars($tenant['phone'] ?? '') ?></td>
                    <td class="right mono small muted">Printed on: <?= htmlspecialchars($meta['DateOfPrinting'] ?? date('d M Y H:i:s')) ?></td>
                </tr>
            </table>
        </div>

    </div><!-- /page 1 -->

</div>
</body>
</html>
