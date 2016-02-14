<?php
/**
 * Version details
 *
 * @package    block_groupreg
 * @copyright  2013 onwards Igor Nikulin (serafimpanov@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_groupreg extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_groupreg');
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER;

        $id = optional_param('id', NULL, PARAM_INT);

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';
        
        $alink   = new moodle_url("/blocks/groupreg/process.php", array("id"=>$id));
        
        $o  = "";
        $o .= html_writer::start_tag('div');
        $o .= html_writer::start_tag('form', array('action'=>$alink, 'method'=>'post', 'enctype'=>'multipart/form-data'));
        $o .= html_writer::start_tag('div');
        $o .= html_writer::empty_tag('input', array('type'=>'file', 'name'=>'file_csv', 'value'=>''));
        $o .= html_writer::end_tag('div');
        $o .= html_writer::start_tag('div');
        $o .= html_writer::empty_tag('input', array('type'=>'submit', 'value'=>get_string('upload')));
        $o .= $OUTPUT->help_icon('pluginname', 'block_groupreg');
        $o .= html_writer::end_tag('div');
        $o .= html_writer::end_tag('form');
        $o .= html_writer::end_tag('div');
        
        if($USER->id != 2) 
          return false;
        
        $this->content->text .= $o;

        return $this->content;
    }

    // my moodle can only have SITEID and it's redundant here, so take it away
    public function applicable_formats() {
        return array('all' => false,
                     'site' => true,
                     'site-index' => true,
                     'course-view' => true, 
                     'course-view-social' => false,
                     'mod' => true, 
                     'mod-quiz' => false);
    }

    public function instance_allow_multiple() {
          return true;
    }

    function has_config() {return true;}

    public function cron() {
            mtrace( "Hey, my cron script is running" );
             
                 // do something
                  
                      return true;
    }
}
