#!/usr/bin/perl


require("mylib.pl");

open (IN, "w7.1.fdb") || &webdie("Can't open w7.1.fdb: $!");
while (<IN>){
      @line = split(/\^/, $_);
      if ($line[1]){
        $lines .= "$line[1] $line[0] likes the color $line[3].<br>\n";
      }
}

&begin_html;

print <<EOT;
Colors: 
<p>$lines</p>
</body></html>
EOT



