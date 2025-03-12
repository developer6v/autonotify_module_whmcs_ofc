<?php

require_once __DIR__ . '/formattNumber.php'; 


use WHMCS\Database\Capsule;

function autonotify_send_hook ($hook, $vars, $clientId) {

    $customFieldId = Capsule::table('tblcustomfields')->where('fieldname', 'Aceita Notificações pelo WhatsApp? (Autonotify)')->value('id');
    $clientsWantsMessage = Capsule::table('tblcustomfieldsvalues')->where('fieldid', $customFieldId)->where('relid', $clientId)->value('value');

    if ($clientsWantsMessage == "Não") {
        return;
    } else {
        $token = Capsule::table('sr_autonotify_module_whmcs')
            -> where('id', 1)
            -> value('token');

        $urlApi = "https://apiautonotify.sourei.com.br";
        $url_autonotify_send_hook = "${urlApi}/hooks/whmcs";


        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . $token
        ];

        $vars['phone'] = formatPhoneNumber($vars['phone']);

        $postfields = json_encode ([
            "keys" => $hook,
            "data" => $vars
        ]);


        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_URL, $url_autonotify_send_hook);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postfields);
        $response = curl_exec ($ch);
        return $response;
    }
}


?>