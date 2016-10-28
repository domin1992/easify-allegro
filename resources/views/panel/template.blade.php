@extends('layouts.master')

@section('title', 'Twój szablon')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      @if(isset($error) && $error != '')
        <div class="alert alert-danger">{{ $error }}</div>
      @endif
      <h1>Twój szablon</h1>
      <article>
        <div class="row">
          <div class="col-sm-6">
            <object data="/visualization/{{ $template->hash }}.pdf" type="application/pdf" class="pdf-visualization">
              <p>Najwyraźniej nie posiadasz wtyczki odpowiadającej za odtworzenie PDF.</p>
              <p>Spokojnie, możesz otworzyc dokument bezpośrednio <a href="/visualization/{{ $template->hash }}.pdf">tutaj</a>.</p>
            </object>
          </div>
          <div class="col-sm-6">
            <div class="divider">
              <h3>
                @if($owner)
                  Uzupełnij informacje o szablonie
                @else
                  Informacje o szablonie
                @endif
              </h3>
              <form class="form-horizontal">
                <div class="form-group">
                  <label for="template-name" class="col-sm-3 control-label">Nazwa szablonu</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="template-name" placeholder="Nazwa" value="{{ $template->name }}" @if(!$owner)disabled="disabled"@endif>
                  </div>
                </div>
                <div class="form-group">
                  <label for="template-version" class="col-sm-3 control-label">Wersja</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="template-version" value="{{ $template->version }}" @if(!$owner)disabled="disabled"@endif>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Utworzono</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="{{ date_format($template->created_at, 'd.m.Y H:i:s') }}" disabled="disabled">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Symbole</label>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="var-start" class="col-sm-3 control-label">od</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="var-start" value="{{ $template->var_start }}" @if(!$owner)disabled="disabled"@endif>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="var-end" class="col-sm-3 control-label">do</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="var-end" value="{{ $template->var_end }}" @if(!$owner)disabled="disabled"@endif>
                      </div>
                    </div>
                  </div>
                </div>
                @if(!$owner)
                <div class="form-group">
                  <label class="col-sm-3 control-label">Właściel</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="{{ $realOwner }}" disabled="disabled">
                  </div>
                </div>
                @endif
                @if($owner)
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <div class="alert-holder-template"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <a href="javascript:void(0)" class="btn btn-custom-orange save-template" data-template="{{ $template->id }}">Zapisz</a>
                  </div>
                </div>
                @endif
              </form>
            </div>
            @if($owner)
            <div class="divider">
              <h3>Udostępnij szablon</h3>
              <div class="shared-list">
                @if(count($sharedIds) > 0 && count($sharedEmails) > 0)
                  @for($i = 0; $i < count($sharedIds); $i++)
                  <div class="row">
                    <div class="col-sm-12">
                      <a href="javscript:void(0)" class="remove-from-sharing" data-user="{{ $sharedIds[$i] }}" data-template="{{ $template->id }}"><i class="fa fa-times icon-red"></i></a>&nbsp;&nbsp;&nbsp;{{ $sharedEmails[$i] }}
                    </div>
                  </div>
                  @endfor
                @endif
              </div>
              <div class="alert-holder-share"></div>
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Adres e-mail</label>
                  <div class="col-sm-7">
                    <input type="email" class="form-control" id="new-receiver" placeholder="przykladowy@adres.pl">
                  </div>
                  <div class="col-sm-2">
                    <a href="javascript:void(0)" class="btn btn-custom-orange add-share" data-template="{{ $template->id }}">Dodaj</a>
                  </div>
                </div>
              </form>
            </div>
            @endif
            <div class="divider">
              <h3>Utwórz dokument</h3>
              <a href="{{ URL::to('/utworz-dokument?id='.$template->id) }}" class="btn btn-custom-orange">Utworz dokument z tego szablonu</a>
            </div>
            @if($owner)
            <div class="divider">
              <h3>Aktualizuj szablon</h3>
              <form action="{{ URL::to('/aktualizuj-szablon') }}" method="post" enctype="multipart/form-data">
                @if(isset($errors))
                  @foreach($errors as $error)
                    @foreach($error as $err)
                      <div class="alert alert-danger">{{ $err }}</div>
                    @endforeach
                  @endforeach
                @endif
                <input type="file" name="files[]" id="filer_input">
                <p><small class="tip">Tylko pliki z rozszerzeniem html, lub htm</small></p>
                <input type="hidden" name="template" value="{{ $template->id }}">
                <input type="submit" value="Wyslij" id="upload-file" class="btn btn-custom-orange">
                {!! csrf_field() !!}
              </form>
            </div>
            <h3>Usuń szablon</h3>
            <form action="{{ URL::to('/usun-szablon') }}" method="post">
              <input type="hidden" name="template_id" value="{{ $template->id }}">
              {!! csrf_field() !!}
              <a href="javascript:void(0)" class="btn btn-custom-remove" id="del-template">Usuń</a>
            </form>
            @endif
          </div>
        </div>
      </article>
    </div>
  </div>
</div>
<div class="modal fade del-template-confimation">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Potwierdź</h4>
      </div>
      <div class="modal-body">
        <p>Ta funkcja bezpowrotnie usunie ten szablon z Twojego konta i z kont użytkoników, którym go udostępniłeś. Czy na pewno chcesz to zrobić?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-cancel" data-dismiss="modal">Nie</button>
        <button type="button" id="del-template-confirm" class="btn btn-custom-remove">Tak, na pewno</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')
<script src="{{ URL::asset('js/share.js') }}"></script>
<script src="{{ URL::asset('js/set-template.js') }}"></script>
<script src="{{ URL::asset('js/del-template.js') }}"></script>
@endsection
