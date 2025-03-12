<?php
use WHMCS\Database\Capsule;

function service_cliente ($vars, $clientId){
    $serviceId = $vars['params']['serviceid'];

   //autologin
   global $CONFIG;
   $adminFolder = App::get_admin_folder_name();
   $autologin = $CONFIG['SystemURL'] .'/an.php?ht=service&id=' . $serviceId . '&cid=' . $clientId;


    // variaveis do serviço
    $productName = Capsule::table('tblhosting')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where('tblhosting.id', $serviceId)->value('tblproducts.name');
    $username = Capsule::table('tblhosting')->where('id', $serviceId)->value('username');
    $password = Capsule::table('tblhosting')->where('id', $serviceId)->value('password');
    
    $data = [
        "autologin" => $autologin,
        "productname" => $productName,
        "serviceid" => $serviceId,
        "username" => $username,
        "password" => $password
    ];
    return $data;
}

?>