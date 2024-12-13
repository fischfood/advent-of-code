<?php

/**
 * Day 12: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-12.txt');
//$data = file_get_contents('data/data-12-sample.txt');
//$data = file_get_contents('data/data-12-sample-2.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {

    $map = [];
    $total = 0;

    foreach( $dataset as $y => $row ) {
        foreach( str_split($row) as $x => $char ) {
            $map[$y][$x] = $char;
        }
    }    
    
    $results = flood_and_group( $map );

    foreach( $results as $r => $ap ) {
        [$a, $p] = $ap;
        $axp = $a * $p;
        $total += $axp;
        //echo "\n$r - $a * $p = $axp";
    }

    echo $total;
}


// Part Two
function part_two($dataset) {
	# Do More Things
}

function flood_and_group( $map ) {
    
    $y_bounds = count($map);
    $x_bounds = count($map[0]);

    $visited = array_fill(0, $y_bounds, array_fill(0, $x_bounds, false));
    $results = [];

    // BFS function
    $bfs = function($x_start, $y_start, $map, $x_bounds, $y_bounds, $groups, $group_num) use (&$visited, &$results) {

        $directions = [
            [0, -1], [0, 1], [-1, 0], [1, 0]
        ];
        
        $queue = [[$x_start, $y_start]];
        $char = $map[$y_start][$x_start];

        $area = 0;
        $plots = [];
        $total_perimeter = [];
        
        while ( ! empty( $queue ) ) {

            [$x, $y] = array_shift($queue);

            // Skip if visited
            if ( $visited[$y][$x] ) {
                continue;
            }

            $visited[$y][$x] = true;
            $area++;
            
            $plots[] = [$x, $y];
            $perimeter = 4; // Assume no neighboring plots

            // Check all directions for same character
            foreach ( $directions as $direction) {

                $new_y = $y + $direction[0];
                $new_x = $x + $direction[1];

                if ( $new_x >= 0 && $new_x < $x_bounds && $new_y >= 0 && $new_y < $y_bounds ) {

                    if ( $map[$new_y][$new_x] === $char) {
                        $perimeter--; // Remove one touching    

                        if ( ! isset( $visited[ "$new_x,$new_y" ] ) ) {
                            $queue[] = [$new_x, $new_y];
                        }
                    }
                }
            }
            $total_perimeter["$x,$y"] = $perimeter;
        }
        
        foreach ( $plots as [ $x, $y ]) {
            $touches = $total_perimeter["$x,$y"];
            

            if ( ! array_key_exists( $char . $group_num, $results ) ) {
                $results[$char . $group_num] = [$area, $touches];
            } else {
                $old_touch = $results[$char . $group_num][1];
                $results[$char . $group_num][1] = $old_touch + $touches;
            }
        }

        $groups["$char$group_num"] = $area;
    };

    $groups = [];
    $group_num = 1;

    for ( $y = 0; $y < $y_bounds; $y++ ) {
        for ($x = 0; $x < $x_bounds; $x++) {
            if (!$visited[$y][$x]) {
                $bfs($x, $y, $map, $x_bounds, $y_bounds, $groups, $group_num);
                $group_num++;
            }
        }
    }

    return $results;
}

echo PHP_EOL . 'Day 12: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;