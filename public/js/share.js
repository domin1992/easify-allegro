$(document).ready(function(){
  $('.shared-list').delegate('.remove-from-sharing', 'click', function(){
    runPreloader();
    $('.alert-holder-share').html('');
    var user_id = $(this).data('user');
    var template_id = $(this).data('template');
    var elem = $(this);
    $.post('/del-share', { _token: $('meta[name=csrf-token]').attr('content'), template_id: template_id, user_id: user_id })
    .done(function(response){
      var responseJson = $.parseJSON(response);
      if(responseJson.success == 1){
        $(elem).closest('.row').remove();
      }
      else{
        $('.alert-holder-share').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
      }
      stopPreloader();
    })
    .fail(function(response){
      $('.alert-holder-share').html('<div class="alert alert-danger">Wystąpił błąd połączenia z serwerem</div>');
      stopPreloader();
    });
  });

  $('.add-share').click(function(){
    runPreloader();
    $('.alert-holder-share').html('');
    if($('#new-receiver').val().length != 0){
      var email = $('#new-receiver').val();
      var template_id = $(this).data('template');
      $.post('/add-share', { _token: $('meta[name=csrf-token]').attr('content'), template_id: template_id, email: email })
      .done(function(response){
        var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          $('.shared-list').append('<div class="row"><div class="col-sm-12"><a href="javascript:void(0)" class="remove-from-sharing" data-user="' + responseJson.user_id + '" data-template="' + template_id + '"><i class="fa fa-times icon-red"></i></a>&nbsp;&nbsp;&nbsp;' + email + '</div></div>');
          $('#new-receiver').val('');
        }
        else{
          $('.alert-holder-share').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
        }
        stopPreloader();
      })
      .fail(function(response){
        $('.alert-holder-share').html('<div class="alert alert-danger">Wystąpił błąd połączenia z serwerem</div>');
        stopPreloader();
      });
    }
    else{
      $('.alert-holder-share').html('<div class="alert alert-danger">Musisz wpisac adres e-mail osoby, której chcesz udostępnić ten szablon</div>');
      stopPreloader();
    }
  });
});
