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
$filename =$1;
$ext = $2;
$filename =~ s/\W//g;        #security!
$ext = lc($ext);

$ext =~ s/php/txt/i;          #SECURITY!
$filename = $filename . "." . $ext;

my $upload_filehandle = $query->upload("upload_file"); #Named "upload_file" in the input tag

$path = "$upload_dir/$filename";

&print_screen;
##############################  End Main ############################

sub print_screen{
my @pics = glob ("$upload_dir*.jpg $upload_dir/*.gif $upload_dir/*.png");
my $select_box = &make_select(@pics);    #from mylib.pl


print <<EOT;

<style>
.left {width:400px;}
.show {position:absolute; top:130px; left:260px;}

#up {position:absolute;
  left:20px; 
  top:40px}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" ></script>

<script>
\$(document).ready(function(){
  \$('#selBox').change( function(){   
        //alert (this.value);
        \$('#caption').text(this.value)
       \$('#showpic').attr('src',this.value);  
  });

});     //ready

</script>
</header>
<body>
 <div class="left">
 View Templates:<br>
 $select_box <br> <br>
 </div>
 <div class="show">
 <p id="caption">$success</p>
 <img src= "$path" id="showpic" style="width: 300px;">
 </div>

</form>
</body>
</html>
EOT
exit;
}

