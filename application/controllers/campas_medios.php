<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Heredamos de la clase CI_Controller */
class Campas_medios extends CI_Controller {

  function __construct()
  {
	
    parent::__construct();
	$this->load->helper('url');
	$this->load->model('modelo');
	$this->load->model('modelo_listado');
	
  }

  public function index()
  {    
    redirect('campas_medios/cargar');			
  }
  
  function cargar($id,$anio){
	    $anio=$anio; 
	  	
		$clasificaciones=$this->modelo->clasificaciones_campa();
		$total_clasificaciones=$clasificaciones->num_rows()-1;
	 	$i1=0;
		
		$campas=$this->modelo->montos_campas($anio);
		$total_campas=$campas->num_rows()-1;
	 	$i2=0;
		
		$costo_total_categoria=0;
		
		foreach($clasificaciones->result() as $fila) { 
		  	$costo_total_categoria=0;
			
	 		foreach($campas->result() as $fila2) {
				
				if($fila->descripcion_clasificacion==$fila2->descripcion_clasificacion){
						
				$costo_total_categoria=$costo_total_categoria+$fila2->costo_campa;
				}
	 		}
					
	 	}	
		$data['anio']=$anio;
	    $data['id_medio'] = $id;
	    $data['opcion'] = 'campas_medios';	
		$data['logo'] = $this->modelo->logo();
		$data['url_logo'] = $this->modelo->url_logo();
		$data['logo_opcional'] = $this->modelo->logo_opcional();
		$data['url_logo_opcional'] = $this->modelo->url_logo_opcional();
	  	$this->load->view('cabecera',$data);
		$data['clasificacion_medio']=$this->modelo->clasificacion_medio($id);
		$data['num_campas']=$this->modelo->campas_medios_realizadas($anio,$id);	
		$data['costototalmedio']=$this->modelo->clasificacion_gastos_tipo_medioc($anio,$id);
		
		$data['promedio_campas']=$this->modelo->costo_promedio_campa($anio);
		$data['monto_total_campas']=$this->modelo->monto_total_campas($anio);
		$data['anios_campas']=$this->modelo->anios_campas();
		$data['anio']=$anio;
		
		if($anio==date("Y"))
		$data['ultima_actualizacion']=$this->modelo->ultima_actualizacion_factura();
		
		$data['todas_campas']=$this->modelo_listado->lista_campas_medios($anio,$id);
		
  		$this->load->view('campas_medios',$data);	
		$this->load->view('pie');								
  } 
    
        
}