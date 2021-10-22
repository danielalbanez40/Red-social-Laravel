const w = window;
const d = document;
const url = "http://proyecto-laravel.com.devel";

w.addEventListener('load', function() {

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    function like() {

        // Botón de Like
        $('.btn-like').unbind('click').click(function() {

            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src',url+'/img/heart-red.png');

            $.ajax({
                
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response) {

                    if (response.like) {

                        console.log('Has dado like a la publicación');

                    }else {

                        console.log('Error al dar like');

                    }
                }
            });

            dislike();
        });
    }
    like();
    
    function dislike(){
        // Botón de Dislike
        $('.btn-dislike').unbind('click').click(function() {
            
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src',url+'/img/heart-black.png');

            $.ajax({
                
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response) {

                    if (response.like) {

                        console.log('Has dado dislike a la publicación');

                    }else {

                        console.log('Error al dar dislike');
                        
                    }
                }
            });

            like();
        });
        // alert("La página está completamente cargada!!");
    }
    dislike();

    // Buscador
    $('#buscador').submit(function () {
        $(this).attr('action', url + '/gente/' + $('#buscador #search').val());
    });

});


