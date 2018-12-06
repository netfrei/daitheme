<?php

namespace theme_nfdai\output\core;

defined('MOODLE_INTERNAL') || die();

use moodle_url;
use lang_string;
use coursecat_helper;
use coursecat;
use stdClass;
use course_in_list;
use context_course;
use context_system;
use pix_url;
use html_writer;
use heading;
use pix_icon;
use image_url;
use single_select;

require_once ($CFG->dirroot . '/course/renderer.php');
global $PAGE;
global $DB;


class course_renderer extends \theme_boost\output\core\course_renderer {
   
   protected $countcategories = 0;
    public function frontpage_available_courses($id = 0) {          
            $catcommingsoon = get_string('comingsoon','theme_nfdai');        
            $comingsoonclass='';
            global $CFG, $OUTPUT, $PAGE;
            $trimtitlevalue= 100;
            require_once ($CFG->libdir . '/coursecatlib.php');

            $chelper = new coursecat_helper();
            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->set_courses_display_options(array(
                'recursive' => true,
                'limit' => $CFG->frontpagecourselimit,
                'viewmoreurl' => new moodle_url('/course/index.php') ,
                'viewmoretext' => new lang_string('fulllistofcourses')
            ));
	
            $chelper->set_attributes(array(
                'class' => 'frontpage-course-list-all'
            ));
            
            $courses = coursecat::get($id)->get_courses($chelper->get_courses_display_options());
            $totalcount = coursecat::get($id)->get_courses_count($chelper->get_courses_display_options());            
            $rcourseids = array_keys($courses);
            $acourseids = array_chunk($rcourseids, 4);
    			
            $coursesheader = get_string('availablecourses');
            $header = '
                <div id="category-course-list">
                <div class="courses category-course-list-all"> 
                <div class="class-list">
                    <h2  class="centerit">'.$coursesheader . '</h2>
                </div>';
            $content = '';
            $footer = '<div class="viewallcourses"><a href="course/index.php" data-tooltip="tooltip" data-placement="top" title="'.get_string('allcourses','theme_nfdai'). '"><h3>'.get_string('allcourses','theme_nfdai').'</h3></a> </div>
                </div>
                </div>';

            if (count($rcourseids) > 0) {
                $content .= '<div class="container-fluid"> <div class="row">';
                foreach ($acourseids as $courseids) {                 
                    $rowcontent = '';
                    foreach ($courseids as $courseid) {
                        $course = get_course($courseid);
                        //trim after 100 chararcters
                        //$trimtitle = $course->fullname;
                        $trimtitle = format_string(theme_nfdai_course_trim_char($course->fullname, $trimtitlevalue));
                        $summary = theme_nfdai_strip_html_tags($course->summary);
                        $summary = format_text(theme_nfdai_course_trim_char($summary));
                        //$noimgurl = $OUTPUT->image_url('noimg', 'theme');
                        $courseurl = new moodle_url('/course/view.php', array(
                            'id' => $courseid
                        ));
                        if ($course instanceof stdClass) {
                            require_once ($CFG->libdir . '/coursecatlib.php');
                            $course = new course_in_list($course);
                        }
                        // print enrolmenticons
                        $pixcontent = '';
                        if ($icons = enrol_get_course_info_icons($course)) {
                            $pixcontent .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
                            foreach ($icons as $pix_icon) {
                                $pixcontent .= $this->render($pix_icon);
                            }
                            $pixcontent .= html_writer::end_tag('div'); // .enrolmenticons
                        }
                        // display course category if necessary (for example in search results)
                        require_once($CFG->libdir. '/coursecatlib.php');
                        if ($cat = coursecat::get($course->category, IGNORE_MISSING)) {
                            // get Top Parent Category ID (in path)
                            
                            if (!strcasecmp ($catcommingsoon, $cat->get_formatted_name() )){
                                $comingsoonclass =strtolower(preg_replace('/\s+/', '', $catcommingsoon));
                                //echo "<script> console.log(".$cat->get_formatted_name().")</script>" ;
                            } else {
                                $comingsoonclass='';    
                            }
                            $nfcatgeroy_path=explode("/",$cat->path);
                            #print_object($nfcatgeroy_path[1]);					
                            $nfcategroyid=$nfcatgeroy_path[1];	
                            $nfgetcategorybyid = coursecat::get($nfcategroyid, IGNORE_MISSING);
                            #print_object($nfgetcategorybyid->name);
                            // immediate parent category id 

                            $catcontent = html_writer::start_tag('div', array('class' => 'coursecat'));
                            #print_object($catcontent);
                            $catcontent .= html_writer::span($nfgetcategorybyid->get_formatted_name());
                            //$catcontent .= html_writer::link(new moodle_url('/course/index.php', array('categoryid' =>  $cat->id)),	$nfgetcategorybyid->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
                            //$catcontent .= html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $nfcategroyid)),	$nfgetcategorybyid->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
                            $catcontent .= $pixcontent;
                            $catcontent .= html_writer::end_tag('div'); // .coursecat
                        } 
                        // Load from config if usea a img from course summary file if not exist a img then a default one ore use a fa-icon.
                        $imgurl = '';
                        $context = context_course::instance($course->id);
                        foreach ($course->get_course_overviewfiles() as $file) {
                            $isimage = $file->is_valid_image();
                            $imgurl = file_encode_url("$CFG->wwwroot/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename() , !$isimage);
//                            if (!$isimage) {
//                                $imgurl = $noimgurl;
//                            }
                        }
                        if (empty($imgurl)) {
                            $imgurl = $PAGE->theme->setting_file_url('headerdefaultimage', 'headerdefaultimage', true);
//                            if (!$imgurl) {
//                                $imgurl = $noimgurl;
//                            }
                        }
                         
                        $rowcontent .= '
                        <div class="col-md-4 col-sm-6 col-xs-12 nfcourseboxes ">';
                        $rowcontent .= html_writer::start_tag('div', array(
                            'class' => $course->visible ? 'coursevisible' : 'coursedimmed1'
                        ));
                        if ($comingsoonclass){
                            $rowcontent .= '
                            <div class="class-box comingsoon">
                            ';
                            $rowcontent .= '<span class="cornertext">'.$catcommingsoon.'</span>';
                        }else{
                            $rowcontent .= '
                                <div class="class-box">
                                ';
                        }
                        $tooltiptext = 'data-tooltip="tooltip" data-placement= "top" title="' . format_string($course->fullname) . '"';
                         
                        $extraclass ='class="d-block mb-4 h-100"';
                        $rowcontent .= '
                            <a '. $tooltiptext . ' href="' . $courseurl . '">
                            <div class="courseimagecontainer">
                            <div class="course-image-view" style="background-image: url(' . $imgurl . ');background-repeat: no-repeat;background-size:cover; background-position:center;">
                            </div>
                            <div class="course-overlay">
                            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                            </div>

                            </div></a>
                            <div class="course-info">
                             <div class="course-summary">
                                        ' . $catcontent . '
                                <div class="course-title">
                                <a '. $tooltiptext . ' href="' . $courseurl . '">
                              <h4 class="coursetitle">' . $trimtitle . '</h4> 
                                </a>
                            </div>                                   
                            ';

                        $rowcontent .= '
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>';
                         
                    }
                    $content .= $rowcontent;     
                }
                $content .= '</div> </div>';
            }
            $coursehtml = $header . $content . $footer;
            if ($id == 0) {
                echo $coursehtml;
            }
            else {
                $coursehtml .= '<br/><br/>';
                return $coursehtml;
            }
    }
    
    public function view_available_courses($id = 0, $courses = null, $totalcount = null) {
        $catcommingsoon = get_string('comingsoon','theme_nfdai');
        $comingsoonclass='';
        global $CFG, $OUTPUT, $PAGE;
       
        $rcourseids = array_keys($courses);
        $acourseids = array_chunk($rcourseids, 100);
             
           // echo "<script>console.log(".json_encode(var_export($acourseids,true)).");</script>";
           

        $header = '';
        $content = '';
        $footer='';
        if (count($rcourseids) > 0) {

            $rowcontent = '';
            $rowcontent .= '';
            foreach ($acourseids as $courseids) {

                
                foreach ($courseids as $courseid) {
                    $course = get_course($courseid);
                    $summary = theme_nfdai_strip_html_tags($course->summary);
                    $summary = format_text(theme_nfdai_course_trim_char($summary));
                    $trimtitle = $course->fullname;
                    //$noimgurl = $OUTPUT->image_url('noimg', 'theme');
                    $courseurl = new moodle_url('/course/view.php', array(
                        'id' => $courseid
                    ));

                    $systemcontext = $PAGE->bodyid;

                    // Course completion Progress Radial
                    if (\core_completion\progress::get_course_progress_percentage($course) && $systemcontext == 'page-site-index') {
                        $comppc = \core_completion\progress::get_course_progress_percentage($course);
                        $comppercent = number_format($comppc, 0);
                        $hasprogress = true;
                    } else {
                        $comppercent = 0;
                        $hasprogress = false;
                    }
                    $progresschartcontext = ['hasprogress' => $hasprogress, 'progress' => $comppercent];
                    if ($course->enablecompletion == 1 && $systemcontext == 'page-site-index') {
                        $progresschart = $this->render_from_template('block_myoverview/progress-chart', $progresschartcontext);
                    } else {
                        $progresschart = '';
                    }
                    // Course completion Progress bar
                    if ($course->enablecompletion == 1 && $systemcontext == 'page-site-index') {
                        $completiontext = get_string('coursecompletion', 'completion');
                        $compbar = "<div class='progress'>";
                        $compbar .= "<div class='progress-bar progress-bar-info barfill' role='progressbar' aria-valuenow='{$comppercent}' ";
                        $compbar .= " aria-valuemin='0' aria-valuemax='100' style='width: {$comppercent}%;'>";
                        $compbar .= "{$comppercent}%";
                        $compbar .= "</div>";
                        $compbar .= "</div>";
                        $progressbar = $compbar;
                    } else {
                        $progressbar = '';
                        $completiontext = '';
                    }
                    if ($course instanceof stdClass) {
                        require_once ($CFG->libdir . '/coursecatlib.php');
                        $course = new course_in_list($course);
                    }
                    // print enrolmenticons
                    $pixcontent = '';
                    if ($icons = enrol_get_course_info_icons($course)) {
                        $pixcontent .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
                        foreach ($icons as $pix_icon) {
                            $pixcontent .= $this->render($pix_icon);
                        }
                        $pixcontent .= html_writer::end_tag('div'); // .enrolmenticons
                    }
                    // display course category if necessary (for example in search results)
                    require_once($CFG->libdir . '/coursecatlib.php');
                    $cat = coursecat::get($course->category, IGNORE_MISSING);
                    if (!strcasecmp ($catcommingsoon, $cat->get_formatted_name() )){                                                
                        $comingsoonclass =strtolower(preg_replace('/\s+/', '', $catcommingsoon));
                    } else {
                        $comingsoonclass='';    
                    }
                    if ($cat) {                    
                        $catcontent = html_writer::start_tag('div', array('class' => 'coursecat'));
                        //$catcontent .= get_string('category') . ': ' .
                        $catcontent .=  html_writer::span($cat->get_formatted_name());
                        $catcontent .= $pixcontent;
                        $catcontent .= html_writer::end_tag('div'); // .coursecat
                    }

                    // Load from config if usea a img from course summary file if not exist a img then a default one ore use a fa-icon.
                    $imgurl = '';
                    $context = context_course::instance($course->id);
                    foreach ($course->get_course_overviewfiles() as $file) {
                        $isimage = $file->is_valid_image();
                        $imgurl = file_encode_url("$CFG->wwwroot/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$isimage);
//                        if (!$isimage) {
//                            $imgurl = $noimgurl;
//                        }
                    }
                    if (empty($imgurl)) {
                        $imgurl = $PAGE->theme->setting_file_url('headerdefaultimage', 'headerdefaultimage', true);
//                        if (!$imgurl) {
//                            $imgurl = $noimgurl;
//                        }
                    }
                    if ($comingsoonclass){
                            $rowcontent .= '
                            <div class="class-box comingsoon">
                            ';
                        $rowcontent .= '<span class="cornertext">'.$catcommingsoon.'</span>';
                    }else{
                        $rowcontent .= '
                            <div class="class-box">
                            ';
                    }
                     
                    $tooltiptext = 'data-tooltip="tooltip" data-placement= "top" title="' . format_string($course->fullname) . '"';
                    
                    $rowcontent .= '
                                <a ' . $tooltiptext . ' href="' . $courseurl . '">
                                    <div class="courseimagecontainer">
                                        <div class="course-image-view" style="background-image: url(' . $imgurl . ');background-repeat: no-repeat;background-size:cover; background-position:center;">
                                                        <div class="mycoursecompletiontile4">' . $progresschart . '</div>
                                        </div>
                                        <div class="course-overlay">
                                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                        </div>

                                    </div>
                                </a>
                              <div class="course-info">
                                 <div class="course-summary">
                                    ' . $catcontent . '
                                    <div class="course-title">
                                        <a ' . $tooltiptext . ' href="' . $courseurl . '">
                                        <h4 class="coursetitle">' . $trimtitle . '</h4>
                                        </a>
                                    </div>';

                    $rowcontent .= '
                                 </div>
                             </div> 
                            </div>
                    ';
                   
                }
                $content .= $rowcontent;
                $content .= '';
            }
        } 
        $coursehtml = $header . $content . $footer;
        return $coursehtml;
    }
    protected function my_coursecat_category_content(coursecat_helper $chelper, $coursecat, $depth) {
        
        // Subcategories
        $content = $this->coursecat_subcategories($chelper, $coursecat, $depth);
        // if  $coursecat depth is not one, so we have more subcategories 
            
        // AUTO show courses: Courses will be shown expanded if this is not nested category,
        // and number of courses no bigger than $CFG->courseswithsummarieslimit.
        $showcoursesauto = $chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO;
        if ($showcoursesauto && $depth) {
            // this is definitely collapsed mode
            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
        }
        // Courses
        if ($chelper->get_show_courses() > course_renderer::COURSECAT_SHOW_COURSES_COUNT) {
           $courses = array();     
           $courses = $coursecat->get_courses($chelper->get_courses_display_options());
            if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
                // the option for 'View more' link was specified, display more link (if it is link to category view page, add category id)
                if ($viewmoreurl->compare(new moodle_url('/course/index.php'), URL_MATCH_BASE)) {
                    $chelper->set_courses_display_option('viewmoreurl', new moodle_url($viewmoreurl, array('categoryid' => $coursecat->id)));
                }
            }
         
            $content .= $this->coursecat_courses($chelper, $courses, $coursecat->get_courses_count());
        }
        
        if ($showcoursesauto) {
            // restore the show_courses back to AUTO
            $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_AUTO);
        }
        return $content;
    }
    /**
     * Returns HTML to display the subcategories and courses in the given category
     *
     * This method is re-used by AJAX to expand content of not loaded category
     *
     * @param coursecat_helper $chelper various display options
     * @param coursecat $coursecat
     * @param int $depth depth of the category in the current tree
     * @return string
     */
    protected function coursecat_category(coursecat_helper $chelper, $coursecat, $depth) {
        // open category tag
        
        $classes = array('category', "level".$depth);
        if (empty($coursecat->visible)) {
            $classes[] = 'dimmed_category';
        }
        $categorycontent = $this->my_coursecat_category_content($chelper, $coursecat, $depth);
     
        $this->coursecat_include_js();
        if ($coursecat->parent == 0) {
            $content = html_writer::start_tag('div', array(
                    'class' => join(' ', $classes),
                    'data-categoryid' => $coursecat->id,
                    'data-depth' => $depth,
                    'numberofcourses'=>$coursecat->get_courses_count(),
                    'data-showcourses' => $chelper->get_show_courses(),
                    'data-type' => self::COURSECAT_TYPE_CATEGORY,
            ));
            
        }else{
            $content ='';
        }
        
        // build the category name
        $categoryname = $coursecat->get_formatted_name();
        $categoryname = html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $coursecat->id)), $categoryname);
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_COUNT && ($coursescount = $coursecat->get_courses_count())) {
            $categoryname .= html_writer::tag('span', ' (' . $coursescount . ')', array('title' => get_string('numberofcourses'), 'class' => 'numberofcourse'));
        }
        // Top directory
        if ($coursecat->parent == 0){ 
            $content .= html_writer::tag(($depth > 1) ? 'h4' : 'h3', $categoryname, array('class' => 'categoryname'));
            $content.='<div class="catcourseswrap">';
             $content.='<div class="coursesrow">';
        } 
        elseif (!($coursecat->parent == 0)&&($coursecat->get_courses_count()>0)&& ($depth >2)){
              $content .= html_writer::tag(($depth > 1) ? 'h4' : 'h3', $categoryname, array('class' => 'categoryname'));
        }
        $content .=  $categorycontent;
        if ($coursecat->parent == 0) {
            $content .= '</div>';
                $content .= '<div class="controls"><div class="right-arrow"><i class="fa fa-angle-left fa-3x"></i></div>
                <div class="left-arrow"><i class="fa fa-angle-right fa-3x"></i></div></div>';
             
           $content .= '</div>';
            $content .= html_writer::end_tag('div'); 
        } elseif (!($coursecat->parent == 0)&&($coursecat->get_courses_count()>0)&& ($depth >2)){
             $content .= html_writer::end_tag('div'); 
        }
        // Return the course category tree HTML
        return $content;
    }

    /**
     * Renders the list of subcategories in a category
     *
     * @param coursecat_helper $chelper various display options
     * @param coursecat $coursecat
     * @param int $depth depth of the category in the current tree
     * @return string
     */
    protected function coursecat_subcategories(coursecat_helper $chelper, $coursecat, $depth) {
        global $CFG;

        $subcategories = array();
        if (!$chelper->get_categories_display_option('nodisplay')) {
            $subcategories = $coursecat->get_children($chelper->get_categories_display_options());
        }
        $totalcount = $coursecat->get_children_count();
        if (!$totalcount) {
            // Note that we call coursecat::get_children_count() AFTER coursecat::get_children() to avoid extra DB requests.
            // Categories count is cached during children categories retrieval.
            return '';
        }

        // prepare content of paging bar or more link if it is needed
        $paginationurl = $chelper->get_categories_display_option('paginationurl');
        $paginationallowall = $chelper->get_categories_display_option('paginationallowall');

        if ($totalcount > count($subcategories)) {
            if ($paginationurl) {
                // the option 'paginationurl was specified, display pagingbar
                $perpage = $chelper->get_categories_display_option('limit', $CFG->coursesperpage);
                $page = $chelper->get_categories_display_option('offset') / $perpage;
                $pagingbar = $this->paging_bar($totalcount, $page, $perpage, $paginationurl->out(false, array('perpage' => $perpage)));

                if ($paginationallowall) {
                    $pagingbar .= html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => 'all')), get_string('showall', '', $totalcount)), array('class' => 'paging paging-showall'));
                }
            } else if ($viewmoreurl = $chelper->get_categories_display_option('viewmoreurl')) {
                // the option 'viewmoreurl' was specified, display more link (if it is link to category view page, add category id)
                if ($viewmoreurl->compare(new moodle_url('/course/index.php'), URL_MATCH_BASE)) {
                    $viewmoreurl->param('categoryid', $coursecat->id);
                }
                $viewmoretext = $chelper->get_categories_display_option('viewmoretext', new lang_string('viewmore'));
                $morelink = html_writer::tag('div', html_writer::link($viewmoreurl, $viewmoretext), array('class' => 'paging paging-morelink'));
            }
        } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {

            // there are more than one page of results and we are in 'view all' mode, suggest to go back to paginated view mode
            $pagingbar = html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => $CFG->coursesperpage)), get_string('showperpage', '', $CFG->coursesperpage)), array('class' => 'paging paging-showperpage'));
        }

        // display list of subcategories
        //$content = html_writer::start_tag('div', array('class' => 'subcategories wrapall'));
        $content='';
        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }

        foreach ($subcategories as $subcategory) {

            $content .= $this->coursecat_category($chelper, $subcategory, $depth + 1);
        }

        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }
        if (!empty($morelink)) {
            $content .= $morelink;
        }

        //$content .= html_writer::end_tag('div');
        return $content;
    }
    protected function coursecat_courses(coursecat_helper $chelper, $courses, $totalcount = null) {
        global $CFG;
        if ($totalcount === null) {
            $totalcount = count($courses);
        }
        if (!$totalcount) {
            // Courses count is cached during courses retrieval.
            return '';
        }
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
        $paginationurl = $chelper->get_courses_display_option('paginationurl');
        $paginationallowall = $chelper->get_courses_display_option('paginationallowall');
        if ($totalcount > count($courses)) {
            if ($paginationurl) {
                $perpage = $chelper->get_courses_display_option('limit', $CFG->coursesperpage);
                $page = $chelper->get_courses_display_option('offset') / $perpage;
                $pagingbar = $this->paging_bar($totalcount, $page, $perpage, $paginationurl->out(false, array(
                            'perpage' => $perpage
                )));
                if ($paginationallowall) {
                    $pagingbar .= html_writer::tag('div', html_writer::link($paginationurl->out(false, array(
                                                'perpage' => 'all'
                                            )), get_string('showall', '', $totalcount)), array(
                                'class' => 'paging paging-showall'
                    ));
                }
            } else if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
                $viewmoretext = $chelper->get_courses_display_option('viewmoretext', new lang_string('viewmore'));
                $morelink = html_writer::tag('div', html_writer::tag('a', html_writer::start_tag('i', array(
                                            'class' => 'fa-graduation-cap' . ' fa fa-fw'
                                        )) . html_writer::end_tag('i') . $viewmoretext, array(
                                    'href' => $viewmoreurl,
                                    'class' => 'btn btn-primary coursesmorelink'
                                )), array(
                            'class' => 'paging paging-morelink'
                ));
            }
        } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {
            $pagingbar = html_writer::tag('div', html_writer::link($paginationurl->out(false, array(
                                        'perpage' => $CFG->coursesperpage
                                    )), get_string('showperpage', '', $CFG->coursesperpage)), array(
                        'class' => 'paging paging-showperpage'
            ));
        }
        $attributes = $chelper->get_and_erase_attributes('courses');
        $content = '';
        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }
        $categoryid = optional_param('categoryid', 0, PARAM_INT);
        $coursecount = 0;
        $content .= $this->view_available_courses($categoryid, $courses, $totalcount);
        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }
        if (!empty($morelink)) {
            $content .= $morelink;
        }
        return $content;
    }

    /**
    * Renders html to display a course search form.
    * to remove search form from main content - see boost classes/output/core/course-renderer.php
    */
    public function course_search_form($value = '', $format = 'plain') {
        return;
    }
    
    
        /**
     * Returns HTML to display a tree of subcategories and courses in the given category
     *
     * @param coursecat_helper $chelper various display options
     * @param coursecat $coursecat top category (this category's name and description will NOT be added to the tree)
     * @return string
     */
    protected function coursecat_tree(coursecat_helper $chelper, $coursecat) {
        // Reset the category expanded flag for this course category tree first.
        $this->categoryexpandedonload = true;
        $categorycontent = $this->my_coursecat_category_content($chelper, $coursecat, 0);
        if (empty($categorycontent)) {
            return '';
        }
        // Start content generation
        $content = '';       
        $attributes = $chelper->get_and_erase_attributes('course_category_tree clearfix');
        $content .= '<h2 class="header-courses">'.get_string('headingcourses','theme_nfdai').'</h2>';
        $content .= html_writer::start_tag('div', $attributes);
        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content wrapall'));
        $content .= html_writer::end_tag('div'); // .course_category_tree
        return $content;
    }
    
    
}

