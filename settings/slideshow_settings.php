<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Heading and course images settings page file.
 *
 * @packagetheme_nfdai
 * @copyright  
 * @creditstheme_boost - MoodleHQ
 * @licensehttp://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
$page = new admin_settingpage('theme_nfdai_slideshow', get_string('slideshowsettings', 'theme_nfdai'));


// Show hide user enrollment toggle.
$name = 'theme_nfdai/showslideshow';
$title = get_string('showslideshow', 'theme_nfdai');
$description = get_string('showslideshow_desc', 'theme_nfdai');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// This is the descriptor for slide
$name = 'theme_nfdai/slide1info';
$heading = get_string('slide1info', 'theme_nfdai');
$information = get_string('slide1infodesc', 'theme_nfdai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Slide title
$name = 'theme_nfdai/slide1title';
$title = get_string('slidetitle', 'theme_nfdai');
$description = get_string('slidetitle_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_nfdai/slide1content';
$title = get_string('slidecontent', 'theme_nfdai');
$description = get_string('slidecontent_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
//$name = 'theme_nfdai/slide1image';
//$title = get_string('slideimage', 'theme_nfdai');
//$description = get_string('slideimage_desc', 'theme_nfdai');
//$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide1image');
//$setting->set_updatedcallback('theme_reset_all_caches');
//$page->add($setting);

// This is the descriptor for slide
$name = 'theme_nfdai/slide2info';
$heading = get_string('slide2info', 'theme_nfdai');
$information = get_string('slide2infodesc', 'theme_nfdai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Slide title
$name = 'theme_nfdai/slide2title';
$title = get_string('slidetitle', 'theme_nfdai');
$description = get_string('slidetitle_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_nfdai/slide2content';
$title = get_string('slidecontent', 'theme_nfdai');
$description = get_string('slidecontent_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
//$name = 'theme_nfdai/slide2image';
//$title = get_string('slideimage', 'theme_nfdai');
//$description = get_string('slideimage_desc', 'theme_nfdai');
//$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide2image');
//$setting->set_updatedcallback('theme_reset_all_caches');
//$page->add($setting);

// This is the descriptor for slide
$name = 'theme_nfdai/slide3info';
$heading = get_string('slide3info', 'theme_nfdai');
$information = get_string('slide3infodesc', 'theme_nfdai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);
// Slide title
$name = 'theme_nfdai/slide3title';
$title = get_string('slidetitle', 'theme_nfdai');
$description = get_string('slidetitle_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_nfdai/slide3content';
$title = get_string('slidecontent', 'theme_nfdai');
$description = get_string('slidecontent_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
//$name = 'theme_nfdai/slide3image';
//$title = get_string('slideimage', 'theme_nfdai');
//$description = get_string('slideimage_desc', 'theme_nfdai');
//$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide3image');
//$setting->set_updatedcallback('theme_reset_all_caches');
//$page->add($setting);



// This is the descriptor for slide
$name = 'theme_nfdai/slide4info';
$heading = get_string('slide4info', 'theme_nfdai');
$information = get_string('slide4infodesc', 'theme_nfdai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);
// Slide title
$name = 'theme_nfdai/slide4title';
$title = get_string('slidetitle', 'theme_nfdai');
$description = get_string('slidetitle_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_nfdai/slide4content';
$title = get_string('slidecontent', 'theme_nfdai');
$description = get_string('slidecontent_desc', 'theme_nfdai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
//$name = 'theme_nfdai/slide4image';
//$title = get_string('slideimage', 'theme_nfdai');
//$description = get_string('slideimage_desc', 'theme_nfdai');
//$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide4image');
//$setting->set_updatedcallback('theme_reset_all_caches');
//$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);