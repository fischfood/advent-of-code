<?php

/**
 * Day 19: Aplenty
 */

// The usual
$data = file_get_contents('data/data-19.txt');
//$data = file_get_contents('data/data-19-sample.txt');

$dataset = explode("\n\n", $data);

// Part One
function part_one($dataset) {
    
    $workflows = $dataset[0];
    $ratings = $dataset[1];

    $flows = set_workflows( $workflows );

    echo check_ratings( $ratings, $flows );

}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function set_workflows( $workflows ) {

    $flows = [];

    $rows = explode( "\n", $workflows );
    foreach( $rows as $row ) {
        $row = str_replace( ['{','}'], [',',''], $row );
        $row = str_replace( ['<', '>', ':'], ['|<|', '|>|', '|'], $row );
        
        $row_data = explode( ',', $row );

        $key = $row_data[0];
        unset( $row_data[0] );

        $i = 0;

        foreach( $row_data as $rd ) {
            $rdex = explode('|', $rd );

            if ( count( $rdex ) > 1 ) {
                $flows[$key][] = [
                    'if' => $rdex[0],
                    'op' => $rdex[1],
                    'val' => $rdex[2],
                    'then' => $rdex[3]
                ];
            } else {
                $flows[$key][$i] = $rd;
            }
            $i++;
        }
    }

    return $flows;
}

function check_ratings( $ratings, $workflows ) {

    $accepted = 0;

    $ratings = explode( "\n", $ratings );
    
    foreach( $ratings as $rating ) {
        $values = ['check' => 'in'];
        $xmas = explode( ',', str_replace( ['{','}'], '', $rating ) );

        foreach( $xmas as $x ) {
            $todo = explode( '=', $x );
            $values[$todo[0]] = $todo[1];
        }

        $total = array_sum( $values );
        
        $sorted = process_ratings( $values, $workflows );

        if ( $sorted === 'A' ) {
            $accepted += $total;
        }
    }

    return $accepted;
}

function process_ratings( $rating, $workflows ) {

    $key = $rating['check'];
    $this_workflow = $workflows[$key];
    $count = count( $this_workflow );
    $next = '';

    for ( $i = 0; $i < $count; $i++ ) {

        if ( ! is_array( $this_workflow[$i] ) ) {
            $next = $this_workflow[$i];
            //echo PHP_EOL . 'None, go to ' . $next;
        } else {

            $wf = $this_workflow[$i];

            $letter = $wf['if'];
            // echo PHP_EOL . "Checking " . $rating[$letter] . ' ' .  $wf['op'] . ' ' . $wf['val'];
            
            if ( $wf['op'] === '>' ) {
                if ( $rating[$letter] > $wf['val'] ) {
                    $next = $wf['then'];
                }
            } else {
                if ( $rating[$letter] < $wf['val'] ) {
                    $next = $wf['then'];
                }
            }

            // If next is set, exit the loop
            if ( '' !== $next ) {
                $i = $count;
            }
        }
    }

    if ( $next === 'A' || $next === 'R' ) {
        return $next;
    } else {
        $rating['check'] = $next;
        return process_ratings( $rating, $workflows );
    }

}



echo PHP_EOL . 'Day 19: Aplenty' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;