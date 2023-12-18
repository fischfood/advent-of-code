<?php

/**
 * Day 18: Lavaduct Lagoon
 */

// The usual
$data = file_get_contents('data/data-18.txt');
//$data = file_get_contents('data/data-18-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $start = microtime( true );

    [$grid, $sides] = get_perimeter( $rows );
    $total_area = shoelace( $grid );

    $inner_corners = count( $grid ) - 1;
    
    $inner_add = ( $inner_corners / 2 ) - 2;
    $outer_add = ( $inner_corners / 2 ) + 2;
    
    echo $total_area + ( $sides / 2 ) + ( $inner_add * .25 ) + ( $outer_add * .75 );

}

// Part Two
function part_two($rows) {

    [$grid, $sides] = get_perimeter( $rows, 'hex' );
    $total_area = shoelace( $grid );

    $inner_corners = count( $grid ) - 1;
    
    $inner_add = ( $inner_corners / 2 ) - 2;
    $outer_add = ( $inner_corners / 2 ) + 2;
    
    echo $total_area + ( $sides / 2 ) + ( $inner_add * .25 ) + ( $outer_add * .75 );
    
}

function get_perimeter( $rows, $hex = false ) {
    $corners = [ [0,0] ];
    $sides = 0;

    $x = 0;
    $y = 0;

    foreach( $rows as $row ) {
        $row = explode( ' ', $row );

        $dir = $row[0];
        $length = $row[1];
        $color = preg_replace( '/[^a-z0-9]/', '', $row[2] );

        if ( $hex == true ) {
            $new_data = str_split( $color, 5 );
            $dir = $new_data[1];

            $length = base_convert( $new_data[0], 16, 10 );
        }

        $sides += $length - 1;

        // Assume inner is down/right from start
        if ( $dir === 'L' || $dir === '2' ) { $x -= $length; }
        if ( $dir === 'R' || $dir === '0' ) { $x += $length; }
        if ( $dir === 'U' || $dir === '3' ) { $y -= $length; }
        if ( $dir === 'D' || $dir === '1' ) { $y += $length; }

        $corners[] = [ $x, $y ];
    }

    return [ $corners, $sides ];
}

function shoelace( $corners ) {

    $total = 0;

    for ( $c = 0; $c < count( $corners ) - 1; $c++ ) {
        $left = ( $corners[$c][0] * $corners[$c+1][1] );
        $right = ( $corners[$c][1] * $corners[$c+1][0] );

        $total += ( $left - $right );
    }

    return $total / 2;

}

echo PHP_EOL . 'Day 18: Lavaduct Lagoon' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;