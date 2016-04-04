<?php
/**
* Template part for tip top bar
*
* @package WordPress
* @subpackage FoundationPress
* @since FoundationPress 1.0
*/
?>
<div class="tip-top">
    <div class="row medium-collapse">
        <div class="small-24 columns tip-top-l">                  
            <?php
            $options = get_option('theme_options');
            if (!empty($options['phone'])): ?>
            <a href="tel:<?php echo $options['phone']; ?>">
            <i class="fa fa-phone"></i>
            <span class="phone">
            <?php echo $options['phone']; ?>
            </span>
            </a>
            <?php endif; ?>               
            <a href="<?php echo site_url();?>/contact/" id="emailLink">         
            <i class="fa fa-paper-plane"></i>
            <span class="email">
                Email us
            </span><!--/.email-->
            </a>
            <a href="javascript:void(0);" onclick="olark('api.box.expand')">
                <i class="fa fa-comment"></i>
                <span class="chat">
                    Chat
                </span><!--/.chat-->
            </a>
           
        </div> <!-- / .small-12 -->
    </div> <!-- / .row -->
</div> <!-- / .tip-top -->