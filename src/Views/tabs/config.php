<?php
use WHMCS\Database\Capsule;

function config_tab() {
    Capsule::connection()->getPdo()->exec("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");

    // configurações
    $config_data = Capsule::table('sr_autonotify_module_whmcs')->where('id', 1)->first();
    $token = $config_data->token;
    $status = $config_data->status;

    $output = "<div class='config_body tab_content_autonotify'>
        <div class='config_div'>

            <div class='config_header'>
                <p class='config_title'><i class='fa-solid fa-gear'></i> Configurações</p>
                <span class='config_subtitle'>O módulo Autonotify for WHMCS automatiza o envio de mensagens automáticas para seus clientes via WhatsApp. Nesta aba, você pode gerenciar e configurar o Autonotify conforme suas necessidades específicas.</span>
            </div>

            <div class='config_input_div'>
                <p><i class='fa-solid fa-key'></i> Token</p>";

                if ($status) {
                    $output .= "
                        <span>Seu token para a integração com o Autonotify. <i class='status-autonotify status-autonotify-activated fa-solid fa-circle-check'></i></span>
                        <input
                            value = '$token'
                            class='config_input'
                            id='token_autonotify'
                            data-token='$token'
                            type='text'
                            data-status='ativo'
                            placeholder='Insira o token do seu serviço Autonotify.'
                            disabled
                        />

                        <i class='edit-token fa-solid fa-pen-to-square'></i>";
                } else {
                    $output .= "
                        <span>Seu token para a integração com o Autonotify. <i class='status-autonotify status-autonotify-unactivated fa-solid fa-circle-check'></i></span>
                        <input
                            class='config_input'
                            id='token_autonotify'
                            type='text'
                            data-status='inativo'
                            placeholder='Insira o token do seu serviço Autonotify.'
                        />";
                }
            $output .= "
            </div>";

            $output .= "<button id='config_save_autonotify'><i class='fa-regular fa-share-from-square'></i> Validar Token</button>
            <span class='cancelUpdate'>Cancelar</span>";
            $output .= "<div class='saving_result'>
                <p class='saving_result_true' id='saving_config_true'><i class='fa-solid fa-circle-check'></i> Token Validado!</p>
                <p class='saving_result_false'id='saving_config_false'><i class='fa-solid fa-triangle-exclamation'></i> Falha ao validar token! Entre em contato com o suporte.</p>
                <img id='saving_config_result' src='/modules/addons/autonotify_module_whmcs/public/gif/loading.gif'/>
            </div>
        </div> 
    </div>";
    
    return $output;
}
?>
