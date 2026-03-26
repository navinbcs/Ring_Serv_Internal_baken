<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-10 01:59:06 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-02-10 02:00:39 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-02-10 02:19:47 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-02-10 04:38:21 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-02-10 12:38:36 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1697
ERROR - 2026-02-10 12:38:49 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-10 05:50:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-10 06:00:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:00:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:01:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:02:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:03:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:04:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "UserId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 71
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "MMCNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 72
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "DoctorName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 73
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "TenantId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 74
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "TenantName" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 75
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "RoleId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 76
ERROR - 2026-02-10 06:07:20 --> Severity: Warning --> Attempt to read property "Role" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 77
ERROR - 2026-02-10 06:20:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:20:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:21:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:22:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:17 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:34 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:35 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:40 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:50 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:51 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:52 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:56 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:23:59 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:08 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:09 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:11 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:12 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:13 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:14 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:15 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:16 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:18 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:19 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:20 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:21 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:22 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:23 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:24 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:25 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:26 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:27 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:28 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:29 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:30 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:31 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:32 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:33 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:37 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:38 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:39 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:41 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:42 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:43 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:44 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:45 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:46 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:47 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:48 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:49 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:53 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:54 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:55 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:57 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:24:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:00 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:01 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:02 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:03 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:04 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:05 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:06 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:07 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:25:08 --> Severity: Warning --> Undefined array key "HTTP_AUTHORIZATION" E:\Applications\RING_PHP\Ring_dev\application\controllers\Itemmaster.php 29
ERROR - 2026-02-10 06:25:08 --> Severity: 8192 --> str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\Ring_dev\application\controllers\Itemmaster.php 30
ERROR - 2026-02-10 06:25:08 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 06:25:10 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-10 06:43:00 --> Severity: error --> Exception: floor(): Argument #1 ($num) must be of type int|float, string given E:\Applications\RING_PHP\Ring_dev\application\helpers\amount_helper.php 6
ERROR - 2026-02-10 07:23:26 --> Severity: error --> Exception: floor(): Argument #1 ($num) must be of type int|float, string given E:\Applications\RING_PHP\Ring_dev\application\helpers\amount_helper.php 6
ERROR - 2026-02-10 07:23:29 --> Severity: error --> Exception: floor(): Argument #1 ($num) must be of type int|float, string given E:\Applications\RING_PHP\Ring_dev\application\helpers\amount_helper.php 6
ERROR - 2026-02-10 07:23:30 --> Severity: error --> Exception: floor(): Argument #1 ($num) must be of type int|float, string given E:\Applications\RING_PHP\Ring_dev\application\helpers\amount_helper.php 6
ERROR - 2026-02-10 13:15:23 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 13:15:24 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 13:15:24 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 09:55:34 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:35 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:38 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:39 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:42 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:42 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:51 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 09:55:51 --> Severity: error --> Exception: Signature verification failed E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 50
ERROR - 2026-02-10 15:29:53 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-02-10 15:29:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:29:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-02-07'
AND "IsPatientProcessed" = 0
ERROR - 2026-02-10 15:29:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 17:59:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 09:59:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "RingGroupId" = ''
AND "ImplementationId" = 1
ERROR - 2026-02-10 09:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 15:29:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-02-07'
AND "IsPatientProcessed" = 0
ERROR - 2026-02-10 15:29:54 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 17:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 17:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 15:29:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-02-07'
AND "IsPatientProcessed" = 0
ERROR - 2026-02-10 09:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 17:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 17:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 09:59:54 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 17:59:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 15:29:56 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-02-10 15:29:57 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-02-10 15:29:57 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-02-10 15:29:57 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-02-10 15:29:58 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-02-10 15:31:17 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 10:01:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "RingGroupId" = ''
AND "ImplementationId" = 1
ERROR - 2026-02-10 15:31:17 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 18:01:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 10:01:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 15:31:17 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:31:17 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:31:17 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 18:01:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 10:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 10:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT *
FROM "UserMRN"
WHERE "RINGID" = 'undefined'
AND "RingGroupId" = ''
AND "ImplementationId" = 1
ERROR - 2026-02-10 18:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 10:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 18:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 18:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 10:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 10:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 15:31:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 18:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."PatientMasterId", "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsReferralFormProcessed", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "ET"."RingGroup", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription", "PSM"."SpecialityDescription" "DoctorSpeciality", "RGT"."RingGroupId" as "RingGroupMasterID", "ET"."ICD", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
FROM "EreportsTransit" "ET"
LEFT JOIN "Users" "U" ON "U"."UserId" = "ET"."InsertUserId"
LEFT JOIN "Tenants" "T" ON "T"."TenantId" = "ET"."TenantId"
LEFT JOIN "PractitionerMaster" "PM" ON "PM"."ID" = "U"."LinkUserId"
LEFT JOIN "PractitionerSpecialityMaster" "PSM" ON "PSM"."ID" = "PM"."SpecialityId"
LEFT JOIN "HonorificMaster" "HM" ON "HM"."id" = "U"."HonorificMasterId"
LEFT JOIN "ICDMaster" "IC" ON "IC"."Id" = "ET"."IcdMasterId"
LEFT JOIN "RingGroupTenants" "RGT" ON "RGT"."TenantId" = "ET"."TenantId"
WHERE "ET"."PatientMasterId" = 'undefined'
AND "ET"."InsertDate" > '2026-02-07'
AND "ET"."IsPatientProcessed" = 0
ORDER BY "ET"."ReportTransitId" DESC
 OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY
ERROR - 2026-02-10 10:01:18 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "ET"."ReportTransitId", "ET"."InsertDate", "ET"."Description", "ET"."EreferralForm", "ET"."IsProcessed", "ET"."IsDoctorProcessed", "ET"."IsPatientProcessed", "ET"."ReferredToUserId", "ET"."ReferralICD", "ET"."AddReferral", "ET"."InsertUserId" "DoctorId", "U"."DisplayName" "doctorName", "U"."LastName", "U"."PhoneNumber" "UserPhoneNumber", "PSM"."SpecialityDescription" "DoctorSpeciality", "T"."TenantId", "T"."TenantName", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "IC"."ICDSubCode", "IC"."ICDSubCodeDescription" "DiagnosisName", "PSM"."SpecialityDescription" "DoctorSpeciality", "ET"."EReferralStatus", "ET"."VisitNotes", "ET"."Treatment", "ET"."Diagnosis", "ET"."Diagnosis", "ET"."RingGroup", "RGT"."RingGroupId" as "RingGroupMasterID", "HM"."Description" "sirname_title", "ET"."RingGroupId" "refTenant"
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
ERROR - 2026-02-10 15:31:33 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:31:34 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:31:34 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:33:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:33:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:33:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:46:11 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:46:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 15:46:13 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 16:03:27 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 16:03:28 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 16:03:30 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 16:14:52 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 16:14:53 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-10 16:14:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
