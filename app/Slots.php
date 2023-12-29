<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Slots extends Model
{
    protected $table = "slots";
    protected $fillable =[

        "name", "warehouse_id", "start_time", 'duration' , 'end_time' ,"is_active", "per_slot_order","start_day","end_day"
    ];

    // public function product()
    // {
    // 	return $this->belongsTo('App\Product');
    	
    // }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
    public function getEndDayAttribute($value){
        switch ($value) {
            case 1:
                $value = 'Monday';
                break;
            case 2:
                $value = 'Tuesday';
                break;
            case 3:
                $value = 'Wednesday';
                break;
            case 4:
                $value = 'Thursday';
                break;
            case 5:
                $value = 'Friday';
                break;
            case 6:
                $value = 'Saturday';
                break;
            case 7:
                $value = 'Sunday';
                break;
        }

        return $value;
    }

    public function getStartDayAttribute($value){
        switch ($value) {
            case 1:
                $value = 'Monday';
                break;
            case 2:
                $value = 'Tuesday';
                break;
            case 3:
                $value = 'Wednesday';
                break;
            case 4:
                $value = 'Thursday';
                break;
            case 5:
                $value = 'Friday';
                break;
            case 6:
                $value = 'Saturday';
                break;
            case 7:
                $value = 'Sunday';
                break;
        }

        return $value;
    }

    // public function checkActiveSlots($id){
    //     $slots = Slots::where('warehouse_id',$id)->where('is_active',1)->get();
    //     $count = $slots->count();
    //     // dd($slots);
    //     if($count >= 1){
    //         return true;
    //     }
    //     return false;

    // }
    public function checkActiveSlots($id){
        $slots = Slots::where('warehouse_id',$id)->where('is_active',1)->get();
        $count = $slots->count();
        // dd($slots);
        if($count >= 7){
            return true;
        }
        return false;

    }

    public static function getAvailableSlots($current, $start, $duration = 10, $warehous_id)
    {
        $warehouse = self
            ::where('warehouse_id', $warehous_id)
            ->where('is_active', 1)
            ->first();

        $comparison = $current;
        $date = Carbon::parse($start)->format("Y-m-d");
        $current_date = Carbon::parse($current)->format("Y-m-d");
        if(Carbon::parse($start)->isSameDay(Carbon::parse($current))){
            $date = $current_date;
            $comparison = $start;
        }
        $data = [];

        if($warehouse){
            $start_time = Carbon::parse($date.' '.$warehouse->start_time);
            $end_time = Carbon::parse($date.' '.$warehouse->end_time);
            
            $interval = CarbonInterval::minutes($duration);

            
            $current_time = $start_time;
            while ($current_time <= $end_time) {
                if ($current_time > Carbon::parse($comparison)) {
                    $data[] = $current_time->format('h:i A');
                }
                $current_time->add($interval);
            }
        }

        
        return $data;
    }
}
