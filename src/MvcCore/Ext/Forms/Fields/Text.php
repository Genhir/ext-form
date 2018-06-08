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

namespace MvcCore\Ext\Forms\Fields;
class Text 
	extends		\MvcCore\Ext\Forms\Field 
	implements	\MvcCore\Ext\Forms\Fields\IPattern, 
				\MvcCore\Ext\Forms\Fields\IMinMaxLength
{
	use \MvcCore\Ext\Forms\Field\Attrs\AutoComplete;
	use \MvcCore\Ext\Forms\Field\Attrs\PlaceHolder;
	use \MvcCore\Ext\Forms\Field\Attrs\Pattern;
	use \MvcCore\Ext\Forms\Field\Attrs\MinMaxLength;
	use \MvcCore\Ext\Forms\Field\Attrs\Size;
	use \MvcCore\Ext\Forms\Field\Attrs\DataList;

	protected $type = 'text';

	protected $validators = ['SafeString'/*, 'MinLength', 'MaxLength', 'Pattern'*/];

	public function & SetForm (\MvcCore\Ext\Forms\IForm & $form) {
		parent::SetForm($form);
		$this->setFormPattern();
		$this->setFormMinMaxLength();
		return $this;
	}

	public function PreDispatch () {
		parent::PreDispatch();
		if ($this->translate && $this->placeholder)
			$this->placeholder = $this->form->Translate($this->placeholder);
	}

	public function RenderControl () {
		$attrsStr = $this->renderControlAttrsWithFieldVars(
			['minLength', 'maxLength', 'size', 'placeHolder', 'pattern', 'autoComplete', 'list']
		);
		$formViewClass = $this->form->GetViewClass();
		return $formViewClass::Format(static::$templates->control, [
			'id'		=> $this->id,
			'name'		=> $this->name,
			'type'		=> $this->type,
			'value'		=> htmlspecialchars($this->value, ENT_QUOTES),
			'attrs'		=> $attrsStr ? " $attrsStr" : '',
		]);
	}
}
