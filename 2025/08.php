<?php
/**
 * Day 08: Playground
 * Part 1: 1.17599 Seconds (27m25s - 1328th)
 * Part 2: 1.18189 Seconds (47m34s - 2158th)
 */

// The usual
$starttime = microtime(true);
$sample = true;

if ( isset( $sample ) ) {
	$data = file_get_contents('data/data-08-sample.txt');
	$p1_total = 10;
} else {
	$data = file_get_contents('data/data-08.txt');
	$p1_total = 1000;
}

// Needs a little help to keep going, but this is overkill
ini_set('memory_limit', '10G');

$dataset = explode("\n", $data);

// Part One
function part_one($dataset, $connect_total ) {

	$groups = [];

	// Get all distances sorted
	$distances = determine_distances( $dataset );

	// Group until we have the desired number of connections
	for ( $d = 0; $d < $connect_total; $d++ ) {
		[$a, $b] = $distances[$d];
		
		$groups = determine_groupings( $a, $b, $groups );
	}

	$sizes = [];

	// Get sizes of all groups, then sort descending
	foreach( $groups as $group ) {
		$sizes[] = count( $group );
	}
	rsort( $sizes );

	// Total of first three largest groups
	echo $sizes[0] * $sizes[1] * $sizes[2];
}

// Part Two
function part_two($dataset) {

	$total_boxes = count( $dataset );
	$groups = [];
	$in = [];

	// Get all distances sorted
	$distances = determine_distances( $dataset );

	$all_together = false;
	$d = 0;

	// Keep going until all boxes are in one group
	while ( ! $all_together ) {

		[$a, $b] = $distances[$d];
		
		$groups = determine_groupings( $a, $b, $groups );

		// Mark both boxes as seen
		$in[$a] = true;
		$in[$b] = true;

		// If every box has been seen and we're back down to one group, we're done
		if ( count( $in ) === $total_boxes && count( $groups ) === 1 ) {
			$all_together = true;
			$point_a = explode( ',', $dataset[$a] );
			$point_b = explode( ',', $dataset[$b] );
		};

		$d++;
	}

	// Output the product of the X coordinates of the last two points added
	echo $point_a[0] * $point_b[0];

}

function determine_distances( $data ) {

	$distances = [];

	// Compare all points to each other
	for ( $i = 0; $i < count( $data ); $i++ ) {
		for ( $j = $i + 1; $j < count( $data ); $j++ ) {

			// Calculate distance and use as key, giving wiggle room for precision
			$distance = (string) round( distance_3d( $data[$i], $data[$j] ), 6 );
			$distances[ $distance ] = [$i, $j];
		}
	}
	
	// Sort by distance and return
	ksort( $distances );
	return array_values( $distances );

}

function distance_3d( $p1, $p2 ) {

	// Split coordinates
	$axyz = explode( ',', $p1 );
	$bxyz = explode( ',', $p2 );

	// Calculate deltas
	$dx = $bxyz[0] - $axyz[0];
	$dy = $bxyz[1] - $axyz[1];
	$dz = $bxyz[2] - $axyz[2];

	return sqrt( ($dx * $dx) + ($dy * $dy) + ($dz * $dz) );
}

function determine_groupings( $a, $b, $groups ) {
	
	// Use null not 0 for comparison to avoid first key
	$group_a = $group_b = null;

	// Check all groups to see if current IDs are in them
	foreach ( $groups as $gi => $group ) {
		if ( in_array( $a, $group ) ) {
			$group_a = $gi;
		}
		if ( in_array( $b, $group ) ) {
			$group_b = $gi;
		}
	}

	if ( is_null( $group_a ) && is_null( $group_b ) ) {
		// If none, make a new group
		$groups[] = [$a, $b];

	} elseif ( ! is_null( $group_a ) && is_null( $group_b ) ) {
		// If only a is in a group, add b to a's group
		$groups[ $group_a ][] = $b;

	} elseif ( is_null( $group_a ) && ! is_null( $group_b ) ) {
		// If only b is in a group, add a to b's group
		$groups[ $group_b ][] = $a;

	} elseif ( $group_a !== $group_b ) {
		// If both are in different groups, merge the groups
		$groups[ $group_a ] = array_merge( $groups[ $group_a ], $groups[ $group_b ] );

		// Remove the now-empty group, and reindex
		unset( $groups[ $group_b ] );
		$groups = array_values( $groups );
	}

	return $groups;
}

echo PHP_EOL . 'Day 08: Playground' . PHP_EOL . 'Part 1: ';
part_one($dataset, $p1_total);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
