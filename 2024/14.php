<?php

/**
 * Day 14: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-14.txt');
//$data = file_get_contents('data/data-14-sample.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {

    $x_bounds = 101; //11;
    $y_bounds = 103; //7;
    $map = [];
    $quadrants = [0,0,0,0];
    
    foreach( $dataset as $k => $d ) {
        preg_match_all( '/-?[0-9]{1,3}/', $d, $robot );
        $final = move_robot( $robot[0], 100, $x_bounds, $y_bounds );
        list( $x, $y ) = $final;
        $map[$k] = implode( ',', $final);

        if ( $y < floor( $y_bounds / 2 ) ) {
            if ( $x < floor( $x_bounds / 2 ) ) { $quadrants[0] = $quadrants[0] + 1;}
            if ( $x > floor( $x_bounds / 2 ) ) { $quadrants[1] = $quadrants[1] + 1;}
        } 

        if ( $y > floor( $y_bounds / 2 ) ) {
            if ( $x < floor( $x_bounds / 2 ) ) { $quadrants[2] = $quadrants[2] + 1;}
            if ( $x > floor( $x_bounds / 2 ) ) { $quadrants[3] = $quadrants[3] + 1;}
        } 
    }

    $map_totals = array_count_values( $map );

    // for( $y = 0; $y < $y_bounds; $y++ ) {
    //     echo "\n";
    //     for( $x = 0; $x < $x_bounds; $x++ ) {
    //         if ( array_key_exists( "$x,$y", $map_totals ) ) {
    //             echo $map_totals["$x,$y"];
    //         } else {
    //             echo '.';
    //         }
    //     }
    // }

    echo array_product( $quadrants );
}

// Part Two
function part_two($dataset) {

}

function move_robot( $robot, $times, $x_bounds, $y_bounds ) {

    list( $x, $y, $dx, $dy ) = $robot;

    // echo "\n";
    // echo "curPur: $x, $y - $times";

    $new_x = $x + $dx;
    $new_y = $y + $dy;

    if ( $new_x < 0 ) { $new_x += $x_bounds; }
    if ( $new_x >= $x_bounds ) { $new_x -= $x_bounds; }

    if ( $new_y < 0 ) { $new_y += $y_bounds; }
    if ( $new_y >= $y_bounds ) { $new_y -= $y_bounds; }

    $robot[0] = $new_x;
    $robot[1] = $new_y;

    $times--;
    
    if ( $times === 0 ) {
        return [$robot[0],$robot[1]];
    }

    return move_robot( $robot, $times, $x_bounds, $y_bounds );
}

echo PHP_EOL . 'Day 14: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;