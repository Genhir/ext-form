<?php

/**
 * SimpleForm
 *
 * This source file is subject to the BSD 3 License
 * For the full copyright and license information, please view 
 * the LICENSE.md file that are distributed with this source code.
 *
 * @copyright	Copyright (c) 2016 Tom Flídr (https://github.com/mvccore/simpleform)
 * @license		https://mvccore.github.io/docs/simpleform/3.0.0/LICENCE.md
 */

require_once(__DIR__.'/../../SimpleForm.php');
require_once(__DIR__.'/../Core/Validator.php');
require_once(__DIR__.'/../Core/Field.php');
require_once(__DIR__.'/../Core/View.php');

class SimpleForm_Validators_ValueInOptions extends SimpleForm_Core_Validator
{
	public function Validate ($submitValue, $fieldName, SimpleForm_Core_Field & $field) {
		$safeValue = $this->completeSafeValueByOptions($submitValue, $field);
		$safeValueType = gettype($safeValue);
		$safeValueCount = count($safeValue);
		$safeValueLen = is_array($safeValue) ? count($safeValue) : mb_strlen($safeValue);
		if (
			($safeValueType == 'array' && $safeValueCount !== count($submitValue)) ||
			($safeValueType == 'array' && $safeValueCount === 0 && $field->Required) ||
			($safeValueType == 'string' && $safeValueLen !== mb_strlen($submitValue)) ||
			($safeValueType == 'string' && $safeValueLen === 0 && $field->Required)
		) {
			$this->addError(
				$field, 
				SimpleForm::$DefaultMessages[SimpleForm::VALID], 
				function ($msg, $args) {
					return SimpleForm_Core_View::Format($msg, $args);
				}
			);
		}
		return $safeValue;
	}

	protected function completeSafeValueByOptions ($submitValue, & $field) {
		if (gettype($submitValue) == 'array') {
			$submitValues = $submitValue;
			$safeValue = array();
		} else {
			$submitValue = (string) $submitValue;
			$submitValues = mb_strlen($submitValue) > 0 ? array($submitValue) : array();
			$safeValue = '';
		}
		foreach ($submitValues as $submitValueItem) {
			$submitValueItem = trim($submitValueItem);
			$catched = 0;
			$safeValueItem = '';
			foreach ($field->Options as $key1 => $option1) {
				if ($key1 == $submitValueItem) {
					$catched = 1;
					$safeValueItem = $key1;
					break;
				}
				if (isset($option1['options']) && gettype($option1['options']) == 'array') {
					foreach ($option1['options'] as $key2 => $option2) {
						if ($key2 == $submitValueItem) {
							$catched = 1;
							$safeValueItem = $key2;
							break;
						}
					}
				}
				if ($catched) break;
			}
			if ($catched) {
				if (gettype($safeValue) == 'array') {
					$safeValue[] = $safeValueItem;
				} else {
					$safeValue = $safeValueItem;
				}
			}
		}
		return $safeValue;
	}
}