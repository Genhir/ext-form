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

require_once('/../../SimpleForm.php');
require_once('CompanyIds.php');

class SimpleForm_Validators_CompanyTaxId extends SimpleForm_Validators_CompanyIds
{
	protected static $exceptionMessage = "No company TAX ID verification method for language: '{lang}'.";
	protected static $errorMessageKey = SimpleForm::TAX_ID;
	protected function validate_CS ($id = '')
	{
		$id = preg_replace('#\s+#', '', $id);

		if (!preg_match('#^\d{8}$#', $id)) {
			return FALSE;
		}

		$a = 0;
		for ($i = 0; $i < 7; $i++) {
			$a += $id[$i] * (8 - $i);
		}

		$a = $a % 11;

		if ($a === 0) $c = 1;
		elseif ($a === 10) $c = 1;
		elseif ($a === 1) $c = 0;
		else $c = 11 - $a;

		return (int) $id[7] === $c;
	}
}
