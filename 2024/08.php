<?php

/**
 * Day 08: Resonant Collinearity
 * Part 1: 0.00057 Seconds
 * Part 2: 0.00430 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-08.txt');
//$data = file_get_contents('data/data-08-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include_once( '../functions.php' );

// Part One
function part_one($dataset) {
    $nodes = [];
    $antenna = [];

    $x_bounds = strlen( $dataset[0] ) - 1;
    $y_bounds = count( $dataset ) - 1;

    foreach( $dataset as $y => $row ) {

        $row = str_split( $row );

        foreach( $row as $x => $char ) {
            if ( $char !== '.' ) {
                $nodes[$char][] = [$x, $y];
            }
        }
    }

    foreach( $nodes as $char => $node ) {
        for ( $i = 0; $i < count( $node ) - 1; $i++ ) {
            for ( $j = $i + 1; $j < count( $node ); $j++ ) {
                $delta_x = $node[$i][0] - $node[$j][0];
                $delta_y = $node[$i][1] - $node[$j][1];

                $new_first_x = $node[$i][0] + $delta_x;
                $new_first_y = $node[$i][1] + $delta_y;

                $new_second_x = $node[$j][0] - $delta_x;
                $new_second_y = $node[$j][1] - $delta_y;

                if ( $new_first_x >= 0 && $new_first_x <= $x_bounds && $new_first_y >= 0 && $new_first_y <= $y_bounds ) {
                    $antenna[$new_first_x . ',' . $new_first_y] = '#';
                }

                if ( $new_second_x >= 0 && $new_second_x <= $x_bounds && $new_second_y >= 0 && $new_second_y <= $y_bounds ) {
                    $antenna[$new_second_x . ',' . $new_second_y] = '#';
                }
            }
        }
    }

    echo count( $antenna );
}

// Part Two
function part_two($dataset) {
	$nodes = [];
    $node_pos = [];
    $node_count = 0;
    $antenna = [];

    $x_bounds = strlen( $dataset[0] ) - 1;
    $y_bounds = count( $dataset ) - 1;

    $bounds = [$x_bounds, $y_bounds];

    foreach( $dataset as $y => $row ) {

        $row = str_split( $row );

        foreach( $row as $x => $char ) {
            if ( $char !== '.' ) {
                $node_count++;
                $nodes[$char][] = [$x, $y];
                $node_pos[] = $x . ',' . $y;
            }
        }
    }

    foreach( $nodes as $char => $node ) {
        for ( $i = 0; $i < count( $node ) - 1; $i++ ) {
            for ( $j = $i + 1; $j < count( $node ); $j++ ) {

                $a = [ $node[$i][0], $node[$i][1] ];
                $b = [ $node[$j][0], $node[$j][1] ];

                $delta_x = $node[$i][0] - $node[$j][0];
                $delta_y = $node[$i][1] - $node[$j][1];

                // Check first, plus...
                $antenna = add_til_oob( $a, [$delta_x, $delta_y], $char, $bounds, $node_pos);

                // Check second, plus...
                $antenna = add_til_oob( $a, [$delta_x * -1, $delta_y * -1], $char, $bounds, $node_pos );
                

            }
        }
    }

    echo count( $antenna ) + $node_count;
}

function add_til_oob( $this_node, $delta, $char, $bounds, $node_pos) {
    global $antenna;

    list( $this_x, $this_y ) = $this_node;
    list( $delta_x, $delta_y ) = $delta;
    list( $x_bounds, $y_bounds ) = $bounds;

    $new_x = $this_x + $delta_x;
    $new_y = $this_y + $delta_y;

    if ( $new_x >= 0 && $new_x <= $x_bounds && $new_y >= 0 && $new_y <= $y_bounds ) {
        if ( ! in_array($new_x . ',' . $new_y, $node_pos ) ) {
            $antenna[$new_x . ',' . $new_y] = '#';
        }
        add_til_oob( [$new_x, $new_y], [$delta_x, $delta_y], $char, $bounds, $node_pos );
    }

    return $antenna;
}

echo PHP_EOL . 'Day 08: Resonant Collinearity' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
//part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;