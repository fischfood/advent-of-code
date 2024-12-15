<?php

/**
 * Day 15: Warehouse Woes
 * Part 1: 0.01483 Seconds
 * Part 2: --
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-15.txt');
//$data = file_get_contents('data/data-15-sample.txt');
//$data = file_get_contents('data/data-15-sample-2.txt');

$rows = explode("\n\n", $data);
$dataset = $rows;

// Part One
function part_one($dataset) {
    [$warehouse, $dirs] = $dataset;
    $map = [];
    $start = [0,0];
    $total = 0;

    // Make dirs one line
    $dirs = implode( '', explode("\n", $dirs ) );

    foreach( explode( "\n", $warehouse ) as $y => $row ) {
        foreach( str_split( $row ) as $x => $char ) {
            $map[$y][$x] = $char;
            if ( $char === '@' ) {
                $start = [$x,$y];
            }
        }
    }

    //show_map( $map );

    foreach( str_split( $dirs ) as $dir ) {
        [$start, $map] = move_robot( $start, $map, $dir );
    }

    //show_map( $map );

    foreach( $map as $y => $row ) {
        foreach( $row as $x => $char ) {
            if ( $char === 'O' ) {
                $total += $x + ( $y * 100 );
            }
        }
    }

    echo $total;
}

// Part Two
function part_two($dataset) {
	# Do More Things
}

function move_robot( $start, $map, $dir ) { 

    $next = $start;

    $directions = [
        '<' => [-1, 0],
        '>' => [1, 0],
        '^' => [0, -1],
        'v' => [0, 1],
    ];

    if ( isset( $directions[$dir] ) ) {
        [$dx, $dy] = $directions[$dir];
        $next = [$start[0] + $dx, $start[1] + $dy];
    }

    // Check that block
    $next_char = $map[$next[1]][$next[0]];

    // If not a wall...
    if ( '#' !== $next_char ) {

        // If open, move and unset
        if ( '.' === $next_char ) {
            $map[$start[1]][$start[0]] = '.';
            $map[$next[1]][$next[0]] = '@';
            $start = $next;
        }

        // If box, attempt to push
        else {
            list( $map, $can_move ) = move_boxes( $next, $dir, $map );

            if ( $can_move ) {
                $map[$start[1]][$start[0]] = '.';
                $map[$next[1]][$next[0]] = '@';
                $start = $next;
            }
        }
    }

    return [$start, $map];
}

function move_boxes( $box_coords, $dir, $map ) {
    $queue = [];
    $can_move = true;
    [$x, $y] = $box_coords;

    $directions = [
        '>' => [1, 0], 
        '<' => [-1, 0],
        'v' => [0, 1], 
        '^' => [0, -1],
    ];
    
    [$dx, $dy] = $directions[$dir];
    $queue = [];
    
    for ($i = 1; ; $i++) {
        $nx = $x + ($i * $dx);
        $ny = $y + ($i * $dy);
    
        // If we go out of bounds, stop
        if ( ! isset($map[$ny][$nx] ) ) {
            $can_move = false;
            break;
        }
    
        $next_char = $map[$ny][$nx];
    
        // If we hit a wall, stop everything
        if ($next_char === '#') {
            $can_move = false;
            break;
        }
    
        // Otherwise, start adding directions
        $queue[] = [$nx, $ny];
    
        // If we hit an open spot, move everything before it
        if ($next_char === '.') {
            foreach ($queue as [$qx, $qy]) {
                $map[$qy][$qx] = 'O';
            }
            break;
        }
    }

    return [ $map, $can_move ];

}

function show_map( $map ) {
    foreach( $map as $row ) {
        echo "\n" . implode( '', $row );
    }
    echo "\n";
}

echo PHP_EOL . 'Day 15: Warehouse Woes' . PHP_EOL . 'Part 1: ';
part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;