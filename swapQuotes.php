<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2/6/2020
 * Time: 4:11 AM
 */

/**
 * Class swapQuotes
 *
 * Swaps the Quotes in the String.
 *
 * If there are quotes, the swap variable will be filled with the exact reverse of the string.  Leading to single quotes
 * to become double, and vise versa.
 *
 */
class swapQuotes {
	const DEBUG=true;
	/**
	 * @var string $string the original string.
	 */
	public $string;

	/**
	 * @var null|string $swap remains null if no quotes.
	 */
	public $swap = null;

	public function __construct($string) {
		$this->swapStrQuotes($string);
	}

	/**
	 * Change the Quote from double to single, or vice versa.  Will Alternate Quotes if more then one.
	 *
	 * We "reverse" or "swap" the quotes to handle two different situations.  This is used on the replace and search
	 * strings to reverse the options in case of alternative quotes used in code.
	 *
	 * @param $string
	 * @return string
	 */
	private function swapStrQuotes($string) {
		$this->string = $string;
		$this->swap = null;

		$found = FALSE;
		$searchArray = str_split($string);
		foreach($searchArray as &$value) {
			$found = self::swapChrQuote($value);
		}
		$final = implode($searchArray);
		if($found && self::DEBUG) {
			$this->swap = $final;
			echo "Original: $string Result: $final\n";
		}
	}

	/**
	 * Turn a single character, quote to its opposite.
	 *
	 * @param $value
	 * @return bool
	 */
	private static function swapChrQuote(&$value) {
		if($value == '\'') {
			$value = '"';
			return TRUE;
		} elseif($value == '"') {
			$value = "'";
			return TRUE;
		}
		return FALSE;
	}

}