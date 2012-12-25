<?php

/**
 * Mailing filter form base class.
 *
 * @package    SystemCore
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'title'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'html'                => new sfWidgetFormFilterInput(),
      'text'                => new sfWidgetFormFilterInput(),
      'public'              => new sfWidgetFormFilterInput(),
      'settings'            => new sfWidgetFormFilterInput(),
      'status'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hash'                => new sfWidgetFormFilterInput(),
      'time_start'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'time_end'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'is_deleted'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'mailing_lists_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MailingList')),
      'mailing_emails_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Email')),
    ));

    $this->setValidators(array(
      'user_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'title'               => new sfValidatorPass(array('required' => false)),
      'html'                => new sfValidatorPass(array('required' => false)),
      'text'                => new sfValidatorPass(array('required' => false)),
      'public'              => new sfValidatorPass(array('required' => false)),
      'settings'            => new sfValidatorPass(array('required' => false)),
      'status'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hash'                => new sfValidatorPass(array('required' => false)),
      'time_start'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'time_end'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'is_deleted'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'mailing_lists_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MailingList', 'required' => false)),
      'mailing_emails_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Email', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mailing_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addMailingListsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('Mailing2MailingList.mailing_list_id', $values)
    ;
  }

  public function addMailingEmailsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Mailing2Email Mailing2Email')
      ->andWhereIn('Mailing2Email.email_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Mailing';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'user_id'             => 'ForeignKey',
      'title'               => 'Text',
      'html'                => 'Text',
      'text'                => 'Text',
      'public'              => 'Text',
      'settings'            => 'Text',
      'status'              => 'Number',
      'hash'                => 'Text',
      'time_start'          => 'Date',
      'time_end'            => 'Date',
      'is_deleted'          => 'Boolean',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'mailing_lists_list'  => 'ManyKey',
      'mailing_emails_list' => 'ManyKey',
    );
  }
}
