<?php

/**
 * BaseConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $record
 * @property text $value
 * 
 * @method string getRecord() Returns the current record's "record" value
 * @method text   getValue()  Returns the current record's "value" value
 * @method Config setRecord() Sets the current record's "record" value
 * @method Config setValue()  Sets the current record's "value" value
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseConfig extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('config');
        $this->hasColumn('record', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('value', 'text', null, array(
             'type' => 'text',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}