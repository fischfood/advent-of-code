<?php

/**
 * Day 18: RAM Run
 * Part 1: 0.00514 Seconds - 2327th!
 * Part 2: 4.78132 Seconds - 2195th!!
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-18.txt');
// $data = file_get_contents('data/data-18-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {

    // Set the bounds and fill a map. 6 for sample, 70 for real.
    $x_bounds = $y_bounds = 70; // 70; 6;
    $map = array_fill(0, $y_bounds + 1, array_fill(0, $x_bounds + 1, '.'));

    // Set the start to upper left, end to lower right
    $map[0][0] = 'S';
    $map[$y_bounds][$x_bounds] = 'E';

    // Only run a certain amount of bytes falling. 12 for sample, 1024 for real
    foreach( $dataset as $k => $row ) {
        if ( $k < 1024 ) { // 1024, 12

            // Replace . with # where byte walls should be
            [$x, $y] = explode( ',', $row );
            $map[$y][$x] = '#';
        }

    }

    // Run a BFS to get the best path
    $path = bfs( [0,0], [$x_bounds,$y_bounds], $map, $x_bounds, $y_bounds);

    // Get the total steps in the path, minus one for the start point
    echo count( $path ) - 1;
}

// Part Two
function part_two($dataset) {

    // Set the bounds and fill a map. 6 for sample, 70 for real.
	$x_bounds = $y_bounds = 70; // 70; 6;
    $map = array_fill(0, $y_bounds + 1, array_fill(0, $x_bounds + 1, '.'));

    // Set the start to upper left, end to lower right
    $map[0][0] = 'S';
    $map[$y_bounds][$x_bounds] = 'E';

    // From part one, we know a path exists up until 12 bytes / 1024 byte, so start there. Previous is a guaranteed success
    for ( $i = 1024; $i <= count( $dataset ); $i++ ) { // 1024, 12
        
        // Same map build as before
        foreach( $dataset as $k => $row ) {
            if ( $k <= $i ) { // 1024, 12
                [$x, $y] = explode( ',', $row );
                $map[$y][$x] = '#';
            }
        }

        // Run a BFS to get the best path
        $path = bfs( [0,0], [$x_bounds,$y_bounds], $map, $x_bounds, $y_bounds);

        // Once a path comes back with an error, we know it's unsolvable.
        // Get this coordinate
        if ( $path == false ) {
            echo "Fails at " . $dataset[$i] . " ($i)";
            $i = PHP_INT_MAX;
        }
    }
}

// Generic BFS going from S to E
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
            if ($new_x >= 0 && $new_x <= $x_bounds && $new_y >= 0 && $new_y <= $y_bounds && $map[$new_y][$new_x] !== '#' && !isset($visited[$new_y][$new_x])) {
                $visited[$new_y][$new_x] = true;
                $queue[] = [$new_x, $new_y];
                $previous[$new_y][$new_x] = [$x, $y]; // Track the previous step
            }
        }
    }

    return false;
}

echo PHP_EOL . 'Day 18: RAM Run' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;