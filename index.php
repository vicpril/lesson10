<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
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
function databaseErrorHandler($message, $info) {
    // Если использовалась @, ничего не делать.
    if (!error_reporting())
        return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>";
    print_r($info);
    echo "</pre>";
    exit();
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

$filename_user = 'user.php';

// Проверка существования файла с данными
if (!file_exists($filename_user)) {

    // переадресация, если фаил не существует
    header("Refresh:10; url=install.php");
    exit("Параметры подключения к БД не заданы. Через 10 сек. Вы будете перенаправлены на страницу INSTALL.</br>
            Если автоматического перенаправления не происходит, нажмите <a href='install.php'>здесь</a>.");
}

// Подключение к БД
if (!file_get_contents($filename_user)) {
    exit('Ошибка: неверный формат файла ' . $filename_user);
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
$mysqli->setErrorHandler('databaseErrorHandler');
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

    // Переадресация, если таблиц нет
    header("Refresh:10; url=install.php");
    exit("Нарушена структура или отсутствуют таблицы в БД. Через 10 сек. Вы будете перенаправлены на страницу INSTALL.</br>
            Если автоматического перенаправления не происходит, нажмите <a href='install.php'>здесь</a>.");
}

// Работа скрипта

$id = (isset($_GET['id'])) ? $_GET['id'] : '';

if (isset($_GET['delete'])) {
    delete_explanation_from_db($_GET['delete']);
}

if (isset($_POST['button_add'])) {
    add_explanation_into_db($_POST, $id);
}

$explanations = get_explanations_from_db();

if (isset($_GET['show']) && isset($explanations[$_GET['show']])) {
    $show = $_GET['show'];
    $name = $explanations[$show];
    foreach ($name as &$value) {
        $value = htmlspecialchars($value);
    }
    $smarty->assign('header_tpl', 'header_exp');
    $smarty->assign('title', 'Объявление');
    $smarty->assign('show', $show);
    $smarty->assign('name', $name);
} else {
    $smarty->assign('header_tpl', 'header');
    $smarty->assign('title', 'Доска объявлений');
}

$listOfExplanations = getListOfExplanations($explanations);

$smarty->assign('private_radios', array('0' => 'Частное лицо', '1' => 'Компания'));
$smarty->assign('cities', getCitiesList());
$smarty->assign('categories', getCategoriesList());
$smarty->assign('list', $listOfExplanations);
$smarty->assign('tr', array('bgcolor="#ffffff"', 'bgcolor="#E7F5FE"'));

$smarty->display('index.tpl');
