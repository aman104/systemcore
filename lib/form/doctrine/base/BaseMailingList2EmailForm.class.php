<?php

/**
 * MailingList2Email form base class.
 *
 * @method MailingList2Email getObject() Returns the current form's model object
 *
 * @package    SystemCore
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailingList2EmailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailing_list_id' => new sfWidgetFormInputHidden(),
      'email_id'        => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'phone'           => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'mailing_list_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('mailing_list_id')), 'empty_value' => $this->getObject()->get('mailing_list_id'), 'required' => false)),
      'email_id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('email_id')), 'empty_value' => $this->getObject()->get('email_id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'phone'           => new sfValidatorString(array('max_length' => 255)),
      'status'          => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mailing_list2_email[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailingList2Email';
  }

}
