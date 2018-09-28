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

namespace MvcCore\Ext\Forms;

interface IView
{
	/**
	 * Get global views forms directory placed by default
	 * inside `"/App/Views"` directory.
	 * Default value is `"Forms"`, so scripts app path
	 * is `"/App/Views/Forms"`.
	 * @return string
	 */
	public static function GetFormsDir ();

	/**
	 * Set global views forms directory placed by default
	 * inside `"/App/Views"` directory.
	 * Default value is `"Forms"`, so scripts app path
	 * is `"/App/Views/Forms"`.
	 * @param string $formsDir
	 * @return string
	 */
	public static function SetFormsDir ($formsDir = 'Forms');

	/**
	 * Get global views fields directory placed by default
	 * inside `"/App/Views"` directory.
	 * Default value is `"Forms/Fields"`, so
	 * scripts app path is `"/App/Views/Forms/Fields"`.
	 * @return string
	 */
	public static function GetFieldsDir ();

	/**
	 * Set global views fields directory placed by default
	 * inside `"/App/Views"` directory.
	 * Default value is `"Forms/Fields"`, so
	 * scripts app path is `"/App/Views/Forms/Fields"`.
	 * @param string $fieldsDir
	 * @return string
	 */
	public static function SetFieldsDir ($fieldsDir = 'Forms/Fields');

	/**
	 * Get controller instance as reference.
	 * @return \MvcCore\View|\MvcCore\IView
	 */
	public function & GetView ();

	/**
	 * Set controller and it's view instance.
	 * @param \MvcCore\View|\MvcCore\IView $view
	 * @return \MvcCore\Ext\Forms\View
	 */
	public function & SetView (\MvcCore\IView & $view);

	/**
	 * Get form instance to render.
	 * @return \MvcCore\Ext\Form|\MvcCore\Ext\Forms\IForm
	 */
	public function & GetForm ();

	/**
	 * Set form instance to render.
	 * @param \MvcCore\Ext\Form|\MvcCore\Ext\Forms\IForm $form
	 * @return \MvcCore\Ext\Forms\View
	 */
	public function & SetForm (\MvcCore\Ext\Forms\IForm & $form);

	/**
	 * Get rendered field.
	 * @return \MvcCore\Ext\Forms\Field|\MvcCore\Ext\Forms\IField
	 */
	public function & GetField ();

	/**
	 * Set rendered field.
	 * @param \MvcCore\Ext\Forms\Field|\MvcCore\Ext\Forms\IField $field
	 * @return \MvcCore\Ext\Forms\View
	 */
	public function & SetField (\MvcCore\Ext\Forms\IField & $field);

	/**
	 * Get any value by given name existing in local store. If there is no value
	 * in local store by given name, try to get result value into store by
	 * field reflection class from field instance property if view is used for
	 * field rendering. If there is still no value found, try to get result value
	 * into store by form reflection class from form instance property and if
	 * still no value found, try to get result value from local view instance
	 * `__get()` method.
	 * @param string $name
	 * @return mixed
	 */
	public function __get ($name);

	/**
	 * Get `TRUE` by given name existing in local store. If there is no value
	 * in local store by given name, try to get result value into store by
	 * field reflection class from field instance property if view is used for
	 * field rendering. If there is still no value found, try to get result value
	 * into store by form reflection class from form instance property and if
	 * still no value found, try to get result value from local view instance
	 * `__get()` method.
	 * @param string $name
	 * @return bool
	 */
	public function __isset ($name);

	/**
	 * Call public field method if exists in field instance and view is used for
	 * field rendering or call public form method if exists in form instance or
	 * try to call view helper by parent `__call()` method.
	 * @param string $method
	 * @param mixed  $arguments
	 * @return mixed
	 */
	public function __call ($method, $arguments);

	/**
	 * Render configured form template.
	 * @return string
	 */
	public function RenderTemplate ();

	/**
	 * Render form naturaly by cycles inside php scripts.
	 * All form fields will be rendered inside empty <div> elements.
	 * @return string
	 */
	public function RenderNaturally ();

	/**
	 * Render form begin.
	 * Render opening <form> tag and hidden input with csrf tokens.
	 * @return string
	 */
	public function RenderBegin ();

	/**
	 * Render hidden input with CSRF tokens.
	 * This method is not necessary to call, it's
	 * called internaly by $form->View->RenderBegin();
	 * @return string
	 */
	public function RenderCsrf ();

	/**
	 * Return current CSRF (Cross Site Request Forgery) hidden
	 * input name and it's value as `\stdClass`.
	 * Result `\stdClass` has keys: `name` and `value`.
	 * @return \stdClass
	 */
	public function GetCsrf ();

	/**
	 * Render form errors.
	 * If form is configured to render all errors together at form beginning,
	 * this function completes all form errors into `div.errors` with `div.error` elements
	 * inside containing each single errors message.
	 * @return string
	 */
	public function RenderErrors ();

	/**
	 * Render form content - form fields.
	 * Go through all `$form->fields` and call `$field->Render();` on every field
	 * and put it into an empty `<div>` element. Render each field in full possible
	 * way - naturaly by label configuration with possible errors configured beside
	 * or with custom field template.
	 * @return string
	 */
	public function RenderContent ();

	/**
	 * Render form end.
	 * Render html closing `</form>` tag and supporting javascript and css files
	 * if is form not using external js/css renderers.
	 * @return string
	 */
	public function RenderEnd ();

	/**
	 * Format string function.
	 * @param string $str Template with replacements like `{0}`, `{1}`, `{anyStringKey}`...
	 * @param array $args Each value under it's index is replaced as
	 *					  string representation by replacement in form `{arrayKey}`
	 * @return string
	 */
	public static function Format ($str = '', array $args = []);

	/**
	 * Render content of html tag attributes by key/value array.
	 * @param array $atrributes
	 * @return string
	 */
	public static function RenderAttrs (array $atrributes = []);
}
