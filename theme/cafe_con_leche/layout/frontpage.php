<?php
if (!empty($CFG->themedir) and file_exists("$CFG->themedir/cafe_con_leche")) {
    require_once ($CFG->themedir."/cafe_con_leche/lib.php");
} else {
    require_once ($CFG->dirroot."/theme/cafe_con_leche/lib.php");
}

// $PAGE->blocks->region_has_content('region_name') doesn't work as we do some sneaky stuff 
// to hide nav and/or settings blocks if requested
$blocks_side_pre = trim($OUTPUT->blocks_for_region('side-pre'));
$hassidepre = strlen($blocks_side_pre);
$blocks_side_post = trim($OUTPUT->blocks_for_region('side-post'));
$hassidepost = strlen($blocks_side_post);

if (empty($PAGE->layout_options['noawesomebar'])) {
    $topsettings = $this->page->get_renderer('theme_cafe_con_leche','topsettings');
    cafe_con_leche_initialise_awesomebar($PAGE);
    $awesome_nav = $topsettings->navigation_tree($this->page->navigation);
    $awesome_settings = $topsettings->settings_tree($this->page->settingsnav);
}

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();

if(!empty($PAGE->theme->settings->useeditbuttons) && $PAGE->user_allowed_editing()) {
    if (cafe_con_leche_initialise_editbuttons($PAGE)) {
        $bodyclasses[] = 'cafe_con_leche_with_edit_buttons';
    }
}

if ($hassidepre && !$hassidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($hassidepost && !$hassidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$hassidepost && !$hassidepre) {
    $bodyclasses[] = 'content-only';
}

if(!empty($PAGE->theme->settings->persistentedit)) {
    if(property_exists($USER, 'editing') && $USER->editing) {
        $OUTPUT->set_really_editing(true);
    }
    if ($PAGE->user_allowed_editing()) {
        $USER->editing = 1;
        $bodyclasses[] = 'cafe_con_leche_persistent_edit';
    }
}

if(!empty($PAGE->theme->settings->usemodchoosertiles)) {
    $bodyclasses[] = 'cafe_con_leche_modchooser_tiles';
}

if (!empty($PAGE->theme->settings->footnote)) {
    $footnote = $PAGE->theme->settings->footnote;
} else {
    $footnote = '<!-- There was no custom footnote set -->';
}

// Tell IE to use the latest engine (no Compatibility mode), if the user is using IE.
$ie = false;
if (class_exists('core_useragent')) {
    if (core_useragent::check_ie_version()) {
        $ie = true;
    }
} else if (check_browser_version("MSIE", "0")) {
    $ie = true;
}
if ($ie) {
    header('X-UA-Compatible: IE=edge');
}

echo $OUTPUT->doctype() ?>
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
	
    <meta name="description" content="<?php echo strip_tags(format_text($SITE->summary, FORMAT_HTML)) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <script type="text/javascript">
    YUI().use('node', function(Y) {
        window.thisisy = Y;
    	Y.one(window).on('scroll', function(e) {
    	    var node = Y.one('#back-to-top');

    	    if (Y.one('window').get('docScrollY') > Y.one('#page-content-wrapper').getY()) {
    		    node.setStyle('display', 'block');
    	    } else {
    		    node.setStyle('display', 'none');
    	    }
    	});

    });
    </script>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html();
if (empty($PAGE->layout_options['noawesomebar'])) {  ?>
    <div id="awesomebar" class="cafe_con_leche-awesome-bar">
        <?php
                echo $awesome_nav;
                if ($hascustommenu && !empty($PAGE->theme->settings->custommenuinawesomebar) && empty($PAGE->theme->settings->custommenuafterawesomebar)) {
                    echo $custommenu;
                }
                echo $awesome_settings;
                if ($hascustommenu && !empty($PAGE->theme->settings->custommenuinawesomebar) && !empty($PAGE->theme->settings->custommenuafterawesomebar)) {
                    echo $custommenu;
                }
                echo $topsettings->settings_search_box();
        ?>
    </div>
<?php } ?>

<div id="page">

<!-- START OF HEADER -->
    <?php 
		//Fondo de la cabecera
		if (!empty($PAGE->theme->settings->fondo_cabecera)) {
			$theme = theme_config::load('cafe_con_leche');
			$fondourl = $PAGE->theme->setting_file_url('fondo_cabecera', 'fondo_cabecera');
			echo "<div id=\"page-header\" style='background-image: url(".$fondourl.");background-size: 100% 100%;' class=\"clearfix\">";
		} else {
			echo "<div id=\"page-header\" class=\"clearfix\">";
		}
	?>
    <!--<div id="page-header" class="clearfix">-->
		<div id="page-header-wrapper">
	        <div class="logo">
				<?php 
					$logo = $PAGE->theme->settings->logotipo;
					$extension = pathinfo($logo, PATHINFO_EXTENSION);
					$nombre_base = basename($logo, '.'.$extension);  
					$setting = 'logotipo';
					$theme = theme_config::load('cafe_con_leche');
					$banner = $theme->setting_file_url($setting, $setting);
					if (!empty($PAGE->theme->settings->logotipo)) {
						$logourl = $PAGE->theme->setting_file_url('logotipo', 'logotipo');
					} else {
						$logourl = $OUTPUT->pix_url('logo', 'theme');
					}
				?>
				<div id="centrador">	
					<a href="<?php echo $CFG->wwwroot ?>"><img class="userpicture" alt="Logo" title="<?php print_string('home'); ?>" style="max-height:105px" src="<?php echo $logourl ?>" /></a>
				</div>
			</div>
			<div class="titulo">
				<h1 class="headermain"><?php echo $PAGE->heading ?></h1>
			</div>
    	    <div class="headermenu">
        		<?php
        		    if (!empty($PAGE->theme->settings->showuserpicture)) {
        				if (isloggedin())
        				{
        					echo ''.$OUTPUT->user_picture($USER, array('size'=>55)).'';
        				}
        				else {
        					?>
						<img class="userpicture" src="<?php echo $OUTPUT->pix_url('image', 'theme'); ?>" />
						<?php
        				}
        			}
        		echo $OUTPUT->login_info();
    	        echo $OUTPUT->lang_menu();
	        	echo $PAGE->headingmenu;
		        ?>	    
	    	</div>
	    </div>
    </div>
    
    <?php if ($hascustommenu && empty($PAGE->theme->settings->custommenuinawesomebar)) { ?>
      <div id="custommenu" class="cafe_con_leche-awesome-bar"><?php echo $custommenu; ?></div>
 	<?php } ?>
  	  
<!-- END OF HEADER -->

<!-- START OF CONTENT -->

<div id="page-content-wrapper" class="clearfix">
    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">
            
                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
                            <?php echo method_exists($OUTPUT, "main_content")?$OUTPUT->main_content():core_renderer::MAIN_CONTENT_TOKEN ?>
                        </div>
                    </div>
                </div>
                
                <?php if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                        <?php echo $blocks_side_pre ?>
                    </div>
                </div>
                <?php } ?>
                
                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                        <?php echo $blocks_side_post ?>
                    </div>
                </div>
                <?php } ?>
                
            </div>
        </div>
    </div>
</div>

<!-- END OF CONTENT -->

<!-- START OF FOOTER -->

    <div id="page-footer">
		<div class="footnote"><?php echo $footnote; ?></div>
        <p class="helplink">
        <?php echo page_doc_link(get_string('moodledocslink')) ?>
        </p>

        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>

<!-- END OF FOOTER -->

</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<div id="back-to-top"> 
    <a class="arrow" href="#">▲</a> 
    <a class="text" href="#">Back to Top</a> 
</div>
</body>
</html>
