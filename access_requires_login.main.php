<?php
/**
 * This file is the template that displays "login required" for non logged-in users.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * @package evoskins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $app_version, $disp, $Blog, $Skin;

if( evo_version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>

<?php
if( $Skin->is_visible_container( 'menu' ) ) { // Display 'Menu' widget container
$header_md = $Skin->change_class( 'header_content_mode' );
$trans = '';
if( $Skin->get_setting( 'nav_bg_transparent' ) == 1 ) {
    $trans = 'class="nav_bgt"';
}
?>
<header id="nav" <?php echo $trans; ?> >
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_tabs" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
                skin_widget( array(
                    // CODE for the widget:
    				'widget'              => 'coll_title',
                    'block_start'         => '<div class="navbar-brand">',
                    'block_end'           => '</div>',
                    'block_title_start'   => '<h3>',
                    'block_title_end'     => '</h3>',
                    // 'item_class'          => 'navbar-brand',
                ) );
            ?>
            <!-- <a class="navbar-brand-img" href="<?php echo $baseurl; ?>">
                <img src="<?php echo $skin_url.'logo_white.png'; ?>" />
            </a> -->
        </div>
        <nav id="nav_tabs" class="nav_tabs collapse navbar-collapse">
    		<ul class="main_nav">
    		<?php
    			// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
    			// Display container and contents:
    			// Note: this container is designed to be a single <ul> list
    			skin_container( NT_('Menu'), array(
    					// The following params will be used as defaults for widgets included in this container:
					'block_start'         => '',
					'block_end'           => '',
					'block_display_title' => false,
					'list_start'          => '',
					'list_end'            => '',
					'item_start'          => '<li class="$wi_class$">',
					'item_end'            => '</li>',
					'item_selected_start' => '<li class="active $wi_class$">',
					'item_selected_end'   => '</li>',
					'item_title_before'   => '',
					'item_title_after'    => '',
				) );
    			// ----------------------------- END OF "Menu" CONTAINER -----------------------------
    		?>
    		</ul>
        </nav>

        <?php if( $Skin->get_setting( 'nav_search_icon' ) == 1 ) : ?>
        <div class="search_icon">
            <a href="#cd_search" class="search_tringger">
                <span></span>
            </a>
        </div>
        <div id="cd_search">
            <?php
                skin_widget( array(
                    // CODE for the widget:
                    'widget'               => 'coll_search_form',
                    // Optional display params
                    'block_start'          => '<div class="evo_widget $wi_class$ header_search">',
                    'block_end'            => '</div>',
                    'block_display_title'  => false,
                    'search_submit_before' => '<span class="hidden">',
                    'search_submit_after'  => '</span>',
                ) );
            ?>
        </div>
        <?php endif; ?>

    </div><!-- .container-fluid -->
</header><!-- #nav -->
<?php } ?>

<?php
if( $Skin->is_visible_container( 'header' ) ) { // Display 'Header' widget container
?>
<header id="main_header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 <?php echo $header_md; ?>">
                <div class="site_brand">
                <?php
                    // ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
                    // Display container and contents:
                    skin_container( NT_('Header'), array(
                        // The following params will be used as defaults for widgets included in this container:
                        'block_start'       => '<div class="evo_widget $wi_class$">',
                        'block_end'         => '</div>',
                        'block_title_start' => '<h1>',
                        'block_title_end'   => '</h1>',
                    ) );
                    // ----------------------------- END OF "Header" CONTAINER -----------------------------
                ?>
                </div>
            </div><!-- .col -->

            <?php if( $Skin->get_setting('header_breadcrumb') == 1 ) : ?>
            <div class="col-xs-12 col-sm-12 <?php echo $header_md; ?>">
                <div class="bc_content">
                <?php
                    // ------------------------- "Breadcrumbs" CONTAINER EMBEDDED HERE --------------------------
                    // Breadcrumbs
                    skin_widget( array(
                		// CODE for the widget:
                		'widget'           => 'breadcrumb_path',
                		// Optional display params
                		'block_start'      => '<ul class="breadcrumb">',
                		'block_end'        => '</ul><div class="clear"></div>',
                		'separator'        => '',
                		'item_mask'        => '<li><a href="$url$">$title$</a></li>',
                		'item_active_mask' => '<li class="active">$title$</li>',
                	) );
                    // ----------------------------- END OF "Page Top" CONTAINER -----------------------------
                ?>
                </div>
            </div><!-- .col -->
            <?php endif; ?>

        </div><!-- .row -->
    </div><!-- .container -->
</header><!-- #main_header -->
<?php } ?>

<h1>hello 2</h1>

<div id="content">
	<div class="container">
		<div class="row">
			<div id="main_content" class="<?php if( $Skin->is_visible_container( 'sidebar' ) ){ echo $Skin->get_column_class( 'layout' ); } else { echo 'col-md-12'; } ?>">

				<?php
					// ------------------------ TITLE FOR THE CURRENT REQUEST ------------------------
					request_title( array(
						'title_before'       => '<h2 class="evo_title_disp">',
						'title_after'        => '</h2>',
						'title_none'         => '',
						'glue'               => ' - ',
						'title_single_disp'  => false,
						'title_page_disp'    => false,
						'format'             => 'htmlbody',
						'display_edit_links' => false,
						'category_text'      => '',
						'categories_text'    => '',
						'catdir_text'        => '',
						'comments_text'      => T_('Latest Replies'),
						'front_text'         => '',
						'posts_text'         => '',
						'useritems_text'     => T_('User\'s topics'),
						'usercomments_text'  => T_('User\'s replies'),
						'register_text'      => '',
						'login_text'         => '',
						'lostpassword_text'  => '',
						'account_activation' => '',
						'msgform_text'       => T_('Messagesss'),
						'user_text'          => '',
						'users_text'         => '',
					) );
					// ----------------------------- END OF REQUEST TITLE ----------------------------
				?>

				<?php
					// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
					skin_include( '$disp$', array(
						'author_link_text' 		  => 'auto',
						// Profile tabs to switch between user edit forms
						'profile_tabs' => array(
							'block_start'         => '<nav><ul class="nav nav-tabs profile_tabs">',
							'item_start'          => '<li>',
							'item_end'            => '</li>',
							'item_selected_start' => '<li class="active">',
							'item_selected_end'   => '</li>',
							'block_end'           => '</ul></nav>',
						),

						// Pagination
						'pagination' => array(
							'block_start'           => '<div class="center"><ul class="pagination">',
							'block_end'             => '</ul></div>',
							'page_current_template' => '<span>$page_num$</span>',
							'page_item_before'      => '<li>',
							'page_item_after'       => '</li>',
							'page_item_current_before' => '<li class="active">',
							'page_item_current_after'  => '</li>',
							'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
							'next_text'             => '<i class="fa fa-angle-double-right"></i>',
						),
						// Item content:
						'url_link_position'     => 'top',

						// Form params for the forms below: login, register, lostpassword, activateinfo and msgform
						'skin_form_before'      => '<div class="panel panel-default skin-form">'
													.'<div class="panel-heading">'
														.'<h3 class="panel-title">$form_title$</h3>'
													.'</div>'
													.'<div class="panel-body">',
						'skin_form_after'       => '</div></div>',

						// Login
						'display_form_messages' => true,
						'form_title_login'      => T_('Log in to your account').'$form_links$',
						'form_title_lostpass'   => get_request_title().'$form_links$',
						'lostpass_page_class'   => 'evo_panel__lostpass',
						'login_form_inskin'     => false,
						'login_page_class'      => 'evo_panel__login',
						'login_page_before'     => '<div class="$form_class$">',
						'login_page_after'      => '</div>',
						'display_reg_link'      => true,
						'abort_link_position'   => 'form_title',
						'abort_link_text'       => '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>',

						// Register
						'register_page_before'      => '<div class="evo_panel__register">',
						'register_page_after'       => '</div>',
						'register_form_title'       => T_('Register'),
						'register_links_attrs'      => '',
						'register_use_placeholders' => true,
						'register_field_width'      => 252,
						'register_disabled_page_before' => '<div class="evo_panel__register register-disabled">',
						'register_disabled_page_after'  => '</div>',

						// Activate form
						'activate_form_title'  	=> T_('Account activation'),
						'activate_page_before' 	=> '<div class="evo_panel__activation">',
						'activate_page_after'  	=> '</div>',

						// Search
						'search_input_before'  	=> '<div class="input-group">',
						'search_input_after'   	=> '',
						'search_submit_before' 	=> '<span class="input-group-btn">',
						'search_submit_after'  	=> '</span></div>',

						// Front page
						'featured_intro_before' => '<div class="jumbotron">',
						'featured_intro_after'  => '</div>',

						// Form "Sending a message"
						'msgform_form_title' 	=> T_('Contact <span>Us</span>'),
					) );
					// Note: you can customize any of the sub templates included here by
					// copying the matching php file into your skin directory.
					// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
				?>

			</div><!-- .col -->
			<?php
			if( $Skin->is_visible_container( 'sidebar' ) ) { // Display sidebar:
				// ------------------------- SIDEBAR INCLUDED HERE --------------------------
				skin_include( '_sidebar.inc.php' );
				// Note: You can customize the sidebar by copying the
				// _sidebar.inc.php file into the current skin folder.
				// ----------------------------- END OF SIDEBAR -----------------------------
			} ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #main_content -->


<?php
$columns = $Skin->get_setting( 'footer_widgets_columns' );
$footer_mode = $Skin->change_class( 'footer_bottom_mode' );

if( $Skin->is_visible_container( 'footer' ) ) { // Display 'Footer' widget container
?>
<footer id="footer">
    <div class="container">
    	<!-- =================================== START OF FOOTER =================================== -->
        <?php if( $Skin->get_setting( 'footer_widget' ) == 1 ) : ?>
    	<div class="footer_widgets row">
    		<?php
    			// Display container and contents:
    			skin_container( NT_("Footer"), array(
					// The following params will be used as defaults for widgets included in this container:
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
    			// Note: Double quotes have been used around "Footer" only for test purposes.
    		?>
            <div class="clearfix"></div>
        </div>
        <!-- .footer_widgets -->
        <?php endif; ?>

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
<?php }
	}
?>



<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>
