$(document).ready(function(){
  $('#del-template').click(function(){
    $('.del-template-confimation').modal('show');
  });
  $('#del-template-confirm').click(function(){
    $('#del-template').closest('form').submit();
  });
});
