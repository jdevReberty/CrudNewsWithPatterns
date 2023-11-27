@extends('white_template.layouts.app', ['page' => __('Tables'), 'pageSlug' => 'tables'])

@section('content')
<div class="row">
  <div class="col-md-12 d-flex justify-content-end mb-2">
    <a href="{{route('news.create')}}">
      <button class="btn">Cadastrar Notícia</button>
    </a>
  </div>
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
        <h4 class="card-title"> Notícias</h4>
      </div>
      <div class="d-flex justify-content-end mr-2">
        <input class="col-3 form-control" type="text" id="search_with_filter" placeholder="Pesquisar..." value="{{$filterValues}}">
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>
                <th>
                  Título
                </th>
                <th>
                  Conteúdo
                </th>     
                <th>
                  Ações
                </th>         
              </tr>
            </thead>
            <tbody>
              @foreach ($news->items() as $item)
                <tr>
                  <td>
                    <p class="text_overflow_ellipsis">
                      {{$item->title}}
                    </p>
                  </td>
                  <td >
                    <p class="text_overflow_ellipsis" title="{{$item->content}}">
                      {{$item->content}}
                    </p>
                  </td>  
                  <td class="d-flex">
                    <a href="{{route('news.show', ['id' => $item->id])}}">
                      <button class="btn btn-icon btn-primary mr-1" title="Visualizar">
                         <i class="tim-icons icon-notes"></i>
                      </button>
                    </a>
                    <a href="{{route('news.edit', ['id' => $item->id])}}">
                      <button class="btn btn-icon btn-warning mr-1" title="Editar">
                         <i class="tim-icons icon-pencil"></i>
                      </button>
                    </a>
                    <a href="{{route('news.delete', ['id' => $item->id])}}">
                      <button class="btn btn-icon btn-danger" title="Excluir">
                         <i class="tim-icons icon-trash-simple"></i>
                      </button>
                    </a>
                  </td>                
                </tr>    
              @endforeach
            </tbody>
          </table>
          @if ($news->total() == 0)
            <div class="alert alert-warning" role="alert">
              Nenhuma notícia cadastrada por {{ Auth::user()->name }}
            </div> 
          @endif
        </div>

      </div>
    </div>
  </div>
</div>

<x-pagination :paginator="$news" :appends="$filter"/>
@endsection

@section('local_scripts')
  <script src="{{asset('js/seach_pagination.js')}}"></script>
@endsection
