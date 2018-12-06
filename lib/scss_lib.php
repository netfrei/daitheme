<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Post process the CSS tree.
 *
 * @param string $tree The CSS tree.
 * @param theme_config $theme The theme config object.
*/ 

function theme_nfdai_css_tree_post_processor($tree, $theme) {
    $prefixer = new theme_boost\autoprefixer($tree);
    $prefixer->prefix();
}

/*
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
 function theme_nfdai_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
   $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');

    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_nfdai', 'preset', 0, '/', $filename))) {
        // This preset file was fetched from the file area for theme_photo and not theme_boost (see the line above).
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }
  	$scss .= file_get_contents($CFG->dirroot . '/theme/nfdai/scss/nfdai_variables.scss');
  	$scss .= file_get_contents($CFG->dirroot . '/theme/nfdai/scss/style.scss');
        // Pre CSS - this is loaded AFTER any prescss from the setting but before the main scss.
        $pre = file_get_contents($CFG->dirroot . '/theme/nfdai/scss/pre.scss');
        // Post CSS - this is loaded AFTER the main scss but before the extra scss from the setting.
         $post = file_get_contents($CFG->dirroot . '/theme/nfdai/scss/post.scss');

    // Combine them together.
    return $pre . "\n" . $scss . "\n" . $post;
}

 

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_nfdai_get_pre_scss($theme) {
    global $CFG, $PAGE;

    $pres= '';

    $configurable = [
    // Config key => variableName,
    'slideshowheight' => ['slideshowheight'],
    ];

    // Add settings variables.
    foreach ($configurable as $configkey => $targets) {
        $value = $theme->settings->{$configkey};
        if (empty($value)) {
            continue;
        }
        array_map(function ($target) use (&$prescss, $value) {
            $prescss .= '$' . $target . ': ' . $value . ";\n";
        }
        , (array)$targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $prescss .= $theme->settings->scsspre;
		
    }

    // Set the default image for the header.
    $slide1image = $theme->setting_file_url('slide1image', 'slide1image');
    if (isset($slide1image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $prescss .= '.slide1image {background-image: url("' . $slide1image . '"); background-size:cover; background-repeat: no-repeat; background-position:center;height:$slideshowheight;}';
    }
 
    // Set the default image for the header.
    $slide2image = $theme->setting_file_url('slide2image', 'slide2image');
    if (isset($slide2image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $prescss .= '.slide2image {background-image: url("' . $slide2image . '"); background-size:cover; background-repeat: no-repeat; background-position:center;height:$slideshowheight;}';
    }

    // Set the default image for the header.
    $slide3image = $theme->setting_file_url('slide3image', 'slide3image');
    if (isset($slide3image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $prescss .= '.slide3image {background-image: url("' . $slide3image . '"); background-size:cover; background-repeat: no-repeat; background-position:center;height:$slideshowheight;}';
    }
	// Set the default image for the header.
    $slide4image = $theme->setting_file_url('slide4image', 'slide4image');
    if (isset($slide4image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $prescss .= '.slide4image {background-image: url("' . $slide4image . '"); background-size:cover; background-repeat: no-repeat; background-position:center;height:$slideshowheight;}';
    }
    return $prescss;
}

/**
 * Copy the updated theme image to the correct location in dataroot for the image to be served
 * by /theme/image.php. Also clear theme caches.
 *
 * @param $settingname
 */
function theme_nfdai_update_settings_images($settingname) {
    global $CFG;

    // The setting name that was updated comes as a string like 's_theme_nfdai_loginbackgroundimage'.
    // We split it on '_' characters.
    $parts = explode('_', $settingname);
    // And get the last one to get the setting name..
    $settingname = end($parts);

    // Admin settings are stored in system context.
    $syscontext = context_system::instance();
    // This is the component name the setting is stored in.
    $component = 'theme_nfdai';


    // This is the value of the admin setting which is the filename of the uploaded file.
    $filename = get_config($component, $settingname);
    // We extract the file extension because we want to preserve it.
    $extension = substr($filename, strrpos($filename, '.') + 1);

    // This is the path in the moodle internal file system.
    $fullpath = "/{$syscontext->id}/{$component}/{$settingname}/0{$filename}";

    // This location matches the searched for location in theme_config::resolve_image_location.
    $pathname = $CFG->dataroot . '/pix_plugins/theme/nfdai/' . $settingname . '.' . $extension;

    // This pattern matches any previous files with maybe different file extensions.
    $pathpattern = $CFG->dataroot . '/pix_plugins/theme/nfdai/' . $settingname . '.*';

    // Make sure this dir exists.
    @mkdir($CFG->dataroot . '/pix_plugins/theme/nfdai/', $CFG->directorypermissions, true);

    // Delete any existing files for this setting.
    foreach (glob($pathpattern) as $filename) {
        @unlink($filename);
    }

    // Get an instance of the moodle file storage.
    $fs = get_file_storage();
    // This is an efficient way to get a file if we know the exact path.
    if ($file = $fs->get_file_by_hash(sha1($fullpath))) {
        // We got the stored file - copy it to dataroot.
        $file->copy_content_to($pathname);
    }

    // Reset theme caches.
    theme_reset_all_caches();
}