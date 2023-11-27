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
                <h4 class="card-title"> Editar Notícia <i class="tim-icons icon-double-right"></i> {{$news->title}}</h4>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('news.update', ['id' => $news->id])}}" method="post">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{$news->id}}">
                    <div class="card-body">
                        <label for="title">Título</label>
                        <div class="input-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input class="form-control" type="text" name="title" id="title" placeholder="Informe o título da notícia" value="{{ $news->title }}" />
                        </div>
                        <label for="content">Conteúdo</label>
                        <div class="input-group{{ $errors->has('content') ? ' has-danger' : '' }}"> 
                            <textarea class="form-control" name="content" id="content" >{{ $news->content }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-md btn-lg mr-2">{{ _('Salvar') }}</button>
                        <a href="{{ route('news.index') }}">
                            <span class="btn btn-secondary btn-md btn-lg">{{ _('Cancelar') }}</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
