<?php

// Template Name: Business Template

get_header();
$quality_pro_options = quality_theme_data_setup();
$current_options = wp_parse_args(get_option('quality_pro_options', array()), $quality_pro_options);

?>
<div id="section-block" class="template-business-home"></div>	
<div class="clearfix"></div>
<?php

if ($current_options['slider_enable'] == true) {
    get_template_part('index', 'static');
}

do_action('quality_sections', false);
//****** get index service  *********/
//****** get index Projects  *********/
//****** get index Blog  *********/
if ($current_options['home_blog_enabled'] == true) {
    get_template_part('index', 'blog');
}
get_footer();
		