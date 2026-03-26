<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-03-20 05:18:41 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-03-20 10:53:02 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Error converting data type nvarchar to int. - Invalid query:  EXEC usp_AppointmentListForRing undefined,2 
ERROR - 2026-03-20 05:38:50 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-03-20 05:48:39 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-03-20 06:05:45 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-03-20 06:07:50 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-03-20 11:42:32 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:42:32 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:42:32 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:42:32 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:42:32 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:42:32 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:38 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:38 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:38 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:38 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:39 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:39 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:49 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:49 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:50 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:50 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:50 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:43:50 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 06:13:53 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-03-20 11:44:22 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:44:22 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:44:23 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:44:23 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:44:23 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:44:23 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:46:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:46:41 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:46:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:46:41 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:46:41 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:46:41 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:47:29 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:47:29 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:47:30 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:47:30 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:47:30 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:47:30 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:48:03 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:48:03 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:48:04 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:48:04 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:48:04 --> Severity: Warning --> Attempt to read property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
ERROR - 2026-03-20 11:48:04 --> Severity: error --> Exception: Attempt to assign property "MobileNumber" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Webservice.php 645
