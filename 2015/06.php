<?php

/**
 * Day 06: Probably a Fire Hazard
 */

// The usual
$data = file_get_contents('data/data-06.txt');
$rows = explode("\n", $data);
$dataset = $rows;

// Part One
function part_one($dataset) {
    $lights = [];
    for ( $i = 0; $i < 1000; $i++ ) {
        $lights[$i] = [];
    };
    
    foreach( $dataset as $d ) {
        preg_match_all( '/on|off|toggle|[0-9]{1,3},[0-9]{1,3}/', $d, $matches );
        list( $type, $start, $end ) = $matches[0];

        $start = explode( ',', $start );
        $end = explode( ',', $end );

        $start_x = $start[0];
        $start_y = $start[1];

        $end_x = $end[0];
        $end_y = $end[1];

        if ( $type == 'on' ) {
            for( $x = $start_x; $x <= $end_x; $x++ ) {
                for( $y = $start_y; $y <= $end_y; $y++ ) {
                    $lights[$x][$y] = true;
                }
            }
        }

        if ( $type == 'off' ) {
            for( $x = $start_x; $x <= $end_x; $x++ ) {
                for( $y = $start_y; $y <= $end_y; $y++ ) {
                    unset($lights[$x][$y]);
                }
            }
        }

        if ( $type == 'toggle' ) {
            for( $x = $start_x; $x <= $end_x; $x++ ) {
                for( $y = $start_y; $y <= $end_y; $y++ ) {
                    if ( array_key_exists( $y, $lights[$x] ) ) {
                        unset($lights[$x][$y]);
                    } else {
                        $lights[$x][$y] = true;
                    }
                }
            }
        }
    }

    $total = 0;
    foreach ( $lights as $l ) {
        $total += array_sum( $l );
    }

    echo $total;
}

// Part Two
function part_two($dataset) {
	$lights = [];
    for ( $i = 0; $i < 1000; $i++ ) {
        for ( $j = 0; $j < 1000; $j++ ) {
            $lights[$i][$j] = 0;
        }
    };
    
    foreach( $dataset as $d ) {
        preg_match_all( '/on|off|toggle|[0-9]{1,3},[0-9]{1,3}/', $d, $matches );
        list( $type, $start, $end ) = $matches[0];

        $start = explode( ',', $start );
        $end = explode( ',', $end );

        $start_x = $start[0];
        $start_y = $start[1];

        $end_x = $end[0];
        $end_y = $end[1];

        if ( $type == 'on' ) {
            for( $x = $start_x; $x <= $end_x; $x++ ) {
                for( $y = $start_y; $y <= $end_y; $y++ ) {
                    $lights[$x][$y] = $lights[$x][$y] + 1;
                }
            }
        }

        if ( $type == 'off' ) {
            for( $x = $start_x; $x <= $end_x; $x++ ) {
                for( $y = $start_y; $y <= $end_y; $y++ ) {
                    $lights[$x][$y] = $lights[$x][$y] - 1;
                    if ( $lights[$x][$y] < 0 ) {
                        $lights[$x][$y] = 0;
                    }
                }
            }
        }

        if ( $type == 'toggle' ) {
            for( $x = $start_x; $x <= $end_x; $x++ ) {
                for( $y = $start_y; $y <= $end_y; $y++ ) {
                    $lights[$x][$y] = $lights[$x][$y] + 2;
                }
            }
        }
    }

    $total = 0;
    foreach ( $lights as $l ) {
        $total += array_sum( $l );
    }

    echo $total;
}

echo PHP_EOL . 'Day 06: Probably a Fire Hazard' . PHP_EOL . 'Part 1: ';
//part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;