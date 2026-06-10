<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Content
 *
 * @package storefront
 */

get_header(); ?>

<style>
    .container-narow {
      max-width: 880px !important;
      margin: 0 auto;
      padding: 20px 20px  20px 20px   !important;
    }
    .container-content{

      padding-top: 60px   !important;
    }
    
    h1,h2,h3,p {
     color: black !important;
    }
    .entry-title {
        display: none;
     margin-bottom: 40px !important;
       margin-top: 20px !important;
    }
    .entry-title-my {
        display: block !important;
     margin-bottom: 30px !important;
       margin-top: 30px !important;
    }
    .hentry {
     margin-bottom: -20px !important;
    }
    
    .wpcf7-form .wpcf7-text {
       BACKGROUND: WHITE !important;
    border: 1px solid black !important;
    border-radius: 3px !important;
        height: 40px;
    }
    
       .wpcf7-form textarea {
       BACKGROUND: WHITE !important;
    border: 1px solid black !important;
    border-radius: 4px !important;
    
    }
    
    .wpcf7-submit  {
color: white;
    height: 60px;
    width: 100%;
    background: #f39c12 !important;
    text-transform: none;
    letter-spacing: -0.5px !important;
    }
    
</style>

	<div id="primary" class="content-area">
		<main id="main" style="padding-top: 0 !important;" class="site-main" role="main">
            
            <div style="background: #f4f4f4;">
            <div class="container-narow">
                <h1 class="entry-title entry-title-my"><?php the_title(); ?></h1>
            </div>
            </div>

		    <div class="container-narow container-content">
			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>
	
            </div>



		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();



