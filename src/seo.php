<?php
/**
 * SEO "Yoast alike"
 * 
 * This plugin was made to work like a
 * - very - simpler version of WP Yoast.
 * 
 * @version  0.5.1
 * @author  Dimas Pante <dimas@pante.com.br>
 */
header('Cache-Control: private, max-age=1');
header('Cache-Control: no-cache');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Allow');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/x-www-form-urlencoded; charset="utf-8"', true);
header('Expires: ' . gmdate('r', time() + 1));

include_once '_init.php';
include_once '_functions.php';

$raw_text      = $_POST['text']; //defined at init.js
$clear_text    = clearText($raw_text);
$length_total  = wordCount($clear_text);

/* count the length of links and explode it */
$exp_links     = preg_match_all('~<a([^/][^>]*?)>~', $raw_text, $link_total, PREG_PATTERN_ORDER);
$link_total    = array_pop($link_total);

/* count the length of bold words and explode it */
$exp_bolds     = preg_match_all('~<strong([^/][^>]*?)>~', $raw_text, $bold_total, PREG_PATTERN_ORDER);
$bold_total    = count(array_pop($bold_total));

/* count the length of headings and explode it */
$exp_headings  = preg_match_all('~<h([0-6][^/][^>]*?)>~', $raw_text, $heading_total, PREG_PATTERN_ORDER);
$heading_total = count(array_pop($heading_total));

/* count the length of images and explode it */
$exp_images    = preg_match_all('~<img([^/][^>]*?)>~', $raw_text, $images_total, PREG_PATTERN_ORDER);
$images_total  = count(array_pop($images_total));

/* check how many links are external/internal */
$internal_link = 0;
$external_link = 0;

for ($i = 0; $i < $exp_links; $i++) {
    $explode = explode(' ', $link_total[$i]);

    for ($x = 0; $x < count($explode); $x++) {
        $href = substr($explode[$x], 0, 5);

        if ($href == 'href=') {
            $link_explode = substr($explode[$x], 6, -1);

            if (strpos($link_explode, $_SERVER['HTTP_HOST'])) {
                $internal_link++;
            } elseif (!strpos($link_explode, $_SERVER['HTTP_HOST'])) {
                $external_link++;
            }
        }

        $link_explode = '';
    }

    $explode = '';
}

/* generate notices to send through json */
$notices = array();

if ($raw_text) {
	if ($length_total > 300) {
		$notices[] = '<p><span class="snippet_preview-message--success"></span>'.sprintf($i18n['length_total_ok'],$length_total).'</p>';
	} elseif($length_total <= 300) {
		$notices[] = '<p><span class="snippet_preview-message--warning"></span>'.sprintf($i18n['length_total_warning'],$length_total).'</p>';
	} elseif(!$length_total) {
		$notices[] = '<p><span class="snippet_preview-message--danger"></span>'.$i18n['length_total_danger'].'</p>';
	}
} else {
    $notices[] = '<p><span class="snippet_preview-message--danger"></span>'.$i18n['length_total_null'].'</p>';
}

if ($images_total) {
    $notices[] = '<p><span class="snippet_preview-message--success"></span>'.sprintf($i18n['images_total_ok'],$images_total).'</p>';
} else {
    $notices[] = '<p><span class="snippet_preview-message--warning"></span>'.$i18n['images_total_warning'].'</p>';
}

if ($heading_total) {
    $notices[] = '<p><span class="snippet_preview-message--success"></span>'.sprintf($i18n['heading_total_ok'],$heading_total).'</p>';
} else {
    $notices[] = '<p><span class="snippet_preview-message--warning"></span>'.$i18n['heading_total_warning'].'</p>';
}

if ($bold_total) {
	$notices[] = '<p><span class="snippet_preview-message--success"></span>'.sprintf($i18n['bold_total_ok'],$bold_total).'</p>';
} else {
    $notices[] = '<p><span class="snippet_preview-message--warning"></span>'.$i18n['bold_total_warning'].'</p>';
}

if ($exp_links) {
    $notices[] = '<p><span class="snippet_preview-message--success"></span>'.sprintf($i18n['links_total'],$exp_links).'</p>';
    if ($internal_link) {
        $notices[] = '<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; ' . $internal_link . ' '.$i18n['links_total_int'].';</p>';
    }
    if ($external_link) {
        $notices[] = '<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; ' . $external_link . ' '.$i18n['links_total_ext'].';</p>';
    }
} else {
    $notices[] = '<p><span class="snippet_preview-message--warning"></span>'.$i18n['links_total_null'].'</p>';
}

$data['message'] = implode('',$notices);

echo json_encode($data);
