<?php

require_once __DIR__ . '/tabs/config.php';


function layout($vars) { 

    $page_set = isset($_GET['tab']) ? $_GET['tab'] : "config";

    $output = "
    <div class='autonotify_body' id='autonotify_body' data-tab='$page_set'>
        <div class='autonotify_header'>
            <img id='autonotify_logo' src='/modules/addons/autonotify_module_whmcs/public/img/autonotify.svg'/>
        </div>   
        <div class='tabs'>
            <div class='tab_config tab_unique' data-tab='config'>
                <span><i class='fa-solid fa-gear'></i> Configuração</span>
            </div>
        </div>
    </div>
    
    <div class='autonotify_content'>";

    $output .= config_tab();

    $output .= "</div>";

    return $output;
}


?>