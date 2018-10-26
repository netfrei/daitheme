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
 * @packagetheme_dai
 * @copyright  
 * @creditstheme_boost - MoodleHQ
 * @licensehttp://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
$page = new admin_settingpage('theme_dai_slideshow', get_string('slideshowsettings', 'theme_dai'));


// Show hide user enrollment toggle.
$name = 'theme_dai/showslideshow';
$title = get_string('showslideshow', 'theme_dai');
$description = get_string('showslideshow_desc', 'theme_dai');
$default = 0;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// This is the descriptor for slide
$name = 'theme_dai/slide1info';
$heading = get_string('slide1info', 'theme_dai');
$information = get_string('slide1infodesc', 'theme_dai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Slide title
$name = 'theme_dai/slide1title';
$title = get_string('slidetitle', 'theme_dai');
$description = get_string('slidetitle_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_dai/slide1content';
$title = get_string('slidecontent', 'theme_dai');
$description = get_string('slidecontent_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
$name = 'theme_dai/slide1image';
$title = get_string('slideimage', 'theme_dai');
$description = get_string('slideimage_desc', 'theme_dai');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide1image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for slide
$name = 'theme_dai/slide2info';
$heading = get_string('slide2info', 'theme_dai');
$information = get_string('slide2infodesc', 'theme_dai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Slide title
$name = 'theme_dai/slide2title';
$title = get_string('slidetitle', 'theme_dai');
$description = get_string('slidetitle_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_dai/slide2content';
$title = get_string('slidecontent', 'theme_dai');
$description = get_string('slidecontent_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
$name = 'theme_dai/slide2image';
$title = get_string('slideimage', 'theme_dai');
$description = get_string('slideimage_desc', 'theme_dai');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide2image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for slide
$name = 'theme_dai/slide3info';
$heading = get_string('slide3info', 'theme_dai');
$information = get_string('slide3infodesc', 'theme_dai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);
// Slide title
$name = 'theme_dai/slide3title';
$title = get_string('slidetitle', 'theme_dai');
$description = get_string('slidetitle_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_dai/slide3content';
$title = get_string('slidecontent', 'theme_dai');
$description = get_string('slidecontent_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
$name = 'theme_dai/slide3image';
$title = get_string('slideimage', 'theme_dai');
$description = get_string('slideimage_desc', 'theme_dai');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide3image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);



// This is the descriptor for slide
$name = 'theme_dai/slide4info';
$heading = get_string('slide4info', 'theme_dai');
$information = get_string('slide4infodesc', 'theme_dai');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);
// Slide title
$name = 'theme_dai/slide4title';
$title = get_string('slidetitle', 'theme_dai');
$description = get_string('slidetitle_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Slide Description
$name = 'theme_dai/slide4content';
$title = get_string('slidecontent', 'theme_dai');
$description = get_string('slidecontent_desc', 'theme_dai');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// logo image.
$name = 'theme_dai/slide4image';
$title = get_string('slideimage', 'theme_dai');
$description = get_string('slideimage_desc', 'theme_dai');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'slide4image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);