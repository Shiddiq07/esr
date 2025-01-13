<?php

if (!function_exists('camelToSlug')) {
	/**
	 * Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
	 * @param    string   $str    String in camel case format
	 * @return   string           $str Translated into underscore format
	 */
	function camelToSlug($str, $glue = '_') {
		$slug = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1' . $glue, $str));
		$explode = explode($glue, $slug);

		if (count($explode) < 2) {
			$slug = strtolower($str);
		}

		return $slug;
	}
}

if (!function_exists('slugToCamel')) {
	/**
	 * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
	 * @param    string   $str                     String in underscore format
	 * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
	 * @return   string                            $str translated into camel caps
	 */
	function slugToCamel($str, $glue = '_', $capitalise_first_char = false) {
		$camel_case = str_replace($slug, '', ucwords($str, $slug));

		if ($capitalise_first_char === false) {
			$camel_case = lcfirst($camel_case);
		}

		return $camel_case;
	}
}

if (!function_exists('slugToName')) {
	/**
	 * Translates a string with underscores into camel case (e.g. first_name -&gt; First Name)
	 * @param    string   $str                     String in underscore format
	 * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
	 * @return   string                            $str translated into camel caps
	 */
	function slugToName($str, $glue = '_') {
		$camel_case = str_replace($glue, ' ', $str);

		return ucwords($camel_case);
	}
}

if (!function_exists('value')) {
	function value($value)
	{
		return $value instanceof Closure ? $value() : $value;
	}
}

if (!function_exists('def')) {
	function def($stack, $offset, $default = null)
	{
	    if (is_array($stack)) {
	        if (array_key_exists($offset, $stack)) {
	        	if (empty($stack[$offset])) {
	        		return $default;
	        	} else {
	            	return $stack[$offset];
	        	}
	        }
	    } elseif (is_object($stack)) {
	        if (property_exists($stack, $offset)) {
	        	if (empty($stack->{$offset})) {
	        		return $default;
	        	} else {
	            	return $stack->{$offset};
	        	}
	        } elseif ($stack instanceof ArrayAccess) {
	        	if (empty($stack[$offset])) {
	        		return $default;
	        	} else {
	            	return $stack[$offset];
	        	}
	        } elseif (method_exists($stack, '__isset')) {
	            if ($stack->__isset($offset)) {
	                if (method_exists($stack, '__get')) {
	                	if (empty($stack->__get($offset, $default))) {
			        		return $default;
			        	} else {
			            	return $stack->__get($offset, $default);
			        	}
	                }

	                if (empty($stack->$offset)) {
		        		return $default;
		        	} else {
		            	return $stack->$offset;
		        	}
	            }
	        } else {
	            return def((array) $stack, $offset, value($default));
	        }
	    }

	    return value($default);
  }
}

if (!function_exists('isWeekend')) {
	function isWeekend($date = null) {
		$date = empty($date) ? date('Y-m-d') : $date;

		return (date('N', strtotime($date)) >= 6);
	}
}

function diffDay($start, $end)
{
	$start = date_create(date('Y-m-d', strtotime($start)));
	$end = date_create(date('Y-m-d', strtotime($end)));
	$diff = date_diff($start, $end);

	return $diff->format("%d%") + 1;
}

/**
 * Count the number of working days between two dates.
 *
 * This function calculate the number of working days between two given dates,
 * taking account of the Public festivities, Easter and Easter Morning days,
 * the day of the Patron Saint (if any) and the working Saturday.
 * @link https://gist.github.com/massiws/9593008
 * 
 * @param   string  $date1    Start date ('YYYY-MM-DD' format)
 * @param   string  $date2    Ending date ('YYYY-MM-DD' format)
 * @param   boolean $workSat  TRUE if Saturday is a working day
 * @param   string  $patron   Day of the Patron Saint ('MM-DD' format)
 * @return  integer           Number of working days ('zero' on error)
 *
 * @author Massimo Simonini <massiws@gmail.com>
 */
function diffWorkDay($date1, $date2, $workSat = TRUE, $patron = NULL) {
	if (!defined('SATURDAY')) define('SATURDAY', 6);
	if (!defined('SUNDAY')) define('SUNDAY', 0);

	// Array of all public festivities
	// $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
	// The Patron day (if any) is added to public festivities
	// if ($patron) {
	// 	$publicHolidays[] = $patron;
	// }

	/*
	* Array of all Easter Mondays in the given interval
	*/
	$yearStart = date('Y', strtotime($date1));
	$yearEnd   = date('Y', strtotime($date2));

	for ($i = $yearStart; $i <= $yearEnd; $i++) {
		$easter = date('Y-m-d', easter_date($i));
		list($y, $m, $g) = explode("-", $easter);
		$monday = mktime(0,0,0, date($m), date($g)+1, date($y));
		$easterMondays[] = $monday;
	}

	$start = strtotime($date1);
	$end   = strtotime($date2);
	$workdays = 0;

	for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
		$day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
		$mmgg = date('m-d', $i);
		if (
			$day != SUNDAY
			// && !in_array($mmgg, $publicHolidays)
			&& !in_array($i, $easterMondays)
			&& !($day == SATURDAY && $workSat == FALSE)
		) {
			$workdays++;
		}
	}

	return intval($workdays);
}

/**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $array[] = $date->format($format); 
    }

    return $array;
}

/**
 * [getWorkDatesFromRange description]
 * @param   string  $date1    Start date ('YYYY-MM-DD' format)
 * @param   string  $date2    Ending date ('YYYY-MM-DD' format)
 * @param   boolean $workSat  TRUE if Saturday is a working day
 * @param   string  $patron   Day of the Patron Saint ('MM-DD' format)
 * @return  array             List of working dates
 */
function getWorkDatesFromRange($date1, $date2, $workSat = TRUE, $patron = NULL) {
	if (!defined('SATURDAY')) define('SATURDAY', 6);
	if (!defined('SUNDAY')) define('SUNDAY', 0);

	// Array of all public festivities
	// $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
	// The Patron day (if any) is added to public festivities
	// if ($patron) {
	// 	$publicHolidays[] = $patron;
	// }

	/*
	* Array of all Easter Mondays in the given interval
	*/
	$yearStart = date('Y', strtotime($date1));
	$yearEnd   = date('Y', strtotime($date2));

	for ($i = $yearStart; $i <= $yearEnd; $i++) {
		$easter = date('Y-m-d', easter_date($i));
		list($y, $m, $g) = explode("-", $easter);
		$monday = mktime(0,0,0, date($m), date($g)+1, date($y));
		$easterMondays[] = $monday;
	}

	$start = strtotime($date1);
	$end   = strtotime($date2);
	$workdays = [];

	for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
		$day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
		$mmgg = date('m-d', $i);
		if (
			$day != SUNDAY
			// && !in_array($mmgg, $publicHolidays)
			&& !in_array($i, $easterMondays)
			&& !($day == SATURDAY && $workSat == FALSE)
		) {
			$workdays[] = date('Y-m-d', $i);
		}
	}

	return $workdays;
}

if (!function_exists('isDate')) {
	function isDate($string)
	{
		return strtotime($string) !== false;
	}
}

if (!function_exists('multipleUnset')) {
	function multipleUnset($arrays, $keys)
	{
		foreach ($keys as $key) {
			if (array_key_exists($key, $arrays)) {
				unset($arrays[$key]);
			}
		}

		return $arrays;
	}
}

if (!function_exists('reArrayFiles')) {
	/**
	 * [reArrayFiles description]
	 * @see <https://www.php.net/manual/en/features.file-upload.multiple.php>
	 * @param  [type] &$file_post [description]
	 * @return [type]             [description]
	 */
	function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}
}

if (!function_exists('get_client_ip')) {
	function getClientIp() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
}

if (!function_exists('getInitials')) {
    function getInitials($string) {
        $words = explode(' ', $string);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }

        return $initials;
    }
}

if (!function_exists('formatNumber')) {
	function formatNumber($number, $dec = 0) {
	    $formatted = number_format($number, $dec);

	    // Hapus angka nol di belakang
	    $formatted = rtrim($formatted, '0'); // Hapus 0 di belakang
	    $formatted = rtrim($formatted, '.'); // Hapus titik jika ada di belakang

	    return $formatted; // ngilangin koma dan 0 kalo ada
	}
}
