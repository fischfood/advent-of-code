<?php

/**
 * Day 25: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-25.txt');
// $data = file_get_contents('data/data-25-sample.txt');

$rows = explode("\n\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {
    $locks = [];
    $keys = [];

    foreach( $dataset as $d ) {
        $lines = explode( "\n", $d );

        if ( str_starts_with( $lines[0], '#' ) ) {
            $nums = [];
            for ( $i = 0; $i < strlen( $lines[0] ); $i++ ) {
                $length = -1;
                for ( $l = 0; $l < 7; $l++ ) {
                    if ( $lines[$l][$i] === '#' ) {
                        $length++;
                    }
                }
                $nums[] = $length;
            }
            $locks[] = $nums;
        } else {
            $nums = [];
            for ( $i = 0; $i < strlen( $lines[0] ); $i++ ) {
                $length = -1;
                for ( $l = 0; $l < 7; $l++ ) {
                    if ( $lines[$l][$i] === '#' ) {
                        $length++;
                    }
                }
                $nums[] = $length;
            }
            $keys[] = $nums;
        }
    }

    $passed = 0;

    foreach( $locks as $lock ) {
        foreach( $keys as $key ) {
            // echo "\n Comparing " . implode( ',', $lock ) . ' with ' . implode( ',', $key );
            $pass = true;
            for ( $i = 0; $i < count( $lock ); $i++ ) {
                if ( ( $lock[$i] + $key[$i] ) > 5 ) {
                    $pass = false;
                }
            }
            if ( $pass ) {
                $passed++;
            }
        }
    }

    echo $passed;

}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day 25: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;