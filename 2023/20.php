<?php

/**
 * Day 20: Pulse Propagation
 */

// The usual
$data = file_get_contents('data/data-20.txt');
$data = file_get_contents('data/data-20-sample.txt');
$data = file_get_contents('data/data-20-sample-2.txt');

$rows = explode("\n", $data);

// Part One
function part_one($rows) {

    [$starts, $paths] = make_paths( $rows );
    
    // TODO: Find all conjections and get their connections
    //$paths = assign_multi_conjections( $paths );

    print_r( $paths );
    
    // [$lows, $highs] = press_button( $starts, $paths, 1 );

    //echo PHP_EOL . $lows . ' - ' . $highs;
}

// Part Two
function part_two($rows) {
	# Do More Things
}

function make_paths( $rows ) {

    $paths = [];

    foreach( $rows as $row ) {
        $row = str_replace( ['&','%'], ['& -> ','% -> '], $row );
        $row_data = explode( ' -> ', $row );

        if ( $row_data[0] === 'broadcaster' ) {
            $starts = explode( ', ', $row_data[1] );
        } else {

            $paths[ $row_data[1] ] = [
                'type' => $row_data[0],
                'to' => explode( ', ', $row_data[2] ),
                'val' => 0
            ];
        }
    }

    return [$starts, $paths ];
}

function press_button( $starts, $paths, $press = 1 ) {

    $highs = 0;
    $lows = 0; // Button Press

    for ( $p = 0; $p < $press; $p++ ) {

        $lows++; // Initial Button Press
        echo PHP_EOL . "button -0-> broadcaster";

        for ( $i = 0; $i < count( $starts ); $i++ ) {

            $lows++;
            
            $start_key = $starts[$i];
            echo PHP_EOL . "broadcaster -0-> $start_key";

            $active = [ [ $start_key, $paths[$start_key]['val'] ] ];

            //print_r( $active );

            while ( count( $active ) > 0 ) {

                $new_active = [];

                for( $ii = 0; $ii < count( $active ); $ii++ ) {

                    $a = $active[$ii];

                    unset( $active[$ii] );

                    $key = $a[0];
                    $val = $a[1];
                    $from = '';

                    if ( ! empty( $a[2] ) ) {
                        $from = $a[2];
                    }

                    //echo PHP_EOL . "$key receiving $val";
                    
                    // If flip
                    if ( $paths[$key]['type'] === '%' ) {

                        $sending = ( 1 - $paths[$key]['val'] );
                        $paths[$key]['val'] = $sending;
                        $to = $paths[$key]['to'];

                        foreach( $to as $t ) {
                            echo PHP_EOL . "$key -$sending-> $t";

                            if ( $sending === 0 ) {
                                $lows++;
                            } else {
                                $highs++;
                            }

                            if ( $t === 'output' ) {
                                continue;
                            }

                            if ( $paths[$t]['type'] === '%'  && $sending === 1 ) {
                                //echo ' END';
                            } else {
                                //echo ' SEND';
                                array_unshift( $active, [ $t, $sending, $key ] );
                            }
                        }
                    } else {

                        $sending = ( 1 - $val );
                        $paths[$key]['val'] = $sending;
                        $to = $paths[$key]['to'];

                        foreach( $to as $t ) {
                            echo PHP_EOL . "$key -$sending-> $t";

                            if ( $sending === 0 ) {
                                $lows++;
                            } else {
                                $highs++;
                            }

                            if ( $t === 'output' ) {
                                continue;
                            }

                            if ( $paths[$t]['type'] === '%' && $sending === 1 ) {
                                //echo ' END';
                            } else {
                                //echo ' SEND';
                                array_unshift( $active, [ $t, $sending, $key ] );
                            }
                        }
                        
                    }
                }
            }
        }
    }

    return[ $lows, $highs ];

}

echo PHP_EOL . 'Day 20: Pulse Propagation' . PHP_EOL . 'Part 1: ';
part_one($rows);
echo PHP_EOL . 'Part 2: ';
part_two($rows);
echo PHP_EOL . PHP_EOL;