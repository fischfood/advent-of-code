<?php

/**
 * Day 08: TITLE
 */

// The usual
$data = file_get_contents('data/data-08.txt');
//$data = file_get_contents('data/data-08-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
    
    $char = 0;
    $val = 0;
   
    foreach( $dataset as $d ) {
        $char += strlen($d);
        
        $patterns = ['/\\\\(\\\\|\")/','/\\\\x(..)/'];
        $replace = ['P','Q'];
        $val += strlen( preg_replace($patterns, $replace, $d) ) - 2;

        // echo $d . ' - ' . preg_replace($patterns, $replace, $d);
        // echo "\n";
    }

    echo $char - $val;
}

// Part Two
function part_two($dataset) {
	$char = 0;
    $literal = 0;
   
    foreach( $dataset as $d ) {
        $char += strlen($d);
        
        $patterns = ['/"/','/\\\\/'];
        $replace = ['SQ','SS'];
        $literal += strlen( preg_replace($patterns, $replace, $d) ) + 2;
    }

    echo $literal - $char;
}

echo PHP_EOL . 'Day 08: TITLE' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;