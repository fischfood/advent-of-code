<?php

/**
 * Day 20: Race Condition
 * Part 1: 96.75789 Seconds (476th Place!!)
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-20.txt');
// $data = file_get_contents('data/data-20-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {

    $map = [];

    foreach( $dataset as $y => $row ) {
        foreach( str_split($row) as $x => $char ) {
            $map[$y][$x] = $char;
            if ( $char == 'S' ) {
                $start = [$x, $y];
            }
            if ( $char == 'E' ) {
                $end = [$x, $y];
            }
        }
    }

    $y_bounds = count($map);
    $x_bounds = count($map[0]);
    $path = [];
    $saved = 0;

    for( $y = 0; $y < $y_bounds; $y++ ) {
        for( $x = 0; $x < $x_bounds; $x++ ) {
            $this_map = $map;

            if ( '#' === $this_map[$y][$x] && $x > 0 && $x < $x_bounds && $y > 0 && $y < $y_bounds ) {

                $this_map[$y][$x] = '.';
                $this_path = bfs( $start, $end, $this_map, $x_bounds, $y_bounds);

                $path[] = count( $this_path ) - 1;
            }
        }
    }

    sort( $path );
    $original = end($path);

    foreach( $path as $p ) {
        //echo "\n Saved ". $original - $p;
        if ( $p < $original - 99 ) {
            $saved++;
        }
    }

    echo $saved;
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function bfs( $start, $end, $map, $x_bounds, $y_bounds ) {

    $queue = [];
    $visited = [];
    $previous = [];

    $directions = [
        'N' => [0, -1],
        'S' => [0, 1], 
        'E' => [1, 0], 
        'W' => [-1, 0],
    ];

    $queue[] = [$start[0], $start[1]];
    $visited[$start[1]][$start[0]] = true;

    while ( ! empty( $queue ) ) {

        [$x,$y] = array_shift($queue);

        // If we reached the end, reconstruct the path
        if ($x === $end[0] && $y === $end[1]) {
            $path = [];
            while (isset($previous[$y][$x])) {
                $path[] = [$x, $y];
                list($x, $y) = $previous[$y][$x];
            }
            $path[] = $start; // Add the starting point
            return array_reverse($path); // Reverse the path to get it from start to end
        }

        // Explore all 4 directions
        foreach ($directions as $move) {
            $new_x = $x + $move[1];
            $new_y = $y + $move[0];

            // Check boundaries and walls
            if ($new_x > 0 && $new_x < $x_bounds && $new_y > 0 && $new_y < $y_bounds && $map[$new_y][$new_x] !== '#' && !isset($visited[$new_y][$new_x])) {
                $visited[$new_y][$new_x] = true;
                $queue[] = [$new_x, $new_y];
                $previous[$new_y][$new_x] = [$x, $y]; // Track the previous step
            }
        }
    }

    return false;
}

echo PHP_EOL . 'Day 20: Race Condition' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;