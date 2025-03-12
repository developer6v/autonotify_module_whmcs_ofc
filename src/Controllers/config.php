<?php

require_once __DIR__ . '/../Services/save_config.php';
require_once __DIR__ . '/../Services/validate_token.php';

$request_method = $_SERVER['REQUEST_METHOD']; 

// salvar configurações
if ($request_method === "POST") {
    $token_autonotify = $_POST['token_autonotify'] ?? null;
    $validateToken = validateToken($token_autonotify);

    if ($validateToken == 'Access granted') { 
        save_config($token_autonotify, true);
    } 
    
    echo $validateToken; 
}

?>
