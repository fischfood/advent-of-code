<?php
/**
 * Day 09: Movie Theater
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-09-sample.txt');
// $data = file_get_contents('data/data-09.txt');

$dataset = explode("\n", $data);
ini_set('memory_limit', '10G');

// Part One
function part_one($dataset) {

	$rectangles = [];

	foreach ( $dataset as $line ) {
		if ( trim( $line ) !== '' ) {
			$rectangles[] = array_map( 'intval', explode( ',', $line ) );
		}
	}

	$max = 0;

	// Compare all points to each other
	for ( $i = 0; $i < count( $rectangles ); $i++ ) {
		for ( $j = $i + 1; $j < count( $rectangles ); $j++ ) {

			[ $ax, $ay ] = $rectangles[$i];
			[ $bx, $by ] = $rectangles[$j];

			$h = abs( $bx - $ax) + 1;
			$w = abs( $by - $ay) + 1;
			$area = $h * $w;

			$max = max( $max, $area );
		}
	}

	echo $max;

}

// Part Two
function part_two( $dataset ) {

	$rectangles = [];

	foreach ( $dataset as $line ) {
		if ( trim( $line ) !== '' ) {
			$rectangles[] = array_map( 'intval', explode( ',', $line ) );
		}
	}

	// Each point connects to the next one (and the last back to the first)
	$edges = [];

	for ( $i = 0; $i < count( $rectangles ); $i++ ) {

		[ $ax, $ay ] = $rectangles[$i];
		[ $bx, $by ] = $rectangles[ ( $i + 1 ) % count( $rectangles ) ];

		$edges[] = [ min( $ax, $bx ), min( $ay, $by ), max( $ax, $bx ), max( $ay, $by ) ];
	}

	$max = 0;

	// Compare all points to each other
	for ( $i = 0; $i < count( $rectangles ); $i++ ) {
		for ( $j = $i + 1; $j < count( $rectangles ); $j++ ) {

			[ $ax, $ay ] = $rectangles[$i];
			[ $bx, $by ] = $rectangles[$j];

			$h = abs( $bx - $ax) + 1;
			$w = abs( $by - $ay) + 1;
			$area = $h * $w;

			// Can't beat what we already have, don't bother checking it
			if ( $area <= $max ) {
				continue;
			}

			$x_min = min( $ax, $bx );
			$x_max = max( $ax, $bx );
			$y_min = min( $ay, $by );
			$y_max = max( $ay, $by );

			// If any edge cuts into the inside of the rectangle, part of it is outside the shape
			foreach ( $edges as [ $ex_min, $ey_min, $ex_max, $ey_max ] ) {
				if ( $ex_min < $x_max && $ex_max > $x_min && $ey_min < $y_max && $ey_max > $y_min ) {
					continue 2;
				}
			}

			// Nothing cuts through, so it's all inside or all outside. Check the middle.
			// Count the vertical edges to the right of it: odd means inside.
			$cx = ( $x_min + $x_max ) / 2;
			$cy = ( $y_min + $y_max ) / 2;
			$crossings = 0;

			foreach ( $edges as [ $ex_min, $ey_min, $ex_max, $ey_max ] ) {
				if ( $ex_min === $ex_max && $ex_min > $cx && $ey_min <= $cy && $cy < $ey_max ) {
					$crossings++;
				}
			}

			$on_edge = $x_max - $x_min <= 1 || $y_max - $y_min <= 1;

			if ( ! $on_edge && $crossings % 2 === 0 ) {
				continue;
			}

			$max = $area;
		}
	}

	echo $max;

}

echo PHP_EOL . 'Day 09: Movie Theater' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
