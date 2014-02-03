<?php echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <?php 
		$setting = 'favicon';
		$theme = theme_config::load('cafe_con_leche');
		$banner = $theme->setting_file_url($setting, $setting);
		if (!empty($PAGE->theme->settings->favicon)) {
			$faviconurl = $PAGE->theme->setting_file_url('favicon', 'favicon');
		} else {
			$faviconurl = $OUTPUT->pix_url('favicon', 'theme');
		}
	?>
    <link rel="shortcut icon" href="<?php echo $faviconurl ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

<!-- END OF HEADER -->

    <div id="content" class="clearfix">
        <?php echo method_exists($OUTPUT, "main_content")?$OUTPUT->main_content():core_renderer::MAIN_CONTENT_TOKEN ?>
    </div>

<!-- START OF FOOTER -->
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>