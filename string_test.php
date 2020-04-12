<?php
$arr = [
    'one' => 1,
    'two' => 2,
    'three' => 3
];

$str = implode(' ', $arr);
foreach ($arr as $key => $value) {
    $a[] = $key . ' : ' . $value . "\n";
}

print_r(implode("\n", $a));
