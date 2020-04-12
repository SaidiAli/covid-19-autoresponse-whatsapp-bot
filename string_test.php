<?php
$arr = [
    'one' => 1,
    'two' => 2,
    'three' => 3
];

$str = implode(' ', $arr);
foreach ($arr as $key => $value) {
    print_r($key.' : '. $value."\n");
}
