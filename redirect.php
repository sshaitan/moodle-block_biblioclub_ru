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
 * Authentication on znanium.com
 *
 * @package    block_znanium_com
 * @copyright  2014 Vadim Dvorovenko
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_login();

$contextid = required_param('contextid', PARAM_INT);
require_capability('block/znanium_com:use', context::instance_by_id($contextid));

$params = array(
    'contextid' => $contextid
);
$event = \block_znanium_com\event\link_used::create($params);
$event->trigger();

$visit = new stdClass();
$visit->time = time();
$visit->userid = $USER->id;
$visit->contextid = $contextid;
$DB->insert_record('block_znanium_com_visits', $visit);

$secretkey = get_config('block_znanium_com', 'secretkey');
$domain = get_config('block_znanium_com', 'domain');

$timestamp = date('YmdHis');
$signature = md5($USER->id . $secretkey . $timestamp);
$params = array(
    'domain' => $domain,
    'id' => $USER->id,
    'login' => $USER->username,
    'name' => $USER->firstname,
    'patr' => '',
    'lname' => $USER->lastname,
    'time' => $timestamp,
    'sign' => $signature);
$url = new moodle_url('http://znanium.com/autosignon.php', $params);
redirect($url);
