#!/usr/bin/perl
# Paul Burgwardt
# COMM442
#
# Homework 1
# File: hwnotking.pl
# Purpose: Searches input file for words that only include "king", not "king" or "kings".
#          Search shall be case-INSENSITIVE.
#          Print only the words found.

# Attempt to open input file
open (IN, "$ARGV[0]") || die "Can't open $ARGV[0]: $!";

# Read in everything
@lines = <IN>;

# Read each line
foreach (@lines){

  # Split the line into an array of words
  @words = split();
   
  # Read each word
  foreach (@words){

    # Check if word matches search requirement
    if ((/\Bking/ || /king\B/) and !/kings/ && !/king:/){
	
	  # Print the word
      print "$_\n";
	  
    }
  } 
}
