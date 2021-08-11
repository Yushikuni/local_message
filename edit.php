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
 * edit file for component 'local_message'
 *
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
**/

use local_message\form\edit;
use local_message\manager;

require_once(__DIR__ . '/../../config.php');

$PAGE->set_url('/local/message/edit.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title("edit mesages");

$messageid = optional_param('messageid',null, PARAM_INT);

//zobraz form
$mform = new edit();

if ($mform->is_cancelled()) 
{
    //Go back to manage.php page
    redirect($CFG->wwwroot.'/local/message/manage.php', get_string('cancelled','local_message'));

} 
else if ($fromform = $mform->get_data()) 
{

    $manager = new manager();
     
    if($fromform -> id)
    {
        //update existující zprávy
        $manager -> update_message($fromform->id, $fromform->messagetext, $fromform->messagetype);       
        redirect($CFG->wwwroot.'/local/message/manage.php', get_string('updatemessage','local_message'). $fromform->messagetext);
    }
    else
    {
        $manager -> create_message($fromform->messagetext, $fromform->messagetype);
        //Go back to manage.php page
        redirect($CFG->wwwroot.'/local/message/manage.php', get_string('cratedmessage','local_message'). $fromform->messagetext);
    }    
}

if($messageid)
{
    $manager = new manager();
    $message = $manager -> get_message($messageid);
    if(!$message)
    {
        //throw new invalid_parametr_exception('Message not found');
        die("Message not found");
    }
    $mform -> set_data($message);
}
echo $OUTPUT -> header();

$mform -> display();

echo$OUTPUT -> footer();