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
namespace theme_nfdai\output;
use coding_exception;
use html_writer;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use single_select;
use paging_bar;
use url_select;
use context_course;
use pix_icon;
use theme_config;
defined('MOODLE_INTERNAL') || die;
require_once ($CFG->dirroot . "/course/renderer.php");
require_once ($CFG->libdir . '/coursecatlib.php');
/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_nfdai
 * @copyright   
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {
  /**
     * Prints a nice side block with an optional header.
     *
     * @param block_contents $bc HTML for the content
     * @param string $region the region the block is appearing in.
     * @return string the HTML to be output.
     */
    public function block(block_contents $bc, $region) {
        $bc = clone($bc); // Avoid messing up the object passed in.
        if (empty($bc->blockinstanceid) || !strip_tags($bc->title)) {
            $bc->collapsible = block_contents::NOT_HIDEABLE;
        }

        $id = !empty($bc->attributes['id']) ? $bc->attributes['id'] : uniqid('block-');
        $context = new stdClass();
        $context->skipid = $bc->skipid;
        $context->blockinstanceid = $bc->blockinstanceid;
        $context->dockable = $bc->dockable;
        $context->id = $id;
        $context->hidden = $bc->collapsible == block_contents::HIDDEN;
        $context->skiptitle = strip_tags($bc->title);
        $context->showskiplink = !empty($context->skiptitle);
        $context->arialabel = $bc->arialabel;
        $context->ariarole = !empty($bc->attributes['role']) ? $bc->attributes['role'] : 'complementary';
        $context->type = $bc->attributes['data-block'];
        $context->title = $bc->title;
        $context->content = $bc->content;
        $context->annotation = $bc->annotation;
        $context->footer = $bc->footer;
        $context->hascontrols = !empty($bc->controls);
        $context->type = $bc->attributes['data-block'];
        $context->additionnal_classes = substr(str_replace('block' . $bc->attributes['data-block'] . ' ', '' , $bc->attributes['class']), 6); //remove 'block_data_block' and 'block' class_
        $context->content = $bc->content;
        if ($context->hascontrols) {
            $context->controls = $this->block_controls($bc->controls, $id);
        }

        return $this->render_from_template('core/block', $context);
    }

    
     /**
     * Wrapper for header elements.
     *
     * @return string HTML to display the main header.
     */
    public function full_header() {
        global $PAGE;

        $header = new stdClass();
        $header->settingsmenu = $this->context_header_settings_menu();
        $header->contextheader = $this->context_header();
        $header->hasnavbar = empty($PAGE->layout_options['nonavbar']);
        $header->navbar = $this->navbar();
        $header->pageheadingbutton = $this->page_heading_button();
        $header->courseheader = $this->course_header();
        return $this->render_from_template('theme_nfdai/header', $header);
    }
    public function image_url($imagename, $component = 'moodle') {
        // Strip -24, -64, -256  etc from the end of filetype icons so we
        // only need to provide one SVG, see MDL-47082.
        $imagename = \preg_replace('/-\d\d\d?$/', '', $imagename);
        return $this->page->theme->image_url($imagename, $component);
    }


    public function fp_slideshow() {
        global $PAGE;
        $theme = theme_config::load('nfdai');
        $slideshowon = $PAGE->theme->settings->showslideshow == 1;
	$howitworks= get_string('howitworks','theme_nfdai');	
       
        // show only slide if has image
        //$hasslide1 = (empty($theme->setting_file_url('slide1image', 'slide1image'))) ? false : $theme->setting_file_url('slide1image', 'slide1image');
		// show slide even if no image 
        $hasslide1 = (empty($theme->setting_file_url('slide1image', 'slide1image'))) ? true : $theme->setting_file_url('slide1image', 'slide1image');
        $slide1 = (empty($PAGE->theme->settings->slide1title)) ? false : $PAGE->theme->settings->slide1title;
		$slide1content = (empty($PAGE->theme->settings->slide1content)) ? false : format_text($PAGE->theme->settings->slide1content);
        $showtext1 = (empty($PAGE->theme->settings->slide1title)) ? false : format_text($PAGE->theme->settings->slide1title);
         
	   	//show only slide if has image
	    //$hasslide2 = (empty($theme->setting_file_url('slide2image', 'slide2image'))) ? false : $theme->setting_file_url('slide2image', 'slide2image');
        // show slide even if no image
		$hasslide2 = (empty($theme->setting_file_url('slide2image', 'slide2image'))) ? true : $theme->setting_file_url('slide2image', 'slide2image');
		$slide2 = (empty($PAGE->theme->settings->slide2title)) ? false : $PAGE->theme->settings->slide2title;
        $slide2content = (empty($PAGE->theme->settings->slide2content)) ? false : format_text($PAGE->theme->settings->slide2content);
        $showtext2 = (empty($PAGE->theme->settings->slide2title)) ? false : format_text($PAGE->theme->settings->slide2title);

		//$hasslide3 = (empty($theme->setting_file_url('slide3image', 'slide3image'))) ? false : $theme->setting_file_url('slide3image', 'slide3image');
		$hasslide3 = (empty($theme->setting_file_url('slide3image', 'slide3image'))) ? true : $theme->setting_file_url('slide3image', 'slide3image');
		$slide3 = (empty($PAGE->theme->settings->slide3title)) ? false : $PAGE->theme->settings->slide3title;
        $slide3content = (empty($PAGE->theme->settings->slide3content)) ? false : format_text($PAGE->theme->settings->slide3content);
        $showtext3 = (empty($PAGE->theme->settings->slide3title)) ? false : format_text($PAGE->theme->settings->slide3title);
		
		//$hasslide4 = (empty($theme->setting_file_url('slide4image', 'slide4image'))) ? false : $theme->setting_file_url('slide4image', 'slide4image');
		$hasslide4 = (empty($theme->setting_file_url('slide4image', 'slide4image'))) ? true : $theme->setting_file_url('slide4image', 'slide4image');
        $slide4 = (empty($PAGE->theme->settings->slide4title)) ? false : $PAGE->theme->settings->slide4title;
        $slide4content = (empty($PAGE->theme->settings->slide4content)) ? false : format_text($PAGE->theme->settings->slide4content);
        $showtext4 = (empty($PAGE->theme->settings->slide4title)) ? false : format_text($PAGE->theme->settings->slide4title);
		
        $fp_slideshow = [
            'howitworks' => $howitworks,
            'hasfpslideshow' => $slideshowon, 
            'hasslide1' => $hasslide1 ? true : false, 
            'hasslide2' => $hasslide2 ? true : false,
            'hasslide3' => $hasslide3 ? true : false, 
            'hasslide4' => $hasslide4 ? true : false, 
            'showtext1' => $showtext1 ? true : false, 
            'showtext2' => $showtext2 ? true : false, 
            'showtext3' => $showtext3 ? true : false,  
            'showtext4' => $showtext4 ? true : false, 
            'slide1' => array(
            'slidetitle' => $slide1,
            'slidecontent' => $slide1content
        ) , 'slide2' => array(
            'slidetitle' => $slide2,
            'slidecontent' => $slide2content
        ) , 'slide3' => array(
            'slidetitle' => $slide3,
            'slidecontent' => $slide3content
        ) , 'slide4' => array(
            'slidetitle' => $slide4,
            'slidecontent' => $slide4content
        ) ,];
        return $this->render_from_template('theme_nfdai/slideshow', $fp_slideshow);
    }
}