@extends('layouts.master')

@section('title', 'Utwórz dokument')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Utwórz dokument</h1>
      <article>
        <form class="form-horizontal document-create-form" method="POST" action="{{ URL::to('/generuj-dokument') }}" data-template="{{ $template->id }}">
          <div class="form-group">
            <label for="document-name" class="col-sm-2 control-label">Nazwa dokumentu</label>
            <div class="col-sm-10">
              <input type="text" id="document-name" class="form-control" placeholder="Twoja nazwa dokumentu">
            </div>
          </div>
          @forelse($matching[1] as $key => $match)
          <div class="form-group">
            <label for="variable-{{ $key }}" class="col-sm-2 control-label">{{ $match }}</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="variable-{{ $key }}" data-variable="{{ $match }}" placeholder="Twoja tresc, ktora pokaze sie na aukcji w tym miejscu"></textarea>
            </div>
            <div class="col-sm-1">
              <p class="icon-holder">
                <a href="javascript:void(0)" class="insert-list-btn" data-anchor="variable-{{ $key }}">
                  <i class="fa fa-list-ul"></i>
                </a>
              </p>
              <p class="icon-holder">
                <a href="javascript:void(0)" class="insert-image-btn" data-anchor="variable-{{ $key }}">
                  <i class="fa fa-picture-o"></i>
                </a>
              </p>
              <p class="icon-holder">
                <a href="javascript:void(0)" class="insert-header-btn" data-anchor="variable-{{ $key }}">
                  <i class="fa fa-header"></i>
                </a>
              </p>
            </div>
          </div>
          @empty
            <p>Hmmm... dokument nie jest dobrze przygotowany, nie odnaleziono żadnych miejsc, w których można coś zmienić</p>
            <p>Przeczytaj <a href="{{ URL::to('/jak-dziala') }}">Jak działa</a>, aby dowiedzieć się jak przygotować szablon.</p>
          @endforelse
          <div class="form-group">
            <div class="alert-holder"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 text-right">
              <a href="javascript:void(0)" id="document-preview-anchor" class="btn btn-custom-orange">Podgląd</a>&nbsp;<a href="javascript:void(0)" id="document-create-anchor" class="btn btn-custom-orange">Zatwierdź</a>
            </div>
          </div>
        </form>
      </article>
    </div>
  </div>
</div>
<div class="modal fade create-document-confimation">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Potwierdź</h4>
      </div>
      <div class="modal-body">
        <p>Zdecydowałeś się na wygenerowanie Twojego dokumentu. Po kliknięciu w <strong>Potwierdzam</strong> otrzymasz kod źrodłowy z wypełnioną treścią. Upewnij się, że wszystkie pola zostały wypełnione prawidłowo, ponieważ poźniej nie będzie możliwości zmiany tych treści.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-cancel" data-dismiss="modal">Jeszcze się upewnię</button>
        <button type="button" id="create-document-confirm" class="btn btn-primary">Potwierdzam</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade insert-list">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Wstaw listę</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="list-form">
          <div class="form-group">
            <div class="col-sm-12 list-type">
              <div class="radio">
                <label>
                  <input type="radio" name="list_type" id="list-type-points" value="list_type_points" checked>
                  Wypunktowana
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="list_type" id="list-type-numbers" value="list_type_numbers">
                  Numerowana
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="list-row-0">
            </div>
          </div>
          <div id="list-values">
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <a href="javascript:void(0)" class="btn btn-custom-orange" id="list-add-row">Dodaj pozycję</a>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-cancel" data-dismiss="modal">Zamknij</button>
        <a href="javascript:void(0)" class="btn btn-custom-orange" id="list-save">Wstaw</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade insert-image">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Wstaw obraz</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="image-address" class="col-sm-3 control-label">Adres obrazu</label>
            <div class="col-sm-9">
              <input type="text" id="image-address" class="form-control" placeholder="http://przykład.pl/obrazek1.jpg">
            </div>
          </div>
          <div class="form-group">
            <label for="image-alternative" class="col-sm-3 control-label">Podpis obrazu</label>
            <div class="col-sm-9">
              <input type="text" id="image-alternative" class="form-control" placeholder="To jest przykładowy obrazek">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-cancel" data-dismiss="modal">Zamknij</button>
        <a href="javascript:void(0)" class="btn btn-custom-orange" id="image-save">Wstaw</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade insert-header">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Wstaw nagłówek</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="header-type" class="col-sm-3 control-label">Typ nagłówka</label>
            <div class="col-sm-9">
              <select class="form-control" id="header-type">
                <option value="1">H1</option>
                <option value="2">H2</option>
                <option value="3">H3</option>
                <option value="4">H4</option>
                <option value="5">H5</option>
                <option value="6">H6</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="header-text" class="col-sm-3 control-label">Treść nagłówka</label>
            <div class="col-sm-9">
              <input type="text" id="header-text" class="form-control" placeholder="Nagłówek">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-cancel" data-dismiss="modal">Zamknij</button>
        <a href="javascript:void(0)" class="btn btn-custom-orange" id="header-save">Wstaw</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')
<script src="{{ URL::asset('js/list-generator.js') }}"></script>
<script src="{{ URL::asset('js/insert-image.js') }}"></script>
<script src="{{ URL::asset('js/insert-header.js') }}"></script>
<script src="{{ URL::asset('js/create-document.js') }}"></script>
@endsection
