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
 * Authentication on biblioclub.ru
 *
 * @package    block_biblioclub_ru
 * @copyright  2020 Pavel Lobanov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_login();

$contextid = optional_param('contextid', null, PARAM_INT);

if ($contextid) {
    $context = context::instance_by_id($contextid);
} else {
    $context = context_system::instance();
    $contextid = $context->id;
}
require_capability('block/biblioclub_ru:use', $context);

// not needed for biblioclub.ru
//$documentid = optional_param('documentid', null, PARAM_INT);
//$page = optional_param('page', null, PARAM_INT);

$params = array(
    'contextid' => $contextid
);
$event = \block_biblioclub_ru\event\link_used::create($params);
$event->trigger();

$visit = new stdClass();
$visit->time = time();
$visit->userid = $USER->id;
$visit->contextid = $contextid;
$DB->insert_record('block_biblioclub_ru_visits', $visit);

$secretkey = get_config('block_biblioclub_ru', 'secretkey');
$domain = get_config('block_biblioclub_ru', 'domain');

$timestamp = time();
// FIXME: using student type by default
$user_type = 6;
$user_id = $USER->id;
$login = $USER->username;
$sign = md5($user_id . $secretkey . $timestamp);

$params = array(
    'page' => 'main_ub_red',
    'action' => 'auth_for_org',
    'domain' => $domain,
    'user_id' => $user_id,
    'login' => $login,
    'time' => $timestamp,
    'sign' => $sign,
    'first_name' => $USER->firstname,
    'last_name' => $USER->lastname
);
if ($USER->middlename) {
    $params['parent_name'] = $USER->middlename;
}
$url = new moodle_url('https://biblioclub.ru/index.php', $params);
redirect($url);
