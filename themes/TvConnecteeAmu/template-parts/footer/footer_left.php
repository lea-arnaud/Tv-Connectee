<?php
?>

<div id="footer_left">
    <?php if(is_user_logged_in()) { ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer gauche') ) : endif; ?>
    <?php } ?>
</div>
<div id="footer_right">
    <?php if(is_user_logged_in()) { ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer droite') ) : endif; ?>
    <?php } ?>
</div>

<div id="footer">
    <?php if(is_user_logged_in()) { ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : endif; ?>
    <?php } ?>
    <?php wp_footer(); ?>
</div>