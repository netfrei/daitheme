<?php
 
// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.
                                                                                              
 
// This is used for performance, we don't need to know about these settings on every page in Moodle, only when                      
// we are looking at the admin settings pages.                                                                                      
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Note new tabs layout for admin settings pages.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingdai', get_string('configtitle', 'theme_dai'));
    require('settings/slideshow_settings.php');
 
}
 
