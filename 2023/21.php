<?php

/**
 * Day 21: Step Counter
 */

// The usual
$data = file_get_contents('data/data-21.txt');
$data = file_get_contents('data/data-21-sample.txt');
//$data = file_get_contents('data/data-21-sample-2.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    [$grid, $start] = build_grid( $rows );
    $walk = walk( $grid, $start, 6 );

    echo PHP_EOL . count( $walk );
}

// Part Two
function part_two($rows) {
	// if the grid was empty, total spaces = ( distance + 1 ) ^ 2;
}

function build_grid( $rows ) {
    $grid = [];
    $start = '';

    foreach( $rows as $num => $row ) {
        $grid[$num] = str_split( $row );

        if ( str_contains( $row, 'S') ) {
            $start = [ strpos( $row, 'S' ), $num ];
        }
    }

    return [$grid, $start ];

}

function walk( $grid, $start, $total_steps = 16 ) {

    $all_steps = [];
    $possible_steps = [];
    $locations = [ $start ];

    $min_x = 0;
    $min_y = 0;
    $max_x = count( $grid[0] ) - 1;
    $max_y = count( $grid ) - 1;

    $even_odd = $total_steps % 2;
    
    if ( ! $even_odd ) {
        $possible_steps[] = implode( ',', $start );
    }

    for ( $steps = 0; $steps < $total_steps; $steps++ ) {
        
        foreach( $locations as $k => $loc ) {
            unset( $locations[$k] );

            $x = $loc[0];
            $y = $loc[1];

            if ( $x+1 <= $max_x && $grid[$y][$x + 1] === '.' && ! in_array( $x + 1 . ',' . $y, $all_steps ) ) {
                $all_steps[] = $x + 1 . ',' . $y;
                $locations[] = [$x + 1, $y];

                if ( $steps % 2 !== $even_odd ) {
                    $possible_steps[] = $x + 1 . ',' . $y;
                    $grid[$y][$x + 1] = 0;
                }
            }

            if ( $x-1 >= $min_x && $grid[$y][$x - 1] === '.' && ! in_array( $x - 1 . ',' . $y, $all_steps ) ) {
                $all_steps[] = $x - 1 . ',' . $y;
                $locations[] = [$x - 1, $y];

                if ( $steps % 2 !== $even_odd ) {
                    $possible_steps[] = $x - 1 . ',' . $y;
                    $grid[$y][$x - 1] = 0;
                }
            }

            if ( $y+1 <= $max_y && $grid[$y + 1][$x] === '.' && ! in_array( $x . ',' . $y + 1, $all_steps ) ) {
                $all_steps[] = $x . ',' . $y + 1;
                $locations[] = [$x, $y + 1];

                if ( $steps % 2 !== $even_odd ) {
                    $possible_steps[] = $x . ',' . $y + 1;
                    $grid[$y + 1][$x] = 0;
                }
            }

            if ( $y-1 >= $min_y && $grid[$y - 1][$x] === '.' && ! in_array( $x . ',' . $y - 1, $all_steps ) ) {
                $all_steps[] = $x . ',' . $y - 1;
                $locations[] = [$x, $y - 1];

                if ( $steps % 2 !== $even_odd ) {
                    $possible_steps[] = $x . ',' . $y - 1;
                    $grid[$y - 1][$x] = 0;
                }
            }            
        }
    }

    foreach( $grid as $g ) {
        echo PHP_EOL . implode('', $g);
    }

    return $possible_steps;
}

echo PHP_EOL . 'Day 21: Step Counter' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;