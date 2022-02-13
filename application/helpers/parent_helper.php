<?php
function getActiveMenu($major_id, $major) {
	if ($major_id == $major->id) {
		return ' w3-blue';
	}
	return null;
}

function countParentAll($stats) {
	return $stats->inject + $stats->not_inject + $stats->no_data;
}

function  percent($value, $all) {
	if (empty($all)) {
		return 0;
	}
	return round($value / $all * 100,1);
}
