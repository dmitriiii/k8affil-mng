<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    K8affil_Mng
 * @subpackage K8affil_Mng/admin/partials
 */
class K8affil_Mng_Admin_Display
{
	public $page_title;
	public $menu_title;
	public $capability;
	public $menu_slug;
	public $function;
	public $icon_url;
	public $position;
  public function __construct(){
  	$this->page_title = 'Affiliates Sync';
		$this->menu_title = 'Affiliates Sync';
		$this->capability = 'manage_options';
		$this->menu_slug  = 'k8affil-mng';
		$this->function   = 'process';
		$this->icon_url   = 'dashicons-rest-api';
		$this->position   = 4;
		$this->settz();
    // add_action( 'admin_menu', array( $this, 'settz' ) );
  }
  public function settz(){
		add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array( $this, $this->function ), $this->icon_url, $this->position );
  }
  public function process(){?>
		<div class="wrap">
	    <div id="icon-users" class="icon32"></div>
	    <h2><?php echo $this->page_title; ?></h2>

	    <table class="wp-list-table widefat fixed striped k8affil-tbl">
	    	<tr>
	    		<th style="width: 60px;"><strong>#</strong></th>
	    		<th style="width: 85%"><h3>Group</h3></th>
	    		<th><h3>Syncronize</h3></th>
	    	</tr>
	    	<tr>
	    		<th>1</th>
	    		<th><strong><em><u>Affiliates Types & Categories</u></em></strong></th>
	    		<th><button class="button button-primary button-large k8affil-btn" data-action="k8affil_act_typecat">Sync!</button></th>
	    	</tr>
	    	<tr>
	    		<th>2</th>
	    		<th><strong><em><u>Affiliates Vendors</u></em></strong></th>
	    		<th><button class="button button-primary button-large k8affil-btn" data-action="k8affil_act_vend">Sync!</button></th>
	    	</tr>
	    	<tr>
	    		<th>3</strong></th>
	    		<th><strong><em><u>Affiliates Coupons</u></em></strong></th>
	    		<th><button class="button button-primary button-large k8affil-btn" data-action="k8affil_act_coup">Sync!</button></th>
	    	</tr>
	    </table>
			
			<br>
			<br>

	    <table class="wp-list-table widefat fixed striped k8affil-tbl">
	    	<tr>
	    		<th style="width: 60px;"><strong>#</strong></th>
	    		<th style="width: 85%"><h3>Group</h3></th>
	    		<th><h3>Syncronize</h3></th>
	    	</tr>
	    	<tr>
	    		<th>1</th>
	    		<th><strong><em><u>Custom taxonomies for posts under VPN Anbieter</u></em></strong></th>
	    		<th><button class="button button-primary button-large k8affil-btn" data-action="k8affil_act_tax">Sync!</button></th>
	    	</tr>

	    </table>
	  </div><!-- .wrap -->
  <?php
  }
}
if( is_admin() ){
	new K8affil_Mng_Admin_Display();
}