#!/usr/bin/perl
require ("mylib.pl");

use CGI;
my $query = new CGI;

# Get Parameter Variables
my $class = $query->param("class");
my $background_color = $query->param("background_color");
my $background_image = $query->param("background_image");
my $opacity = $query->param("opacity");
my $font_color = $query->param("font_color");
my $font_weight = $query->param("font_weight");
my $font_size = $query->param("font_size");

$code = "";

# Determine Instantiation
if($class eq "")
{
	$code .= "<xmp><div style=\"";
	if($background_color ne "")
	{
		$code .= "background-color: #" . $background_color . ";";
	}
	if($background_image ne "")
	{
		$code .= "background-image: url(\"" . $background_image . "\");";
	}
	if($opacity ne "")
	{
		$code .= "opacity: " . $opacity . ";";
	}
	if($font_color ne "")
	{
		$code .= "font-color: " . $font_color . ";";
	}
	if($font_weight ne "")
	{
		$code .= "font-weight: " . $font_weight . ";";
	}
	if($font_size ne "")
	{
		$code .= "font-size: " . $font_size . ";";
	}
	
	$code .=">This is some sample text.</div></xmp>"
}
else
{
	# Set Up Class Definition
	$code .= "." . $class . "{";
	if($background_color ne "")
	{
		$code .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;background-color: #" . $background_color . ";";
	}
	if($background_image ne "")
	{
		$code .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;background-image: url(\"" . $background_image . "\");";
	}
	if($opacity ne "")
	{
		$code .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;opacity: " . $opacity . ";";
	}
	if($font_color ne "")
	{
		$code .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;font-color: " . $font_color . ";";
	}
	if($font_weight ne "")
	{
		$code .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;font-weight: " . $font_weight . ";";
	}
	if($font_size ne "")
	{
		$code .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;font-size: " . $font_size . ";";
	}
	$code .= "<br />}";
}

&begin_html("Created");

print <<EOT;

<link rel="stylesheet" href="style.css">
</header>
<body>
<div style="padding: 20px;">
		<h1>div Generator</h1>
		
		<h3>Here's the code:</h3>
		<div style="background-color: lightgray; font-style: italic; padding: 20px; display: inline-block;">
			<!--.$class<br />
			{<br />
			&nbsp;&nbsp;&nbsp;&nbsp;background-color: #$background_color;<br />
			&nbsp;&nbsp;&nbsp;&nbsp;background-image: url("$background_image");<br />
			&nbsp;&nbsp;&nbsp;&nbsp;opacity: $opacity;<br />
			&nbsp;&nbsp;&nbsp;&nbsp;color: $font_color;<br />
			&nbsp;&nbsp;&nbsp;&nbsp;font-weight: $font_weight;<br />
			&nbsp;&nbsp;&nbsp;&nbsp;font-size: $font_size;<br />
			}-->
			$code
		</div>
</div>
<br />
<div style="padding: 20px; width: auto;">
	<h3>Here's what it looks like right now:</h3>
	<div style='background-color: #$background_color; background-image: url("$background_image"); opacity: $opacity; color: $font_color; font-weight: $font_weight; font-size: $font_size; display: inline-block'>
		This is sample text.
	</div>
	<br />
	<br />
	Doesn't look right?  Click <a href="index.html">here</a> to go back and try again.
</div>
</body>
</html>
EOT
exit;

