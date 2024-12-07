<?php

/**
 * Day 07: Bridge Repair
 * Part 1: 1.93656 Seconds
 * Part 2: 109.60698 Seconds
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-07.txt');
$data = file_get_contents('data/data-07-sample.txt');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {

    // Operations we're using
    $try = ['*','+'];
    $sum = 0;

    foreach( $dataset as $k => $d ) {
    
        list( $total, $numbers ) = explode( ': ', $d );

        $nums = explode( ' ', $numbers );
        $count = count($nums) - 1;

        // We need to figure out how many operators are needed
        // For x + y, it's one, for x + y + z, it's two
        // For x,y we need to check x*y (0) and x+y (1)
        // for x,y,z, we need to check ++, +*, *+, and ** (11, 10, 01, 00);
        // This is basically binary, (3,2,1,0) with padding in front
        // This $op_binary_total will get the total spaces needed so we always have 0's in front
        $op_binary_total = count( str_split( str_pad( decbin( pow( 2, $count ) - 1 ), $count, 0 ) ) );

        // 1 = 1, 11 = 3, 111 = 7, 1111 = 15
        // This is 2^1 - 1, 2^2 - 1, 2^3 - 1, and 2^4 - 1
        // We'll make this our total, and split to binary within
        for ( $i = ( pow( 2, $count ) - 1 ); $i >= 0; $i-- ) {
            $ops = str_split( str_pad( decbin( $i ), $op_binary_total, 0, STR_PAD_LEFT) );
            
            // Start with the first item so we always add operation and digit together
            $eval = $nums[0];

            // For every number in the list, minus the first...
            for ( $j = 1; $j <= $count; $j++ ) {

                // .. get the operation we're trying, plus the next number
                $operation = $try[$ops[$j-1]];
                $next = $nums[$j];

                // Set the Evaluation...
                $equation = "$eval $operation $next";

                // ... and evaluate it (since it always goes in order, not PEMDAS)
                $eval = eval(" return $equation;" );
                
                // If we're bigger, we can't go lower. Break out, try the next.
                if ( $eval > $total ) {
                    break;
                }
            }

            // If we hit a success, add it and break out
            if ( $eval == $total ) {
                $sum += $total;
                break;
            }
        }
    }

    echo $sum;
}

// Part Two
function part_two($dataset) {
    // Operations we're using, now adding a third (but we won't reference it)
    $try = ['+','*','||'];
    $sum = 0;

    foreach( $dataset as $k => $d ) {
        list( $total, $numbers ) = explode( ': ', $d );

        $nums = explode( ' ', $numbers );
        $count = count($nums) - 1;

        // Again, We need to figure out how many operators are needed
        // For x + y, it's one, for x + y + z, it's two
        // Now, for x,y we need to check x*y (0), x+y (1), and x||y (2)
        // for x,y,z, we need to check || ||, ||+, ||*, +||, ++, +*, *||, *+, and ** (22, 21, 20, 12, 11, 10, 02, 01, 00);
        // Where binary has 0 and 1, ternary (base 3) has 0, 1, and 2
        $op_ternary_total = count( str_split( str_pad( decbin( pow( 2, $count ) - 1 ), $count, 0 ) ) );

        // Now instead of 2^x - 1 we need 3^x - 1
        for ( $i = ( pow( 3, $count ) - 1 ); $i >= 0; $i-- ) {
            $ops = str_split( str_pad( base_convert( $i, 10, 3 ), $op_ternary_total, 0, STR_PAD_LEFT) );
            
            $eval = $nums[0];

            // This remains the same, loop through each
            for ( $j = 1; $j <= $count; $j++ ) {
                $operation = $try[$ops[$j-1]];
                $next = $nums[$j];

                // Now we just need to add a check for the ||
                // If the key is 2 (which is ||), merge the numbers instead of adding / multiplying
                // The rest remains the same
                if ( $ops[$j-1] == 2 ) {
                    $equation = "$eval$next";
                } else {
                    $equation = "$eval $operation $next";
                }

                // Evaluate it
                $eval = eval(" return $equation;" );
                
                // If we're bigger, we can't go lower. Break out.
                if ( $eval > $total ) {
                    break;
                }
            }

            // If we hit a success, add it and break out
            if ( $eval == $total ) {
                $sum += $total;
                break;
            }
        }
    }

    echo $sum;
}

echo PHP_EOL . 'Day 07: Bridge Repair' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;