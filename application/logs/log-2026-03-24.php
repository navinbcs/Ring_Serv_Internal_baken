<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-03-24 03:50:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-24 05:44:03 --> Severity: Warning --> Undefined variable $data E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 622
ERROR - 2026-03-24 06:15:31 --> Severity: error --> Exception: syntax error, unexpected single-quoted string "doctor", expecting "]" E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 204
ERROR - 2026-03-24 06:24:12 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 71
ERROR - 2026-03-24 06:25:52 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 71
ERROR - 2026-03-24 06:25:52 --> Severity: Warning --> Undefined variable $clinicPhone E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 140
ERROR - 2026-03-24 06:25:52 --> Severity: Warning --> Undefined variable $clinicEmail E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 141
ERROR - 2026-03-24 06:26:28 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 71
ERROR - 2026-03-24 06:56:59 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 71
ERROR - 2026-03-24 07:13:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Invalid column name 'CountryMasterId'. - Invalid query: SELECT "E"."Id" "enrollmentId", "E"."EncounterNo", "E"."EncounterNo", "E"."EncounterNo", "E"."EnrollmentDate", "E"."AppointmentId", "AP"."AppointmentNo", "AP"."AppointmentDate", "AP"."FromTime", "AP"."ToTime", "P"."PatientId", "P"."FullName", "P"."LastName", "P"."DateOfBirth", "G"."Description" "GenderDescription", "T"."TenantId", "T"."TenantName", "T"."Address" "TenantAddress", "T"."CountryMasterId", "CM"."CountryDescription", "CM"."CurrencyName", "CM"."CurrencyCode", "U"."DisplayName" "DoctorFName", "U"."LastName" "DoctorLName", "PM"."PractitionerCode", "PM"."MMCNumber", "PMS"."SpecialityDescription" "Department"
FROM "Enrollment" "E"
LEFT JOIN "Appointment" "AP" ON "AP"."Id" = "E"."AppointmentId"
LEFT JOIN "PatientMaster" "P" ON "P"."PatientId" = "E"."PatientId"
LEFT JOIN "GenderMaster" "G" ON "G"."Id" = "P"."GenderId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "E"."TenantId"
LEFT JOIN "CountryMaster" "CM" ON "CM"."ID" = "T"."CountryMasterId"
LEFT JOIN "Users" "U" ON "U"."LinkUserId" = "E"."PrimaryPractitionerId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."Id" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PMS" ON "PMS"."ID" = "AP"."SpecialityId"
WHERE "E"."Id" = '1173'
ERROR - 2026-03-24 07:14:39 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Invalid column name 'CountryMasterId'. - Invalid query: SELECT "E"."Id" "enrollmentId", "E"."EncounterNo", "E"."EncounterNo", "E"."EncounterNo", "E"."EnrollmentDate", "E"."AppointmentId", "AP"."AppointmentNo", "AP"."AppointmentDate", "AP"."FromTime", "AP"."ToTime", "P"."PatientId", "P"."FullName", "P"."LastName", "P"."DateOfBirth", "G"."Description" "GenderDescription", "T"."TenantId", "T"."TenantName", "T"."Address" "TenantAddress", "T"."CountryMasterId", "CM"."CountryDescription", "CM"."CurrencyName", "CM"."CurrencyCode", "U"."DisplayName" "DoctorFName", "U"."LastName" "DoctorLName", "PM"."PractitionerCode", "PM"."MMCNumber", "PMS"."SpecialityDescription" "Department"
FROM "Enrollment" "E"
LEFT JOIN "Appointment" "AP" ON "AP"."Id" = "E"."AppointmentId"
LEFT JOIN "PatientMaster" "P" ON "P"."PatientId" = "E"."PatientId"
LEFT JOIN "GenderMaster" "G" ON "G"."Id" = "P"."GenderId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "E"."TenantId"
LEFT JOIN "CountryMaster" "CM" ON "CM"."ID" = "T"."CountryID"
LEFT JOIN "Users" "U" ON "U"."LinkUserId" = "E"."PrimaryPractitionerId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."Id" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PMS" ON "PMS"."ID" = "AP"."SpecialityId"
WHERE "E"."Id" = '1173'
ERROR - 2026-03-24 07:15:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Invalid column name 'CurrencyCode'. - Invalid query: SELECT "E"."Id" "enrollmentId", "E"."EncounterNo", "E"."EncounterNo", "E"."EncounterNo", "E"."EnrollmentDate", "E"."AppointmentId", "AP"."AppointmentNo", "AP"."AppointmentDate", "AP"."FromTime", "AP"."ToTime", "P"."PatientId", "P"."FullName", "P"."LastName", "P"."DateOfBirth", "G"."Description" "GenderDescription", "T"."TenantId", "T"."TenantName", "T"."Address" "TenantAddress", "T"."CountryId", "CM"."CountryDescription", "CM"."CurrencyName", "CM"."CurrencyCode", "U"."DisplayName" "DoctorFName", "U"."LastName" "DoctorLName", "PM"."PractitionerCode", "PM"."MMCNumber", "PMS"."SpecialityDescription" "Department"
FROM "Enrollment" "E"
LEFT JOIN "Appointment" "AP" ON "AP"."Id" = "E"."AppointmentId"
LEFT JOIN "PatientMaster" "P" ON "P"."PatientId" = "E"."PatientId"
LEFT JOIN "GenderMaster" "G" ON "G"."Id" = "P"."GenderId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "E"."TenantId"
LEFT JOIN "CountryMaster" "CM" ON "CM"."ID" = "T"."CountryID"
LEFT JOIN "Users" "U" ON "U"."LinkUserId" = "E"."PrimaryPractitionerId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."Id" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PMS" ON "PMS"."ID" = "AP"."SpecialityId"
WHERE "E"."Id" = '1173'
ERROR - 2026-03-24 07:16:03 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Invalid column name 'CurrencyCode'. - Invalid query: SELECT "E"."Id" "enrollmentId", "E"."EncounterNo", "E"."EncounterNo", "E"."EncounterNo", "E"."EnrollmentDate", "E"."AppointmentId", "AP"."AppointmentNo", "AP"."AppointmentDate", "AP"."FromTime", "AP"."ToTime", "P"."PatientId", "P"."FullName", "P"."LastName", "P"."DateOfBirth", "G"."Description" "GenderDescription", "T"."TenantId", "T"."TenantName", "T"."Address" "TenantAddress", "T"."CountryId", "CM"."CountryDescription", "CM"."CurrencyName", "CM"."CurrencyCode", "U"."DisplayName" "DoctorFName", "U"."LastName" "DoctorLName", "PM"."PractitionerCode", "PM"."MMCNumber", "PMS"."SpecialityDescription" "Department"
FROM "Enrollment" "E"
LEFT JOIN "Appointment" "AP" ON "AP"."Id" = "E"."AppointmentId"
LEFT JOIN "PatientMaster" "P" ON "P"."PatientId" = "E"."PatientId"
LEFT JOIN "GenderMaster" "G" ON "G"."Id" = "P"."GenderId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "E"."TenantId"
LEFT JOIN "CountryMaster" "CM" ON "CM"."ID" = "T"."CountryID"
LEFT JOIN "Users" "U" ON "U"."LinkUserId" = "E"."PrimaryPractitionerId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."Id" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PMS" ON "PMS"."ID" = "AP"."SpecialityId"
WHERE "E"."Id" = '1173'
ERROR - 2026-03-24 07:16:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Invalid column name 'CurrencyCode'. - Invalid query: SELECT "E"."Id" "enrollmentId", "E"."EncounterNo", "E"."EncounterNo", "E"."EncounterNo", "E"."EnrollmentDate", "E"."AppointmentId", "AP"."AppointmentNo", "AP"."AppointmentDate", "AP"."FromTime", "AP"."ToTime", "P"."PatientId", "P"."FullName", "P"."LastName", "P"."DateOfBirth", "G"."Description" "GenderDescription", "T"."TenantId", "T"."TenantName", "T"."Address" "TenantAddress", "T"."CountryId", "CM"."CountryDescription", "CM"."CurrencyName", "CM"."CurrencyCode", "U"."DisplayName" "DoctorFName", "U"."LastName" "DoctorLName", "PM"."PractitionerCode", "PM"."MMCNumber", "PMS"."SpecialityDescription" "Department"
FROM "Enrollment" "E"
LEFT JOIN "Appointment" "AP" ON "AP"."Id" = "E"."AppointmentId"
LEFT JOIN "PatientMaster" "P" ON "P"."PatientId" = "E"."PatientId"
LEFT JOIN "GenderMaster" "G" ON "G"."Id" = "P"."GenderId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "E"."TenantId"
LEFT JOIN "CountryMaster" "CM" ON "CM"."ID" = "T"."CountryID"
LEFT JOIN "Users" "U" ON "U"."LinkUserId" = "E"."PrimaryPractitionerId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."Id" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PMS" ON "PMS"."ID" = "AP"."SpecialityId"
WHERE "E"."Id" = '1173'
ERROR - 2026-03-24 07:16:58 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Incorrect syntax near '.'. - Invalid query: SELECT "E"."Id" "enrollmentId", "E"."EncounterNo", "E"."EncounterNo", "E"."EncounterNo", "E"."EnrollmentDate", "E"."AppointmentId", "AP"."AppointmentNo", "AP"."AppointmentDate", "AP"."FromTime", "AP"."ToTime", "P"."PatientId", "P"."FullName", "P"."LastName", "P"."DateOfBirth", "G"."Description" "GenderDescription", "T"."TenantId", "T"."TenantName", "T"."Address" "TenantAddress", "T"."CountryId", "CM"."CountryDescription", "CM"."CurrencyName", "--" "CM"."CurrencyCode", "U"."DisplayName" "DoctorFName", "U"."LastName" "DoctorLName", "PM"."PractitionerCode", "PM"."MMCNumber", "PMS"."SpecialityDescription" "Department"
FROM "Enrollment" "E"
LEFT JOIN "Appointment" "AP" ON "AP"."Id" = "E"."AppointmentId"
LEFT JOIN "PatientMaster" "P" ON "P"."PatientId" = "E"."PatientId"
LEFT JOIN "GenderMaster" "G" ON "G"."Id" = "P"."GenderId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "E"."TenantId"
LEFT JOIN "CountryMaster" "CM" ON "CM"."ID" = "T"."CountryID"
LEFT JOIN "Users" "U" ON "U"."LinkUserId" = "E"."PrimaryPractitionerId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."Id" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PMS" ON "PMS"."ID" = "AP"."SpecialityId"
WHERE "E"."Id" = '1173'
ERROR - 2026-03-24 07:20:05 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 72
ERROR - 2026-03-24 07:24:04 --> Severity: error --> Exception: syntax error, unexpected variable "$currency", expecting "function" or "const" E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 6
ERROR - 2026-03-24 07:24:57 --> Severity: error --> Exception: syntax error, unexpected token "global", expecting "function" or "const" E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 6
ERROR - 2026-03-24 07:29:17 --> Severity: error --> Exception: syntax error, unexpected variable "$currency", expecting "function" or "const" E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 6
ERROR - 2026-03-24 07:29:59 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:30:52 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:31:41 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:32:05 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:33:19 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:34:04 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:35:30 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:35:30 --> Severity: error --> Exception: Too few arguments to function amountInWordsMYR(), 1 passed in E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php on line 263 and exactly 2 expected E:\Applications\RING_PHP\Ring_dev\application\helpers\amount_helper.php 4
ERROR - 2026-03-24 07:36:04 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:37:13 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:38:18 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:38:18 --> Severity: error --> Exception: syntax error, unexpected token ",", expecting ")" E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 263
ERROR - 2026-03-24 07:38:32 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:47:14 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:52:07 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 74
ERROR - 2026-03-24 07:52:07 --> Severity: error --> Exception: Call to undefined function e() E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 144
ERROR - 2026-03-24 07:53:51 --> Severity: error --> Exception: Call to undefined function e() E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 144
ERROR - 2026-03-24 08:00:17 --> Severity: error --> Exception: Call to undefined function e() E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 144
ERROR - 2026-03-24 08:06:04 --> Severity: error --> Exception: Call to undefined function e() E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 144
ERROR - 2026-03-24 15:21:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:04 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:10 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:10 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:10 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:20 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:21 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:21 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:30 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:30 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:30 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:40 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:40 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:40 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:50 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:50 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:21:50 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:10 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:10 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:10 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:20 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:20 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 15:22:20 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 10:34:16 --> Severity: Warning --> Undefined array key "prn" E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 194
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Amount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 256
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Discount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 256
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Code E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 258
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Description E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 259
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Quantity E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 262
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$UnitPrice E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 263
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Discount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 264
ERROR - 2026-03-24 10:41:17 --> Severity: Warning --> Undefined property: stdClass::$Amount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 10:42:31 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:47:38 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:48:26 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:49:08 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:50:16 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:50:16 --> Severity: Warning --> Undefined variable $Prn E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 194
ERROR - 2026-03-24 10:50:20 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:50:20 --> Severity: Warning --> Undefined variable $Prn E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 194
ERROR - 2026-03-24 10:51:14 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:52:13 --> Severity: Warning --> Undefined variable $decryptedPhoneNo E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 84
ERROR - 2026-03-24 10:52:51 --> Severity: error --> Exception: syntax error, unexpected token "=>" E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 70
ERROR - 2026-03-24 10:53:04 --> Severity: Warning --> Undefined variable $patientDetails E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 70
ERROR - 2026-03-24 10:53:28 --> Severity: Warning --> Undefined variable $patientDetails E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 70
ERROR - 2026-03-24 10:53:44 --> Severity: Warning --> Undefined variable $patientDetails E:\Applications\RING_PHP\Ring_dev\application\controllers\Invoice.php 49
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Amount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 256
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Discount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 256
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Code E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 258
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Description E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 259
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Quantity E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 262
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$UnitPrice E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 263
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Discount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 264
ERROR - 2026-03-24 10:56:30 --> Severity: Warning --> Undefined property: stdClass::$Amount E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:07:15 --> Severity: error --> Exception: syntax error, unexpected token "echo" E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 266
ERROR - 2026-03-24 11:13:31 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:13:31 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:13:31 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:13:31 --> Severity: Warning --> Attempt to read property "BillAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:13:31 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:18:08 --> Severity: Compile Error --> Cannot use isset() on the result of an expression (you can use "null !== expression" instead) E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:19:02 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:19:02 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:19:02 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:19:02 --> Severity: Warning --> Attempt to read property "BillAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:19:02 --> Severity: 8192 --> number_format(): Passing null to parameter #1 ($num) of type float is deprecated E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:20:02 --> Severity: Compile Error --> Cannot use isset() on the result of an expression (you can use "null !== expression" instead) E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:20:05 --> Severity: Compile Error --> Cannot use isset() on the result of an expression (you can use "null !== expression" instead) E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:20:54 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:20:54 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:20:54 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:20:54 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:22:40 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:22:40 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:22:40 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:22:40 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:23:30 --> Severity: error --> Exception: syntax error, unexpected token "echo" E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 265
ERROR - 2026-03-24 11:23:43 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:23:43 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:23:43 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:23:43 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:24:05 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:24:05 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:24:05 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:24:05 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:25:06 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:25:06 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:25:06 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:25:06 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:27:41 --> Severity: error --> Exception: Cannot use object of type stdClass as array E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 267
ERROR - 2026-03-24 11:28:16 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:28:16 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:28:16 --> Severity: Warning --> Undefined array key 1 E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 11:28:16 --> Severity: Warning --> Attempt to read property "TaxAmount" on null E:\Applications\RING_PHP\Ring_dev\application\views\ring_invoice.php 257
ERROR - 2026-03-24 18:32:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:32:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:33:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:34:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:35:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:36:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:03 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:46 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:47 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:37:47 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:07 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:07 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:07 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:37 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:37 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:37 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:51 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:38:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:39:06 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:39:06 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:39:07 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:39 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:39 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:40 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:41 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:51 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:40:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:04 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:05 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:06 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:34 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:34 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:35 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:48 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:49 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-24 18:41:50 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
