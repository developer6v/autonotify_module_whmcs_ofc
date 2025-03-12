<?php
use WHMCS\Database\Capsule;

function domain_admin ($vars, $clientId){

    $params = $vars['params'];
    $error = $vars['error'] ?? null;
    $domainid = $params['domainid'];


   //autologin
   global $CONFIG;
   $adminFolder = App::get_admin_folder_name();
   $autologin = $CONFIG['SystemURL'] .'/an.php?ht=domain&id=' . $domainid . '&cid=' . $clientId;
    // definições extra
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    $domainUrl = "{$adminUrl}/clientsdomains.php?userid={$clientId}&id={$domainid}";
    $sld = $params['sld'];
    $tld = $params['tld'];
    $dominio = "{$sld}.{$tld}";
    $regperiod = $params['regperiod'];
    $contactName = $params['fullname'];
    $contactPhone = $params['fullphonenumber'];
    $contactEmail = $params['email'];

    $data = [
        "autologin" => $autologin,
        "domainerror" => $error,
        "regperiod" => $regperiod,
        "domainurl" => $domainUrl,
        "domainid" => $domainid,
        "dominio" => $dominio,
        "dominioperiodo" => $regperiod,
        "contactname" => $contactName,
        "contactemail" => $contactEmail,
        "contactphone" => $contactPhone,
    ];
  
    return $data;
}

?>