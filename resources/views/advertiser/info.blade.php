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
                            <p align="center"> Ваш оффер успешно создан! </p>
                            <p align="center"> Сейчас вернёмся в личный кабинет... </p>
                            </h4>
                        </div> 
                    </div>     {{--card-body --}}
                </div>      {{--class="card" --}}
            </div>
        </div>
    </div>  {{--class="container" --}}

<script>

setTimeout(function (){ window.location.href= '/advertiser/workboard';},3000);
</script>
@endsection