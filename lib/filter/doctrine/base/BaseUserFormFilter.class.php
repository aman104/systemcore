<?php

/**
 * User filter form base class.
 *
 * @package    SystemCore
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'username'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'api_token'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'api_secret' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'first_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'phone'      => new sfWidgetFormFilterInput(),
      'street'     => new sfWidgetFormFilterInput(),
      'post_code'  => new sfWidgetFormFilterInput(),
      'city'       => new sfWidgetFormFilterInput(),
      'country'    => new sfWidgetFormFilterInput(),
      'is_company' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'nip'        => new sfWidgetFormFilterInput(),
      'status'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'invoice_id' => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'username'   => new sfValidatorPass(array('required' => false)),
      'api_token'  => new sfValidatorPass(array('required' => false)),
      'api_secret' => new sfValidatorPass(array('required' => false)),
      'first_name' => new sfValidatorPass(array('required' => false)),
      'last_name'  => new sfValidatorPass(array('required' => false)),
      'email'      => new sfValidatorPass(array('required' => false)),
      'phone'      => new sfValidatorPass(array('required' => false)),
      'street'     => new sfValidatorPass(array('required' => false)),
      'post_code'  => new sfValidatorPass(array('required' => false)),
      'city'       => new sfValidatorPass(array('required' => false)),
      'country'    => new sfValidatorPass(array('required' => false)),
      'is_company' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'nip'        => new sfValidatorPass(array('required' => false)),
      'status'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'invoice_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'username'   => 'Text',
      'api_token'  => 'Text',
      'api_secret' => 'Text',
      'first_name' => 'Text',
      'last_name'  => 'Text',
      'email'      => 'Text',
      'phone'      => 'Text',
      'street'     => 'Text',
      'post_code'  => 'Text',
      'city'       => 'Text',
      'country'    => 'Text',
      'is_company' => 'Boolean',
      'nip'        => 'Text',
      'status'     => 'Number',
      'invoice_id' => 'Number',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
