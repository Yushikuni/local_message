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
**/
defined ('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/message/lib.php');
require_once($CFG->dirroot . '/local/message/class/message_manager.php');

class local_message_manager_test extends advanced_testcase
{
    /**
    * Test that create message
    */
    public function test_create_message()
    {
        $this -> resetAfterTest();
        $this -> setUser(2);
        
        $manager = new message_manager();
        $messages = $manager->get_messages(2);
        $this -> assertEmpty($messages);

        $typeresult = \core\output\notification::NOTIFY_WARNING;
        $result  = $manager -> create_message('DATA TEST MESSAGE', $typeresult);

        $this ->assertTrue($result);
        $messages = $manager->get_messages(2);
        $this -> assertNotEmpty($messages);

        $this -> assertCount(1,$messages);
        $message = array_pop($messages);

        $this -> assetsEquals('DATA TEST MESSAGE', $message->message_text);
        $this -> assetsEquals($typeresult, $message->message_type);
    }

    /**
    * Test that we get correct messages
    */
    public function test_get_message()
    {
        global $DB;
        $this -> resetAfterTest();
        $this -> setUser(2);
        //user 2 je admin
        $manager = new message_manager();
        $messages = $manager->get_messages(2);
        $this -> assertEmpty($messages);

        //vytvareni novych zprav:
        $typeresult = \core\output\notification::NOTIFY_WARNING;
        
        $manager -> create_message('DATA TEST MESSAGE 1', $typeresult);
        $manager -> create_message('DATA TEST MESSAGE 2', $typeresult);
        $manager -> create_message('DATA TEST MESSAGE 3', $typeresult);

        $messages = $DB->get_records('local_message');
        //pokud zpravy amin jeste nevidel
        foreach($messages as $id => $m)
        {
            $manager->mark_message_read($id, 1);
        }

        $messagesAdmin = $manager->get_messages(2);
        $this->assertCount(3,$messagesAdmin);

        //test pro admin usera
        foreach($messages as $id => $m)
        {
            $manager->mark_message_read($id, 2);
        }

        $messagesAdmin = $manager->get_messages(2);
        $this->assertCount(0,$messagesAdmin);

    }

}
