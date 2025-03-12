<?php
use WHMCS\Database\Capsule;

require_once __DIR__ . "/Templates/Client/admin.php";
require_once __DIR__ . "/Templates/Client/cliente.php";
require_once __DIR__ . "/Templates/Domain/admin.php";
require_once __DIR__ . "/Templates/Fatura/cliente.php";
require_once __DIR__ . "/Templates/Order/admin.php";
require_once __DIR__ . "/Templates/Service/cliente.php";
require_once __DIR__ . "/Templates/Ticket/cliente.php";
require_once __DIR__ . "/Templates/Ticket/admin.php";

function get_hook_variables($hook, $vars, $clientId) {
    //logACtivity("clientid: " . $clientId);
    $clientData = Capsule::table('tblclients')
        ->where('id', $clientId)
        ->first(); 
    $website = Capsule::table('tblconfiguration')->where("setting","=", "SystemURL")->value("value");


    // Atualiza $result com base no hook
    if (strpos($hook, 'Invoice') !== false) {
        $result = fatura_cliente($vars, $clientId);
    } 
    else if ($hook == 'TicketUserReply') {
        $result = ticket_admin($vars, $clientId);
    }
    else if ($hook == 'TicketOpenAdmin') {
        $result = ticket_admin($vars, $clientId);
    }
    else if (strpos($hook, 'Ticket') !== false) {
        $result = ticket_cliente($vars, $clientId);
    }
    else if (strpos($hook, 'AfterModule') !== false) {
        $result = service_cliente($vars, $clientId);
    }
    else if ($hook == 'UserLogin') {
        $result = cliente_cliente($vars, $clientId);
    }
    
    else if ($hook == 'ClientAdd') {
        $result1 = cliente_cliente($vars, $clientId);
        $result2 = cliente_admin($vars, $clientId);
        $result = array_merge($result1, $result2);
    }

    else if ($hook == 'AfterShoppingCartCheckout' || $hook == 'OrderPaid') {
        $result = order_admin($vars, $clientId);
    }
    else if ($hook == 'AfterRegistrarRegistration' || $hook == 'AfterRegistrarRegistrationFailed') {
        $result = domain_admin($vars, $clientId);
    } 
    else {
        $result = [];
    }


    $result['clientid'] = $clientId;
    $result['firstname'] = $clientData->firstname;
    $result['lastname'] = $clientData->lastname;
    $result['company'] = $clientData->companyname;
    $result['email'] = $clientData->email;
    $result['phone'] = preg_replace('/[\s\.\-]/', '', $clientData->phonenumber);
    $result['address'] = $clientData->address1 . " - " . $clientData->address2;
    $result['city'] = $clientData->city;
    $result['state'] = $clientData->state;
    $result['postcode'] = $clientData->postcode;
    $result['website'] = $website;
    $result['date'] = date("d/m/Y");
    $result['hour'] = date("H:i:s");

    logActivity(json_encode($result, true));

    return $result;
}
?>
