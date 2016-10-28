@extends('layouts.master')

@section('title', 'Panel administratora')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>Panel administratora</h2>
    </div>
  </div>
  <div class="row">
    @include('admin.sidebar')
    <div class="col-sm-10">
      <h4>Blog</h4>
      <div class="table-responsive">
        <table class="table table-responsive table-hover table-striped">
          <tr>
            <th>id</th>
            <th>Tytuł</th>
            <th>Tekst</th>
            <th>Autor</th>
            <th>Utworzono</th>
            <th>Opcje</th>
          </tr>
          @forelse($blogs as $blog)
          <tr>
            <td>{{ $blog->id }}</td>
            <td>{{ $blog->title }}</td>
            <td>{{ strip_tags($blog->text) }}</td>
            <td>{{ $blog->author }}</td>
            <td>{{ date_format(new DateTime($blog->created_at), 'd-m-Y H:i:s') }}</td>
            <td><a href="{{ URL::to('/ea-admin/blog/usun-wpis/'.$blog->id) }}" class="icon-bordered"><i class="fa fa-trash"></i></a>&nbsp;<a href="{{ URL::to('/ea-admin/blog/wpis/'.$blog->id) }}" class="icon-bordered"><i class="fa fa-pencil-square-o"></i></a></td>
          </tr>
          @empty
          <tr>
            <td colspan="6">Nie ma żadnych wpisów</td>
          </tr>
          @endforelse
        </table>
      </div>
      <div class="text-right">
        <a href="{{ URL::to('/ea-admin/blog/wpis') }}" class="btn btn-custom-orange">Nowy wpis</a>
      </div>
    </div>
  </div>
</div>
@endsection
