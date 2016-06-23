var $ = require('jquery');

function init() {
  var data = {param1: 'value1'};

  $.ajax({
    url: '/prototype/action/get-objects',
    type: 'POST',
    dataType: 'json',
    data: data,
  })
  .done(function() {
    console.log("success");
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
    $('#loader').fadeOut('slow', function() {
      console.log('complete');
    });
  });
}

if ($('.objects').length) {
  init();
}

function isEmbedlySet(element) {
  if ($(element).find('.embedly-card-hug').length) {
    return true;
  } else {
    return false;
  }
}

var objectsHeight = $('#Objects').height();

function showObject(object) {
  $('#loader').hide();
  $(object).show();

  var interval = setInterval(function() {
    var height = $(object).height();
    height = (objectsHeight - height) / 2;
    height = Math.floor(height);
    $(object).css('margin-top', height);

  }, 200);

  var timeout = setTimeout(function() {
    clearInterval(interval);
  }, 3000);
}

$('.embedly-card').each(function() {
  var parent = $(this).parent();
  var object = $(this).closest('.Object');

  var timeout = setTimeout(function() {
    clearInterval(interval);
    showObject(object);
  }, 3000);

  var interval = setInterval(function() {
    var element = $(parent).find('div.embedly-card iframe');
    var link = $(parent).find('a.embedly-card');

    if (element.length && !link.length) {
      clearInterval(interval);
      clearTimeout(timeout);
      showObject(object);
    }
  }, 10);
});
