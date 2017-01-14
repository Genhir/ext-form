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
require_once('Base.php');

class SimpleForm_Core_Helpers
{
	const CTRL_VIEW_PROVIDER_METHOD = 0;
	const CTRL_VIEW_PROVIDER_PROPERTY = 1;

	const SESSION_PROVIDER_INSTANCE = 0;
	const SESSION_PROVIDER_STATIC = 1;

	/**
	 * Cofiguration how to get view object from controller object
	 * @var array
	 */
	public static $ControllerViewProvider = array(
		'type'		=> self::CTRL_VIEW_PROVIDER_METHOD,
		'getter'	=> 'GetView',
	);
	/**
	 * Basic $_SESSION array as session service configuration.
	 * @var array
	 */
	public static $SessionProvider = array(
		'type'		=> self::SESSION_PROVIDER_STATIC,
		'callable'	=> array(__CLASS__, 'getSimpleSessionRecord'),
		'expirator'	=> '',
		'expiration'=> 0,
	);

	/**
	 * Forms default values storage.
	 * @var stdClass
	 */
	protected static $sessionData = NULL;
	/**
	 * Forms cross site request forgery protecting hashes storage.
	 * @var stdClass
	 */
	protected static $sessionCsrf = NULL;
	/**
	 * Forms error messages storage.
	 * @var stdClass
	 */
	protected static $sessionErrors = NULL;
	/**
	 * Session services configurations by existing classes as keys
	 * @var array
	 */
	protected static $sessionProviders = array(
		'MvcCore_Session'	=> array(
			'type'			=> self::SESSION_PROVIDER_STATIC,
			'callable'		=> array('MvcCore_Session', 'GetNamespace'),
			'expirator'		=> 'setExpirationSeconds',
			'expiration'	=> 32872500, // (60 * 60 * 24 * 365.25) -> year
		),
		'Zend_Session'		=> array(
			'type'			=> self::SESSION_PROVIDER_INSTANCE,
			'class'			=> 'Zend_Session_Namespace',
			'expirator'		=> 'setExpirationSeconds',
			'expiration'	=> 32872500, // (60 * 60 * 24 * 365.25) -> year
		),
	);

	/**
	 * Static initialization - called at the class end.
	 * @return void
	 */
	public static function StaticInit () {
		foreach (static::$sessionProviders as $detectedClass => & $configuration) {
			if (class_exists($detectedClass)) {
				static::$SessionProvider = $configuration;
				break;
			}
		}
	}

	/* common helpers ********************************************************************/

	public static function ValidateMaxPostSizeIfNecessary(SimpleForm & $form) {
		if (strtolower($form->Method) != 'post') return;
		$maxSize = ini_get('post_max_size');
		if (empty($_SERVER['CONTENT_LENGTH'])) {
			$form->AddError(
				sprintf(SimpleForm::$DefaultMessages[SimpleForm::EMPTY_CONTENT], $maxSize)
			);
			$form->Result = SimpleForm::RESULT_ERRORS;
		}
		$units = array('k' => 10, 'm' => 20, 'g' => 30);
		if (isset($units[$ch = strtolower(substr($maxSize, -1))])) {
			$maxSize <<= $units[$ch];
		}
		if ($maxSize > 0 && isset($_SERVER['CONTENT_LENGTH']) && $maxSize < $_SERVER['CONTENT_LENGTH']) {
			$form->AddError(
				sprintf(SimpleForm::$DefaultMessages[SimpleForm::MAX_POST_SIZE], $maxSize)
			);
			$form->Result = SimpleForm::RESULT_ERRORS;
		}
	}

	/* controller -> view ************************************************************/

	/**
	 * Get view object from controller object by local configuration.
	 * @param mixed $controller 
	 * @return mixed
	 */
	public static function GetControllerView (& $controller) {
		$result = NULL;
		$type = static::$ControllerViewProvider['type'];
		$getter = static::$ControllerViewProvider['getter'];
		if ($type == self::CTRL_VIEW_PROVIDER_PROPERTY) {
			$result = $controller->{$getter};
		} else if ($type == self::CTRL_VIEW_PROVIDER_METHOD) {
			$result = $controller->{$getter}();
		}
		return $result;
	}

	/* session ***********************************************************************/

	/**
	 * Get form default values by form id.
	 * @param string $formId 
	 * @return array
	 */
	public static function GetSessionData ($formId = '') {
		$sessionData = & static::setUpSessionData();
		if ($formId && isset($sessionData->$formId)) {
			$rawResult = $sessionData->$formId;
			return $rawResult;
		} else {
			return array();
		}
	}
	/**
	 * Get form cross site request forgery protecting hashes as array by form id.
	 * @param string $formId
	 * @return array
	 */
	public static function GetSessionCsrf ($formId = '') {
		$sessionCsrf = & static::setUpSessionCsrf();
		if ($formId && isset($sessionCsrf->$formId)) {
			$rawResult = $sessionCsrf->$formId;
			return $rawResult;
		} else {
			return array();
		}
	}
	/**
	 * Get form error messages by form id, if there are any keys in array,
	 * keys are representing form field names. If there are no keys, messages
	 * have common meaning for whole form.
	 * @param string $formId
	 * @return array
	 */
    public static function GetSessionErrors ($formId = '') {
		$sessionErrors = & static::setUpSessionErrors();
		if ($formId && isset($sessionErrors->$formId)) {
			$rawResult = $sessionErrors->$formId;
			return $rawResult;
		} else {
			return array();
		}
	}
	/**
	 * Set form default values by form id into session.
	 * @param string $formId 
	 * @param array $data 
	 */
	public static function SetSessionData ($formId = '', $data = array()) {
		$sessionData = & static::setUpSessionData();
		if ($formId) $sessionData->$formId = $data;
	}
	/**
	 * Set form cross site request forgery values by form id into session.
	 * @param string $formId
	 * @param array $data
	 */
	public static function SetSessionCsrf ($formId = '', $csrf = array()) {
		$sessionCsrf = & static::setUpSessionCsrf();
		if ($formId) $sessionCsrf->$formId = $csrf;
	}
	/**
	 * Set form error messages by form id into session.
	 * @param string $formId
	 * @param array $data
	 */
	public static function SetSessionErrors ($formId = '', $errors = array()) {
		$sessionErrors = & static::setUpSessionErrors();
		if ($formId) $sessionErrors->$formId = $errors;
	}

	/***********************************************************************************/

	protected static function & setUpSessionData () {
		if (static::$sessionData == NULL) static::$sessionData = static::getSessionNamespace('SimpleForm_Data');
		return static::$sessionData;
	}
	protected static function & setUpSessionCsrf () {
		if (static::$sessionCsrf == NULL) static::$sessionCsrf = static::getSessionNamespace('SimpleForm_Csrf');
		return static::$sessionCsrf;
	}
	protected static function & setUpSessionErrors () {
		if (self::$sessionErrors == NULL) static::$sessionErrors = static::getSessionNamespace('SimpleForm_Errors');
		return self::$sessionErrors;
	}
	protected static function & getSessionNamespace ($namespace) {
		$type = static::$SessionProvider['type'];
		if ($type == self::SESSION_PROVIDER_INSTANCE) {
			$class = static::$SessionProvider['class'];
			$result = new $class($namespace);
		} else if ($type == self::SESSION_PROVIDER_STATIC) {
			$result = call_user_func(static::$SessionProvider['callable'], $namespace);
		}
		$expirator = static::$SessionProvider['expirator'];
		$expiration = static::$SessionProvider['expiration'];
		// do not use this, because all page elements should be requested throw php script in MvcCore package, including all assets
		// $result->SetExpirationHoops(1);
		if ($expirator && $expiration) $result->$expirator($expiration);
		return $result;
	}
	protected static function & getSimpleSessionRecord ($namespace) {
		if (!(isset($_SESSION[$namespace]) && !is_null($_SESSION[$namespace]))) {
			$_SESSION[$namespace] = new stdClass;
		}
		return $_SESSION[$namespace];
	}
}
