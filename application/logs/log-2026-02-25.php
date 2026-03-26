<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-25 10:35:34 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 10:35:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 10:36:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:00:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:21:13 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:21:28 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:27:04 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:28:34 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:30:16 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
FROM "UserTenants" "UT"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "UT"."TenantId"
LEFT JOIN "Users" "U" ON "U"."UserId" = "UT"."UserId"
LEFT JOIN "DoctorImplementation" "DI" ON "U"."UserId" = "DI"."RingDoctorId"
LEFT JOIN "UserRoles" "UR" ON "U"."UserId" = "UR"."UserId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
WHERE "UT"."TenantId" = 'undefined'
AND "UR"."RoleId" = 12
AND "U"."IsActive" = 1
AND "DI"."Scheduled" = 1
AND "DI"."TenantId" = 'undefined'
ERROR - 2026-02-25 11:30:22 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-02-25 17:13:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-02-22'
AND "IsPatientProcessed" = 0
ERROR - 2026-02-25 17:13:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-02-22'
AND "IsPatientProcessed" = 0
ERROR - 2026-02-25 17:13:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:22 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-02-22'
AND "IsPatientProcessed" = 0
ERROR - 2026-02-25 17:13:31 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:32 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:41 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:42 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:51 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:13:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:01 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:11 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:21 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-25 17:14:22 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
