<?php

/**
 * Day 02: I Was Told There Would Be No Math
 */

// The usual
$data = file_get_contents('data/data-02.txt');
$rows = explode("\n", $data);

$sample_a = ['2x3x4'];
$sample_b = ['1x1x10'];

$dataset = $rows;

// Helper - Order Sides/Measurements Numerically
function box_sides_s2l( $box, $calc = 'area' ) {

    $bd = explode( 'x', $box );
    $dimensions = [];

    if ( 'area' === $calc ) {
        // P1: Area
        $dimensions[] = $bd[0] * $bd[1];
        $dimensions[] = $bd[0] * $bd[2];
        $dimensions[] = $bd[1] * $bd[2];
    } else {
        // P2: Perimeter + Volumne
        $dimensions[] = $bd[0];
        $dimensions[] = $bd[1];
        $dimensions[] = $bd[2];
        $dimensions[] = $bd[0] * $bd[1] * $bd[2];
    }

    // Sort low to high
    sort( $dimensions );
    return $dimensions;
    
}

// Part One - How many total square feet of wrapping paper should they order?
function part_one($dataset) {
    
    $total_sqft = 0;

    // Get Dimensions of each box
    foreach( $dataset as $box ) {
        
        $bd = box_sides_s2l($box);

        // Total = All 6 sides, plus extra of the smallest side
        $sqft = ( 2 * ( $bd[0] + $bd[1] + $bd[2] ) ) + $bd[0];

        // Add it to the total
        $total_sqft = $total_sqft + $sqft;
        
    }

    return sprintf( 'We need %d sq/ft of paper', $total_sqft);
}

// Part Two - How many total feet of ribbon should they order?
function part_two($dataset) {

	$total_ft = 0;

    // Get Dimensions of each box
    foreach( $dataset as $box ) {
        
        $bd = box_sides_s2l($box, 'perimeter');

        // Total = Two smallest perimeters, twice, plus total volume
        $ft = ( 2 * ( $bd[0] + $bd[1] ) ) + $bd[3];

        // Add it to the total
        $total_ft = $total_ft + $ft;
        
    }

    return sprintf( 'and %d ft of ribbon!', $total_ft);
}

echo PHP_EOL . 'Day 02: I Was Told There Would Be No Math' . PHP_EOL;
echo 'Part 1: ' . part_one($dataset) . PHP_EOL;
echo 'Part 2: ' . part_two($dataset) . PHP_EOL . PHP_EOL;