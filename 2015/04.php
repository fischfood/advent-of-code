<?php

/**
 * Day 04: TITLE
 */

// The usual
$data = file_get_contents('data/data-04.txt');
$sample_a = 'abcdef';
$sample_b = 'pqrstuv';

$key = $data;

// Part One
function part_one($key) {
    for ( $i = 0; $i < INF; $i++ ) {
        
        $hash = md5( $key . $i );

        if ( substr( $hash, 0, 5) === '00000' ) {
            return sprintf( 'The lowest integer for five zeroes is %d with a hash of %s', $i, $hash );
        }
    }
}

// Part Two
function part_two($key) {
	# Do More Things
}

echo PHP_EOL . 'Day 04: TITLE' . PHP_EOL;
echo 'Part 1: ' . part_one($key) . PHP_EOL;
echo 'Part 2: ' . part_two($key) . PHP_EOL . PHP_EOL;