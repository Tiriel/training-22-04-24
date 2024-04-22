<?php

require __DIR__.'/User.php';
require __DIR__.'/AuthInterface.php';
require __DIR__.'/Member.php';
require __DIR__.'/AdminLevel.php';
require __DIR__.'/Admin.php';

$m1 = new Member('Ben', 'Ben', 'abcd1234', 36);
$m2 = new Member('Tom', 'Tom', 'abcd1234', 25);
$a1 = new Admin('Paul', 'Paul', 'admin1234', 56, AdminLevel::Admin);

echo Member::count()."\n";
echo Admin::count()."\n";

unset($m2);

echo Member::count()."\n";
