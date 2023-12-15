<?php

/**
 * Day 15: Lens Library
 */

// The usual
$data = file_get_contents('data/data-15.txt');
//$data = file_get_contents('data/data-15-sample.txt');

$strings = explode(",", $data);

// Part One
function part_one($strings) {

    $sum = 0;

    foreach( $strings as $string ) {

        $characters = str_split( $string );

        $total = 0;
        foreach( $characters as $char ) {
            
            $total += ord($char);
            $total = $total * 17;
            $total = $total % 256;
        }

        $sum += $total;
    }

    echo $sum;
}

// Part Two
function part_two($strings) {
	
    $contents = array_fill(0,256, [] );

    foreach( $strings as $row => $string ) {

        $label = preg_replace( '/[^a-z]/', '', $string );
        $lens = preg_replace( '/[^0-9]/', '', $string );

        $characters = str_split( $label );

        $total = 0;
        foreach( $characters as $char ) {
            
            $total += ord($char);
            $total = $total * 17;
            $total = $total % 256;
        }

        $box = $total;

        // If remove
        if ( '' == $lens ) {
            unset( $contents[$box][$label] );
        } else {
            $contents[$box][$label] = $lens;
        }
    }

    $focus_power = 0;

    foreach( array_filter( $contents ) as $box_level => $box_contents ) {
        $box_contents = array_values( $box_contents );
        foreach( $box_contents as $slot => $lenses ) {
            $focus_power += ($box_level + 1) * ($slot + 1) * preg_replace( '/[^0-9]/', '', $lenses );
        }
    }

    echo $focus_power;
}

echo PHP_EOL . 'Day 15: Lens Library' . PHP_EOL . 'Part 1: ';
part_one($strings);
echo PHP_EOL . 'Part 2: ';
part_two($strings);
echo PHP_EOL . PHP_EOL;