<?php

/**
 * Day 11: Cosmic Expansion
 */

// The usual
$data = file_get_contents('data/data-11.txt');
$data = file_get_contents('data/data-11-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    
    $expanded = expand_universe( $rows );
    //print_r( $expanded );
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function expand_universe( $rows ) {

    $columns = [];

    // Add Rows
    for ( $r = 0; $r < count( $rows ); $r++ ) {
        if ( count( array_unique( str_split( $rows[$r] ) ) ) === 1 ) {
            array_splice( $rows, $r, 0, $rows[$r] );
            $r++;
        }
    }

    // Get Columns
    foreach( $rows as $row ) {
        foreach( str_split( $row ) as $col => $r ) {
            $columns[$col][] = $r;
        }
    }

    $rev_cols = array_reverse( $columns, true );

    foreach( $rev_cols as $col => $values ) {
        if ( count( array_unique( $values ) ) === 1 ) {
            foreach( $rows as $k => $row ) {
                $row_split = str_split( $row );

                array_splice( $row_split, $col, 0, '.' );

                $rows[$k] = implode( '', $row_split );
            }
        }
    }

    return $rows;
}

echo PHP_EOL . 'Day 11: Cosmic Expansion' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;