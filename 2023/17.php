<?php

/**
 * Day 17: Clumsy Crucible
 */

// The usual
$data = file_get_contents('data/data-17.txt');
$data = file_get_contents('data/data-17-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    
    $get_grid = get_grid( $rows );
    //print_r( $get_grid );

    $start = ['0,0'];
    $end = [ count($get_grid[0]) . ',' . count( $get_grid) ];

    print_r( $start );
    print_r( $end );
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function get_grid( $rows ) {
    $grid = [];

    foreach( $rows as $rnum => $row ) {
        $nums = str_split( $row );

        $grid[$rnum] = $nums;
    }

    return $grid;
}

echo PHP_EOL . 'Day 17: Clumsy Crucible' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;