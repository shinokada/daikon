<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Support_Controller
 *
 * Extends the Site_Controller class so I can declare special Support Admin controllers
 *
 */
class Support_Controller extends Site_Controller
{
	function Support_Controller()
	{
		parent::Site_Controller();

		// Set base crumb
		$this->bep_site->set_crumb('Support Home','customersupport/admin');

		// Set container variable
		$this->_container = $this->config->item('backendpro_template_support') . "container.php";

		// Set Pop container variable
		$this->_popup_container = $this->config->item('backendpro_template_support') . "popup.php";

		// Make sure user is logged in
		// check('Control Panel');

		// Check to see if the install path still exists
		if( is_dir('install'))
		{
			flashMsg('warning',$this->lang->line('backendpro_remove_install'));
		}

		// Set private meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);
		$this->bep_site->set_metatag('robots','nofollow, noindex');
		$this->bep_site->set_metatag('pragma','nocache',TRUE);

		// Load the ADMIN asset group
		$this->bep_assets->load_asset_group('ADMIN');

		log_message('debug','BackendPro : Admin_Controller class loaded');
	}
}

/* End of Admin_controller.php */
/* Location: ./system/application/libraries/Admin_controller.php */