@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Рабочий стол') }}</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <h3> <p class="text-center">Добро пожаловать, {{ Auth::user()->name }}! </p></h3>
                        <p class="text-center">  Вы вошли как рекламодатель </p> 
                        <div class="row">
                            <div class="col">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('advertiser.create') }}" class="btn btn-primary" role="button" aria-disabled="true">Создать оффер</a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('advertiser.show') }}" class="btn btn-primary" role="button" aria-disabled="true">Статистика</a>
                                </div>
                            </div>
                        </div>
                        <div class="row"> <div><p ></p></div> </div>             {{--Для пробела --}}
                        @if (!$offer->isEmpty()) 
                            <div class="row">
                                <h3><p class="text-center">Ваши офферы:</p></h3>
                            </div>  
                        @if ($count_active>0)
                                <div class="row">
                                    <div class="col"><h3><p id="text_active" class="text-center">Активные:</p></h3></div> 
                                </div>
                        @endif 
                        <div id="active">                      
                            @foreach ($offer as $item)
                                @if ($item->is_actived == true)
                                    <div class="row p-3" id="rowid{{ $item->id}}">               <!-- padding 3 -->
                                        <div class="col-8"> 
                                            <div class="card">
                                                <div class="card-header mt-2">
                                                    <h3><p class="text-center"> {{ $item->title}}   </p> </h3>
                                                </div>
                                                <div class="card-body text-white bg-secondary bg-gradient">
                                                        <div class="list-group">
                                                            <h4> <p class="text-center"> Тема: {{ $item->topic}} </p> </h4>  
                                                            <h4> <p class="text-center"> Цена: {{ $item->cpc}} р за переход. Подписчиков:  {{ $item->count}} </p>  </h4>                                             
                                                        </div> 
                                                </div>      
                                            </div>
                                        </div>
                                            <div class="col">   
                                                <a href="javascript:void(0)" data-url="{{ route('advertiser.update') }}"                    
                                                 class="btn btn-danger dizactivate" id="{{ $item->id}}" >Отключить</a> 
                                            </div>
                                    </div>  
                                @endif
                            @endforeach
                        </div>                
                        @if ($count_nonactive>0)
                            <div class="row">
                                <div class="col"><h3><p id="text_nonactive" class="text-center">Неактивные:</p></h3></div> 
                            </div>
                        @endif
                            <div id="dizactive">    
                            @foreach ($offer as $item)
                                @if ($item->is_actived == false)
                                    <div class="row p-3" id="rowid{{ $item->id}}">
                                        <div class="col-8">
                                            <div class="card"> 
                                                <div class="card-header mt-2">
                                                    <h3><p class="text-center"> {{ $item->title}}   </p> </h3>
                                                </div>
                                                <div class="card-body text-white bg-secondary bg-gradient">
                                                    <div class="list-group">
                                                        <h4><p class="text-center"> Тема: {{ $item->topic}} </p></h4>    
                                                        <h4><p class="text-center"> Цена: {{ $item->cpc}} р за переход. Подписчиков:  {{ $item->count}} </p></h4>                                              
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">   
                                            <a href="javascript:void(0)" data-url="{{ route('advertiser.update') }}"                    
                                            class="btn btn-success activate" id="{{ $item->id}}" >Активировать</a> 
                                        </div>
                                    </div>  
                                @endif
                            @endforeach 
                            </div>      
                        @else 
                            <div class="row">
                                <div class="col"><h3><p class="text-center">У вас нет офферов</p></h3></div> 
                            </div>
                        @endif                              
                    </div> {{--class="card-body"--}} 
                <a href="{{ url('/') }}"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"> <p style="text-align:center"> Вернуться на главную страницу<p></a>  
            </div>   {{--class = "card"--}}   
        </div>     {{--class = "col-md-8"--}}
    </div>  {{--class = row justify-content-center --}}
</div>  {{--class="container" --}}

<script>
    $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on('click', '.dizactivate', function() {
        var updateURL = $(this).data('url');                 
        var trObj = $(this);                                  
        var id =  $(this).attr('id');                         
        var div = document.getElementById("rowid"+ id);       // получаем строку <div class="row p-3" id="rowid{{ $item->id}}">

        // AJAX запрос на отключение оффера
        $.ajax({
            url: updateURL,    
            type: 'PATCH',
            dataType: 'json',
            data: {
                    id: id,
                    act: 'diz'
            },
            success: function(data) {
                $('#rowid'+id).remove();                        // убираем строку из активных
                $( "#dizactive" ).append(div);                  // добавляем удалённую строку к  <div id="dizactive">
                trObj.removeClass("btn btn-danger dizactivate");// меняем класс у кнопки
                trObj.addClass("btn btn-success activate");
                trObj.text('Активировать');                     // меняем текст кнопки

                var btn_success = $('.activate').length;        // считаем число элементов с кнопкой "Активировать"
                var btn_danger= $('.dizactivate').length;       // считаем число элементов с кнопкой "Отключить"
                if (!btn_danger) {
                    $('#text_active').hide();                   // если нет активных офферов скрываем надпись "активные" 
                }   else   { $('#text_active').show();}
                if (!btn_success) { 
                    $('#text_nonactive').hide();                // если нет неактивных офферов скрываем надпись "неактивные" 
                }   else   { $('#text_nonactive').show();}
            }
        });
    });

        // AJAX запрос на включение оффера
        $(document).on('click', '.activate', function() {
            var updateURL = $(this).data('url');                  
            var trObj = $(this);                                  
            var id =  $(this).attr('id');                         // получаем id оффера
            var div = document.getElementById("rowid"+ id);       // получаем строку <div class="row p-3" id="rowid{{ $item->id}}">
            // AJAX запрос на отключение оффера
            $.ajax({
                url: updateURL,
                type: 'PATCH',
                dataType: 'json',
                data: {
                    id: id,
                    act: 'act'
                },
                success: function(data) {
                    $('#rowid'+id).remove();                        // убираем строку из активных
                    $( "#active" ).append(div);                     // добавляем удалённую строку к  <div id="active">
                    trObj.removeClass("btn btn-success activate");  // меняем класс у кнопки
                    trObj.addClass("btn btn-danger dizactivate");
                    trObj.text('Отключить');                     // меняем текст кнопки
                    var btn_success = $('.activate').length;          // считаем число элементов с кнопкой "Активировать"
                    var btn_danger= $('.dizactivate').length;          // считаем число элементов с кнопкой "Отключить" 
                    if (!btn_danger) {
                        $('#text_active').hide();                   // если нет активных офферов скрываем надопись актовные 
                    } else   { $('#text_active').show();}

                    if (!btn_success) {
                        $('#text_nonactive').hide();               // если нет неактивных офферов скрываем надпись "неактивные" 
                    }   else   { $('#text_nonactive').show();}

                }
            });
        });
    });
   
</script>
@endsection

