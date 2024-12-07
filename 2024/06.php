<?php

/**
 * Day 06: TITLE
 */

// The usual
$data = file_get_contents('data/data-06.txt');
$data = file_get_contents('data/data-06-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
//include_once( '../functions.php' );

$starttime = microtime(true);

// Part One
function part_one($dataset) {
    $map = [];
    $rocks = [];
    $security = [];
    $visited = [];
    $dir = 0;

    $x_bounds = strlen( $dataset[0] ) - 1;
    $y_bounds = count( $dataset ) - 1;

    foreach( $dataset as $y => $x_row ) {
        $xs = str_split( $x_row, 1 );

        foreach( $xs as $x => $char ) {
            $map[$y][$x] = $char;

            if ( $char === '#' ) {
                $rocks[$x . ',' . $y] = '#';
            }
            if ( $char === '^' ) {
                $security = [$x,$y];
                $visited[$x . ',' . $y] = 'X';
                $map[$security[1]][$security[0]] = '^';
            }
        }
    }

    $walk = true;

    while ( $walk ) {
        $next = $security;

        switch ($dir) {
            case 0:
                $next[1]--;
                break;
            case '1':
                $next[0]++;
                break;
            case '2':
                $next[1]++;
                break;
            case '3':
                $next[0]--;
                break;
        }

        $check_rock = implode( ',', $next );

        if ( array_key_exists( $check_rock, $rocks ) ) {
            // Found Rock, turning
            $dir++;

            // Rotate
            if ( $dir > 3 ) { $dir = 0; }

        } else { 

            // Allow to move
            $security = $next;
            $visited[implode( ',', $security )] = 'X';

            if ( $security[0] <= 0 || $security[0] >= $x_bounds || $security[1] <= 0 || $security[1] >= $y_bounds ) {
                // Out of Bounds;
                $walk = false;
            } else {
                // Mark the map
                $map[$security[1]][$security[0]] = 'X';
            }
        }
    }

    echo count( $visited );

    // foreach( $map as $x ) {
    //     echo "\n" . implode($x);
    // }
}

// Part Two
function part_two($dataset) {
    $map = [];
    $rocks = [];
    $security = [];
    $visited = [];
    $dir = 0;
    $obs = 0;

    $x_bounds = strlen( $dataset[0] ) - 1;
    $y_bounds = count( $dataset ) - 1;

    foreach( $dataset as $y => $x_row ) {
        $xs = str_split( $x_row, 1 );

        foreach( $xs as $x => $char ) {
            $map[$y][$x] = $char;

            if ( $char === '#' ) {
                $rocks[$x . ',' . $y] = '#';
            }
            if ( $char === '^' ) {
                $security = [$x,$y];
                $visited[$x . ',' . $y] = '0';
                $map[$security[1]][$security[0]] = '^';
            }
        }
    }

    $walk = true;

    while ( $walk ) {
        //echo "\nI'm at " . implode( ',', $security ) . " going $dir - ";
        $next = $security;

        switch ($dir) {
            case 0:
                $next[1]--;
                $right = [0, '+', 'x'];
                break;
            case '1':
                $next[0]++;
                $right = [1, '+', 'y'];
                break;
            case '2':
                $next[1]++;
                $right = [0,'-', 'x'];
                break;
            case '3':
                $next[0]--;
                $right = [1,'-', 'y'];
                break;
        }

        $check_rock = implode( ',', $next );

        // I'm only checking the immediate, I need to check all!
        // $check_right = implode( ',', $right );

        // if ( array_key_exists( $check_right, $visited ) ) {
        //     $right_dir = ( $dir === 3 ) ? '0' : $dir + 1 ;

        //     echo "Checking $check_right for $right_dir in " . $visited[$check_right];

        //     if ( str_contains( $right_dir, $visited[$check_right] ) ) {
        //         echo ' - Id loop here';
        //         $obs++;
        //     }
        // }

        // Check All Rights from here
        $would_loop = false;
        $right_dir = ( $dir === 3 ) ? '0' : $dir + 1 ;

        //echo "\n" . implode( ',', $security );
        if ( $right[1] === '+' ) {
            for ( $r = $security[$right[0]]; $r < ${$right[2] . '_bounds'}; $r++ ) {
                if ( $right[2] === 'x' ) {
                    $check_right = $r . ',' . $security[1];
                } else {
                    $check_right = $security[0] . ',' . $r;
                }

                if ( array_key_exists( $check_right, $visited ) ) {
                    if ( str_contains( $right_dir, $visited[$check_right] ) ) {
                        $would_loop = true;
                    }
                }

                // We need to check if we'll hit a rock then look to the right of that
                if ( array_key_exists( $check_right, $rocks ) ) {
                    echo 'check_rock';
                }
            }

        } else {
            for ( $r = $security[$right[0]]; $r > 0; $r-- ) {
                if ( $right[2] === 'x' ) {
                    $check_right = $r . ',' . $security[1];
                } else {
                    $check_right = $security[0] . ',' . $r;
                }

                if ( array_key_exists( $check_right, $visited ) ) {
                    if ( str_contains( $right_dir, $visited[$check_right] ) ) {
                        $would_loop = true;
                    }
                }
            }
        }

        if ( $would_loop === true ) {
            //echo "\nAdd rock at " . implode(',', $next);
            $obs++;
        }

        if ( array_key_exists( $check_rock, $rocks ) ) {
            // Found Rock, turning
            $dir++;
            //echo ' - turning';

            // Rotate
            if ( $dir > 3 ) { $dir = 0; }

        } else { 

            // Allow to move
            $security = $next;
            $coord = implode( ',', $security );

            if ( array_key_exists( $coord, $visited ) ) {
                $visited[ $coord ] .= $dir;
            } else {
                $visited[ $coord ] = $dir;
            }

            if ( $security[0] <= 0 || $security[0] >= $x_bounds || $security[1] <= 0 || $security[1] >= $y_bounds ) {
                // Out of Bounds;
                $walk = false;
            } else {
                // Mark the map
                $map[$security[1]][$security[0]] = 'X';
            }
        }
    }

    echo $obs;
}

echo PHP_EOL . 'Day 06: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;