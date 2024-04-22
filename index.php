<?php

use App\User\Admin;
use App\User\Enum\AdminLevel;
use App\User\Member;

require_once __DIR__.'/vendor/autoload.php';

$m1 = new Member('Ben', 'Ben', 'abcd1234', 36);
$m2 = new Member('Tom', 'Tom', 'abcd1234', 25);
$a1 = new Admin('Paul', 'Paul', 'admin1234', 56, AdminLevel::Admin);

echo Member::count()."\n";
echo Admin::count()."\n";

unset($m2);

echo Member::count()."\n";
