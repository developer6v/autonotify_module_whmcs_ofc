<?php
use WHMCS\Database\Capsule;

function cliente_admin ($vars, $clientId) {

    //autologin
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $autologin = $CONFIG['SystemURL'] .'/an.php?ht=client&cid=' . $clientId;



    // definições extras
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    $clientUrl = "{$adminUrl}/clientssummary.php?userid={$clientId}";
    $clientPhone = Capsule::table("tblclients")->where("id", $clientId)->value("phonenumber");
    $clienteCompany = Capsule::table("tblclients")->where("id", $clientId)->value("companyname");


    


    $data = [
        "autologin" => $autologin,
        "clienturl" => $clientUrl,
        "clientphone" => $clientPhone,
        "clientcompany" => $clienteCompany
    ];

    return $data;
}

?>