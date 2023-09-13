<?php

/**
 * Day 01: Not Quite Lisp
 */

// The usual
$data = file_get_contents('data/data-01.txt');

$sample_1a = '))(((((';
$sample_1b = ')())())';

$sample_2a = ')';
$sample_2b = '()())';

$dataset = $data;

// Part One - Going up and down floors
function part_one($dataset) {

    $open = substr_count( $dataset, '(' );
    $close = substr_count( $dataset, ')' );

    return sprintf('Santa will land on floor %d (%d Up and %d Down)', ( $open - $close ), $open, $close );

}

// Part Two - When does Santa reach the basement
function part_two($dataset) {
	$steps = str_split($dataset, 1);
    $start = 0;

    foreach ( $steps as $char => $s ) {
        if ( '(' === $s ) {
            $start++;
        } else {
            $start--;
        }

        if ( $start < 0 ) {
            return sprintf('Santa will reach the basement after %d moves.', $char + 1 );
        }
    }
}

echo PHP_EOL . 'Day 01: Not Quite Lisp' . PHP_EOL;
echo 'Part 1: ' . part_one($dataset) . PHP_EOL;
echo 'Part 2: ' . part_two($dataset) . PHP_EOL . PHP_EOL;