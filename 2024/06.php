<?php

/**
 * Day 06: TITLE
 */

// The usual
$data = file_get_contents('data/data-06.txt');
//$data = file_get_contents('data/data-06-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
//include_once( '../functions.php' );

$starttime = microtime(true);

// Part One
function part_one($dataset) {
    $map = [];
    $rocks = [];
    $security = [];
    $visited = [];
    $dir = 0;

    $x_bounds = strlen( $dataset[0] ) - 1;
    $y_bounds = count( $dataset ) - 1;

    foreach( $dataset as $y => $x_row ) {
        $xs = str_split( $x_row, 1 );

        foreach( $xs as $x => $char ) {
            $map[$y][$x] = $char;

            if ( $char === '#' ) {
                $rocks[$x . ',' . $y] = '#';
            }
            if ( $char === '^' ) {
                $security = [$x,$y];
                $visited[$x . ',' . $y] = 'X';
                $map[$security[1]][$security[0]] = '^';
            }
        }
    }

    $walk = true;

    while ( $walk ) {
        $next = $security;

        switch ($dir) {
            case 0:
                $next[1]--;
                break;
            case '1':
                $next[0]++;
                break;
            case '2':
                $next[1]++;
                break;
            case '3':
                $next[0]--;
                break;
        }

        $check_rock = implode( ',', $next );

        if ( array_key_exists( $check_rock, $rocks ) ) {
            // Found Rock, turning
            $dir++;

            // Rotate
            if ( $dir > 3 ) { $dir = 0; }

        } else { 

            // Allow to move
            $security = $next;
            $visited[implode( ',', $security )] = 'X';

            if ( $security[0] <= 0 || $security[0] >= $x_bounds || $security[1] <= 0 || $security[1] >= $y_bounds ) {
                // Out of Bounds;
                $walk = false;
            } else {
                // Mark the map
                $map[$security[1]][$security[0]] = 'X';
            }
        }
    }

    echo count( $visited );

    // foreach( $map as $x ) {
    //     echo "\n" . implode($x);
    // }
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day 06: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;