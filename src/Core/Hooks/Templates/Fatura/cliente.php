<?php

include_once ('../../../../Services/get_gateway_code.php');


use WHMCS\Database\Capsule;


function fatura_cliente ($vars, $clientId){
    $invoiceId = $vars['invoiceid'];

   //autologin
   global $CONFIG;
   $adminFolder = App::get_admin_folder_name();
   $autologin = $CONFIG['SystemURL'] .'/an.php?ht=invoice&id=' . $invoiceId . '&cid=' . $clientId;


    // variaveis de invoice
    $value = Capsule::table('tblinvoices')->where('id', $invoiceId)->value('total');
    $duedate = (new DateTime(Capsule::table('tblinvoices')->where('id', $invoiceId)->value('duedate')))->format('d/m/Y');
    $invoiceItems = Capsule::table('tblinvoiceitems')
    ->where('invoiceid', $invoiceId)
    ->get(['description', 'amount']);

    $itemDetails = [];
    foreach ($invoiceItems as $item) {
        $itemDetails[] = "- {$item->description} (R$ {$item->amount})";
    }

    $productList = implode("\n", $itemDetails);

    // $codigoPix = getBoletoPix($invoiceId);

    $data = [
        "autologin" => $autologin,
        "codigopix/codigoboleto" => '' ,
        "invoiceid" => $invoiceId,
        "duedate" => $duedate,
        "value" => $value,
        "productlist" => $productList
    ];

    logActivity("product list: " . json_encode($data, true));
    
    return $data;
}

?>