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
 * Strings for component 'Local_message', language 'en', branch 'MOODLE_20_STABLE'
 *'
 * @package   Local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
 */
require_once(__DIR__ . '/../../config.php');

global $DB;

$PAGE -> set_url('/local/message/manage.php');
$PAGE -> set_context(\context_system::instance());
$PAGE -> set_title(get_string('titlepagemanage', 'local_message'));

$messages = $DB->get_records('local_message', null, 'id');

echo $OUTPUT->header();

$templatecontext = (object)
[
    'picurl'            => new moodle_url('/local/message/pic/hellothere.jpg'), 
    'messages'          => array_values($messages),
    'editurl'           => new moodle_url('/local/message/edit.php'),
    'editmsg'           => get_string('edtmsg','local_message'),
    'sndnextmessage'    => get_string('sndnextmessage','local_message'),
];

echo $OUTPUT->render_from_template('local_message/manage',$templatecontext);
echo $OUTPUT->footer();