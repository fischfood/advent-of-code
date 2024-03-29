<?php

/**
 * Day 03: Gear Ratios
 */

// The usual
$data = file_get_contents('data/data-03.txt');
//$data = file_get_contents('data/data-03-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $num_sym = build_map( $rows );

    $numbers = $num_sym[0];
    $symbols = $num_sym[1];

    $part_numbers = check_for_parts( $numbers, $symbols );

    echo array_sum( $part_numbers );
}

// Part Two
function part_two($rows) {

    $num_sym = build_map( $rows );

    $numbers = $num_sym[0];
    $symbols = $num_sym[1];

    $gear_numbers = check_for_gears( $numbers, $symbols );

    echo array_sum( $gear_numbers );
}

function build_map( $rows ) {

    $numbers = [];
    $symbols = [];
    $i = 1;

    foreach( $rows as $rnum => $row_string ) {
        $row = str_split( $row_string );

        $staged = '';
        $staged_pos = [];

        foreach( $row as $pos => $char ) {

            // If it is a number, start building
            if ( is_numeric( $char ) ) {

                $staged .= $char;
                $staged_pos[] = $pos . ',' . $rnum;

                // If last number in a row, make sure to submit it
                // This failed for me for way too long...
                if ( $pos + 1 === count($row) ) {
                    $numbers[$i . '_' . $rnum . '-' . $staged] = $staged_pos;
                    $staged = '';
                    $staged_pos = [];
                }
            
            } else {

                // If a number exists, log it and reset
                if ( $staged !== '' ) {
                    $numbers[$i . '_' . $rnum . '-' . $staged] = $staged_pos;
                    
                    $staged = '';
                    $staged_pos = [];
                }

                if ( '.' !== $char ) {
                    // Add x,y of symbol to list
                    $symbols[] = [$pos, $rnum, $char];
                }
            }

            $i++;
        }
    }


    return [$numbers, $symbols];
}

function check_for_parts( $numbers, $symbols ) {

    $part_numbers = [];
    
    foreach( $symbols as $symbol ) {
        //echo 'Coord: ' . $symbol[0] . ',' . $symbol[1] . PHP_EOL;
        for ( $x = -1; $x <= 1; $x++ ) {
            for ( $y = -1; $y <= 1; $y++ ) {
                $coord_to_check =  ($symbol[0]) + $x . ',' . ($symbol[1] + $y);

                //echo 'Checking: ' . $coord_to_check;
                
                foreach( $numbers as $number => $coords ) {
                    if ( in_array( $coord_to_check, $coords ) ) {
                        //echo ' - Found: ' . $number;
                        unset( $numbers[$number] );
                        $part_numbers[] = substr($number, strpos($number, "-") + 1);
                        //echo PHP_EOL . '---- Adding' . substr($number, strpos($number, "-") + 1);
                    }
                }

                //echo PHP_EOL;
            }
        }
    }
    
    return $part_numbers;
}

function check_for_gears( $numbers, $symbols ) {

    $gear_numbers = [];
    
    foreach( $symbols as $symbol ) {
        $maybe_gears = [];

        if ( '*' === $symbol[2] ) {

            for ( $x = -1; $x <= 1; $x++ ) {
                for ( $y = -1; $y <= 1; $y++ ) {
                    $coord_to_check =  ($symbol[0]) + $x . ',' . ($symbol[1] + $y);
                    
                    foreach( $numbers as $number => $coords ) {
                        if ( in_array( $coord_to_check, $coords ) ) {
                            unset( $numbers[$number] );
                            $maybe_gears[] = substr($number, strpos($number, "-") + 1);
                        }
                    }
                }
            }
        }

        if ( count( $maybe_gears ) === 2 ) {
            $gear_numbers[] = $maybe_gears[0] * $maybe_gears[1];
        }
    }
    
    return $gear_numbers;
}

echo PHP_EOL . 'Day 03: Gear Ratios' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;