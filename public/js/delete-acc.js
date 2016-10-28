$(document).ready(function(){
  $('#delete-acc').click(function(){
    $('.delete-confirm').modal('show');
  });

  $('#delete-confirm').click(function(){
    runPreloader();
    $('.error-holder').html('');
    if($('#pass-del').val() != ''){
      $.post('/usun-konto', { pass: $('#pass-del').val(), _token: $('meta[name=csrf-token]').attr('content') })
      .done(function(response){
        var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          window.open('http://easify-allegro.xyz', '_self', false);
        }
        else{
          $('.error-holder').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
        }
        stopPreloader();
      })
      .fail(function(response){
        $('.error-holder').html('<div class="alert alert-danger">Wystąpił błąd, spróbuj ponownie później</div>');
        stopPreloader();
      });
    }
    else{
      $('.error-holder').html('<div class="alert alert-danger">Musisz wpisać swoje hasło</div>');
      stopPreloader();
    }
  });
});
