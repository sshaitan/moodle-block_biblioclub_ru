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

$string['defaultlink'] = 'Go to Biblioclub.ru digital library';
$string['defaulttitle'] = 'Biblioclub';
$string['domain'] = 'Domain';
$string['eventlinkused'] = 'Biblioclub digital library visited';
$string['link'] = 'Link text';
$string['month'] = 'Month';
$string['pluginname'] = 'Authentication on Biblioclub digital library site';
$string['privacy:metadata:visits'] = 'Records of the user\'s transitions from Moodle to Biblioclub.';
$string['privacy:metadata:visits:userid'] = 'The Moodle user who followed the library link.';
$string['privacy:metadata:visits:contextid'] = 'The Moodle context from which the link was followed.';
$string['privacy:metadata:visits:time'] = 'The time the user followed the link.';
$string['privacy:visits'] = 'Biblioclub visits';
$string['privacy:metadata:external'] = 'User identity is sent to biblioclub.ru for seamless authentication and access to the external library. Data held by Biblioclub must be requested from that service.';
$string['privacy:metadata:external:userid'] = 'The Moodle user ID identifying the user at Biblioclub.';
$string['privacy:metadata:external:login'] = 'The Moodle username (padded when shorter than six characters); it may be an email address.';
$string['privacy:metadata:external:firstname'] = 'The user\'s first name.';
$string['privacy:metadata:external:lastname'] = 'The user\'s last name.';
$string['privacy:metadata:external:middlename'] = 'The user\'s middle name, if provided.';
$string['privacy:metadata:external:domain'] = 'The organisation domain configured by the administrator.';
$string['privacy:metadata:external:time'] = 'The authentication request timestamp.';
$string['secretkey'] = 'Secret key';
$string['statistics'] = 'Statistics';
$string['title'] = 'Block title';
$string['visits'] = 'Visits count';
$string['biblioclub_ru:addinstance'] = 'Add a new Biblioclub digital library block';
$string['biblioclub_ru:myaddinstance'] = 'Add a new Biblioclub digital library block to home page';
$string['biblioclub_ru:use'] = 'Use block to visit Biblioclub digital library';
$string['biblioclub_ru:viewstats'] = 'View visits statistics';
