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

namespace block_biblioclub_ru\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\transform;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy Subsystem.
 *
 * @package    block_biblioclub_ru
 * @copyright  2020 Pavel Lobanov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\request\core_userlist_provider {
    /**
     * Describe stored visits and the identity sent to Biblioclub.
     *
     * @param collection $collection Metadata collection.
     * @return collection
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table('block_biblioclub_ru_visits', [
            'userid' => 'privacy:metadata:visits:userid',
            'contextid' => 'privacy:metadata:visits:contextid',
            'time' => 'privacy:metadata:visits:time',
        ], 'privacy:metadata:visits');
        $collection->add_external_location_link('biblioclub.ru', [
            'user_id' => 'privacy:metadata:external:userid',
            'login' => 'privacy:metadata:external:login',
            'first_name' => 'privacy:metadata:external:firstname',
            'last_name' => 'privacy:metadata:external:lastname',
            'parent_name' => 'privacy:metadata:external:middlename',
            'domain' => 'privacy:metadata:external:domain',
            'time' => 'privacy:metadata:external:time',
        ], 'privacy:metadata:external');
        return $collection;
    }

    /**
     * Find the contexts from which the user followed the link.
     *
     * @param int $userid User ID.
     * @return contextlist
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();
        $contextlist->add_from_sql(
            'SELECT c.id FROM {context} c
               JOIN {block_biblioclub_ru_visits} v ON v.contextid = c.id
              WHERE v.userid = :userid',
            ['userid' => $userid]
        );
        return $contextlist;
    }

    /**
     * Find users with visits in the supplied context (not necessarily a block context).
     *
     * @param userlist $userlist Context and user list.
     */
    public static function get_users_in_context(userlist $userlist) {
        $userlist->add_from_sql('userid',
            'SELECT userid FROM {block_biblioclub_ru_visits} WHERE contextid = :contextid',
            ['contextid' => $userlist->get_context()->id]
        );
    }

    /**
     * Export only the approved user's visits in approved contexts.
     *
     * @param approved_contextlist $contextlist Approved user and contexts.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        foreach ($contextlist->get_contexts() as $context) {
            $records = $DB->get_records('block_biblioclub_ru_visits', [
                'userid' => $contextlist->get_user()->id,
                'contextid' => $context->id,
            ], 'time ASC, id ASC');
            if (!$records) {
                continue;
            }
            $visits = [];
            foreach ($records as $record) {
                $visits[] = (object) ['time' => transform::datetime($record->time)];
            }
            writer::with_context($context)->export_data(
                [get_string('privacy:visits', 'block_biblioclub_ru')],
                (object) ['visits' => $visits]
            );
        }
    }

    /**
     * Delete all visits in exactly this context.
     *
     * @param \context $context Approved context.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;
        $DB->delete_records('block_biblioclub_ru_visits', ['contextid' => $context->id]);
    }

    /**
     * Delete only the approved user's visits in approved contexts.
     *
     * @param approved_contextlist $contextlist Approved user and contexts.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $contextids = $contextlist->get_contextids();
        if (!$contextids) {
            return;
        }
        list($insql, $params) = $DB->get_in_or_equal($contextids, SQL_PARAMS_NAMED);
        $params['userid'] = $contextlist->get_user()->id;
        $DB->delete_records_select('block_biblioclub_ru_visits',
            "userid = :userid AND contextid $insql", $params);
    }

    /**
     * Delete only the approved users' visits in the approved context.
     *
     * @param approved_userlist $userlist Approved context and users.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $userids = $userlist->get_userids();
        if (!$userids) {
            return;
        }
        list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
        $params['contextid'] = $userlist->get_context()->id;
        $DB->delete_records_select('block_biblioclub_ru_visits',
            "contextid = :contextid AND userid $insql", $params);
    }
}
