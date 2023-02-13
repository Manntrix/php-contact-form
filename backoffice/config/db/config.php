<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

require_once BASE_PATH . '../../../vendor/autoload.php';
require_once BASE_PATH . '../../inc/MysqliDb.php';
require_once BASE_PATH . '../../inc/helpers.php';

$rootpath = dirname(__DIR__, 3);

$dotenv = Dotenv\Dotenv::createImmutable($rootpath);
$dotenv->load();



// Create the Mailer using your created Transport


function send_mail($subject, $to, $from, $toname, $fromname, $body){
    $transport = (new Swift_SmtpTransport('smtp-relay.sendinblue.com', 587))
        ->setUsername('webtestjpr@gmail.com')
        ->setPassword('7xRY5Zz9GaySDwBL')
    ;
    $mailer = new Swift_Mailer($transport);
    $message = (new Swift_Message($subject))
        ->setFrom([$from => $fromname])
        ->setTo([$to, $to => $toname])
        ->setBody($body)
    ;
    $result = $mailer->send($message);
    return $result;
}



/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);

/**
 * Get instance of DB object
 */
function getDbInstance() {
	return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}