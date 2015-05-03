#!/usr/bin/perl
# Paul Burgwardt
# COMM442
#
# Homework 1
# File: hwcountwords.cgi
# Purpose: Counts all words from input and returns top 20 words.

open (IN, "$ARGV[0]") || &webdie("Invalid Usage!  Example: hwcountwords.cgi?/marlowe/act1");

chomp(@omit= <DATA>);

# Read in everything from input
@lines = <IN>;

# Initialize list counter
$list_counter = 0;

# Read each line
foreach (@lines){

  # Split the line into an array of words
  @line = split(); 
   
  # Read each word on line
  foreach (@line){
  
    # Skip if King> etc
    if (/\w>/) {next;} 
    
	# Change the word to lowercase for easier matching/counting
	$_=lc($_);
	
	# Store word
    $word = $_;
	
    foreach (@omit){
      if ($_ eq $word) {next;}
    }
	
	# Increment/store the count for the word in the assoc array
    $words{$_}++;
   }
}

# Begin HTML
print <<EOT;
Content-type: text/html

<!doctype html>
<html lang-en>
<head>
\t<title>Top 20 Words</title>
<body>

EOT

# Iterate through the words array
foreach (keys(%words)){
  
  # Push the word and word count onto word count array
  push (@wc, "$words{$_} $_");
}

@sorted = sort{$b <=> $a or $a cmp $b} @wc;

# Iterate through the sorted array
foreach (@sorted){

  # Print the word count and its word
  print "\t$_<br />\n";
  
  # Increment list counter
  $list_counter++;
  
  # Once we list 20 elements, stop
  if ($list_counter > 20) {last};
}

# Close the HTML
print "</body>\n</html>";
