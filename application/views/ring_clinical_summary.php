<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING Clinic – Clinical Summary</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
            font-size:11px;
            line-height:1.45;
            color:#0f172a;
        }
        .page-wrap{}
        .page{padding:24px 26px;}
        h1{font-size:18px;margin:0 0 4px;}
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
        tbody td{border-bottom:1px solid #edf1f7;}
        tbody tr:last-child td{border-bottom:none;}
        .border-none th,.border-none td{border:0!important;}
        .section-title{
            font-size:11px;
            font-weight:bold;
            letter-spacing:0.5px;
            text-transform:uppercase;
            color:#64748b;
        }
        .mono{font-family:"SF Mono","Roboto Mono",Menlo,monospace;font-size:10px;}
    </style>
</head>
<body>
<div class="page-wrap">
    <div class="page">

        <!-- HEADER (same as prescription / bill) -->
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
                    <span class="pill">CLINICAL SUMMARY</span>
                    <p class="mt-8 strong">Consultant</p>
                    <p class="strong">Dr. <?php echo htmlspecialchars($doctor['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="small mt-8"><span class="muted">Doctor&rsquo;s Licence No.</span><br><span class="strong"><?php echo $dashCell($lic); ?></span></p>
                    <p class="small mt-8"><span class="muted">Primary speciality</span><br><span class="strong"><?php echo $dashCell($pSp); ?></span></p>
                    <p class="small mt-8"><span class="muted">Secondary speciality</span><br><span class="strong"><?php echo $dashCell($sSp); ?></span></p>
                </td>
            </tr>
        </table>

        <!-- TOP INFO (same as prescription: Patient | Visit | Vitals) -->
        <div class="mt-12 card">
            <table>
                <tr>
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

        <!-- 1. Medical History -->
        <div class="mt-12 card">
            <div class="section-title">Medical History</div>
            <div class="mt-8 small">
                <?php if (!empty($medicalHistory)): ?>
                    <?php foreach ($medicalHistory as $history): ?>
                        <p>
                            <?= htmlspecialchars($history['DiseaseOrSurgery'] ?? '') ?>
                            <?php if (($history['DoctorHospital'] ?? '') !== ''): ?>
                                — <?= htmlspecialchars($history['DoctorHospital']) ?>
                            <?php endif; ?>
                            <?php if (($history['DateIdentified'] ?? '') !== ''): ?>
                                <span class="muted">(<?= htmlspecialchars($history['DateIdentified']) ?>)</span>
                            <?php endif; ?>
                        </p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="muted">No medical history recorded</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 2. Allergies -->
        <div class="mt-12 card">
            <div class="section-title">Allergies</div>
            <div class="mt-8 small">
                <?php if (!empty($allergies)): ?>
                    <?php foreach ($allergies as $allergy): ?>
                        <p>
                            <strong><?= htmlspecialchars($allergy['Details'] ?? '') ?></strong>
                            <?php if (($allergy['Remarks'] ?? '') !== ''): ?>
                                — <?= htmlspecialchars($allergy['Remarks']) ?>
                            <?php endif; ?>
                            <?php if (($allergy['Severity'] ?? '') !== ''): ?>
                                <span class="muted">(<?= htmlspecialchars($allergy['Severity']) ?>)</span>
                            <?php endif; ?>
                        </p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="muted">No allergies recorded</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 3. Progress Notes -->
        <div class="mt-12 card">
            <div class="section-title">Progress Notes</div>
            <div class="mt-8 small">
                <?php if (!empty($progress['Complaints']) && $progress['Complaints'] !== '—'): ?>
                    <p><strong>Complaints</strong></p>
                    <p><?= htmlspecialchars($progress['Complaints']) ?></p>
                <?php endif; ?>
                <?php if (!empty($progress['Diagnosis']) && $progress['Diagnosis'] !== '—'): ?>
                    <p class="mt-8"><strong>Diagnosis</strong></p>
                    <p><?= htmlspecialchars($progress['Diagnosis']) ?></p>
                <?php endif; ?>
                <?php if (!empty($progressNoteLines)): ?>
                    <?php foreach ($progressNoteLines as $line): ?>
                        <p class="mt-8">
                            <?php if (($line['date'] ?? '') !== ''): ?>
                                <span class="strong"><?= htmlspecialchars($line['date']) ?></span>
                                <?php if (($line['text'] ?? '') !== ''): ?><br><?php endif; ?>
                            <?php endif; ?>
                            <?= nl2br(htmlspecialchars($line['text'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
                        </p>
                    <?php endforeach; ?>
                <?php elseif (empty($progress['Complaints']) || $progress['Complaints'] === '—'): ?>
                    <?php if (empty($progress['Diagnosis']) || $progress['Diagnosis'] === '—'): ?>
                        <p class="muted">No progress notes recorded</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- 4. Investigations -->
        <div class="mt-12 card">
            <div class="section-title">Investigations</div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th>Test</th>
                    <th style="width:120px;">When</th>
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

        <!-- 5. Prescription -->
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

        <!-- 6. Discharge Summary (usp_rpt_DischargeNotes — aligned with RING.Web ClinicalSummary.repx: DoctorName, InsertDate, ICDCodeDescription, DischargeNotes) -->
        <div class="mt-12 card">
            <div class="section-title">Discharge Summary</div>
            <?php
            $drows = $dischargeRows ?? [];
            if (isset($discharge) && is_array($discharge) && !isset($dischargeRows)) {
                $drows = [$discharge];
            }
            ?>
            <?php if (!empty($drows)): ?>
                <?php foreach ($drows as $idx => $dc): ?>
                    <?php if ($idx > 0): ?>
                        <p class="mt-8 muted small">──────────────</p>
                    <?php endif; ?>
                    <table class="border-none small mt-8">
                        <tr>
                            <td style="width:38%;" class="muted">Doctor name</td>
                            <td class="strong"><?= htmlspecialchars($dc['doctorName'] ?? '—') ?></td>
                        </tr>
                        <tr>
                            <td class="muted">Discharge date and time</td>
                            <td class="strong mono"><?= htmlspecialchars($dc['dischargeDateTime'] ?? '—') ?></td>
                        </tr>
                        <tr>
                            <td class="muted">Final diagnosis (ICD)</td>
                            <td class="strong"><?= nl2br(htmlspecialchars($dc['icdDescription'] ?? '—', ENT_QUOTES, 'UTF-8')) ?></td>
                        </tr>
                        <tr>
                            <td class="muted">Discharge notes</td>
                            <td class="strong"><?= nl2br(htmlspecialchars($dc['dischargeNotes'] ?? '—', ENT_QUOTES, 'UTF-8')) ?></td>
                        </tr>
                        <?php if (trim((string) ($dc['dischargedBy'] ?? '')) !== ''): ?>
                        <tr>
                            <td class="muted">Discharged by</td>
                            <td class="strong"><?= htmlspecialchars($dc['dischargedBy'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php
                        $fuExtras = [
                            ['followUpDateTime', 'Follow up — date &amp; time', true],
                            ['followUpRemark', 'Follow up visit suggested — remark', false],
                            ['followUpDate', 'Follow up visit suggested date', true],
                            ['remark', 'Additional remark', false],
                        ];
                        foreach ($fuExtras as $fe) {
                            $k = $fe[0];
                            $lab = $fe[1];
                            $isMono = $fe[2];
                            $v = trim((string) ($dc[$k] ?? ''));
                            if ($v === '' || $v === '—') {
                                continue;
                            }
                            $tdCls = 'strong' . ($isMono ? ' mono' : '');
                            $inner = ($k === 'followUpRemark' || $k === 'remark')
                                ? nl2br(htmlspecialchars($v, ENT_QUOTES, 'UTF-8'))
                                : htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
                        ?>
                        <tr>
                            <td class="muted"><?= $lab ?></td>
                            <td class="<?= $tdCls ?>"><?= $inner ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="mt-8 small muted">No discharge summary recorded</p>
            <?php endif; ?>
        </div>

        <div class="mt-16">
            <table class="border-none">
                <tr>
                    <td class="small muted">For emergencies call <?= htmlspecialchars($tenant['phone'] ?? '') ?></td>
                    <td class="right mono small muted">Printed on: <?= htmlspecialchars($meta['DateOfPrinting'] ?? date('d M Y H:i:s')) ?></td>
                </tr>
            </table>
        </div>

    </div>
</div>
</body>
</html>
