#!/usr/bin/perl
# Paul Burgwardt
# COMM442
#
# Homework 1
# File: hwking.pl
# Purpose: Searches input file for lines that contain the word "king" twice.
#          Search shall be case-INSENSITIVE.
#          Search shall use "\b" to get only "king"
#          Search shall print matching lines, number of matching lines.

# Attempt to open input file
open (IN, "$ARGV[0]") || die "Can't open $ARGV[0]: $!";

# Read in everything
@lines = <IN>;

# Initialize count for matches
$count = 0;

# Read each line
foreach (@lines){

  # Check if line matches search requirement
  if (/\bking\b.*\bking\b/){
  
    # Print the matching line
    print $_;
	
	# Increment count
    $count++;
  }
}

# Print total number of matches
print "Matched $count lines.\n"

