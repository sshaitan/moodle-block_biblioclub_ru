Seamless authentication in biblioclub.ru from Moodle Learning Platform 
===============================

This is fork of original repo by https://github.com/vadimonus/moodle-block_znanium_com

It's contains a code of plugin for Moodle Platform which enable seamless authentication
of Moodle Platform users in russian digital library system biblioclub.ru. 

Author
------
Vadim Dvorovenko (Vadimon@mail.ru)

Плагин бесшовной аутентификации на сайте biblioclub.ru из Moodle
========================================

Это форк оригинального репо https://github.com/vadimonus/moodle-block_znanium_com

Данный репозитарий содержит исходный код плагина для платформы Moodle.
Плагин реализует возможность добавления блока в платформу Moodle. Блок содержит специальную ссылку для 
пользователей при переходе по которой, пользователь автоматически авторизуется платформой ЭБС Библиоклуб.

При настройке плагина треубется указать данные авторизации:
- домен
- секретный ключ

Эти данные вы можете получить обратившись в техническую поддержку biblioclub.ru.

Системные требования
--------------------
- Moodle 2.7 (сборка 2016120500) и выше.
- Проверено на Moodle 5.2.2 и PHP 8.4.

Установка
---------
Скачайте zip-архив со страницы релизов. Установите плагин через менеджер плагинов Moodle от администратора.

Совместимость с витриной ЭБС от 14.09.2026
------------------------------------------

Новая витрина `biblioclub.ru` использует fingerprint-сессию (`uinfo` + `X-Sign`)
и больше не принимает старый браузерный переход напрямую. Версия плагина от
14.09.2026 выполняет бесшовный вход через официальный compatibility-host
`old.biblioclub.ru`. После перехода пользователь остается авторизованным в ЭБС.

Администратору Moodle не нужно менять домен организации или секретный ключ.
Они по-прежнему задаются в настройках блока.

Автор оригинального кода
------
Вадим Дворовенко (Vadimon@mail.ru)

Автор форка
------
Павел Лобанов (pavel_lobanov@directmedia.ru)
