<?php
ini_set('memory_limit', '10G');
/**
 * Day 11: TITLE
 * Part 1: 0.00000 Seconds
 * Part 2: 0.00000 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-11.txt');
//$data = file_get_contents('data/data-11-sample.txt');

$dataset = explode( ' ', $data );

// Part One
function part_one($dataset) {
    echo count( blink( $dataset, 25 ) );
    
}

// Part Two
function part_two($dataset) {
	echo count( blink( $dataset, 25 ) );
}

function blink( $stones, $times ) {
    /**
     * Rules:
     * 0 -> 1
     * Even Digits = 2 stones (left half, left stone. No leading)
     * If neither, replaced by 2024
     */

    //echo "\n $times " . count( $stones ) . " - " . implode( ' ', $stones );

    if ( $times == '0' ) {
        return $stones;
    }

    $list = [];

    foreach( $stones as $stone ) {
        if ( $stone == 0 ) {
            $list[] = '1';
        } elseif ( strlen( $stone ) % 2 == 0 ) {
            $num = str_split( $stone, strlen( $stone ) / 2 );
            $list[] = $num[0];
            $list[] = intval( $num[1] );
        } else {
            $list[] = $stone * 2024;
        }
    }

    $times--;

    return blink( $list, $times );
}

echo PHP_EOL . 'Day 11: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;