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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

namespace block_biblioclub_ru\privacy;

use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\transform;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy scope and isolation tests.
 *
 * @package block_biblioclub_ru
 * @copyright 2026 Pavel Lobanov
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\PHPUnit\Framework\Attributes\CoversClass(provider::class)]
final class provider_test extends \core_privacy\tests\provider_testcase {
    /** @var \stdClass First user. */
    private $user1;
    /** @var \stdClass Second user. */
    private $user2;
    /** @var \context[] Contexts with visits. */
    private $contexts;

    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();
        $this->user1 = $generator->create_user();
        $this->user2 = $generator->create_user();
        $course1 = $generator->create_course();
        $course2 = $generator->create_course();
        $this->contexts = [
            \context_system::instance(),
            \context_course::instance($course1->id),
            \context_course::instance($course2->id),
            \context_user::instance($this->user1->id),
        ];
        global $DB;
        foreach ($this->contexts as $context) {
            foreach ([$this->user1, $this->user2] as $user) {
                $DB->insert_record('block_biblioclub_ru_visits', (object) [
                    'userid' => $user->id, 'contextid' => $context->id, 'time' => 1700000000,
                ]);
            }
        }
    }

    /** Discover visits in system, course and user contexts. */
    public function test_context_and_user_discovery(): void {
        $contextids = array_map(function($context) {
            return $context->id;
        }, $this->contexts);
        $this->assertEqualsCanonicalizing($contextids, provider::get_contexts_for_userid($this->user1->id)->get_contextids());
        $this->assertEmpty(provider::get_contexts_for_userid(999999)->get_contextids());
        foreach ($this->contexts as $context) {
            $users = new userlist($context, 'block_biblioclub_ru');
            provider::get_users_in_context($users);
            $this->assertEqualsCanonicalizing([$this->user1->id, $this->user2->id], $users->get_userids());
        }
    }

    /** Exports neither other users' visits nor unapproved contexts. */
    public function test_export_is_scoped(): void {
        global $DB;
        $context = $this->contexts[1];
        $DB->insert_record('block_biblioclub_ru_visits', (object) [
            'userid' => $this->user2->id, 'contextid' => $context->id, 'time' => 1800000000,
        ]);
        $approved = new approved_contextlist($this->user1, 'block_biblioclub_ru', [$context->id]);
        provider::export_user_data($approved);
        $data = writer::with_context($context)->get_data([get_string('privacy:visits', 'block_biblioclub_ru')]);
        $this->assertCount(1, $data->visits);
        $this->assertEquals(transform::datetime(1700000000), $data->visits[0]->time);
        $this->assertFalse(writer::with_context($this->contexts[2])->has_any_data());
    }

    /** Single-user deletion preserves other users and other contexts. */
    public function test_delete_data_for_user(): void {
        global $DB;
        $approved = new approved_contextlist($this->user1, 'block_biblioclub_ru', [$this->contexts[1]->id]);
        provider::delete_data_for_user($approved);
        $this->assertEquals(7, $DB->count_records('block_biblioclub_ru_visits'));
        $this->assertEquals(4, $DB->count_records('block_biblioclub_ru_visits', ['userid' => $this->user2->id]));
        $this->assertEquals(3, $DB->count_records('block_biblioclub_ru_visits', ['userid' => $this->user1->id]));
    }

    /** Bulk deletion preserves unapproved users and other contexts. */
    public function test_delete_data_for_users(): void {
        global $DB;
        $approved = new approved_userlist($this->contexts[1], 'block_biblioclub_ru', [$this->user1->id]);
        provider::delete_data_for_users($approved);
        $this->assertEquals(7, $DB->count_records('block_biblioclub_ru_visits'));
        $this->assertEquals(4, $DB->count_records('block_biblioclub_ru_visits', ['userid' => $this->user2->id]));
        provider::delete_data_for_users(new approved_userlist(
            $this->contexts[2], 'block_biblioclub_ru', [$this->user1->id, $this->user2->id]
        ));
        $this->assertEquals(5, $DB->count_records('block_biblioclub_ru_visits'));
    }

    /** All-user deletion affects exactly one context. */
    public function test_delete_context(): void {
        global $DB;
        provider::delete_data_for_all_users_in_context($this->contexts[0]);
        $this->assertEquals(6, $DB->count_records('block_biblioclub_ru_visits'));
        $this->assertFalse($DB->record_exists('block_biblioclub_ru_visits', ['contextid' => $this->contexts[0]->id]));
    }

    /** Empty approved lists are safe no-ops. */
    public function test_empty_approvals(): void {
        global $DB;
        provider::delete_data_for_user(new approved_contextlist($this->user1, 'block_biblioclub_ru', []));
        provider::delete_data_for_users(new approved_userlist($this->contexts[0], 'block_biblioclub_ru', []));
        provider::export_user_data(new approved_contextlist($this->user1, 'block_biblioclub_ru', []));
        $this->assertEquals(8, $DB->count_records('block_biblioclub_ru_visits'));
        $this->assertFalse(writer::with_context($this->contexts[0])->has_any_data());
    }
}
