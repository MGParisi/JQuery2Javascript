<?php
//remove to get the path replacement working.
die();
require_once 'textNrep.php';
/**
 * Uses: https://github.com/jackocnr/intl-tel-input/wiki/Converting-jQuery-to-JavaScript
 *
 * Does not fix all files.
 *
 * For replacing of javascript on files.
 */
/**
 * Todo: Toggle $( with JQuery(
 * Todo: check for the $element attribute for thoose that apply.  $('...'). or $("...") will be the pattern.
 */
$textNrep = new textNrep();

$replacements = new replacements();
foreach($replacements->values as $replacement) {
	textReplaceAll($replacement);
}

/**
 * Replace all text.
 *
 * @param \replacement $replacement
 * @param string       $ext
 */
function textReplaceAll(\replacement $replacement, $ext = '*') {
	$pathExclude = array();
	$pathArray = array();
	$pathArray[] = __DIR__ . "/../app/views/";
	//$pathArray[] = __DIR__ . "/../app/webpacker/src/javascript/staff/";
	//$pathArray[] = __DIR__ . "/../app/webpacker/src/javascript/video_helpers/";
	//$pathArray[] = __DIR__ . "/../app/webpacker/src/javascript/webchat/";
	$pathExclude[] = __DIR__ . "/../app/views/admins/";

	foreach($pathArray as $key => $path) {
		textReplaceAllInPath($replacement, $path, $pathExclude, $ext);
	}
}


/**
 * Text Replace all files in all paths.
 *
 * @param \replacement $replacement
 * @param array        $exclusions
 * @param string       $ext
 */
function textReplaceAllInPath(\replacement $replacement, string $path, array $exclusions, $ext = '*') {

	//echo $path.PHP_EOL;
	$path = realpath($path); // Path to your textfiles

	//echo $path.PHP_EOL;
	$fileList = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST
	);

	//print_r($fileList);
	//die();
	$count = 0;
	$total = iterator_count($fileList);
	/** @var  ?\SplFileInfo $item */
	foreach($fileList as $item) {
		if ($item->getFileName() !== '..' && $item->getFileName()!=='.') {
			//print_r($item);
			$count++;

			$textNrep = new textNrep();
			$totalChanged = $textNrep->textReplaceFile($replacement, $exclusions, $ext, $item);
			if($totalChanged) {
				echo "(Files: $count/$total - $totalChanged) Replacing All ***" . $replacement->searchFor() .
					 "*** with ***" . $replacement->replaceWith() . "*** in file:" . $item->getPathName() . PHP_EOL;
			}
		}
	}

}