#!/usr/bin/perl

# Paul Burgwardt
# COMM442 - Professor Horn
# Final
# Question 5

# Create Days Array
@days = qw(Sunday Monday Tuesday Wednesday Thursday Friday Saturday);

# Get Information From localtime()
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime();
dbmopen (%PICTURES, 'dow', 0664) || die("Can't open dow: $!\n");

# Get Name And Source
$picture = $PICTURES{$wday};
$picture =~ m/(.*)\^(.*)\^(.*)$/;
$name = $2;
$source = $3;

# HTML Header
print "Content-type: text/html\n\n";

# Print JSON
print "{ \"dow\":\"$days[$wday]\", \"name\":\"$name\", \"path\":\"$source\" }\n";
