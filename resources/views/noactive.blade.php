@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Личный кабинет') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row"> 
                            <h4>
                            <p align="center"> Ваша учетная запись была отключена </p>
                            <p align="center"> Для активации обратитесь к администратору сайта {{ $admin->email }} </p>
                            </h4>
                        </div> 
                    </div>     {{--card-body --}}
                    <a href="{{ url()->previous() }}"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"> <p style="text-align:center"> Вернуться назад<p></a>  
                </div>
            </div>     {{--card-body --}}
        </div>      {{--class="card" --}}
    </div>
</div>       {{--class="container" --}}
@endsection


