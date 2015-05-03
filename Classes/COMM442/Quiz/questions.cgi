#!/usr/bin/perl
# questions.cgi

require ("mylib.pl");
&read_form_results;


$color = $entry{color};
$tomb = $entry{tomb};
$many = $entry{many};

if ($color =~ /white/i) {
   $print .= "1. You said $color.  That is correct. <br /><br />\n";
   $count++;
}
else {$print .= "1. Sorry, $color is not the right answer. <br /><br />\n";}


if ($tomb =~ /Grant/i) {
   $print .= "2. Correct. $tomb is burried there. <br /><br />\n";
   $count++;
}
else {$print .= "2. Sorry, $tomb is not burried there. <br /><br />\n";}


if ($many >= 16) {
    $print .= "3. You said that it takes $many perl programmers to
    find an HTML mistake.  That is more or less correct.  Sometimes
    it takes more.  <br /><br />\n";
    $count++;
}
else {$print .= "3. Wrong. It will take more than $many programmers to
      find an error in HTML.  Hint. At least 7 of them won't know
      HTML. Another 7 will be looking in the Perl code. 
      <br /><br />\n";}


$average = $count/3;
$percent = 100 * $average;

$score = sprintf ( "Your score = %.2f%<br />\n", $percent);

$print .= $score;

###########  End of the Perl work.  Now we print the HTML  ####



print <<EOT;
Content-type: text/html\n\n
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head><title>Comm442: $date </title> 
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel=stylesheet type="text/css" href="comm442.css">

<style type="text/css">

</style>

<script type="text/javascript">

</script>

</head>

<body>

<h2> questions.cgi: the answers </h2> 

$print


</body></html>

EOT
