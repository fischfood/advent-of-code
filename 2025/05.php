<?php
/**
 * Day 05: Cafeteria
 * Part 1: 0.00100 Seconds (05m36s - N/A - 56913rd)
 * Part 2: 0.00036 Seconds (36m49s - N/A - 488847th)
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-05.txt');
$data = file_get_contents('data/data-05-sample.txt');

$dataset = explode("\n\n", $data);

// Part One
function part_one($dataset) {

	$pass = 0;
	[ $fresh, $ingredients ] = $dataset;

	$fresh = explode( "\n", $fresh );
	$ingredients = explode( "\n", $ingredients );

	foreach( $ingredients as $i ) {
		
		$this_pass = 0;

		// Check if this ingredient is fresh across all lists
		foreach( $fresh as $f ) {
			$range = explode( '-', $f );
			if ( $i >= $range[0] && $i <= $range[1] ) {
				$this_pass++;
			}
		}

		// Doesn't matter how many ranges it passes, it's one ingredient that passes
		if ( $this_pass > 0 ) {
			$pass++;
		}

	}

	echo $pass;
}

// Part Two
function part_two($dataset) {

	$total = 0;
	$fresh_ranges = $dataset[0];

	$fresh = explode( "\n", $fresh_ranges );
	$ranges = [];

	// Convert string to array range
	foreach( $fresh as $k => $f ) {
		$fresh[$k] = explode('-', $f);
	}

	// Sort by lowest starting
	usort(
		$fresh,
		function ( $a, $b ) {
			return $a['0'] <=> $b['0'];
		}
	);

	// Use first as baseline;
	$ranges[] = $fresh[0];
	$i = 0;

	// Check each array after to see if it extends the bounds (or sits within is fine too)
	foreach( array_slice( $fresh, 1 ) as $next ) {
		if ( $next[0] <= $ranges[$i][1] ) {
			$ranges[$i][1] = max( $next[1], $ranges[$i][1] );

		} else {
			// If not, start a new range to compare against
			$i++;
			$ranges[$i] = $next;
		}
	}

	// Count how many are in the range, and add it to the total
	foreach( $ranges as $range ) {
		$total += $range[1] - $range[0] + 1;
	}

	echo $total;

}

echo PHP_EOL . 'Day 05: Cafeteria' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
