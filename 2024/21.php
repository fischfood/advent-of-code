<?php

/**
 * Day 21: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-21.txt');
// $data = file_get_contents('data/data-21-sample.txt');

$rows = explode("\n", $data);
$dataset = $rows;

// Part One
function part_one($dataset) {

    $total = 0;
    
    foreach( $dataset as $d ) {
        $presses = arrow_keys( arrow_keys( numpad( $d ) ) );
        echo "\n" . intval( $d ) . ' * ' . strlen( $presses );
        $total += ( intval( $d ) * strlen( $presses ) );
    }

    echo "\n";
    echo $total;
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function numpad( $number ) {
    // echo "\n";
    $number = str_split( $number );
    $current = [2,3];

    $arrow_keyss = [
        7,8,9,4,5,6,1,2,3,"x",0,"A"
    ];

    $move = '';

    foreach( $number as $num ) {
        $location_num = intval( array_search( $num, $arrow_keyss ) );
        $location = [ $location_num % 3, floor( $location_num / 3 )];
        
        $dx = $current[0] - $location[0];
        $dy = $current[1] - $location[1];

        $move_x = ( $dx > 0 ) ? str_repeat('<', $dx ) : str_repeat('>', abs( $dx ));
        $move_y = ( $dy > 0 ) ? str_repeat('^', $dy ) : str_repeat('v', abs( $dy ));

        // If bottom row of numpad, move vertically first to avoid gap
        if ( $current[1] === 3 ) {
            $move .= $move_y . $move_x . 'A';
        } else {
            $move .= $move_x . $move_y . 'A';
        }

        $current = $location;
    }

    return $move;
}

function arrow_keys( $dirs ) {
    // echo "\nNeed: $dirs -- ";
    $dirs = str_split( $dirs );
    $current = [2,0]; // x,y

    $arrow_keys = [
        "x","^","A","<","v",">"
    ];

    $move = '';

    foreach( $dirs as $num ) {
        $location_num = intval( array_search( $num, $arrow_keys ) );
        $location = [ $location_num % 3, floor( $location_num / 3 ) ];
        
        $dx = $current[0] - $location[0];
        $dy = $current[1] - $location[1];

        // print_r( $current );
        // echo "Go to $num";

        $move_x = ( $dx > 0 ) ? str_repeat('<', $dx ) : str_repeat('>', abs( $dx ));
        $move_y = ( $dy > 0 ) ? str_repeat('^', $dy ) : str_repeat('v', abs( $dy ));

        // If top row of arrow keys, move vertically first to avoid gap
        if ( $current[1] === 0 ) {
            $move .= $move_y . $move_x . 'A';
        } else {
            $move .= $move_x . $move_y . 'A';
        }

        $current = $location;
    }

    // echo $move;
    return $move;
}

echo PHP_EOL . 'Day 21: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;