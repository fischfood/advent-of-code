<?php

/**
 * Day 06: Wait For It
 */

// The usual
$data = file_get_contents('data/data-06.txt');
//$data = file_get_contents('data/data-06-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $time_limit = generate_records( $rows )[0];
    $records = generate_records( $rows )[1];

    $winning_times = [];

    // Records are a bell curve
    foreach( $time_limit as $k => $time ) {
        $winning_times[$k] = 0;
        for ( $hold = 1; $hold < ( $time / 2 ); $hold++ ) {

            $total_distance = ( $time - $hold ) * $hold;
            if ( $total_distance > $records[$k] ) {
                $winning_times[$k] = $winning_times[$k] + 1;
            }
        }

        $winning_times[$k] = $winning_times[$k] * 2;
        if ( $time % 2 === 0 ) {
            $winning_times[$k] = $winning_times[$k] + 1;
        }
    }

    echo array_product( $winning_times );
    
}

// Part Two
function part_two($rows) {
	$time_limit = implode( '', generate_records( $rows )[0] );
    $record = implode( '', generate_records( $rows )[1] );

    $winning_times = 0;

    // Records are a bell curve
    for ( $hold = 1; $hold < round( $time_limit / 2 ); $hold++ ) {

        $total_distance = ( $time_limit - $hold ) * $hold;
        if ( $total_distance > $record ) {
            $winning_times = $winning_times + 1;
        }
    }

    $winning_times = $winning_times * 2;
    if ( $time_limit % 2 === 0 ) {
        $winning_times = $winning_times + 1;
    }

    echo $winning_times;
}

function generate_records( $rows ) {
    $times = array_values( array_filter(  explode( ' ', substr($rows[0], strpos($rows[0], ":") + 1) ) ) );
    $records = array_values( array_filter(  explode( ' ', substr($rows[1], strpos($rows[1], ":") + 1) ) ) );

    return [ $times, $records ];
}

echo PHP_EOL . 'Day 06: Wait For It' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;