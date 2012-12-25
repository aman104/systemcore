<?php

/**
 * Mailing2Email form base class.
 *
 * @method Mailing2Email getObject() Returns the current form's model object
 *
 * @package    SystemCore
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailing2EmailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailing_id' => new sfWidgetFormInputHidden(),
      'email_id'   => new sfWidgetFormInputHidden(),
      'status'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'mailing_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('mailing_id')), 'empty_value' => $this->getObject()->get('mailing_id'), 'required' => false)),
      'email_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('email_id')), 'empty_value' => $this->getObject()->get('email_id'), 'required' => false)),
      'status'     => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mailing2_email[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mailing2Email';
  }

}
