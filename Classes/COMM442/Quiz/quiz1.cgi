#!/usr/bin/perl
# Paul Burgwardt
# COMM442
#
# Quiz 1
# File: quiz1.cgi

require("mylib.pl");

open IN, "quiz1.fdd" or &webdie("Can't open quiz1.fdd: $!");

&read_form_results;

&begin_html;

print "Your test is corrected:<br><br>";

#print "$entry{name} <br>";
#print "$entry{white} <br>";
#print "$entry{drink} <br>";
#print "$entry{best} <br>";

if ($entry{sky}=~ /blue/i) {
  print "1. Correct. The sky is indeed blue.<br>";
  $right++;
}
else{
  print "1. Incorrect. Try another color.<br>";
}


if ($entry{president}=~ /obama/i) {
  print "2. Correct. Easy!<br>";
  $right++;
}
else{
  print "2. Incorrect. Try again!<br>";
}


if ($entry{oranges}=~ /three/i || $entry{oranges}==3) {
  print "3. Correct. You have the same three oranges!<br>";
  $right++;
}
else{
  print "3. Incorrect. Did we do anything with the oranges?<br>";
}

$score = $right/3;
$score = sprintf "%2.2f", $score;
$score= $score * 100;

open OUT, ">>quiz1.fdb";
print OUT "$entry{name}: $score\n";
close OUT;

print "<br><br> Your score is $score%"
