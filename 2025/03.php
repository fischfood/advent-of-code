<?php
/**
 * Day 03: Lobby
 * Part 1: 0.00128 Seconds (20m05s - 2979th)
 * Part 2: 0.00251 Seconds (31m29s - 2369th)
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-03.txt');
// $data = file_get_contents('data/data-03-sample.txt');

$dataset = explode("\n", $data);

// Part Two
function part_one_and_two( $dataset, $length ) {

	$total = 0;

	foreach ( $dataset as $d ) {
		$nums   = str_split( $d );
		$string = '';

		// While our string is less than what's needed
		while ( strlen( $string ) < $length ) {

			// Maximum Key distance to hit string length
			$needed = count( $nums ) - ( $length - strlen( $string ) );

			// Get all digits before the cut off
			$remaining = array_slice( $nums, 0, $needed + 1, true );

			// Give me the earliest position of each digit that's available
			$unique = array_unique( $remaining );

			// Sort and get largest digit
			asort( $unique );
			$largest = array_key_last( $unique );

			// Add to string
			$string .= $nums[ $largest ];

			// Set available digits remaining to this key + 1
			$nums = array_slice( $nums, $largest + 1 );
		}

		// Add final string to the total
		$total += (int) $string;
	}

	echo $total;
}




echo PHP_EOL . 'Day 03: Lobby' . PHP_EOL . 'Part 1: ';
part_one_and_two($dataset, 2);
echo PHP_EOL . 'Part 2: ';
part_one_and_two($dataset, 12);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
