<?php

/**
 * Day 14: Restroom Redoubt
 * Part 1: 0.01561 Seconds
 * Part 2: 1.49231 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-14.txt');
//$data = file_get_contents('data/data-14-sample.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {
    $map = [];
    $quadrants = [0,0,0,0];
    $robots = [];
    $time = 100;

    $x_bounds = 101; // Real: 101, Sample: 11
    $y_bounds = 103; // Real: 103, Sample: 7
    
    // Split each robot into Starting X, Starting Y, Move X, and Move Y
    // Set all data for that robot, [$x, $y, $dx, $dy]
    foreach( $dataset as $k => $d ) {
        preg_match_all( '/-?[0-9]{1,3}/', $d, $robot );
        $robots[$k] = $robot[0];
    }

    // For each timestamp, move the robots where they should be, using [$x, $y, $dx, $dy]
    for ( $i = 0; $i < $time; $i++ ) {
        foreach( $robots as $r => $robot ) {

            // Get the new position...
            $new_spot = move_robot( $robot, $x_bounds, $y_bounds );
            
            // And reassign coordinates for the next run
            $robots[$r] = $new_spot;
        }
    }

    // Once we have their final positions, we can determine what quadrant they are in
    foreach( $robots as $k => $final_robot ) {

        // Grab the X and Y to compare, add to map if necessary (To compare sample data)
        list( $x, $y ) = $final_robot;
        $map[$k] = "$x,$y";

        // Split the Y / X in half, then get rid of the decimal
        // Ex. 7 Rows / 2 = 3.5 - Floor gives us 3, now we can check if it's under 3 (0,1,2) or over 3 (4,5,6). Repeat for X
        // Quadrant numbers aren't important as long as there are four to check

        if ( $y < floor( $y_bounds / 2 ) ) {
            if ( $x < floor( $x_bounds / 2 ) ) { $quadrants[0] = $quadrants[0] + 1;}
            if ( $x > floor( $x_bounds / 2 ) ) { $quadrants[1] = $quadrants[1] + 1;}
        } 

        if ( $y > floor( $y_bounds / 2 ) ) {
            if ( $x < floor( $x_bounds / 2 ) ) { $quadrants[2] = $quadrants[2] + 1;}
            if ( $x > floor( $x_bounds / 2 ) ) { $quadrants[3] = $quadrants[3] + 1;}
        } 
    }

    // Multiple the four quadrant totals together
    echo array_product( $quadrants );

    // For Display Purposes:

    // $map_totals = array_count_values( $map );
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
}

// Part Two
function part_two($dataset) {
    $image = [];
    $robots = [];

    // We don't know how long we need to run, so go as high as possible
    $time = PHP_INT_MAX;

    $x_bounds = 101; // Real: 101, Sample: 11
    $y_bounds = 103; // Real: 103, Sample: 7
    
    // Split each robot into Starting X, Starting Y, Move X, and Move Y
    // Set all data for that robot, [$x, $y, $dx, $dy]
    foreach( $dataset as $k => $d ) {
        preg_match_all( '/-?[0-9]{1,3}/', $d, $robot );
        $robots[$k] = $robot[0];
    }

    // For each timestamp...
    for ( $i = 1; $i < $time; $i++ ) {

        // Set a new list of results to look for duplicates
        $results = [];

        // Move the robots where they should be, using [$x, $y, $dx, $dy]
        foreach( $robots as $r => $robot ) {

            // Get the new coordinates...
            $new_spot = move_robot( $robot, $x_bounds, $y_bounds );

            // Assign them for the next run
            $robots[$r] = $new_spot;

            // Log the X,Y coordinates to see if more than one is in that spot
            list( $x, $y ) = $new_spot;
            $results[$r] = "$x,$y";
        }

        // Count the total times each X,Y appears and log that to a new array
        $map_totals = array_count_values( $results );
        
        // Multiple all array values together
        // If any position in $map_totals exists more than once, our product will be higher than 1, so it fails
        if ( array_product( $map_totals ) === 1 ) {

            // Set all positions to a string to see when they bunch together
            $output = '';
            for( $y = 0; $y < $y_bounds; $y++ ) {
                for( $x = 0; $x < $x_bounds; $x++ ) {
                    if ( array_key_exists( "$x,$y", $map_totals ) ) {
                        $image[$y][$x] = '#';
                        $output .= '#';
                    } else {
                        $image[$y][$x] = '.';
                        $output .= '.';
                    }
                }
            }

            // If we find multiple blocks in a row, we've found an image
            if ( str_contains( $output, '#####') ) {

                // This is our row. Create it, echo the row, and exit the loop;
                generate_image( $image, $i );
                echo $i;
                $i = PHP_INT_MAX;
            }
        }
    }
}

function move_robot( $robot, $x_bounds, $y_bounds ) {

    // Grab current coordinates, and how the robot moves
    list( $x, $y, $dx, $dy ) = $robot;

    // Set new positions
    $new_x = $x + $dx;
    $new_y = $y + $dy;

    // Check if out of bounds, and reset
    if ( $new_x < 0 ) { $new_x += $x_bounds; }
    if ( $new_x >= $x_bounds ) { $new_x -= $x_bounds; }

    if ( $new_y < 0 ) { $new_y += $y_bounds; }
    if ( $new_y >= $y_bounds ) { $new_y -= $y_bounds; }

    // Set new coordinates, and send them back for the next step
    $robot[0] = $new_x;
    $robot[1] = $new_y;

    return $robot;
}

function generate_image( $image, $line ) {
    // New File location
    $file = __DIR__ . "/data/data-14-easter-egg-" . $line . ".txt";

    // Build the map
    $pixels = '';
    foreach( $image as $img ) {
        $pixels .= implode( '', $img ) . "\n";
    }

    // Write it to the file
    file_put_contents( $file, $pixels );
}

echo PHP_EOL . 'Day 14: Restroom Redoubt' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;