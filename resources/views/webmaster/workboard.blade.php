@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Рабочий стол') }}</div>
                <div class="card-body">              
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">      
                        <h3> <p class="text-center">Добро пожаловать, {{ Auth::user()->name }}! </p></h3>
                        <p class="text-center">  Вы вошли как вебмастер </p> 
                            <div class="row justify-content-center">
                                <div class="row col-sm-6">
                                    <a href="{{ route('webmaster.show') }}" class="btn btn-primary" role="button" aria-disabled="true">Статистика</a>
                                </div>
                            </div> 
                        <div class="row"> <div><p class="text-center"></p></div> </div>             {{--Для пробела --}}
                    @if ($offer->isEmpty()) 
                        <div class="row">
                            <div class="col"><h3><p class="text-center">Вы не подписаны ни на один оффер.</p></h3></div> 
                        </div>
                    @else 
                        <div class="row">
                            <h3><p class="text-center">Офферы, на которые вы подписаны:</p></h3>
                        </div>  
                    @foreach ($offer as $item)
                        <div class="row p-3">                   <!-- padding 3 -->
                            <div class="col-8"> 
                                <div class="card">
                                    <!-- оформляем карточку оффера как ссылку, по клику на которую будет выходить ссылка-->
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#Modal{{$item->id}}" style="text-decoration:none; color:inherit">
                                        <div class="card-header mt-2">
                                                <h3><p class="text-center"> {{ $item->title}}   </p> </h3>
                                        </div>
                                        <div class="card-body text-white bg-secondary bg-gradient">
                                            <div class="list-group">      
                                                <h4> <p class="text-center"> Тема: {{ $item->topic}} </p> </h4>  
                                                <h4> <p class="text-center"> Цена: {{ $item->cpc}} р за переход. Подписчиков:  {{ $item->count}} </p>  </h4>                                                
                                            </div> 
                                        </div> 
                                    </a> 
                                </div>
                            </div>
                                    <!-- Модальное окно при клике на карточку оффера -->
                                    <div class="modal fade" id="Modal{{$item->id}}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="ModalLabel">Ваша ссылка для этого оффера: </h1>
                                                </div>
                                                <div class="modal-body">
                                                    <h2> http://127.0.0.1:8000/api/link/{{ $item->offer_idEncoded }}/{{$user_idEncoded}}</h2>
                                                </div>
                                                <div class="modal-footer">
                                                        <!-- кнопка закрытия модального окна-->
                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#Modal{{$item->id}}">
                                                            Закрыть
                                                          </button> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <div class="col">
                                <form action="{{ route('webmaster.update', $item->id) }}" method="post"> 
                                    @csrf
                                    <input type="submit" class="btn btn-danger" value="Отписаться" name="unsubscribe" >
                                </form>    
                            </div>
                        </div>
                        @endforeach
                    @endif 
                    <div class="row"> <div><p class="text-center"></p></div> </div>             {{--Для пробела --}}  
                    <div class="row">
                        <div class="col"><h3><p class="text-center">Доступные офферы:</p></h3></div> 
            </div>
                @foreach ($offer_allowed as $item)
                    <div class="row p-3">
                        <div class="col-8"> 
                            <div class="card"> 
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
                        </div>
                    <div class="col">  
                        <form action="{{ route('webmaster.update', $item->id) }}" method="post" id="submit-button">    
                            @csrf
                            <!-- Модальное окно с ссылкой -->
                            <div class="modal fade" id="Modal{{$item->id}}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="ModalLabel">Ваша ссылка для размещения на вашем сайте:</h1>
                                        </div>
                                        <div class="modal-body">
                                            <h2> http://127.0.0.1:8000/api/link/{{ $item->offer_idEncoded }}/{{$user_idEncoded}}</h2>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- кнопкой закрытия в модальном окне отправляем форму-->
                                            <input type="submit" class="btn btn-secondary" value="Закрыть" name="subscribe" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- кнопка для активации модального окна с ссылкой-->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Modal{{$item->id}}">
                                Подписаться
                            </button> 
                        </form>   
                    </div>
                </div>
                @endforeach
                    </div>      <!--class="card-body"-->             
                </div>      <!-- class="card-body" -->
            </div>      <!-- class="card" -->
        </div>      <!--  class="col-md-8"-->
    </div>      <!-- class="row justify-content-center">  -->
</div>  <!-- class="container" -->

@endsection


