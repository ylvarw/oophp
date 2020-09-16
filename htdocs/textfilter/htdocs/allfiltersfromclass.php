<?php
namespace Ylvan\Text;

// use MyTextFilter;
// use Michelf\MarkdownExtra;

// Include essentials
require __DIR__ . "/../src/TextFilter/MyTextFilter.php";
require __DIR__ . "/../src/config.php";
require __DIR__ . "/../../../vendor/autoload.php";

$mdtext = file_get_contents(__DIR__ . "/../text/sample.md");
$bbtext = file_get_contents(__DIR__ . "/../text/bbcode.txt");
$cltext = file_get_contents(__DIR__ . "/../text/clickable.txt");
$alltext = $cltext . $mdtext . $bbtext;
$filters = ["markdowm", "bbcode", "link", "nl2br"];
$mdfilter = ["markdown"];
$bbfilter = ["bbcode"];
$linkfilter = ["link"];
$nl2brfilter = ["nl2br"];

$textfilter = new MyTextFilter();
$t4 = $textfilter->parse($alltext, $filters);


?>
<!doctype html>
<html>
<meta charset="utf-8">
<style>body {width: 700px;}</style>
<title>Show off all filters, all at the same time</title>

<h1>Showing off ALL textfiltes from filter class</h1>


<h2>All text before formating</h2>
<pre><?= $cltext, $mdtext, $bbtext ?></pre>


<h1>Text fully formatted with all filters:</h1>
<!-- <h2>Order of Filters: makeClickable, markdown, nl2br, bbcode2html.</h2> -->
<h2>Order of Filters: markdowm, bbcode, link, nl2br.</h2>

<?= $t4 ?>



<h1>All Filters: Markdown, nl2br, Bbcode and Clickable applied</h1>


