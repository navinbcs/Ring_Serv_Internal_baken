<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2026-02-27 03:05:28 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-27 03:05:46 --> Query error: [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'undefined' to data type int. - Invalid query: SELECT "U"."UserId" "DoctorId", CONCAT(U.DisplayName, ' ', U.LastName) AS DoctorName, "T"."PhoneNumber" AS "UserPhoneNumber", "U"."SecondarySpecialityId", "T"."TenantName" "TenantName", "T"."PhoneCode", "T"."FaxCode", "T"."PhoneNumber" "TenantPhoneNuber", "T"."FaxNumber" "TenantFaxNumber", "T"."Address" "TenantAddress", "PSM"."SpecialityDescription" "DoctorSpeciality", "HM"."Description" as "Prefix"
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
ERROR - 2026-02-27 03:13:36 --> Severity: Warning --> Attempt to read property "Platform" on null E:\Applications\RING_PHP\Ring_dev\application\controllers\Webservice.php 1059
ERROR - 2026-02-27 05:20:28 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:20:36 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:20:41 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:30 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:40 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:38:50 --> 404 Page Not Found: Indexphp/groupadmin
ERROR - 2026-02-27 05:39:32 --> 404 Page Not Found: Indexphp/groupadmin
