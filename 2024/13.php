<?php

/**
 * Day 13: Claw Contraption
 * Part 1: 0.00165 Seconds
 * Part 2: 0.00168 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-13.txt');
// $data = file_get_contents('data/data-13-sample.txt');

$rows = explode("\n\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {
    $total = 0;

    foreach( $dataset as $g => $game ) {
        [$a, $b, $p] = explode( "\n", $game );
        $total += run_presses( $a, $b, $p );
    }   

    echo $total;
}

// Part Two
function part_two($dataset) {

	$total = 0;

    foreach( $dataset as $g => $game ) {
        [$a, $b, $p] = explode( "\n", $game );
        $total += run_presses( $a, $b, $p, 10000000000000, PHP_INT_MAX );
    }   

    echo $total;
}

function run_presses( $a, $b, $p, $inc = 0, $max = 100 ) {
    $total = 0;

    preg_match_all( '/[0-9]{1,3}/', $a, $a_match );
    preg_match_all( '/[0-9]{1,3}/', $b, $b_match );
    preg_match_all( '/[0-9]{1,9}/', $p, $p_match );

    list( $a1, $a2 ) = $a_match[0];
    list( $b1, $b2 ) = $b_match[0];
    list( $p1, $p2 ) = $p_match[0];

    $p1 = $inc + $p1;
    $p2 = $inc + $p2;

    // Cost: A = 3, B = 1;
    
    // Button A: X+94, Y+34
    // Button B: X+22, Y+67
    // Prize: X=8400, Y=5400

    // Ax + By = C .. or [$a1]X + [$b1]Y = $c1 (Really $p1)
    // 94x + 22y = 8400
    // 34x + 67y = 5400

    // Eliminate X
    // 34( 94x + 22y ) = 34(8400) || 3196x + 748y = 285600
    // 94( 36x + 67y ) = 94(5400) || 3196x + 6298y = 507600
    $new_b1 = $b1 * $a2;
    $new_p1 = $p1 * $a2;
    $new_b2 = $b2 * $a1;
    $new_p2 = $p2 * $a1;

    // Subtract 2 from 1
    // (748 - 6298)y = (285600 - 507600) || -5500y = -222,000
    $b_tot = $new_b1 - $new_b2;
    $p_tot = $new_p1 - $new_p2;

    // -222,000 / -5500 = 40 = Y

    // Avoid divide by 0
    if ( $b_tot !== 0 ) {

        $y = $p_tot / $b_tot;

        // If not a decimal, plug it in
        if ( ! str_contains( $y, '.' ) && $y <= $max) {
            
            // 94x + 22(40) = 8400 || 94x + 880 = 8400
            // 94x = 7520 || 7520 / 94 = x

            $x = ( $p1 - ( $b1 * $y ) ) / $a1;

            // If no decimals, success
            if ( ! str_contains( $x, '.' ) && $x <= $max ) {
                // A = Y ($3), B = X ($1)
                $total += ( $y * 1 );
                $total += ( $x * 3 );            
            }
        }
    }

    return $total;
}

echo PHP_EOL . 'Day 13: Claw Contraption' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;