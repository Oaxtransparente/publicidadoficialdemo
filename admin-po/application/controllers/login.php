<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->rand = random_string('alnum', 6);	
		$this->load->model('captcha_modelo');
        $this->load->model('login_modelo');
		$this->load->model('modelo');
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','form'));
        $this->load->database();
    }
    
    public function index()
    {    
        switch ($this->session->userdata('perfil')) {
            case '':
                $data['token'] = $this->token();
                $data['titulo'] = '';
				$data['logo'] = $this->modelo->logo();
				$data['url_logo'] = $this->modelo->url_logo();
				$data['logo_opcional'] = $this->modelo->logo_opcional();
				$data['url_logo_opcional'] = $this->modelo->url_logo_opcional();								
		
				$this->load->view('logos',$data);				
				$data = array('titulo' => '','captcha' => $this->captcha());
				$this->session->set_userdata('captcha', $this->rand);
				
                $this->load->view('login',$data);				
				$this->load->view('pie');
                break;
            case 'administrador':
                redirect(base_url().'index.php/medios');
                break;
            default:        
                $data['titulo'] = 'Login con roles de usuario en codeigniter';
                $this->load->view('login',$data);
                break;        
        }
    }
    
    public function token()
    {
        $token = md5(uniqid(rand(),true));
        $this->session->set_userdata('token',$token);
        return $token;
    }
    
    public function autentificar()
    {				
        if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
        {
            
			
			$this->form_validation->set_rules('username', 'nombre de usuario', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
 
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }else{
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $check_user = $this->login_modelo->login_user($username,$password);
								
                if($check_user == TRUE && $this->send_form() == TRUE)
                {
                    $data = array(
                    'is_logued_in'     =>         TRUE,
                    'id_usuario'     =>         $check_user->id,
                    'perfil'        =>        $check_user->perfil,
                    'username'         =>         $check_user->username
                    );        
                    $this->session->set_userdata($data);
                    $this->index();
                }
				
				else{
					echo $check_user;
					redirect(base_url().'index.php/login');
				}
				
            }
        }else{
            redirect(base_url().'index.php/login');
        }
    }
 
    public function salir()
    {
        $this->session->sess_destroy();
        redirect(base_url().'index.php/login');
    }
	
	
	
	
	
	
	
	
	 public function captcha()
	{
		//configuramos el captcha
		$conf_captcha = array(
			'word'   => $this->rand,
			'img_path' => './captcha/',
			'img_url' =>  base_url().'captcha/',
			'font_path' => './fonts/AlfaSlabOne-Regular.ttf',
			'img_width' => '250',
			'img_height' => '60', 
			'expiration' => 600 
		);

		$cap = create_captcha($conf_captcha);
		$this->captcha_modelo->insert_captcha($cap);
		return $cap;
	}

	public function send_form()
	{

		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');
		
		if($this->form_validation->run() == false)
		{

			return false;

		}else{

			$expiration = time()-600; // Límite de 10 minutos 
			$ip = $this->input->ip_address();//ip del usuario
			$captcha = $this->input->post('captcha');
			$this->captcha_modelo->remove_old_captcha($expiration);
			
			$check = $this->captcha_modelo->check($ip,$expiration,$captcha);

			if($check == 1)
			{
				return true;
			}

		}		

	}
	
	
	public function validate_captcha()
	{

	    if($this->input->post('captcha') != $this->session->userdata('captcha'))
	    {
	        $this->form_validation->set_message('validate_captcha', 'Error');
	        return false;
	    }else{
	        return true;
	    }

	}
	
	
}