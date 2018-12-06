<?php
defined('MOODLE_INTERNAL') || die();
// Call the theme lib file.
require_once(__DIR__ . '/lib.php');
 
$THEME->name = 'nfdai';
//$THEME->sheets = array('style');
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->parents = ['boost'];
$THEME->enable_dock = false;

$THEME->layouts = [
    // The site home page.
    'frontpage'=> array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre', 'left-region'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
      // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre', 'left-region'),
        'defaultregion' => 'left-region',
    ),
    // Main course page.
    'course' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre', 'left-region'),
        'defaultregion' => 'left-region',
        'options' => array('langmenu' => true),
    ),
    'coursecategory' => array(
        'file' => 'columns2.php',
        'regions' => array('left-region'),
        'defaultregion' => 'left-region',
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'columns2.php',
        'regions' => array('left-region'),
        'defaultregion' => 'left-region',
    ),
    
    // Server administration scripts.
    'admin' => array(
        'file' => 'columns2.php',
        'regions' => array('left-region'),
        'defaultregion' => 'left-region',
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => 'columns2.php',
        'regions' => array('left-region'),
        'defaultregion' => 'left-region',
        'options' => array('nonavbar' => true, 'langmenu' => true),
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'columns2.php',
        'regions' => array('left-region'),
        'defaultregion' => 'left-region',
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'columns2.php',
        'regions' => array('left-region'),
        'defaultregion' => 'left-region',
    )
    
];
// Call main theme scss - including the selected preset.
$THEME->scss = function($theme) {
    return theme_nfdai_get_main_scss_content($theme);
};
// Call css/scss processing functions and renderers.
$THEME->csstreepostprocessor = 'theme_nfdai_css_tree_post_processor';
$THEME->prescsscallback = 'theme_nfdai_get_pre_scss';
$THEME->extrascsscallback = 'theme_nfdai_get_extra_scss';
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

$THEME->enable_dock = false;
$THEME->yuicssmodules = array();
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
