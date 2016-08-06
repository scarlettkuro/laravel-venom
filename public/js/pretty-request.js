/* 
 * Allow to make GET request from <a> marked with .pretty-request class
 * with AJAX and refresh page after that 
 * (allows to rebuild page on server side)
 */
$(function() {
    $('.pretty-request').click(function (event) {
        event.preventDefault();
        var target = $(event.target);
        $.ajax( target.attr('href') )
            .success(function() {
                location.reload();
            })
            .error(function() {
              alert( "error" );
            });
    });
});

