<?php

/**
 * Day 09: Disk Fragmenter
 * Part 1: 74.57541 Seconds
 * Part 2: 0.00000 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-09.txt');
$data = file_get_contents('data/data-09-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $steps;

// Part One
function part_one($dataset) {
    
    $i = 0;
    $string = '';
    $total = 0;

    $blocks = [];

    foreach( $dataset as $k => $d ) {
        if ( $k % 2 ) {
            $string .= str_repeat( '.', intval( $d ) );
            for ( $num = 0; $num < $d; $num++ ) {
                $blocks[] = '.';
            }
        } else {
            $string .= str_repeat( $i, intval( $d ) );
            for ( $num = 0; $num < $d; $num++ ) {
                $blocks[] = $i;
            }
            $i++;
        }
        
    }

    $string = implode('', $blocks );

    while( str_contains( $string, '.' )) {

        $next_pos = array_search( '.', $blocks );
        $last = end( $blocks );

        if ( $last !== '.' ) {
            $blocks[ $next_pos ] = $last;
        }

        array_pop( $blocks );
        $string = implode( '', $blocks );
    }

    foreach( $blocks as $k => $b ) {
        $total += ( $k * $b );
    }

    echo $total;

}

// Part Two
function part_two($dataset) {
	
}

echo PHP_EOL . 'Day 09: Disk Fragmenter' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;