jQuery(document).ready(function($) {
    var status =   $('#token_autonotify').data('status');
    if (status == 'inativo') {
        $('#config_save_autonotify').show();
    }


    // Salvar Configurações
    $('#config_save_autonotify').click(function(){
        var token_autonotify = $('#token_autonotify').val();
        //loading effect
        $('#saving_config_result').show();

        $.ajax ({
            type: "POST",
            url: '/modules/addons/autonotify_module_whmcs/src/Controllers/config.php',
            data: {
                "token_autonotify": token_autonotify
            },
            success: function(response) {
                console.log("resposta: " + response);
                $('#saving_config_true').hide();
                $('#saving_config_false').hide();

                if (response == "Access granted") {
                    $('.status-autonotify').removeClass('status-autonotify-unactivated');
                    $('.status-autonotify').addClass('status-autonotify-activated');
                    $('#saving_config_true').fadeIn('fast');
                    setTimeout(function() {
                        $('#saving_config_true').fadeOut('slow');
                    }, 2000);
                    window.location.reload();
                } else {
                    $('.status-autonotify').removeClass('status-autonotify-activated');
                    $('.status-autonotify').addClass('status-autonotify-unactivated');
                    $('#saving_config_false').fadeIn('fast');
                    setTimeout(function() {
                        $('#saving_config_false').fadeOut('slow');
                    }, 2000);
                    var responseMessage = response.message ?? response;
                    console.log(JSON.stringify(responseMessage));
                }
                console.log('Resposta requisição ajax: ' + response);
            },
            
            error: function(xhr, status, error) {
                $('#saving_config_false').show();
                console.log('Erro na requisição AJAX: ' + error);
            }
        }).always(function (response) {
            console.log(response);
            $('#saving_config_result').hide();
        }); 
    });


    // Editar Token
    $(document).on('click', '.edit-token', function () {
        $('#token_autonotify').removeAttr('disabled');
        $('#token_autonotify').focus();
        $('#token_autonotify').val('');
        $('#config_save_autonotify').show();
        $('.cancelUpdate').show();
        $('.edit-token').hide();
    });

    $(document).on('click', '.cancelUpdate', function () {
        var token = $('#token_autonotify').data('token');
        console.log('token: ' + token);
        $('.edit-token').show();
        $('.cancelUpdate').hide();
        $('#config_save_autonotify').hide();
        $('#token_autonotify').val(token);
        $('#token_autonotify').attr('disabled', 'disabled');
    });

});

