<?php

/**
 * MvcCore
 *
 * This source file is subject to the BSD 3 License
 * For the full copyright and license information, please view
 * the LICENSE.md file that are distributed with this source code.
 *
 * @copyright	Copyright (c) 2016 Tom Flídr (https://github.com/mvccore/mvccore)
 * @license		https://mvccore.github.io/docs/mvccore/4.0.0/LICENCE.md
 */

namespace MvcCore\Ext\Forms\Field\Props;

/**
 * Trait for classes:
 * - `\MvcCore\Ext\Forms\Fields\Color`
 * - `\MvcCore\Ext\Forms\Fields\Number`
 *    - `\MvcCore\Ext\Forms\Fields\Range`
 * - `\MvcCore\Ext\Forms\Fields\Select`
 *    - `\MvcCore\Ext\Forms\Fields\CountrySelect`
 * - `\MvcCore\Ext\Forms\Fields\Text`
 *    - `\MvcCore\Ext\Forms\Fields\Email`
 *    - `\MvcCore\Ext\Forms\Fields\Password`
 *    - `\MvcCore\Ext\Forms\Fields\Search`
 *    - `\MvcCore\Ext\Forms\Fields\Tel`
 *    - `\MvcCore\Ext\Forms\Fields\Url`
 * - `\MvcCore\Ext\Forms\Fields\Textarea`
 * - `\MvcCore\Ext\Forms\Fields\Hidden`
 */
trait AutoComplete
{
	/**
	 * Attribute indicates if the input can be automatically completed 
	 * by the browser, usually by remembering previous values the user has entered.
	 * Possible values: `off`, `on`, `name`, `email`, `username`, `country`, `postal-code` and many more...
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#attr-autocomplete
	 * @var string|NULL
	 */
	protected $autoComplete = NULL;

	/**
	 * Get attribute indicates if the input can be automatically completed 
	 * by the browser, usually by remembering previous values the user has entered.
	 * Possible values: `off`, `on`, `name`, `email`, `username`, `country`, `postal-code` and many more...
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#attr-autocomplete
	 * @return string|NULL
	 */
	public function GetAutoComplete () {
		return $this->autoComplete;
	}

	/**
	 * Set attribute indicates if the input can be automatically completed 
	 * by the browser, usually by remembering previous values the user has entered.
	 * Possible values: `off`, `on`, `name`, `email`, `username`, `country`, `postal-code` and many more...
	 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input#attr-autocomplete
	 * @param string $autoComplete 
	 * @return \MvcCore\Ext\Forms\Field|\MvcCore\Ext\Forms\IField
	 */
	public function & SetAutoComplete ($autoComplete) {
		/** @var $this \MvcCore\Ext\Forms\IField */
		$this->autoComplete = $autoComplete;
		return $this;
	}
}
