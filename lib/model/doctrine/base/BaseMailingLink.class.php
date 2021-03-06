<?php

/**
 * BaseMailingLink
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $mailing_id
 * @property string $source
 * @property string $link
 * @property integer $click
 * @property Mailing $Mailing
 * 
 * @method integer     getMailingId()  Returns the current record's "mailing_id" value
 * @method string      getSource()     Returns the current record's "source" value
 * @method string      getLink()       Returns the current record's "link" value
 * @method integer     getClick()      Returns the current record's "click" value
 * @method Mailing     getMailing()    Returns the current record's "Mailing" value
 * @method MailingLink setMailingId()  Sets the current record's "mailing_id" value
 * @method MailingLink setSource()     Sets the current record's "source" value
 * @method MailingLink setLink()       Sets the current record's "link" value
 * @method MailingLink setClick()      Sets the current record's "click" value
 * @method MailingLink setMailing()    Sets the current record's "Mailing" value
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMailingLink extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mailing_link');
        $this->hasColumn('mailing_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('source', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('link', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('click', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
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
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}