<?php

/**
 * Day 04: Ceres Search
 */

// The usual
$data = file_get_contents('data/data-04.txt');
//$data = file_get_contents('data/data-04-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
    $Xs = [];
    $Ms = [];
    $As = [];
    $Ss = [];
    $total = 0;
    
    // Set each coordinate into its own character map, using a variable variable
    foreach( $dataset as $y => $d ) {
        $row = str_split( $d );

        foreach( $row as $x => $char ) {
            ${$char . 's'}[$x . ',' . $y] = $char;
        }
    }

    // Start with X
    foreach( $Xs as $coords => $xx ) {
        list( $x, $y ) = explode( ',', $coords );

        // Possible directions, no 0,0
        $check = [
            [-1,-1],[-1,0],[-1,1],
            [0,-1],[0,1],
            [1,-1],[1,0],[1,1],
        ];

        // Check each direction change for the M
        foreach( $check as $dir ) {
            list( $change_x, $change_y ) = $dir;
            $m_x = $x + $change_x;
            $m_y = $y + $change_y;

            // If found, keep going that direction only
            if ( array_key_exists( $m_x . ',' . $m_y, $Ms ) ) {
                $a_x = $m_x + $change_x;
                $a_y = $m_y + $change_y;

                // Search for the A
                if ( array_key_exists( $a_x . ',' . $a_y, $As ) ) {
                    $s_x = $a_x + $change_x;
                    $s_y = $a_y + $change_y;

                    // Search for the S, and log if found
                    if ( array_key_exists( $s_x . ',' . $s_y, $Ss ) ) {
                        $total++;
                    }
                }
            }
        }
    }

    echo $total;

}

// Part Two
function part_two($dataset) {
    $Xs = []; // Unused
	$Ms = [];
    $As = [];
    $Ss = [];
    $total = 0;
    
    // Same maping, X isn't important but it'll create it anyway
    foreach( $dataset as $y => $d ) {
        $row = str_split( $d );

        foreach( $row as $x => $char ) {
            ${$char . 's'}[$x . ',' . $y] = $char;
        }
    }

    // Start from the A's
    foreach( $As as $coords => $aa ) {
        list( $x, $y ) = explode( ',', $coords );

        // The X is only in X shape, not +
        // Create the coordinates to check for the four diagonals
        $tl = ($x - 1) . ',' . ($y - 1);
        $br = ($x + 1) . ',' . ($y + 1);
        $tr = ($x + 1) . ',' . ($y - 1);
        $bl = ($x - 1) . ',' . ($y + 1);

        // Check is MS or SM exists on one slant, and if so, check for the same on the other
        // If found, log it
        if ( ( array_key_exists( $tl, $Ms) && ( array_key_exists( $br, $Ss ) ) || array_key_exists( $tl, $Ss) && ( array_key_exists( $br, $Ms ) ) ) ) {
            if ( ( array_key_exists( $tr, $Ms) && ( array_key_exists( $bl, $Ss ) ) || array_key_exists( $tr, $Ss) && ( array_key_exists( $bl, $Ms ) ) ) ) {
                $total++;
            }
        }

    }

    echo $total;
}

echo PHP_EOL . 'Day 04: Ceres Search' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;
