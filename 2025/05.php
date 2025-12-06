<?php
/**
 * Day 05: TITLE
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
		foreach( $fresh as $f ) {
			$range = explode( '-', $f );
			if ( $i >= $range[0] && $i <= $range[1] ) {
				$this_pass++;
				continue;
			}
		}

		if ( $this_pass > 0 ) {
			$pass++;
		}

	}

	echo $pass;
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day 05: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
