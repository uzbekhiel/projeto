$(document).ready(function(){

    $('a,logout').click(function(){
        $.ajax({
           url: 'sair.php',
           success:function(){
                document.location = 'index.php';
           }
         });
    });

    $('span').click(function(){
        var pai = $(this).parent().attr('class');
        var id = $(this).attr('id');
        var idNivel = id.split('_');
        var nivel = idNivel[1];
        $('.'+pai+' span').css('background-image', 'url(css/images/vazia.png)');
        $('.'+pai+' span:lt('+nivel+')').css('background-image', 'url(css/images/cheia.png)');

    });

});