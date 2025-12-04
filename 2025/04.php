<?php
/**
 * Day 04: Printing Department
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-04.txt');
$data = file_get_contents('data/data-04-sample.txt');

$rows = explode("\n", $data);

$dataset = $rows;
include_once( '../functions.php' );

// Part One
function part_one($dataset) {

	$map = [];
	$check = [];
	$y_bounds = sizeof( $dataset ) - 1;
	$x_bounds = strlen( $dataset[0] ) - 1;
	$allowed = 0;

	foreach ( $dataset as $y => $row ) {
		foreach ( str_split( $row ) as $x => $char ) {
			$map[$y][$x] = $char;
			if ( $char === '@' ) {
				$check[] = "$y,$x";
			}
		}
	}

	foreach( $check as $c ) {
		// echo "Checking $c: ";
		[$y, $x] = explode( ',', $c );

		$roll_total = 0;

		$dirs = [
			[-1, -1],
			[-1, 1],
			[1, -1],
			[1,1],
			[-1, 0],
			[1,0],
			[0,1],
			[0,-1]
		];

		foreach( $dirs as $dir ) {
			[$dy, $dx] = $dir;
			if ( 
				( $y + $dy ) >= 0 &&
				( $y + $dy ) <= $y_bounds &&
				( $x + $dx ) >= 0 &&
				( $x + $dx ) <= $y_bounds
			) {
				if ( ( $map[ $y + $dy ][ $x + $dx ] === '@' ) ) {
					$roll_total++;
				}
			}
		}

		// echo "y: $roll_total;";
		// echo PHP_EOL;

		if ( $roll_total < 4 ) {
			$allowed++;
		}
	}

	echo $allowed;
}

// Part Two
function part_two($dataset) {
	$map = [];
	$check = [];
	$y_bounds = sizeof( $dataset ) - 1;
	$x_bounds = strlen( $dataset[0] ) - 1;
	$allowed = 0;

	$removed = 1;

	foreach ( $dataset as $y => $row ) {
		foreach ( str_split( $row ) as $x => $char ) {
			$map[$y][$x] = $char;
			if ( $char === '@' ) {
				$check[$y . ',' . $x] = "$y,$x";
			}
		}
	}

	while ( $removed > 0 ) {

		// echo PHP_EOL . "New Run " . sizeof( $check ) . ": ";


		$removed_this_time = 0;
		$cleared = [];

		foreach( $check as $c ) {
			// echo "Checking $c: ";
			[$y, $x] = explode( ',', $c );

			$roll_total = 0;

			$dirs = [
				[-1, -1],
				[-1, 1],
				[1, -1],
				[1,1],
				[-1, 0],
				[1,0],
				[0,1],
				[0,-1]
			];

			foreach( $dirs as $dir ) {
				[$dy, $dx] = $dir;
				if ( 
					( $y + $dy ) >= 0 &&
					( $y + $dy ) <= $y_bounds &&
					( $x + $dx ) >= 0 &&
					( $x + $dx ) <= $y_bounds
				) {
					if ( ( $map[ $y + $dy ][ $x + $dx ] === '@' ) ) {
						$roll_total++;
					}
				}
			}

			// echo "y: $roll_total;";
			// echo PHP_EOL;

			if ( $roll_total < 4 ) {
				$cleared[] = [$y, $x];
				$removed_this_time++;
				$allowed++;
			}
		}

		// echo PHP_EOL . $removed_this_time . PHP_EOL;

		$removed = $removed_this_time;

		foreach( $cleared as $c ) {
			[$y, $x] = $c;
			$map[ $y ][ $x ] = '.';
			unset( $check[ $y . ',' . $x ] );
		}
	}

	echo $allowed;
}

echo PHP_EOL . 'Day 04: Printing Department' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
