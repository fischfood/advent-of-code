<?php

/**
 * Day 03: Perfectly Spherical Houses in a Vacuum
 */

// The usual
$data = file_get_contents('data/data-03.txt');
$sample_a = '>';
$sample_b = '^>v<';
$sample_c = '^v^v^v^v^v';

$dataset = $data;

/**
 * get_new_coord
 * 
 * Takes the current coordinates, and a direction, and moves Santa/Robo Santa to that location
 * Returns the new location
 * 
 * return $cur_coord;
 */
function get_new_coord( $cur_coord, $direction ) {
    switch ($direction) {
        case '<':
            $cur_coord[0]--;
            break;
        case '>':
            $cur_coord[0]++;
            break;
        case '^':
            $cur_coord[1]++;
            break;
        case 'v':
            $cur_coord[1]--;
            break;
    }

    return $cur_coord;
}

// Part One - How many houses receive at least one present?
function part_one($dataset) {

    $moves = str_split($dataset, 1);

    $location = [0,0];
    $visited = ['0,0'];

    // Move coords based on direction
    foreach( $moves as $move ) {
       
        // Move Santa
        $location = get_new_coord( $location, $move );

        // Add location to array (x,y)
        $visited[] = implode( ',', $location );
    }

    // Count how many unique visits there are
    return sprintf(
        'Santa visited %d houses',
        sizeof( array_unique( $visited ) )
    );

}

// Part Two - This year, how many houses receive at least one present?
function part_two($dataset) {
	$moves = str_split($dataset, 2);

    $santa_location = [0,0];
    $robo_location = [0,0];

    $visited = ['0,0'];

    // Move coords based on direction
    foreach( $moves as $move ) {
       
        // Move Santa
        $santa_location = get_new_coord( $santa_location, $move[0] );

        // Move Robo Santa
        $robo_location = get_new_coord( $robo_location, $move[1] );

        // Add location to array (x,y)
        $visited[] = implode( ',', $santa_location );
        $visited[] = implode( ',', $robo_location );
    }

    // Count how many unique visits there are
    return sprintf(
        'Santa and Robo Santa visited %d houses',
        sizeof( array_unique( $visited ) )
    );
}

echo PHP_EOL . 'Day 03: Perfectly Spherical Houses in a Vacuum' . PHP_EOL;
echo 'Part 1: ' . part_one($dataset) . PHP_EOL;
echo 'Part 2: ' . part_two($dataset) . PHP_EOL . PHP_EOL;