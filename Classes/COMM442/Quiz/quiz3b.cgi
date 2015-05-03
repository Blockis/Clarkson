#!/usr/bin/perl
#q3

#!/usr/bin/perl

require("mylib.pl");
&read_form_results;
$pass= $entry{"password"};

if (!$pass) {&print_screen;}


$clarkson = "TCXRdyiDki6mc";
$yahoo = "zwAdxlPUH3CCA";

$clark_crypt= crypt($pass,"$clarkson");
$yah_crypt =  crypt($pass,"$yahoo");

if ($clarkson eq $clark_crypt) {print "Location: http://www.clarkson.edu\n\n";}
if ($yahoo eq $yah_crypt){print "Location: http://www.yahoo.com\n\n";}
print "Location: http://heron.snell.clarkson.edu\n\n";


sub print_screen(){

print <<EOT;
content-type: text/html

<html> <head> <title>quiz3</title> </head>
<body bgcolor = "00aaaa" text="ffffff">
<center> </h2>Hypergate</h2> </center>

<form method=POST action="quiz3b.cgi">
<font color="#aa00cc"></font><p>
Enter a test code: <input name="password" type=password>  <input type=submit>
</form></body></html>

EOT
exit;
}
