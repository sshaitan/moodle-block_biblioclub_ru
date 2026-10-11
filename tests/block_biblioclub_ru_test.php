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

namespace block_biblioclub_ru;

/**
 * Rendering regression tests.
 *
 * @package block_biblioclub_ru
 * @copyright 2026 Pavel Lobanov
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\block_biblioclub_ru::class)]
final class block_biblioclub_ru_test extends \advanced_testcase {
    /** The second call returns the same content object without new queries. */
    public function test_content_is_cached(): void {
        global $CFG, $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        require_once($CFG->dirroot . '/blocks/moodleblock.class.php');
        require_once($CFG->dirroot . '/blocks/biblioclub_ru/block_biblioclub_ru.php');
        $block = new \block_biblioclub_ru();
        $block->page = new \moodle_page();
        $block->page->set_context(\context_system::instance());
        $block->page->set_url('/');
        $first = $block->get_content();
        $queries = $DB->perf_get_queries();
        $this->assertSame($first, $block->get_content());
        $this->assertSame($queries, $DB->perf_get_queries());
        $this->assertStringContainsString('redirect.php', $first->text);
        $this->assertStringContainsString('statistics.php', $first->text);
    }

    /** Users without either capability receive a defined empty text field. */
    public function test_content_without_capabilities(): void {
        global $CFG;
        $this->resetAfterTest();
        $this->setGuestUser();
        require_once($CFG->dirroot . '/blocks/moodleblock.class.php');
        require_once($CFG->dirroot . '/blocks/biblioclub_ru/block_biblioclub_ru.php');
        $block = new \block_biblioclub_ru();
        $block->page = new \moodle_page();
        $block->page->set_context(\context_system::instance());
        $this->assertSame('', $block->get_content()->text);
        $this->assertSame('', $block->get_content()->footer);
    }
}
