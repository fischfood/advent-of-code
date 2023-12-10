<?php

// ini_set('memory_limit', '10G');

/**
 * Day 10: Pipe Maze
 */

// The usual
$data = file_get_contents('data/data-10.txt');
//$data = file_get_contents('data/data-10-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $start    = microtime( true );
    
    [$starting_coord, $x_bounds, $y_bounds] = determine_start( $rows );

    echo next_pipe( $starting_coord, [$starting_coord], 0, $x_bounds, $y_bounds, $rows );

    $end    = microtime( true );
    printf( ' - Time: %s seconds' . PHP_EOL, round( $end - $start, 4 ) );
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function determine_start( $rows ) {
    $start_coord = [0,0];
    $y_bounds = count( $rows );
    $x_bounds = strlen( $rows[0] );

    foreach( $rows as $y => $row ) {
        $row_char = str_split( $row );
        foreach( $row_char as $x => $letter ) {
            if ( 'S' === $letter ) {
                $start_coord = $x . ',' . $y;
            }
        }
    }

    return [$start_coord, $x_bounds, $y_bounds];
}

function next_pipe( $this_coord_string, $visited, $v_total, $x_bounds, $y_bounds, $rows ) {

    $this_coord = explode( ',', $this_coord_string);
    $cur_symbol = $rows[$this_coord[1]][$this_coord[0]];

    $directions = [
        '0,-1' => [ // Up
            'allowed' => ['|', '7', 'F'], 
            'if' => ['|', 'J', 'L', 'S']
        ],
        '0,1' => [ // Down
            'allowed' => ['|', 'J', 'L'], 
            'if' => ['|', '7', 'F', 'S']
        ],
        '-1,0' => [ // Left
            'allowed' => ['-','F','L'], 
            'if' => ['-', 'J', '7' , 'S']
        ],
        '1,0' => [ // Right
            'allowed' => ['-', 'J', '7' ],
            'if' => ['-', 'F', 'L', 'S']
        ]
    ];

    $allowed_total = 0;

    foreach( $directions as $dir => $symbols ) {

        $check_coord = explode( ',', $dir );
        $new_x = $this_coord[0] + $check_coord[0];
        $new_y = $this_coord[1] + $check_coord[1];

        // If in grid
        if ( $new_x >= 0 && $new_x < $x_bounds && $new_y >= 0 && $new_y < $y_bounds ) {

            $new_coord = $new_x . ',' . $new_y;

            //echo PHP_EOL . '     On ' . $cur_symbol . '(' . $this_coord_string . ')' . ' - ' . 'Checking ' . $dir . ': ' . $new_coord . ' - Found: ' . $rows[$new_y][$new_x];

            // If you can move there...
            if ( in_array( $rows[$new_y][$new_x], $symbols['allowed'] ) && in_array( $rows[$this_coord[1]][$this_coord[0]], $symbols['if'] ) && ! in_array( $new_coord, $visited) ) {

                //echo PHP_EOL . 'Allowed: ' . $rows[$new_y][$new_x];
                
                $allowed_total++;
                $v_total++;

                $visited[ $v_total ] = $new_coord;
                return next_pipe( $new_coord, $visited, $v_total, $x_bounds, $y_bounds, $rows );
            }
        }
    }
    return( count( $visited ) / 2 );
}

echo PHP_EOL . 'Day 10: Pipe Maze' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;