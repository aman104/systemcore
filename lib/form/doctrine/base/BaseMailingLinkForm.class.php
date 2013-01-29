<?php

/**
 * MailingLink form base class.
 *
 * @method MailingLink getObject() Returns the current form's model object
 *
 * @package    SystemCore
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailingLinkForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'mailing_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mailing'), 'add_empty' => false)),
      'source'     => new sfWidgetFormInputText(),
      'link'       => new sfWidgetFormInputText(),
      'click'      => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mailing_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Mailing'))),
      'source'     => new sfValidatorString(array('max_length' => 255)),
      'link'       => new sfValidatorString(array('max_length' => 255)),
      'click'      => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'MailingLink', 'column' => array('link')))
    );

    $this->widgetSchema->setNameFormat('mailing_link[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailingLink';
  }

}
