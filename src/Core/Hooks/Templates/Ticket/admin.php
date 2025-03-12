<?php
use WHMCS\Database\Capsule;

function ticket_admin ($vars, $clientId){
    $ticketId = $vars['ticketid'];

    // definições extras
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    $ticketUrl = "{$adminUrl}/supporttickets.php?action=view&id=$ticketId";
    $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
    $ticketTitle = $ticketDetails->title;
    $ticketNumber = $ticketDetails->tid;
    $ticketCode = $ticketDetails->c;
    $ticketMessage = str_replace("\n", " ", $ticketDetails->message);
    $ticketDate = date("d/m/Y", strtotime($ticketDetails->date));
    $ticketHour = date("H:i", strtotime($ticketDetails->date));
    $website = Capsule::table('tblconfiguration')->where("setting","=", "SystemURL")->value("value");
    $ticketAnswer = Capsule::table('tblticketreplies')
        ->where('tid', $ticketId)
        ->where('admin', '')
        ->orderBy('id', 'desc')
        ->limit(1)
        ->value('message') ?? '';
    $ticketAnswer = str_replace("\n", " ", $ticketAnswer);
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