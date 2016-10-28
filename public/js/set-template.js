$(document).ready(function(){
  $('.save-template').click(function(){
    runPreloader();
    $('.alert-holder-template').html('');
    var template_id = $(this).data('template');
    var name = $('#template-name').val();
    var content = '';
    var version = $('#template-version').val();
    var var_start = $('#var-start').val();
    var var_end = $('#var-end').val();
    $.post('/set-template', { _token: $('meta[name=csrf-token]').attr('content'), template_id: template_id, name: name, content: content, version: version, var_start: var_start, var_end: var_end })
    .done(function(response){
      var responseJson = $.parseJSON(response);
      if(responseJson.success == 1){
        $('.alert-holder-template').html('<div class="alert alert-success">Zapisano zmiany</div>');
      }
      else{
        $('.alert-holder-template').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
      }
      stopPreloader();
    })
    .fail(function(response){
      $('.alert-holder-template').html('<div class="alert alert-danger">Wystąpił błąd połączenia z serwerem</div>');
      stopPreloader();
    });

  });
});
