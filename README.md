# Advent of Code

My solutions to the [Advent of Code](https://adventofcode.com) puzzles.

If you'd like to see the solutions, you can run the following in terminal, replacing YYYY with the four digit year, and DD with the two digit day of the date you wish to view:

`php -r "require 'YYYY/DD.php';"`

## Bash Commands (using Mac)
If you are using this as a base for starting your own Advent of Code, or even if you just want to get your day started more quickly, add this to your .bash_profile to jumpstart your day. This will assume you are using the structure of /Users/{name}/Advent of Code/YYYY/DD.php. Look for # REPLACE

### If you only want to create your files for the day, use the following:
```
function aoc() {
	# Expected Operations:
	# "aoc" - opens Advent of Code folder, creates a file for today in this year, plus blank data files (and folders that need to exist)
	# "aoc 5" - opens Advent of Code folder, creates a file for day 05 in this year, plus blank data files (and folders that need to exist)
	# "aoc 12 2023" - opens Advent of Code folder, creates a file for day 12 in the year 2023 plus blank data files (and folders that need to exist)
	# "aoc o" - opens Advent of Code folder withing the IDE/Editor ONLY

	# REPLACE with your name, and uncomment or add your IDE/Editor of choice
	cd /Users/fischfood/Advent\ of\ Code;
    # open -a "Phpstorm.app" .;
    # open -a "Sublime Text.app" .;
	# open -a "Visual Studio Code.app" .;
    # END REPLACE #

	DAY=$1
	YEAR=$2

	# If first input is "o", just open
	# otherwise, create stuff
	if [ "$1" != "o" ]
	then

		# If a year isn't set, set it to this year
		# Check if the selected years folder exists, and create if missing.
		# Go into that folder
		if [ ! $YEAR ] 
		then
			YEAR="$(date +'%Y')";
		fi

		if [ ! -d $YEAR ]
		then
			mkdir $YEAR;
		fi
		cd $YEAR;


		# If this is the first time making the year folder, make the data folder too
		if [ ! -d "data" ]
		then
			mkdir "data";
		fi

		# If a day isn't set, set it to today
		if [ ! $DAY ]
		then
			DAY="$(date +'%d')";
		fi

		# Make it two digits for Finder sorting
		DAY=$(printf "%02d" $DAY)

		# Clone the starting point php file and replace the date. Make the data text files
		cp ../starting-point.php ./$DAY.php;
		sed -i '' "s/DAY/$DAY/g" ./$DAY.php;
		touch "data/data-$DAY.txt";
		touch "data/data-$DAY-sample.txt";
	fi
}
```