<?php

/**
 * Day 02: Red-Nosed Reports
 */

// The usual
$data = file_get_contents('data/data-02.txt');
// $data = file_get_contents('data/data-02-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
    
    $result = 0;

    foreach ( $dataset as $row ) {
        $result += check( $row );
    }

    echo $result;
}

// Part Two
function part_two($dataset) {

    $result = 0;

    foreach ( $dataset as $row ) {
        $result += any_safe( $row );
    }

    echo $result;
}

function any_safe( $row ) {

    $r = explode( ' ', $row );
    $count = count($r);
    $success = 0;

    for ( $i = 0; $i < $count; $i++ ) {
        $this_row = $r;
        unset( $this_row[$i] );
        $success = check( implode(' ', $this_row ) );
        
        if ( $success ) {
            break;
        }
    }

    return $success;
}

function check( $row ) {
    $start = false;
    $dir = '';
    $success = false;

    $r = explode( ' ', $row );

    foreach( $r as $k => $num ) {

        if ( ! $start ) {
            $start = $num;
        } else {
            if ( $num < $start && $dir !== 'inc' && ( $start - $num < 4 ) ) {
                $dir = 'dec';
                $start = $num;
            } elseif ( $num > $start && $dir !== 'dec' && ( $num - $start < 4 ) ) {
                $dir = 'inc';
                $start = $num;
            } else {                
               return 0;
            }
        }
    }

    return 1;
}

echo PHP_EOL . 'Day 02: Red-Nosed Reports' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;