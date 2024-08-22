@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Личный кабинет') }}</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <h3> <p class="text-center">Редактирование личных данных</p></h3>
                        <p class="text-center">  Вы вошли как вебмастер</p>                
                        <h3> <p class="text-center">Смена никнейма:</p></h3>                         
                    
                        <form method="POST" action="{{ route('change.name') }}">
                            @csrf 
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Новый никнейм:</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name">
                                </div>
                                @error('name')
                                    <p class="text-danger"> {{ $message }} </p> 
                                @enderror
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary"> Сменить </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        @if(session()->has('error'))
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="alert alert-danger">
                                        <h5> <p class="text-center">{{ session()->get('error') }}</p></h5>
                                    </div>
                                </div>
                            </div>
                        @endif   
                        @if(session()->has('success'))
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="alert alert-success">
                                        <h5> <p class="text-center">{{ session()->get('success') }}</p></h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h3> <p class="text-center">Смена пароля:</p></h3>
                        <form method="POST" action="{{ route('change.password') }}">
                            @csrf 
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Текущий пароль</label> 
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password">
                                </div>
                                @error('current_password')
                                    <p class="text-danger"> {{ $message }} </p> 
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Новый пароль</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">
                                </div>
                            </div>
                            @error('password')
                                <p class="text-danger"> {{ $message }} </p> 
                            @enderror

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                                </div>
                            </div>
                            @error('password_confirmation')
                                <p class="text-danger"> {{ $message }} </p> 
                            @enderror
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">  Сменить </button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection