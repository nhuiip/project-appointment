<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {

	var $template_data = array();

	function __construct($config = array()){
		$this->CI =& get_instance();
		if ( ! empty($config))
		{
			$this->initialize($config);
		}
		$this->title($config['title']);
		log_message('debug', 'Template Class Initialized');
	}

	private function initialize($config = array()){
		foreach ($config as $key => $val)
		{
			$this->{'_'.$key} = $val;
		}
	}

	private function set($name, $value){
		$this->template_data[$name] = $value;
	}

	private function set_theme($data = array()){
		if(! empty($data)){
			foreach ($data as $key => $value) {
				switch ($key) {
					case 'title':
						$this->title($value);
						break;
				    case 'js':
				        $this->js($value);
				        break;
				    case 'css':
				        $this->css($value);
				        break;
				    case 'frontend':
				    	$view = '';
				    	$view_data = array();
				    	$return = FALSE;
				    	if(! empty($value[0])) $view = $value[0];
				    	if(! empty($value[1])) $view_data = $value[1];
				    	if(! empty($value[2])) $return = $value[2];
				    	$this->frontend($view,$view_data,$return);
				    	break;
				    case 'backend':
				    	$view = '';
				    	$view_data = array();
				    	$return = FALSE;
				    	if(! empty($value[0])) $view = $value[0];
				    	if(! empty($value[1])) $view_data = $value[1];
				    	if(! empty($value[2])) $return = $value[2];
				    	$this->backend($view,$view_data,$return);
				    	break;
				}
			}
		}
	}

	public function load($template = '', $view = '' , $view_data = array(), $return = FALSE){
		$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
		return $this->CI->load->view($template, $this->template_data, $return);
	}

	public function js($data = array()){
		if(! empty($data)){
			$js = NULL;

			foreach ($data as $key => $value) {
				$js.= '<script type="text/javascript" src="'.$value.'.js"></script>';
			}
			$this->set('js',$js);
		}
	}

	public function css($data = array()){
		if(! empty($data)){
			$css = NULL;
			foreach ($data as $key => $value) {
				$css.= '<link href="'.$value.'.css" rel="stylesheet" />';
			}
			$this->set('css',$css);
		}
	}

	public function tagfacebook($data = array()){
		if(! empty($data)){
			$tagfacebook = NULL;
			foreach ($data as $key => $value) {
				$tagfacebook.= '<meta property="'.$key.'" content="'.$value.'" />';
			}
			$this->set('tagfacebook',$tagfacebook);
		}
	}

	public function title($title = NULL){
		if(! empty($title)){
			$this->set('title',$title);
		}
	}

	public function frontend($view = '' , $view_data = array(), $return = FALSE){
		$template = $this->_theme_locations.$this->_theme_frontend;
		$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
		return $this->CI->load->view($template, $this->template_data, $return);
	}

	public function backend($view = '' , $view_data = array(), $return = FALSE){
		$template = $this->_theme_locations.$this->_theme_backend;
		$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
		return $this->CI->load->view($template, $this->template_data, $return);
	}
	/**
	* Note
	* $this->title(value) : Set title html.
	* $this->js(array(filename)) : Import file Javascript.
	* $this->css(array(filename)) : Import file css.
	* $this->frontend(pageview) : Show page view for theme frontend. You can config theme frontend. config/template.php config['theme_fronend']
	* $this->backend(pageview) : Show page view for theme backend. You can config theme frontend. config/template.php config['theme_backend']
	* $this->set_theme(array()) : You can set all function.
	*/
}