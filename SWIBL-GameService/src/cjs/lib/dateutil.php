<?php
namespace cjs\lib;

class DateUtil {
    
    static function dateconvert($date,$func) {
        if ($date == null)
            return null;
            if ($func == 1){ //insert conversion
                list($month, $day, $year) = preg_split('/\/|-/', $date);
                $date = $year . "-" . $month . "-" . $day;
                return $date;
            }
            if ($func == 2){ //output conversion
                list($year, $month, $day) = preg_split('/[-.]/', $date);
                $date = "$month/$day/$year";
                return $date;
            }
            if ($func == 3){ //output conversion  - used to trim timestamp field
                $dt = substr($date,0,10);
                list($year, $month, $day) = preg_split('/\/|-/', $dt);
                $date = $month . "/" . $day . "/" . $year;
                return $date;
            }
            
    }
}