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

namespace MvcCore\Ext\Forms\Validators;

class Pattern extends \MvcCore\Ext\Forms\Validator
{
	use \MvcCore\Ext\Forms\Field\Attrs\Pattern;

	/**
	 * Set up field instance, where is validated value by this 
	 * validator durring submit before every `Validate()` method call.
	 * This method is also called once, when validator instance is separately 
	 * added into already created field instance to process any field checking.
	 * @param \MvcCore\Ext\Forms\Field|\MvcCore\Ext\Forms\IField $field 
	 * @return \MvcCore\Ext\Forms\Validator|\MvcCore\Ext\Forms\IValidator
	 */
	public function & SetField (\MvcCore\Ext\Forms\IField & $field) {
		parent::SetField($field);
		$fieldImplementsPattern = $field instanceof \MvcCore\Ext\Forms\Field\Attrs\Pattern;
		if ($this->pattern && $fieldImplementsPattern && !$field->GetPattern()) {
			// if this validator is added into field as instance - check field if it has pattern attribute defined:
			$field->SetPattern($this->pattern);
		} else if (!$this->pattern && $fieldImplementsPattern && $field->GetPattern()) {
			// if validator is added as string - get pattern property from field:
			$this->pattern = $field->GetPattern();
		} else {
			$this->throwNewInvalidArgumentException(
				'No RegExp `pattern` property defined in current validator or in field.'	
			);
		}
		return $this;
	}

	/**
	 * Validate raw user input by configured regexp match pattern.
	 * @param string|array $submitValue Raw submitted value from user.
	 * @return string|NULL Safe submitted value or `NULL` if not possible to return safe value.
	 */
	public function Validate ($rawSubmittedValue) {
		$result = NULL;
		$rawSubmittedValue = trim($rawSubmittedValue);
		if ($this->pattern !== NULL) {
			$pattern = $this->pattern;
			$beginBorderChar = mb_strpos($pattern, "#") === 0;
			$endBorderChar = mb_substr($pattern, mb_strlen($pattern) - 2, 1) === '#';
			if (!$beginBorderChar && !$endBorderChar)
				$pattern = "#" . $pattern . "#";
			$matched = @preg_match($pattern, $rawSubmittedValue, $matches);
			if ($matched) 
				$result = $rawSubmittedValue;
		} else {
			$result = $rawSubmittedValue;
		}
		if ($result === NULL) {
			$this->field->AddValidationError(
				$this->form->GetDefaultErrorMsg(\MvcCore\Ext\Forms\IError::INVALID_FORMAT),
				array($this->pattern)
			);
		}
		return $result;
	}
}
