<?php

namespace Drupal\event_day_counter;

class EventDayCounter {
  public function getDaysDiff($event_date) {

    $event_time = strtotime($event_date);
    $current_time = time();

    $current_day_start = strtotime('today', $current_time);
    $event_day_start = strtotime('today', $event_time);

    $days_diff = round(($event_day_start - $current_day_start) / (24 * 60 * 60));
    return $days_diff;
    }
}

