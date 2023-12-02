<?php

/**
 * Day 02: Cube Conundrum
 */

// The usual
$data = file_get_contents('data/data-02.txt');
//$data = file_get_contents('data/data-02-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One - Which games would have been possible if the bag contained only 12 red cubes, 13 green cubes, and 14 blue cubes?
function part_one($dataset) {

    $allowed_games = [];

    foreach( $dataset as $row ) {
        $allowed = 'true';

        $data_split = explode( ';', str_replace( ':', ';', $row ) );

        $game_key = preg_replace( '/[^0-9]/', '', $data_split[0] );

        foreach( $data_split as $roll_num => $dice_grab ) {
            if ( $roll_num > 0 ) {
                $this_roll = explode( ',', $dice_grab );
                
                foreach( $this_roll as $colors ) {
                    $num_dice = explode( ' ', trim( $colors ) );

                    if ( 'red' === $num_dice[1] && $num_dice[0] > 12 ) {
                        $allowed = 'false';
                    } elseif ( 'green' === $num_dice[1] && $num_dice[0] > 13 ) {
                        $allowed = 'false';
                    } elseif ( 'blue' === $num_dice[1] && $num_dice[0] > 14 ) {
                        $allowed = 'false';
                    }
                }
            }
        }

        if ( $allowed === 'true' ) {
            $allowed_games[] = $game_key;
        }
        
    }
    
    echo array_sum( $allowed_games );
}

// Part Two - What is the fewest number of cubes of each color that could have been in the bag to make the game possible?
function part_two($dataset) {
	
    $game_min = [];

    foreach( $dataset as $row ) {

        $data_split = explode( ';', str_replace( ':', ';', $row ) );

        $red = 0;
        $green = 0;
        $blue = 0;

        foreach( $data_split as $roll_num => $dice_grab ) {
            if ( $roll_num > 0 ) {
                $this_roll = explode( ',', $dice_grab );
                
                foreach( $this_roll as $colors ) {
                    $num_dice = explode( ' ', trim( $colors ) );

                    if ( 'red' === $num_dice[1] && $num_dice[0] > $red ) {
                        $red = $num_dice[0];
                    } elseif ( 'green' === $num_dice[1] && $num_dice[0] > $green ) {
                        $green = $num_dice[0];
                    } elseif ( 'blue' === $num_dice[1] && $num_dice[0] > $blue ) {
                        $blue = $num_dice[0];
                    }
                }
            }
        }

        $game_min[] = $red * $blue * $green;
        
    }
    
    echo array_sum( $game_min );
}

echo PHP_EOL . 'Day 02: Cube Conundrum' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;