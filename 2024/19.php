<?php

/**
 * Day 19: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-19.txt');
// $data = file_get_contents('data/data-19-sample.txt');

$rows = explode("\n\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
    [$towels, $stripes_needed] = $dataset;

    $towels = explode( ', ', $towels );
    $stripes_needed = explode( "\n", $stripes_needed );

    // Check longest first
    usort($towels, fn($a, $b) => strlen($b) - strlen($a));

    $total = 0;
    
    foreach ( $stripes_needed as $stripes ) {
        //echo "\n Checking $stripes";
        if ( build_stripes_needed( $stripes, $towels ) ) {
            $total++;
        }
    }

    echo $total;
}

// Part Two
function part_two($dataset) {
	[$towels, $stripes_needed] = $dataset;

    $towels = explode( ', ', $towels );
    $stripes_needed = explode( "\n", $stripes_needed );

    // Check longest first
    usort($towels, fn($a, $b) => strlen($b) - strlen($a));

    $ways = 0;
    
    foreach ( $stripes_needed as $stripes ) {
        $ways += build_stripes_needed( $stripes, $towels, true );
    }

    echo $ways;
}

function build_stripes_needed( $stripes_needed, $towels, $count_ways = false, &$cache = [] ) {
    
    // If we found a previous string, get the total
    if ( isset( $cache[$stripes_needed] ) ) {
        return $cache[$stripes_needed];
    }

    // If we've removed all stripes, towel is complete
    if ( $stripes_needed === '' ) {
        return true;
    }

    $ways = 0;

    foreach ( $towels as $towel ) {

        // If we find this pattern in the beginning, remove it
        if ( strpos( $stripes_needed, $towel ) === 0 ) {
            $remaining_stripes = substr( $stripes_needed, strlen( $towel ) );

            // If we need total ways, keep adding
            if ( $count_ways ) {
                $ways += build_stripes_needed( $remaining_stripes, $towels, $count_ways, $cache );
            } 
            // Otherwise, just return a single success
            else {
                if ( build_stripes_needed( $remaining_stripes, $towels, $count_ways, $cache ) ) {
                    return true;
                }
            }
        }
    }

    // Cache the result, return the total
    $cache[$stripes_needed] = $ways;
    return $ways;
}

echo PHP_EOL . 'Day 19: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;