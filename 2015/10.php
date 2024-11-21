<?php
ini_set('memory_limit', '10G');

/**
 * Day 10: TITLE
 */

// The usual
$data = 1321131112;
//$data = 1;

// Part One
function look_and_say( $data, $limit ) {

    $ds = $data;

    for ( $i = 1; $i <= $limit; $i++ ) {
        $j = 0;
        $current = '';

        //echo 'checking ' . $ds . "\n";
        $d = str_split( $ds );
        $ds = '';
        $da = [];

        foreach( $d as $num ) {
            if ( $num === $current ) {
                $total = $da[$j][1];
                $da[$j] = [$num, $total + 1];
            } else {
                $j++;
                $da[$j] = [$num, 1];
            }
            $current = $num;
        }

        foreach( $da as $k => $da_data ) {
            $ds = $ds . $da_data[1] . $da_data[0];
        }
    }

    echo strlen( $ds );
}

echo PHP_EOL . 'Day 10: TITLE' . PHP_EOL . 'Part 1: ';
look_and_say( $data, 40 );
echo PHP_EOL . 'Part 2: ';
//look_and_say( $data, 50 );
echo PHP_EOL . PHP_EOL;