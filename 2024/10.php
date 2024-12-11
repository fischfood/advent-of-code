<?php

/**
 * Day 10: TITLE
 * Part 1: 0.00000 Seconds
 * Part 2: 0.00000 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-10.txt');
//$data = file_get_contents('data/data-10-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include_once( '../functions.php' );

// Part One
function part_one($dataset) {

    $map = [];
    $starts = [];
    $total = 0;

    foreach( $dataset as $y => $row ) {
        foreach( str_split($row) as $x => $char ) {
            $map[$y][$x] = (int)$char;
            if ( $char == '0' ) {
                $starts[] = [$x, $y];
            }
        }
    }

    $y_bounds = count($map);
    $x_bounds = count($map[0]);

    // Run for every 0 start point
    foreach( $starts as $xy ) {
        list( $x, $y ) = $xy;
        $total += bfs($x, $y, $map, $x_bounds, $y_bounds);
    }

    echo $total;
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

// Breadth-First Search (BFS) function
function bfs($x_coord, $y_coord, $map, $x_bounds, $y_bounds) {

    $directions = [
        [0, -1], // Up
        [0, 1],   // Down
        [-1, 0], // Left
        [1, 0]  // Right
    ];

    $visited = [];
    $endings = [];

    $queue = [ [ $x_coord, $y_coord ] ];
    $visited[ "$x_coord,$y_coord"] = true;

    while ( ! empty( $queue ) ) {
        list($x, $y) = array_shift($queue);
        $current_height = $map[$y][$x];

        if ( $current_height === 9 ) {
            $endings["$x,$y"] = 9;
        }

        // Check neighbors for +1
        foreach ( $directions as $direction ) {
            $new_x = $x + $direction[0];
            $new_y = $y + $direction[1];

            if ( $new_x >= 0 && $new_x < $x_bounds && $new_y >= 0 && $new_y < $y_bounds ) {
                $next_height = $map[$new_y][$new_x];
                $key = "$new_x,$new_y";

                // IF neighbor is one higher, add to queue
                if ( ! isset( $visited[ $key ] ) && $next_height === $current_height + 1) {
                    $visited[ $key ] = true;
                    $queue[] = [ $new_x, $new_y ];
                }
            }
        }
    }

    echo "\n";
    print_r($endings);

    return count($endings);
}

echo PHP_EOL . 'Day 10: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;