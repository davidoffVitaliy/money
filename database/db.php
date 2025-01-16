<?php

function db()
{
    $mysqli = mysqli_connect('MySQL-8.2','root','','money_03');

    if ($mysqli->connect_error) {
        die("Ошибка соединения: " . $mysqli->connect_error);
    }

    return $mysqli;
}