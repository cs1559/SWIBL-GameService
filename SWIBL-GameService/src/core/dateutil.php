<?php
namespace swibl\core;

class DateUtil {

    static function dateConvertForInput($date) {
        return self::dateconvert($date,1);
    }
    static function dateConvertForOutput($date) {
        return self::dateconvert($date,2);
    }
    
    /**
     * The dateconvert method will convert a date value to a specific format based on the database function.
     * Available functions supported is for INSERT and UPDATE type operations.
     * 
     * @param unknown $date
     * @param unknown $func
     * @return NULL|string
     */
    private function dateconvert($date,$func=2) {
        
        // Trim the date element.
        $date = substr($date,0,10);
        // Replace any "/" with "-"
        $date = str_replace("/", "-", $date);

        $currentFormat = 0;
        
        // If no date was given, return null
        if ($date == null) 
            return null;

            
//         if (preg_match('/\d{4}-\d{2}-\d{2}/',$date)) {
//             return $date;
//         }
            
        // Try to identify what format was provided.
        if (preg_match('/\d{2}-\d{2}-\d{4}/',$date)) {
            list($seg1, $seg2, $year) = preg_split('/\/|-/', $date);
            $fld1 = (int) $seg1;
            $fld2 = (int) $seg2;
            
            if ( $fld1 <= 12) {
                $currentFormat = 1;
            } elseif ($fld2 > 12) {
                $currentFormat = 2;
            } else {
                $currentFormat = 3;
            }
        }
        
        if ($func == 1){ //insert conversion
            if ($currentFormat == 0) {
                return $date;
            }
            list($month, $day, $year) = preg_split('/\/|-/', $date);
            $date = $year . "-" . $month . "-" . $day;
            return $date;
        }
        if ($func == 2){ //output conversion
            if ($currentFormat == 1) {
                list($month, $day, $year) = preg_split('/[-.]/', $date);
                $date = "$month/$day/$year";
                return $date;
            }
              list($year, $month, $day) = preg_split('/[-.]/', $date);
              $date = "$month/$day/$year";
              return $date;
        }
//         if ($func == 3){ //output conversion  - used to trim timestamp field
//               $dt = substr($date,0,10);
//               list($year, $month, $day) = preg_split('/\/|-/', $dt);
//               $date = $month . "/" . $day . "/" . $year;
//               return $date;
//         }        
    }
}