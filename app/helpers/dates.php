<?php 

function create_readable_date(string $date) {

	$date = new \DateTime($date);

	$minute_seconds  = 60;
	$hour_seconds    = 3600;
	$day_seconds     = 86400;
	$month_days      = $day_seconds * (int) $date->format("t");
	$year_days       = (bool) $date->format("L") ? $day_seconds * 366 : $day_seconds * 365;

	$date_timestamp    = $date->getTimestamp();
	$current_timestamp = time();

	$total_diff = (int) ($current_timestamp - $date_timestamp);

	// Return seconds
	if($total_diff < $minute_seconds) {
		return "Few seconds ago";
	}
	// Return minutes
	else if($total_diff >= $minute_seconds && $total_diff < $hour_seconds) {
		$time = (int) floor($total_diff / $minute_seconds);

		if($time === 1) return "A minute ago";

		return $time . " minutes ago";
	}
	// Return hours
	else if($total_diff >= $hour_seconds && $total_diff < $day_seconds) {
		$time = (int) floor($total_diff / $hour_seconds);

		if($time === 1) return "A hour ago";

		return $time . " hours ago";
	}
	// Return days
	else if($total_diff >= $day_seconds && $total_diff < $month_days) {
		$time = (int) floor($total_diff / $day_seconds);

		if($time === 1) return "A day ago";
		if($time < 7) return $time . " days ago";
		if($time >= 7 && $time < 14) return "A week ago";
		if($time >= 14 && $time < 21) return "2 weeks ago";
		if($time >= 21 && $time < 28) return "3 weeks ago";
		else return "4 weeks ago";

	}
	// Return months
	else if($total_diff >= $month_days && $total_diff <= $year_days) {
		$time = (int) floor($total_diff / $month_days);
		if($time === 1) return "A month ago";

		return $time . " months ago";
	// Return years
	} else {
		$time = (int) floor($total_diff / $year_days);
		if($time === 1) return "A year ago";

		return $time . " years ago";
	}

}