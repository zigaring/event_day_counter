<?php

namespace Drupal\event_day_counter;

class EventDayCounter {
    public function getDaysDiff($event_date) {

      $event_time = strtotime($event_date); 
      $current_time = time(); 

      $event_hour = date('H', $event_time);  //check for hour of event

      $current_day_start = strtotime('today', $current_time);
      
      if($event_hour >= 22){
        $event_day_start = strtotime('+2 hours', $event_time); 
      }else{
        $event_day_start = strtotime('today', $event_time);
      }

      $days_diff = round(($event_day_start - $current_day_start) / (24 * 60 * 60));
      return $days_diff;
      }
}

