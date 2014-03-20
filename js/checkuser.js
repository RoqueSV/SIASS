$(function() {    
    $('#usuario').blur(function(){

        $('#Info').html('<img src="../../imagenes/loader.gif" alt="" />').fadeOut(1000);

        var usuario = $(this).val();        
        var dataString = 'usuario='+usuario;

        $.ajax({
            type: "POST",
            url: "../../librerias/checkuser.php",
            data: dataString,
            success: function(data) {
                $('#Info').fadeIn(1000).html(data);
            }
        });
    });              
});    