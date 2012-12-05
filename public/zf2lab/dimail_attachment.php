<?php
require_once './autoloader.php';

use Zend\Mail\Message;
use Zend\Mail\Transport;
use Zend\Di\Di;
use Zend\Di\Config as DiConfig;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;

$diConfig = array('instance' => array(
    'Zend\Mail\Transport\FileOptions' => array(
        'parameters' => array(
            'path' => __DIR__,
        )
    ),
    'Zend\Mail\Transport\File' => array(
        'injections' => array(
            'Zend\Mail\Transport\FileOptions'
        )
    ),
    'Zend\Mail\Transport\SmtpOptions' => array(
        'parameters' => array(
            'name'              => 'sendgrid',
            'host'              => 'smtp.sendgrid.net',
            'port' => 25,
            'connectionClass'  => 'login',
            'connectionConfig' => array(
                'username' => 'allo.vince@gmail.com',
                'password' => 'password',
            ),
        )
    ),
    'Zend\Mail\Message' => array(
        'parameters' => array(
            'headers' => 'Zend\Mail\Headers',
            'encoding' => 'utf-8',
            'Zend\Mail\Message::setTo:emailOrAddressList' => 'allo.vince@gmail.com',
            'Zend\Mail\Message::setTo:name' => 'EvaEngine',
            'Zend\Mail\Message::setFrom:emailOrAddressList' => 'info@evaengine.com',
            'Zend\Mail\Message::setFrom:name' => 'EvaEngine',
        )
    ),
    'Zend\Mail\Transport\Smtp' => array(
        'injections' => array(
            'Zend\Mail\Transport\SmtpOptions'
        )
    ),
));

$di = new Di();
$di->configure(new DiConfig($diConfig));

$transport = $di->get('Zend\Mail\Transport\Smtp');
//$transport = $di->get('Zend\Mail\Transport\Sendmail');
$transport = $di->get('Zend\Mail\Transport\File');
$message = $di->get('Zend\Mail\Message');


$mimeMessage = new MimeMessage();
$messageText = new Part('Mail Content');
$messageText->type = 'text/html';


//$data = file_get_contents('ee.png');
//$data = base64_encode($data);

$data = fopen('loading.jpg', 'r');
$messageAttachment = new Part($data);
$messageAttachment->type = 'image/jpg';
$messageAttachment->filename = 'loading.jpg';
$messageAttachment->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
$messageAttachment->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;


$file = iconv("UTF-8","gb2312", '新建文本文档.txt');
$data = fopen($file, 'r');
$messageTextAttachment = new Part($data);
$messageTextAttachment->filename = '新建文本文档.txt';
$messageTextAttachment->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
$messageTextAttachment->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;

$mimeMessage->setParts(array(
    $messageText,
    $messageAttachment,
    $messageTextAttachment,
));


$message->setSubject("Mail Subject with Attachment")
        ->setBody($mimeMessage);
$transport->send($message);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="" lang="">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8" />
    <title>Text</title>
</head>
</html>
