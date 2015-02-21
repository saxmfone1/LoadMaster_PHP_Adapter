<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include('./LM_API_7.1-24b.php');
$user = "bal";
$password = "1fourall";
$host = "172.21.8.100";

$API = new LM_API($host, $user, $password);
//$response=$API->delvs("11");
//$response=$API->listvs();
$modvsparams = array("Cache" => "1", "AddVia" => "1");
$response=$API->modvs("12", $modvsparams);
//$response=$API->addvs("172.21.8.122", "80", "tcp");
print_r($response);

?>