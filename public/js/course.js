var currentBtc = 0;
$(document).ready(function(){

  if($('#course').length){
    getCurrentBitcoin();
    setInterval(getCurrentBitcoin(), 10000);
  }

  function getCurrentBitcoin(){
    $.get('/get-current-bitcoin', { _token: $('meta[name=csrf-token]').attr('content') })
    .done(function(response){
      var responseJson = $.parseJSON(response);
      $('#course').html('<h2>' + (responseJson.last).toFixed(2).toString().replace('.', ',') + ' PLN<small> / 1 BTC</small></h2>');
      currentBtc = responseJson.last;
    })
    .fail(function(response){
      $('#course').text('Nie można pobrać danych');
    })
  }
});
