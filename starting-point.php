<?php

/**
 * Day DAY: TITLE
 */

// The usual
$data = file_get_contents('data/data-DAY.txt');
//$data = file_get_contents('data/data-DAY-sample.txt');

$rows = explode("\n", $data);

$dataset = $rows;

// Part One
function part_one($dataset) {
    # Do Stuff
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day DAY: TITLE' . PHP_EOL;
echo 'Part 1: ' . part_one($dataset) . PHP_EOL;
echo 'Part 2: ' . part_two($dataset) . PHP_EOL;