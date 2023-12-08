<?php

/**
 * Day 08: Haunted Wasteland
 */

// The usual
$data = file_get_contents('data/data-08.txt');
//$data = file_get_contents('data/data-08-sample.txt');
//$data = file_get_contents('data/data-08-sample-2.txt');
//$data = file_get_contents('data/data-08-sample-3.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $start = 'AAA';
    $end = 'ZZZ';

    [$directions, $paths] = get_direction_paths($rows);

    $dir = str_split( $directions );

    $i = 0;
    $total = 0;

    while ( $i < count( $dir ) ) {
        $total++;

        if ( $start !== $end ) {
            $start = $paths[$start][$dir[$i]];
        }

        if ( $i === count( $dir ) - 1 && $start !== $end ) {
            $i = 0;
            continue;
        }

        $i++;

    }

    echo $total; 
}

// Part Two
function part_two($rows) {
	
    [$directions, $paths, $starts, $ends] = get_direction_paths($rows);
    
    $dir = str_split( $directions );
    $path_to_z = [];


    foreach( $starts as $start ) {

        $i = 0;
        $total = 0;
        $this_start = $start;

        while ( $i < count( $dir ) ) {

            if ( $this_start[2] === 'Z' ) {
                $path_to_z[] = $total;
                $i = count( $dir );
            } else {
                $this_start = $paths[$this_start][$dir[$i]];
            }

            $total++;

            if ( $i === count( $dir ) - 1 ) {
                $i = 0;
                continue;
            }

            $i++;

        }
    }

    $lcm = $path_to_z[0];

    foreach( $path_to_z as $t ) {
        $lcm = gmp_lcm( $lcm, $t );
    }

    echo $lcm;

}

function get_direction_paths( $rows ) {

    $directions = $rows[0];
    unset( $rows[0], $rows[1] );
    $paths = [];
    $starts = [];
    $ends = [];

    foreach( $rows as $row ) {
        $row = explode( ' ', str_replace( ['= (', ',', ')'], '', $row ) );
        $paths[ $row[0] ] = ['L' => $row[1], 'R' => $row[2] ];

        if ( $row[0][2] === 'A' ) {
            $starts[] = $row[0];
        }

        if ( $row[0][2] === 'Z' ) {
            $ends[] = $row[0];
        }
    }

    

    return [$directions, $paths, $starts, $ends];
}

echo PHP_EOL . 'Day 08: Haunted Wasteland' . PHP_EOL . 'Part 1: ';
//part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;