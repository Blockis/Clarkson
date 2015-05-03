#!/usr/bin/perl

# Paul Burgwardt
# COMM442 - Professor Horn
# Final
# Question 3

# Glob All Images In /pics
@pictures = glob "pics/*";

# Filter And Resize
foreach( @pictures )
{
	# Skip Images With *-400*
	if ( $_ =~ m/-400\./ ) { next; }
	# Save Filename Information
	$_ =~ m/(.*)(\....)$/;
	$name = $1;
	$extension = $2;
	$extension = lc($extension);
	# Only Allow Images
	if( $extension !~ /\.jpg$|\.gif$|\.png$/ ) { next; }
	# Change Spaces To Underscores
	$name =~ s/\s+/_/;
	$newname = "$name-400" . $extension;
	# Resize It
	`convert -resize 400 "$_" $newname`;
}