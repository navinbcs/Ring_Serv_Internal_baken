<?php

$connectionInfo=[];
$connectionInfo = array(
    "Database" => 'RING_1_0_INTERNAL',
    "UID"      => 'ringdbuser',
    "PWD"      => 'G7m!xY2#qP9$vL5@dT'
);
$conn = sqlsrv_connect("192.168.81.205,14134", $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
echo "SQLSRV OK!";