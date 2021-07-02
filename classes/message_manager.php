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

class message_manager
{
    /**
    * @param string $message_text
    * @param string $message_type
    * @return bool true if successful
    **/
    public function create_message(string $message_text, string $message_type): bool
    {
        global $DB;
        //inset data into database
        $recordtoinsert = new stdClass();
        $recordtoinsert->messagetext = $message_text;
        $recordtoinsert->messagetype = $message_type;
        try
        {
            return $DB->insert_record('local_message', $recordtoinsert, false);
        }
        catch(dml_exception $e)
        {
            return false;
        }
    }
    //ziskani vsech zprav podle userid
    /**
    * @param int $userid uzivatel kdo dostava zpravy
    * @return array zprav   
    */
    public function get_messages($userid):array
    {
        global $DB;
        //$messages = $DB->get_records('local_message');
        $sql = "SELECT lm.id, lm.messagetext, lm.messagetype 
        FROM {local_message} lm 
        left JOIN {local_message_read} lmr ON lm.id = lmr.messageid AND lmr.userid = :userid 
        WHERE lmr.userid IS NULL";

        $params = 
        [
            'userid' => $userid,
        ];
        try
        {
            return $messages = $DB->get_records_sql($sql, $params);
        }
        catch(dml_exception $e)
        {
            return false; //log error here
        }
    }
    
    public function mark_message_read($messageid,$userid)
    {
        global $DB;
        $readrecord = new stdClass();
        //add read message to table reda message
        $readrecord->messageid = $messageid;
        $readrecord->userid = $userid;
        $readrecord->timeread = time();
        try
        {
            return $DB->insert_record('local_message_read', $readrecord, false);
        }
        catch(dml_exception $e)
        {
            return false;
        }
    }
}
