<?php

/**
 * Day 03: Mull It Over
 */

// The usual
$data = file_get_contents('data/data-03.txt');
// $data = file_get_contents('data/data-03-sample.txt');
// $data = file_get_contents('data/data-03-sample-2.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $data;
include_once( '../functions.php' );

// Part One
function part_one($dataset) {
    $total = 0;

    preg_match_all( '/mul\([0-9]{1,3},[0-9]{1,3}\)/', $dataset, $matches );
    
    foreach( $matches[0] as $m ) {
        list($first, $second) = explode( ',', $m );
        
        preg_match_all('/\d+/', $first, $a);
        preg_match_all('/\d+/', $second, $b);

        $total += ( $a[0][0] * $b[0][0] );
    }

    echo $total;
}

// Part Two
function part_two($dataset) {
	$total = 0;

    preg_match_all( '/mul\([0-9]{1,3},[0-9]{1,3}\)|(do\(\))|(don\'t\(\))/', $dataset, $matches );

    $enabled = true;
    
    foreach( $matches[0] as $m ) {
        if ( str_contains($m, 'mul') && $enabled ) {

            list($first, $second) = explode( ',', $m );

            preg_match_all('/\d+/', $first, $a);
            preg_match_all('/\d+/', $second, $b);
    
            $total += ( $a[0][0] * $b[0][0] );
        } elseif ( $m === 'do()' ) {
            $enabled = true;
        } else {
            $enabled = false;
        }
    }

    echo $total;
}

echo PHP_EOL . 'Day 03: Mull It Over' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;