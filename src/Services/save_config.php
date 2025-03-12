<?php
include_once('../../../../../init.php');
use WHMCS\Database\Capsule;

function save_config($token_autonotify, $status) {
    try {
        Capsule::table('sr_autonotify_module_whmcs')->where('id', 1)->update([
            'token' => $token_autonotify,
            'status' => $status,
        ]);

        return ['success' => true, 'message' => 'Configuração salva com sucesso.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erro ao salvar a configuração: ' . $e->getMessage()];
    }
}
?>