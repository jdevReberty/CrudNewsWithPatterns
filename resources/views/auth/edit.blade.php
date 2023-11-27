@extends('white_template.layouts.app')

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
            <h4 class="card-title pb-0"> Editar Perfil</h4>
        </div>
        <div class="card-body">
            <form class="form" method="post" action="{{ route('user.update', ['user' => $user->id]) }}">
                @csrf
                <input type="hidden" name="device_name" value="create_user">
                <div class="card-body">
                    <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Nome') }}" value="{{ old('name') ?? $user->name }}">
                        @include('white_template.alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email') }}" value="{{ $user->email }}" readonly>
                        @include('white_template.alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ _('Senha') }}">
                        @include('white_template.alerts.feedback', ['field' => 'password'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-md btn-block">{{ _('Salvar') }}</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection
