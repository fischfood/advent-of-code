<?php

/**
 * Day 16: The Floor Will Be Lava
 */

// The usual
$data = file_get_contents('data/data-16.txt');
//$data = file_get_contents('data/data-16-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $grid = ( make_grid( $rows ) );
    $energized = fire_beam( $grid );

    echo $energized;
}

// Part Two
function part_two($rows) {

    $start = microtime( true );

	$grid = ( make_grid( $rows ) );

    $energized = [];
    $max = count( $grid[0] ) - 1;

    for ( $i = 0; $i <= $max; $i++ ) {
        //$energized[] = fire_beam( $grid, '0,' . $i, 'R' ); // 8136
        //$energized[] = fire_beam( $grid, $max . ',' . $i, 'L' ); // 8047
        $energized[] = fire_beam( $grid, $i . ',0', 'D' ); // 8148
        //$energized[] = fire_beam( $grid, $i . ',' . $max, 'U' ); // 8058
    }

    asort( $energized );
    echo array_pop( $energized );

    $end = microtime( true );
    printf( 'Time: %s seconds' . PHP_EOL, round( $end - $start, 3 ) );
}

function make_grid( $rows ) {
    $grid = [];

    foreach ( $rows as $row => $characters ) {
        $grid[$row] = str_split( $characters );
    }

    return $grid;
}

function fire_beam( $grid, $start_string = '0,0', $dir = 'R' ) {
    
    $x_bounds = count( $grid[0] ) - 1;
    $y_bounds = count( $grid ) - 1;

    $start = explode( ',', $start_string );

    $first_char = $grid[ $start[1] ][ $start[0] ];
    $active_beams = get_beam_direction( $dir, $first_char, $start_string );

    $visited_dir = [];
    $energized = [ $start_string ];

    while ( ! empty( $active_beams ) ) {
        foreach( $active_beams as $beam => $coord_dir ) {

            if ( in_array( $beam, $visited_dir ) ) {
                unset( $active_beams[$beam] );
                continue;
            }

            $visited_dir[] = $beam;

            $location = explode( ',', $coord_dir[0] );
            $x = $location[0];
            $y = $location[1];
            $dir = $coord_dir[1];

            switch( $dir ) {
                case 'L': $x--; break;
                case 'R': $x++; break;
                case 'U': $y--; break;
                case 'D': $y++; break;
            }

            if ( $x < 0 || $x > $x_bounds || $y < 0 || $y > $y_bounds ) {
                unset( $active_beams[$beam] );
                continue;
            }

            $new_location_coord = $x . ',' . $y;
            $new_location_char = $grid[$y][$x];

            $energized[] = $new_location_coord;

            $next_beams = get_beam_direction( $dir, $new_location_char, $new_location_coord );
            $active_beams = array_merge( $active_beams, $next_beams );
            unset( $active_beams[$beam] );
        }
    }

    return count( array_unique( $energized ) );
}

function get_beam_direction( $dir, $char, $coord ) {

    $new_dir = $dir;

    // Splits
    if ( $char === '|' ) {
        if ( $dir === 'R' || $dir === 'L' ) {
            return [ $coord . 'xU' => [$coord, 'U'], $coord . 'xD' => [$coord, 'D'] ];
        }
    }

    if ( $char === '-' ) {
        if ( $dir === 'U' || $dir === 'D' ) {
            return [ $coord . 'xL' => [$coord, 'L'], $coord . 'xR' => [$coord, 'R'] ];
        }
    }

    // Angles

    if ( $char === '/' ) {
        if ( $dir === 'U' ) { $new_dir = 'R'; }
        if ( $dir === 'D' ) { $new_dir = 'L'; }
        if ( $dir === 'L' ) { $new_dir = 'D'; }
        if ( $dir === 'R' ) { $new_dir = 'U'; }
    }

    if ( $char === '\\' ) {
        if ( $dir === 'U' ) { $new_dir = 'L'; }
        if ( $dir === 'D' ) { $new_dir = 'R'; }
        if ( $dir === 'L' ) { $new_dir = 'U'; }
        if ( $dir === 'R' ) { $new_dir = 'D'; }
    }

    return [ $coord . 'x' . $new_dir => [$coord, $new_dir] ];
}

echo PHP_EOL . 'Day 16: The Floor Will Be Lava' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;