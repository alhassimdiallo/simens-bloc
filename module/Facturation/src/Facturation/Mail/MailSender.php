<?php

namespace Facturation\Mail;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Message;


class MailSender
{
	
	protected static $transport = null;

	public static function initialize($params)
	{
		static::$transport = new SmtpTransport();
// 		static::$transport->setOptions(new SmtpOptions(array(
// 			'name' => $params['name'],
// 			'host' => $params['host'],
// 			'port' => $params['port'],		
// 		)));

		$options = new SmtpOptions(array(
				'name' => 'localhost',
				'host' => '127.0.0.1',
				'port' => 25,
		));

		static::$transport->setOptions($options);
		
	}
	
	Public function send($sender, $sender_name, $to, $to_name, $subject, $body)
	{
		$mail = new Message();
		$mail->setBody($body);
		$mail->setFrom('alkhassimdiallo@hotmail.fr' );
		$mail->addTo('alhassimdiallobe@gmail.com');
		$mail->setSubject($subject);
		//var_dump($mail); exit();
		static::$transport->send($mail);
	}
	
}
