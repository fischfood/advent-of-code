<?php
/**
 * Day 11: Reactor
 * Part 1: 0.00080 Seconds (19m43s ~ 2708th
 * Part 2: 0.00079 Seconds (63m25s ~ 2872nd)
 */

// The usual
$starttime = microtime(true);
$sample = true;

if ( isset( $sample ) ) {
	$data_1 = explode("\n", file_get_contents('data/data-11-sample.txt'));
	$data_2 = explode("\n", file_get_contents('data/data-11-sample-2.txt'));
} else {
	$data_1 = $data_2 = explode("\n", file_get_contents('data/data-11.txt'));
}

// Part One
function part_one($dataset) {

	$paths = [];
	$exits = [];

	foreach( $dataset as $row ) {
		[ $name, $outputs ] = explode( ': ', $row );

		if ( $outputs == 'out' ) {
			$exits[] = $name;
		} else {
			$paths[$name] = explode( ' ', $outputs );
		}
	}

	$finished_paths = follow_path( $paths['you'], 'you', [], $paths, $exits );

	echo count( $finished_paths );
}

// Part Two
function part_two($dataset) {

	$paths = [];

	foreach( $dataset as $row ) {
		[ $name, $outputs ] = explode( ': ', $row );
		$paths[$name] = explode( ' ', $outputs );
	}

	$memo = [];
	$srv_to_fft = count_paths( $paths['svr'], 'fft', $paths, $memo );
	$fft_to_dac = count_paths( $paths['fft'], 'dac', $paths, $memo );
	$dac_to_out = count_paths( $paths['dac'], 'out', $paths, $memo );

	echo $srv_to_fft * $fft_to_dac * $dac_to_out;
}

function follow_path( $paths_to_check, $cur_path, $paths_followed, $paths, $exits ) {
	
	foreach( $paths_to_check as $path ) {
		if ( in_array( $path, $exits ) ) {
			$paths_followed[] = $cur_path . ' > ' . $path . ' > OUT';
		} else {
			if ( $path !== 'out' ) {
				$paths_followed = follow_path( $paths[$path], $cur_path . ' > ' . $path, $paths_followed, $paths, $exits );
			}
		}
	}

	// print_r( $paths_followed );
	return $paths_followed;
}


function count_paths( $paths_to_check, $target, $paths, &$memo = [] ) {
	
	$total = 0;
	
	foreach( $paths_to_check as $path ) {

		// Use memoization
		$cache_key = $path . '->' . $target;
		if ( isset($memo[$cache_key]) ) {
			$total += $memo[$cache_key];
			continue;
		}
		
		if ( $path === $target ) {
			// Found the target! Count this path
			$memo[$cache_key] = 1;
			$total += 1;

		} else if ( $path === 'out' ) {
			// Hit an exit without finding target, dead end
			$memo[$cache_key] = 0;

		} else if ( isset($paths[$path]) ) {
			// Keep following the path
			$count = count_paths( $paths[$path], $target, $paths, $memo );
			$memo[$cache_key] = $count;
			$total += $count;

		} else {
			$memo[$cache_key] = 0;
		}
	}

	return $total;
}

echo PHP_EOL . 'Day 11: Reactor' . PHP_EOL . 'Part 1: ';
part_one($data_1);
echo PHP_EOL . 'Part 2: ';
part_two($data_2);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
