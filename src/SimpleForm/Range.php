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

require_once(__DIR__.'/Core/Field.php');
require_once(__DIR__.'/Core/View.php');

class SimpleForm_Range extends SimpleForm_Core_Field
{
	public $Type = 'range';
	public $Min = null;
	public $Max = null;
	public $Step = null;
	public $Multiple = FALSE;
	public $Wrapper = '{control}';
	public $Validators = array('RangeField');
	public $JsClass = 'SimpleForm.Range';
	public $Js = '__SIMPLE_FORM_DIR__/fields/range.js';
	public $Css = '__SIMPLE_FORM_DIR__/fields/range.css';

	public function SetMin ($min) {
		$this->Min = $min;
		return $this;
	}
	public function SetMax ($max) {
		$this->Max = $max;
		return $this;
	}
	public function SetStep ($step) {
		$this->Step = $step;
		return $this;
	}
	public function SetMultiple ($multiple) {
		$this->Multiple = $multiple;
		return $this;
	}
	public function SetWrapper ($wrapper) {
		$this->Wrapper = $wrapper;
		return $this;
	}
	public function SetUp () {
		parent::SetUp();
		$this->Form->AddJs($this->Js, $this->JsClass, array($this->Name));
		$this->Form->AddCss($this->Css);
	}
	public function RenderControl () {
		if ($this->Multiple) $this->Multiple = 'multiple';
		$attrsStr = $this->renderControlAttrsWithFieldVars(
			array('Min', 'Max', 'Step','Multiple')
		);
		$this->Multiple = $this->Multiple ? TRUE : FALSE ;
		$valueStr = $this->Multiple && gettype($this->Value) == 'array' ? implode(',', $this->Value) : (string)$this->Value;
		$result = SimpleForm_Core_View::Format(static::$templates->control, array(
			'id'		=> $this->Id, 
			'name'		=> $this->Name, 
			'type'		=> $this->Type,
			'value'		=> $valueStr . '" data-value="' . $valueStr,
			'attrs'		=> $attrsStr ? " $attrsStr" : '',
		));
		$wrapperReplacement = '{control}';
		$wrapper = mb_strpos($wrapperReplacement, $this->Wrapper) !== FALSE ? $this->Wrapper : $wrapperReplacement;
		return str_replace($wrapperReplacement, $result, $wrapper);
	}
}