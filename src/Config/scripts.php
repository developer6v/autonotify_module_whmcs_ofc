<?php

function set_header_scripts() {
    $timestamp = time();
    
    // bibliotecas
    $script = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">';
    $script .='<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>';
    
    // home
    $script .= '<link rel="stylesheet" type="text/css" href="/modules/addons/autonotify_module_whmcs/public/css/home.css?v=' . $timestamp . '"/>';
    $script .= '<script type="text/javascript" src="/modules/addons/autonotify_module_whmcs/public/js/home.js?v=' . $timestamp . '"></script>';

    // config
    $script .= '<link rel="stylesheet" type="text/css" href="/modules/addons/autonotify_module_whmcs/public/css/config.css?v=' . $timestamp . '"/>';
    $script .= '<script type="text/javascript" src="/modules/addons/autonotify_module_whmcs/public/js/config.js?v=' . $timestamp . '"></script>';

    return $script;  
}


function set_autologin_button($clientId) {
    $timestamp = time();
    $script = '<script type="text/javascript" src="/modules/addons/autonotify_module_whmcs/public/js/setautologin_button.js?v=' . $timestamp . '"></script>';
    return $script; 
}

?>
