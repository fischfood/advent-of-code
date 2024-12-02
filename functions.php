<?php
// Djikstra Helper
function calculate_total_distance( $path, $distances ) {
    $total_distance = 0;

    for ( $i = 0; $i < count($path) - 1; $i++ ) {
        $from = $path[$i];
        $to = $path[$i + 1];
        $total_distance += $distances[$from][$to];
    }

    return $total_distance;
}

// Djikstra Helper
function get_permutations( $data ) {

    if ( count( $data ) <= 1) {
        return [$data];
    }

    $permutations = [];

    foreach ( $data as $k => $d ) {
        $remaining = $data;
        unset( $remaining[$k] );

        foreach ( get_permutations($remaining) as $permutation ) {
            $permutations[] = array_merge( [$d], $permutation );
        }
    }

    return $permutations;
}

// Djikstra
function find_all_routes($map, $distances) {
    $locations = array_keys($map);
    $routes = [];
    $permutations = get_permutations($locations);

    foreach ($permutations as $path) {

        $total_distance = calculate_total_distance( $path, $distances );
        $routes[] = [
            'path' => $path,
            'distance' => $total_distance
        ];
    }

    return $routes;
}
?>