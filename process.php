<?php
/**
 * Version details
 *
 * @package    block_groupreg
 * @copyright  2013 onwards Igor Nikulin (serafimpanov@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include_once "../../config.php";
include_once $CFG->dirroot."/group/lib.php";
include_once $CFG->dirroot."/lib/enrollib.php";

$id = optional_param('id', NULL, PARAM_INT);


$context = get_context_instance(CONTEXT_COURSE, $id);

$report = array();

if($data = groupreg_csv($_FILES['file_csv']['tmp_name'])){
    foreach($data as $k => $v){

        if(strstr($v[0], '@'))
            $user = $DB->get_record("user", array("email"=>$v[0]));
        else
            $user = $DB->get_record("user", array("username"=>$v[0]));
        
        if(!$group = $DB->get_record("groups", array("name"=>$v[1], "courseid"=>$id))){
            $newgroupdata = new stdClass();
            $newgroupdata->name = $v[1];
            $newgroupdata->courseid = $id;
            $newgroupdata->description = '';

            $gid = groups_create_group($newgroupdata);
            if ($gid){
                $group = $DB->get_record("groups", array("id"=>$gid));
            }
            
            $report['groupcreated'][$gid] = array($newgroupdata->name);
        }

        
        if (!$user) 
            $report['studentnotfound'][] = array($v[0], $group->name);
        
        if ($user && $group){
            enrol_try_internal_enrol($id, $user->id, 5, time());
            groups_add_member($group->id, $user->id);
            
            $report['studentregistered'][] = array($user->username, $user->lastname, $user->firstname, $user->email, $group->name);
        }
        
    }
}

///Excel report
$course = $DB->get_record("course", array("id"=>$id));

$name = "GroupReg_".$course->shortname."_".date(get_string('timeformat', 'block_groupreg'), time());

if (!$data = $DB->get_record_sql("SELECT itemid FROM {files} WHERE component='block_groupreg' AND filearea='excel' AND contextid=? ORDER BY itemid DESC LIMIT 1", array($context->id))) {
    $itemid = 1;
} else {
    $itemid = $data->itemid + 1;
}

$fs = get_file_storage();

$fileinfo = array(
    'contextid' => $context->id, 
    'component' => 'block_groupreg',
    'filearea' => 'excel',
    'itemid' => $itemid,
    'filepath' => '/',
    'filename' => $name.'.json');

$fs->create_file_from_string($fileinfo, json_encode($report));


///Page layout
$PAGE->set_url('/blocks/groupreg/process.php', array('id'=>$id));

$title = get_string("datawassubmited", "block_groupreg");
$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();
echo $OUTPUT->box_start('generalbox');
echo $OUTPUT->notification($title, 'notifysuccess'); 
echo html_writer::empty_tag("br");
echo html_writer::empty_tag("br");
echo html_writer::link(new moodle_url('/blocks/groupreg/excelreport.php', array('id'=>$id, 'ids'=>$itemid, 'name'=>$name)), get_string('downloadxls', 'block_groupreg'));
echo $OUTPUT->box_end();
echo $OUTPUT->continue_button(new moodle_url("/course/view.php", array("id"=>$id)));
echo $OUTPUT->footer();


function groupreg_csv($file){
    global $DB;

    $filedata = file_get_contents($file);
    $filedata = str_replace("\r", "\n", $filedata);
    $filedata = str_replace("\n\n", "\n", $filedata);
    
    if ($filedata) $filedata = explode("\n", $filedata);
    
    $filedata_ = array();
    
    foreach ($filedata as $filedatavalue){
        if (!empty($filedatavalue)) {
            $filedatavalue = trim($filedatavalue);
            $filedatavalue = str_replace(array("	", ","), ";", $filedatavalue);
            $filedatavalue = explode(";", $filedatavalue);
            
            $filedatavalue_ = array();
            
            foreach($filedatavalue as $v){
                $v = trim($v);
                $filedatavalue_[] = $v;
            }
            
            $filedata_[]   = $filedatavalue_;
        }
    }
    
    if (count($filedata_) > 0)
        return $filedata_;
    else
        return false;
}