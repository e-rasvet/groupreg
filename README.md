--------
ABOUT
--------
This is version 1.x of the "GroupReg" block.

1.x release is compatible only with Moodle 2.2+

The "GroupReg" module is developed by Igor Nikulin.

This module may be distributed under the terms of the General Public License
(see http://www.gnu.org/licenses/gpl.txt for details)

-----------
PURPOSE
-----------
This block allow you add assign students to groups by csv file.

----------------
INSTALLATION
----------------
The "GroupReg" follows standard installation procedures.<br />
Place the "GroupReg" directory in your block directory.<br />
Then visit the Admin page in Moodle to activate it.<br />

-----------------
CSV example
-----------------
The input will be a csv file with only two fields:  
userid, groupname  OR  user_email, groupname

1) if the student is not registered in the course, it will add the student to the course<br />
2) if there is a group name and the group exists, the student will be added to the group<br />
3) if the group does not exist, it will create the group and then add the student to the group<br />
