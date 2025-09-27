<?php
/**
 * Day 11: Corporate Policy
 * Part 1: .43996 Seconds
 * Part 2: 1.6342 Seconds
 */

// The usual
$starttime = microtime(true);
$dataset = 'hepxcrrq';

// Part One
function part_one($dataset) {

	$run = true;

	$letters = str_split( $dataset );
	$numbers = array_map( function( $l ) { return ord( $l ) - 97; }, $letters );

	$run = true;

	while( $run ) {

		$numbers = increment_letters( $numbers );

		if ( rule_check( $numbers ) ) {
			break;
		}

	}

	return implode( '', array_map( function( $n ) { return chr( $n + 97 ); }, $numbers ) );

}

// Part Two
function part_two($dataset) {
	// Not needed, just run part one within part one
}

function increment_letters( $numbers ) {
	$len       = count( $numbers );
	$forbidden = [8, 11, 14];

	// If we land on a forbidden letter, increase, and set rest to a / zero. Don't bother checking
	for ( $i = 0; $i < $len; $i++ ) {
		if ( in_array( $numbers[$i], $forbidden, true ) ) {
			$numbers[$i]++;

			// Zero everything to the right
			for ( $j = $i + 1; $j < $len; $j++ ) {
				$numbers[$j] = 0;
			}

			return $numbers;
		}
	}

	// Otherwise, run through from the back, incrementing
	for ( $i = $len - 1; $i >= 0; $i-- ) {
		$v = $numbers[$i] + 1;

		if ( $v > 25 ) {
			$numbers[$i] = 0;
			continue;
		}

		// If we land on a forbidden letter, increase, and set rest to a / zero
		if ( in_array( $v, $forbidden, true ) ) {
			$v++;
			$numbers[$i] = $v;
			for ( $j = $i + 1; $j < $len; $j++ ) {
				$numbers[$j] = 0;
			}
			return $numbers;
		}

		$numbers[$i] = $v;
		return $numbers;
	}

	return $numbers;
}

function rule_check( $numbers ) {

	// Fail if string contains i, o, or l (8,14,11)
	if ( array_intersect( [8,11,14], $numbers) ) {
		// echo 'Fail on i-o-l';
		return false;
	}

	// Fail if string doesn't contain three consecutive
	$consecutive = false;
	for ( $i = 0; $i <= count($numbers) - 3; $i++ ) {
		if ( $numbers[$i] === $numbers[$i + 1] - 1 && $numbers[$i] === $numbers[$i + 2] - 2 ) {
			$consecutive = true;
			break;
		}
	}

	if ( ! $consecutive ) {
		// echo 'Fail on abc';
		return false;
	}

	// Fail if it doesn't contain two overlapping pairs
	$pairs = [];
	for ( $i = 0; $i < count( $numbers ) - 1; $i++ ) {
		if ( $numbers[$i] === $numbers[$i + 1] ) {
			$pairs[] = $numbers[$i];
			$i++; // skip next since it already matches, and we can't have triples
		}
	}

	// Make sure there are two
	if ( count( array_unique( $pairs ) ) < 2 ) {
		// echo 'Fail on aa + bb';
		return false;
	}

	// If no fails, it's a success
	// echo 'Passed: ';
	return true;
}

echo PHP_EOL . 'Day 11: Corporate Policy' . PHP_EOL . 'Part 1: ';
echo part_one($dataset);
echo PHP_EOL . 'Part 2: ';
echo part_one( part_one($dataset) );
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
