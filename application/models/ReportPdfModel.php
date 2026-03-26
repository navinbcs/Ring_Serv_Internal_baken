<?php
class ReportPdfModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDataFromSP($spName, $patientId, $enrollmentID)
    {
        $sp = 'EXEC ' . $spName;
        $query = $this->db->query(" $sp " . $patientId . "," . $enrollmentID . " ");
        $result = $query->result();
        //  echo $this->db->last_query();
        return $result;
    }
    public function getEnrolentID($chargeHeaderID)
    {

        $query = $this->db->query("select * from ChargeEntryHeader where  ID=" . $chargeHeaderID);
        $result = $query->result();
        //  echo $this->db->last_query();
        return $result;
    }

    public function fullReportPatientBilling($patientId, $enrollmentId)
    {
        $result = [];

        /*PATIENT DETAILS*/
        $patient_sql = "
            SELECT DISTINCT
                E.PatientId,
                T.TenantName,
                T.Address AS TenantAddress,
                PM.Fullname,
                ISNULL(PM.Lastname, '') AS Lastname,
                CONVERT(VARCHAR, E.EnrollmentDate, 103) AS EnrollmentDate,
                PM.MobileCode,
                PM.MobileNumber AS PhoneNo,
                DATEDIFF(YEAR, PM.DateOfBirth, GETDATE()) -
                    CASE WHEN (MONTH(GETDATE()) < MONTH(PM.DateOfBirth)) 
                        OR (MONTH(GETDATE()) = MONTH(PM.DateOfBirth) AND DAY(GETDATE()) < DAY(PM.DateOfBirth))
                        THEN 1 ELSE 0 END AS DateOfBirth,
                CASE WHEN PM.CountryMasterId IS NOT NULL  
                    THEN PM.Address + ', ' + ISNULL(CI.CityDescription,'') + ', ' + 
                         ISNULL(SM.StateDescription,'') + ', ' + ISNULL(CM.CountryDescription,'') + ', ' + 
                         ISNULL(PM.PinCode,'') 
                    ELSE PM.Address  
                END AS Address,
                GM.Description AS GenderId,
                PM.IdentityNo,
                E.prn AS Prn,
                E.EncounterNo,
                U.DisplayName + ' ' + U.LastName AS Consultant,
                T.tenantLogo,
                CONVERT(VARCHAR, GETUTCDATE(), 103) + ' ' + CONVERT(VARCHAR, GETUTCDATE(), 108) AS CurrentDateTime
            FROM Enrollment E
            INNER JOIN Tenants T ON E.TenantId = T.tenantId
            INNER JOIN PatientMaster PM ON E.PatientId = PM.PatientId
            INNER JOIN Users U ON E.PrimaryPractitionerId = U.linkuserid
            LEFT JOIN CountryMaster CM ON PM.CountryMasterId = CM.ID
            LEFT JOIN StateMaster SM ON PM.StateMasterId = SM.ID
            LEFT JOIN CityMaster CI ON PM.CityMasterId = CI.ID
            INNER JOIN GenderMaster GM ON PM.GenderId = GM.Id
            WHERE E.Id = ? AND E.PatientId = ?
        ";
        $result['patient_details'] = $this->db->query($patient_sql, [$enrollmentId, $patientId])->result_array();


        /*INVOICE DETAILS*/
        $invoice_sql = "
            SELECT DISTINCT
                CH.PatientId,
                PM.Fullname,
                ISNULL(PM.Lastname,'') AS Lastname,
                CH.BillNo AS InvoiceNo,
                CONVERT(VARCHAR,CH.BillDate, 103) AS InvoiceDate,
                CASE WHEN PM.CountryMasterId IS NOT NULL
                    THEN PM.Address + ', ' + ISNULL(CM.CountryDescription,'') + ', ' + 
                         ISNULL(SM.StateDescription,'') + ', ' + ISNULL(CI.CityDescription,'') + ', ' + 
                         ISNULL(PM.PinCode,'')
                    ELSE PM.Address
                END AS billingAddress,
                BH.NetAmount,
                BH.TaxAmount,
                BH.DiscountAmount,
                BH.BillAmount,
                dbo.NumberToWords(BH.BillAmount) AS AmountInWords,
                TM.tenantname AS TenantName,
                HM.Description + U.DisplayName + ' ' + ISNULL(U.LastName,'') AS PreparedBy
            FROM ChargeEntryHeader CH
            INNER JOIN PatientMaster PM ON CH.PatientId = PM.PatientId
            LEFT JOIN BillHeader BH ON CH.BillHeaderId = BH.Id
            LEFT JOIN CountryMaster CM ON PM.CountryMasterId = CM.ID
            LEFT JOIN StateMaster SM ON PM.StateMasterId = SM.ID
            LEFT JOIN CityMaster CI ON PM.CityMasterId = CI.ID
            LEFT JOIN Tenants TM ON TM.tenantid = CH.tenantid  
            LEFT JOIN Users U ON U.userid = BH.insertuserid
            LEFT JOIN HonorificMaster HM ON HM.id = U.HonorificMasterId
            WHERE CH.PatientId = ? AND CH.EnrollmentId = ?
        ";
        $result['invoice_details'] = $this->db->query($invoice_sql, [$patientId, $enrollmentId])->result_array();

        /*BILL DETAILS*/
        $bill_sql = "
            SELECT DISTINCT
                CH.PatientId,
                PM.Fullname,
                ISNULL(PM.Lastname,'') AS Lastname,
                CH.BillNo AS InvoiceNo,
                CONVERT(VARCHAR, CH.BillDate, 103) AS InvoiceDate,
                PM.Address AS billingAddress,
                BCS.BillChargesServiceDescription AS Description,
                BCS.BillChargesServiceCode AS Code,
                CED.Quantity,
                CED.UnitPrice,
                CED.Discount,
                CED.Amount
            FROM ChargeEntryHeader CH
            INNER JOIN PatientMaster PM ON CH.PatientId = PM.PatientId
            INNER JOIN ChargeEntryDetail CED ON CH.id = CED.ChargeEntryHeaderId
            LEFT JOIN vBillChargesService BCS ON CED.MasterTypeId = BCS.ID  
                AND BCS.MasterTableId = CED.MasterTableId
            WHERE CH.PatientId = ? AND CH.EnrollmentId = ?
        ";
        $result['bill_details'] = $this->db->query($bill_sql, [$patientId, $enrollmentId])->result_array();

        /*PAYMENT DETAILS*/
        $payment_sql = "
            SELECT DISTINCT 
                CASE 
                    WHEN PD.PaymentModeID = 1 THEN 'CASH'
                    WHEN PD.PaymentModeID = 2 THEN 'CARD'
                    WHEN PD.PaymentModeID = 3 THEN 'CHEQUE'
                    WHEN PD.PaymentModeID = 4 THEN 'INSURANCE'
                    ELSE 'CARD'
                END AS PaymentMode,
                CONVERT(varchar, PD.paymentdate, 103) AS PaymentDate,
                BM.BankName,
                PD.ChequeCardNo,
                PD.PaymentAmount
            FROM ChargeEntryHeader CH
            INNER JOIN PaymentDetails PD ON CH.Id = PD.ChargeEntryHeaderID
            LEFT JOIN BankMaster BM ON PD.BankMasterID = BM.BankMasterID
            WHERE CH.PatientId = ? AND CH.EnrollmentId = ?
        ";
        $result['payment_details'] = $this->db->query($payment_sql, [$patientId, $enrollmentId])->result_array();


        return $result;
    }


    public function getClinicalSummary($patientId, $enrollmentID)
    {
        $result = [];

        // Patient Details
        $result['patient_details'] = $this->getDataFromSP(
            'usp_rpt_PatientDetails',
            $patientId,
            $enrollmentID
        );

        // Allergies
        $result['allergies'] = $this->getDataFromSP(
            'usp_rpt_Allergies',
            $patientId,
            $enrollmentID
        );

        // Prescription
        $result['prescription'] = $this->getDataFromSP(
            'usp_rpt_Prescription',
            $patientId,
            $enrollmentID
        );

        // Medical History
        $result['medical_history'] = $this->getDataFromSP(
            'usp_rpt_Medicalhistory',
            $patientId,
            $enrollmentID
        );

        // Progress Notes
        $result['progress_notes'] = $this->getDataFromSP(
            'usp_rpt_ProgressNotes',
            $patientId,
            $enrollmentID
        );

        // Investigations
        $result['investigations'] = $this->getDataFromSP(
            'usp_rpt_Investigations',
            $patientId,
            $enrollmentID
        );

        // Discharge Notes
        $result['discharge_notes'] = $this->getDataFromSP(
            'usp_rpt_DischargeNotes',
            $patientId,
            $enrollmentID
        );

        return $result;
    }
}