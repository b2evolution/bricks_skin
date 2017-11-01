<?php
/**
 * This is the BODY header include template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * This is meant to be included in a page template.
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $baseurl, $skin_url, $disp, $preview;

// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------

$header_md = $Skin->change_class( 'header_content_mode' );
$trans = '';
if( $Skin->get_setting( 'nav_bg_transparent' ) == 1 ) {
    $trans = 'class="nav_bgt"';
}

$affix_positioning_fix = $Settings->get( 'site_skins_enabled' ) ? ' data-offset-top="42.4"' : 'data-offset-top="1"';

?>
<header id="nav" <?php echo $trans; ?> data-spy="affix"<?php echo $affix_positioning_fix; ?>>
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

			<?php
				// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
				// Display container and contents:
				// Note: this container is designed to be a single <ul> list
				widget_container( 'menu', array(
					// The following params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start'     => '<nav id="nav_tabs" class="nav_tabs collapse navbar-collapse"><ul class="main_nav evo_container $wico_class$">',
					'container_end'       => '</ul></nav>',
					'block_start'         => '',
					'block_end'           => '',
					'block_display_title' => false,
					'list_start'          => '',
					'list_end'            => '',
					'item_start'          => '<li class="evo_widget $wi_class$">',
					'item_end'            => '</li>',
					'item_selected_start' => '<li class="active evo_widget $wi_class$">',
					'item_selected_end'   => '</li>',
					'item_title_before'   => '',
					'item_title_after'    => '',
				) );
				// ----------------------------- END OF "Menu" CONTAINER -----------------------------
			?>

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


<header id="main_header">
    <div class="container">
        <div class="row">
                <?php

                    // if ( $preview )  {
                    //     echo "<h1>Post Preview</h1>"; // Show title post on the preview
                    // } else if ( $disp == 'single' || $disp == 'page' ) {
                    //     $Item->title( array(
                    //         'before'    => '<h1>',
                    //         'after'     => '</h1>',
                    //         'link_type' => '#'
                    //     ) );
                    // } else {
                        // ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
                        // Display container and contents:
                        widget_container( 'header', array(
                            // The following params will be used as defaults for widgets included in this container:
                            'container_display_if_empty' => false, // If no widget, don't display container at all
                            'container_start'   => '<div class="col-xs-12 col-sm-12 '.$header_md.'"><div class="site_brand evo_container $wico_class$">',
                            'container_end'     => '</div></div>',
                            'block_start'       => '<div class="evo_widget $wi_class$">',
                            'block_end'         => '</div>',
                            'block_title_start' => '<h1>',
                            'block_title_end'   => '</h1>',
                        ) );
                        // ----------------------------- END OF "Header" CONTAINER -----------------------------
                    // }
                ?>

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
