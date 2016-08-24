<?php
/**
 * This is the template that displays the message user form
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 * To display a feedback, you should call a stub AND pass the right parameters
 * For example: /blogs/index.php?disp=msgform&recipient_id=n
 * Note: don't code this URL by hand, use the template functions to generate it!
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 * @subpackage bootstrap_blog_skin
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


global $app_version, $disp, $Blog;

if( evo_version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );

$map = $Skin->get_setting( 'contact_map_show' );

// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
skin_include( '_body_header_page.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>

<div id="content">
	<div class="<?php if( $map == 1 ) { echo 'container-fluid'; } else { echo 'container'; }; ?>">
		<div class="row">

			<?php if( $map == 1 ){ ?>
			<div class="content_map col-sm-12 col-md-5">
				<div class="row">
					<div id="maps"></div>
				</div>
			</div>
			<?php } ?>

			<div id="main_content" <?php if( $map == 1 ) { echo 'class="col-sm-12 col-md-7"'; }; ?>>
				<?php
					// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
					messages( array(
						'block_start' => '<div class="action_messages">',
						'block_end'   => '</div>',
					) );
					// --------------------------------- END OF MESSAGES ---------------------------------
				?>

				<?php
					// ------------------------ TITLE FOR THE CURRENT REQUEST ------------------------
					request_title( array(
						'title_before'       => '<h2 class="evo_title_disp">',
						'title_after'        => '</h2>',
						'title_none'         => '',
						'title_single_disp'  => false,
						'title_page_disp'    => false,
						'format'             => 'htmlbody',
						'display_edit_links' => false,
						'glue'               => ' - ',
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
						'msgform_text'       => T_('Contact <span>Us</span>'),
						'treads_text'		 => T_('Contact <span>Us</span>'),
						'user_text'          => '',
						'users_text'         => '',
					) );
					// ----------------------------- END OF REQUEST TITLE ----------------------------
				?>


				<?php
					// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
					skin_include( '$disp$' );
					// Note: you can customize any of the sub templates included here by
					// copying the matching php file into your skin directory.
					// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
				?>
			</div><!-- .col -->
		</div><!-- .row -->

	</div><!-- .container -->

	<?php if( $Skin->get_setting( 'contact_info_show' ) == 1 ) { ?>
	<div class="contact_info container-fluid">
		<div class="main_contact_info clearfix">
			<div class="main_contact_info_icon">
				<i class="ei ei-pin"></i>
			</div>
			<div class="main_contact_info_text">
				<h3>Address</h3>
				<p><?php echo $Skin->get_setting( 'contact_info_address' ); ?></p>
			</div>
		</div>
		<div class="main_contact_info clearfix">
			<div class="main_contact_info_icon">
				<i class="ei ei-mail"></i>
			</div>
			<div class="main_contact_info_text">
				<h3>Email</h3>
				<p><?php echo $Skin->get_setting( 'contact_info_email' ); ?></p>
			</div>
		</div>
		<div class="main_contact_info clearfix">
			<div class="main_contact_info_icon">
				<i class="ei ei-phone"></i>
			</div>
			<div class="main_contact_info_text">
				<h3>Call Us</h3>
				<p><?php echo $Skin->get_setting( 'contact_info_number' ); ?></p>
			</div>
		</div>
	</div>
	<?php } ?>

</div><!-- #content -->


<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
skin_include( '_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>
