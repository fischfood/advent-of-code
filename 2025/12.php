<?php
/**
 * Day 12: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-12.txt');
$data = file_get_contents('data/data-12-sample.txt');

$dataset = explode("\n\n", $data);

// Part One
function part_one($dataset) {

	$presents = [];
	$present_spaces = [];
	$trees = [];

	foreach( $dataset as $data ) {
		if ( str_contains( $data, '#' ) ) {
			$total = str_split( str_replace( "\n", '', $data ) );
			$present_spaces[] = array_count_values( $total )['#'];
		} else {
			$trees = explode( "\n", $data );
		}
	}

	// Eliminate $trees where the space is smaller than the total present spaces
	$valid_trees = [];
	foreach( $trees as $index => $tree ) {
		[ $size, $present_totals ] = explode( ': ', $tree );
		
		$size = array_product( explode( 'x', $size ) );
		$present_totals = explode( ' ', $present_totals );

		$total_present_spaces = 0;
		foreach( $present_totals as $pidx => $presents_needed ) {
			$total_present_spaces += $present_spaces[$pidx] * $presents_needed;
		}

		if ( $total_present_spaces <= $size ) {
			$valid_trees[ $index ] = $tree;
		}
	}

	echo count( $valid_trees );
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day 12: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
