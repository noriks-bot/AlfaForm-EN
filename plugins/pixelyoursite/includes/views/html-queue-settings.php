<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="cards-wrapper cards-wrapper-style2 gap-24 setting-wrapper">
    <!-- Queue System Status -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Queue System Status', 'pixelyoursite'); ?></h4>
            <?php renderProBadge(); ?>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div>
                        <div class="d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Enable Queue System', 'pixelyoursite'); ?></h4>
                        </div>
                        <p class="text-gray mt-4">
                            <?php _e('Enable the queue system to replace async tasks. This will improve performance by processing events in batches instead of individually.', 'pixelyoursite'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Processing Configuration -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Processing Configuration', 'pixelyoursite'); ?></h4>
            <?php renderProBadge(); ?>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="d-flex align-items-center number-option-block">
                        <label class="primary_heading"><?php _e('Max Events Per Batch:', 'pixelyoursite'); ?></label>
                        <?php renderDummyNumberInput(10); ?>
                    </div>
                    <p class="text-gray">
                        <?php _e('Maximum number of events to process in one batch (1-1000). Higher values may improve performance but use more memory.', 'pixelyoursite'); ?>
                    </p>

                    <div>
                        <h4 class="primary_heading mb-4"><?php _e('Processing Interval:', 'pixelyoursite'); ?></h4>
                        <?php renderDummySelectInput('5 minutes'); ?>

                        <p class="text-gray mt-4">
                            <?php _e('How often to process the events queue. More frequent processing provides faster event delivery but uses more server resources.', 'pixelyoursite'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Queue Limits -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Queue Limits', 'pixelyoursite'); ?></h4>
            <?php renderProBadge(); ?>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="d-flex align-items-center number-option-block">
                        <label class="primary_heading"><?php _e('Max Queue Size:', 'pixelyoursite'); ?></label>
                        <?php renderDummyNumberInput(100); ?>
                    </div>
                    <p class="text-gray">
                        <?php _e('Maximum number of events in queue before dropping new events (100-100000). Prevents memory issues during high traffic periods.', 'pixelyoursite'); ?>
                    </p>

                    <div class="d-flex align-items-center number-option-block">
                        <label class="primary_heading"><?php _e('Max Retries:', 'pixelyoursite'); ?></label>
                        <?php renderDummyNumberInput(3); ?>
                    </div>
                    <p class="text-gray">
                        <?php _e('Maximum number of retry attempts for failed events (0-10). Failed events will be retried this many times before being marked as permanently failed.', 'pixelyoursite'); ?>
                    </p>

                    <div class="d-flex align-items-center number-option-block">
                        <label class="primary_heading"><?php _e('Retention Days:', 'pixelyoursite'); ?></label>
                        <?php renderDummyNumberInput(1); ?>
                    </div>
                    <p class="text-gray">
                        <?php _e('Number of days to keep processed/failed events in the database (1-30). Older events will be automatically cleaned up to save space.', 'pixelyoursite'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Queue Statistics -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Queue Statistics', 'pixelyoursite'); ?></h4>

            <div class="queue-actions">
                <?php renderProBadge(); ?>
                <button type="button" id="refresh-stats" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-refresh"></i> <?php _e('Refresh', 'pixelyoursite'); ?>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="queue-stats-grid" id="queue-stats-container">
                        <div class="stat-card stat-pending">
                            <h3 class="stat-number" id="pending-count">0</h3>
                            <p class="stat-label"><?php _e('Pending Events', 'pixelyoursite'); ?></p>
                        </div>
                        <div class="stat-card stat-processed">
                            <h3 class="stat-number" id="processed-count">0</h3>
                            <p class="stat-label"><?php _e('Processed Today', 'pixelyoursite'); ?></p>
                        </div>
                        <div class="stat-card stat-failed">
                            <h3 class="stat-number" id="failed-count">0</h3>
                            <p class="stat-label"><?php _e('Failed Events', 'pixelyoursite'); ?></p>
                        </div>
                        <div class="stat-card stat-total">
                            <h3 class="stat-number" id="total-count">0</h3>
                            <p class="stat-label"><?php _e('Total Events', 'pixelyoursite'); ?></p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 flex-wrap queue-status-info">
                        <div class="col-md-6">
                            <p class="text-gray mb-12">
                                <strong><?php _e('Last Processed:', 'pixelyoursite'); ?></strong>
                                <span id="last-processed"><?php _e('Never', 'pixelyoursite'); ?></span>
                            </p>
                            <p class="text-gray mb-2">
                                <strong><?php _e('Queue Status:', 'pixelyoursite'); ?></strong>
                                <span id="queue-status" class="queue-status idle">
                                    <?php _e('Idle', 'pixelyoursite'); ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-gray mb-12">
                                <strong><?php _e('Processing Rate:', 'pixelyoursite'); ?></strong>
                                <span id="processing-rate">0</span> <?php _e('events/min', 'pixelyoursite'); ?>
                            </p>
                            <p class="text-gray mb-2">
                                <strong><?php _e('Success Rate:', 'pixelyoursite'); ?></strong>
                                <span id="success-rate">100%</span>
                            </p>
                        </div>
                    </div>

                    <div class="queue-management-actions">
                        <div class="d-flex gap-3 flex-wrap">
                            <button type="button" id="manual-process-queue" class="btn btn-primary">
                                <i class="fa fa-play"></i> <?php _e('Process Queue Now', 'pixelyoursite'); ?>
                            </button>
                            <button type="button" id="clear-old-records" class="btn btn-warning">
                                <i class="fa fa-trash"></i> <?php _e('Clear Old Records', 'pixelyoursite'); ?>
                            </button>
                            <button type="button" id="reset-failed-events" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> <?php _e('Reset Failed Events', 'pixelyoursite'); ?>
                            </button>
                        </div>
                        <p class="text-gray mt-3">
                            <?php _e('Use these actions to manually manage your event queue. Process Queue Now will immediately start processing pending events. Clear Old Records will remove processed events older than the retention period.', 'pixelyoursite'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
