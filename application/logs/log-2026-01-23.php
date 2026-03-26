<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-23 11:48:26 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 11:48:26 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 11:48:26 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 11:48:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 11:48:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 11:48:30 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 11:48:38 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:38 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:44 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:44 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:46 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:46 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:46 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:47 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:47 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:47 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:48:59 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:49:01 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 11:49:04 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 06:26:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "U"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."Diagnosis"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."AddReferral" = 1
AND "ET"."IsDoctorProcessed" = 0
AND "ET"."EReferralStatus" = 'Completed'
ORDER BY "ET"."ReportTransitId" DESC
ERROR - 2026-01-23 14:26:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-20'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-23 14:26:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-20'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-23 06:26:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "U"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."Diagnosis"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."AddReferral" = 1
AND "ET"."IsDoctorProcessed" = 0
AND "ET"."EReferralStatus" = 'Completed'
ORDER BY "ET"."ReportTransitId" DESC
ERROR - 2026-01-23 06:26:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "U"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."Diagnosis"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."AddReferral" = 1
AND "ET"."IsDoctorProcessed" = 0
AND "ET"."EReferralStatus" = 'Completed'
ORDER BY "ET"."ReportTransitId" DESC
ERROR - 2026-01-23 14:26:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-20'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-23 14:30:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-20'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-23 06:30:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "U"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."Diagnosis"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."AddReferral" = 1
AND "ET"."IsDoctorProcessed" = 0
AND "ET"."EReferralStatus" = 'Completed'
ORDER BY "ET"."ReportTransitId" DESC
ERROR - 2026-01-23 14:30:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-20'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-23 06:30:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "U"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."Diagnosis"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."AddReferral" = 1
AND "ET"."IsDoctorProcessed" = 0
AND "ET"."EReferralStatus" = 'Completed'
ORDER BY "ET"."ReportTransitId" DESC
ERROR - 2026-01-23 06:30:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "U"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."Diagnosis"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."AddReferral" = 1
AND "ET"."IsDoctorProcessed" = 0
AND "ET"."EReferralStatus" = 'Completed'
ORDER BY "ET"."ReportTransitId" DESC
ERROR - 2026-01-23 14:30:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-20'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-23 12:01:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:01:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:01:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:01:16 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:01:16 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:01:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:22:36 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:22:36 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:22:36 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 12:28:14 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:28:14 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:28:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:28:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:28:15 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:28:15 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:28:15 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:28:15 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:28:16 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:28:16 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:28:16 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:28:16 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:31:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:31:37 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:31:37 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:31:38 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:31:38 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:31:38 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:31:38 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:31:38 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:31:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:31:40 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:31:40 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:31:41 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:34:03 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Incorrect syntax near ','. - Invalid query:  EXEC usp_AppointmentListForRing ,3 
ERROR - 2026-01-23 12:46:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:46:42 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:46:42 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:46:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:46:42 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:46:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:46:42 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:46:42 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:46:43 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:46:43 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:46:43 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:46:43 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:50:01 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:50:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:50:01 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:50:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:50:02 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:50:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:50:02 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:50:02 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:50:02 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:50:03 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:50:03 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:50:03 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:54:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:54:35 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:54:35 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:54:36 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:54:36 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:54:36 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 12:54:36 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:54:36 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:54:36 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:54:37 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 12:54:37 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 12:54:37 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:00:35 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:00:35 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:00:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:00:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:00:35 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:00:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:00:35 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:00:35 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:00:36 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:00:36 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:00:36 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:00:36 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:07:37 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:07:37 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:07:37 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:07:38 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:07:38 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:07:38 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:07:38 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:07:38 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:07:38 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:07:39 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:07:39 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:07:39 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:11:57 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:11:57 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:11:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:11:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:11:57 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:11:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:11:58 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:11:58 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:11:58 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:11:58 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:11:58 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:11:59 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:20:41 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:20:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:20:41 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:20:41 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:20:41 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:20:41 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:20:41 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:20:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:20:42 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:20:42 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:20:42 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:20:42 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:29:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:29:01 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:29:01 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:29:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:29:02 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:29:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:29:02 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:29:02 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:29:02 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:29:02 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:29:02 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:29:03 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:35:11 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:35:11 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:35:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:35:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:35:12 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:35:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:35:12 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:35:12 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:35:12 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:35:12 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:35:12 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:35:13 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:53:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:53:03 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:53:03 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:53:03 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:53:03 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 13:53:03 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:53:03 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:53:03 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:53:04 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:53:04 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 13:53:04 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 13:53:04 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:07:27 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:07:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:07:27 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:07:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:07:27 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:07:27 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:07:28 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:07:28 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:07:28 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:07:28 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:07:28 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:07:29 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:14:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:14:42 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:14:42 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:14:43 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:14:43 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:14:43 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:14:43 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:14:43 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:14:43 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:14:44 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:14:44 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:14:44 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:22:16 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:22:16 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:22:16 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:22:16 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:22:16 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:22:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:22:17 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:22:17 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:22:17 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:22:17 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:22:17 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:22:18 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:24:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:24:35 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:24:35 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:24:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:24:35 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:24:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:24:35 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:24:35 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:24:36 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:24:36 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:24:36 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:24:37 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:29:58 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:29:58 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:29:58 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:29:58 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:29:58 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:29:58 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:29:58 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:29:58 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:29:59 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:29:59 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:29:59 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:30:00 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:41:42 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:41:42 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:41:42 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:41:43 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:41:43 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:41:43 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:41:43 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:41:43 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:41:43 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:41:44 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:41:44 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:41:44 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:46:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:46:14 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:46:14 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:46:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:46:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:46:14 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:46:14 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:46:14 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:46:15 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:46:15 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:46:15 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:46:15 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:56:23 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:56:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:56:23 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:56:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:56:24 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 14:56:24 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:56:24 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 14:56:24 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 14:56:24 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:04:16 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:04:16 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:04:16 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:04:17 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:04:17 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:04:17 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:08:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:08:13 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:08:13 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:08:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:08:14 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:08:14 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:08:14 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:08:14 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:08:14 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:08:15 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:08:15 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:08:15 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:15:47 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:15:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:15:47 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:15:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:15:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:15:48 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:15:48 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:15:48 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:15:49 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:15:49 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:15:49 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:15:49 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:27:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:27:53 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:27:53 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:27:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:27:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:27:53 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:27:53 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:27:53 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:27:54 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:27:54 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:27:54 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:27:55 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:41:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:41:40 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:41:40 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:41:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:41:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:41:40 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:41:41 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:41:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:41:41 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:41:41 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:41:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:41:42 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:47:50 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:47:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:47:50 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:47:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:47:50 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:47:51 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 15:47:51 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:47:51 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:47:51 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:47:51 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 15:47:51 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 15:47:52 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:04:46 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:04:46 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:04:46 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:04:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:04:47 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:04:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:04:47 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:04:47 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:04:47 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:04:48 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:04:48 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:04:48 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:08:05 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:08:05 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:08:05 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:08:05 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:08:05 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:08:05 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:08:06 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:08:06 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:08:06 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:08:06 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:08:06 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:08:07 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:37:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 16:37:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 16:37:58 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-23 16:53:10 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:53:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:53:10 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:53:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:53:11 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:53:11 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 16:53:11 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:53:11 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:53:11 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:53:12 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 16:53:12 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 16:53:12 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:14:53 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 17:14:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 17:14:53 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:14:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 17:14:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-01-20'
AND "IsPatientProcessed" = 0
ERROR - 2026-01-23 17:14:56 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:23:46 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 17:23:46 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:23:47 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:23:47 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 17:23:47 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:23:47 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:23:48 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-01-23 17:23:48 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-01-23 17:23:48 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
