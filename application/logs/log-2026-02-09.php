<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-09 10:43:11 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 10:43:11 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 10:43:12 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 11:32:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 11:32:57 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 11:32:58 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 12:27:27 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 12:27:27 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 12:27:27 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 12:46:45 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 12:46:45 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 12:46:46 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-09 07:31:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-09 07:31:25 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-02-09 08:04:47 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-02-09 16:05:47 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1697
ERROR - 2026-02-09 16:05:49 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:07:12 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:09:26 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:09:37 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:11:58 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:12:05 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:12:27 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:12:40 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 16:13:31 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 11:45:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-02-09 19:46:02 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1697
ERROR - 2026-02-09 19:50:02 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 19:50:20 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 19:51:56 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 19:52:19 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 12:06:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-02-09 20:07:08 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1697
ERROR - 2026-02-09 20:11:16 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1697
ERROR - 2026-02-09 20:11:24 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1553
ERROR - 2026-02-09 20:12:01 --> Severity: Warning --> Undefined variable $response E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 1697
