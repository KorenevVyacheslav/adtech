@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Личный кабинет') }}</div>
                    <div class="card-body">
                        <h3> <p class="text-center">Создайте Оффер</p></h3>
                        <form action=" {{ route('advertiser.store') }} " method="post">
                            @csrf    
                            <div class="mb-3">
                                <label for="title" class="form-label">Название:</label>
                                <input value="{{ old('title') }}" type="text" name="title" class="form-control" id="title" placeholder="Пилот">       
                            </div>
                            @error('title')
                                <p class="text-danger"> {{ $message }} </p> 
                            @enderror
                            <div class="mb-3">
                                <label for="cpc" class="form-label">Стоимость, руб за переход:</label>
                                <p> <input value="{{ old('cpc') }}" type="number" id="cpc" name="cpc" min="1" max="100" /> </p>
                                @error('cpc')
                                    <p class="text-danger"> {{ $message }} </p> 
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="url_" class="form-label">URL адрес:</label>
                                <textarea class="form-control" name="url_" id="url_" placeholder="https://google.com"></textarea>
                            </div>
                            @error('url_')
                                <p class="text-danger"> {{ $message }} </p> 
                            @enderror
                            <div class="mb-3">
                                <label for="role" class="form-label">Выберите тему:</label>
                                <select class="form-select" aria-label="Default select example" name="topic">
                                @foreach($topic as $item)
                                    <option value=" {{$item->title}} " > {{$item->title}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                        <button type="submit" class="btn btn-primary">Создать оффер</button>
                                </div>
                            </div>
                        </form>                
                    </div>     {{--card-body --}}
                <a href="{{ url()->previous() }}"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"> <p style="text-align:center"> Вернуться назад<p></a>  
            </div>
        </div>
</div>  {{--class="container" --}}
@endsection





