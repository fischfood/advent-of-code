<?php

/**
 * Day 17: Chronospatial Computer
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-17.txt');
// $data = file_get_contents('data/data-17-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include_once( '../functions.php' );

// Part One
function part_one($dataset) {
    $a = substr($dataset[0], strpos($dataset[0], ":") + 1);
    $b = substr($dataset[1], strpos($dataset[1], ":") + 1);
    $c = substr($dataset[2], strpos($dataset[2], ":") + 1);

    $vals = [$a,$b,$c];
    
    $ops = explode( ',', trim( substr($dataset[4], strpos($dataset[4], ":") + 1) ) );

    $output = [];

    for( $o = 0; $o < count( $ops ); $o = $o+2 ) {

        $oo = $o + 1;

        if ( array_key_exists( $o, $ops ) && array_key_exists( $oo, $ops ) ) {
            // echo "\n\n Running $o, $oo";
            // echo "\ndo $ops[$o] with $ops[$oo] ";
            [ $vals, $new_o, $output ] = evaluate( $ops[$o], $ops[$oo], $vals, $o, $output );
            // echo "\n" . implode( ' - ' , $vals);
            // echo " out: " . implode(',', $output );

            if ( $new_o !== $o ) {
                $o = $new_o - 2;
            }
        }

    }

    echo implode( ',', $output );
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function evaluate( $inst, $combo, $vals, $iteration, $output ) {
    [$a, $b, $c] = $vals;

    $literal_combo = $combo;

    switch( $combo ) {
        case 4:
            $combo = $a;
            break;
        case 5:
            $combo = $b;
            break;
        case 6: 
            $combo = $c;
            break;
    }

    switch( $inst ) {
        case 0: // adv
            $val = $a / pow( 2, $combo );
            $a = intval($val);
            break;

        case 1: //bxl
            $val = '';
            $bin_b = str_pad( decbin( $b ), 26, 0, STR_PAD_LEFT );
            $bin_l = str_pad( decbin( $literal_combo ), 26, 0, STR_PAD_LEFT );

            foreach( str_split( $bin_b ) as $k => $bb ) {
                if ( $bin_b[$k] == $bin_l[$k] ) {
                    $val .= '0';
                } else {
                    $val .= '1';
                }
            }

            $b = intval( bindec( $val ) );
            break;

        case 2: // bst     
            $val = $combo % 8;
            $b = $val;
            break;

        case 3: // jnz
            if ( $a !== 0 ) {
                $iteration = $literal_combo;
            }
            break;

        case 4: // bxc
            $val = '';
            $bin_b = str_pad( decbin( $b ), 26, 0, STR_PAD_LEFT );
            $bin_c = str_pad( decbin( $c ), 26, 0, STR_PAD_LEFT );

            foreach( str_split( $bin_b ) as $k => $bb ) {
                if ( $bin_b[$k] == $bin_c[$k] ) {
                    $val .= '0';
                } else {
                    $val .= '1';
                }
            }

            $b = intval( bindec( $val ) );
            break;

        case 5: // out
            $val = intval($combo) % 8;
            $output[] = $val;
            break;

        case 6: // bdv
            $val = $a / pow( 2, $combo );
            $b = intval($val);
            break;

        case 7: // cdv
            $val = $a / pow( 2, $combo );
            $c = intval($val);
            break;
    }

    $vals = [[$a, $b, $c ], $iteration, $output ];

    return $vals;
}

echo PHP_EOL . 'Day 17: Chronospatial Computer' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;