#!/usr/bin/perl

@images = glob "memes/$ARGV[0]*.png";

foreach(@images) {
      m#/(.*)\.#;
      $_="<div>\n<a href=\"viewer.cgi?$1\">\n<img src=\"thumbs\$1.png\"/>\n</a>\n<br>\n<h1>$1</h1></div>\n";
}
print <<EOT;
Content-type: text/html

<!doctype html>
<html>
<head>
<title>Gallery</title>
</head>
<body>
@images</body>
</html>
EOT
