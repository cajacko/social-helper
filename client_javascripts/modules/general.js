var $ = global.jQuery = require('jquery');
var bootstrap = require('bootstrap/dist/js/bootstrap');

function error() {
    $('#siteMessage').fadeIn('fast', function() {
        setTimeout(function() {
            $('#siteMessage').fadeOut('slow');
        }, 2000);
    });
}

function submitAction(element, data) {
    var discardElement = $(element).closest('.object');

    var url = $(element).attr('href');

    if (!url) {
        url = $(element).attr('action');
        data = {};

        $(element).find('input').each(function() {
            var input = $(this).attr('name');
            var value = $(this).val();

            if (!data[input] && input == 'account') {
                data[input] = [];
            }

            if (input == 'account' && $(this).prop('checked')) {
                data[input].push(value);
            } else if (input != 'account') {
                data[input] = value;
            }
        });
    }

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: data
    })
    .done(function(data) {
        if (!data || data.err || !data.success) {
            error();
        } else {
            $(discardElement).slideUp();
        }
    })
    .fail(function() {
        error();
    });
}

$(document).ready(function() {
    $('.directAction').click(function(event) {
        event.preventDefault();
        var element = $(this);
        submitAction(element);
    });

    var accountdIDs = [
        {id: 1, name: 'charliejackson', type: 'twitter'},
        {id: 2, name: 'ninestudios', type: 'twitter'},
        {id: 6, name: 'supercouth', type: 'twitter'}
    ];

    var accountLength = accountdIDs.length;

    $('.popoverAction').popover({
        content: function() {
            var action = $(this).data('action');
            var objectID = $(this).data('objectid');
            var html = '';

            html += '<form class="popoverForm" action="/action/" method="post">';
            html += '<input type="hidden" name="action" value="' + action + '">';
            html += '<input type="hidden" name="objectID" value="' + objectID + '">';
            html += '<div class="form-group">';

            for (var i = 0; i < accountLength; i++) {
                html += '<input class="form-control" type="checkbox" name="account" value="' + accountdIDs[i].id + '">';

                if (accountdIDs[i].type == 'twitter') {
                    html += '@';
                }

                html += accountdIDs[i].name;
            }

            html += '</div>';
            html += '<button class="btn" type="submit">Go</button>';
            html += '</form>';

            return html;
        },
        title: 'Accounts',
        html: true,
        placement: 'bottom'
    }).on('shown.bs.popover', function() {
        var id = $(this).attr('aria-describedBy');
        $('#' + id).find('form').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            submitAction(element);
        });
    });
});
