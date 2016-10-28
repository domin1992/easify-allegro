@extends('layouts.master')

@section('title', 'Blog')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>Blog</h2>
      <div class="blog-wrapper">
        @forelse($blogs as $blog)
          <div class="blog">
            <h3><a href="{{ URL::to('/blog/'.$blog->id) }}">{{ $blog->title }}</a></h3>
            <p><small>{{ $blog->created_at }}</small></p>
            <p>{{ str_limit(strip_tags($blog->text), 100, '...') }}</p>
          </div>
        @empty
          <h5>Brak wpisów</h5>
        @endforelse
      </div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Vertical EA 2 -->
<ins class="adsbygoogle"
	 style="display:inline-block;width:728px;height:90px"
	 data-ad-client="ca-pub-2180140997733350"
	 data-ad-slot="6010047627"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
      <div class="paginations text-center">
        <nav>
          <ul class="pagination">

          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/paginator.js') }}"></script>
@endsection
