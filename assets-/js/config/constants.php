<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);



define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('DATE_FORMAT_WS', 'd-m-Y');
define('DATE_FORMAT', 'Y-m-d');
define('DATE_TIME_FORMAT', 'Y-m-d H:i:s');

define('CAPTCHA_COUNT', 4);
define('STR_SEPARATOR', '@SEP@');

define('UPLOADS_IMG_PATH', FCPATH. 'uploads/img');
define('UPLOADS_PDF_PATH', FCPATH. 'uploads/pdf');
define('UPLOADS_DOCX_PATH', FCPATH. 'uploads/doc');
define('UPLOADS_CV_PATH', FCPATH. 'uploads/cv');
define('UPLOADS_IMG_CALLBACK',  '/uploads/img/');

define('UPLOADS_PROFILE_IMG_PATH', FCPATH. 'uploads/profile');
define('UPLOADS_PROFILE_CV_PATH', FCPATH. 'uploads/profile');
define('UPLOADS_PROFILE_CALLBACK',  '/uploads/profile/');

define('UPLOADS_IMG_MAX_SIZE', '1024');//1 Mo
define('UPLOADS_IMG_MAX_WIDTH', '1024');
define('UPLOADS_IMG_MAX_HEIGHT', '768');
define('UPLOADS_IMG_ALLOWED_TYPES', 'gif|jpg|png');
define('UPLOADS_PDF_ALLOWED_TYPES', 'pdf');
define('UPLOADS_DOCX_ALLOWED_TYPES', 'doc|docx');
define('UPLOADS_CV_ALLOWED_TYPES', 'txt|doc|docx|pdf');

define('NEWS_TITLE_MAX_CHARS_SMALL',  70);
define('NEWS_TITLE_MAX_CHARS',  150);
//define('NEWS_TITLE_MAX_CHARS_SMALL',  42);
define('NEWS_DESCRIPTION_MAX_CHARS',  450);
define('NEWS_DESCRIPTION_MAX_CHARS_SMALL',  170);
define('NEWS_DESCRIPTION_MAX_CHARS_SMALLAG',  95);
define('NEWS_DESCRIPTION_MAX_CHARS_EXTRA_SMALL',  70);


define('AGENDA_TITLE_MAX_CHARS',  150);
define('AGENDA_DESCRIPTION_MAX_CHARS',  450);

define('SEARCH_TERM_CHARS_MIN',  3);
define('SEARCH_CNT_LINK', 4);

define('SIDE_BAR_MAX_ELEMENTS', 5);



define('TOKEN_CHANNEL_SEPARATOR', '||SEP||');
define('TOKEN_PATTERN_USER_LOGIN', '{USER_LOGIN}');
define('TOKEN_PATTERN_USER_ID', '{USER_ID}');
define('TOKEN_PATTERN_USER_TYPE', '{USER_TYPE}');
define('TOKEN_CHANNEL_FORMAT', TOKEN_PATTERN_USER_LOGIN.TOKEN_CHANNEL_SEPARATOR.TOKEN_PATTERN_USER_ID.TOKEN_CHANNEL_SEPARATOR.TOKEN_PATTERN_USER_TYPE);
define('USER_TYPE_ADMIN', 'user_admin');
define('USER_TYPE_USER', 'administration/index');



define('ADMIN_CONTACT_EMAIL', 'si@iav.ac.ma');
define('ING_CONTACT_EMAIL', 'benabbeskhalid@gmail.com');
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
