<?php

namespace WpOptionsManager;

class OptionsPostHandler {

  public $container;
  public $pluginMeta;
  public $optionsFlash;
  public $optionsValidator;

  public $postAction = null;
  public $redirectTo = '';
  public $didDeny = false;
  public $didQuit = false;
  public $denyReason = '';

  function needs() {
    return array('pluginMeta', 'optionsFlash', 'optionsValidator');
  }

  function enable() {
    add_action($this->getPostAction(), array($this, 'process'));
  }

  function process() {
    if ($this->isPOST() === false) {
      return $this->deny('not_post');
    }

    if ($this->isValidNonce() === false) {
      return $this->deny('invalid_nonce');
    }

    if ($this->isLoggedIn() === false) {
      return $this->deny('not_logged_in');
    }

    if ($this->hasOptionsAccess() === false) {
      return $this->deny('not_enough_permissions');
    }

    $this->validate();
    $this->redirect();
  }

  function getPostAction() {
    if (!is_null($this->postAction)) {
      return $this->postAction;
    }

    $optionsKey       = $this->pluginMeta->getOptionsKey();
    $this->postAction = "admin_post_$optionsKey-post";

    return $this->postAction;
  }

  function getNonceName() {
    $prefix = $this->getPostAction();
    $name = "$prefix-nonce";

    return str_replace('-', '_', $name);
  }

  function getNonceValue() {
    $key = $this->getNonceName();

    if (array_key_exists($key, $_POST)) {
      return $_POST[$key];
    } else {
      return '';
    }
  }

  function deny($reason = '') {
    $this->didDeny = true;
    $this->denyReason = $reason;

    if (!$this->isPHPUnit()) {
      wp_die('You do not have sufficient permissions to access this page.');
    }
  }

  function validate() {
    $valid = $this->optionsValidator->validate($_POST);

    if ($valid === true) {
      $this->saveSuccess();
    } else {
      $this->saveErrors($this->optionsValidator->errors());
    }
  }

  function redirect() {
    $this->redirectTo = $this->pluginMeta->getOptionsUrl();

    if (!$this->isPHPUnit()) {
      wp_redirect($this->redirectTo);
    }

    $this->quit();
  }

  function quit() {
    $this->didQuit = true;

    if (!$this->isPHPUnit()) {
      exit();
    }
  }

  function saveSuccess() {
    $json = array('success' => true);
    $this->optionsFlash->save($json);
  }

  function saveErrors($errors) {
    $json = array('errors' => $errors);
    $this->optionsFlash->save($json);
  }

  function isPOST() {
    return array_key_exists('REQUEST_METHOD', $_SERVER) && $_SERVER['REQUEST_METHOD'] === 'POST';
  }

  function isValidNonce() {
    return wp_verify_nonce(
      $this->getNonceValue(), $this->getPostAction()
    ) !== false;
  }

  function isLoggedIn() {
    return is_user_logged_in();
  }

  function hasOptionsAccess() {
    $capability = $this->pluginMeta->getOptionsCapability();
    return current_user_can($capability);
  }

  function isPHPUnit() {
    return defined('PHPUNIT_RUNNER');
  }

}
