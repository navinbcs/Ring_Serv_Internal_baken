<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-03-02 05:30:48 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:30:49 --> 404 Page Not Found: Indexphp/api
ERROR - 2026-03-02 05:30:51 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:30:51 --> 404 Page Not Found: Indexphp/api
ERROR - 2026-03-02 05:30:54 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:30:55 --> 404 Page Not Found: Indexphp/api
ERROR - 2026-03-02 05:30:57 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:30:57 --> 404 Page Not Found: Indexphp/api
ERROR - 2026-03-02 05:31:02 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:31:28 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:31:47 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:33:32 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:34:19 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:38:22 --> 404 Page Not Found: Indexphp/SSOAuth
ERROR - 2026-03-02 05:57:19 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 05:57:41 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 05:57:58 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 05:58:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 06:11:51 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-03-02 09:12:09 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-02 09:17:36 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-02 09:31:00 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 09:45:15 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-02 10:04:24 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 10:05:34 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 10:31:07 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-02 11:05:28 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-03-02 11:05:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-03-02 11:06:12 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
