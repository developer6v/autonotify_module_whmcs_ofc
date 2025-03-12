<?php

$basedir = dirname(__DIR__, 5);
require_once ($basedir . '/modules/gateways/paghiper/classes/PaghiperTransaction.php');

function getBoletoPix ($invoiceId) {

    $transactionData = [
        'invoiceID' => $invoiceId,
        'format' => 'json'
    ];

    // Inicialize a transação PagHiper
    try {
        $paghiperTransaction = new PaghiperTransaction($transactionData);
        //return $paghiperTransaction->process();
        $invoiceTransaction = json_decode($paghiperTransaction->process(), TRUE);
        if ($invoiceTransaction) {
            if ($invoiceTransaction['emv']) {
                $pixCode = $invoiceTransaction['emv'] ?? 'teste';
                return $pixCode;
            } elseif ($invoiceTransaction['digitable_line']) {
                $boletoCode = $invoiceTransaction['digitable_line'] ?? 'teste';
                return $boletoCode;
            } 
        } else {
            return '';
        }
    } catch (Exception $e) {
        return("");
    }
}


?>