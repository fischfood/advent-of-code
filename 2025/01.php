<?php
/**
 * Day 01: Secret Entrance
 */

// The usual
$loctime = microtime(true);
$data = file_get_contents('data/data-01.txt');
$data = file_get_contents('data/data-01-sample.txt');


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

	$min  = 0;
	$max  = 99;
	$span = $max - $min + 1;
	$cur_pos  = 50;
	$zero = 0;

	foreach ( $dataset as $data ) {

		preg_match( '/(.)(\d+)/', $data, $matches );

		[ $full, $dir, $num ] = $matches;

		$last_pos = $cur_pos;

		// Forget the reset, keep it on a solid line
		if ( 'L' === $dir ) {
			$cur_pos -= $num;
		} else {
			$cur_pos += $num;
		}

		// Check if we're ending on a multiple of 100
		if ( $cur_pos % $span === 0 ) {
			$zero++;
		}

		// Set your numbers as the next lowest integer / 100
		// 58 / 100 = 0.58 = 0
		// 104 / 100 = 1.04 = 1
		// -22 / 100 = -0.22 = -1

		$starting_span = floor( $last_pos / $span );
		$ending_span = floor( $cur_pos / $span );

		// Calculate the change distance and add it to that many zeros being crossed
		$range_changes = abs( $ending_span - $starting_span );

		$zero += $range_changes;
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
