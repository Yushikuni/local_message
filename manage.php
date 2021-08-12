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
 * manage page for 'local_message'
 *
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
 */
require_once(__DIR__ . '/../../config.php');

global $DB;

//adminovsky pristup na stranku, nutne se prihlasit pro zobrazeni stranky (ochrana proti tomu, aby kazdy mel pristup na urcite stranky) 
//require_admin();//-> nepotrebuju pokud kontroluju pristup pro managera

//i pro prochazeni chci aby uzivatel se prihlasil
require_login();

//kontrola pro moznost pristupu bez adminovskeho loginu
$context = context_system::instance();
require_capability('local/message:managemessages', $context);

$PAGE -> set_url('/local/message/manage.php');
$PAGE -> set_context(\context_system::instance());
$PAGE -> set_title(get_string('titlepagemanage', 'local_message'));
$PAGE -> set_heading(get_string('title', 'local_message'));

//nacitani javaskriptu
$PAGE->requires->js_call_amd('local_message/confirm');/*, $func, $params);*/

$messages = $DB->get_records('local_message', null, 'id');

echo $OUTPUT->header();

$templatecontext = (object)
[
    'picurl'            => new moodle_url('/local/message/pic/hellothere.jpg'), 
    'messages'          => array_values($messages),
    'editurl'           => new moodle_url('/local/message/edit.php'),
    'editmsg'           => get_string('edtmsg','local_message'),
    'deltmsg'           => get_string('deltmsg','local_message'),
    'sndnextmessage'    => get_string('sndnextmessage','local_message'),
];

echo $OUTPUT->render_from_template('local_message/manage',$templatecontext);
echo $OUTPUT->footer();