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
 * settings for 'local_message' plugin
 *
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
 */

if($hassiteconfig){
    //pridani kategorie
    $page = new admin_category('local_message_category', get_string('pluginname', 'local_message'));
    
    //nastaveni pro plugin settings
    $settings = new admin_settingpage('local_message', get_string('plgnnamesett', 'local_message'));
    $settings->add(new admin_setting_configtext('local_message/option','Option','Informatiioon about this option', 100, PARAM_INT));
  
    //zobrazeni v menu
    $ADMIN->add('localplugins',$page);                       
    $ADMIN->add('local_message_category', new admin_externalpage('???',get_string('manage','local_message')  , $CFG->wwwroot.'/local/message/manage.php')); 
    $ADMIN->add('local_message_category', $settings);
    //??? -> nevim co misto '???' tak tam zustanou otazniky, lepsi nez ZULUL ne?
}