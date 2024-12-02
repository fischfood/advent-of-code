<?php

/**
 * Day 09: All in a Single Night
 */

// The usual
$data = file_get_contents('data/data-09.txt');
//$data = file_get_contents('data/data-09-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include( '../functions.php' );

// Part One
function part_one($dataset) {

    $distances = [];
    $map = [];

    foreach( $dataset as $d ) {
        list( $from_to, $distance ) = explode( ' = ', $d );
        list( $from, $to ) = explode( " to ", trim($from_to) );

        $map[$from][] = $to;
        $map[$to][] = $from;

        $distances[$from][$to] = $distance;
        $distances[$to][$from] = $distance;
    }

    $shortestDistances = find_all_routes($map, $distances);
    $shortest = PHP_INT_MAX;
    
    foreach( $shortestDistances as $sd ) {
        if ( $sd['distance'] < $shortest ) {
            $shortest = $sd['distance'];
        }
    }

    echo $shortest;
}

// Part Two
function part_two($dataset) {
	$distances = [];
    $map = [];

    foreach( $dataset as $d ) {
        list( $from_to, $distance ) = explode( ' = ', $d );
        list( $from, $to ) = explode( " to ", trim($from_to) );

        $map[$from][] = $to;
        $map[$to][] = $from;

        $distances[$from][$to] = $distance;
        $distances[$to][$from] = $distance;
    }

    $shortestDistances = find_all_routes($map, $distances);
    $longest = 0;
    
    foreach( $shortestDistances as $sd ) {
        if ( $sd['distance'] > $longest ) {
            $longest = $sd['distance'];
        }
    }

    echo $longest;
}

echo PHP_EOL . 'Day 09: All in a Single Night' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;