#!/usr/bin/env php
<?php

require '../vendor/autoload.php';

use Carbon\Carbon;

function getDates()
{
	$f = fopen('php://stdin', 'r');

	while ($line = trim(fgets($f))) {
	  yield $line;
	}

	fclose($f);
}

foreach (getDates() as $dateIn) {
	$date = Carbon::parse($dateIn);
	echo $date->format('Y-m-d H:m:i') . "\n";
}
// if (empty($argv[1])) {
// 	echo "[date] | convert-dates.php [date]\n\n";
// 	exit(1);
// }


