<?php
/**
 * Day 07: Laboratories
 * Part 1: 0.00639 Seconds (41m27s - N/A)
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-07.txt');
// $data = file_get_contents('data/data-07-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include_once( '../functions.php' );

// Needs a little help to keep going, but this is overkill
ini_set('memory_limit', '10G');

// Part One
function part_one($dataset) {
	
	$grid = [];
	$splits = [];
	$start = '';
	$laser_positions = [];

	$height = count( $dataset );

	foreach ($dataset as $y => $row) {
		foreach( str_split( $row ) as $x => $char ) {
			$grid[ $y ][ $x ] = $char;

			if ( $char === 'S' ) {
				$start = $y . ',' . $x;
			}

			if ( $char === '^' ) {
				$splits[$y . ',' . $x] = '^';
			}
		}
	}

	$check = [$start];
	$visited = [];
	$hit_splits = [];
	$tot_splits = 0;
	
	$i = 1; // Failsafe

	while ( count( $check ) > 0 ) {
		$checking = array_pop( $check );
		$visited[$checking] = true;

		[ $y, $x ] = explode( ',', $checking );

		if ( $y == $height ) {
			continue;
		}

		if ( array_key_exists( ( $y ) . ',' . $x, $splits ) ) {
			
			$hit_splits[ ( $y ) . ',' . $x ] = true;

			foreach ( [$x + 1, $x - 1] as $sx ) {
				if ( ! isset( $visited[ "$y,$sx"] ) ) {
					$check[] =  "$y,$sx";
				}
			}
			
		} else {
			// Continue Falling
			$next = ( $y + 1 ) . ",$x";
			if ( ! isset( $visited[$next] ) ) {
				$check[] = $next;
			}
			$grid[ $y ][ $x ] = '|';
		}

		$i++;
	}

	foreach( $grid as $row ) {
		// echo PHP_EOL . implode( '', $row );
	}

	echo count( $hit_splits );
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day 07: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
