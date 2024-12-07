<?php

/**
 * Day 07: TITLE
 */

// The usual
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

    $continue = true;

    while( $continue ) {
        $continue = false;

        foreach( $actions as $this_char => $todo ) {
            $needed = $todo[0];

            $has = true;
            foreach( $needed as $n ) {
                if ( ! array_key_exists( $n, $set ) ) {
                    $has = false;
                }
            }

            // If we have all variables set, evaluate and remove from todo
            if ( $has ) {
                $value = evaluate_binary( $todo, $set, $this_char );
                //echo "\nSaving $this_char as $value";
                $set[$this_char] = $value;
                unset( $actions[$this_char] );
            } 
            
            // Otherwise, keep in list to try again next run
            else {
                $continue = true;
            }
        }
    }

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

    $set['b'] = decbin( part_one($dataset) );

    $continue = true;

    while( $continue ) {
        $continue = false;

        foreach( $actions as $this_char => $todo ) {
            $needed = $todo[0];

            $has = true;
            foreach( $needed as $n ) {
                if ( ! array_key_exists( $n, $set ) ) {
                    $has = false;
                }
            }

            // If we have all variables set, evaluate and remove from todo
            if ( $has ) {
                $value = evaluate_binary( $todo, $set, $this_char );
                //echo "\nSaving $this_char as $value";
                $set[$this_char] = $value;
                unset( $actions[$this_char] );
            } 
            
            // Otherwise, keep in list to try again next run
            else {
                $continue = true;
            }
        }
    }

    echo bindec($set['a']);
}

// Binary Evaluation
function evaluate_binary( $todo, $set, $character ) {
    $value = 0;

    $needed = $todo[0];
    $action_list = $todo[1];
    $action = $todo[1][0];

    //echo "\nChecking $character";

    switch ( $action ) {
        case '1':
            $value = '';
            $s1 = str_split( $set[$needed[0]] );
            $s2 = str_split( str_pad( decbin(1), 16, "0", STR_PAD_LEFT ) );

            foreach( $s1 as $set_k => $digit ) {
                if ( $s1[$set_k] + $s2[$set_k] > 1 ) {
                    $value .= '1';
                } else {
                    $value .= '0';
                }
            }
            
            break;
        case 'AND':
            $value = '';
            //echo "\n - needs $needed[0] and $needed[1]";
            $s1 = str_split( $set[$needed[0]] );
            $s2 = str_split( $set[$needed[1]] );
            //echo "\n" . $character . ' - ' . $set[$needed[0]] . ' && ' . $set[$needed[1]];

            //echo ' && ' . count( $s1 ) . ' - ' . count( $s2 );
            if ( count( $s1 ) === count( $s2 ) ) {
                foreach( $s1 as $set_k => $digit ) {
                    if ( $s1[$set_k] + $s2[$set_k] > 1 ) {
                        $value .= '1';
                    } else {
                        $value .= '0';
                    }
                }
            }
            break;
        case 'OR':
            $value = '';

            //echo "\n - needs $needed[0] + $needed[1]";
            $s1 = str_split( $set[$needed[0]] );
            $s2 = str_split( $set[$needed[1]] );
            //echo "\n" . $character . ' - ' . $set[$needed[0]] . ' || ' . $set[$needed[1]];

            //echo ' || ' . count( $s1 ) . ' - ' . count( $s2 );
            if ( count( $s1 ) === count( $s2 ) ) {
                foreach( $s1 as $set_k => $digit ) {
                    if ( $s1[$set_k] + $s2[$set_k] > 0 ) {
                        $value .= '1';
                    } else {
                        $value .= '0';
                    }
                }
            }
            break;
        case 'NOT':
            $value = strtr( $set[ $needed[0] ], ['0' => '1', '1' => '0']);
            break;
        case 'LSHIFT':
            $value = $set[$needed[0]];
            $shift = $action_list[1];
            $value = str_pad( substr( $value, 1 * $shift, 16), 16, 0, STR_PAD_RIGHT);
            break;
        case 'RSHIFT':
            $value = $set[$needed[0]];
            $shift = $action_list[1];
            $value = str_pad( substr( $value, 0, -1 * $shift), 16, 0, STR_PAD_LEFT);
            break;
        case 'EQ':
            $value = $set[$needed[0]];
    }

    return $value;
}

echo PHP_EOL . 'Day 07: TITLE' . PHP_EOL . 'Part 1: ';
echo part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;