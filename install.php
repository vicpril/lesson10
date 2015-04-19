<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 0);
header("Content-Type: text/html; charset=utf-8");

$project_root = __DIR__;
$smarty_dir = $project_root . '/smarty/';


// put full path to Smarty.class.php
require($smarty_dir . '/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = false;
$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

// Подключаем библиотеку FirePHPCore
require_once ($project_root . '/FirePHPCore/FirePHP.class.php');

// Инициализируем класс FirePHP
$firePHP = FirePHP::getInstance(true);

// Устанавливаем активность. Если выключить (false), то отладочные сообщения не будут
// отображаться в FireBug
$firePHP->setEnabled(true);

//
// FUNCTION
//

// Код обработчика ошибок SQL.
    function installErrorHandler($message, $info) {
        // Если использовалась @, ничего не делать.
        if (!error_reporting())
            return;
        // Выводим информацию об ошибке.
        $path = strstr($message, '/');
        // Сообщение об ошибке без пути
        echo "SQL Error: ". rtrim($message, 'at '.$path);
        // Кнопка "назад"
        exit('<br><a href="#" onclick="history.go(-1)">Go Back</a>');
    }

    // Пишем лог в firePHP
    function myLogger($db, $sql, $caller) {
        global $firePHP;
        if (isset($caller['file'])) {
            $firePHP->group("at " . @$caller['file'] . ' line ' . @$caller['line']);
        }
        $firePHP->log($sql);
        if (isset($caller['file'])) {
            $firePHP->groupEnd();
        }
    }

//
// Main block
//

$page_from = 'install.php';
$filename_user = 'user.php';

if (!isset($_POST['button_install'])) {
    // Стартовая страница index.php
    $smarty->assign('title', 'Вход в базу данных');
    $smarty->assign('message', 'Введите данные для подключения к БД');
    $smarty->assign('action', 'install.php');
    $smarty->display('user_ini.tpl');
    exit;
} else {
    // Подключение к БД
    if ($_POST['button_install'] == 'Вход в базу данных') {
        $user['db_name'] = $_POST['database_name'];
        $user['s_name'] = $_POST['server_name'];
        $user['u_name'] = $_POST['user_name'];
        $user['pas'] = $_POST['password'];

//        if ($user['db_name'] == '') {
//            exit('Не введено имя базы данных. Заполните соответствующее поле. <br><a href="#" onclick="history.go(-1)">Go Back</a>');
//        }

        if (!file_put_contents($filename_user, serialize($user))) {
            exit('Ошибка: не удалось записать фаил ' . $filename_user);
        }
    }

    $user = unserialize(file_get_contents($filename_user));
    $u_name = $user['u_name'];
    $s_name = $user['s_name'];
    $pas = $user['pas'];
    $db_name = $user['db_name'];

// Подключить DBSimple
    require_once $project_root . "/dbsimple/config.php";
    require_once "DbSimple/Generic.php";

// Подключаемся к БД.
    $mysqli = DbSimple_Generic::connect("mysqli://$u_name:$pas@$s_name/$db_name");

// Устанавливаем обработчик ошибок.
    $mysqli->setErrorHandler('installErrorHandler');
    $mysqli->setLogger('myLogger');
    
    $message = "Соединение с БД установлено.<br>";

    $mysql_dir = $project_root;
    include($mysql_dir . '/mysql.php');

    // Проверка существования таблиц
    $tables = array();
    $tables = $mysqli->selectCol("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", $db_name);

    if (!in_array('explanations', $tables) ||
            !in_array('categories_list', $tables) ||
            !in_array('cities_list', $tables)) {

        // Установка таблиц, если таблиц нет
        $message .=install_dump($db_name);
    } else {

        // Диалог восстановления из дампа
        if ($_POST['button_install'] == 'Вход в базу данных') {
            $smarty->display('install_dump.tpl');
            exit;
        } else {
            if ($_POST['button_install'] == 'Да') {
                $message .=install_dump($user['db_name']);
            }
            // Если 'Нет' - то отображаем 'install_ok.tpl'
        }
    }

    // Страница ОК
    $smarty->assign('action', 'index.php');
    $smarty->assign('message', $message);
    $smarty->display('install_ok.tpl');
}