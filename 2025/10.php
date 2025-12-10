<?php
/**
 * Day 10: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-10.txt');
$data = file_get_contents('data/data-10-sample.txt');

ini_set('memory_limit', '10G');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
	$presses = 0;
	
	foreach( $dataset as $data ) {
		$this_presses = PHP_INT_MAX;
		preg_match('/\[(.*)\]\s(.*)\s\{(.*)\}/', $data, $matches);

		[ $full, $lights, $wiring, $joltage ] = $matches;

		$target = str_replace( ['.','#'], [0,1], $lights);

		$wiring = explode(' ', str_replace( ['(',')'], '', $wiring ) );

		$switches = [];
		foreach( $wiring as $buttons ) {
			$switches[] = explode( ',', $buttons );
		}

		for ( $i = 1; $i < pow( 2, count( $switches ) ); $i++ ) {
			$start = array_fill( 0, strlen( $target ), 0 );
			$actions = str_split( str_pad( decbin( $i ), count( $switches ), 0, STR_PAD_LEFT ) );
			foreach( $actions as $button => $action ) {
				if ( $action == 1 ) {
					foreach( $switches[$button] as $light ) {
						$start[$light] = ( $start[$light] + 1 ) % 2;
					}
				}
				// Could be cleaned up to stop midway, or try only single presses, then two presses, etc
			}
			if ( implode( '', $start ) == $target && array_sum( $actions ) < $this_presses ) {
				$this_presses = array_sum( $actions );
			}
		}

		$presses += $this_presses;
		
	}

	echo $presses;

}

// Part Two
function part_two($dataset) {
	$total_presses = 0;
	
	foreach( $dataset as $data ) {
		$this_presses = PHP_INT_MAX;
		preg_match('/\[(.*)\]\s(.*)\s\{(.*)\}/', $data, $matches);

		[ $full, $lights, $wiring, $joltage ] = $matches;
		$joltage = explode( ',', $joltage );

		$wiring = explode(' ', str_replace( ['(',')'], '', $wiring ) );

		$max_presses = [];
		foreach( $wiring as $bidx => $buttons ) {
			$mp = PHP_INT_MAX;
			foreach( explode( ',', $buttons) as $button ) {
				if ( $joltage[$button] < $mp ) {
					$mp = $joltage[$button];
				}
			}

			$max_presses[$bidx] = $mp;
		};

		$combinations = generate_combinations( $max_presses );

		// Now run through combinations until we find a match to the target $joltage
		foreach( $combinations as $combination ) {
			$start = array_fill( 0, count( $joltage ), 0 );
			foreach( $combination as $bidx => $presses ) {
				if ( $presses > 0 ) {
					$buttons = explode( ',', $wiring[$bidx] );
					foreach( $buttons as $button ) {
						$start[$button] += $presses;
					}
				}
				// echo implode( ',', $start ) . ' vs ' . implode( ',', $joltage ) . PHP_EOL;

				if ( $start == $joltage && array_sum( $combination ) < $this_presses ) {
					$this_presses = array_sum( $combination );
				}
			}
		}

		$total_presses += $this_presses;
		
	}

	echo $total_presses;
}

function generate_combinations( array $maxes ) {
	$results = [];

	$count   = count( $maxes );
	if ( $count === 0 ) {
		return $results;
	}

	// Start at all zeros.
	$current = array_fill( 0, $count, 0 );

	while ( true ) {
		$results[] = $current;

		// Increment like an odometer from the last position backwards.
		$pos = $count - 1;

		while ( $pos >= 0 ) {
			if ( $current[ $pos ] < $maxes[ $pos ] ) {
				// We can increment this position.
				$current[ $pos ]++;

				// Reset all positions to the right back to 0.
				for ( $i = $pos + 1; $i < $count; $i++ ) {
					$current[ $i ] = 0;
				}

				// Successfully incremented; go record next combination.
				break;
			} else {
				// This position is at its max; carry to the left.
				$pos--;
			}
		}

		// If we ran past the leftmost position, we’re done.
		if ( $pos < 0 ) {
			break;
		}
	}

	return $results;
}

echo PHP_EOL . 'Day 10: TITLE' . PHP_EOL . 'Part 1: ';
// part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
