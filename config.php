<?php
defined('MOODLE_INTERNAL') || die();
// Call the theme lib file.
require_once(__DIR__ . '/lib.php');

$THEME->name = 'dai';
//$THEME->sheets = array('style');
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->parents = ['boost'];
$THEME->enable_dock = false;

$THEME->layouts = [
    // The site home page.
    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
	],
];
// Call main theme scss - including the selected preset.
$THEME->scss = function($theme) {
    return theme_dai_get_main_scss_content($theme);
};

// Call css/scss processing functions and renderers.
$THEME->csstreepostprocessor = 'theme_dai_css_tree_post_processor';
$THEME->prescsscallback = 'theme_dai_get_pre_scss';
$THEME->extrascsscallback = 'theme_dai_get_extra_scss';
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

$THEME->enable_dock = false;
$THEME->yuicssmodules = array();
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
