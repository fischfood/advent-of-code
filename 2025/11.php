<?php
/**
 * Day 11: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-11.txt');
// $data = file_get_contents('data/data-11-sample.txt');
// $data = file_get_contents('data/data-11-sample-2.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;
include_once( '../functions.php' );

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

	$begin = $paths['you'];

	$finished_paths = follow_path( $begin, 'you', [], $paths, $exits );

	echo count( $finished_paths );
}

function follow_path( $paths_to_check, $cur_path, $paths_followed, $paths, $exits ) {
	foreach( $paths_to_check as $path ) {
		if ( in_array( $path, $exits ) ) {
			$paths_followed[] = $cur_path . ' > ' . $path . ' > OUT';
		} else {
			$paths_followed = follow_path( $paths[$path], $cur_path . ' > ' . $path, $paths_followed, $paths, $exits );
		}
	}

	// print_r( $paths_followed );

	return $paths_followed;
}


// Part Two
function part_two($dataset) {
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

	$begin = $paths['svr'];

	$finished_paths = follow_path( $begin, 'svr', [], $paths, $exits );

	$fft_dac = 0;

	foreach ( $finished_paths as $path ) {
		if ( str_contains( $path, ' fft ' ) && str_contains( $path, ' dac ' ) ) {
			$fft_dac++;
		}
	}

	echo $fft_dac;
}

echo PHP_EOL . 'Day 11: TITLE' . PHP_EOL . 'Part 1: ';
// part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
