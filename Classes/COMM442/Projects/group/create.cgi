#!/usr/bin/perl
require ("mylib.pl");

use CGI;
use CGI::Carp qw ( fatalsToBrowser );
$CGI::POST_MAX = 1024 * 4000;    # 4MB

my $upload_dir = "templates/";
my $query = new CGI;
my $filename = $query->param("upload_file");  # In tag: name="upload_file";

my $success="",$ext;
my $select="";


if (!$filename){
$msg="Select a file for upload.";
&make_select;
&print_screen;
exit;
}

$filename =~ /(.*)\.(\w*$)/;
$filename = $1;
$fullfilename = $filename;
$ext = $2;
$filename =~ s/\W//g;        #security!
$ext = lc($ext);

$ext =~ s/php/txt/i;          #SECURITY!
$filename = $filename . "." . $ext;

$path = "$upload_dir/$filename";

&print_screen;
##############################  End Main ############################

sub print_screen{
my @pics = glob ("$upload_dir*.jpg $upload_dir/*.gif $upload_dir/*.png");
my $select_box = &make_select(@pics);    #from mylib.pl

print <<EOT;

<style>
.left
{
	width:300px;
	float: left;
	padding: 20px;
}
.captions{
	width: 300px;
	float: left;
}

.container {
        width: 300px;
        clear: both;
		float: left;
    }
    .container input {
        width: 100%;
        clear: both;
    }

</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" ></script>

<script>
\$(document).ready(function(){
  \$('#selBox').change( function(){   
        \$('#showpic').attr('src',this.value);
		\$('#img').val(this.value);
  });
});

</script>
</header>
<body>
	<h1>Meme Generator</h1>
	<h2>Site Navigation</h2>
	<form action="generate.cgi" method="post">
		<input type="hidden" name="template" value="$path">
		<div class="container">
			Templates:<br />
			$select_box
			<br />
			<br />
			<label>Template:</label><input type="text" name="template" id="img" style="float: right;">
			<br />
			<label>First Line:</label><input type="text" name="top" style="float: right;">
			<br />
			<label>Second Line:</label><input type="text" name="bottom" style="float: right;">
			<br />
			<br />
			<input type="submit" value="Submit"> 
		</div>
		<div class="left">
			<div class="show">
				<img src= "$path" id="showpic" style="width: 300px;">
			</div>
		</div>
		
</form>
</body>
</html>
EOT
exit;
}

