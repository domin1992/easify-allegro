@extends('layouts.master')

@section('title', 'Zwiększ limit')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Zwiększ limit</h1>
      <h4>Wybierz sposob płatności</h4>
      <article>
        <div class="row flex">
          <div class="payment-method">
            <a href="{{ URL::to('/zaplac?method=bitcoin') }}">
              <img src="https://bitcoin.org/img/icons/opengraph.png" alt="Bitcoin" />
            </a>
          </div>
          <div class="payment-method">
            <a href="{{ URL::to('/zaplac?method=paypal') }}">
              <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Paypal_2014_logo.png" alt="Bitcoin" />
            </a>
          </div>
          <!-- <div class="payment-method">
            <a href="{{ URL::to('/zaplac?method=przelewy24') }}">
              <img src="http://vignette3.wikia.nocookie.net/leagueoflegends/images/5/51/Przelewy24.png/revision/latest?cb=20140321163754&path-prefix=pl" alt="Bitcoin" />
            </a>
          </div>
          <div class="payment-method">
            <a href="{{ URL::to('/zaplac?method=sms') }}">
              <p class="big"><strong>SMS</strong></p>
            </a>
          </div> -->
        </div>
      </article>
    </div>
  </div>
</div>
@endsection
