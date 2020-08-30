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

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext(
            'block_biblioclub_ru/domain',
            new lang_string('domain', 'block_biblioclub_ru'),
            '',
            '',
            PARAM_RAW));

    $settings->add(new admin_setting_configtext(
            'block_biblioclub_ru/secretkey',
            new lang_string('secretkey', 'block_biblioclub_ru'),
            '',
            '',
            PARAM_RAW));

    $settings->add(new admin_setting_configtext(
            'block_biblioclub_ru/title',
            new lang_string('title', 'block_biblioclub_ru'),
            '',
            new lang_string('defaulttitle', 'block_biblioclub_ru'),
            PARAM_RAW));

    $settings->add(new admin_setting_configtext(
            'block_biblioclub_ru/link',
            new lang_string('link', 'block_biblioclub_ru'),
            '',
            new lang_string('defaultlink', 'block_biblioclub_ru'),
            PARAM_RAW));
}


