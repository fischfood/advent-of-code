<?php

/**
 * Day 05: If You Give A Seed A Fertilizer
 */

// The usual
$data = file_get_contents('data/data-05.txt');
$data = file_get_contents('data/data-05-sample.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {

    $almanac = map_almanac($dataset);

    $seeds = $almanac[0];
    $conversion = array_values( $almanac[1] );

    $step = 0;
    $locations = [];
    
    foreach( $seeds as $seed ) {
        $locations[] = plant_seed( $seed, $conversion, $step );
    }

    asort( $locations );
    echo reset($locations);

}

// Part Two
function part_two($dataset) {
	
    $almanac = map_almanac($dataset);

    $seeds = $almanac[0];
    $new_seeds = [];

    for ( $s = 1; $s <= count( $seeds ) / 2; $s++ ) {

        $seed_beginning = ( $s - 1 ) * 2;

        $seed_start = $seeds[$seed_beginning];
        $seed_end = $seed_start + $seeds[$seed_beginning + 1] - 1;

        $new_seeds = array_merge( $new_seeds, range( $seed_start, $seed_end ) );
        
    }

    $conversion = array_values( $almanac[1] );

    $step = 0;
    $locations = [];
    
    foreach( $new_seeds as $seed ) {
        $locations[$seed] = plant_seed( $seed, $conversion, $step );
    }

    //print_r( $locations );

    asort( $locations );
    echo reset($locations);
}

function map_almanac( $data ) {

    $seeds = explode( ' ', substr($data[0], strpos($data[0], ":") + 2) );
    $almanac = [];
    $almanac_keys = '';
    
    unset( $data[0] );
    
    foreach( $data as $num => $row ) {

        $first_five = substr($row, 0, 5);
        switch( $first_five ) {
            case ('seed-'):
                $almanac_keys = 'soil';
                break;
            case ('soil-'):
                $almanac_keys = 'fertilizer';
                break;
            case ('ferti'):
                $almanac_keys = 'water';
                break;
            case ('water'):
                $almanac_keys = 'light';
                break;
            case ('light'):
                $almanac_keys = 'temp';
                break;
            case ('tempe'):
                $almanac_keys = 'humidity';
                break;
            case ('humid'):
                $almanac_keys = 'location';
                break;
            default :
                if ( '' !== $row ) {
                    $range = explode( ' ', $row );

                    $dest = $range[0];
                    $start = $range[1];
                    $length = $range[2];

                    $shift = $dest - $start;

                    $almanac[$almanac_keys][$start] = [$start + $length - 1, $shift];
                }
                break;
        }

    }

    return [$seeds, $almanac];
}

function plant_seed( $input, $conversion, $step = 0 ) {
    
    $total_steps = count( $conversion );
    
    $this_step = $conversion[$step];
    $output = '';

    foreach( $this_step as $start => $to_shift ) {

        if ( $input >= $start && $input <= $to_shift[0] ) {
            $output = $input + $to_shift[1];
        }
    }

    if ( $output === '' ) {
        $output = $input;
    }

    $step++;
    
    if ( $step < $total_steps ) {
        return plant_seed( $output, $conversion, $step );
    } else {
        return $output;
    }
}

echo PHP_EOL . 'Day 05: If You Give A Seed A Fertilizer' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;