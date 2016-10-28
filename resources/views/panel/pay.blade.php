@extends('layouts.master')

@section('title', 'Zapłać')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Zapłać</h1>
      <h4>
        @if($method == 'bitcoin')
          Bitcoin
        @elseif($method == 'paypal')
          PayPal
        @else
          UPS! Coś poszło nie tak
        @endif
      </h4>
      @if($method == 'bitcoin')
        <div class="row">
          <article class="col-sm-9">
            <form class="form-horizontal" id="main-form" data-method="{{ $method }}">
              <div class="form-group">
                <label for="package" class="control-label col-sm-3">Wybierz Pakiet</label>
                <div class="col-sm-9">
                  <select id="package" class="form-control">
                    <option value="0" selected>Wybierz</option>
                    @foreach($pricing as $price)
                      <option value="{{ $price->id }}">{{ $price->package }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div id="package-description" class="small-box">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="wallet-address" class="control-label col-sm-3">Dodaj swój adres portfela Bitcoin</label>
                @if($userWallet == null || $userWallet->bitcoin == '')
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="wallet-address" placeholder="np. 1pyYYXXsswfni24nrf4i">
                  </div>
                  <div class="col-sm-2 bitcoin-wallet-btn-holder">
                    <a href="javascript:void(0)" class="btn btn-custom-orange" id="save-bitcoin-address">Zapisz</a>
                  </div>
                @else
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="wallet-address" value="{{ $userWallet->bitcoin }}" disabled>
                  </div>
                  <div class="col-sm-2 bitcoin-wallet-btn-holder">
                    <a href="javascript:void(0)" id="edit-bitcoin-address"><small>edytuj</small></a>
                  </div>
                @endif
              </div>
              <div class="form-group">
                <div class="col-sm-12 error-holder"></div>
              </div>
              <div class="form-group">
                <label for="package" class="control-label col-sm-3">Zadeklaruj wpłatę</label>
                <div class="col-sm-9">
                  <a href="javascript:void(0)" class="btn btn-custom-orange" id="pay-final">Płacę</a>
                </div>
              </div>
            </form>
            <div class="small-box" id="final" style="display: none;">
              <div class="row">
                <div class="col-sm-6">
                  <h3>Do zapłaty</h3>
                  <h1 style="color: #333;" id="to-pay"></h1>
                </div>
                <div class="col-sm-6 text-center">
                  <img src="/img/bitcoin-qr.png" alt="Bitcoin Address Easify Allegro" />
                  19ezbstsNnbxmq74jK9AqPYYyVKy7U6Aup
                </div>
              </div>
            </div>
          </article>
          <aside class="col-sm-3">
            <h5>Aktulany kurs Bitcoin (Bitmarket.pl)</h5>
            <p id="course"></p>
          </aside>
        </div>
      @elseif($method == 'paypal')
        @if(empty($realization) || $realization != 'done')
          @if($realization == 'undone')
            <div class="alert alert-danger">Wpłata się nie powiodła. Spróbuj ponownie.</div>
          @endif
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="main-form" class="form-horizontal" target="_top" data-method="{{ $method }}">
            <div class="form-group">
              <label for="package" class="control-label col-sm-3"><input type="hidden" name="on0" value="Wybierz pakiet">Twój adres e-mail w PayPal</label>
              @if($userWallet == null || $userWallet->paypal == '')
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="wallet-address" placeholder="np. twoj@adres.pl">
                </div>
                <div class="col-sm-2 paypal-wallet-btn-holder">
                  <a href="javascript:void(0)" class="btn btn-custom-orange" id="save-paypal-address">Zapisz</a>
                </div>
              @else
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="wallet-address" value="{{ $userWallet->paypal }}" disabled>
                </div>
                <div class="col-sm-2 paypal-wallet-btn-holder">
                  <a href="javascript:void(0)" id="edit-paypal-address"><small>edytuj</small></a>
                </div>
              @endif
            </div>
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="V2UXAL486QHTA">
            <div class="form-group">
              <label for="package" class="control-label col-sm-3"><input type="hidden" name="on0" value="Wybierz pakiet">Wybierz pakiet</label>
              <div class="col-sm-9">
                <select name="os0" id="package" class="form-control">
                  <option value="3 Dokumenty">3 Dokumenty 2,40 PLN</option>
                	<option value="5 Dokumentow">5 Dokumentów 3,90 PLN</option>
                	<option value="10 Dokumentow">10 Dokumentów 7,80 PLN</option>
                	<option value="15 Dokumentow">15 Dokumentów 11,70 PLN</option>
                	<option value="25 Dokumentow">25 Dokumentów 19,60 PLN</option>
                	<option value="Nielimitowane">Nielimitowane 29,90 PLN</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12 error-holder"></div>
            </div>
            <input type="hidden" name="currency_code" value="PLN">
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <!-- <input type="image" src="http://easify-allegro.xyz/img/btn-custom-orange.png" border="0" name="submit" alt="PayPal – Płać wygodnie i bezpiecznie">
                <img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1"> -->
                <a href="javascript:void(0)" id="pay-final-paypal" class="btn btn-custom-orange">Płacę</a>
              </div>
            </div>
          </form>
        @else
          <div class="alert alert-success">Pomyślnie przekazano wpłatę na konto Easify Allegro. Gdy tylko zostanie zaksięgowana otrzymasz swój pakiet.</div>
        @endif
      @else
        UPS! Coś poszło nie tak
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/course.js') }}"></script>
<script src="{{ URL::asset('js/pay.js') }}"></script>
@endsection
