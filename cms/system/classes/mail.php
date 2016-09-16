<?php

include_once 'libs/php_mailer/phpmailer.php';
include_once 'libs/php_mailer/smtp.php';

class Mail extends PHPMailer {

private $config = array();

public function __construct(){

	$conf_exampler = array('myIncomeMailbox', 'fromMailbox', 'FromName', 'mySubject', 'recipientSubject', 'useSMTP', 'SMTPHost', 'SMTPAuth', 'SMTPUsername', 'SMTPPassword', 'SMTPSecure', 'SMTPPort', 'SMTPDebug');
	
	if(!($config_data = parse_ini_file(path(inc, 'formmail.ini')))) throw new Exception('Mail configuration failed!');

	foreach ($conf_exampler as $key) { 
	
		if(!isset($config_data[$key])) throw new Exception('Can`t find mail configuration item ('.$key.')!');
	
	}
	
	// Enable verbose debug output
	if($config_data['SMTPDebug'] > 0) $this->SMTPDebug = $config_data['SMTPDebug'];
	
	if(isset($config_data['useSMTP']) && $config_data['useSMTP']) {
	
		// Set mailer to use SMTP
		$this->isSMTP();
		// Specify main and backup SMTP servers
		$this->Host = $config_data['SMTPHost'];
		// Enable SMTP authentication
		$this->SMTPAuth = $config_data['SMTPAuth'] ? true : false;
		// SMTP username
		$this->Username = $config_data['SMTPUsername'];
		// SMTP password
		$this->Password = $config_data['SMTPPassword'];
		// Enable TLS encryption, `ssl` also accepted
		$this->SMTPSecure = $config_data['SMTPSecure'];
		// TCP port to connect to
		$this->Port = $config_data['SMTPPort'];

	}

	$this->From = $config_data['fromMailbox'];
	$this->FromName = $config_data['FromName'];

	// Set email format to HTML
	$this->isHTML(true);
	
	$this->config = $config_data;
	unset($config_data);

}

// Если хотим отправить письмо себе
public function sendMailToMe($data=array()){

    $this->all_recipients = array();
	$this->to = array();

	$this->addAddress($this->config['myIncomeMailbox'], $this->config['FromName']);
	
	$this->Subject = $this->config['mySubject'];

	if(!$html_body = getTplContents(path(inc, 'html_tpl', 'letter_tpl', 'html_1_'.user_lang.'.php'), $data)) throw new Exception('Can`t load mail body!');
	$this->Body    = $html_body;
	
	if($text_body = getTplContents(path(inc, 'html_tpl', 'letter_tpl', 'text_1_'.user_lang.'.php'), $data))
	$this->AltBody = $text_body;
	
	return $this->send();

}

// Если хотим отправить письмо заполнителю формы
public function sendMailToRecipient($toMail, $forName=null, $data=array()){

    $this->all_recipients = array();
	$this->to = array();

	$this->addAddress($toMail, $forName);
	
	$this->Subject = $this->config['recipientSubject'];
	
	if(!$html_body = getTplContents(path(inc, 'html_tpl', 'letter_tpl', 'html_2_'.user_lang.'.php'), $data)) throw new Exception('Can`t load mail body!');
	$this->Body    = $html_body;
	
	if($text_body = getTplContents(path(inc, 'html_tpl', 'letter_tpl', 'text_2_'.user_lang.'.php'), $data))
	$this->AltBody = $text_body;
	
	return $this->send();

}

}