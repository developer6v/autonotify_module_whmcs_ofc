<?php
use WHMCS\Database\Capsule;
 
function order_admin ($vars, $clientId){
    $orderId = $vars['OrderID'];
        
    // definições extras
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    $orderUrl = "{$adminUrl}/orders.php?action=view&id=$orderId";
    $order = Capsule::table('tblorders')->where('id', $orderId)->first();
    $invoiceId = $order->invoiceid;
    $clientId = $order->userid;
    $client = Capsule::table("tblclients")->where("id", $clientId)->first();

    // Método de Pagamento
    $paymentGateway = $order->paymentmethod;
    $paymentMethod = Capsule::table("tblpaymentgateways")->where("gateway", $paymentGateway)->where("setting", "name")->value("value");

    // CUPOM
    $cupomCode = $order->promocode;
    if ($cupomCode) {
        $cupomValue = number_format($order->promovalue, 0, ',', '');
        $cupomLine = "Cupom: {$cupomCode} (%{$cupomValue})\n";
    }

    // verificar a existencia de afiliados
    $affiliateId = Capsule::table("tblaffiliateshistory")->where('invoice_id', $invoiceId)->value("affiliateid");
    if ($affiliateId) {
        $affiliateClientId = Capsule::table("tblaffiliates")->where("id", $affiliateId)->value("clientid");
        $affiliateClient = Capsule::table("tblclients")->where("id", $affiliateClientId)->first();
        $affiliateFirstName = $affiliateClient->firstname;
        $affiliateLastName = $affiliateClient->lastname;
        $affiliateLine = "Afiliado: {$affiliateFirstName} {$affiliateLastName} (#{$affiliateClientId})\n";
    }
    // Formatar o valor e a data do pedido
    $value = number_format($order->amount, 2, ',', '');
    $date = (new DateTime($order->date))->format('d/m/Y');
    $hour = (new DateTime($order->date))->format('H:i:s');

    // Obter o status do pedido
    $statusOrder = Capsule::table('tblinvoices')->where("id", $invoiceId)->value('status');
    switch ($statusOrder) {
        case "Unpaid":
            $statusOrder = "Pendente";
            break;
        case "Pendente":
            $statusOrder = "Pendente";
            break;
        case "Paid":
            $statusOrder = "Pago";
            break;
        case "Draft":
            $statusOrder = "Rascunho";
            break;
        case "Cancelled":
            $statusOrder = "Cancelado";
            break;
        
    }
    // Concatenar nome completo do cliente
    $clientName = $client->firstname . " " . $client->lastname;

    // Endereço do cliente, cpf e telefone
    $address = trim($client->address1 . " - " . ($client->address2 ?? "")) . " - " . $client->city . " - " . $client->state . ", " . $client->postcode;
    $clientPhone = preg_replace("/[^0-9]/", "", $client->phonenumber);
    $cpfNumber = Capsule::table('tblcustomfieldsvalues')->where('fieldid', 1)->where('relid', $clientId)->value('value');
    if ($cpfNumber) {
        $cpf = "CPF: {$cpfNumber}\n";
    }
    // Order Placed By
    $requestorId = Capsule::table('tblorders')->where('id', $orderId)->value('requestor_id');
    $adminRequestorId = Capsule::table('tblorders')->where('id', $orderId)->value('admin_requestor_id');
    if ($requestorId != 0 && $adminRequestorId == 0) {
        $firstname = Capsule::table('tblusers')->where('id', $requestorId)->value('first_name');
        $lastname = Capsule::table('tblusers')->where('id', $requestorId)->value('last_name');
        $requestor = "Usuário - {$firstname} {$lastname} (ID: {$requestorId})\n\n";
    } else if ($requestorId == 0 && $adminRequestorId != 0) {
        $firstname = Capsule::table('tbladmins')->where('id', $adminRequestorId)->value('firstname');
        $lastname = Capsule::table('tbladmins')->where('id', $adminRequestorId)->value('lastname');
        $requestor = "Admin - {$firstname} {$lastname} (ID: {$adminRequestorId})";
    }
    // Obter nomes dos produtos e ciclos de faturamento
    $packages = Capsule::table("tblhosting")
        ->join("tblproducts", "tblhosting.packageid", "=", "tblproducts.id")
        ->where("tblhosting.orderid", $orderId)
        ->get(["tblhosting.billingcycle", "tblhosting.domain", "tblproducts.name"]);

    $productDetails = [];
    foreach ($packages as $package) {
        $billingcycle = "($package->billingcycle)";
        $domain = "- $package->domain";
        $productDetails[] = "- {$package->name} $billingcycle $domain";
    }
    $productList = implode("\n", $productDetails);


    $autologin = $CONFIG['SystemURL'] .'/an.php?ht=order&id=' . $invoiceId . '&cid=' . $clientId;




    $data = [
        "autologin" => $autologin,
        "value" => $value,
        "orderid" => $orderId,
        "paymentmethod" => $paymentMethod,
        "orderrequestor" => $requestor,
        "productslist" => $productList,
        "clientphone" => $clientPhone,
        "address" => $address,
        "invoiceid" => $invoiceId,
        "orderstatus" => $statusOrder,
        "orderurl" => $orderUrl,
    ];

    return $data;
}

?>