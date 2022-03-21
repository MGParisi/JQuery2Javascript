<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2/6/2020
 * Time: 2:51 AM
 */
require_once('replacement.php');


class replacements {
	public $values = array();
	/**
	 * Text Search for => text find.
	 *
	 * [searchstring, replacementstring]
	 *
	 * @var array
	 */

	private $default = [
		/**
		 * SELECTORS
		 */
		//$("body") => document.body
		['$("body")', 'document.body'],

		//$("html") => document.documentElement
		['$("html")', 'document.documentElement'],

		//$(selector) => document.querySelector(selector)
		//todo
		['$(','document.querySelector('],

		//$elem.find(selector) => elem.querySelector(selector)
		['.find(', '.querySelector('],

		// $elem.closest('.country') => elem.closest('.country')
		['.closest("form")', '.forms'],

		// siblings: $el.prev() and $el.next() => el.previousElementSibling and el.nextElementSibling
		['.prev()', '.previousElementSibling'],
		['.prev("")', '.previousElementSibling'],
		['.next()', '.nextElementSibling'],
		['.next("")', '.nextElementSibling'],
		/**
		 * Input Values: getting and setting
		 */
		//$input.val() => input.value
		['.val()', '.value'],
		['.val("")', '.value'],
		//todo
		//$input.val("hello") => input.value = "hello"

		/**
		 * Event Listeners
		 */
		//todo
		//$elem.on(eventName, handler) => elem.addEventListener(eventName, handler)
		//Note: 3rd arg of false (for useCapture) not needed as not supporting IE8 - see addEventListener docs
		//$elem.off(eventName) => elem.removeEventListener(eventName, handler) // note you must keep a ref to handler for this
		//Key event listeners: use e.key === "+" instead of e.which === 43
		//See key docs
		['.on(', '.addEventListener(' ],
		['.off(', '.removeEventListener(' ],
		//Key event listeners: use e.key === "+" instead of e.which === 43 See key docs

		/**
		 * Event handlers
		 */
		// key events: (e.which === 45) => (e.key === "Tab") - docs

		/**
		 * Class Manipulation
		 */
		//$elem.addClass(c) => elem.classList.add(c)
		['.addClass(', '.classList.add('],

		//['.removeClass(', '.classList.remove('],
		['.toggleClass(', '.classList.toggle('],

		//$elem.hasClass(c) => elem.classList.contains(c)
		['.hasClass(', '.classList.contains('],

		//$elem.attr('class') = 'some classes' => elem.className = 'some classes'
		['.attr("class")', '.className'],

		/**
		 * Styling todo: Much MORE ADVANCED
		 */
		// $el.css({ top: "10px" }) => el.style.top = "10px"

		/**
		 * Scroll Position
		 */
		//$el.scrollTop() => el.scrollTop
		['.scrollTop()', '.scrollTop'],

		//$el.scrollTop(10) => el.scrollTop = 10

		/**
		 * Utils
		 */
		//$.inArray(item, arr) > -1 => arr.indexOf(item) > -1 // note: could use arr.includes(item) but would require polyfill for IE11

		//$.extend({}, defaults, options) => Object.assign(defaults, options)
		//$.trim(s) => s.trim()

		//To append a HTML string:
		//$elem.append(htmlString) => elem.insertAdjacentHTML('beforeend', htmlString);

		['.append(', '.insertAdjacentHTML("beforeend",'],

		//To add copy:
		//
		//$elem.text(s)
		//=>
		//
		//var elemText = document.createTextNode(text);
		//elem.appendChild(elemText)

		//$input.val() => input.value

		/**
		 * Creating/appending elements
		 */
		//$("<div>", {"class": c}).appendTo(parent); =>
		//var elem = document.createElement("div");
		//elem.className = c;
		//container.appendChild(elem);

		//To add copy:
		//
		//$elem.text(s)
		//=>
		//
		//var elemText = document.createTextNode(text);
		//elem.appendChild(elemText)
		//To append a HTML string:
		//
		//$elem.append(htmlString) => elem.insertAdjacentHTML('beforeend', htmlString);

		/**
		 * Attributes
		 */
		//$elem.attr("placeholder") => elem.getAttribute("placeholder")
		//$elem.attr("placeholder", p) => elem.setAttribute("placeholder", p)

		/**
		 * Properties
		 */
		['.props("readonly")', '.readOnly'],
		['.props("disabled")', '.disabled'],

	];

	/**
	 * replacements constructor.
	 *
	 * Loads all the defaults into the collection.
	 */
	public function __construct() {
		foreach($this->default as $value) {
			$this->add($value[0], $value[1]);
		}
	}


	public function add(string $searchFor, string $replaceWith) {
		$this->values[] = new replacement($searchFor, $replaceWith);
	}

}