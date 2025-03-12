<?php

function validateToken($token) {
    $urlApi = "https://apiautonotify.sourei.com.br";
    $url_validate_token = "${urlApi}/auth";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $token
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url_validate_token);
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        logActivity('validate token: ' . $error);
        return "cURL Error: " . $error;
    }
    logActivity('validate token: ' . $response);
    
    curl_close($ch);
    return $response;
}

?>
