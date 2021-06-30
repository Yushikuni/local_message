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
 * Strings for component 'local_message', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
 */

function local_message_before_footer()
{
    global $DB, $USER;



    //$messages = $DB->get_records('local_message');
    $sql = "SELECT lm.id, lm.messagetext, lm.messagetype 
            FROM {local_message} lm 
            left JOIN {local_message_read} lmr ON lm.id = lmr.messageid 
            WHERE lmr.userid<> :userid 
            OR lmr.userid IS NULL";

    $params = 
    [
        'userid' => $USER->id, 
    ];

    $messages = $DB->get_records_sql($sql, $params);

    $readrecord = new stdClass();
    foreach($messages as $message)
    {
        $type = \core\output\notification::NOTIFY_INFO;

        if($message->messagetype === '0')
        {
            $type = \core\output\notification::NOTIFY_WARNING;
        }
        else if($message->messagetype === '2')
        {
            $type = \core\output\notification::NOTIFY_SUCCESS;
        }
        else if($message->messagetype === '3')
        {
            $type = \core\output\notification::NOTIFY_ERROR;
        }
        \core\notification::add($message->messagetext, $type);

        //add read message to table reda message
        $readrecord->messageid = $message->id;
        $readrecord->userid = $USER->id;
        $readrecord->timeread = time();
        $DB->insert_record('local_message_read', $readrecord);
    }
    //\core\notification::error($message); //barva Cosmos
    //\core\notification::warning($message);//barva FORGET ME NOT
    //\core\notification::info($message);//modré upozornění
    //\core\notification::add($message, \core\output\notification::NOTIFY_SUCCESS);//zelené upozornění
}
