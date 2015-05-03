#!/usr/local/bin/perl

use Image::Magick;

use CGI qw(:standard);

&begin_html("echo.cgi results");

my $file = "templates/aliens.jpg";
my $im = Image::Magick->new();
my $rc = $im->Read($file);
 die $rc if $rc;
                       
$rc = $im->Annotate(
     gravity => "North",
     text => "THIS IS A TEST",
     font => "arial.ttf",
     #stroke => "black",
     fill=> "white",
     pointsize => 40,
);
  die $rc if $rc;

#$file =~ /(.*)\.(\w*$)/;
#$new = $1 . "1" . $2;
  
$rc = $im->Write("templates/aliens2.jpg");
   die $rc if $rc;

print("\n</body> </html>\n");


############  End Main #############


# begin_html(): Print the HTML header  
# arguments 1. title
# No return.  Prints to the screen.
sub begin_html{
my($title);
$title = $_[0];      
print <<EOT;
Content-type: text/html\n\n

<!doctype html>
<html lang-en>
<head>
<title>ECHO</title>
<style>
</style>

</head>
<body>
<h3> Echo Results </h3>

EOT
}