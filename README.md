## SEO Plugin - "Yoast alike"

### VERSION:

0.5.2

### ABOUT:
 This plugin was made to work like
 a *very* simpler version of WP Yoast.

 It is used along with ckeditor, and it listens
 to an ajax request to update the content and
 then check if it has, at least:
 
 - a min length of 300 chars;
 - a heading tag (h1..h6);
 - a word in bold style (better for keywords);
 - an internal image;
 - an external link (targeted to blank or not);

 It requires two external libraries to work (through CDN or self-hosted):

 - ckeditor (currently using version 4.11.3)
 - jQuery (currently using version 3.3.1)

To change the language, head to src/seo.php file and modify the include file.
The plugin currently accepts Brazilian Portuguese, US English, Spanish and Italian.
 
### TODO:
1. Object-oriented inner functions;
2. Overrall improvements.