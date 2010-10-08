<!--
When creating a new menu item on the top-most level
Please ensure that you assign the LI a unique ID

Examples can be seen below for menu_bep_system
-->
<ul id="menu">
    
    <?php
    $this->load->view($this->config->item('backendpro_template_support') . 'menu_support');
   ?>
    
</ul>