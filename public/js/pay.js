$(document).ready(function(){
  //Bitcoin
  $('#package').change(function(){
    if(('#main-form').data('method') == 'bitcoin'){
      $('#package-description').fadeOut();
      if($(this).val() != 0){
        $.post('/get-current-price', { _token: $('meta[name=csrf-token]').attr('content'), package: $(this).val() })
        .done(function(response){
          var responseJson = $.parseJSON(response);
          if(responseJson.success == 1){
            var price = responseJson.price;
            price = price.toFixed(2);
            price = price.toString();
            price = price.replace(".", ",");
            priceBtc = responseJson.price / currentBtc;
            priceBtc = priceBtc.toFixed(10);
            $('#package-description').html('<h4>Cena:</h4><p>' + price + ' zł</p><h3>Do zapłaty</h3><h4>' + priceBtc + ' BTC</h4>');
            $('#package-description').fadeIn();
          }
        })
        .fail(function(response){
          //Co jak się nie udało
        });
      }
    }
  });

  $('.bitcoin-wallet-btn-holder').delegate('#save-bitcoin-address', 'click', function(){
    $.post('/set-bitcoin-address', { _token: $('meta[name=csrf-token]').attr('content'), address: $('#wallet-address').val() })
    .done(function(response){
      var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          $('#wallet-address').prop('disabled', true);
          $('.bitcoin-wallet-btn-holder').html('<a href="javascript:void(0)" id="edit-bitcoin-address"><small>edytuj</small></a>');
        }
    })
    .fail(function(response){
      //Co jak się nie udało
    });
  });

  $('.bitcoin-wallet-btn-holder').delegate('#edit-bitcoin-address', 'click', function(){
    $('#wallet-address').prop('disabled', false);
    $('.bitcoin-wallet-btn-holder').html('<a href="javascript:void(0)" class="btn btn-custom-orange" id="save-bitcoin-address">Zapisz</a>');
  });

  $('#pay-final').click(function(){
    $.post('/is-bitcoin-address', { _token: $('meta[name=csrf-token]').attr('content') })
    .done(function(response){
      var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          if(responseJson.exists == 1){
            if($('#package').val() != 0){
              $.post('/get-current-price', { _token: $('meta[name=csrf-token]').attr('content'), package: $('#package').val() })
              .done(function(response){
                var responseJson = $.parseJSON(response);
                if(responseJson.success == 1){
                  var price = responseJson.price;
                  priceBtc = responseJson.price / currentBtc;
                  priceBtc = priceBtc.toFixed(10);
                  $('#to-pay').html(priceBtc + ' BTC');
                  $('#main-form').fadeOut();
                  $('#final').fadeIn();
                  $.post('/declare-payment', { _token: $('meta[name=csrf-token]').attr('content'), package: $('#package').val(), price: priceBtc, method: $('#main-form').data('method') });
                }
              })
              .fail(function(response){
                //Co jak się nie udało
              });
            }
            else{
              $('.error-holder').html('<div class="alert alert-danger">Musisz wybrać pakiet');
            }
          }
          else{
            $('.error-holder').html('<div class="alert alert-danger">Musisz wpisać swój adres portfela Bitcoin');
          }
        }
        else{
          //Co jak się nie udało
        }
    })
    .fail(function(response){
      //Co jak się nie udało
    });
  });

  //Paypal
  $('.paypal-wallet-btn-holder').delegate('#save-paypal-address', 'click', function(){
    $.post('/set-paypal-address', { _token: $('meta[name=csrf-token]').attr('content'), address: $('#wallet-address').val() })
    .done(function(response){
      var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          $('#wallet-address').prop('disabled', true);
          $('.paypal-wallet-btn-holder').html('<a href="javascript:void(0)" id="edit-paypal-address"><small>edytuj</small></a>');
        }
    })
    .fail(function(response){
      //Co jak się nie udało
    });
  });

  $('.paypal-wallet-btn-holder').delegate('#edit-paypal-address', 'click', function(){
    $('#wallet-address').prop('disabled', false);
    $('.paypal-wallet-btn-holder').html('<a href="javascript:void(0)" class="btn btn-custom-orange" id="save-paypal-address">Zapisz</a>');
  });

  $('#pay-final-paypal').click(function(){
    var payFinalPaypal = $(this);
    $.post('/is-paypal-address', { _token: $('meta[name=csrf-token]').attr('content') })
    .done(function(response){
      var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          if(responseJson.exists == 1){
            if($('#package').val() != 0){
              $.post('/declare-payment', { _token: $('meta[name=csrf-token]').attr('content'), package: $('#package').val(), method: $('#main-form').data('method') });
              $(payFinalPaypal).closest('form').submit();
            }
            else{
              $('.error-holder').html('<div class="alert alert-danger">Musisz wybrać pakiet');
            }
          }
          else{
            $('.error-holder').html('<div class="alert alert-danger">Musisz wpisać swój adres portfela PayPal');
          }
        }
        else{
          //Co jak się nie udało
        }
    })
    .fail(function(response){
      //Co jak się nie udało
    });
  });
});
