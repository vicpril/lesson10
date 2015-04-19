<?php

function getCitiesList() {
    global $mysqli;
    $cities = $mysqli->selectCol("SELECT `index` AS ARRAY_KEY, city FROM cities_list");
    return $cities;
}

function getCategoriesList() {
    global $mysqli;
    $result = $mysqli->select("SELECT t2.index, t2.category AS cat, t1.category AS groupe
                        FROM categories_list AS t1
                        LEFT JOIN categories_list AS t2 ON t2.parent_id = t1.index
                        WHERE t2.parent_id is not null");
    foreach ($result as $row) {
        $categories [$row['groupe']][$row['index']] = $row['cat'];
    }
    return $categories;
}

function get_explanations_from_db() {
    global $mysqli;
    $explanations = $mysqli->select( "SELECT id AS ARRAY_KEY, private, seller_name, "
            . "email, allow_mails, phone, location_id, category_id, title, description, "
            . "price FROM explanations ORDER BY id");
    if (isset($explanations)) {
        return $explanations;
    } else {
        return array();
    }
}

// Обработка входящего объявления
function processingQuery($exp, $id) {
    $exp['id'] = $id;
    if (isset($exp['button_add'])){
        unset($exp['button_add']);
    }
    foreach ($exp as $key => &$value) {
        $query[$key] = strip_tags($value);
    }
    $query['price'] = (float) $query['price'];
    return $query;
}

// Добавить объявление в БД
function add_explanation_into_db($exp, $id) {
    global $mysqli;
    $exp = processingQuery($exp, $id);
    $mysqli->select("REPLACE INTO explanations (?#) VALUES (?a)", array_keys($exp), array_values($exp));
}

function delete_explanation_from_db($id) {
    global $mysqli;
    $mysqli->select("delete from explanations where id = ?d", $id);
}

function getListOfExplanations($explanations) {
    $list = array();
    foreach ($explanations as $key => $value) {
        $list[] = '<a href="index.php?show=' . $key . '">' . $value['title'] . '</a>';
        $list[] = $value['price'];
        $list[] = $value['seller_name'];
        $list[] = '<a href="index.php?delete=' . $key . '">Удалить</a>';
    }
    return $list;
}

// Очистка таблиц, установка дампа
function install_dump($db_name) {
    global $project_root;
    $dump_dir = $project_root . '/dump_db/';
    $filename = $dump_dir . 'test.sql';

    if (!file_exists($filename)) {
        exit('Дамп базы не найден');
    }
    if (!file($filename)) {
        exit('Ошибка: неверный формат файла ' . $filename);
    } else {
        dropOldTables($db_name);
        parceDump($filename);
    }
    $message = "Базы данных установлены.<br>";
    return $message;
}

function dropOldTables($db) {
    global $mysqli;
    $mysqli->select("SET FOREIGN_KEY_CHECKS = 0");
    $query = "SELECT concat('DROP TABLE IF EXISTS ', table_name, ';') AS `drop` "
            . "FROM information_schema.tables "
            . "WHERE table_schema = ?";
    $tables = $mysqli->selectCol($query, $db);
    foreach ($tables as $value) {
        $mysqli->select($value);
    }
    $mysqli->select("SET FOREIGN_KEY_CHECKS = 1");
}

function parceDump($dump_filename, $i = 0, $j = 0) {
    global $mysqli;
    $dump = file($dump_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($dump as $key => $value) {
        if (substr($value, 0, 2) == '--') {
            unset($dump[$key]);
        }
    }
    $str = implode('', $dump);
    while ($i <= strlen($str) - 1) {
        if ($str[$i] == ';') {
            $query = substr($str, $j, $i - $j);
            $mysqli->select($query);
            $j = $i + 1;
        }
        $i++;
    }
}


