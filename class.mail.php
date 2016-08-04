<?php
define('SMTP_STATUS_NOT_CONNECTED', 1, TRUE);
define('SMTP_STATUS_CONNECTED', 2, TRUE);
class qb_smtp
{
    var $connection;
    var $recipients;
    var $headers;
    var $timeout;
    var $errors;
    var $status;
    var $body;
    var $from;
    var $host;
    var $port;
    var $helo;
    var $auth;
    var $user;
    var $pass;
    
    /**
     *  ����Ϊһ������
     *  host        SMTP ������������       Ĭ�ϣ�localhost
     *  port        SMTP �������Ķ˿�       Ĭ�ϣ�25
     *  helo        ����HELO���������      Ĭ�ϣ�localhost
     *  user        SMTP ���������û���     Ĭ�ϣ���ֵ
     *  pass        SMTP �������ĵ�½����   Ĭ�ϣ���ֵ
     *  timeout     ���ӳ�ʱ��ʱ��          Ĭ�ϣ�5
     *  @return  bool
     */
    
    function qb_smtp($params = array())
    {
        if(!defined('CRLF')) define('CRLF', "\r\n", TRUE);
        
        $this->timeout  = 5;
        $this->status   = SMTP_STATUS_NOT_CONNECTED;
        $this->host     = 'localhost';
        $this->port     = 25;
        $this->auth     = FALSE;
        $this->user     = '';
        $this->pass     = '';
        $this->errors   = array();
        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }
        
        $this->helo     = $this->host;
        //  ���û�������û�������֤        
        $this->auth = ('' == $this->user) ? FALSE : TRUE;
    }
    function connect($params = array())
    {
        if(!isset($this->status))
        {
            $obj = new qb_smtp($params);
            
            if($obj->connect())
            {
                $obj->status = SMTP_STATUS_CONNECTED;
            }
            return $obj;
        }
        else
        {
            
            $this->connection = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
            socket_set_timeout($this->connection, 0, 250000);
            $greeting = $this->get_data();
            
            if(is_resource($this->connection))
            {
                $this->status = 2;
                return $this->auth ? $this->ehlo() : $this->helo();
            }
            else
            {
                $this->errors[] = 'Failed to connect to server: '.$errstr;
                return FALSE;
            }
        }
    }
    
    /**
     * ����Ϊ����
     * recipients      �����˵�����
     * from            �����˵ĵ�ַ��Ҳ����Ϊ�ظ���ַ
     * headers         ͷ����Ϣ������
     * body            �ʼ�������
     */
    
    function send($params = array())
    {
        foreach($params as $key => $value)
        {
            $this->set($key, $value);
        }
        if($this->is_connected())
        {
            //  �������Ƿ���Ҫ��֤     
            if($this->auth)
            {
                if(!$this->auth()) return FALSE;
            }
            $this->mail($this->from);
            if(is_array($this->recipients))
            {
                foreach($this->recipients as $value)
                {
                    $this->rcpt($value);
                }
            }
            else
            {
                $this->rcpt($this->recipients);
            }
            if(!$this->data()) return FALSE;
            $headers = str_replace(CRLF.'.', CRLF.'..', trim(implode(CRLF, $this->headers)));
            $body    = str_replace(CRLF.'.', CRLF.'..', $this->body);
            $body    = $body[0] == '.' ? '.'.$body : $body;
            $this->send_data($headers);
            $this->send_data('');
            $this->send_data($body);
            $this->send_data('.');
            return (substr(trim($this->get_data()), 0, 3) === '250');
        }
        else
        {
            $this->errors[] = 'Not connected!';
            return FALSE;
        }
    }
    
    function helo()
    {
        if(is_resource($this->connection)
                AND $this->send_data('HELO '.$this->helo)
                AND substr(trim($error = $this->get_data()), 0, 3) === '250' )
        {
            return TRUE;
        }
        else
        {
            $this->errors[] = 'HELO command failed, output: ' . trim(substr(trim($error),3));
            return FALSE;
        }
    }
    
    
    function ehlo()
    {
        if(is_resource($this->connection)
                AND $this->send_data('EHLO '.$this->helo)
                AND substr(trim($error = $this->get_data()), 0, 3) === '250' )
        {
            return TRUE;
        }
        else
        {
            $this->errors[] = 'EHLO command failed, output: ' . trim(substr(trim($error),3));
            return FALSE;
        }
    }
    
    function auth()
    {
        if(is_resource($this->connection)
                AND $this->send_data('AUTH LOGIN')
                AND substr(trim($error = $this->get_data()), 0, 3) === '334'
                AND $this->send_data(base64_encode($this->user))            // Send username
                AND substr(trim($error = $this->get_data()),0,3) === '334'
                AND $this->send_data(base64_encode($this->pass))            // Send password
                AND substr(trim($error = $this->get_data()),0,3) === '235' )
        {
            return TRUE;
        }
        else
        {
            $this->errors[] = 'AUTH command failed: ' . trim(substr(trim($error),3));
            return FALSE;
        }
    }
    
    function mail($from)
    {
        if($this->is_connected()
            AND $this->send_data('MAIL FROM:<'.$from.'>')
            AND substr(trim($this->get_data()), 0, 2) === '250' )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    function rcpt($to)
    {
        if($this->is_connected()
            AND $this->send_data('RCPT TO:<'.$to.'>')
            AND substr(trim($error = $this->get_data()), 0, 2) === '25' )
        {
            return TRUE;
        }
        else
        {
            $this->errors[] = trim(substr(trim($error), 3));
            return FALSE;
        }
    }
    function data()
    {
        if($this->is_connected()
            AND $this->send_data('DATA')
            AND substr(trim($error = $this->get_data()), 0, 3) === '354' )
        { 
            return TRUE;
        }
        else
        {
            $this->errors[] = trim(substr(trim($error), 3));
            return FALSE;
        }
    }
    function is_connected()
    {
        return (is_resource($this->connection) AND ($this->status === SMTP_STATUS_CONNECTED));
    }
    function send_data($data)
    {
        if(is_resource($this->connection))
        {
            return fwrite($this->connection, $data.CRLF, strlen($data)+2);
        }
        else
        {
            return FALSE;
        }
    }
    function &get_data()
    {
        $return = '';
        $line   = '';
        if(is_resource($this->connection))
        {
            while(strpos($return, CRLF) === FALSE OR substr($line,3,1) !== ' ')
            {
                $line    = fgets($this->connection, 512);
                $return .= $line;
            }
            return $return;
        }
        else
        {
            return FALSE;
        }
    }
    function set($var, $value)
    {
        $this->$var = $value;
        return TRUE;
    }
} // End of class



class smtp
{
	var $debug;
	var $host;
	var $port;
	var $auth;
	var $user;
	var $pass;

	function smtp($host = "", $port = 25,$auth = false,$user,$pass){
		$this->host=$host;
		$this->port=$port;
		$this->auth=$auth;
		$this->user=$user;
		$this->pass=$pass;
	}

	function sendmail($to,$from, $subject, $content, $T=0){
		global $webdb;
		//$name, $email, $subject, $content, $type=0
		$type=1;
		//$name=array("�ǰ���������Ա");
		$email=array($to);
		$_CFG['smtp_host']= $this->host;
		$_CFG['smtp_port']= $this->port;
		$_CFG['smtp_user']= $this->user;
		$_CFG['smtp_pass']= $this->pass;
		$_CFG['name']= '88mq.net';
		$_CFG['smtp_mail']= $from;

		//$name = "=?UTF-8?B?".base64_encode($name)."==?=";
		$subject = "=?gbk?B?".base64_encode($subject)."==?=";
		$content = base64_encode($content);
		$headers[] = "To:=?gbk?B?".''."?= <$email[0]>";//ԭΪbase64_encode($name[0])
		$headers[] = "From:=?gbk?B?".base64_encode($_CFG['name'])."?= <$_CFG[smtp_mail]>";
		$headers[] = "MIME-Version: Blueidea v1.0";
		$headers[] = "X-Mailer: 9gongyu Mailer v1.0";
		//$headers[] = "From:=?UTF-8?B?".base64_encode($_CFG['shop_name'])."==?=<$_CFG[smtp_mail]>";
		$headers[] = "Subject:$subject";
		$headers[] = ($type == 0) ? "Content-Type: text/plain; charset=gbk; format=flowed" : "Content-Type: text/html; charset=gbk; format=flowed";
		$headers[] = "Content-Transfer-Encoding: base64";
		$headers[] = "Content-Disposition: inline";
		//    SMTP ��������Ϣ
		$params['host'] = $_CFG['smtp_host'];
		$params['port'] = $_CFG['smtp_port'];
		$params['user'] = $_CFG['smtp_user'];
		$params['pass'] = $_CFG['smtp_pass'];
		if (empty($params['host']) || empty($params['port']))
		{
			// ���û�����������Ͷ˿�ֱ�ӷ��� false
			return false;
		}
		else
		{
			//  �����ʼ�
			$send_params['recipients']    = $email;
			$send_params['headers']        = $headers;
			$send_params['from']        = $_CFG['smtp_mail'];
			$send_params['body']        = $content;

			$smtp = new qb_smtp($params);
			if($smtp->connect() AND $smtp->send($send_params))
			{
				return TRUE;
			}
			else 
			{
				return FALSE;
			} // end if
		}
	}
}

?>