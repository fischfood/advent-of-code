<?php

/**
 * Day 05: Print Queue
 * Part 1: 0.00838 Seconds
 * Part 2: 0.02415 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-05.txt');
//$data = file_get_contents('data/data-05-sample.txt');

$dataset = $data;

// Part One
function part_one($dataset) {
    $total = 0;

    // Map each number with which other number comes before and after, function below
    list( $nums, $updates ) = order_update_mapping( $dataset );

    // Run through the pages to check if they are in the proper order
    foreach( $updates as $update ) {

        // Split numbers for testing
        $line = explode( ',', $update );

        // Check if the order passes the proper order or not, function below
        $pass = determine_if_order_passes( $line, $nums );

        // If all checks passed, take the length of the array, subtract one and divide by two to get the middle. Add that to the total.
        // Arrays start at 0, so for example [0,1,2,3,4] - Length is 5, last key is 4, divide by two and we get the middle (2)
        if ( $pass ) {
            $total += $line[(count($line) - 1) / 2];
        }
    }

    // Output the total of all middle numbers
    echo $total;

}

// Part Two
function part_two($dataset) {
    $fails = [];
    $total = 0;

    // Map each number with which other number come before and after
    list( $nums, $updates ) = order_update_mapping( $dataset );

    // Run through the pages to check if they are in the proper order
    foreach( $updates as $update ) {

        // Split numbers for testing
        $line = explode( ',', $update );

        // Check if the order passes the proper order or not, function below
        $pass = determine_if_order_passes( $line, $nums );

        // This time we only need the failures. If it doesn't pass, add it to be checked
        if ( ! $pass ) {
            $fails[] = $line;
        }
    }

    // Run through each failure
    foreach( $fails as $fail_nums ) {

        $order = [];
        
        foreach( $fail_nums as $f ) {

            // We need to count how many come before and after compared to the other numbers in the list
            $before = 0;
            $after = 0;

            // Loop through each number in this line, and reference this number.
            // We want to check if this number comes before or after, and we gather how many times of each
            // Some numbers will have the same total of befores as others, so we need both
            // I failed initially because two numbers had 0 befores, but one has 3 afters and another had 4 afters
            for ( $i = 0; $i < count( $fail_nums ) - 1; $i++ ) {

                // Before check, does the number I want have befores...?
                if ( array_key_exists( 'before', $nums[$fail_nums[$i]] ) ) {
                    // And if so, does my original number exist in that list?
                    if ( in_array( $f, $nums[$fail_nums[$i]]['before'] ) ) {
                        $before++;
                    }
                }

                // After check, does the number I want have afters...?
                if ( array_key_exists( 'after', $nums[$fail_nums[$i]] ) ) {
                    // And if so, does my original number exist in that list?
                    if ( in_array( $f, $nums[$fail_nums[$i]]['after'] ) ) {
                        $after++;
                    }
                }
            }

            // We want befores to go 0 -> 9, A has 0 numbers before, B has 1 number before (A), C also has 1 number before...uh oh (A), D has 3 numbers before (ABC)
            // Say B has 1 number after, and C has 2 numbers after. More numbers after means it has to appear earlier, so C has to come before B.
            // So take an arbitarily large number, enough to keep all at the same length of digits, and subtract. 
            // 99 - 1 (B gets 98), 99 - 2 (C gets 97)
            // Now we can keep the order counting higher. Adding a period makes it a decimal
            // A = 0.3
            // C = 1.97
            // B = 1.98
            // D = 3.0
            $order[$before . '.' . (999 - $after)] = $f;
        }

        // Sort by the new key, reset the keys to be 0, 1, 2, etc, and grab the middle again
        krsort( $order );
        $order = array_values( $order );
        $total += $order[(count($order) - 1) / 2];
    }

    // Output the total of all middle numbers
    echo $total;

}

function order_update_mapping( $data ) {
    $numbers = [];

    // Break up orders (xx|xx) and updates (xx,xx,xx,xx) into their own groups
    list( $order_list, $update_list ) = explode("\n\n", $data);
    
    // Break those groups up into their own lines
    $orders = explode( "\n", $order_list );
    $updates = explode( "\n", $update_list );

    // Push each of the numbers to an array as the key, with the opposite number as the before/after
    foreach( $orders as $order ) {
        list( $a, $b ) = explode( '|', $order );
        $numbers[$a]['after'][] = $b;
        $numbers[$b]['before'][] = $a;
    }

    // Send back the map of all numbers, and the updates we will need to check if they're in the proper order
    return [$numbers, $updates];
}

function determine_if_order_passes( $line, $nums ) {

    // Assume the line will pass
    $pass = true;
    
    // For each number...
    foreach( $line as $k => $num ) {

        // Look at all the numbers ahead if it. If it is the last number, nothing is ahead
        for ( $i = $k+1; $i < count($line); $i++ ) {

            // If the number you're looking at isn't known to have any "after" numbers, it's an auto fail
            if ( !array_key_exists('after',$nums[$num] ) ) {
                $pass = false;
            } 

            // Otherwise, check if each number that comes after is in the after list
            else {
                // If not, fail again
                if ( ! in_array( $line[$i], $nums[$num]['after'] ) ) {
                    $pass = false;
                }
            }
        }
    }

    // Send back success or failure
    return $pass;
}

echo PHP_EOL . 'Day 05: Print Queue' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;