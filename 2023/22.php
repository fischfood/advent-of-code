<?php

/**
 * Day 22: Sand Slabs
 */

// The usual
$data = file_get_contents('data/data-22.txt');
//$data = file_get_contents('data/data-22-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    [$x_stack, $z_stack] = make_blocks( $rows );

    $x_stack = array_reverse( $x_stack );
    $z_stack = array_reverse( $z_stack );

    foreach( $x_stack as $x ) {
        echo PHP_EOL . implode( '', $x );
    }

    echo PHP_EOL;

    foreach( $z_stack as $x ) {
        echo PHP_EOL . implode( '', $x );
    }

}

// Part Two
function part_two($rows) {
	# Do More Things
}

function make_blocks( $rows ) {
    $x_stack = [];
    $y_stack = [];
    $width = 10;

    $alphabet = range('A', 'Z');

    foreach( $rows as $k => $row ) {
        $block = explode( ',', str_replace( '~', ',', $row ) );

        $x = abs( $block[0] - $block[3] );
        $y = abs( $block[1] - $block[4] );
        $z = abs( $block[2] - $block[5] );

        for ( $iy = $block[2]; $iy <= $block[5]; $iy++ ) {

            if ( ! array_key_exists( $iy, $x_stack ) ) {
                $x_stack[$iy] = array_fill( 0, $width, '.');
            }

            for ( $ix = $block[0]; $ix <= $block[3]; $ix++ ) {

                if ( $x_stack[$iy][$ix] !== '.' ) {
                    $x_stack[$iy][$ix] = '?';
                } else {
                    $x_stack[$iy][$ix] = $alphabet[$k % 26];
                }
            }

            if ( ! array_key_exists( $iy, $y_stack ) ) {
                $z_stack[$iy] = array_fill( 0, $width, '.');
            }

            for ( $iz = $block[0]; $iz <= $block[3]; $iz++ ) {
                if ( $z_stack[$iy][$iz] !== '.' ) {
                    $z_stack[$iy][$iz] = '?';
                } else {
                    $z_stack[$iy][$iz] = $alphabet[$k % 26];
                }
            }
        }

        //echo PHP_EOL . $alphabet[$k] . $x . $y . $z;
    }

    return [ $x_stack, $z_stack];
}



echo PHP_EOL . 'Day 22: Sand Slabs' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;