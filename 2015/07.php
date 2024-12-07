<?php

/**
 * Day 07: Some Assembly Required
 * Part 1: .00484 Seconds
 * Part 2: .00977 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-07.txt');
//$data = file_get_contents('data/data-07-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {

    $set = [];
    $actions = [];

    // First, set data that we know
    foreach( $dataset as $d ) {
        list( $todo, $wire ) = explode( ' -> ', $d );

        // If we know the number of a wire, set it as a 16-digit binary
        if ( is_numeric( $todo ) ) {
            $set[$wire] = str_pad( decbin($todo), 16, "0", STR_PAD_LEFT);
        }

        // Otherwise, add items to the actions[] to comb through after
        // Break up the todo into values and action
        else {
            preg_match_all( '/AND|OR|LSHIFT|RSHIFT|NOT|[0-9]{1,2}/', $todo, $operation );
            preg_match_all( '/[a-z]{1,5}/', $todo, $variables );

            // Add in check for direct assignment, "x -> y"
            $operation[0] = ( empty( $operation[0] ) ) ? ['EQ'] : $operation[0];
            $actions[$wire] = [ $variables[0], $operation[0] ];
        }
    }

    // Loop until we run out of actions, and every wire has been assigned
    $set = run_loop_through( $set, $actions );

    // Give us the answer for a, returned since we need it for Part Two
    return bindec($set['a']);
}

// Part Two
function part_two($dataset) {
	$set = [];
    $actions = [];

    // First, set data that we know
    foreach( $dataset as $d ) {
        list( $todo, $wire ) = explode( ' -> ', $d );

        // If we know the number of a wire, set it as a 16-digit binary
        if ( is_numeric( $todo ) ) {
            //echo "\nSaving $wire as " . str_pad( decbin($todo), 16, "0", STR_PAD_LEFT);
            $set[$wire] = str_pad( decbin($todo), 16, "0", STR_PAD_LEFT);
        }

        // Otherwise, add items to the actions[] to comb through after
        // Break up the todo into values and action
        else {
            preg_match_all( '/AND|OR|LSHIFT|RSHIFT|NOT|[0-9]{1,2}/', $todo, $operation );
            preg_match_all( '/[a-z]{1,5}/', $todo, $variables );

            // Add in check for direct assignment, "x -> y"
            $operation[0] = ( empty( $operation[0] ) ) ? ['EQ'] : $operation[0];
            $actions[$wire] = [ $variables[0], $operation[0] ];
        }
    }

    // Set $wire 'b' to equal the binary of 'a' from Part One
    $set['b'] = decbin( part_one($dataset) );

    // Loop until we run out of actions, and every wire has been assigned
    $set = run_loop_through( $set, $actions );

    // Give us the final number
    echo bindec($set['a']);
}

function run_loop_through( $set, $actions ) {
    
    $continue = true;

    // While we have actions to run...
    while( $continue ) {
        $continue = false;

        // For every action (todo) ...
        foreach( $actions as $this_char => $todo ) {
            $needed = $todo[0];

            // Check if it is assigned
            $has = true;
            foreach( $needed as $n ) {
                if ( ! array_key_exists( $n, $set ) ) {
                    $has = false;
                }
            }

            // If we have all variables set, evaluate and remove from the list of future actions
            if ( $has ) {
                $value = evaluate_binary( $todo, $set, $this_char );
                $set[$this_char] = $value;
                unset( $actions[$this_char] );
            } 
            
            // Otherwise, keep in list to try again next run
            else {
                $continue = true;
            }
        }
    }

    return $set;
}

// Binary Evaluation
function evaluate_binary( $todo, $set, $character ) {
    $value = 0;

    // $needed is one character that is always set, $action_list is what we should be doing, $action is the type
    $needed = $todo[0];
    $action_list = $todo[1];
    $action = $todo[1][0];

    switch ( $action ) {

        // Some rows have a 1 AND $char.
        // Convert 1 to binary and evaluate as an AND
        case '1':
            $value = '';
            $s1 = str_split( $set[$needed[0]] );
            $s2 = str_split( str_pad( decbin(1), 16, "0", STR_PAD_LEFT ) );

            // Compare each position
            foreach( $s1 as $set_k => $digit ) {
                // If both have a 1, it's a 1
                if ( $s1[$set_k] + $s2[$set_k] > 1 ) {
                    $value .= '1';
                } 
                // Otherwise it's a 0
                else {
                    $value .= '0';
                }
            }
            break;
            
        case 'AND':
            $value = '';
            $s1 = str_split( $set[$needed[0]] );
            $s2 = str_split( $set[$needed[1]] );

            // Compare each position
            if ( count( $s1 ) === count( $s2 ) ) {
                foreach( $s1 as $set_k => $digit ) {
                    // If both have a 1, it's a 1
                    if ( $s1[$set_k] + $s2[$set_k] > 1 ) {
                        $value .= '1';
                    }
                    // Otherwise it's a 0
                    else {
                        $value .= '0';
                    }
                }
            }
            break;

        case 'OR':
            $value = '';
            $s1 = str_split( $set[$needed[0]] );
            $s2 = str_split( $set[$needed[1]] );
            
            // Compare each position
            if ( count( $s1 ) === count( $s2 ) ) {
                foreach( $s1 as $set_k => $digit ) {
                    // If either spot is a 1, it's a 1
                    if ( $s1[$set_k] + $s2[$set_k] > 0 ) {
                        $value .= '1';
                    }
                    // Otherwise it's a 0
                    else {
                        $value .= '0';
                    }
                }
            }
            break;

        case 'NOT':
            // For not, flip 0 to 1 and 1 to 0
            $value = strtr( $set[ $needed[0] ], ['0' => '1', '1' => '0']);
            break;

        case 'LSHIFT':
            $value = $set[$needed[0]];

            // Shift left by this many digits
            $shift = $action_list[1];

            // Shift left and add 0s to the right
            $value = str_pad( substr( $value, 1 * $shift, 16), 16, 0, STR_PAD_RIGHT);

            break;

        case 'RSHIFT':
            $value = $set[$needed[0]];

            // Shift right by this many digits
            $shift = $action_list[1];

            // Shift left and add 0s to the right
            $value = str_pad( substr( $value, 0, -1 * $shift), 16, 0, STR_PAD_LEFT);
            break;

        case 'EQ':
            // If direct, just set right to left
            $value = $set[$needed[0]];
    }

    return $value;
}

echo PHP_EOL . 'Day 07: Some Assembly Required' . PHP_EOL . 'Part 1: ';
echo part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;