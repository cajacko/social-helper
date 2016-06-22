var $ = require('jquery');

$('#ShowRegisterForm').click(function() {
  $('#Login').hide();
  $('#Register').show();
});

$('#ShowLoginForm').click(function() {
  $('#Login').show();
  $('#Register').hide();
});
