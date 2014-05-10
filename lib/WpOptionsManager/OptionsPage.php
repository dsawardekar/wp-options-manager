<?php

namespace WpOptionsManager;

class OptionsPage {

  public $container;
  public $pluginMeta;
  public $optionsStore;
  public $optionsFlash;
  public $optionsPostHandler;

  public $didSuccess = false;
  public $didErrors  = false;

  function needs() {
    return array(
      'pluginMeta',
      'optionsStore',
      'optionsFlash',
      'optionsPostHandler',
      'twigHelper'
    );
  }

  function register() {
    $this->registerOptionsPage();
    $this->optionsPostHandler->enable();
  }

  function registerOptionsPage() {
    $meta = $this->pluginMeta;

    add_options_page(
      $meta->getOptionsPageTitle(),
      $meta->getOptionsMenuTitle(),
      $meta->getOptionsCapability(),
      $meta->getOptionsMenuSlug(),
      array($this, 'show')
    );
  }

  function show() {
    $this->loadFlash();
    $this->showMessages();

    $this->twigHelper->display(
      $this->getTemplateName(),
      $this->getPageTemplateContext()
    );
  }

  function showMessages() {
    if ($this->didSuccess || $this->didErrors) {
      settings_errors();
    }
  }

  function getPageTemplateContext() {
    $context               = $this->getTemplateContext();
    $context['nonceField'] = wp_nonce_field(
      $this->optionsPostHandler->getPostAction(),
      $this->optionsPostHandler->getNonceName(),
      false, false
    );

    return $context;
  }

  function loadFlash() {
    $this->flash = $this->optionsFlash->loadAndClear();
    if ($this->flash === false) {
      return;
    }

    if (array_key_exists('success', $this->flash)) {
      $this->registerSuccess();
    } elseif (array_key_exists('errors', $this->flash)) {
      $this->registerErrors($this->flash['errors']);
    }
  }

  function registerSuccess() {
    add_settings_error(
      $this->pluginMeta->getOptionsKey(),
      $this->pluginMeta->getSlug(),
      'Settings Updated',
      'updated'
    );

    $this->didSuccess = true;
  }

  function registerErrors($errors) {
    foreach ($errors as $field => $messages) {
      $this->registerError($field, $messages);
    }

    $this->didErrors = true;
  }

  function registerError($field, $messages) {
    foreach ($messages as $message) {
      add_settings_error(
        $this->pluginMeta->getOptionsKey(),
        $this->pluginMeta->getSlug(),
        "Error: $message",
        'error'
      );
    }
  }

  /* abstract */
  function getTemplateName() {
    return 'options';
  }

  function getTemplateContext() {
    return array();
  }

}
