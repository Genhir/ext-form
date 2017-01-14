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

require_once('Core/Field.php');
require_once('Core/View.php');

class SimpleForm_Checkbox extends SimpleForm_Core_Field
{
	public $Type = 'checkbox';
	public $LabelSide = 'right';
	public $Validators = array('Checked');
	protected static $templates = array(
		'control'			=> '<input id="{id}" name="{name}" type="checkbox" value="true"{value}{attrs} />',
		'togetherLabelLeft'	=> '<label for="{id}"{attrs}><span>{label}</span>{control}</label>',
		'togetherLabelRight'=> '<label for="{id}"{attrs}>{control}<span>{label}</span></label>',
	);
	public function __construct(array $cfg = array()) {
		parent::__construct($cfg);
		static::$templates = (object) array_merge((array)parent::$templates, (array)self::$templates);
	}
	public function RenderControl () {
		$attrsStr = $this->renderControlAttrsWithFieldVars();
		return SimpleForm_Core_View::Format(static::$templates->control, array(
			'id'		=> $this->Id, 
			'name'		=> $this->Name, 
			'value'		=> $this->Value ? ' checked="checked"' : '',
			'attrs'		=> $attrsStr ? " $attrsStr" : '', 
		));
	}
}
