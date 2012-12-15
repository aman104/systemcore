<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    SystemCore
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'username'   => new sfWidgetFormInputText(),
      'api_token'  => new sfWidgetFormInputText(),
      'api_secret' => new sfWidgetFormInputText(),
      'first_name' => new sfWidgetFormInputText(),
      'last_name'  => new sfWidgetFormInputText(),
      'email'      => new sfWidgetFormInputText(),
      'phone'      => new sfWidgetFormInputText(),
      'street'     => new sfWidgetFormInputText(),
      'post_code'  => new sfWidgetFormInputText(),
      'city'       => new sfWidgetFormInputText(),
      'country'    => new sfWidgetFormInputText(),
      'is_company' => new sfWidgetFormInputCheckbox(),
      'nip'        => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormInputText(),
      'invoice_id' => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'username'   => new sfValidatorString(array('max_length' => 255)),
      'api_token'  => new sfValidatorString(array('max_length' => 255)),
      'api_secret' => new sfValidatorString(array('max_length' => 255)),
      'first_name' => new sfValidatorString(array('max_length' => 255)),
      'last_name'  => new sfValidatorString(array('max_length' => 255)),
      'email'      => new sfValidatorString(array('max_length' => 255)),
      'phone'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'street'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'post_code'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_company' => new sfValidatorBoolean(array('required' => false)),
      'nip'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'     => new sfValidatorInteger(array('required' => false)),
      'invoice_id' => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('username'))),
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('api_token'))),
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('api_secret'))),
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('email'))),
      ))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
