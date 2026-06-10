<?php
// Fallback - homepage handled by front-page.php
get_header();
echo '<main>'; if (have_posts()) { while (have_posts()) { the_post(); the_content(); } }
echo '</main>';
get_footer();
