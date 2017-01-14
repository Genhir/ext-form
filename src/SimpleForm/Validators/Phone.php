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

class SimpleForm_Validators_Phone extends SimpleForm_Core_Validator
{
	protected static $countryPhoneCallingCodes = ',0,1,3,4,5,6,7,8,9,20,27,28,30,31,32,33,34,36,38,39,40,41,42,43,44,45,46,47,48,49,51,52,53,54,55,56,57,58,60,61,62,63,64,65,66,81,82,83,84,86,89,90,91,92,93,94,95,98,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,290,291,292,293,294,295,296,297,298,299,350,351,352,353,354,355,356,357,358,359,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,420,421,422,423,424,425,426,427,428,429,500,501,502,503,504,505,506,507,508,509,590,591,592,593,594,595,596,597,598,599,670,671,672,673,674,675,676,677,678,679,680,681,682,683,684,685,686,687,688,689,690,691,692,693,694,695,696,697,698,699,800,801,802,803,804,805,806,807,808,809,850,851,852,853,854,855,856,857,858,859,870,875,876,877,878,879,880,881,882,883,884,885,886,887,888,889,960,961,962,963,964,965,966,967,968,969,970,971,972,973,974,975,976,977,978,979,990,991,992,993,994,995,996,997,998,999,1670,1671,1684,';

	public function Validate ($submitValue, $fieldName, SimpleForm_Core_Field & $field) {
		$submitValue = trim($submitValue);
		$noSpacesValue = preg_replace("#[^0-9\+]#", '', $submitValue);
		// determinate bad phone format
		$goodFormat = self::verifyPhoneFormat($noSpacesValue);
		// complete formated value with spaces
		$spacesValue = '';
		$index = strlen($noSpacesValue);
		$safeCounter = 0;
		while ($index > 0 && $safeCounter < 10) {
			$beginIndex = max(0, $index - 3);
			$partLength = $index - $beginIndex;
			$spaceString = ($spacesValue) ? ' ' : '' ;
			if ($beginIndex === 0) $spaceString = '';
			$spacesValue = substr($noSpacesValue, $beginIndex, $partLength) . $spaceString . $spacesValue;
			$submitValue = substr($noSpacesValue, 0, $beginIndex);
			$index -= 3;
			$safeCounter++;
		}

		if ((mb_strlen($noSpacesValue) === 0 && $field->Required) || !$goodFormat) {
			$this->addError($field, SimpleForm::$DefaultMessages[SimpleForm::PHONE], function ($msg, $args) {
				return SimpleForm_Core_View::Format($msg, $args);
			});
		}
		return $spacesValue;
	}
	protected static function verifyPhoneFormat ($noSpacesValue = '') {
		$goodFormat = FALSE;
		if (strlen($noSpacesValue) > 9) {
			$phoneCallingCode = str_replace(array('+', '00'), '', substr($noSpacesValue, 0, strlen($noSpacesValue) - 9));
			if (strpos(self::$countryPhoneCallingCodes, ',' . $phoneCallingCode . ',') !== FALSE) {
				$goodFormat = TRUE;
			}
		}
		return $goodFormat;
	}
}
