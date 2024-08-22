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
                        <div class="row"> 
                            <h4> <p align="center"> Статистика </p> </h4>
                        </div> 

                        <!-- выпадающее окно выбора периода-->
                        <div class="row mb-3">
                            <label for="period" class="col-md-4 col-form-label text-md-end"> Выберите период </label>
                            <div class="col-md-6">
                                <select class="form-select" id="period" name="period">
                                <option value="day">день</option>
                                <option value="month">месяц</option>
                                <option value="year">год</option>
                            </select>
                            </div>
                        </div>

                        <table id="table" class="table table-bordered data-table" style="margin-top: 30px;">
                            <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Количество <br/> переходов</th>
                                    <th>Количество <br/> выданных ссылок</th>
                                    <th>Количество нелегальных <br/> переходов</th>
                                    <th>Статус</th>
                                    <th>Доход, руб</th> 
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr id="total">
                                <th colspan="5">Итого:</th>
                                <td></td>
                                </tr>
                            </tfoot>
                        </table>

                       <a href="{{ route('admin.workboard' ) }} "  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"> <p style="text-align:center"> Вернуться назад<p></a>  
                   </div>     {{--card-body --}}
                </div>      {{--card --}}
            </div>
    </div>      {{-- <div class="row justify-content-center"> --}}
</div>      {{--class="container" --}}

<script>
    $(document).ready(function(){ 
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

        var period = 'day';            // вызов ajax для первой загрузки страницы
        ajax(period);                  // период по умолчанию = день

        var select = document.querySelector('#period');        // селектор выбора периода
        select.addEventListener('change',function(){
            $("#table tbody").children().remove();             // очистка таблицы при смене периода
        var period = select.value;                              // 'day', 'month', 'year'
        ajax(period);                                           // получение данных для таблицы через функцию ajax
        });
    })
   
    // функция получения данных для таблицы
    // аргументы - 'day', 'month', 'year' 
    function ajax(period) {
        $.ajax({                  
            url: '{{ route('admin.ajax' ) }}',              
            type: 'POST',
            dataType: 'json',
            data: {
                period: period,
            },
            success: function(data) {
                var sum =0 ; 
                $.each(data.offers, function (key, value) {
                    var $is_actived = value.is_actived ? "активен" : "отключен";
                    $("#table tbody").append("<tr><td>"+value.title+"</td><td>"+value.clicks+"</td><td>"+value.refs+"</td><td>"+value.illegalClicks+"</td><td>"+$is_actived+"</td><td>"+(value.clicks*value.cpc*0.2).toFixed(2)+"</td></tr>");
                    sum = sum + value.clicks*value.cpc*0.2            // считаем общую сумму расходов
                });
                sum = (sum).toFixed(2); 
                $("#total td:nth-child(2)").html(sum);
            }  
        });
    }
    </script>
@endsection



