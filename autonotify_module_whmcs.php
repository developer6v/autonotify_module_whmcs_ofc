<?php
include_once __DIR__ . '/hooks.php';
include_once __DIR__ . '/src/Views/home.php';
include_once __DIR__ . '/src/Config/module.php';

function autonotify_module_whmcs_config() { 
    return array(
        'name' => 'Autonotify Module For WHMCS',
        'description' => 'Módulo responsável por integrar o WHMCS com o Autonotify.',
        'version' => '1.0',
        'author' => 'Sourei',
        'fields' => array()
    );
}

function autonotify_module_whmcs_activate() {
    autonotify_activate();
    return array('status' => 'success', 'description' => 'Módulo ativado com sucesso! As seguintes tabelas foram criadas no banco de dados (se não existiam): sr_autonotify_module_whmcs, sr_templates_for_whmcs, sr_relatory_for_whmcs.');
}

function autonotify_module_whmcs_deactivate() {
    return array('status' => 'success', 'description' => 'Módulo desativado com sucesso!');
}

function autonotify_module_whmcs_output($vars) {
    echo layout($vars);
}