<?php
/**
 * Version details
 *
 * @package    block_groupreg
 * @copyright  2013 onwards Igor Nikulin (serafimpanov@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include_once "../../config.php";
include_once $CFG->dirroot."/lib/excellib.class.php";


$id   = optional_param('id', NULL, PARAM_INT);
$ids  = optional_param('ids', NULL, PARAM_INT);
$name = optional_param('name', NULL, PARAM_TEXT);


$context = get_context_instance(CONTEXT_COURSE, $id);

$fs = get_file_storage();

$file = $fs->get_file($context->id, 'block_groupreg', 'excel', $ids, '/', $name.'.json');

$report = json_decode($file->get_content());

///Excel report
$workbook = new MoodleExcelWorkbook("-");
$myxls =& $workbook->add_worksheet('report');

$format =& $workbook->add_format();
$format->set_bold(0);
$formatbc =& $workbook->add_format();
$formatbc->set_bold(1);

$myxls->set_row(0, 30);
$myxls->set_column(0,1,20);
$myxls->set_column(2,10,15);

$row = 0;

foreach($report as $k => $v){
    $row++;
    $myxls->write_string($row, 0, get_string($k, 'block_groupreg'),$formatbc);
    foreach($v as $r2){
        $row++;
        $col = 0;
        foreach($r2 as $r3){
            if (is_numeric($r3))
              $myxls->write_number($row, $col, $r3);
            else
              $myxls->write_string($row, $col, $r3);
            
            $col++;
        }
    }
}

$workbook->send($name.'.xls');

$workbook->close();