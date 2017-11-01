<?php
/**
 * This is the BODY footer include template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * This is meant to be included in a page template.
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

$columns = $Skin->get_setting( 'footer_widgets_columns' );
$footer_mode = $Skin->change_class( 'footer_bottom_mode' );

?>

<footer id="footer">
    <div class="container">
    	<!-- =================================== START OF FOOTER =================================== -->
        <?php if( $Skin->get_setting( 'footer_widget' ) == 1 ) :
                // ------------------------- "Footer" CONTAINER EMBEDDED HERE --------------------------
                widget_container( 'footer', array(
                    // The following params will be used as defaults for widgets included in this container:
                    'container_display_if_empty' => false, // If no widget, don't display container at all
                    'container_start'      => '<div class="footer_widgets row evo_container $wico_class$">',
                    'container_end'        => '<div class="clearfix"></div></div>',
                    'block_start'          => '<div class="evo_widget $wi_class$ col-xs-12 col-sm-6 '.$columns.'"">',
                    'block_end'            => '</div>',
                    // This will enclose the title of each widget:
                    'block_title_start'    => '<div class="evo_widget_heading"><h4 class="evo_widget_title">',
                    'block_title_end'      => '</h4></div>',
                    // This will enclose the body of each widget:
                    'block_body_start'     => '<div class="evo_widget_body">',
                    'block_body_end'       => '</div>',
                    // If a widget displays a list, this will enclose that list:
                    'list_start'           => '<ul>',
                    'list_end'             => '</ul>',
                    // This will enclose each item in a list:
                    'item_start'           => '<li class="evo_widget_list">',
                    'item_end'             => '</li>',
                    // This will enclose sub-lists in a list:
                    'group_start'          => '<ul>',
                    'group_end'            => '</ul>',
                    // This will enclose (foot)notes:
                    'notes_start'          => '<div class="notes">',
                    'notes_end'            => '</div>',
                    // Widget 'Search form':
                    'search_class'         => 'compact_search_form',
                    'search_input_before'  => '<div class="input-group">',
                    'search_input_after'   => '',
                    'search_submit_before' => '<span class="input-group-btn">',
                    'search_submit_after'  => '</span></div>',
                    // 'author_link_text'  => $params['author_link_text']
                ) );
                // ----------------------------- END OF "Footer" CONTAINER -----------------------------
        endif; ?>

        <?php if( $Skin->get_setting( 'footer_copyright' ) == 1 || $Skin->get_setting( 'footer_social_icon' ) == 1 ) : ?>
        <div class="footer_bottom clearfix <?php echo $footer_mode; ?> row">
            <?php
                /* SOCIAL ICON
                 * ========================================================================== */
                if( $Skin->get_setting( 'footer_social_icon' ) == 1 ) :
                skin_widget( array(
                    // CODE for the widget:
    				'widget'              => 'user_links',
                    // Options display params
                    'block_start'         => '<div class="social_icon">',
                    'block_end'           => '</div>',
                    'block_display_title' => false,
                ));
                endif;
            ?>

            <?php if( $Skin->get_setting( 'footer_copyright' ) == 1 ) : ?>
    		<p class="copyright">
    			<?php
    				// Display footer text (text can be edited in Blog Settings):
    				$Blog->footer_text( array(
						'before' => '',
						'after'  => ' &bull; ',
					) );
    			?>

    			<?php
    				// Display a link to contact the owner of this blog (if owner accepts messages):
    				$Blog->contact_link( array(
						'before' => '',
						'after'  => ' &bull; ',
						'text'   => T_('Contact'),
						'title'  => T_('Send a message to the owner of this blog...'),
					) );
    				// Display a link to help page:
    				$Blog->help_link( array(
						'before'      => ' ',
						'after'       => ' ',
						'text'        => T_('Help'),
					) );
    			?>

    			<?php
    				// Display additional credits:
    				// If you can add your own credits without removing the defaults, you'll be very cool :))
    				// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
    				credits( array(
						'list_start'  => '&bull;',
						'list_end'    => ' ',
						'separator'   => '&bull;',
						'item_start'  => ' ',
						'item_end'    => ' ',
					) );
    			?>
    		</p>
            <?php endif; ?>
    	</div><!-- .footer_bottom -->
        <?php endif; ?>
    </div><!-- .container -->
</footer><!-- #footer -->

<?php if ( $Skin->get_setting( 'back_to_top' ) == 1 ) { ?>
<a href="#0" class="cd_top"><i class="ei ei-arrow_up"></i></a>
<?php } ?>

<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------
?>
