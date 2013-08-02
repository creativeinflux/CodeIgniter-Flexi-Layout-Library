<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Example of the flexi layout library
 *
 * @author Justin Mitchell (http://www.creativeinflux.co.uk)
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 * @package Flexi Layout Library
 */

class Home extends CI_Controller {

//----------------------------------------------------------------------------------->

	/**
	 * __construct
	 * Loads the flexi library and sets the footer css and breadcrumbs
	 */

	function __construct() {
		parent::__construct();

		$this->load->library('flexi');

		$footer['data'] = 'This variable data was sent to the footer partial from the controller';

		$this->flexi->partial('footer', $footer)
					->css('example_css.css')
					->breadcrumb(array('home' => '/'));
	}

//----------------------------------------------------------------------------------->

	/**
	 * index
	 * Sets the page title and loads the home content
	 */

	public function index() {

		$data['content'] = 'Homepage';
		$this->flexi->title('Homepage')
					->make('home', $data);

	}

}