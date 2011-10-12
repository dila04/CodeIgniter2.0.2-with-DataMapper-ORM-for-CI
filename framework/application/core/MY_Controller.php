<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 *
 */
class MY_Controller extends CI_Controller
{
	public $view_dir; // controller view directory
	public $view_as_data = NULL; // an option not to display data in browser, instead it will be returned as string
	public $use_view_dir = TRUE; // an option to use controller view directory or call view directly from views directory
	private $layout_dir = 'layouts'; // default layouts directory
	private $the_layout_dir = '';
	private $layout = 'main';
	private $layout_variables = array();

	public function __construct()
	{
		parent::__construct();
		$this->loadFirePHP();
		$this->loadGA();
	}
	
	public function loadGA()
	{
		$class = $this->uri->segment(1);
		$method = $this->uri->segment(2);
		$postlike = $this->uri->segment(4);

		$this->load->config('ga');
		$ga = $this->config->item('ga');
		$ga_code = $this->config->item('ga_code');
		
		if ( count($ga) > 0)
		{
			if (!$class and !$method)
			{
				$ga_pagename = array('ga_pagename'=>'index');
			}else{
					$ga_pagename = $ga[$class][$method];
					$ga_pagename = array(
									'ga_pagename'=>$ga_pagename,
									'ga_code'=>$ga_code
									);
			}
			$this->setVars($ga_pagename);
		}
	}
	
	/**
	 * Improves $ci->load->view method by adding a separate directory view for each controller
	 *
	 * @param string $view_file file under a controllers directory view
	 * @param array $data holds all the values that will be passed to the view file
	 * @param boolean $view_as_data sets if the view data will render in the browser or will be return by the function
	 * @return view data will be returned instead of displaying in the browser
	*/ 
	public function render($view_file, $data=array(), $view_as_data=true)
	{
		// checks if class property $this->view_as_data is not set to null
		if ($this->view_as_data!==NULL)
		{
			// sets the function property $view_as_data value to class property $this->view_as_data
			$view_as_data = $this->view_as_data;
		}

		// checks if class property $this->use_view_dir is TRUE 
		if ($this->use_view_dir)
		{
			// checks if class property $this->view_dir has string value 
			if ($this->view_dir)
			{
				// set the local property $view_file as the controller view directory plus the $view_file parameter value
				$view_file = $this->view_dir . '/' . $view_file;
			}
		}

		// check if $data var has no elements and $this->layout_variables have
		if (count($data)<1 and count($this->layout_variables)>0)
		{
			// set $this->layout_variables to $data
			$data = $this->layout_variables;
		}
		// check if $data and $this->layout_variables have elements
		elseif (count($this->layout_variables)>0 and count($data)>0)
		{
			// merge $this->layout_variables to $data
			$data = array_merge($data,$this->layout_variables);
		}
		
		// returns as data if $view_as_data is true, else the page will be rendered in browser
		return $this->load->view($view_file, $data, $view_as_data);
	}
	
	/**
	* Setter for Controller Layout
	*
	* @param string $layout
	* @return void
	*/ 
	public function setLayout($layout){
		$this->the_layout_dir = $this->layout_dir . '/' . $layout;
	}
	
	/**
	* Getter for Controller Layout
	*
	* @return Controllers $layout_directory
	*/ 
	public function getLayout()
	{
		return $this->the_layout_dir;
	}
	
	/**
	* FirePHP loader method
	*
	* @return void
	*/
	private function loadFirePHP(){
		$this->load->config('fireignition');
		if ($this->config->item('fireignition_enabled'))
		{
			if (floor(phpversion()) < 5)
			{
				log_message('error', 'PHP 5 is required to run fireignition');
			} else {
				$this->load->library('firephp');
			}
		}
		else 
		{
			$this->load->library('firephp_fake');
			$this->firephp =& $this->firephp_fake;
		}		
	}

	/**
	 * @param array $vars
	 */
	public function setVars($vars)
	{
		if (count($vars)>0)
		{
			foreach ($vars as $key=>$value)
			{
				// double underscore for layout variables
				$this->layout_variables['__'.$key] = $value;
			}
		}
	}
}