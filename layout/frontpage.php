<?php

defined('MOODLE_INTERNAL') || die();
#$hascenterpost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('center-post', $OUTPUT));
user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
require_once($CFG->libdir . '/behat/lib.php');

if (isloggedin()) {
    $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
    if ($USER->username != "guest") {
        $login = true;
    }
} else {
    $navdraweropen = false;
    $login = false;
}
$extraclasses = [];
if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'siteurl' => "$CFG->wwwroot",
    'output' => $OUTPUT,
    'loggedIn' => $login,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'navdraweropen' => $navdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
];
$PAGE->requires->jquery();
$PAGE->requires->js('/theme/dai/javascript/scrolltotop.js');
$PAGE->requires->js('/theme/dai/javascript/tooltipfix.js');
$templatecontext['flatnavigation'] = $PAGE->flatnav;
echo $OUTPUT->render_from_template('theme_dai/frontpage', $templatecontext);



 