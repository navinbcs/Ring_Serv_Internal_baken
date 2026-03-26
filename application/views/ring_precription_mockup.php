<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>RING – INVOICE</title>
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
<div class="page-wrap" >

    <!-- ===================== PAGE 1 : OUTPATIENT BILL ===================== -->
    <div class="page">

        <!-- HEADER -->
        <table>
            <tr>
                <td style="width:60%;vertical-align:top;">
                    <img src="img/RingLogo.png" width="200" style="background: #f3fafd;padding: 0 10px; border-radius: 6px;">
                </td>
                <td style="width:40%;vertical-align:top;" class="right">
                    <h2>RING Clinic Kuala Lumpur</h2>
                    <p class="mt-8 strong">RING Clinic Kuala Lumpur:</p>
                    <p class="strong">  20, Vertical Business Suites,</p>
                        <p class=" strong">Jln. Kerinchi, Bangsar South,</p>
                </td>
            </tr>
        </table>

        <div class="mt-12 card">
            
            <div class="section-title">Patient Details</div>
            <table class="border-none small">
                <tr>
                    <td style="width: 45%;">
                        <table class="border-none">
                        <tr>
                            <td>Visit Date</td>
                            <td class="strong"> 03/12/2025</td>
                        </tr>
                        <tr>
                            <td>Patient Name</td>
                            <td class="strong">TEST3DEC251 TEST</td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td class="strong">18</td>
                        </tr>  
                        <tr>
                            <td>Sex</td>
                            <td class="strong">Male</td>
                        </tr> 
                        <tr>
                            <td>IC/Passport No</td>
                            <td class="strong">6895589</td>
                        </tr> 
                        </table>
                    </td> 
                    
                    <td style="width: 45%;">
                        <table class="border-none">
                        <tr>
                            <td>Phone No</td>
                            <td class="strong">+60 11031220251</td>
                        </tr>
                        <tr>
                            <td>MRN</td>
                            <td class="strong">RCKL1-PRN-00115</td>
                        </tr>
                        <tr>
                            <td>Visit No</td>
                            <td class="strong">RCKL1-00000203</td>
                        </tr>
                        <tr>
                            <td>Consultant</td>
                            <td class="strong">Dr.Greg House</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="strong">
                                <div style="width: 200px;">
                                    MYS, Kuala Lumpur, Wilayah
                                    Persekutuan Kuala Lumpur,
                                    Malaysia,
                                </div>
                              </td>
                        </tr>
                        </table>   
                    </td>
                </tr>
                
            </table>
                  
        </div>

        <div class="mt-16 card">
            <div class="section-title">Allergies </div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:70px;text-align:left">Date Identified</th>
                    <th style="width:70px;text-align:left">Details</th>
                    <th style="width:70px;text-align:left">Remarks</th>
                    <th style="width:70px;text-align:left">Severity </th>
                    <th style="width:80px;text-align:left" class="num">Category</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td  style="width:70px;">10/12/2025</td>
                    <td  style="width:70px;">Details</td>
                    <td  style="width:70px;">Remarks</td>
                    <td  style="width:70px;">Severity</td>
                    <td  style="width:80px;">allergy</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-16 card">
            <div class="section-title">Prescription </div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:70px;text-align:left">Medication</th>
                    <th style="width:70px;text-align:left">Quantity</th>
                    <th style="width:70px;text-align:left">Frequency</th>
                    <th style="width:70px;text-align:left">Duration(Days) </th>
                    <th style="width:80px;text-align:left" >Instructions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td  style="width:70px;">10/12/2025</td>
                    <td  style="width:70px;">Details</td>
                    <td  style="width:70px;">Remarks</td>
                    <td  style="width:70px;">Severity</td>
                    <td  style="width:80px;">allergy</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-16 card">
            <div class="section-title">Medical History </div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:70px;text-align:left">Date identified</th>
                    <th style="width:70px;text-align:left">Disease / Surgery</th>
                    <th style="width:70px;text-align:left">Doctor/Hospital Name</th>
                    <th style="width:70px;text-align:left">Updated By</th>
                    <th style="width:80px;text-align:left" >Updated Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td  style="width:70px;">10/12/2025</td>
                    <td  style="width:70px;">Allergy</td>
                    <td  style="width:70px;">Ring</td>
                    <td  style="width:70px;">Doctor</td>
                    <td  style="width:80px;">10/12/2025</td>
                </tr>
                </tbody>
            </table>
        </div>

       
        <!-- AMOUNT IN WORDS + TOTALS -->
        <table class="mt-12">
            <tr>
                <td style="width:60%;vertical-align:top;">
                    <div class="card card-soft" style="height:115px;">
                        <div class="section-title">Progress Notes</div>
                        <p class="mt-8">
                            Patient Complaints
                        </p>
                    </div>
                </td>
                <td style="width:40%;vertical-align:top;">
                    <div class="card">
                        <div class="section-title">Initial Diagnosis</div>
                        <table class="totals small">
                            <tr>
                                <td>Pulse</td>
                                <td class="num">11111</td>
                            </tr>
                            <tr>
                                <td>BP</td>
                                <td class="num">11</td>
                            </tr>
                            <tr>
                                <td>Temperature</td>
                                <td class="num">38.80</td>
                            </tr>
                            <tr>
                                <td>Respiratory Rate</td>
                                <td class="num">2222222222</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="mt-16 card">
            <div class="section-title">Investigations </div>
            <table class="mt-8">
                <thead>
                <tr>
                    <th style="width:70px;text-align:left">Date </th>
                    <th style="width:70px;text-align:left">Time</th>
                    <th style="width:70px;text-align:left">Investigation</th>
                    <th style="width:70px;text-align:left">Type</th>
                    <th style="width:80px;text-align:left" >Added / Update By</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td  style="width:70px;">10/12/2025</td>
                    <td  style="width:70px;">11:00AM</td>
                    <td  style="width:70px;">Investigation</td>
                    <td  style="width:70px;">allergy</td>
                    <td  style="width:80px;">Added</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div><!-- /page 1 -->

    <!-- mPDF page break -->
    <!-- <pagebreak /> -->

    <!-- ===================== PAGE 2 : PRESCRIPTION & CLINICAL NOTES ===================== -->
   

</div>
</body>
</html>
