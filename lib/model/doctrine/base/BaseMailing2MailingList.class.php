<?php

/**
 * BaseMailing2MailingList
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $mailing_id
 * @property integer $mailing_list_id
 * @property MailingList $MailingList
 * @property Mailing $Mailing
 * 
 * @method integer             getMailingId()       Returns the current record's "mailing_id" value
 * @method integer             getMailingListId()   Returns the current record's "mailing_list_id" value
 * @method MailingList         getMailingList()     Returns the current record's "MailingList" value
 * @method Mailing             getMailing()         Returns the current record's "Mailing" value
 * @method Mailing2MailingList setMailingId()       Sets the current record's "mailing_id" value
 * @method Mailing2MailingList setMailingListId()   Sets the current record's "mailing_list_id" value
 * @method Mailing2MailingList setMailingList()     Sets the current record's "MailingList" value
 * @method Mailing2MailingList setMailing()         Sets the current record's "Mailing" value
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMailing2MailingList extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mailing2_mailing_list');
        $this->hasColumn('mailing_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('mailing_list_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('MailingList', array(
             'local' => 'mailing_list_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Mailing', array(
             'local' => 'mailing_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}