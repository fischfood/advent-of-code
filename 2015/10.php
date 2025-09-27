<?php
ini_set('memory_limit', '10G');

/**
 * Day 10: TITLE
 * Part 1: .15752 Seconds
 * Part 2: 2.7098 Seconds
 */

// The usual
$data = 1321131112;
//$data = 1;

$starttime = microtime(true);

// Part One
function look_and_say( $data, $limit ) {

	$ds = $data;

	for ( $i = 1; $i <= $limit; $i++ ) {

		$d = str_split( $ds );
		$ds = '';

		$current = $d[0];
		$count   = 1;
		$output  = [];

		for ( $j = 1, $len = count( $d ); $j < $len; $j++ ) {
			if ( $d[$j] === $current ) {
				$count++;
			} else {
				$output[] = $count;
				$output[] = $current;
				$current  = $d[$j];
				$count    = 1;
			}
		}

		$output[] = $count;
		$output[] = $current;

		$ds = implode( '', $output );
	}

	echo strlen( $ds );
}

echo PHP_EOL . 'Day 10: TITLE' . PHP_EOL . 'Part 1: ';
look_and_say( $data, 40 );
echo PHP_EOL . 'Part 2: ';
look_and_say( $data, 50 );
echo PHP_EOL. 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL . PHP_EOL;
