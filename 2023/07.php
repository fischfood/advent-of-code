<?php

/**
 * Day 07: Camel Cards
 */

// The usual
$data = file_get_contents('data/data-07.txt');
//$data = file_get_contents('data/data-07-sample.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {
    $total = 0;
    $hands = generate_hands( $rows );

    foreach( array_values( $hands ) as $rank => $bet ) {
        $total += $bet * ($rank + 1 );
    }

    echo $total;
}

// Part Two
function part_two( $rows ) {
    $total = 0;
    $hands = generate_joker_hands( $rows );

    foreach( array_values( $hands ) as $rank => $bet ) {
        $total += $bet * ($rank + 1 );
    }

    echo $total;
}

function generate_hands( $data ) {
    $hands = [];

    foreach( $data as $hand ) {
        $this_hand = explode(' ', $hand );

        $cards = $this_hand[0];
        $bet = $this_hand[1];

        $card_hex = str_replace( ['T','J','Q','K','A'], ['a','b','c','d','e'], $cards );
        
        $card_counts = count_chars( $cards, 1 );
        arsort( $card_counts );

        $strength = implode( '', $card_counts );

        switch( $strength ) {
            case '5':
                $type = '7'; break;
            case '41': 
                $type = '6'; break;
            case '32':
                $type = '5'; break;
            case '311': 
                $type = '4'; break;
            case '221':
                $type = '3'; break;
            case '2111':
                $type = '2'; break;
            case '11111':
                $type = '1'; break;
        }

        $hand_value_hex = $type . $card_hex;
        $hands[ base_convert( $hand_value_hex, 16, 10)] = $bet;
        
    }

    ksort( $hands );
    return $hands;
}

function generate_joker_hands( $data ) {
    $hands = [];

    foreach( $data as $k => $hand ) {
        $this_hand = explode(' ', $hand );

        $cards = $this_hand[0];
        $bet = $this_hand[1];

        $card_hex = str_replace( ['T','J','Q','K','A'], ['a','1','c','d','e'], $cards );
        
        $card_counts = count_chars( $cards, 1 );

        // J is 74
        unset( $card_counts[74]);
        arsort( $card_counts );

        $strength = implode( '', $card_counts );

        switch( $strength ) {
            // 5 of a kind is now default
            case '41': // 4 of a kind 
            case '31': // AAA2J
            case '21': // AA2JJ
            case '11': // A2JJJ
                $type = '6'; break;
            case '32': // Full House
            case '22': // AA22J
                $type = '5'; break;
            case '311': // 3 of a Kind
            case '211'; // AA23J
            case '111'; // A23JJ
                $type = '4'; break;
            case '221': // 2 Pair - Joker will always bring to Full House
                $type = '3'; break;
            case '2111': // 1 Pair
            case '1111': // A234J
                $type = '2'; break;
            case '11111': // High - Joker will always bring to a pair
                $type = '1'; break;
            default: // All 5 of a Kind
                $type = '7'; break;
        }

        $hand_value_hex = $type . str_pad( $card_hex, 5, 0, STR_PAD_LEFT );
        $hands[ base_convert( $hand_value_hex, 16, 10)] = $bet;
    }

    ksort( $hands );
    return $hands;
}

echo PHP_EOL . 'Day 07: Camel Cards' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;