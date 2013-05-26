<?php

class sendMessagesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'system';
    $this->name             = 'sendMessages';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [sendMessages|INFO] task does things.
Call it with:

  [php symfony sendMessages|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $_SERVER['SERVER_NAME'] = 'sendmail24.pl';

    $mailings = MailingTable::getInstance()->findBy('status', '2');
    foreach($mailings as $mailing)
    {
      $mailing->sendEmails();
    }

    // add your code here
  }
}
