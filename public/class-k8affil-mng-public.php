<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    K8affil_Mng
 * @subpackage K8affil_Mng/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    K8affil_Mng
 * @subpackage K8affil_Mng/public
 * @author     Your Name <email@example.com>
 */
class K8affil_Mng_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $k8affil_mng    The ID of this plugin.
	 */
	private $k8affil_mng;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $k8affil_mng       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $k8affil_mng, $version ) {

		$this->k8affil_mng = $k8affil_mng;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in K8affil_Mng_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The K8affil_Mng_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->k8affil_mng, plugin_dir_url( __FILE__ ) . 'css/k8affil-mng-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in K8affil_Mng_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The K8affil_Mng_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->k8affil_mng, plugin_dir_url( __FILE__ ) . 'js/k8affil-mng-public.js', array( 'jquery' ), $this->version, false );

	}

}
