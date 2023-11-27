@extends('white_template.layouts.app', ['class' => 'register-page', 'page' => _('Register Page'), 'contentClass' => 'register-page'])

@section('content')
    <div class="row">
        <div class="{{ Auth::check() ? "col-md-12" : "col-md-7" }} mx-auto">
            <div class="card card-register card-white">
                @if (!Auth::check())
                    <div class="card-header">
                        <img class="card-img" src="{{ asset('assets') }}/img/card-primary.png" alt="Card image">
                        <h4 class="card-title">{{ _('Cadastrar') }}</h4>
                    </div>
                @else 
                @foreach ($errors->messages() as $key => $item)
                    <div class="alert alert-danger" role="alert">
                        {{ $item[0] }}
                    </div> 
                @endforeach
                <div class="card-header mt-2 ml-2 mb-0 pb-0">
                    <h4 class="">{{ _('Cadastrar') }} <i class="tim-icons icon-double-right"></i> Usuário</h4>
                </div>              
                @endif
                {{ $errors->has('errors') ? $errors['errors'] : '' }}
                <form class="form {{ Auth::check() ? "col-md-6 mx-auto" : "" }}" method="post" action="{{ Auth::check() ? route('user.admin.store') : route('user.store') }}">  
                    @csrf
                    <input type="hidden" name="device_name" value="create_user">
                    <div class="card-body">
                        <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Nome') }}" value="{{ old('name') }}">
                            @include('white_template.alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-email-85"></i>
                                </div>
                            </div>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email') }}" value="{{ old('email') }}">
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
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ _('Confirmar Senha') }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-md btn-block">{{ _('Cadastrar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
