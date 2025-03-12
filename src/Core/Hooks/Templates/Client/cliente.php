<?php
use WHMCS\Database\Capsule;

function cliente_cliente ($vars, $clientId){

    
    //autologin
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $autologin = $CONFIG['SystemURL'] .'/an.php?ht=client&cid=' . $clientId;



    // definição variaveis de cliente
    $ipaddress =  $_SERVER['REMOTE_ADDR'];
    $data = [
        "autologin" => $autologin,
        "ipaddr" => $ipaddress
    ];
    return $data;
}

?>