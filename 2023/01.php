<?php

/**
 * Day 01: Trebuchet?!
 */

// The usual
$data = file_get_contents('data/data-01.txt');
//$data = file_get_contents('data/data-01-sample.txt');
//$data = file_get_contents('data/data-01-sample-2.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One - Combine first and last digits and add them to total
function part_one($dataset) {
    $total = 0;
    foreach( $dataset as $d ) {
        $nums = str_split( preg_replace( '/[^0-9]/', '', $d ) );

        // Combine first and last numbers, even if there is only one
        $number = intval( $nums[0] . end($nums) );
        $total += $number;
    }

    echo $total;
}

// Part Two - Combine first and last numbers (digit OR text) and add them to total
function part_two($dataset) {
	$total = 0;
    foreach( $dataset as $d ) {

        $num_strings = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        // $num_digits = [1,2,3,4,5,6,7,8,9];
        // I Initially read it as eightwo would only be 8, so I tried to replace in order. This was wrong, it should be 8 and 2

        // Convert the text to a digit, but leave the rest of the number in case characters overlap
        $num_d_s = ['one1one', 'two2two', 'three3three', 'four4four', 'five5five', 'six6six', 'seven7seven', 'eight8eight', 'nine9nine'];

        $d2 = str_replace( $num_strings, $num_d_s, $d );
        $nums = str_split( preg_replace( '/[^1-9]/', '', $d2 ) );

        $number = intval( $nums[0] . end($nums) );

        //echo PHP_EOL . $number . ' - - - ' . $d . '(' . implode('',$nums) . ') = (' . $nums[0] . ' + ' . end($nums) . ')';
        $total += $number;
    }

    echo $total;
}

echo PHP_EOL . 'Day 01: Trebuchet?!' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;