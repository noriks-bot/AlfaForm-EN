<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function renderRecommendedVideo( $videos, $title = 'Recommended Videos' ) {
	?>

	<div class="card-video card">
        <div class="d-flex align-items-center">
            <div class="card-header card-video-header header-opened card-header-style2 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <h4 class="font-semibold"><?php echo $title;?></h4>
                </div>

                <div>
					<?php cardCollapseBtn(); ?>
                </div>
            </div>
        </div>

        <div class="card-body card-body-gray" style="display: block;">
            <div class="video-links-wrapper">
				<?php foreach ( $videos as $video ) : ?>
					<div class="video-block-item">
						<?php include PYS_FREE_VIEW_PATH . '/UI/youtube-icon.php'; ?>
						<div class="youtube-title">
							<div>
								<p class="title primary_heading">
									<?php echo esc_html( $video['title'] ); ?>
								</p>
							</div>
							<div>
								<p class="time">
									<?php echo esc_html( $video['time'] ); ?> min
								</p>
							</div>
						</div>

						<a class="video-link secondary_heading btn-gray btn-small" href="<?php echo esc_url( $video['url'] ); ?>"
						   target="_blank">Watch Now</a>
					</div>
				<?php endforeach; ?>
            </div>

            <div class="watch-more">
                <a href="https://www.youtube.com/channel/UCnie2zvwAjTLz9B4rqvAlFQ" target="_blank"
                   class="link link-underline primary_heading">Watch more on our
                    YouTube channel</a>
            </div>
        </div>
    </div>
<?php
}