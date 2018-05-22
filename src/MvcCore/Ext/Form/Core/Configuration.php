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

namespace MvcCore\Ext\Form\Core;

require_once('Base.php');

abstract class Configuration extends Base
{
	/** Form http submitting method ('get'). */
	const METHOD_GET    = 'get';
	/** Form http submitting method ('post'). */
	const METHOD_POST   = 'post';
	/** Form http submitting method ('head'). */
	const METHOD_HEAD	= 'head';
	/** Form http submitting method ('put'). */
	const METHOD_PUT    = 'put';
	/** Form http submitting method ('patch'). */
	const METHOD_PATCH	= 'patch';
	/** Form http submitting method ('trace'). */
	const METHOD_TRACE	= 'trace';
	/** Form http submitting method ('options'). */
	const METHOD_OPTIONS= 'options';
	/** Form http submitting method ('connect'). */
	const METHOD_CONNECT= 'connect';
	/** Form http submitting method ('delete'). */
	const METHOD_DELETE = 'delete';


	/**
	 * Form enctype attribute value 'application/x-www-form-urlencoded',
	 * By submitting - all form values will be encoded
	 * to key1=value1&key2=value2&... string.
	 * This enctype type is used for all \MvcCore\Ext\Form(s) by default.
	 */
	const ENCTYPE_URLENCODED = 'application/x-www-form-urlencoded';
	/**
	 * Form enctype attribute value 'multipart/form-data',
	 * By submitting - no characters will be encoded.
	 * This value is required when you are using forms that have a file upload control.
	 */
	const ENCTYPE_MULTIPART  = 'multipart/form-data';
	/**
	 * Form enctype attribute value 'application/x-www-form-urlencoded',
	 * By submitting - spaces will be converted to "+" symbols,
	 * but no special characters will be encoded.
	 */
	const ENCTYPE_PLAINTEXT  = 'text/plain';


	/**
	 * Html id attributes delimiter,
	 * used for form controls to complete
	 * it's ids as <form-id>_<control-name>
	 */
	const HTML_IDS_DELIMITER = '_';


	/**
	 * Constants used internaly and mostly
	 * in validator classes to specify
	 * proper error message index.
	 */
	const EQUAL = ':equal',
	NOT_EQUAL = ':notEqual',
	REQUIRED = ':required',
	INVALID_FORMAT = ':invalidFormat',
	INVALID_CHARS = ':invalidChars',
	EMPTY_CONTENT = ':empty',
	CSRF = ':csrf',
	// text
	MIN_LENGTH = ':minLength',
	MAX_LENGTH = ':maxLength',
	LENGTH = ':length',
	EMAIL = ':email',
	URL = ':url',
	NUMBER = ':number',
	INTEGER = ':integer',
	FLOAT = ':float',
	DATE = ':date',
	DATE_TO_LOW = ':dateToLow',
	DATE_TO_HIGH = ':dateToHigh',
	TIME = ':time',
	TIME_TO_LOW = ':timeToLow',
	TIME_TO_HIGH = ':timeToHigh',
	DATETIME = ':datetime',
	PHONE = ':phone',
	ZIP_CODE = ':zipCode',
	TAX_ID = ':taxId',
	VAT_ID = ':varId',
	GREATER = ':greater',
	LOWER = ':lower',
	RANGE = ':range',
	// file upload
	MAX_FILE_SIZE = ':fileSize',
	MAX_POST_SIZE = ':maxPostSize',
	IMAGE = ':image',
	MIME_TYPE = ':mimeType',
	// other
	VALID = ':valid',
	CHOOSE_MIN_OPTS = ':chooseMinOpts',
	CHOOSE_MAX_OPTS = ':chooseMaxOpts',
	CHOOSE_MIN_OPTS_BUBBLE = ':chooseMinOptsBubble',
	CHOOSE_MAX_OPTS_BUBBLE = ':chooseMaxOptsBubble';


	/**
	 * Default not translated error messages with replacements
	 * for control names and more specific info to tell the user.
	 * @var array
	 */
	public static $DefaultMessages = array(
		self::EQUAL					=> "Field '{0}' requires exact value: '{1}'.",
		self::NOT_EQUAL				=> "Value for field '{0}' should not be '{1}'.",
		self::REQUIRED				=> "Field '{0}' is required.",
		self::INVALID_FORMAT		=> "Field '{0}' has invalid format ('{1}').",
		self::INVALID_CHARS			=> "Field '{0}' contains invalid characters.",
		self::EMPTY_CONTENT			=> "Sent data are empty.",
		self::CSRF					=> "Form hash expired, please submit the form again.",
		self::MIN_LENGTH			=> "Field '{0}' requires at least {1} characters.",
		self::MAX_LENGTH			=> "Field '{0}' requires no more than {1} characters.",
		self::LENGTH				=> "Field '{0}' requires a value between {1} and {2} characters long.",
		self::EMAIL					=> "Field '{0}' requires a valid email address.",
		self::URL					=> "Field '{0}' requires a valid URL.",
		self::NUMBER				=> "Field '{0}' requires a valid number.",
		self::INTEGER				=> "Field '{0}' requires a valid integer.",
		self::FLOAT					=> "Field '{0}' requires a valid float number.",
		self::DATE					=> "Field '{0}' requires a valid date format: '{1}'.",
		self::DATE_TO_LOW			=> "Field '{0}' requires date higher or equal to '{1}'.",
		self::DATE_TO_HIGH			=> "Field '{0}' requires date lower or equal to '{1}'.",
		self::TIME					=> "Field '{0}' requires a valid time format: '00:00 - 23:59'.",
		self::TIME_TO_LOW			=> "Field '{0}' requires time higher or equal to '{1}'.",
		self::TIME_TO_HIGH			=> "Field '{0}' requires time lower or equal to '{1}'.",
		self::DATETIME				=> "Field '{0}' requires a valid date time format: '{1}'.",
		self::PHONE					=> "Field '{0}' requires a valid phone number.",
		self::ZIP_CODE				=> "Field '{0}' requires a valid zip code.",
		self::TAX_ID				=> "Field '{0}' requires a valid TAX ID.",
		self::VAT_ID				=> "Field '{0}' requires a valid VAR ID.",
		self::GREATER				=> "Field '{0}' requires a value greater than {1}.",
		self::LOWER					=> "Field '{0}' requires a value lower than {1}.",
		self::RANGE					=> "Field '{0}' requires a value between {1} and {2}.",
		self::MAX_FILE_SIZE			=> "The size of the uploaded file can be up to {0} bytes.",
		self::MAX_POST_SIZE			=> "The uploaded data exceeds the limit of {0} bytes.",
		self::IMAGE					=> "The uploaded file has to be image in format JPEG, GIF or PNG.",
		self::MIME_TYPE				=> "The uploaded file is not in the expected file format.",
		self::VALID					=> "Field '{0}' requires a valid option.",
		self::CHOOSE_MIN_OPTS		=> "Field '{0}' requires at least {1} chosen option(s) at minimal.",
		self::CHOOSE_MAX_OPTS		=> "Field '{0}' requires {1} of the selected option(s) at maximum.",
		self::CHOOSE_MIN_OPTS_BUBBLE=> "Please select at least {0} options as minimal.",
		self::CHOOSE_MAX_OPTS_BUBBLE=> "Please select up to {0} options at maximum.",
	);


	/**
	 * Form submit result state (0 - error happend).
	 * Submit was not successful,there was an error/errors.
	 */
	const RESULT_ERRORS		= 0;
	/**
	 * Form submit result state (1 - everything ok).
	 * Submit was successful, no error happend.
	 */
	const RESULT_SUCCESS	= 1;
	/**
	 * Form submit result state (2 - everything ok, next step).
	 * Submit was successful, no error happend
	 * and one of submittin button is control
	 * to indicate that we can go to next step
	 * in multiple forms wizzard (typicly eshop ordering).
	 */
	const RESULT_NEXT_PAGE	= 2;


	/**
	 * Control/labels rendering mode ('normal').
	 * Label will be rendered before control,
	 * only for checkbox and radio button label
	 * will be rendered after control.
	 */
	const FIELD_RENDER_MODE_NORMAL			= 'normal';
	/**
	 * Control/labels rendering mode ('no-label').
	 * No label will be rendered with control.
	 */
	const FIELD_RENDER_MODE_NO_LABEL		= 'no-label';
	/**
	 * Control/labels rendering mode ('label-around').
	 * Label will be rendered around control.
	 */
	const FIELD_RENDER_MODE_LABEL_AROUND	= 'label-around';


	/**
	 * Control errors rendering mode ('all-together').
	 * All errors are rendered naturaly at form begin together in one html div element.
	 * If you are using custom template for form - you have to call after form beginning $this->RenderErrors();
	 * to get all errors into template. This value is used as default for all \MvcCore\Ext\Form(s).
	 */
	const ERROR_RENDER_MODE_ALL_TOGETHER		= 'all-together';
	/**
	 * Control errors rendering mode ('before-each-control').
	 * If there will be any error, it will be rendered as single span.errors
	 * before current form control with single or multiple span.error elements
	 * inside, by errors count for current form control. It will be rendered in
	 * natural form rendering mode without template but also in custom form rendering mode
	 * with template if you call anytime in template $field->RenderLabelAndControl();
	 * If you will use in custom form rendering mod with template method $field->RenderControl();,
	 * there will be not rendered any error spans before control, you have to use $field->RenderErrors();
	 * to get errors for each control.
	 */
	const ERROR_RENDER_MODE_BEFORE_EACH_CONTROL	= 'before-each-control';
	/**
	 * Control errors rendering mode ('after-each-control').
	 * If there will be any error, it will be rendered as single span.errors
	 * after current form control with single or multiple span.error elements
	 * inside, by errors count for current form control. It will be rendered in
	 * natural form rendering mode without template but also in custom form rendering mode
	 * with template if you call anytime in template $field->RenderLabelAndControl();
	 * If you will use in custom form rendering mod with template method $field->RenderControl();,
	 * there will be not rendered any error spans before control, you have to use $field->RenderErrors();
	 * to get errors for each control.
	 */
	const ERROR_RENDER_MODE_AFTER_EACH_CONTROL	= 'after-each-control';

	protected $application = NULL;

	/**
	 * Controller object, always passed and required
	 * as first argument through \MvcCore\Ext\Form::__constructor($controller) method.
	 * @requires
	 * @var \MvcCore\Controller|mixed
	 */
	public $Controller = null;
	/**
	 * Form view, object container with variables from local context to render in template.
	 * Created automaticly inside \MvcCore\Ext\Form before each rendering process.
	 * @var \MvcCore\Ext\Form\Core\View|mixed
	 */
	public $View = NULL;
	/**
	 * Form id, required to configure.
	 * Used to identify session data, error messages,
	 * csrf tokens, html form attribute id value and much more.
	 * @requires
	 * @var string
	 */
	public $Id = '';
	/**
	 * Form submitting url value.
	 * Should be relative or absolute, anything
	 * to complete classic html form attribute action.
	 * @requires
	 * @var string
	 */
	public $Action = '';
	/**
	 * Form http submitting method.
	 * 'post' by default.
	 * @var string
	 */
	public $Method = self::METHOD_POST;
	/**
	 * Form enctype attribute - how the form values
	 * should be encoded when submitting it to the server.
	 * 'application/x-www-form-urlencoded' by default, it means
	 * all form values will be encoded to key1=value1&key2=value2... string.
	 * @var string
	 */
	public $Enctype = self::ENCTYPE_URLENCODED;
	/**
	 * Field to complete optional translator language argument automaticly.
	 * If you are operating in multilanguage project and you want to use
	 * translator in \MvcCore\Ext\Form, set this Lang property to desired language code
	 * you want to translate every visible text into it. Use this property
	 * with $form->Translator and $form->Translate properties;
	 * @var string
	 */
	public $Lang = '';
	/**
	 * Field to create proper validator for zip codes, currencies etc...
	 * If you are operating in multilanguage project and you want to use
	 * form field validators for locale specific needs in \MvcCore\Ext\Form,
	 * set $form->Locale property to desired international locale code
	 * you want to use proper validator functionality.
	 * @var string
	 */
	public $Locale = '';
	/**
	 * Form html element css class attribute value.
	 * To specify more css classes - add more strings separated by space.
	 * @var string
	 */
	public $CssClass = '';
	/**
	 * Form html element additional attributes.
	 * To add any other attribute for html <form> element,
	 * assert here key/value array, keys will be used as attribute names,
	 * values as attribute values, simple.
	 * @var array
	 */
	public $Attributes = array();
	/**
	 * Url string, relative or absolute, to specify, where
	 * user will be redirected after form will be submitted successfully.
	 * It's required to use \MvcCore\Ext\Form like this, but if you want to use method
	 * $form->RedirectAfterSubmit();, at the end of custom Submit method implementation,
	 * you need to specify at least success and error url strings.
	 * @var string
	 */
	public $SuccessUrl = '';
	/**
	 * Url string, relative or absolute, to specify, where
	 * user will be redirected after form will be submitted successfully
	 * and submit button will be recognized to switch $form->Result value to value 2,
	 * which means next step redirection after successfull submit. This functionality
	 * to switch to value 2 is up to you. This field is designed only for you as empty.
	 * It's not required to use \MvcCore\Ext\Form like this, but if you want to use method
	 * $form->RedirectAfterSubmit(); at the end of custom Submit method implementation,
	 * and you want to go to next step by one button or stay in the same page by
	 * another form submit button, this is very good and comfortable pattern.
	 * to use it like this.
	 * @var string
	 */
	public $NextStepUrl = '';
	/**
	 * Url string, relative or absolute, to specify, where
	 * user will be redirected after form will not be submitted successfully.
	 * It's not required to use \MvcCore\Ext\Form like this, but if you want to use method
	 * $form->RedirectAfterSubmit(); at the end of custom Submit method implementation,
	 * you need to specify at least success and error url strings.
	 * @var string
	 */
	public $ErrorUrl = '';
	/**
	 * Form submit result state (by default - 1 - everything ok).
	 * Submit was successful, no error happend.
	 */
	public $Result = self::RESULT_SUCCESS;
	/**
	 * If true, every form control placeholder, label content and error message
	 * will be translated to $form->Lang value translation fraze. If false, nothing
	 * will be translated. If null, nothing configured yet. Null is for internal purposes.
	 * @var bool
	 */
	public $Translate = NULL;
	/**
	 * Translator callable (should be closure function or array
	 * with classname/instance and method name string). First argument
	 * of callable object has to be a translation key and second argument
	 * has to be a language string ('en', 'de' ...) to translate the key into.
	 * result of callable object has to be a string - translated key to called language.
	 * @var callable
	 */
	public $Translator = NULL;
	/**
	 * Default switch how to set every form control to be required by default.
	 * If you define directly any control to not be required, it will not be required.
	 * This is only value used as default for not strictly defined require values in controls.
	 * @var bool
	 */
	public $Required = FALSE;
	/**
	 * Every form control after it is added by $form->AddField() method is added under it's name
	 * into this public array fith all form fields except csrf input:hidden. Fields are rendered
	 * by order in this array.
	 * @var \MvcCore\Ext\Form\Core\Field[]
	 */
	public $Fields = array();
	/**
	 * Form submited data from client. After $form->Submit() has been called,
	 * data are clean and ready to use if $form->Result is in success state.
	 * @var array
	 */
	public $Data = array();
	/**
	 * If any configured error happends by $form->Submit() process, it's stored in this array.
	 * Every record in this array is array with first item to be an error  message string.
	 * If the error is for specific field name, there is also a second item - field name.
	 * Errors array has normal numeric keys.
	 * @var array
	 */
	public $Errors = array();
	/**
	 * Default control/label rendering mode for each form control/label.
	 * Default values is string 'normal', it means label will be rendered
	 * before control, only for checkbox and radio button label will be
	 * rendered after control.
	 * @var string
	 */
	public $FieldsDefaultRenderMode = self::FIELD_RENDER_MODE_NORMAL;
	/**
	 * Errors rendering mode, by default configured as string: 'all-together',
	 * It means all errors are rendered naturaly at form begin together in one html div.errors element.
	 * If you are using custom template for form - you have to call after form beginning: $this->RenderErrors();
	 * to get all errors into template.
	 * @var string
	 */
	public $ErrorsRenderMode = self::ERROR_RENDER_MODE_ALL_TOGETHER;
	/**
	 * Form custom template relative path without .phtml extension.
	 * By default it's an empty string, which means there will be used no template and form
	 * will be rendered naturaly, one field by one without any breaking line html element.
	 * If there is any path defined, it has to be defined relatively from directory '/App/Views/Scripts'
	 * to desired template.
	 * @var string
	 */
	public $TemplatePath = '';
	/**
	 * Property to change template type path, where form templates will be located.
	 * By default, all form templates are located in '/App/Views/Scripts', if you want to change it,
	 * you can set this property for example to 'Forms' to define base directory for form templates to
	 * /App/Views/Forms' or by defining this property to '../Forms' to '/App/Forms' etc...
	 * @var string
	 */
	public $TemplateTypePath = 'Scripts';
	/**
	 * Array with all necessary javascript contructors and file paths to add
	 * into html response after form is rendered by contained fields.
	 * Every record in this field has defined:
	 *	- string - supporting javascript file relative path
	 *	- string - supporting javascript full class name inside supporting file
	 *	- array - supporting javascript constructor params
	 * @var array
	 */
	public $Js = array();
	/**
	 * Array with all necessary css file paths to add into html response after
	 * form is rendered by contained fields. Every record in this field has defined:
	 *	- string - supporting javascript file relative path
	 *	- string - supporting javascript full class name inside supporting file
	 *	- array - supporting javascript constructor params
	 * @var array
	 */
	public $Css = array();
	/**
	 * If there is necessary to add after form into html response
	 * any supported javascript, there is necessary also to add
	 * base supporting form javascript - this is relative path
	 * where it is located.
	 * @var string
	 */
	public $JsBaseFile = '__MVCCORE_FORM_DIR__/mvccore-form.js';
	/**
	 * Javascript external files renderer. If any callable is set, it has
	 * to accept first param to be SplFileInfo about extenal support javascript file.
	 * Javascript renderer must add supporting javascript file only once into html
	 * output result in any custom way, it is it's responsibility.
	 * @var callable
	 */
	public $JsRenderer = NULL;
	/**
	 * Css external files renderer. If any callable is set, it has
	 * to accept first param to be SplFileInfo about extenal support css file.
	 * Css renderer must add supporting css file only once into html
	 * output result in any custom way, it is it's responsibility.
	 * @var callable
	 */
	public $CssRenderer = NULL;


	/**
	 * Add cross site request forgery error handler.
	 * By CSRF error by submitting process there shoud be called
	 * queue of those handlers, for example to deauthenticate the user
	 * or anything else to secure your app more.
	 * @static
	 * @param callable $handler
	 */
	public static function AddCsrfErrorHandler (callable $handler) {
		static::$csrfErrorHandlers[] = $handler;
	}


	/**
	 * Add supporting css files.
	 * @param string $cssFile supporting css file relative path
	 * @return \MvcCore\Ext\Form
	 */
	public function & AddCss ($cssFile = '') {
		$this->Css[] = array($cssFile);
		return $this;
	}
	/**
	 * Add css class (or classes separated by space) and add new value(s)
	 * after previous css class(es) attribute values. Value is used for
	 * standard css class attribute for HTML form tag.
	 * @param string $cssClass
	 * @return \MvcCore\Ext\Form
	 */
	public function & AddCssClass ($cssClass = '') {
		$this->CssClass .= (($this->CssClass) ? ' ' : '') . $cssClass;
		return $this;
	}
	/**
	 * Add supporting javascript files configuration.
	 * @param string $jsFile				supporting javascript file relative path
	 * @param string $jsClass				supporting javascript full class name inside supporting file
	 * @param array  $jsConstructorParams	supporting javascript constructor params
	 * @return \MvcCore\Ext\Form
	 */
	public function & AddJs ($jsFile = '', $jsClass = 'MvcCoreForm.FieldType', $jsConstructorParams = array()) {
		$this->Js[] = array($jsFile, $jsClass, $jsConstructorParams);
		return $this;
	}

	/**
	 * Set form submitting url value.
	 * It could be relative or absolute, anything
	 * to complete classic html form attribute `action`.
	 * @requires
	 * @param string $url
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetAction ($url = '') {
		$this->Action = $url;
		return $this;
	}
	/**
	 * Set form html element additional attributes.
	 * To add any other attribute for html <form> element,
	 * set here key/value array, keys will be used as attribute names,
	 * values as attribute values, simple. All previously configured additional
	 * attributes will be replaced by this function call.
	 * @param array $attributes
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetAttributes (array $attributes = array()) {
		$this->Attributes = $attributes;
		return $this;
	}
	/**
	 * Set supporting css files.
	 * All previously configured supporting css files will be replaced.
	 * Set it as array with all necessary css file paths to add into html response after
	 * form is rendered by contained fields. Every record in this field has defined:
	 *	- supporting css file relative path
	 * @param array $cssFiles
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetCss (array $cssFiles = array()) {
		$this->Css = array();
		foreach ($cssFiles as $item) $this->AddCss($item);
		return $this;
	}

	/**
	 * Set form html element css class attribute value.
	 * To specify more css classes - add more strings separated by space
	 * and overwrite any previous css class attribute value. Value is used for
	 * standard css class attribute for HTML `<form>` tag.
	 * @param string $cssClass
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetCssClass ($cssClass = '') {
		$this->CssClass = $cssClass;
		return $this;
	}
	/**
	 * Set css external files renderer. If any callable is set, it has
	 * to accept first param to be SplFileInfo about extenal support css file.
	 * Css renderer must add supporting css file only once into html
	 * output result in any custom way, it is it's responsibility.
	 * @param callable $cssRenderer
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetCssRenderer (callable $cssRenderer) {
		$this->CssRenderer = $cssRenderer;
		return $this;
	}
	/**
	 * Set multiple fields values by key/value array.
	 * For each key in $defaults array, library try to find form control
	 * with the same name as array key and that control value is set to array value.
	 * Only data with existing fields by keys are setted into field values.
	 * Values are setted by keys keys sensitively by default.
	 * @param array $defaults			key value array with data to set as values into fields by keys
	 * @param bool  $keysInsensitive	if true, set up properties from $data with case insensivity
	 * @param bool  $clearPreviousDataInSession If `TRUE`, clear all previous data records for this form id in session.
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetDefaults (array $defaults = array(), $keysInsensitive = FALSE, $clearPreviousDataInSession = FALSE) {
		if (!$this->initialized) $this->Init();
		if ($clearPreviousDataInSession) $this->ClearSession();
		$defaultsKeys = $keysInsensitive
			? ',' . implode(',', array_keys($defaults)) . ','
			: '' ;
		foreach ($this->Fields as $fieldName => & $field) {
			if (isset($defaults[$fieldName])) {
				$fieldValue = $defaults[$fieldName];
			} else if ($keysInsensitive) {
				$defaultsKeyPos = stripos($defaultsKeys, ','.$fieldName.',');
				if ($defaultsKeyPos === FALSE) continue;
				$defaultsKey = substr($defaultsKeys, $defaultsKeyPos + 1, strlen($fieldName));
				$fieldValue = $defaults[$defaultsKey];
			} else {
				continue;
			}
			$field->SetValue($fieldValue);
			if ($fieldValue) $this->Data[$fieldName] = $fieldValue;
		}
		return $this;
	}
	/**
	 * Set form enctype attribute - how the form values
	 * should be encoded when submitting it to the server.
	 * 'application/x-www-form-urlencoded' by default, it means
	 * all form values will be encoded to key1=value1&key2=value2... string.
	 * @param string $enctype
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetEnctype ($enctype = '') {
		$this->Enctype = $enctype;
		return $this;
	}
	/**
	 * Set errors rendering mode, by default configured as string: 'all-together',
	 * It means all errors are rendered naturaly at form begin together in one html div.errors element.
	 * If you are using custom template for form - you have to call after form beginning: $this->RenderErrors();
	 * to get all errors into template.
	 * @param mixed $errorsRenderMode
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetErrorsRenderMode ($errorsRenderMode = \MvcCore\Ext\Form::ERROR_RENDER_MODE_ALL_TOGETHER) {
		$this->ErrorsRenderMode = $errorsRenderMode;
		return $this;
	}

	/**
	 * Set error url string, relative or absolute, to specify, where
	 * to redirect user after form not submitted successfully.
	 * It's not required to use `\MvcCore\Ext\Form` like this, but if you want to use method
	 * `$form->RedirectAfterSubmit();` at the end of custom `Submit()` method implementation,
	 * you need to specify at least success and error url strings.
	 * @param string $url
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetErrorUrl ($url = '') {
		$this->ErrorUrl = $url;
		return $this;
	}
	/**
	 * Det default control/label rendering mode for each form control/label.
	 * Default configured value by default is string 'normal', it means label will be rendered
	 * before control, only for checkbox and radio button label will be
	 * rendered after control.
	 * @param string $fieldsDefaultRenderMode
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetFieldsDefaultRenderMode ($fieldsDefaultRenderMode = \MvcCore\Ext\Form::FIELD_RENDER_MODE_NORMAL) {
		$this->FieldsDefaultRenderMode = $fieldsDefaultRenderMode;
		return $this;
	}
	/**
	 * Set form id, required to configure.
	 * Form id is used to identify session data, error messages,
	 * csrf tokens, html form attribute id value and much more.
	 * @requires
	 * @param string $id
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetId ($id = '') {
		$this->Id = $id;
		return $this;
	}
	/**
	 * Set supporting javascript files configuration.
	 * All previously configured supporting javascripts will be replaced.
	 * Set it as array with all necessary javascript contructors and file paths to add
	 * into html response after form is rendered by contained fields.
	 * Every record in this field has to be defined as array with:
	 *	 0 - string - supporting javascript file relative path
	 *	 1 - string - supporting javascript full class name inside supporting file
	 *	 2 - array - supporting javascript constructor params
	 * @param array $jsFilesClassesAndConstructorParams
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetJs (array $jsFilesClassesAndConstructorParams = array()) {
		$this->Js = array();
		foreach ($jsFilesClassesAndConstructorParams as $item) {
			$this->AddJs($item[0], $item[1], $item[2]);
		}
		return $this;
	}
	/**
	 * Set javascript external files renderer. If any callable is set, it has
	 * to accept first param to be SplFileInfo about extenal supporting javascript file.
	 * Javascript renderer has to add supporting javascript file only once into html
	 * output result in any custom way, it is it's responsibility.
	 * @param callable $jsRenderer
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetJsRenderer (callable $jsRenderer) {
		$this->JsRenderer = $jsRenderer;
		return $this;
	}
	/**
	 * Set $form->Lang, usualy used to complete optional translator language argument automaticly.
	 * If you are operating in multilanguage project and you want to use
	 * translator in \MvcCore\Ext\Form, set $form->Lang property to desired language code
	 * you want to translate every visible text into it. Use this property
	 * with $form->Translator and $form->Translate properties;
	 * @param string $lang
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetLang ($lang = '') {
		$this->Lang = $lang;
		return $this;
	}
	/**
	 * Set $form->Locale, usualy used to create proper validator for zip codes, currencies etc...
	 * If you are operating in multilanguage project and you want to use
	 * form field validators for locale specific needs in \MvcCore\Ext\Form,
	 * set $form->Locale property to desired international locale code
	 * you want to use proper validator functionality.
	 * @param string $locale
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetLocale ($locale = '') {
		$this->Locale = strtoupper($locale);
		return $this;
	}

	/**
	 * Set form http submitting method.
	 * `POST` by default.
	 * @param string $method
	 * @return \MvcCore\Ext\Form
	 */
    public function & SetMethod ($method = '') {
		$this->Method = $method;
		return $this;
	}
	/**
	 * Set next step url string, relative or absolute, to specify, where
	 * user will be redirected after form will be submitted successfully
	 * and submit button will be recognized to switch $form->Result value to value 2,
	 * which means next step redirection after successfull submit. This functionality
	 * to switch to value 2 is up to you. This field is designed only for you as empty.
	 * It's not required to use \MvcCore\Ext\Form like this, but if you want to use method
	 * $form->RedirectAfterSubmit(); at the end of custom Submit method implementation,
	 * and you want to go to next step by one button or stay in the same page by
	 * another form submit button, this is very good and comfortable pattern.
	 * @param string $url
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetNextStepUrl ($url = '') {
		$this->NextStepUrl = $url;
		return $this;
	}
	/**
	 * Default required attribute for all fields in form.
	 * It this global required setter is configured to TRUE,
	 * every field with no required configuration after adding
	 * into form instance is configured automaticly by this efault property
	 * as required. Default values is FALSE, means not required fields in all forms by default.
	 * @param bool $required
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetRequired ($required = TRUE) {
		$this->Required = $required;
		return $this;
	}

	/**
	 * Set success url string, relative or absolute, to specify, where
	 * to redirect user after form submitted successfully.
	 * It's not required to use `\MvcCore\Ext\Form` like this, but if you want to use method
	 * `$form->RedirectAfterSubmit();` at the end of custom `Submit()` method implementation,
	 * you need to specify at least success and error url strings.
	 * @param string $url
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetSuccessUrl ($url = '') {
		$this->SuccessUrl = $url;
		return $this;
	}
	/**
	 * Set form custom template relative path without .phtml extension.
	 * By default $form->TemplatePath is an empty string, which means there will be used no template and form
	 * will be rendered naturaly, one field by one without any breaking line html element.
	 * If there is any path defined, it has to be defined relatively from directory '/App/Views/Scripts'
	 * to desired template.
	 * @param string $path
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetTemplatePath ($path = '') {
		$this->TemplatePath = str_replace('\\', '/', $path);
		return $this;
	}
	/**
	 * Set $form->TemplateTypePath property, where current form templates will be located.
	 * By default, all form templates are located in '/App/Views/Scripts', if you want to change it,
	 * you can set this property for example to 'Forms' to define base directory for form templates to
	 * /App/Views/Forms' or by defining this property to '../Forms' to '/App/Forms' etc...
	 * @param string $typePath
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetTemplateTypePath ($typePath = '') {
		$this->TemplateTypePath = str_replace('\\', '/', $typePath);
		return $this;
	}
	/**
	 * Set TRUE to translate everything visible in form.
	 * Control placeholders, label texts and error messages.
	 * If you are configuring your form to be translated, there is also necessary to
	 * set $form->Translator callable to translate everything with it by method
	 * $form->SetTranslator();.
	 * Default values is NULL, means no translations will
	 * be processed it no Translator callable is set.
	 * @param bool $translate
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetTranslate ($translate = TRUE) {
		$this->Translate = $translate;
		return $this;
	}

	/**
	 * Set translator callable to translate everything visible in form.
	 * Handler is necessary to design with first param to be a translation key,
	 * second param to be a language code and hadler has to return translated string result.
	 * This property is optional to configure, but if it is configured to any callable,
	 * everything in form will be translated, except fields strictly defined to not translate.
	 * Default value is `NULL`, it means no translation will be processed.
	 * @param callable $handler
	 * @return \MvcCore\Ext\Form
	 */
	public function & SetTranslator (callable $translator = NULL) {
		$this->Translate = is_callable($translator);
		if ($this->Translate) {
			$this->Translator = $translator;
		} else {
			$this->Translator = NULL;
		}
		return $this;
	}
}
