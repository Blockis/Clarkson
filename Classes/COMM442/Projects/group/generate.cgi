#!/usr/local/bin/perl

use Image::Magick;

use CGI qw(:standard);
$query = new CGI;

&begin_html("echo.cgi results");

foreach ($query->param){
  print "$_:  ";
  @values= $query->param($_);
  print @values;
  print "<br />\n";
}
print "<br>\n";

# Get Timestamp In Seconds To Use As UID
$uuid = `perl -e \'print time\'`;

$top_line = $query->param("top");
$bottom_line = $query->param("bottom");

@template_file = $query->param("template");

$template_file1 = $template_file[1];
$template_file1 =~ /templates\/(.*)\.(\w*$)/;
$nfile = "uploads/" . $1 . $uuid. "." . $2;

my $im = Image::Magick->new();
my $rc = $im->Read($template_file1);
 die $rc if $rc;
                       
$rc = $im->Annotate(
     gravity => "North",
     text => $top_line,
     font => "arial.ttf",
     stroke => "black",
     fill=> "white",
     pointsize => 40,
);
  die $rc if $rc;
  
$rc = $im->Annotate(
	gravity => "South",
	text => $bottom_line,
	font => "arial.ttf",
	stroke => "black",
	fill=> "white",
	pointsize => 40,
);
	die $rc if $rc;
  
$rc = $im->Write("$nfile");
   die $rc if $rc;
   
print("<img src=\"" . $nfile . "\">");

print("\n</body></html>\n");


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
<h3>Results</h3>

EOT
}