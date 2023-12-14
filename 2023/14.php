<?php

ini_set('memory_limit', '10G');

/**
 * Day 14: Parabolic Reflector Dish
 */

// The usual
$data = file_get_contents('data/data-14.txt');
//$data = file_get_contents('data/data-14-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    
    $dish = rotate($rows);
    $new_positions = tilt( $dish );

    echo get_load( rotate( $new_positions ) );
}

// Part Two
function part_two($rows) {
	
    $spin = spin( $rows, 1000000000 );
    echo $spin;
}

function rotate( $rows, $turn = 'cw' ) {
    $rotated = [];

    foreach ( $rows as $m => $row ) {

        if ( ! is_array( $row ) ) {
            $row = str_split( $row );
        }

        $length = count( $row );

        foreach( $row as $key => $char ) {
            $rotated[$key][] = $char;
        }
    }

    if ( $turn === 'ccw' ) {
        foreach( $rotated as $key => $rot ) {
            $rotated[$key] = array_reverse($rot);
        }
    }

    return $rotated;
}

function tilt( $rows ) {
    $new_positions = [];

    foreach( $rows as $row ) {
    
        // For each spot in the row...
        for ( $i = 0; $i < count( $row ); $i++ ) {

            // If I'm on a round rock...
            if ( $row[$i] === 'O' ) {

                // Check all previous spots until I hit another rock
                for ( $this_spot = $i; $this_spot > 0; $this_spot-- ) {
                    $check = $this_spot - 1;

                    if ( $row[$check] === '.' && $row[$this_spot] === 'O') {
                        $row[$check] = 'O';
                        $row[$this_spot] = '.';
                    }

                }
            }
        }

        $new_positions[] = $row;
    }

    return $new_positions;
}

function get_load( $new_positions ) {

    $length = count( $new_positions[0] );
    $total = 0;

    foreach( $new_positions as $rnum => $rocks_settled ) {
        $total += ($length - $rnum) * substr_count( implode('', $rocks_settled), "O");
    }

    return $total;
}

function spin( $rows, $repeat = 1 ) {

    $results = [];
    $repeats_every = '';
    $first_repeat = 0;

    for ( $s = 1; $s <= $repeat; $s++) {

        if ( '' === $repeats_every ) {

            $dish = rotate($rows);
            $rows = array_reverse( tilt( $dish ) );

            $dish = rotate($rows, 'ccw');
            $rows = tilt( $dish );

            $dish = rotate($rows, 'ccw');
            $rows = tilt( $dish );

            $dish = rotate($rows, 'ccw');
            $rows = tilt( $dish );

            $rows = set_north( $rows ); 

            $total_repeat = 0;

            for ( $check = count($results); $check > 0; $check-- ) {
                if ( $rows === $results[$check - 1] ) {

                    $first_repeat = $check;
                    $repeats_every = $s - $check;
                }
            }

            $results[] = $rows;

        } else {
            $s = $repeat;
        }
    }

    //echo $first_repeat;

    $repeat_mod = $repeat % $repeats_every;

    $min = floor( $first_repeat / $repeats_every );

    $matching = ($min * $repeats_every) + $repeat_mod;

    foreach( $results as $k => $r ) {
        //echo PHP_EOL . $k . ' - ' . get_load( $results[$k]);
        //echo output( $r );
    }

    echo get_load( $results[$matching - 1]);

}

function output( $rows ) {
    echo PHP_EOL;
    foreach( $rows as $row ) {
        echo PHP_EOL . implode('', $row);
    }
}

function set_north( $rows ) {

    foreach( $rows as $i => $row ) {
        $rows[$i] = array_reverse($row);
    }

    $reset = array_reverse( $rows );

    return $reset;
}

echo PHP_EOL . 'Day 14: Parabolic Reflector Dish' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;