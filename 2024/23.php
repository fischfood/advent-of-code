<?php

/**
 * Day 23: LAN Party
 * Part 1: 0.38189 Seconds
 * Part 2: 0.04189 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-23.txt');
// $data = file_get_contents('data/data-23-sample.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {

    // Map
    [ $t_connections, $t_nodes ] = map_connections( $dataset, 't' );

    // Get groups of three linked computers, and give us the total
    $connected = compare_connections( $t_connections, $t_nodes );
    echo count( $connected );
}

// Part Two
function part_two($dataset) {

    // Map
    [ $t_connections, $t_nodes ] = map_connections( $dataset, 't' );

    // Get full groups of linked computers
    $grouped = compare_connections( $t_connections, $t_nodes, 'all_connected' );

    // Sort groups by how many times they appear, and get the largest (first)
    $sort_grouped = array_count_values($grouped);
    arsort($sort_grouped);
    $password = array_key_first( $sort_grouped );

    echo $password;
}

function map_connections( $dataset, $char = "t" ) {

    // Define connections between computers
    foreach( $dataset as $d ) {
        [$a, $b] = explode( '-', $d);
        $connections[$a][] = $b;
        $connections[$b][] = $a;
    }

    // Eliminate connections without a starting character, t is default
    if ( $char ) {
        foreach( $connections as $k => $c ) {
            // Add a comma at the start, and use as glue, to check for ,[char]
            $char_check = ',' . implode( ',', $c );
            
            if ( str_contains( $char_check, ',' . $char ) ) {
                $char_connections[$k] = array_values( $c );
                $char_nodes[] = $k;
            }
        }

        return [ $char_connections, $char_nodes ];
    }

    return $connections;
}

function compare_connections( $connections, $nodes, $network = false ) {

    // Connected is for ones that link to every one in the group (A to B, B to C, and A to C)
    // Grouped is for the whole network (A to B, B to C, C to D)
    $connected = [];
    $grouped = [];

    // Compare each node to every other
    for ($i = 0; $i < count($nodes); $i++) {
        for ($j = $i + 1; $j < count($nodes); $j++) {

            // Get the nodes we're checking
            $node_a = $nodes[ $i ];
            $node_b = $nodes[ $j ];

            // And get all of their connections
            $a_nodes = $connections[ $node_a ];
            $b_nodes = $connections[ $node_b ];

            // Create a group of all connected nodes in a set, starting with the nodes we're checking
            $group = [$node_a, $node_b];

            // Check every computer connected to A
            foreach( $a_nodes as $a => $n ) {
                
                // If this node is also in B, and A's node is in B...
                if ( in_array( $n, $b_nodes ) && in_array( $node_a, $b_nodes ) ) {
                
                    // We have a success!
                    // Add this node to the network group
                    $group[] = $n;

                    // Set the linked computers to A, B, and N. Sort for direct string comparison
                    $links = [$node_a, $node_b, $n];
                    sort( $links );

                    // If one of these starts with a T, log it
                    if ( str_contains( ',' . implode(',', $links), ',t' ) ) {
                        $connected[ implode(',', $links) ] = $links;
                    }
                }
            }

            // Sort all of the nodes A-Z (for direct string comparison), then add it to the network group list
            sort( $group );
            $grouped[] = implode( ',', $group );
        }
    }

    if ( $network ) {
        return $grouped;
    }

    return $connected;
}

echo PHP_EOL . 'Day 23: LAN Party' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;