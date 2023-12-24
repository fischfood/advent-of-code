<?php

/**
 * Day 24: TITLE
 */

// The usual
$data = file_get_contents('data/data-24.txt');
//$data = file_get_contents('data/data-24-sample.txt');

$min = 200000000000000; $max = 400000000000000;
//$min = 7; $max = 27;

$rows = explode("\n", $data);

// Part One
function part_one($rows, $min, $max) {

    $equations = build_linear_equations( $rows );
    $success = check_intersect( $equations, $min, $max );

    echo $success;
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function build_linear_equations( $rows ) {
    $equations = [];

    foreach( $rows as $row ) {
        $vals = explode( ', ', str_replace( '@', ',', $row ) );
        
        $x = $vals[0];
        $y = $vals[1];
        $run = $vals[3];
        $rise = $vals[4];

        // (((19/-2)*1)-13)*-1

        $slope = $rise / $run;
        $x_offset = ( ( ( ( $x / $run ) * $rise ) - $y ) * -1 );

        //echo PHP_EOL . "y = $slope x + $x_offset";

        $equations[] = [$slope, $x_offset, $x, $y, $run, $rise];
    }

    return $equations;
}

function check_intersect( $equations, $min = 7, $max = 27 ) {

    $success = 0;

    foreach( $equations as $e => $equation ) {
        for ( $i = $e + 1; $i < count( $equations ); $i++ ) {

            //echo PHP_EOL;
            
            //echo PHP_EOL . "y = " . $equations[$e][0] . 'x + ' . $equations[$e][1];
            //echo PHP_EOL . "y = " . $equations[$i][0] . 'x + ' . $equations[$i][1];
            
            $left_x = $equations[$e][0] - $equations[$i][0];
            $right_integer = $equations[$i][1] - $equations[$e][1];

            // Check same increase
            if ( $left_x == 0 ) {
                //echo 'No Interset';
                continue;
            }
            
            $x = ( $right_integer / $left_x );
            $y = ( $equations[$e][0] * $x ) + $equations[$e][1];

            // Check min/max
            if ( $x < $min || $x > $max || $y < $min || $y > $max ) {
                //echo 'Out of bounds';
                continue;
            }

            $first_x = $equations[$e][2];
            $first_y = $equations[$e][3];
            $first_xd = $equations[$e][4];
            $first_yd = $equations[$e][5];

            $second_x = $equations[$i][2];
            $second_y = $equations[$i][3];
            $second_xd = $equations[$i][4];
            $second_yd = $equations[$i][5];

            if ( $first_x > $x && $first_xd > 0 ) { continue; } // echo 'Past'; 
            if ( $first_x < $x && $first_xd < 0 ) { continue; } // echo 'Past'; 
            if ( $first_y > $y && $first_yd > 0 ) { continue; } // echo 'Past'; 
            if ( $first_y < $y && $first_yd < 0 ) { continue; } // echo 'Past'; 

            if ( $second_x > $x && $second_xd > 0 ) { continue; } // echo 'Past'; 
            if ( $second_x < $x && $second_xd < 0 ) { continue; } // echo 'Past'; 
            if ( $second_y > $y && $second_yd > 0 ) { continue; } // echo 'Past'; 
            if ( $second_y < $y && $second_yd < 0 ) { continue; } // echo 'Past'; 


            // If nothing has failed, it has happened
            //echo 'Success at ' . $x . ', ' . $y;
            $success++;
            
        }
    }

    return $success;
}

echo PHP_EOL . 'Day 24: TITLE' . PHP_EOL . 'Part 1: ';
part_one($rows, $min, $max);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;