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
require_once($CFG->dirroot.'/local/message/classes/form/edit.php');

global $DB;

$PAGE->set_url('/local/message/edit.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title("edit mesages");

//zobraz form
$mform = new edit();



if ($mform->is_cancelled()) 
{
    //Go back to manage.php page
    redirect($CFG->wwwroot.'/local/message/manage.php', 'Message form was cancelled');

} 
else if ($fromform = $mform->get_data()) 
{
    //inset data into database
    $recordtoinsert = new stdClass();
    $recordtoinsert->messagetext = $fromform->messagetext;
    $recordtoinsert->messagetype = $fromform->messagetype;

    $DB->insert_record('local_message', $recordtoinsert);
    //Go back to manage.php page
    redirect($CFG->wwwroot.'/local/message/manage.php', 'Message has been created: '. $fromform->messagetext);
}
echo $OUTPUT->header();

$mform->display();

echo$OUTPUT->footer();