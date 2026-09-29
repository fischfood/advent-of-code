<?php
/**
 * Day 01: Secret Entrance
 * Part 1: 0.00192 Seconds (23h - N/A)
 * Part 2: 0.00316 Seconds (>24h - N/A)
 */

// The usual
$loctime = microtime(true);
$data = file_get_contents('data/data-01-sample.txt');
// $data = file_get_contents('data/data-01.txt');


$dataset = explode("\n", $data);

// Part One
function part_one($dataset) {

	$loc = 50;
	$min = 0;
	$max = 99;
	$zero = 0;

	foreach( $dataset as $data ) {
		preg_match('/(.)(\d+)/', $data, $matches);
		
		[ $full, $dir, $num ] = $matches;

		if ( $dir === 'L' ) {
			$loc -= $num;
			if ( $loc < $min ) {
				$loc = $max - ( $min - $loc - 1 );
				$loc = $loc % ( $max + 1 );
			}
		} else {
			$loc += $num;
			if ( $loc > $max ) {
				$loc = $min + ( $loc - $max - 1 );
				$loc = $loc % ( $max + 1 );
			}
		}

		if ( $loc === 0 ) {
			$zero++;
		}

	}

	echo $zero;
}

// Part Two
function part_two( $dataset ) {

	$cur_pos  = 50;
	$zero = 0;

	foreach ( $dataset as $data ) {

		preg_match( '/(.)(\d+)/', $data, $matches );

		[ $full, $dir, $num ] = $matches;

		// Every 100 is a full rotation
		$zero += floor( $num / 100 );

		// Remaining num to move
		$remaining_clicks = $num % 100;

		if ( $dir === 'R' ) {

			// Distance until we hit 0 when moving right
			$steps_to_zero = (100 - $cur_pos) % 100;  

			// We hit 0 only if 0 is reached within remainder steps
			if ($steps_to_zero > 0 && $steps_to_zero <= $remaining_clicks) {
				$zero++;
			}

			// Move position
			$cur_pos = ($cur_pos + $remaining_clicks) % 100;

		} else {

			if ($cur_pos > 0 && $cur_pos <= $remaining_clicks) {
				$zero++;
			}

			$cur_pos = ($cur_pos - $remaining_clicks);

			if ($cur_pos < 0) {
				$cur_pos += 100;
			}
		}

	}

	echo $zero;	
}



echo PHP_EOL . 'Day 01: Secret Entrance' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $loctime );
echo PHP_EOL;
