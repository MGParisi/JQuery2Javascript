<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2/6/2020
 * Time: 2:47 AM
 */
require_once "swapQuotes.php";

class replacement {
	const DEBUG = FALSE;
	/**
	 * @var null|\swapQuotes $searchFor
	 */
	private $searchFor = NULL;

	/**
	 * @var null|\swapQuotes $replaceWith
	 */
	private $replaceWith = NULL;

	/**
	 * Set Search and the Cache.
	 *
	 * @param string $searchFor
	 */
	public function setSearchFor(string $searchFor) {
		$this->searchFor = new swapQuotes($searchFor);
	}

	/**
	 * Set ReverseWith and the Cache.
	 *
	 * @param string $replaceWith
	 */
	public function setReplaceWith(string $replaceWith) {
		$this->replaceWith = new swapQuotes($replaceWith);
	}

	/**
	 * replacement constructor.
	 *
	 * @param string|NULL $searchFor
	 * @param string|NULL $replaceWith
	 */
	public function __construct(string $searchFor = NULL, string $replaceWith = NULL) {
		if(isset($searchFor)) {
			$this->setSearchFor($searchFor);
		}
		if(isset($replaceWith)) {
			$this->setReplaceWith($replaceWith);
		}
	}


	/**
	 * Text value to search for.
	 *
	 * @return null|string
	 */
	public function searchFor() {
		return $this->searchFor->string;
	}


	/**
	 * Text value to replace with.
	 *
	 * @return null|string
	 */
	public function replaceWith() {
		return $this->replaceWith->string;
	}

	/**
	 * Replace the searchFor with the replaceWith.  Allows for opposits to be generated.
	 *
	 * @param          $file_contents
	 * @param int|null $secondCount
	 * @param bool     $reverse
	 * @return mixed
	 */
	public function strReplace($file_contents, ?int &$secondCount = 0, $reverse = FALSE) {
		if($reverse && $this->searchFor->swap) {
			return str_replace(
				$this->searchFor->swap,
				$this->replaceWith->swap,
				$file_contents,
				$secondCount
			);
		} else {
			return str_replace(
				$this->searchFor->string,
				$this->replaceWith->string,
				$file_contents,
				$secondCount
			);
		}

	}
}