<?php

/**
 * Day 04: Scratchcards
 */

// The usual
$data = file_get_contents('data/data-04.txt');
//$data = file_get_contents('data/data-04-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    $wins = scratch_card( $rows );
    $matches = [];
    
    foreach( $wins as $card ) {
        if ( $card > 0 ) {
            $matches[] = 1 * pow( 2, $card - 1 );
        } else {
            $matches[] = 0;
        }
    }

    echo array_sum( $matches );
}

// Part Two
function part_two($rows) {

    $owned_cards = array_fill(1, count( $rows ), 1);
    $total_winning_numbers = scratch_card( $rows );

    for ( $i = 1; $i <= ( count( $owned_cards ) ); $i++) {

        $total_tickets = $owned_cards[$i];
        $tickets_won = $total_winning_numbers[$i - 1];

        for ( $w = $i + 1; $w <= ( $i + $tickets_won ); $w++ ) {
            $owned_cards[$w] = $owned_cards[$w] + $total_tickets;
        }
    }

    echo array_sum( $owned_cards );

}

function scratch_card( $rows ) {
    foreach( $rows as $row ) {
        $i = 0;

        $card = explode( '|', $row );
        $winning_data = substr($card[0], strpos($card[0], ":") + 1);
        $num_data = $card[1];

        $winning_numbers = array_filter( explode( ' ', $winning_data ) );
        $your_numbers = array_filter( explode( ' ', $num_data ) );

        foreach ( $your_numbers as $num ) {
            if ( in_array( $num, $winning_numbers ) ) {
                $i++;
            }
        }

        $wins[] = $i;
    }

    return $wins;
}

echo PHP_EOL . 'Day 04: Scratchcards' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;