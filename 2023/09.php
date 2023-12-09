<?php

/**
 * Day 09: Mirage Maintenance
 */

// The usual
$data = file_get_contents('data/data-09.txt');
//$data = file_get_contents('data/data-09-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $next_numbers_sum = 0;

    foreach( $rows as $row ) {
        $all_numbers = extrapolate( $row );
        $rev_numbers = array_reverse( $all_numbers );

        $add_num = 0;
        foreach( $rev_numbers as $rev_lines ) {
            $last_num = array_pop( $rev_lines );
            $add_num = $add_num + $last_num;
        }

        $next_numbers_sum += $add_num;
    }

    echo $next_numbers_sum;
}

// Part Two
function part_two($rows) {
	$prev_numbers_sum = 0;

    foreach( $rows as $row ) {
        $all_numbers = extrapolate( $row );
        $rev_numbers = array_reverse( $all_numbers );

        $sub_num = 0;
        foreach( $rev_numbers as $rev_lines ) {
            $last_num = $rev_lines[0];
            $sub_num = $last_num - $sub_num;
        }

        $prev_numbers_sum += $sub_num;
    }

    echo $prev_numbers_sum;
}

function extrapolate( $row, $all_numbers = [] ) {
    
    $numbers = [];

    if ( ! is_array( $row ) ) {
        $row = explode( ' ', $row );
    }

    if ( empty( $all_numbers ) ) {
        $all_numbers[] = $row;
    }

    for ( $i = 0; $i < count($row) - 1; $i++ ) {
        $numbers[] = $row[$i + 1] - $row[$i];
    }

    $all_numbers[] = $numbers;

    if ( count( array_unique( $numbers ) ) === 1 && array_unique( $numbers)[0] === 0 ) {
        return $all_numbers;
    } else {
        return extrapolate( $numbers, $all_numbers );
    }


}


echo PHP_EOL . 'Day 09: Mirage Maintenance' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;