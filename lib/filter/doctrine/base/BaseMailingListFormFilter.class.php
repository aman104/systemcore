<?php

/**
 * MailingList filter form base class.
 *
 * @package    SystemCore
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailingListFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'name'          => new sfWidgetFormFilterInput(),
      'hash'          => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'mailings_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Mailing')),
    ));

    $this->setValidators(array(
      'user_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'name'          => new sfValidatorPass(array('required' => false)),
      'hash'          => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'mailings_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Mailing', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mailing_list_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addMailingsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Mailing2MailingList Mailing2MailingList')
      ->andWhereIn('Mailing2MailingList.mailing_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'MailingList';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'user_id'       => 'ForeignKey',
      'name'          => 'Text',
      'hash'          => 'Text',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'mailings_list' => 'ManyKey',
    );
  }
}
