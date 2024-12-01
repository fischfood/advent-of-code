<?php

/**
 * Day 01: Historian Hysteria
 */

// The usual
$data = file_get_contents('data/data-01.txt');
//$data = file_get_contents('data/data-01-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
    $a = [];
    $b = [];
    $total = 0;

    foreach( $dataset as $row ) {
        $row = explode( '   ', $row );
        $a[] = $row[0];
        $b[] = $row[1];
    }

    asort($a);
    asort($b);

    $a = array_values( $a );
    $b = array_values ($b );

    foreach( $a as $k => $v ) {
        $val = abs( $v - $b[$k] );
        $total += $val;
    }

    echo $total;
}

// Part Two
function part_two($dataset) {

    $a = [];
    $b = [];
    $total = 0;

    foreach( $dataset as $row ) {
        $row = explode( '   ', $row );
        $a[] = $row[0];
        $b[] = $row[1];
    }

    $b_list = array_count_values( $b );
    $total = 0;

    foreach( $a as $val ) {
        if ( array_key_exists( $val, $b_list ) ) {
            $total += $val * ($b_list[$val]);
        }
    }

    echo $total;
}

echo PHP_EOL . 'Day 01: Historian Hysteria' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;