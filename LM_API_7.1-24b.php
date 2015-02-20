<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of LM_API_7
 *
 * @author jmalek
 */
include('./httpful.phar');
$access = "/access/";

function sendCommand($host, $user, $password, $cmd){
    global $access;
    $uri = "https://$host$access$cmd";
    $response = simplexml_load_string(\Httpful\Request::get($uri)
            ->basicAuth($user, $password)
            ->send()->body);
    if ($response->attributes()->stat == "200"){
        $response = $response->Success->Data;
    }
    else {
        $response = (string)$response->Error[0];
    }
    return $response;
}

class LM_API {
    private $host;
    private $user;
    private $password;
    
    function __construct($host, $user, $password){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
    
    /**
     * Returns stats from LM
     * @return simpleXMLobject
     * 
     */
    function stats(){
        $cmd = "stats";
        $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        return($response);
    }
    
    /**
     * Returns list of VS from LM
     * @return simpleXMLobject
     * 
     */
    function listvs(){
        $cmd = "listvs";
        $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        return($response);
    }
    
    /**
     * Returns the config of a VS
     * @return simpleXMLobject
     * @param string $vsid The ID of a given VS, used by itself can call a VS. Do not use with other paramters.
     * @param string $vsip The IP of a given VS, must be used with $vsport and $vsprot
     * @param string $vsport The port of a given VS, must be used with $vsip and $vsprot
     * @param string $vsprot The protocol of a given VS, tcp or udp, must be used with $vsip and $vsport
     */
    function showvs(){
        if (func_num_args() == 1){
            $vsid = func_get_arg(0);
            $cmd = "showvs?vs=$vsid";
            $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        }
        else if (func_num_args() == 3){
            $vsip = func_get_arg(0);
            $vsport = func_get_arg(1);
            $vsprot = func_get_arg(2);
            $cmd = "showvs?vs=$vsip&port=$vsport&prot=$vsprot";
            $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        }
        else {
            $response = "Incorrect number of arguments. Function takes 1 or 3 arguments. (\$vsid) or (\$vsip, \$vsport, \$vsprot)";
        }
        return $response;
    }
    
    /**
     * Returns the config of a VS
     * @return simpleXMLobject
     * @param string $vsid The ID of a given VS, used by itself can call a VS. Do not use if giving full address of VS
     * @param string $vsip The IP of a given VS, must be used with $vsport and $vsprot
     * @param string $vsport The port of a given VS, must be used with $vsip and $vsprot
     * @param string $vsprot The protocol of a given VS, tcp or udp, must be used with $vsip and $vsport     
     * @param string $rsip The IP of a given RS
     * @param string $rsport The port of a given RS
     * 
     */
    function showrs(){
        if (func_num_args() == 3){
            $vsid = func_get_arg(0);
            $rsip = func_get_arg(1);
            $rsport = func_get_arg(2);
            $cmd = "showvs?vs=$vsid&rs=$rsip&rsport=$rsport";
            $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        }
        else if (func_num_args() == 5){
            $vsip = func_get_arg(0);
            $vsport = func_get_arg(1);
            $vsprot = func_get_arg(2);
            $rsip = func_get_arg(3);
            $rsport = func_get_arg(4);
            $cmd = "showvs?vs=$vsip&port=$vsport&prot=$vsprot&rs=$rsip&rsport=$rsport";
            $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        }
        else {
            $response = "Incorrect number of arguments. Function takes 3 or 5 arguments. (\$vsid, \$rsip, \$rsport) or (\$vsip, \$vsport, \$vsprot, \$rsip, \$rsport)";
        }
        return $response;
    }

    /**
     * Add a Virtual service
     * @param type $vsip The intended IP of the new VS
     * @param type $vsport The intended port of the new VS
     * @param type $vsprot The intended protocol of the new VS, tcp or UDP
     * @return simpleXMLobject
     */
    function addvs($vsip, $vsport, $vsprot){
        $cmd = "addvs?vs=$vsip&port=$vsport&prot=$vsprot";
        $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        return($response);
    }
     
    /**
     * Deletes a VS
     * @return simpleXMLobject
     * @param string $vsid The ID of a given VS, used by itself can call a VS. Do not use with other paramters.
     * @param string $vsip The IP of a given VS, must be used with $vsport and $vsprot
     * @param string $vsport The port of a given VS, must be used with $vsip and $vsprot
     * @param string $vsprot The protocol of a given VS, tcp or udp, must be used with $vsip and $vsport
     */
    function delvs(){
        if (func_num_args() == 1){
            $vsid = func_get_arg(0);
            $cmd = "delvs?vs=$vsid";
            $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        }
        else if (func_num_args() == 3){
            $vsip = func_get_arg(0);
            $vsport = func_get_arg(1);
            $vsprot = func_get_arg(2);
            $cmd = "delvs?vs=$vsip&port=$vsport&prot=$vsprot";
            $response = sendCommand($this->host, $this->user, $this->password, $cmd);
        }
        else {
            $response = "Incorrect number of arguments. Function takes 1 or 3 arguments. (\$vsid) or (\$vsip, \$vsport, \$vsprot)";
        }
        return $response;
    }
}
