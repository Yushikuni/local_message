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
 * external lib file for component 'local_message'
 *'
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
**/

defined('MOODLE_INTERNAL') || die();

use local_message\manager;
require_once($CFG->libdir . "/externallip.php");

class local_message_external extends external_api
{
    //parametry, co parametry vraci, vytvoreni grupy
    /**
     * Returns description of method parametrs
     * @return external_function_parameters
     */
    public static function delete_message_parameters()
    {
        return new external_function_parametrs(
            ['messageid' => new external_value(PARAM_INT, 'id of message')],
        );
    }

    /**
     * Function that delete message 
     * @return string welcome message
     */
    public static function delete_message($messageid):string
    {
        $params = self::validate_parametrs(self::delete_message_parameters(), array('messageid' => $messageid));   

        require_capability('local/message:managemessages', context_system::instance());

        $manager = new manager();
       return $manager -> delete_message($messageid);
    }


    /**
     * Return description of method result value
     * @return external_description 
     */
    public static function delete_message_returns()
    {
        return new external_value(PARAM_BOOL, 'True if message was saccessfully deleted');
    }
}
