<?php

/**
 * Day 15: Lens Library
 */

// The usual
$data = file_get_contents('data/data-15.txt');
//$data = file_get_contents('data/data-15-sample.txt');

$strings = explode(",", $data);

// Part One
function part_one($strings) {

    $sum = 0;

    foreach( $strings as $string ) {

        $characters = str_split( $string );

        $total = 0;
        foreach( $characters as $char ) {
            
            $total += ord($char);
            $total = $total * 17;
            $total = $total % 256;
        }

        $sum += $total;
    }

    echo $sum;
}

// Part Two
function part_two($strings) {
	# Do More Things
}

echo PHP_EOL . 'Day 15: Lens Library' . PHP_EOL . 'Part 1: ';
part_one($strings);
echo PHP_EOL . 'Part 2: ';
part_two($strings);
echo PHP_EOL . PHP_EOL;