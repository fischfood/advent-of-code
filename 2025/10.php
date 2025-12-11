<?php
/**
 * Day 10: TITLE
 */

// The usual
$starttime = microtime(true);
$data = file_get_contents('data/data-10.txt');
$data = file_get_contents('data/data-10-sample.txt');

ini_set('memory_limit', '10G');

$rows = explode("\n", $data);
$steps = str_split($data, 1);

$dataset = $rows;

// Part One
function part_one($dataset) {
	$presses = 0;
	
	foreach( $dataset as $data ) {
		$this_presses = PHP_INT_MAX;
		preg_match('/\[(.*)\]\s(.*)\s\{(.*)\}/', $data, $matches);

		[ $full, $lights, $wiring, $joltage ] = $matches;

		$target = str_replace( ['.','#'], [0,1], $lights);

		$wiring = explode(' ', str_replace( ['(',')'], '', $wiring ) );

		$switches = [];
		foreach( $wiring as $buttons ) {
			$switches[] = explode( ',', $buttons );
		}

		for ( $i = 1; $i < pow( 2, count( $switches ) ); $i++ ) {
			$start = array_fill( 0, strlen( $target ), 0 );
			$actions = str_split( str_pad( decbin( $i ), count( $switches ), 0, STR_PAD_LEFT ) );
			foreach( $actions as $button => $action ) {
				if ( $action == 1 ) {
					foreach( $switches[$button] as $light ) {
						$start[$light] = ( $start[$light] + 1 ) % 2;
					}
				}
				// Could be cleaned up to stop midway, or try only single presses, then two presses, etc
			}
			if ( implode( '', $start ) == $target && array_sum( $actions ) < $this_presses ) {
				$this_presses = array_sum( $actions );
			}
		}

		$presses += $this_presses;
		
	}

	echo $presses;

}

// Part Two
function part_two($dataset) {
	$total_presses = 0;
	
	foreach( $dataset as $data ) {
		$this_presses = PHP_INT_MAX;
		preg_match('/\[(.*)\]\s(.*)\s\{(.*)\}/', $data, $matches);

		[ $full, $lights, $wiring, $joltage ] = $matches;
		$joltage = explode( ',', $joltage );

		$wiring = explode(' ', str_replace( ['(',')'], '', $wiring ) );

		$max_presses = [];
		foreach( $wiring as $bidx => $buttons ) {
			$mp = PHP_INT_MAX;
			foreach( explode( ',', $buttons) as $button ) {
				if ( $joltage[$button] < $mp ) {
					$mp = $joltage[$button];
				}
			}

			$max_presses[$bidx] = $mp;
		};


		// call PuLP ILP helper to solve the integer minimization per row
		$wiring_parsed = array_map(function($s){ return array_map('intval', explode(',', $s)); }, $wiring);
		$payload = [ 'wiring' => $wiring_parsed, 'target' => array_map('intval', $joltage), 'max_presses' => $max_presses ];

		$helperPath = __DIR__ . '/tools/ilp_helper.py';
		
		// Use the specific Python interpreter and run in clean environment
		$cmd = '/Library/Frameworks/Python.framework/Versions/3.10/bin/python3 ' . escapeshellarg($helperPath);
		$descriptorSpec = [ 0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w'] ];

		// run helper in a clean working dir and clear PYTHONPATH to avoid local source imports
		$env = ['PYTHONPATH' => ''];
		$proc = @proc_open($cmd, $descriptorSpec, $pipes, '/tmp', $env);

		if (!is_resource($proc)) {
			echo PHP_EOL . "Could not start SciPy helper (proc_open failed)." . PHP_EOL;
			return;
		}
		fwrite($pipes[0], json_encode($payload));
		fclose($pipes[0]);

		$out = stream_get_contents($pipes[1]); fclose($pipes[1]);
		$err = stream_get_contents($pipes[2]); fclose($pipes[2]);
		$rc = proc_close($proc);
		$result = json_decode($out, true);

		if ($result && isset($result['presses']) && $result['presses'] !== null) {
			$this_presses = array_sum($result['presses']);
		}

		$total_presses += $this_presses;
		
	}

	echo $total_presses;
}

/**
 * generate_combinations removed — not used.
 */

echo PHP_EOL . 'Day 10: TITLE' . PHP_EOL . 'Part 1: ';
// part_one($dataset);
echo PHP_EOL . 'Part 2: ';
part_two($dataset);
echo PHP_EOL;
echo 'Total time to generate: ' . ( microtime( true ) - $starttime );
echo PHP_EOL;
