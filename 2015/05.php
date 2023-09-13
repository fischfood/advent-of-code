<?php

/**
 * Day 05: Doesn't He Have Intern-Elves For This?
 */

// The usual
$data = file_get_contents('data/data-05.txt');
$rows = explode("\n", $data);

$sample_1 = ['ugknbfddgicrmopn', 'aaa', 'jchzalrnumimnmhp', 'haegwjzuvuyypxyu', 'dvszwmarrgswjxmb' ];
$sample_2 = ['qjhvhtzxzqqjkmpb', 'xxyxx', 'uurcxstgmygtbstg', 'ieodomkazucvgmuy'];

$dataset = $rows;

// Part One - How many strings are nice?
function part_one($dataset) {
    $nice = 0;
    foreach( $dataset as $string ) {
        
        // Must have 3 vowels
        $vowels = preg_replace("/[^aeiou]/", "",$string);
        if ( strlen( $vowels ) < 3 ) {
            continue;
        }

        // Must have double characters
        $doubles = preg_match('/(.)\1+/', $string );
        if ( $doubles < 1 ) {
            continue;
        }

        // Can't have these strings
        $disallowed = preg_match('(ab|cd|pq|xy)', $string, $matches );
        if ( $disallowed > 0 ) {
            continue;
        }
        $nice++;
    }

    echo sprintf( 'Found %d nice strings', $nice );
}

// Part Two - How many strings are nice under these new rules?
function part_two($dataset) {
	$nice = 0;

    foreach( $dataset as $string ) {
        $group = [];
        $chars = str_split($string, 1);
        $dupe = false;

        for( $i = 0; $i < count( $chars ) - 1; $i++ ) {

            // Set two letters to check, this and one previous since we start at 1
            $letters = $chars[$i] . $chars[$i + 1];

            // If this letter group is already in the string...
            if ( array_key_exists( $letters, $group ) ) {

                // ...and it isn't the one previous
                if ( $i - $group[$letters] > 1 ) {
                    $dupe = true;
                }

            } else {
                $group[$chars[$i] . $chars[$i+1]] = $i;
            }
        }

        // Check sandwiching with successes
        if ( $dupe ) {

            for( $i = 2; $i < count( $chars ); $i++ ) {
                if ( $chars[$i-2] === $chars[$i] ) {
                    $nice++;
                    break;
                }
            }
        }
    }

    echo sprintf( 'Found %d nice strings', $nice );
}

echo PHP_EOL . "Day 05: Doesn't He Have Intern-Elves For This?" . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL . PHP_EOL;