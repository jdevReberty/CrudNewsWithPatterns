@extends('white_template.layouts.app', ['page' => __('Tables'), 'pageSlug' => 'tables'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            @if (!$errors->isEmpty())
                @foreach ($errors->messages() as $key => $item)
                <div class="alert alert-danger" role="alert">
                    {{ $item[0] }}
                </div> 
                @endforeach
            @endif
            <div class="card-header">
                <h4 class="card-title">
                     <a href="{{route('news.index')}}">Notícias</a> 
                     <i class="tim-icons icon-double-right"></i> {{$news->title}}</h4>
            </div>
            <div class="card-body">
                <h2>{{$news->title}}</h2>
                <h5>{{ $news->content }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
