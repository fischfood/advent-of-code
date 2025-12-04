<?php
/**
 * Day 04: Printing Department
 * Part 1: 0.02908 Seconds (20m32s - 4393rd)
 * Part 2: 0.85484 Seconds (34m44s - 4464th)
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-04.txt');
$data = file_get_contents('data/data-04-sample.txt');

$dataset = explode("\n", $data);

// Part One and Two
function part_one_and_two($dataset, $keep_going = false) {

	$map = [];
	$check = [];
	$y_bounds = sizeof( $dataset ) - 1;
	$x_bounds = strlen( $dataset[0] ) - 1;
	
	$accessible = 0;

	// Set above 0 to run
	$removed = 999;

	foreach ( $dataset as $y => $row ) {
		foreach ( str_split( $row ) as $x => $char ) {
			$map[$y][$x] = $char;
			if ( $char === '@' ) {
				$check[$y . ',' . $x] = "$y,$x";
			}
		}
	}

	// While we're removing at least one roll...
	while ( $removed > 0 ) {

		// Reset for subsequent runs
		$removed = 0;
		$cleared = [];

		// Check all coordinates
		foreach( $check as $c ) {
			[$y, $x] = explode( ',', $c );

			$adj_rolls = 0;

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
					// If there's another roll nearby, increase
					if ( ( $map[ $y + $dy ][ $x + $dx ] === '@' ) ) {
						$adj_rolls++;
					}
				}
			}

			// If surrounded by 4 or less rolls, we can grab it
			// Add to the list to be removed after this run, increase the total
			if ( $adj_rolls < 4 ) {
				$cleared[] = [$y, $x];
				$removed++;
				$accessible++;
			}
		}

		// Keep running, or stop at one run
		if ( $keep_going ) {

			// Remove any rolls we've grabbed from the map and the check
			foreach( $cleared as $c ) {
				[$y, $x] = $c;
				$map[ $y ][ $x ] = '.';
				unset( $check[ $y . ',' . $x ] );
			}

		} else {
			$removed = 0;
		}
	}

	echo $accessible;
}

echo PHP_EOL . 'Day 04: Printing Department' . PHP_EOL . 'Part 1: ';
part_one_and_two( $dataset );
echo PHP_EOL . 'Part 2: ';
part_one_and_two( $dataset, true) ;
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
