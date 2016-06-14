var $ = require('jquery');

function error() {
    $('#siteMessage').fadeIn('fast', function() {
        setTimeout(function() {
            $('#siteMessage').fadeOut('slow');
        }, 2000);
    });
}

$(document).ready(function() {
    $('.actionLink').click(function(event) {
        event.preventDefault();

        var element = $(this);
        var discardElement = $(this).closest('.object');

        var url = $(element).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json'
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
