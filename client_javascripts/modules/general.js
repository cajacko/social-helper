var $ = require('jquery');

function error() {
    $('#siteMessage').fadeIn('fast', function() {
        setTimeout(function() {
            $('#siteMessage').fadeOut('slow');
        }, 2000);
    });
}

$(document).ready(function() {
    $('.linkIcon, .tweetIcon').click(function(event) {
        event.preventDefault();

        var element = $(this);
        var discardElement = $(this).closest('.discardElement');

        var action = $(element).data('action');
        var id = $(element).data('id');

        var url = '/action/ajax';

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: {action: action, id: id},
        })
        .done(function(data) {
            if (!data || data.err) {
                error();
            } else {
                $(discardElement).slideUp();
            }
        })
        .fail(function() {
            error();
        });
    });
});
