<?php
/**
 * Day 09: Movie Theater
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-09.txt');
$data = file_get_contents('data/data-09-sample.txt');

$dataset = explode("\n", $data);
ini_set('memory_limit', '10G');

// Part One
function part_one($dataset) {

	$rectangles = [];

	// Compare all points to each other
	for ( $i = 0; $i < count( $dataset ); $i++ ) {
		for ( $j = $i + 1; $j < count( $dataset ); $j++ ) {

			[ $ax, $ay ] = explode( ',', $dataset[$i] );
			[ $bx, $by ] = explode( ',', $dataset[$j] );

			$h = abs( $bx - $ax) + 1;
			$w = abs( $by - $ay) + 1;
			$area = $h * $w;

			$rectangles[] = $area;
		}
	}

	arsort( $rectangles );

	echo array_shift( $rectangles );

}

// Part Two
function part_two( $dataset ) {
	# Do More Things
}

echo PHP_EOL . 'Day 09: Movie Theater' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
