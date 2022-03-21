<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2/6/2020
 * Time: 1:20 AM
 */

require_once 'replacements.php';

class textNrep {
	const DEBUG = FALSE;
	/** @var null|\RecursiveIteratorIterator $item */
	public $item = NULL;


	/**
	 * Loads and replaces all text in file.
	 *
	 * @param \replacement      $replacement
	 * @param array             $exclusions
	 * @param string            $ext
	 * @param \SplFileInfo|null $item
	 * @return mixed
	 */
	function textReplaceFile(replacement $replacement, array $exclusions, string $ext = '*', ?SplFileInfo $item = NULL) {
		if(isset($item)) {
			$this->item = $item;
		}
		$pathName = $this->item->getPathName();

		$excluded = self::excluded($exclusions, $pathName);

		//echo "excluded: $excluded";
		if(!$excluded && $this->item->isFile() && (stripos($pathName, $ext) !== FALSE || $ext == '*')) {

			$file_contents = file_get_contents($pathName);
			$return = $this->textReplaceString($replacement, $file_contents);

		} else {
			$return = FALSE;
		}
		if($return) {
			file_put_contents($pathName, $file_contents);
		}
		return $return;
	}

	/**
	 * Go through all of the replacements to perform, and perform the text custom Replacement.
	 * @param $string
	 * @return int
	 */
	public function textReplace(&$string) {
		$replacements = new replacements();
		$totalCount = 0;
		foreach($replacements->values as $replacement) {
			$totalCount += $this->textReplaceString($replacement, $string);
		}
		return $totalCount;
	}

	/**
	 * @param $quoteToChange
	 * @return string
	 */
	private function getOpQuote($quoteToChange) {
		if($quoteToChange == '"') {
			$replace = "'";
		} else {
			$replace = '"';
		}
		return $replace;
	}


	/**
	 * @param array  $exclusions
	 * @param string $path
	 * @return bool
	 */
	private static function excluded(array $exclusions, string $path) {
		$path = realpath($path);
		foreach($exclusions as $exclusion) {
			$exclusion = realpath($exclusion);
			if(strpos($path, $exclusion) > 0) {
				$excluded = TRUE;
				//echo "Excluded:$exclusion\n";
				return TRUE;
			}
		}
		return FALSE;

	}


	/**
	 * Replace both the Regular String and the Reverse String.
	 *
	 * @param \replacement $replacement ->searchFor
	 * @param              $jQueryString
	 * @return int
	 */
	public function textReplaceString(replacement $replacement, &$jQueryString) {
		$firstCount = 0;
		$jQueryString = $replacement->strReplace($jQueryString, $firstCount);

		$secondCount = 0;
		//replace the regular string.
		if(strpos($replacement->searchFor(), "'") !== FALSE || strpos($replacement->searchFor(), '"') !== FALSE) {
			$jQueryString = $replacement->strReplace($jQueryString, $secondCount, TRUE);
		}

		return $firstCount + $secondCount;
	}
}