<?php
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'dai';
$THEME->sheets = array('style');
$THEME->editor_sheets = [];
$THEME->parents = ['boost'];
$THEME->enable_dock = false;
$THEME->yuicssmodules = array();
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

//$THEME->sheets = array('custom');
$THEME->scss = function($theme) {
    return theme_dai_get_main_scss_content($theme);
};

$THEME->layouts = [
    // The site home page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre', 'center-post'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    )
];