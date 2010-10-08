 <?php if(check('Customer Support',NULL,FALSE)):?> 
<li id="menu_bep_support"><span class="icon_user_green"><?php print $this->lang->line('customer_support')?></span>
        <ul>
                
            <?php if(check('Customer Record',NULL,FALSE)):?><li><?php print anchor('customersupport/admin','Support Home',array('class'=>'icon_user_orange'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Purchase Support',NULL,FALSE)):?><li><?php print anchor('customersupport/admin/purchase_credit',$this->lang->line('customer_purchase_support'),array('class'=>'icon_user_orange'))?></li><?php echo "\n"; endif;?>
              
             
        </ul>
</li>
<?php endif;?>