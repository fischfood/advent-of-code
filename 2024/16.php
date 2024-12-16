<?php

/**
 * Day 16: TITLE
 */

// The usual
ini_set('memory_limit', '10G');
$starttime = microtime(true);
$data = file_get_contents('data/data-16.txt');
$data = file_get_contents('data/data-16-sample.txt');
$data = file_get_contents('data/data-16-sample-2.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include_once( '../functions.php' );

// Part One
function part_one($dataset) {
    
    $map = [];
    $start = [];
    $end = [];
    $total = 0;

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

    $routes = bfs($start, $end, $map, $x_bounds, $y_bounds);

    foreach( $routes as $i => $route ) {
        echo "\nPath $i - ";
        print_r( $route['length'] . ' + ' . $route['turns'] . ' = ' . ( $route['turns'] * 1000 + $route['length'] ) );
    }
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function bfs($start, $end, $map, $x_bounds, $y_bounds) {
    [$sx, $sy] = $start;

    $directions = [
        [0, -1], // N
        [0, 1], // S
        [-1, 0], // E
        [1, 0] // W
    ];

    $queue = [[
        'x' => $sx,
        'y' => $sy,
        'path' => [[$sx, $sy]],
        'prev_dir' => 3, // Start East/Right
        'turns' => 0
    ]];

    $paths = [];

    while ( ! empty( $queue ) ) {
        $current = array_shift($queue);

        $x = $current['x'];
        $y = $current['y'];
        $path = $current['path'];
        $prev_dir = $current['prev_dir'];
        $turns = $current['turns'];

        // Stop at E
        if ($map[$y][$x] === 'E') {
            $paths[] = [
                'path' => $path,
                'length' => count($path) - 1,
                'turns' => $turns
            ];
            if (count($paths) === 15) break; // Check for multiple paths since it's ordered by length
            continue;
        }

        // Explore neighbors
        foreach ($directions as $index => $direction) {

            $new_x = $x + $direction[0];
            $new_y = $y + $direction[1];

            if ($new_x >= 0 && $new_x < $x_bounds && $new_y >= 0 && $new_y < $y_bounds && $map[$new_y][$new_x] !== '#') {

                if (!in_array([$new_x, $new_y], $path)) {
                    $new_turns = $turns;
                    if ($prev_dir !== null && $prev_dir !== $index) {
                        $new_turns++;
                    }

                    $queue[] = [
                        'x' => $new_x,
                        'y' => $new_y,
                        'path' => array_merge($path, [[$new_x, $new_y]]),
                        'prev_dir' => $index,
                        'turns' => $new_turns
                    ];
                }
            }
        }
    }

    return $paths;
}

echo PHP_EOL . 'Day 16: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;