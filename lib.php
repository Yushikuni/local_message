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
 * lib for component 'local_message'
 *
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
**/
use local_message\manager;

function local_message_before_footer()
{
    global $DB, $USER;

    $manager = new manager();
    $message = $manager->get_messages($USER->id);


    foreach($message as $m)
    {
        $type = \core\output\notification::NOTIFY_INFO;

        if($m->messagetype === '0')
        {
            $type = \core\output\notification::NOTIFY_WARNING;
        }
        else if($m->messagetype === '2')
        {
            $type = \core\output\notification::NOTIFY_SUCCESS;
        }
        else if($m->messagetype === '3')
        {
            $type = \core\output\notification::NOTIFY_ERROR;
        }
        \core\notification::add($m->messagetext, $type);

        $manager->mark_message_read($m->id, $USER->id);

    }
    //\core\notification::error($message); //barva Cosmos
    //\core\notification::warning($message);//barva FORGET ME NOT
    //\core\notification::info($message);//modré upozornění
    //\core\notification::add($message, \core\output\notification::NOTIFY_SUCCESS);//zelené upozornění
}
