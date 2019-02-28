# SEO "Yoast alike"

## ABOUT
 This plugin was made to work like
 a *very* simpler version of WP Yoast.

 It is used along with ckeditor, and it uses
 an ajax request to update the content and
 check if it has, at least:
 
 - a min length of 300 chars;
 - a heading tag (h1..h6);
 - a word in bold style (better for keywords);
 - an internal image;
 - an external link (targeted to blank or not);

 It requires two external libraries to work (through CDN or self-hosted):

 - ckeditor (4)
 - jquery (2)

To change the language, head to src/seo.php file and modify the include file. The plugin currently accepts pt_br (default), en, es and it.
 
### TODO
1. OOP;
2. Improve speed