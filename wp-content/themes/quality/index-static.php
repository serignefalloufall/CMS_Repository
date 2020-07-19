<!-- Quality Main Slider --->
<?php
$quality_pro_options = quality_theme_data_setup();
$current_options = wp_parse_args(get_option('quality_pro_options', array()), $quality_pro_options);
?>

<!-- /Quality Main Slider --->
<section id="slider-carousel">
    <div id="post-<?php the_ID(); ?>" class="item"
    <?php if ($current_options['home_feature'] != '') { ?>
             style="background-image:url(<?php echo esc_url($current_options['home_feature']); ?>)" <?php } ?>>

        <div class="container">
            <?php if ($current_options['home_image_title'] != '' || $current_options['home_image_sub_title'] != '' || $current_options['home_image_description'] != '' || $current_options['home_image_button_text'] != '') : ?>
                <div class="slider-caption">
                    <?php if ($current_options['home_image_title']) { ?>
                        <h5><?php echo esc_html($current_options['home_image_title']); ?></h5>
                        <?php
                    }
                    if ($current_options['home_image_sub_title']) {
                        ?>
                        <h1><?php echo esc_html($current_options['home_image_sub_title']); ?></h1>
                        <?php
                    }
                    if ($current_options['home_image_description']) {
                        ?>
                        <p><?php echo esc_html($current_options['home_image_description']); ?></p>
                        <?php
                    }
                    if ($current_options['home_image_button_text'] != '') {
                        ?>
                        <div class="slide-btn-area-sm">
                            <a class="slide-btn-sm" href="<?php echo esc_url($current_options['home_image_button_link']); ?>" target="_blank">
                                <?php echo esc_html($current_options['home_image_button_text']); ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>