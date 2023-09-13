<?php

/**
 * Day DAY: TITLE
 */

// The usual
$data = file_get_contents('data/data-DAY.txt');
//$data = file_get_contents('data/data-DAY-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
    # Do Stuff
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

echo PHP_EOL . 'Day 05: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;