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
print_r($API->showrs("172.21.8.11", "80", "tcp", "10.3.0.22" ));

?>