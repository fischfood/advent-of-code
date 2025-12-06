<?php
/**
 * Day 06: Trash Compactor
 * Part 1: 0.00100 Seconds (25m35s - 4680th)
 * Part 2: 0.00211 Seconds (58m37s - 3804th)
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-06.txt');
$data = file_get_contents('data/data-06-sample.txt');

$dataset = explode("\n", $data);

// Part One
function part_one($dataset) {

	$problem_data = [];
	$total = 0;

	foreach( $dataset as $d ) {
		
		// For each row, split at the space...
		$nums = explode( ' ', $d );

		// Then strip the blank rows, and reset the keys so the line up vertically
		$problem_data[] = array_values( array_filter( $nums ) );
	}

	// Get how many problems there are total, and how many numbers in each (plus operator)
	$problems_total = sizeof( $problem_data[1] );
	$numbers = count( $dataset );
	$problems = [];

	// Flips rows and columns to join problems
	for ( $col = 0; $col < $problems_total; $col++ ) {
		for ( $row = 0; $row < $numbers; $row++ ) {
			$problems[$col][$row] = $problem_data[$row][$col];
		}
	}

	foreach( $problems as $problem ) {

		$nums = [];

		// Grab the numbers
		for ( $i = 0; $i < $numbers - 1; $i++ ) {
			$nums[] = $problem[$i];
		}

		// Operator is last
		$math = $problem[$numbers - 1];

		// Add the sum/product to the total
		if ( $math === '*' ) {
			$total += array_product( $nums );
		} else {
			$total += array_sum( $nums );
		}
	}

	echo $total;

}

// Part Two
function part_two($dataset) {

	$total = 0;
	$digit_data = [];
	$operators = [];

	$i = 0;

	foreach( $dataset as $d ) {
		$digits = str_split( strrev( $d ) );

		foreach( $digits as $k => $dig ) {

			if ( in_array( $dig, ['*','+'] ) ) {
				$operators[$i] = $dig;
				$i++;
			} else {
				if ( array_key_exists( $k, $digit_data ) ) {
					$digit_data[$k] = trim( $digit_data[$k] . $dig );
				} else {
					$digit_data[$k] = $dig;
				}
			}
		}
	}

	// Group numbers into problems
	$math = [];
	$mm = 0;

	// If it's a number, add it to the problem, otherwise create a new problem
	foreach( $digit_data as $dd ) {
		if ( is_numeric( $dd ) ) {
			$math[$mm][] = $dd;
		} else {
			$mm++;
		}
	}

	// Run each problem, and add the sum/product to the total
	foreach( $math as $k => $m ) {
		if ( $operators[$k] === '*' ) {
			$total += array_product( $m );
		} else {
			$total += array_sum( $m );
		}
	}

	echo $total;

}

echo PHP_EOL . 'Day 06: Trash Compactor' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
