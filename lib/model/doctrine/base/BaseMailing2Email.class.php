<?php

/**
 * BaseMailing2Email
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $mailing_id
 * @property integer $email_id
 * @property integer $status
 * @property Mailing $Mailing
 * @property Email $Email
 * 
 * @method integer       getMailingId()  Returns the current record's "mailing_id" value
 * @method integer       getEmailId()    Returns the current record's "email_id" value
 * @method integer       getStatus()     Returns the current record's "status" value
 * @method Mailing       getMailing()    Returns the current record's "Mailing" value
 * @method Email         getEmail()      Returns the current record's "Email" value
 * @method Mailing2Email setMailingId()  Sets the current record's "mailing_id" value
 * @method Mailing2Email setEmailId()    Sets the current record's "email_id" value
 * @method Mailing2Email setStatus()     Sets the current record's "status" value
 * @method Mailing2Email setMailing()    Sets the current record's "Mailing" value
 * @method Mailing2Email setEmail()      Sets the current record's "Email" value
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMailing2Email extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mailing2_email');
        $this->hasColumn('mailing_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('email_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('status', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Mailing', array(
             'local' => 'mailing_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Email', array(
             'local' => 'email_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}