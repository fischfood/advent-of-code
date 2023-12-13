<?php

/**
 * Day 13: Point of Incidence
 */

// The usual
$data = file_get_contents('data/data-13.txt');
//$data = file_get_contents('data/data-13-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    
    $mirrors = create_mirrors( $rows );

    $horizontals = find_horizontal( $mirrors );
    $verticals = find_vertical( $mirrors, $horizontals );

    echo array_sum( array_merge( $horizontals, $verticals ) );
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function create_mirrors( $rows ) {
    $i = 0;
    $mirrors = [];

    foreach ( $rows as $row ) {
        if ( empty( $row ) ) {
            $i++;
        } else {
            $mirrors[$i][] = $row;
        }
    }

    return $mirrors;
}

function rotate_mirror( $rows ) {

}

function find_horizontal( $mirrors, $multiplier = 100 ) { 

    $horizontals = [];

    foreach ( $mirrors as $m => $mirror_rows ) {

        $total_rows = count( $mirror_rows ) - 1;

        for ( $r = 0; $r < $total_rows; $r++ ) {

            // Find a duplicate row, and check +/-
            if ( $mirror_rows[$r] === $mirror_rows[$r + 1] ) {
                $try = true;

                // 0 cuts off reflection
                if ( $r < ( $total_rows / 2 ) ) {

                    // Go back one row until 0, or reflection stops
                    for ( $n = 1; ($r - $n) >= 0; $n++) {
                        if ( $mirror_rows[$r - $n] !== $mirror_rows[ $r + 1 + $n] ) {
                            $try = false;
                        }
                    }

                // Ends cuts off reflection 
                } else {
                
                    for ( $n = 1; ($r + $n + 1) <= $total_rows; $n++) {
                        if ( $mirror_rows[ $r - $n ] !== $mirror_rows[$r + 1 + $n] ) {
                            $try = false;
                        }
                    }
                }

                if ( $try == true ) {
                    $horizontals[$m] = ($r + 1) * $multiplier;
                }
            }
        }
    }

    return $horizontals;
}

function find_vertical( $mirrors, $exclude ) {
    
    $non_horizontals = [];

    foreach ( $mirrors as $m => $mirror_rows ) {

        if ( ! array_key_exists( $m, $exclude ) ) {
            $not_yet_vertical = [];

            foreach( $mirror_rows as $rnum => $row ) {
                foreach( str_split( $row ) as $col => $r ) {

                    if ( array_key_exists( $col, $not_yet_vertical ) ) {
                        $not_yet_vertical[$col] = $not_yet_vertical[$col] . $r;
                    } else {
                        $not_yet_vertical[$col] = $r;
                    }
                }
            }
            $non_horizontals[$m] = $not_yet_vertical;
        }
    }

    return find_horizontal( $non_horizontals, 1 );
}

echo PHP_EOL . 'Day 13: Point of Incidence' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;