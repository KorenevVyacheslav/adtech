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
                        <p class="text-center">  Вы вошли как администратор </p>                             
                    <div class="row">
                        <div class="col">
                            <div class="d-grid gap-2">                                
                            </div>
                        </div>
                            <div class="col-6 col-md-7">                            
                                <a href="{{ route('admin.show') }}" class="btn btn-primary" role="button" aria-disabled="true">Статистика</a>
                            </div>
                            <div class="row"> 
                                <div><p></p></div> 
                            </div>             {{--Для пробела --}}
                            <h3> <p class="text-center">Список пользователей:</p></h3>
                            <table class="table table-bordered data-table" style="margin-top: 30px;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Имя</th>
                                        <th>Email</th>
                                        <th>Роль</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr id="{{ $user->id }}" >
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                            @if ($user->is_active) 
                                                <td>активен</td>
                                            @else 
                                                <td>не активен</td>
                                            @endif
                                            @if ($user->role=='admin')
                                                <td> </td>
                                            @else <td>
                                                @if ($user->is_active)
                                                    <a href="javascript:void(0)" data-url="{{ route('admin.update') }}"                    
                                                    class="btn btn-danger dizactivate" id=" {{ $user->id }}" >Отключить</a> 
                                                @else 
                                                    <a href="javascript:void(0)" data-url="{{ route('admin.update') }}"                    
                                                    class="btn btn-primary activate" id=" {{ $user->id }}" >Включить</a>
                                                @endif 
                                                </td>
                                            @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //отключение пользователя
        $(document).on('click', '.dizactivate', function() {
            var updateURL = $(this).data('url');                  
            var trObj = $(this);                                 
            var id =  $(this).closest('tr').attr('id');           // получаем id строки = id user
                $.ajax({
                    url: updateURL,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        act: 'diz'
                    },
                    success: function(data) {
                        $("#"+ id +" " + "td:nth-child(5)").html('<td>не активен</td>');    // заменяем статус на странице
                        // вставляем кнопку активации                     
                        $("#"+ id +" " + "td:nth-child(6)").html('<a href="javascript:void(0)" data-url="{{ route("admin.update") }}" class="btn btn-primary activate" id=" {{ $user->id }}" >Включить</a>');
                    }
                });
        });

        //активация пользователя
        $(document).on('click', '.activate', function() {
            var updateURL = $(this).data('url');                  
            var trObj = $(this);                                    
            var id =  $(this).closest('tr').attr('id');           
                $.ajax({
                    url: updateURL,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        act: 'act'
                    },
                    success: function(data) {
                        $("#"+ id +" " + "td:nth-child(5)").html('<td>активен</td>');        // заменяем статус на странице
                        // вставляем кнопку деактивации
                        $("#"+ id +" " + "td:nth-child(6)").html('<a href="javascript:void(0)" data-url="{{ route("admin.update") }}" class="btn btn-danger dizactivate" id=" {{ $user->id }}" >Отключить</a>');
                    }
                });
        });
    });
</script>
@endsection