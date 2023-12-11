<?php

/**
 * Day 11: Cosmic Expansion
 */

// The usual
$data = file_get_contents('data/data-11.txt');
//$data = file_get_contents('data/data-11-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    
    [$expanded_rows, $expanded_cols] = expand_universe( $rows );
    $galaxies = find_galaxies( $rows );

    echo traverse_the_universe( $galaxies, $expanded_rows, $expanded_cols, 2 );
    
}

// Part Two
function part_two($rows) {
    
    [$expanded_rows, $expanded_cols] = expand_universe( $rows );
    $galaxies = find_galaxies( $rows );

    echo traverse_the_universe( $galaxies, $expanded_rows, $expanded_cols, 1000000 );
}

function expand_universe( $rows ) {

    $expanded_rows = [];
    $expanded_columns = [];
    $columns = [];

    // Find Empty Rows
    for ( $r = 0; $r < count( $rows ); $r++ ) {
        if ( count( array_unique( str_split( $rows[$r] ) ) ) === 1 ) {
            $expanded_rows[] = $r;
        }
    }

    // Get Columns
    foreach( $rows as $row ) {
        foreach( str_split( $row ) as $col => $r ) {
            $columns[$col][] = $r;
        }
    }

    // Find Empty Columns
    foreach( $columns as $col => $values ) {
        if ( count( array_unique( $values ) ) === 1 ) {
            $expanded_cols[] = $col;
        }
    }

    return [$expanded_rows, $expanded_cols];
}

function find_galaxies( $universe ) {
    $galaxies = [];

    foreach( $universe as $y => $columns ) {
        foreach( str_split( $columns ) as $x => $symbol ) {
            if ( '#' === $symbol ) {
                $galaxies[] = [$x, $y];
            }
        }
    }

    return $galaxies;
}

function traverse_the_universe( $galaxies, $ex_rows, $ex_cols, $expansion = 2 ) {

    $add = $expansion - 1;
    $total_steps = [];

    // For each Galaxy
    for ( $g = 0; $g < count( $galaxies ); $g++ ) {

        // Get distance to remaining galaxies
        for ( $ng = $g + 1; $ng < count( $galaxies ); $ng++ ) {

            $distance = abs( $galaxies[$ng][0] - $galaxies[$g][0] ) + abs( $galaxies[$ng][1] - $galaxies[$g][1] );

            // Get and sort X and Y coords
            $xs = [$galaxies[$ng][0], $galaxies[$g][0]];
            $ys = [$galaxies[$ng][1], $galaxies[$g][1]];

            // Order low to high
            asort( $xs );
            asort( $ys );

            $xs = array_values($xs);
            $ys = array_values($ys);

            // If an expansion row is in between the two coordinates
            foreach( $ex_cols as $ex_c ) {
                if ( $ex_c > $xs[0] && $ex_c < $xs[1] ) {
                    $distance += $add;
                }
            }

            foreach( $ex_rows as $ex_r ) {
                if ( $ex_r > $ys[0] && $ex_r < $ys[1] ) {
                    $distance += $add;
                }
            }
            
            $total_steps["$g-$ng"] = $distance;
        }
    }

    return array_sum( $total_steps );

}

echo PHP_EOL . 'Day 11: Cosmic Expansion' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;