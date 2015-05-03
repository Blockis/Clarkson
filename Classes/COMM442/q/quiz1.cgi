#!/usr/bin/perl
#quiz1.cgi


require("mylib.pl");

open IN, "quiz1.fdd" or &webdie("Can't open quiz1.fdd: $!");

&read_form_results;


&begin_html;

print "$entry{name}, your test is corrected:<br><br>";

#print "$entry{name} <br>";
#print "$entry{white} <br>";
#print "$entry{drink} <br>";
#print "$entry{best} <br>";

if ($entry{green}=~ /gold/i) {
     print "1. Correct. Green and Gold.<br>";
     $right++;
     }
     else{
     print "1. Incorrect. Try another color.<br>";
     }


if ($entry{drink}=~ /rum/i) {
     print "2. Correct. Simple enough<br>";
     $right++;
     }
     else{
     print "2. Incorrect. Try someting alcoholic.<br>";
     }


if ($entry{country}=~ /australia/i) {
     print "3. Correct. They're from down under<br>";
     $right++;
     }
     else{
     print "3. Incorrect. Try a country south of the equator<br>";
     }

$score = $right/3;
$score = sprintf "%2.2f", $score;
$score= $score * 100;

open OUT, ">>quiz1.fdb";
print OUT "$entry{name}: $score\n";
close OUT;

print "<br><br> Your score is $score"
