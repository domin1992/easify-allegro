@extends('layouts.master')

@section('title', 'Ustawienia')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Ustawienia</h1>
      <div class="divider">
        <h3>Zmień hasło</h3>
        <div class="row">
          <div class="col-sm-6">
            <form method="post" action="{{ URL::to('/zmien-haslo') }}" class="form-horizontal">
              @if(isset($error))
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="alert alert-danger">
                      {{ $error }}
                    </div>
                  </div>
                </div>
              @endif
              @if(isset($success) && $success && isset($msg))
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="alert alert-success">
                      {{ $msg }}
                    </div>
                  </div>
                </div>
              @else
                <div class="form-group">
                  <label for="old-password" class="col-sm-5 control-label">Aktualne hasło</label>
                  <div class="col-sm-7">
                    <input type="password" class="form-control" name="old_password" id="old-password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password" class="col-sm-5 control-label">Nowe hasło</label>
                  <div class="col-sm-7">
                    <input type="password" class="form-control" name="password" id="password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password-confirmation" class="col-sm-5 control-label">Powtórz nowe hasło</label>
                  <div class="col-sm-7">
                    <input type="password" class="form-control" name="password_confirmation" id="password-confirmation">
                  </div>
                </div>
                {!! csrf_field() !!}
                <div class="form-group">
                  <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-custom-orange">Ustaw nowe hasło</button>
                  </div>
                </div>
              @endif
            </form>
          </div>
        </div>
      </div>
      <div class="divider">
        <h3>Usuń konto</h3>
        <a href="javascript:void(0)" class="btn btn-custom-remove" id="delete-acc">Usuń konto</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade delete-confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Potwierdź</h4>
      </div>
      <div class="modal-body">
        <p>Zdecydowałeś się na usunięcie swojego konta. Spowoduje to wykasowanie wszelkiej Twojej działalności z serwisu. Aby dokończyć proces, wpisz swoje hasło i zatwierdź.</p>
        <div class="error-holder"></div>
        <form class="form-horizontal">
          <div class="form-group">
            <label for="pass-del" class="col-sm-3 control-label">Hasło</label>
            <div class="col-sm-7">
              <input type="password" class="form-control" id="pass-del">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-cancel" data-dismiss="modal">Jednak zachowam konto</button>
        <button type="button" id="delete-confirm" class="btn btn-custom-remove">Potwierdzam</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')
<script src="{{ URL::asset('js/delete-acc.js') }}"></script>
@endsection
