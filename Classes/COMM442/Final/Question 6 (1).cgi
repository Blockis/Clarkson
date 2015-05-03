#!/usr/bin/perl

# Paul Burgwardt
# COMM442 - Professor Horn
# Final
# Question 6

use CGI qw(:standard);
$query = new CGI;

# Get dow Parameter
$day = $query->url_param("dow");

# Create Days Array
@days = qw(Sunday Monday Tuesday Wednesday Thursday Friday Saturday);

dbmopen (%PICTURES, 'dow', 0664) || die("Can't open dow: $!\n");

# Get Name And Source
$picture = $PICTURES{$day};
$picture =~ m/(.*)\^(.*)\^(.*)$/;
$name = $2;
$name =~ s/_+/\s/;
$source = $3;

# HTML Header
print "Content-type: text/html\n\n";

# Print JSON
print "{ \"dow\":\"$days[$day]\", \"name\":\"$name\", \"path\":\"$source\" }\n";
