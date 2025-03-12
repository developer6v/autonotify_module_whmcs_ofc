<?php
use WHMCS\Database\Capsule;

function ticket_cliente ($vars, $clientId){
    $ticketId = $vars['ticketid'];

    // variaveis de ticket
    $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
    $ticketTitle = $ticketDetails->title;
    $ticketNumber = $ticketDetails->tid;
    $ticketCode = $ticketDetails->c;
    $ticketMessage = str_replace("\n", " ", $ticketDetails->message);
    $ticketDate = date("d/m/Y", strtotime($ticketDetails->date));
    $ticketHour = date("H:i", strtotime($ticketDetails->date));
    $website = Capsule::table('tblconfiguration')->where("setting","=", "SystemURL")->value("value");
    $ticketUrl = "{$website}viewticket.php?tid={$ticketNumber}&c={$ticketCode}";
    $ticketAnswer = Capsule::table('tblticketreplies')
        ->where('tid', $ticketId)
        ->whereNotNull('admin')
        ->orderBy('id', 'desc')
        ->limit(1)
        ->value('message') ?? '';
    $ticketAnswer = str_replace("\n", " ", $ticketAnswer);


    //autologin
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $autologin = $CONFIG['SystemURL'] .'/an.php?ht=ticket&tid=' . $ticketNumber . '&c=' . $ticketCode. '&cid=' . $clientId;

   
        
    $data = [
        "autologin" => $autologin,
        "ticketsubject" => $ticketTitle,
        "ticketid" => $ticketId,
        "ticketurl" => $ticketUrl,
        "ticketdate" => $ticketDate,
        "tickethour" => $ticketHour,
        "ticketmessage" => $ticketMessage,
        "ticketanswer" => $ticketAnswer
    ];
    
    return $data;
}

?>