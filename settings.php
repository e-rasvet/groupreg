<?php
/**
 * Version details
 *
 * @package    block_groupreg
 * @copyright  2013 onwards Igor Nikulin (serafimpanov@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings->add(new admin_setting_heading('sampleheader',
                                         get_string('headerconfig', 'block_groupreg'),
                                         get_string('descconfig', 'block_groupreg')));

$settings->add(new admin_setting_configcheckbox('groupreg/foo',
                                                get_string('labelfoo', 'block_groupreg'),
                                                get_string('descfoo', 'block_groupreg'),
                                                '0'));
