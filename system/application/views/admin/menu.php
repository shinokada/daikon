<!--
When creating a new menu item on the top-most level
Please ensure that you assign the LI a unique ID

Examples can be seen below for menu_bep_system
-->
<ul id="menu">
    <li id="menu_bep_home"><?php print anchor('admin',$this->lang->line('backendpro_dashboard'),array('class'=>'icon_house'))?></li>
    <?php if(check('System',NULL,FALSE)):?>
    <li id="menu_bep_system"><span class="icon_computer"><?php print $this->lang->line('backendpro_system')?></span>
        <ul>
            <?php if(check('Members',NULL,FALSE)):?><li><?php print anchor('auth/admin/members',$this->lang->line('backendpro_members'),array('class'=>'icon_group'))?></li><?php endif;?>
            <?php if(check('Access Control',NULL,FALSE)):?><li><?php print anchor('auth/admin/access_control',$this->lang->line('backendpro_access_control'),array('class'=>'icon_shield'))?></li><?php endif;?>
            <?php if(check('Settings',NULL,FALSE)):?><li><?php print anchor('admin/settings',$this->lang->line('backendpro_settings'),array('class'=>'icon_cog'))?></li><?php endif;?>
        </ul>
    </li>
    <?php endif;?>
    
    <?php
    $this->load->view($this->config->item('backendpro_template_admin') . 'menu_support');
   ?>
     <?php if(check('Project Panel',NULL,FALSE)):?>
<li id="menu_bep_project"><span class="icon_blackboard16"><?php print $this->lang->line('project_projects')?></span>
        <ul>

            <?php if(check('Project Home',NULL,FALSE)):?><li><?php print anchor('projects/admin/admin','Project Admin Home',array('class'=>'icon_user_red'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Project Spec',NULL,FALSE)):?><li><?php print anchor('projects/admin/adminspec','Project Specs',array('class'=>'icon_arrow_right_16'))?></li><?php echo "\n"; endif;?>


        </ul>
</li>
<?php endif;?>
</ul>