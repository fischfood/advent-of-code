<?php
/**
 * Day 02: Gift Shop
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-02-sample.txt');
// $data = file_get_contents('data/data-02.txt');

$dataset = explode(",", $data);

// Part One
function part_one($dataset) {

	$inv_tot = 0;
	foreach( $dataset as $data ) {

		[$low, $high] = explode( '-', $data );

		// Check every number in range
		for ( $i = $low; $i <= $high; $i++ ) {

			$str_i = (string) $i;
			$len = strlen( $str_i );

			// Check for even length
			if ( $len % 2 !== 0 ) {
				continue;
			}

			// Split in half
			$half_len = $len / 2;
			$first_half = substr( $str_i, 0, $half_len );
			$second_half = substr( $str_i, $half_len, $half_len );

			if ( $first_half === $second_half ) {
				$num = (int) $first_half . $second_half;
				$inv_tot = $inv_tot + $num;
			}
		}

	}

	echo $inv_tot;

}

// Part Two
function part_two($dataset) {

	$inv_tot = 0;
	foreach( $dataset as $data ) {

		[$low, $high] = explode( '-', $data );

		// Check every number in range
		for ( $i = $low; $i <= $high; $i++ ) {

			$str_i = (string) $i;
			$len = strlen( $str_i );

			// Check for all possible sequence length repetitions
			for ( $seq_len = 1; $seq_len <= floor( $len / 2 ); $seq_len++ ) {
				
				if ( $len % $seq_len !== 0 ) {
					continue;
				}

				$repeats = $len / $seq_len;
				$sequence = substr( $str_i, 0, $seq_len );
				$constructed = str_repeat( $sequence, $repeats );

				if ( $constructed === $str_i ) {
					$num = (int) $sequence . str_repeat( $sequence, $repeats - 1 );
					$inv_tot = $inv_tot + $num;
					break; // No need to check further sequence lengths
				}
			}
		}

	}

	echo $inv_tot;
}

echo PHP_EOL . 'Day 02: Gift Shop' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
