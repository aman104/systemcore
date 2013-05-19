<?php

/**
 * Mailing form base class.
 *
 * @method Mailing getObject() Returns the current form's model object
 *
 * @package    SystemCore
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'title'               => new sfWidgetFormInputText(),
      'html'                => new sfWidgetFormInputText(),
      'text'                => new sfWidgetFormInputText(),
      'public'              => new sfWidgetFormInputText(),
      'name_from'           => new sfWidgetFormInputText(),
      'email_from'          => new sfWidgetFormInputText(),
      'settings'            => new sfWidgetFormInputText(),
      'css'                 => new sfWidgetFormInputText(),
      'status'              => new sfWidgetFormInputText(),
      'hash'                => new sfWidgetFormInputText(),
      'time_start'          => new sfWidgetFormDateTime(),
      'time_end'            => new sfWidgetFormDateTime(),
      'is_deleted'          => new sfWidgetFormInputCheckbox(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'mailing_lists_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MailingList')),
      'mailing_emails_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Email')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'title'               => new sfValidatorString(array('max_length' => 255)),
      'html'                => new sfValidatorPass(array('required' => false)),
      'text'                => new sfValidatorPass(array('required' => false)),
      'public'              => new sfValidatorPass(array('required' => false)),
      'name_from'           => new sfValidatorString(array('max_length' => 255)),
      'email_from'          => new sfValidatorString(array('max_length' => 255)),
      'settings'            => new sfValidatorPass(array('required' => false)),
      'css'                 => new sfValidatorPass(array('required' => false)),
      'status'              => new sfValidatorInteger(array('required' => false)),
      'hash'                => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'time_start'          => new sfValidatorDateTime(array('required' => false)),
      'time_end'            => new sfValidatorDateTime(array('required' => false)),
      'is_deleted'          => new sfValidatorBoolean(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'mailing_lists_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MailingList', 'required' => false)),
      'mailing_emails_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Email', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Mailing', 'column' => array('hash')))
    );

    $this->widgetSchema->setNameFormat('mailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mailing';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['mailing_lists_list']))
    {
      $this->setDefault('mailing_lists_list', $this->object->MailingLists->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['mailing_emails_list']))
    {
      $this->setDefault('mailing_emails_list', $this->object->MailingEmails->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveMailingListsList($con);
    $this->saveMailingEmailsList($con);

    parent::doSave($con);
  }

  public function saveMailingListsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['mailing_lists_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->MailingLists->getPrimaryKeys();
    $values = $this->getValue('mailing_lists_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('MailingLists', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('MailingLists', array_values($link));
    }
  }

  public function saveMailingEmailsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['mailing_emails_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->MailingEmails->getPrimaryKeys();
    $values = $this->getValue('mailing_emails_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('MailingEmails', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('MailingEmails', array_values($link));
    }
  }

}
