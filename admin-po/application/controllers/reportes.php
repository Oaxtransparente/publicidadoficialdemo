<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

  function __construct()
  {
	
    parent::__construct();
	$this->load->helper('url');
	$this->load->library(array('session'));
	
	if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'administrador')
    {
       redirect(base_url().'index.php/login');
    }
		
  }

  function index()
  {    
    redirect('reportes/imprimir');			
  }
  
  function imprimir(){
	  $data['opcion'] = 'reportes';	  
	  $this->load->view('cabecera', $data);	 
	  $this->load->view('pie');	 
  }
  
}