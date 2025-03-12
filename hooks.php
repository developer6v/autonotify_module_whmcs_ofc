<?php

use WHMCS\Database\Capsule;

require_once __DIR__ . '/src/Config/scripts.php'; 
require_once __DIR__ . '/src/Core/Hooks/index.php';
require_once __DIR__ . '/src/Services/autonotify-send-hook.php';

// Fatura Criada 
add_hook('InvoiceCreated', 1, function($vars) {
    $invoiceId = $vars['invoiceid'];
    $clientId = Capsule::table('tblinvoices')->where("id", "=", $invoiceId)->value("userid");
    $data = get_hook_variables('InvoiceCreated', $vars, $clientId);
    autonotify_send_hook(['InvoiceCreated'], $data, $clientId);
});

// Fatura Paga
add_hook('InvoicePaid', 1, function($vars) {
    $invoiceId = $vars['invoiceid'];
    $clientId = Capsule::table('tblinvoices')->where("id", "=", $invoiceId)->value("userid");
    $data = get_hook_variables('InvoicePaid', $vars, $clientId);
    autonotify_send_hook(['InvoicePaid'], $data, $clientId);
});

// Fatura Cancelada 
add_hook('InvoiceCancelled', 1, function($vars) {
    $invoiceId = $vars['invoiceid'];
    $clientId = Capsule::table('tblinvoices')->where("id", "=", $invoiceId)->value("userid");
    $data = get_hook_variables('InvoiceCancelled', $vars, $clientId);
    autonotify_send_hook(['InvoiceCancelled'], $data, $clientId);
});

// Fatura Reembolsada
add_hook('InvoiceRefunded', 1, function($vars) {
    $invoiceId = $vars['invoiceid'];
    $clientId = Capsule::table('tblinvoices')->where("id", "=", $invoiceId)->value("userid");
    $data = get_hook_variables('InvoiceRefunded', $vars, $clientId);
    autonotify_send_hook(['InvoiceRefunded'], $data, $clientId);
});

// Lembrete de Fatura
add_hook('InvoicePaymentReminder', 1, function($vars) {
    $invoiceId = $vars['invoiceid'];
    $clientId = Capsule::table('tblinvoices')->where("id", "=", $invoiceId)->value("userid");
    $data = get_hook_variables('InvoicePaymentReminder', $vars, $clientId);
    autonotify_send_hook(['InvoicePaymentReminder'], $data, $clientId);
});

// Ticket Criado 
add_hook('TicketOpen', 1, function($vars) {
    $clientId = $vars['userid'];
    $data = get_hook_variables('TicketOpen', $vars, $clientId);
    autonotify_send_hook(['TicketOpenAdmin', 'TicketOpen'], $data, $clientId);
});

// Ticket Respondido - CLIENTE
add_hook('TicketAdminReply', 1, function($vars) {
    $ticketId = $vars['ticketid'];
    $clientId = Capsule::table('tbltickets')->where("id", "=", $ticketId)->value("userid");
    $data = get_hook_variables('TicketAdminReply', $vars, $clientId);
    autonotify_send_hook(['TicketAdminReply'], $data, $clientId);
});

// Ticket Respondido - ADMIN
add_hook('TicketUserReply', 1, function($vars) {
    $ticketId = $vars['ticketid'];
    $clientId = Capsule::table('tbltickets')->where("id", "=", $ticketId)->value("userid");
    $data = get_hook_variables('TicketUserReply', $vars, $clientId);
    autonotify_send_hook(['TicketUserReply'], $data, $clientId);
});

// Ticket Fechado
add_hook('TicketClose', 1, function($vars) {
    $ticketId = $vars['ticketid'];
    $clientId = Capsule::table('tbltickets')->where("id", "=", $ticketId)->value("userid");
    $data = get_hook_variables('TicketClose', $vars, $clientId);
    autonotify_send_hook(['TicketClose'], $data, $clientId);
});

// Serviço Criado 
add_hook('AfterModuleCreate', 1, function($vars) {
    $clientId = $vars['params']['userid'];
    $data = get_hook_variables('AfterModuleCreate', $vars, $clientId);
    autonotify_send_hook(['AfterModuleCreate'], $data, $clientId);
});

// Serviço Suspenso 
add_hook('AfterModuleSuspend', 1, function($vars) {
    $clientId = $vars['params']['userid'];
    $data = get_hook_variables('AfterModuleSuspend', $vars, $clientId);
    autonotify_send_hook(['AfterModuleSuspend'], $data, $clientId);
});

// Serviço Reativado 
add_hook('AfterModuleUnsuspend', 1, function($vars) {
    $clientId = $vars['params']['userid'];
    $data = get_hook_variables('AfterModuleUnsuspend', $vars, $clientId);
    autonotify_send_hook(['AfterModuleUnsuspend'], $data, $clientId);
});

// Serviço Cancelado 
add_hook('AfterModuleTerminate', 1, function($vars) {
    $clientId = $vars['params']['userid'];
    $data = get_hook_variables('AfterModuleTerminate', $vars, $clientId);
    autonotify_send_hook(['AfterModuleTerminate'], $data, $clientId);
});

// Bem-vindo 
add_hook('ClientAdd', 1, function($vars) {
    $clientId = $vars['client_id'];
    $data = get_hook_variables('ClientAdd', $vars, $clientId);
    autonotify_send_hook(['ClientAddAdmin', 'ClientAdd'], $data, $clientId);
});

// Login de Cliente
add_hook('UserLogin', 1, function($vars) {
    $user = $vars['user'];
    $email = $user->email;
    $clientId = Capsule::table('tblclients')->where('email', $email)->value('id');
    $data = get_hook_variables('UserLogin', $vars, $clientId);
    autonotify_send_hook(['UserLogin'], $data, $clientId);
});

// Novo Pedido
add_hook('AfterShoppingCartCheckout', 1, function($vars) {
    $orderId = $vars['OrderID'];
    $order = Capsule::table('tblorders')->where('id', $orderId)->first();
    $clientId = $order->userid;
    $data = get_hook_variables('AfterShoppingCartCheckout', $vars, $clientId);
    autonotify_send_hook(['AfterShoppingCartCheckout'], $data, $clientId);
});

// Pedido Pago
add_hook('OrderPaid', 1, function($vars) {
    $orderId = $vars['orderId'];
    $vars['OrderID'] = $orderId;
    $order = Capsule::table('tblorders')->where('id', $orderId)->first();
    $clientId = $order->userid;
    $data = get_hook_variables('OrderPaid', $vars, $clientId);
    autonotify_send_hook(['OrderPaid'], $data, $clientId);
});

// Registro de Domínio
add_hook('AfterRegistrarRegistration', 1, function($vars) {
    $params = $vars['params'];
    $clientId = $params['userid'];
    $data = get_hook_variables('AfterRegistrarRegistration', $vars, $clientId);
    autonotify_send_hook(['AfterRegistrarRegistration'], $data, $clientId);
});

// Falha no Registro de Domínio
add_hook('AfterRegistrarRegistrationFailed', 1, function($vars) {
    $params = $vars['params'];
    $clientId = $params['userid'];
    $data = get_hook_variables('AfterRegistrarRegistrationFailed', $vars, $clientId);
    autonotify_send_hook(['AfterRegistrarRegistrationFailed'], $data, $clientId);
});

add_hook('AdminAreaHeaderOutput', 1, function($vars) {
    // Obtém a URL atual
    $currentUrl = $_SERVER['REQUEST_URI'];
    $addonModuleName = 'autonotify_module_whmcs';
    // Verifica se a URL contém o módulo específico
    if (strpos($currentUrl, 'module=' . $addonModuleName) !== false) {
        $script = set_header_scripts();
        return $script;
    }


    return '';
});

?>
