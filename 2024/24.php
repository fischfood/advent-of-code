<?php

/**
 * Day 24: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-24.txt');
// $data = file_get_contents('data/data-24-sample-2.txt');
// $data = file_get_contents('data/data-24-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {

    $values = [];
    $needs = [];
    
    foreach( $dataset as $d ) {
        if ( $d !== '' ) {
            if ( str_contains( $d, ':') ) {
                [$key, $val] = explode( ': ', $d );
                $values[$key] = $val;
            } else {
                preg_match_all( '/(.{1,4}) (AND|OR|XOR) (.{1,4}) -> (.{1,4})/', $d, $matches );
                // print_r( $matches[2] );
                if ( $d != "\n" ) {
                    $needs[$matches[4][0]] = [$matches[2][0], $matches[1][0], $matches[3][0]];
                }
            }
        }
    }

    $i = 0;
    while ( ! empty( $needs ) ) {
        foreach ($needs as $key => $equation ) {
            [ $op, $a, $b ] = $equation;

            if ( array_key_exists( $a, $values ) && array_key_exists( $b, $values ) ) {
                $val = and_or_xor( $op, $a, $b, $values );
                $values[$key] = $val;
                unset( $needs[$key] );
            }
        }
    }

    $binary = '';
    krsort( $values );
    
    foreach( $values as $k => $v ) {
        if ( str_starts_with($k, 'z') ) {
            $binary .= $v;
        }
    }

    echo $binary . ' - ' . bindec( $binary );
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function and_or_xor( $op, $a_key, $b_key, $values ) {

    $a = $values[$a_key];
    $b = $values[$b_key];
    
    switch ($op) {
        case 'AND': 
            $val = ( $a + $b == 2 ) ? 1 : 0;
            break;
        case 'OR':
            $val = ( $a + $b > 0 ) ? 1 : 0;
            break;
        case 'XOR': 
            $val = ( $a + $b == 1 ) ? 1 : 0;
            break;
        }

    return $val;
}

echo PHP_EOL . 'Day 24: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;