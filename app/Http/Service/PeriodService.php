<?php

namespace App\Http\Service;

use Carbon\Carbon;

class PeriodService                                 // сервис возвращает дату в формате Y-m-d H:i:s за вычетом заданного периода                   
{
    //используется в методах AjaxController
    public static function getperiod ($period){
        switch ($period)
        {
          case 'day':
              $period = Carbon::today()->subHours(24);
              break;
          case 'month':
               $period = Carbon::today()->subMonth(); 
              break;               
          case 'year':
                  $period = Carbon::today()->subYear(); 
              break;  
        } 
        return $period;
    }
    
}
