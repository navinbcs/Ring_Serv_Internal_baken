<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-24 12:11:01 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-24 12:11:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-24 12:11:02 --> Severity: error --> Exception: Wrong number of segments E:\Applications\RING_PHP\Ring_dev\application\helpers\jwt_helper.php 35
ERROR - 2026-02-24 07:26:58 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-24 09:52:24 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-02-24 09:52:48 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:04:31 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 16:34:33 --> Severity: Warning --> Undefined property: stdClass::$firstName E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 26
ERROR - 2026-02-24 16:34:33 --> Severity: Warning --> Undefined property: stdClass::$firstName E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 26
ERROR - 2026-02-24 16:34:34 --> Severity: Warning --> Undefined property: stdClass::$firstName E:\Applications\RING_PHP\Ring_dev\application\controllers\V1_1\Ring_cms.php 26
ERROR - 2026-02-24 11:04:43 --> Severity: 8192 --> preg_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated E:\Applications\RING_PHP\system\core\Common.php 726
ERROR - 2026-02-24 11:05:05 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:05:17 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:05:31 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:05:49 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:06:08 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:10:35 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:11:09 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:27:19 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-24 11:27:29 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
