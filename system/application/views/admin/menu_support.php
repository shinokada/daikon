 <?php if(check('Customer Support',NULL,FALSE)):?> 
<li id="menu_bep_support"><span class="icon_user_green"><?php print $this->lang->line('customer_support')?></span>
        <ul>
                
            <?php if(check('Customers Admin',NULL,FALSE)):?><li><?php print anchor('support/admin',$this->lang->line('customer_customers_admin'),array('class'=>'icon_user_orange'))?></li><?php echo "\n"; endif;?>
             
             
        </ul>
</li>
<?php endif;?>