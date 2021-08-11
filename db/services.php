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
 * external services file for component 'local_message'
 *
 * @package   local_message
 * @copyright 2021 Husakova Kvetuse
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later,
 * @var stdClass $plugin
 */
$functions = array(
    'local_message_create_groups' => array(         //web service function name
        'classname'   => 'local_message_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'delete message',          //external function name
        'classpath'   => 'local/message/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
                                                   // defaults to the service's externalib.php
        'description' => 'Delete message.',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls. 
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE),    // Optional, only available for Moodle 3.1 onwards. List of built-in services (by shortname) where the function will be included.  Services created manually via the Moodle interface are not supported.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
);