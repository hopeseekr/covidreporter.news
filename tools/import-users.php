#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Console\Kernel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

$createLaravelApp = function(): \Illuminate\Foundation\Application
{
    $app = require __DIR__.'/../bootstrap/app.php';

    $app->make(Kernel::class)->bootstrap();

    return $app;
};

$app = $createLaravelApp();

function getUsers(): Generator
{
	$f = fopen('php://stdin', 'r');

	while ($line = trim(fgets($f))) {
	    $data = explode(',', $line);
        yield [
            'username'  => $data[0],
            'twitterId' => $data[1],
        ];
	}

	fclose($f);
}


foreach (getUsers() as $index => $userinfo) {
    $no = $index + 1;
    echo "$no. Importing $userinfo[username]...";
    try {
        User::query()->create([
            'username' => $userinfo['username'],
            'password' => $userinfo['twitterId'],
        ]);
    } catch (QueryException $e) {
        echo "already exists.";
        continue;
    } finally {
        echo "\n";
    }
}

// if (empty($argv[1])) {
// 	echo "[date] | convert-dates.php [date]\n\n";
// 	exit(1);
// }


