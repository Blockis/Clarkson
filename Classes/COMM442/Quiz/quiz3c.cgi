#!/usr/bin/perl
#quiz3


require("mylib.pl");
&read_form_results;
$pass= $entry{"password"};

if (!$pass) {&print_screen;}
else {&check_pass()}

########### end main ################


sub check_pass(){

$clarkson = "TCXRdyiDki6mc";
$yahoo = "zwAdxlPUH3CCA";
$clarksonloc= "Location: http://www.clarkson.edu\n\n";
$yahooloc= "Location: http://www.yahoo.com\n\n";
$otherloc= "Location: http://heron.snell.clarkson.edu\n\n";

$clark_crypt= crypt($pass,"TC");
$yah_crypt =  crypt($pass,"zw");

if ($clarkson eq $clark_crypt) {print $clarksonloc;}
if ($yahoo eq $yah_crypt){print $yahooloc}
print $otherloc;

} # end &checkpass

sub print_screen(){

print <<EOT;
content-type: text/html

<html> <head> <title>quiz3</title> </head>
<body bgcolor = "00aaaa" text="ffffff">
<center> </h2>Hypergate</h2> </center>

<form method=POST action="quiz3c.cgi">
<font color="#aa00cc"></font><p>
Enter a test code: <input name="password" type=password>  <input type=submit>
</form></body></html>

EOT
exit;
}    #end print_screen
