jQuery(document).ready(function($){

    var tab_current = $("#autonotify_body").data('tab');
    $(".tab_" + tab_current).css("color", "white");
    $(".tab_" + tab_current).css("background-color", "#1E90FF");
    $(".tab_" + tab_current).css("box-shadow", "0 4px 8px rgba(0, 0, 0, 0.3)");
    // altera o css da tab atual para o css de selecionado
    $('.tab_content_autonotify').css("display", "none");
    $("." + tab_current + "_body").css("display", "block");
    

    $(".tab_unique").click(function(){
        // volta a tab antiga para o css padrão
        $(".tab_unique").css("color", "#1E90FF");
        $(".tab_unique").css("background-color", "white");
        $(".tab_unique").css("box-shadow", "none");


        // altera o css da tab atual para o css de selecionado
        $(this).css("color", "white");
        $(this).css("background-color", "#1E90FF");
        $(this).css("box-shadow", "0 4px 8px rgba(0, 0, 0, 0.3)");
 
        // funcionalidade de troca de tabs
        var tab_selected = $(this).data('tab');
        $('.tab_content_autonotify').css("display", "none");
        $("." + tab_selected + "_body").css("display", "block");


        // funcionalidade de setar parâmetros de url
        var url = new URL(window.location);
        url.searchParams.set('tab', tab_selected);
        //url.searchParams.delete('porPagina');
        //url.searchParams.delete('pagina');
        window.history.replaceState({}, '', url);
    });
});