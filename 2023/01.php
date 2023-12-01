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

        // Only give me digits
        $nums = str_split( preg_replace( '/[^0-9]/', '', $d ) );

        // Combine first and last numbers, even if there is only one
        $number = intval( $nums[0] . end($nums) );

        // Add to the Total
        $total += $number;
    }

    echo $total;
}

// Part Two - Combine first and last numbers (digit OR text) and add them to total
function part_two($dataset) {
	$total = 0;
    foreach( $dataset as $d ) {

        $num_strings = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

        // Convert the text to a digit, but leave the rest of the number in case characters overlap
        // Ex. eightwo should become 82, so when we convert 2, we need a t and the front, and 0 at the end.
        // I just added the whole string for clarity instead of o1e, t2o, t3e, etc.
        $num_d_s = ['one1one', 'two2two', 'three3three', 'four4four', 'five5five', 'six6six', 'seven7seven', 'eight8eight', 'nine9nine'];

        // String to digit string conversions
        $d2 = str_replace( $num_strings, $num_d_s, $d );

        // Only give me digits
        $nums = str_split( preg_replace( '/[^1-9]/', '', $d2 ) );

        // Combine first and last numbers, even if there is only one
        $number = intval( $nums[0] . end($nums) );

        // Add to the total
        $total += $number;
    }

    echo $total;
}

echo PHP_EOL . 'Day 01: Trebuchet?!' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;