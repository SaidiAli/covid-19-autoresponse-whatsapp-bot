<?php
$arr = [
    'one' => 1,
    'two' => 2,
    'three' => 3
];

$str = implode(' ', $arr);

    if(!(in_array(4, $arr))) {
        print_r('works');
    }
