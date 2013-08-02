<?php

/**
 * Flexi Layout Library
 *
 * Flexi Layout Library for building better views with themes, 
 * template, partials, css, js, breadcrumbs control.
 *
 * @author Justin Mitchell (http://www.creativeinflux.co.uk)
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 * @package Flexi Layout Library
 */

class Flexi {

	//layout properties
	public $theme;
	public $template;
	public $template_data = array();
	public $flexi_folder = 'flexi';
	public $content = array();

	//config properties
	public $config = array();
	public $config_override = array();

	//partials properties
	public $partials = array();
	public $partials_folder = 'partials';

	//page properties
	public $title_prefix = '';
	public $title_suffix = '';
	public $title_seperator = '';
	public $title_page = '';
	public $css_folder = 'css';
	public $js_folder = 'js';
	public $page_css = array();
	public $page_js = array();
	public $page_meta = array();
	public $breadcrumbs = array();

//----------------------------------------------------------------------------------->

	/**
	 * __construct
	 * The config will attempt to load the flexi config file and set the properties, you
	 * can also pass the load an array which will e merged and override anything in your
	 * config file. Pass the array as below:
	 *
	 * $this->load->library('flexi', array('theme' => 'my_theme'));
	 *
	 * It there are config items the init method will be called
	 * 
	 * @param array $config
	 */

	public function __construct($config = array()) 
	{
		$this->ci = & get_instance();

		//Load the config if we can
		$this->ci->config->load('flexi_config', true, true);

		//Check if the theme is set in the config
		if($this->ci->config->item('theme', 'flexi_config')) {
			$this->theme($this->ci->config->item('theme', 'flexi_config'));
		}

		//Check if the template is set in the config
		if($this->ci->config->item('template', 'flexi_config')) {
			$this->template($this->ci->config->item('template', 'flexi_config'));
		}

		//if config has been sent through then load the config
		if (count($config) > 0) {
			$this->init($config);
			//Set and override for merging later
			$this->config_override = $config;
		}
	}

//----------------------------------------------------------------------------------->

	/**
	 * init
	 * This method will set the properties from an array.  It will also trigger the theme
	 * and template methods if those are set and will merge the override properties.
	 *
	 * @param array $config (Array of config items)
	 * @return object $this
	 */

	private function init($config = array()) 
	{
		//if the config item is theme run the theme method
		if(isset($config['theme'])) {
			$this->theme($config['theme']);
		}

		//if the config item is template run the template method
		if(isset($config['template'])) {
			$this->template($config['template']);
		}

		//take the config set the items
		foreach ($config as $key => $val) {
			//if the item is in the override cache then don't overwrite it
			if (isset($this->$key) && !array_key_exists($key, $this->config_override)) {
				$this->$key = $val;
			}
		}

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * title
	 * Used to set the page title.
	 *
	 * @param string $title (the page title)
	 * @return object $this
	 */
	
	public function title($title) 
	{
		$this->title = $title;
		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * template
	 * Used to set the name of the template file.
	 *
	 * @param string $template (the name of the template that we will be using)
	 * @return object $this
	 */

	public function template($template) 
	{
		//Set the template
		$this->template = $template;
		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * theme
	 * Used to set the name of the theme.
	 *
	 * @param string $theme
	 * @return object $this
	 */

	public function theme($theme) 
	{
		$this->theme = $theme;

		//See if we have a config file for this theme and merge and init
		if($this->ci->config->item('flexi_config')) {
			$this->config += $this->ci->config->item('flexi_config');
		}

		if(isset($this->config[$theme])) {
			$this->init($this->config[$theme]);
		}

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * templateData
	 * Used to set an array of data that will be sent to the template file.  
	 *
	 * @param array $data (array of data)
	 * @return object $this
	 */

	public function templateData($data) 
	{
		if(is_array($data)) {
			$this->template_data += $data;
		}
		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * partial
	 * Used to set a partial view file.
	 *
	 * @param string $view (the view file that we will be loading)
	 * @param array $data (array of data that will be sent to the view file)
	 * @return object $this
	 */

	public function partial($view = '', $data = array()) 
	{
		if(is_array($view)) {

			foreach ($view as $key => $value) {
				$this->partials[$key]['view'] = $key;

				if(is_array($value)) {
					if(isset($this->partials[$key]['data'])) {
						$this->partials[$key]['data'] += $value;
					} else {
						$this->partials[$key]['data'] = $value;
					} 
				}
			}

		} else {

			$this->partials[$view]['view'] = $view;

			if(is_array($data)) {
				if(isset($this->partials[$view]['data'])) {
					$this->partials[$view]['data'] += $data;
				} else {
					$this->partials[$view]['data'] = $data;
				} 
			}

		}

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * css
	 * Used to set a css file, note the location of the css folder is set from the config file.
	 *
	 * @param string/array $css_file (string or array of css files)
	 * @return object $this
	 */

	public function css($css_file = null) 
	{
		if(is_array($css_file)) {
			$this->page_css += $css_file;
		} else {
			$this->page_css[] = $css_file;
		}

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * js
	 * Used to set a js file, note the location of the js folder is set from the config file.
	 *
	 * @param string/array $js_file (string or array of js files)
	 * @return object $this
	 */

	public function js($js_file = null) 
	{
		if(is_array($js_file)) {
			$this->page_js += $js_file;
		} else {
			$this->page_js[] = $js_file;
		}

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * meta
	 * set the meta data tags
	 *
	 * @param string/array $meta_name (either an key => value array or meta key string)
	 * @param string $meta_content (Set the meta value if key is a string)
	 * @return object $this
	 */

	public function meta($meta_name = '', $meta_content = '') 
	{
		if(is_array($meta_name)) {
			foreach ($meta_name as $key => $value) {
				$this->page_meta[] = array('name' => $key, 'content' => $value);
			}
		} else {
			$this->page_meta[] = array('name' => $meta_name, 'content' => $meta_content);
		}

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * breadcrumbs
	 * set the the breadcrumbs
	 *
	 * @param string $name (breadcrumb name)
	 * @param string $link (link)
	 * @return object $this
	 */

	public function breadcrumb($name, $link = '') 
	{
		if(is_array($name)) {
			foreach ($name as $key => $value) {
				$this->breadcrumbs[] = array('name' => $key, 'link' => $value);
			}
		} else {
			$this->breadcrumbs[] = array('name' => $name, 'link' => $link);
		}
		
		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * make
	 * make the view
	 * 
	 * @param string $view (the view file that will be loaded)
	 * @param array $data (data for the view file)
	 * @return object $this
	 */

	public function make($view = null, $data = array()) 
	{
		//Show error if theme is not set
		if(empty($this->theme)) {
			show_error('Flexi: The theme has not been set.');
		}

		//Show error if template is not set
		if(empty($this->template)) {
			show_error('Flexi: Template has not been set.');
		}

		if(isset($view)) {
			//Set the view for rendering
			$this->content['view'] = $view;

			//Set the data
			if(isset($this->content['data'])) {
				$this->content['data'] += $data;
			} else {
				$this->content['data'] = $data;
			}
		}

		//Load the file
		$this->ci->load->view($this->flexi_folder . '/' . $this->theme . '/' . $this->template, $this->template_data);

		return $this;
	}

//----------------------------------------------------------------------------------->

	/**
	 * getPartial
	 * get and return the partial view file
	 *
	 * @param string $view (the partial view file)
	 * @param boolean $search (Look the file everywhere, if set to false then it must be loaded in the cache, if true we will look everywhere for it but no data will be set)
	 * @param boolean $strict (set whether the view should fail if the partial can't be found)
	 * @return string (the partial view)
	 */

	public function getPartial($view = '', $strict = false) 
	{
		//Try and load the partial file that was cached along with the partials data
		if(isset($this->partials[$view])) {

			//look in the theme folder
			if(file_exists(APPPATH . 'views/' . $this->flexi_folder . '/' . $this->theme . '/' . $this->partials_folder . '/' . $view . '.php')) {
				return $this->ci->load->view($this->flexi_folder . '/' . $this->theme . '/' . $this->partials_folder . '/' . $this->partials[$view]['view'], $this->partials[$view]['data'], true);
			}

			//look in the partials common folder
			if(file_exists(APPPATH . 'views/' . $this->flexi_folder . '/' . $this->partials_folder . '/' . $view . '.php')) {
				return $this->ci->load->view($this->flexi_folder . '/' . $this->partials_folder . '/' . $this->partials[$view]['view'], $this->partials[$view]['data'], true);
			}

		} else {

			//look in the theme folder
			if(file_exists(APPPATH . 'views/' . $this->flexi_folder . '/' . $this->theme . '/' . $this->partials_folder . '/' . $view . '.php')) {
				return $this->ci->load->view($this->flexi_folder . '/' . $this->theme . '/' . $this->partials_folder . '/' . $view, '', true);
			}

			//lonk in the partials common folder
			if(file_exists(APPPATH . 'views/' . $this->flexi_folder . '/' . $this->partials_folder . '/' . $view . '.php')) {
				return $this->ci->load->view($this->flexi_folder . '/' . $this->partials_folder . '/' . $view, '', true);
			}

		}

		//If strict is set then show an error message as the file could not be loaded
		if($strict) show_error('Flexi: The file ' . $view . ' cannot be found. ' . ((!isset($this->partials[$view]) && ($search === false)) ? ' This is because the partial has not been loaded yet and may not exist' : ' This is because the file does not exist') . '.  You have been shown this error because you have loaded the partial with the strict setting if you load the partial without strict this error will be surpressed.');
	}

//----------------------------------------------------------------------------------->

	/**
	 * getContent
	 * get the content
	 *
	 * @return string (the view)
	 */

	public function getContent() 
	{
		return $this->ci->load->view($this->content['view'], $this->content['data'], true);
	}

//----------------------------------------------------------------------------------->

	/**
	 * getTitle
	 * get the title
	 *
	 * @return string
	 */

	public function getTitle() 
	{
		$prefix_seperator = (!empty($this->title_prefix)) ? ' ' . $this->title_seperator . ' ' : '';
		$suffix_seperator = (!empty($this->title_suffix)) ? ' ' . $this->title_seperator . ' ' : '';
		return $this->title_prefix . $prefix_seperator . $this->title . $suffix_seperator . $this->title_suffix;
	}

//----------------------------------------------------------------------------------->

	/**
	 * getCss
	 * get the css files and return either the html or an array of files
	 *
	 * @param boolean $format (what is returned html or array)
	 * @return string/array 
	 */

	public function getCss($format = true) 
	{
		if(!empty($this->page_css)) {
			$return = '';
			foreach($this->page_css as $key => $value) {
				$link = $this->css_folder . '/' . $value;
				if($format === true) {
					$return .= '<link rel="stylesheet" type="text/css" href="' . $link . '"  />';
				} else {
					$return[] = $link;
				}
			}
		}
		
		return $return;
	}

//----------------------------------------------------------------------------------->

	/**
	 * getJs
	 * get the js files and return either the html or an array of files
	 *
	 * @param boolean $format (what is returned html or array)
	 * @return string/array
	 */

	public function getJs($format = true) 
	{
		$return = '';

		if(!empty($this->page_js)) {
			foreach($this->page_js as $key => $value) {
				$link = $this->js_folder . '/' . $value;
				if($format === true) {
					$return .= '<script type="text/javascript" src="' . $link . '"></script>';
				} else {
					$return[] = $link;
				}
			}
		}
		
		return $return;
	}

//----------------------------------------------------------------------------------->

	/**
	 * getMeta
	 * get the html meta data
	 *
	 * @param boolean $format (what is returned html or array)
	 * @return string/array
	 */

	public function getMeta($format = true) 
	{
		$return = '';

		if(!empty($this->page_meta)) {
			foreach($this->page_meta as $key => $value) {
				if($format === true) {
					$return .= '<meta name="' . $value['name'] . '" content="' . $value['content'] . '" />';
				} else {
					$return = $this->page_meta;
				}
			}
		}
		
		return $return;
	}

//----------------------------------------------------------------------------------->

	/**
	 * getBreadcrumbs
	 * get the breadcrumbs that have been set
	 *
	 * @param boolean $show_home (do we want to show the homepage link)
	 * @param boolean $format (what to return html or array)
	 * @return array/string
	 */

	public function getBreadcrumbs($show_home = true, $format = true) 
	{
		if($show_home) array_unshift($this->breadcrumbs, array('name' => 'home', 'link' => ''));

		if($format) {
			$return = '<ul>';
			foreach ($this->breadcrumbs as $key => $value) {
				$return .= '<li><a href="' . $this->ci->config->base_url() . $value['link'] . '">' . $value['name'] . '</a></li>';
			}
			$return .= '</ul>';
		} else {
			$return = $this->breadcrumbs;
		}

		return $return;
	}

//----------------------------------------------------------------------------------->

	/**
	 * GetHead
	 * Get the formatted head
	 *
	 * @param boolean $scripts (do you want to include to scripts in the head?)
	 * @param string $extra (user defined extra)
	 * @return string
	 */

	public function getHead($scripts = true, $extra = '') 
	{
		$html = '<head>
				<title>' . $this->getTitle() . '</title>
				' . $this->getCss() . '
				' . (($scripts) ? $this->getJs() : '') . '
				' . $this->getMeta() . '
				' . $extra . '
				</head>';

		return $html;
	}

}