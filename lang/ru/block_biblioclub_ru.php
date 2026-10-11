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

$string['defaultlink'] = 'Перейти на сайт ЭБС Biblioclub';
$string['defaulttitle'] = 'ЭБС Biblioclub';
$string['domain'] = 'Домен';
$string['eventlinkused'] = 'Осуществлен преход на сайт ЭБС Biblioclub';
$string['link'] = 'Текст ссылки';
$string['month'] = 'Месяц';
$string['pluginname'] = 'Аутентификация на сайте ЭБС Biblioclub';
$string['privacy:metadata:visits'] = 'История переходов пользователя из Moodle в ЭБС.';
$string['privacy:metadata:visits:userid'] = 'Пользователь Moodle, перешедший по ссылке в ЭБС.';
$string['privacy:metadata:visits:contextid'] = 'Контекст Moodle, из которого был выполнен переход.';
$string['privacy:metadata:visits:time'] = 'Время перехода пользователя по ссылке.';
$string['privacy:visits'] = 'Переходы в ЭБС';
$string['privacy:metadata:external'] = 'Идентификационные данные передаются biblioclub.ru для бесшовной авторизации и доступа к внешней библиотеке. Данные, хранящиеся в ЭБС, нужно запрашивать у этого сервиса.';
$string['privacy:metadata:external:userid'] = 'Идентификатор пользователя Moodle, используемый для идентификации в ЭБС.';
$string['privacy:metadata:external:login'] = 'Логин пользователя Moodle (короткие логины дополняются до шести символов); он может быть адресом электронной почты.';
$string['privacy:metadata:external:firstname'] = 'Имя пользователя.';
$string['privacy:metadata:external:lastname'] = 'Фамилия пользователя.';
$string['privacy:metadata:external:middlename'] = 'Отчество пользователя, если указано.';
$string['privacy:metadata:external:domain'] = 'Домен организации, настроенный администратором.';
$string['privacy:metadata:external:time'] = 'Время запроса авторизации.';
$string['secretkey'] = 'Секретный ключ';
$string['statistics'] = 'Статистика';
$string['title'] = 'Заголовок блока';
$string['visits'] = 'Число переходов';
$string['biblioclub_ru:addinstance'] = 'Добавлять блок ЭБС Biblioclub';
$string['biblioclub_ru:myaddinstance'] = 'Добавлять блок ЭБС Biblioclub на домашнюю страницу';
$string['biblioclub_ru:use'] = 'Использовать блок для перехода на сайт ЭБС Biblioclub';
$string['biblioclub_ru:viewstats'] = 'Просматривать статистику переходов';
