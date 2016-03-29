<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Correos extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

    $data['titulo'] = 'Enviar Correos';
    $data['activo'] = '';
    $this->load->view('plantilla/header', $data);
    $this->load->view('correos/enviar', $data);
    $this->load->view('plantilla/footer');
  }

  public function enviar()
  {
    //cargamos la libreria email de ci
		$this->load->library("email");

		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.colpestalozzi.com',
			'smtp_port' => 465,
			'smtp_user' => 'secretaria@colpestalozzi.com',
			'smtp_pass' => 'Envi@rEmail2016',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);

		$this->email->from('Secretaría Pestalozzi');
		$this->email->to("byron-castro@hotmail.com");
		$this->email->subject('Bienvenido/a a uno-de-piera.com');
		$this->email->message('<h2>Email enviado con codeigniter haciendo uso del smtp de gmail</h2><hr><br> Bienvenido al blog');
		//$this->email->send();
		//con esto podemos ver el resultado
		//var_dump($this->email->print_debugger());

    if($this->email->send()){

            $data['title']='Mensaje Enviado';
            $data['msg'] = 'Mensaje enviado a su email';
                     // echo $this->email->print_debugger(); exit;
            //$this->load->view('send_email', $data);
              echo "Mensaje Enviado";
             }else{
                //$data['title']='El mensaje no se pudo enviar';
                //$this->load->view('send_email', $data);
                echo "El mensaje no de pudo enviar";
             }
  }

}
