<?php

/**
 * Day 12: Hot Springs
 */

// The usual
$data = file_get_contents('data/data-12.txt');
$data = file_get_contents('data/data-12-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    
    return find_spring_possibilities( $rows );
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function find_spring_possibilities( $rows ) {
    $totals = [];

    foreach ( $rows as $num => $row ) {
        [$springs_string, $known_string] = explode( ' ', $row );

        $springs = array_values( array_filter( explode( '.', $springs_string ) ) );
        $known = explode( ',', $known_string );

        $possible_positions = 1;

        // If spring length can only fit known
        if ( strlen( $springs_string ) === array_sum( str_split( str_replace(',',1,$known_string ) ) ) ) {
            $totals[$num + 1] = 1;
            continue;
        }

        // If Same Count

    }

    print_r( $totals );
}

echo PHP_EOL . 'Day 12: Hot Springs' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;