<?php
/**
 * SEO "Yoast alike"
 * 
 * This plugin was made to work like a
 * - very - simpler version of WP Yoast.
 * 
 * @version  0.5.2
 * @package  SEO Plugin
 * @author   Dimas Pante <dimas@pante.com.br>
 */

 /** 
 * Accepted languages:
 *  - Brazilian Portuguese <pt-br> (default)
 *  - English <en>
 *  - Spanish <es>
 *  - Italian <it>
 */
$lang = "pt-br";

include_once 'src/_init.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
	<meta charset="UTF-8">
	<title><?php echo $i18n['title']; ?></title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div id="editor_area">
		<textarea class="ckeditor" id="the_editor" name="content"></textarea>
		<div class="snippet_preview" id="snippet-the_editor">
			<div class="snippet_title"><?php echo $i18n['title']; ?></div>
			<div class="snippet_preview-tips"></div>
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
<script src="assets/js/init.js"></script>
</html>