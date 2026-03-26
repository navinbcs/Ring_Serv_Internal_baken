<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-03-05 02:09:33 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-05 02:09:55 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-05 02:44:55 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-05 02:45:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-05 08:17:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-03-02'
AND "IsPatientProcessed" = 0
ERROR - 2026-03-05 08:17:50 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-03-05 08:17:51 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-03-05 08:17:51 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-03-05 08:17:51 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-03-05 08:17:51 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-03-02'
AND "IsPatientProcessed" = 0
ERROR - 2026-03-05 08:17:51 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-03-05 08:17:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-03-02'
AND "IsPatientProcessed" = 0
ERROR - 2026-03-05 08:17:52 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-03-05 08:17:52 --> Severity: Warning --> Undefined property: stdClass::$PatientId E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 490
ERROR - 2026-03-05 08:17:52 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-03-05 08:17:53 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 494
ERROR - 2026-03-05 02:57:59 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-05 02:58:06 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-05 03:55:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-05 03:55:52 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT "PatientId", "EnrollmentDate"
FROM "Enrollment"
WHERE "id" = 'null'
ERROR - 2026-03-05 05:07:10 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-03-05 05:07:19 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-03-05 05:07:56 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-03-05 07:29:45 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-05 07:30:38 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-05 07:31:38 --> Severity: error --> Exception: Attempt to assign property "tenants" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\SSOAuth.php 206
ERROR - 2026-03-05 07:52:48 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:48 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:48 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:48 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:48 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:48 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:52:49 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "userId" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12063
ERROR - 2026-03-05 07:53:11 --> Severity: Warning --> Attempt to read property "date" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 12064
ERROR - 2026-03-05 18:08:39 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-03-02'
AND "IsPatientProcessed" = 0
ERROR - 2026-03-05 18:08:39 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:39 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:39 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-03-02'
AND "IsPatientProcessed" = 0
ERROR - 2026-03-05 18:08:40 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:40 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: SELECT count('ReportTransitId') as count
FROM "EreportsTransit"
WHERE "PatientMasterId" = 'undefined'
AND "InsertDate" > '2026-03-02'
AND "IsPatientProcessed" = 0
ERROR - 2026-03-05 18:08:48 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:49 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:49 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:58 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:59 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:08:59 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:09:09 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:09:09 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:09:09 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:09:18 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:09:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-03-05 18:09:19 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
