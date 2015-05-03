#!/usr/bin/perl

# Paul Burgwardt
# COMM442 - Professor Horn
# Final
# Question 4

# Glob -400 Pictures In /pics
@pictures = glob "pics/*-400.gif pics/*-400.jpg pics/*-400.png";

# Counter For Hash DB
$index = 0;

# Open DBM Hash
dbmopen (%PICTURES, 'dow', 0664) || die("Can't open dow: $!\n"); 
	
# Filter And Resize
foreach( @pictures )
{
	# Strip -400 And Get File Information
	$_ =~ m/(.*)\/(.*)-400(\....)$/;
	$name = $2;
	# Restore Spaces
	$name =~ s/_/ /;
	# Get Extension
	$extension = $3;
	$extension = lc($extension);
	# Fill Database
	$PICTURES{$index} = $index . "^" . $name . "^" . $_;
	# Increment index Counter
	$index++;
}

# Close DB
dbmclose(%PICTURES);