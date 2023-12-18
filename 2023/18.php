<?php

/**
 * Day 18: Lavaduct Lagoon
 */

// The usual
$data = file_get_contents('data/data-18.txt');
//$data = file_get_contents('data/data-18-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $start = microtime( true );

    [$grid, $min_x, $min_y, $max_x, $max_y] = make_grid( $rows );

    [$total_grid, $spaces] = fill_grid( $grid, $min_x, $min_y, $max_x, $max_y );

    $remove_outside = clean_grid( $total_grid, $spaces );

    $total = 0;

    // 35 = #, & 46 = .
    foreach( $remove_outside as $rows ) {
        $counts = count_chars( implode('', $rows), 1 );
        
        if ( array_key_exists( '35', $counts ) ) {
            $total += $counts['35'];
        }

        if ( array_key_exists( '46', $counts ) ) {
            $total += $counts['46'];
        }
    }

    echo $total;

    $end = microtime( true );
    printf( 'Time: %s seconds' . PHP_EOL, round( $end - $start, 3 ) );
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function make_grid( $rows ) {
    $grid = ['0,0'];
    $x = 0;
    $y = 0;

    $min_x = 0;
    $min_y = 0;
    $max_x = 0;
    $max_y = 0;

    foreach( $rows as $row ) {
        $row = explode( ' ', $row );

        $dir = $row[0];
        $length = $row[1];
        $color = preg_replace( '/[^a-z0-9]/', '', $row[2] );

        for ( $i = 0; $i < $length; $i++ ) {
            if ( $dir === 'L' ) { $x--; }
            if ( $dir === 'R' ) { $x++; }
            if ( $dir === 'U' ) { $y--; }
            if ( $dir === 'D' ) { $y++; }

            if ( $x > $max_x ) {
                $max_x = $x;
            }

            if ( $y > $max_y ) {
                $max_y = $y;
            }

            if ( $x < $min_x ) {
                $min_x = $x;
            }

            if ( $y < $min_y ) {
                $min_y = $y;
            }

            $grid[] = $x . ',' . $y;
        }
    }

    return [$grid, $min_x, $min_y, $max_x, $max_y];
}

function fill_grid( $grid, $min_x, $min_y, $max_x, $max_y ) {

    $full_grid = [];
    $spaces = [];

    $x_offset = 0 - $min_x + 1;
    $y_offset = 0 - $min_y + 1;

    for ( $x = 0; $x <= ($max_x + $x_offset + 1); $x++ ) {
        for ( $y = 0; $y <= ($max_y + $y_offset + 1); $y++ ) {
            if ( in_array( $x - $x_offset . ',' . $y - $y_offset, $grid ) ) {
                $char = '#';
            } else {
                $char = '.';
                $spaces[] = $x . ',' . $y;
            }

            $full_grid[$y][] = $char;
        }
    }
    
    return [ $full_grid, $spaces ];
}

function clean_grid( $grid, $spaces ) {    

    $start = [0,0];
    $checked = [];
    $to_check = [ $start ];

    $i = 0;

    while ( ! empty( $to_check ) ) {

        foreach( $to_check as $key => $coords ) {

            $x = $coords[0];
            $y = $coords[1];

            $checked[] = $x . ',' . $y;
            unset( $to_check[$key] );


            if ( $grid[$y][$x] === '.' ) {

                $grid[$y][$x] = ' ';

                if ( $x > 0 && ! in_array( ($x - 1) . ',' . $y, $to_check ) && ! in_array( ($x - 1) . ',' . $y, $checked ) ) {
                    $to_check[] = [ ($x - 1), $y ];
                }
                if ( $y > 0 && ! in_array( $x . ',' . ($y - 1), $to_check ) && ! in_array( $x . ',' . ($y - 1), $checked ) ) {
                    $to_check[] = [ $x, ( $y - 1 ) ];
                }

                if ( $x < count($grid[0]) - 1 && ! in_array( ($x + 1) . ',' . $y, $to_check ) && ! in_array( ($x + 1) . ',' . $y, $checked ) ) {
                    $to_check[] = [ ($x + 1), $y ];
                }

                if ( $y < count($grid) - 1 && ! in_array( $x . ',' . ($y + 1), $to_check ) && ! in_array( $x . ',' . ($y + 1), $checked ) ) {
                    $to_check[] = [ $x, ( $y + 1 ) ];
                }

            }

        }

        

        $i++;
    }
    
    return $grid;

}

echo PHP_EOL . 'Day 18: Lavaduct Lagoon' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;