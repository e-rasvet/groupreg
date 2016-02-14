<?php
/**
 * Version details
 *
 * @package    block_groupreg
 * @copyright  2013 onwards Igor Nikulin (serafimpanov@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['blockstring'] = 'Block string';
$string['descconfig'] = 'Description of the config section';
$string['descfoo'] = 'Config description';
$string['headerconfig'] = 'Config section header';
$string['labelfoo'] = 'Config label';
$string['groupreg:addinstance'] = 'Add a groupreg block';
$string['groupreg:myaddinstance'] = 'Add a groupreg block to my moodle';
$string['pluginname'] = 'GroupReg';
$string['datawassubmited'] = 'Data was submitted';
$string['pluginname_help'] = 'GroupReg<br /><br />

このコースにユーザを登録するには，第１欄にユザーID又はemailをcsvファイルに入力して下さい．<br />
同時にグループにも登録する場合には，第２欄にグループ名を指定して下さい．下記の構成を参照して下さい．<br />
<br />
&lt;userid&gt;<br />
&lt;userid&gt;,&lt;groupname&gt;<br />
&lt;user_email&gt;<br />
&lt;user_email&gt;,&lt;groupname&gt;<br />
<br />
　CSVファイルをアップロードすると：<br />
1) ユザーが当コースに登録していない場合は，登録される，<br />
2) 入力データーに既存グループ名が含まれている場合はそのグループにユザーが追加されます．<br />
3) グループが存在しない場合は，グループを新規作成した後，ユーザが追加されます．
';

$string['groupcreated'] = 'Groups were created';
$string['studentnotfound'] = 'Students not found';
$string['studentregistered'] = 'Students registered';
$string['timeformat'] = 'd_M_Y';
$string['downloadxls'] = 'Download report as .xls';
