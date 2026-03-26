<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-01-14 02:43:11 --> 404 Page Not Found: PackageMasterApi/printPackageBillMockup
ERROR - 2026-01-14 02:43:58 --> Severity: Warning --> Undefined array key "HTTP_AUTHORIZATION" E:\Applications\RING_PHP\Ring_dev\application\controllers\PackageMasterApi.php 36
ERROR - 2026-01-14 02:43:58 --> Severity: 8192 --> str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\Ring_dev\application\controllers\PackageMasterApi.php 37
ERROR - 2026-01-14 02:43:58 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 09:10:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 09:10:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 09:10:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 03:42:06 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:42:12 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:42:16 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:42:21 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:42:23 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:42:24 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:44:27 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:44:33 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:52:06 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:52:12 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 03:52:16 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 13:39:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 05:39:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "RingGroupId" = ''
AND "ImplementationId" = 1
ERROR - 2026-01-14 13:39:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "RingGroupId" = ''
AND "ImplementationId" = 1
ERROR - 2026-01-14 05:39:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:39:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:39:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:39:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 11:09:55 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 11:09:55 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 05:39:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "RingGroupId" = ''
AND "ImplementationId" = 1
ERROR - 2026-01-14 05:39:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:39:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:39:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 11:09:56 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:39:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 11:09:56 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:39:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:39:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:39:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 05:39:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 11:09:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 11:09:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 05:39:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:39:57 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 12:11:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 12:11:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 12:11:43 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 06:54:22 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:22 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:26 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:32 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:35 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:37 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:38 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:40 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:54:40 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:55:59 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:56:02 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 06:56:04 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 07:05:59 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 07:06:02 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 07:06:04 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 07:07:33 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 07:07:36 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 07:07:38 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 15:51:44 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:44 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 07:51:44 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 15:51:44 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 15:51:45 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:45 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 07:51:45 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 07:51:45 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 15:51:46 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:46 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 07:51:46 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:51:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 15:51:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 15:51:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:51:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 07:51:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:51:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 15:51:49 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 15:51:49 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:49 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:51:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:51:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:52:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 13:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 15:52:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:52:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:22:00 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:22:01 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:52:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:52:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:52:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:52:01 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:53:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 13:23:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:53:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:53:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:23:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:53:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:53:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:23:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:53:09 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:53:09 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:23:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:53:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 13:23:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 15:53:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:53:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:23:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 15:53:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:53:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:53:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:53:23 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:23:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:53:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "ImplementationId" = 1
ERROR - 2026-01-14 13:23:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 07:53:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 15:53:32 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 13:23:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 15:53:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:53:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 13:23:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 13:23:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 15:53:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-01-11'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-01-14 07:53:33 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-01-14 08:49:30 --> Severity: Warning --> file_get_contents(https://internal.ring.healthcare/upload/EReportsAttachments/00000/271abe17693d4d19a5ac4bf63f03cf0b.jpg): Failed to open stream: No connection could be made because the target machine actively refused it E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 6940
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:06:49 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:06:52 --> Severity: Warning --> Undefined array key "s" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 717
ERROR - 2026-01-14 17:06:52 --> Severity: Warning --> Undefined array key "direction" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:06:52 --> Severity: Warning --> Undefined array key "a" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:06:52 --> Severity: Warning --> Undefined array key "cellLineHeight" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:06:52 --> Severity: Warning --> Undefined array key "cellLineStackingStrategy" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:06:52 --> Severity: Warning --> Undefined array key "cellLineStackingShift" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Undefined array key -1 E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:09:18 --> Severity: Warning --> Trying to access array offset on value of type null E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:09:20 --> Severity: Warning --> Undefined array key "s" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 717
ERROR - 2026-01-14 17:09:20 --> Severity: Warning --> Undefined array key "direction" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 54
ERROR - 2026-01-14 17:09:20 --> Severity: Warning --> Undefined array key "a" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 55
ERROR - 2026-01-14 17:09:20 --> Severity: Warning --> Undefined array key "cellLineHeight" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 56
ERROR - 2026-01-14 17:09:20 --> Severity: Warning --> Undefined array key "cellLineStackingStrategy" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 57
ERROR - 2026-01-14 17:09:20 --> Severity: Warning --> Undefined array key "cellLineStackingShift" E:\Applications\RING_PHP\Ring_dev\application\libraries\mpdf\src\Tag\Table.php 58
ERROR - 2026-01-14 17:12:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 17:12:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 17:12:58 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 17:15:15 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 17:15:16 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 17:15:20 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-01-14 17:23:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "PatientBackupFiles"
WHERE "EreportsTransitDetailId" = 'ER_0'
AND "BackupReportID" = '43576'
ERROR - 2026-01-14 17:23:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "PatientBackupFiles"
WHERE "EreportsTransitDetailId" = 'ER_3'
AND "BackupReportID" = '43576'
ERROR - 2026-01-14 12:00:11 --> 404 Page Not Found: PackageMasterApi/printPackageBillMockup
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 274
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 278
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 284
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 285
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 286
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 287
ERROR - 2026-01-14 12:58:59 --> Severity: Warning --> Undefined variable $progress E:\Applications\RING_PHP\Ring_dev\application\views\ring_precription.php 292
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "UserId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 71
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "MMCNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 72
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "DoctorName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 73
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "TenantId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 74
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "TenantName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 75
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "RoleId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 76
ERROR - 2026-01-14 13:28:49 --> Severity: Warning --> Attempt to read property "Role" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 77
ERROR - 2026-01-14 13:28:49 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-01-14 13:28:49 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "UserId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 71
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "MMCNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 72
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "DoctorName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 73
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "TenantId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 74
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "TenantName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 75
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "RoleId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 76
ERROR - 2026-01-14 13:32:14 --> Severity: Warning --> Attempt to read property "Role" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 77
ERROR - 2026-01-14 13:32:15 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-01-14 13:32:17 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "UserId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 71
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "MMCNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 72
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "DoctorName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 73
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "TenantId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 74
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "TenantName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 75
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "RoleId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 76
ERROR - 2026-01-14 13:32:33 --> Severity: Warning --> Attempt to read property "Role" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 77
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:58:59 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 13:59:10 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:38 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-01-14 14:45:39 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-01-14 14:45:39 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
