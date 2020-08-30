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

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade code for the HTML block.
 *
 * @param int $oldversion
 * @param object $block
 * @return void
 */
function xmldb_block_biblioclub_ru_upgrade($oldversion, $block) {
    global $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2015022500) {

        // Define table block_biblioclub_ru_visits to be created.
        $table = new xmldb_table('block_biblioclub_ru_visits');

        // Adding fields to table block_biblioclub_ru_visits.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('time', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('contextid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_biblioclub_ru_visits.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('userid', XMLDB_KEY_FOREIGN, array('userid'), 'user', array('id'));
        $table->add_key('contextid', XMLDB_KEY_FOREIGN, array('contextid'), 'context', array('id'));

        // Adding indexes to table block_biblioclub_ru_visits.
        $table->add_index('time', XMLDB_INDEX_NOTUNIQUE, array('time'));

        // Conditionally launch create table for block_biblioclub_ru_visits.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Biblioclub_ru savepoint reached.
        upgrade_block_savepoint(true, 2015022500, 'biblioclub_ru');
    }

    if ($oldversion < 2015110800) {
        upgrade_block_savepoint(true, 2015110800, 'biblioclub_ru');
    }

    return true;

}
