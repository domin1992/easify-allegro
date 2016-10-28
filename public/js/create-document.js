$(document).ready(function(){
  var created = false;
  var document_id = 0;
  var document_hash = '';
  var form;

  $('#document-create-anchor').click(function(){
    runPreloader();
    form = $(this).closest('.document-create-form');
    createDocument(form, 'generate');
  });

  $('#document-preview-anchor').click(function(){
    runPreloader();
    form = $(this).closest('.document-create-form');
    createDocument(form, 'preview');
  });

  $('#create-document-confirm').click(function(){
    runPreloader();
    $('.create-document-confimation').modal('hide');
    $.post('/generate-document', { _token: $('meta[name=csrf-token]').attr('content'), document_id: document_id })
      .done(function(response){
        var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          window.open('/generuj-dokument?id='+document_id, '_self', false);
        }
        else{
          stopPreloader();
          $('.alert-holder').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
        }
      })
      .fail(function(response){
        stopPreloader();
        $('.alert-holder').html('<div class="alert alert-danger">Błąd połączenia z serwerem, spróbuj później</div>');
      });
  });

  function createDocument(form, option){
    if(created){
      var template_id = $(form).data('template');
      var document_name = $('#document-name').val();
      var data = collectAllChanges();
      setDocument(document_id, data, option, form);
    }
    else{
      var template_id = $(form).data('template');
      var document_name = $('#document-name').val();
      var data = collectAllChanges();
      addDocument(template_id, document_name, data, option, form);
    }
  }

  function collectAllChanges(){
    var jsonArray = '';
    var changesData = [];
    $('.document-create-form textarea').each(function(index){
      var item = {
        "name": $(this).data('variable'),
        "value": $(this).val()
      };
      changesData.push(item);
    });
    jsonArray = JSON.stringify({data: changesData});
    return jsonArray;
  }

  function addDocument(template_id, document_name, data, option, form){
    clearErrors();
    $.post('/add-document', { _token: $('meta[name=csrf-token]').attr('content'), template_id: template_id, document_name: document_name, data: data })
      .done(function(response){
        var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          if(option === 'preview'){
            stopPreloader();
            window.open('/visualization/' + responseJson.document_hash + '.pdf');
            document_hash = responseJson.document_hash;
            document_id = responseJson.document_id;
            created = true;
          }
          else if(option === 'generate'){
            stopPreloader();
            document_hash = responseJson.document_hash;
            document_id = responseJson.document_id;
            created = true;
            $('.create-document-confimation').modal('show');
          }
        }
        else{
          stopPreloader();
          $('.alert-holder').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
        }
      })
      .fail(function(response){
        stopPreloader();
        $('.alert-holder').html('<div class="alert alert-danger">Błąd połączenia z serwerem, spróbuj później</div>');
      });
  }

  function setDocument(document_id, data, option, form){
    clearErrors();
    $.post('/set-document', { _token: $('meta[name=csrf-token]').attr('content'), document_id: document_id, data: data })
      .done(function(response){
        var responseJson = $.parseJSON(response);
        if(responseJson.success == 1){
          if(option === 'preview'){
            stopPreloader();
            window.open('/visualization/' + document_hash + '.pdf');
          }
          else if(option === 'generate'){
            stopPreloader();
            $('.create-document-confimation').modal('show');
          }
        }
        else{
          stopPreloader();
          $('.alert-holder').html('<div class="alert alert-danger">' + responseJson.error + '</div>');
        }
      })
      .fail(function(response){
        stopPreloader();
        $('.alert-holder').html('<div class="alert alert-danger">Błąd połączenia z serwerem, spróbuj później</div>');
      });
  }

  function clearErrors(){
    $('.alert-holder').html('');
  }
});
