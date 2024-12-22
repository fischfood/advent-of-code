<?php

/**
 * Day 22: Monkey Market
 * Part 1: 60.66373 Seconds
 */

// The usual
ini_set('memory_limit', '10G');
$starttime = microtime(true);
$data = file_get_contents('data/data-22.txt');
$data = file_get_contents('data/data-22-sample.txt');
$data = 123;

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {
    $total = 0;
    $cache = [];

    foreach( $dataset as $num ) {
        $orig = $num;
        
        for ( $i = 0; $i < 10; $i++ ) {
            $this_num = $num;

            if ( array_key_exists( $this_num, $cache ) ) {
                $num = $cache[$this_num];

            } else {
                $s1 = prune( mix( $num * 64, $num ) );
                $s2 = prune( mix( floor( $s1 / 32 ), $s1 ) );
                $s3 = prune( mix( $s2 * 2048, $s2 ) );

                // echo "\n . $s3";
                $num = $s3;
                $cache[ $this_num ] = $num;
            }
        }

        // echo "\n$orig: $num";
        $total += $num;
    }

    echo count( $cache ) . ' - ';
    echo $total;
}

// Part Two
function part_two($dataset) {
	$total = 0;
    $cache = [];
    $changes = [];

    foreach( $dataset as $num ) {
        $orig = $num;
        $changes[$num][] = substr($num, -1);
        
        for ( $i = 0; $i < 9; $i++ ) {
            $this_num = $num;

            if ( array_key_exists( $this_num, $cache ) ) {
                $num = $cache[$this_num];

            } else {
                $s1 = prune( mix( $num * 64, $num ) );
                $s2 = prune( mix( floor( $s1 / 32 ), $s1 ) );
                $s3 = prune( mix( $s2 * 2048, $s2 ) );

                // echo "\n . $s3";
                $num = $s3;
                $cache[ $this_num ] = $num;
            }

            $changes[$orig][] = substr($num, -1);
        }

        echo "\n$orig: $num";
        $total += $num;
    }

    print_r( $changes );
}

function mix( $num, $secret ) {

    $val = '';
    $bin_n = str_pad( decbin( $num ), 64, 0, STR_PAD_LEFT );
    $bin_s = str_pad( decbin( $secret ), 64, 0, STR_PAD_LEFT );

    foreach( str_split( $bin_n ) as $k => $bb ) {
        if ( $bin_n[$k] == $bin_s[$k] ) {
            $val .= '0';
        } else {
            $val .= '1';
        }
    }

    $val = intval( bindec( $val ) );
    return $val;
}

function prune( $num ) {
    return $num % 16777216;
}

echo PHP_EOL . 'Day 22: Monkey Market' . PHP_EOL . 'Part 1: ';
// part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;