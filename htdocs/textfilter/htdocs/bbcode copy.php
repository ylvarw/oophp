<?php
namespace Mos\TextFilter;

// Include essentials
require __DIR__ . "/../src/config.php";

$filter = new MyTextFilter();


$text = file_get_contents(__DIR__ . "/../text/bbcode.txt");
$html = $filter->parse($text, ["bbcode"]);
// $html = bbcode2html($text);


?>
<!doctype html>
<html>
<meta charset="utf-8">
<style>body {width: 700px;}</style>
<title>Show off BBCode</title>

<h1>Showing off BBCode</h1>

<h2>Source in bbcode.txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Filter BBCode applied, source</h2>
<pre><?= wordwrap(htmlentities($html)) ?></pre>

<h2>Filter BBCode applied, HTML (including nl2br())</h2>
<?= nl2br($html) ?>
