<?php

// General functions library

function daysToSec($days)
{
    return ((60 * 60) * 24) * $days;
}

function emailExists($conn, $email)
{
    $exists = FALSE;
    $sql = "SELECT id FROM customers WHERE email=\"$email\"";
    $result = mysql_query($sql, $conn);
    $numrows = mysql_num_rows($result);

    if ($numrows > 0)
    {
        $exists = true;
    }

    return $exists;
}

function userExists($conn, $user)
{
    $exists = false;
    $sql = "select id from customers where user_name=\"$user\"";

    $result = mysql_query($sql, $conn);
    $numrows = mysql_num_rows($result);
    if ($numrows > 0)
    {
        $exists = true;
    }
    return $exists;
}

function encryptPassword($plain)
{
    return crypt($plain, substr($plain, 0, 2));
}

function generatePassword()
{
    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $strlen = (strlen($str) - 1);
    $len = 12;
    $pass = "";

    for ($i = 0; $i < $len; $i++)
    {
        $pass .= substr($str, rand(0, $strlen), 1);
    }

    return $pass;
}

function getValue($conn, $table, $column, $where)
{
    $where = (!empty($where)) ? "where " . $where : $where;
    $sql = "select $column from $table $where";
//	die($sql);
    $result = execute($sql, $conn);

    while ($rs = mysql_fetch_array($result))
    {
        $value = $rs[$column];
    }

    return $value;
}

function setValue($conn, $table, $column, $value, $where, $valueType)
{
    // $valueType		1=String, 2=Numeric

    $escape = "";

    if ($valueType == 1)
    {
        $escape = "\"";
    }

    $where = (!empty($where)) ? "where " . $where : $where;
    $sql = "update $table set $column=" . $escape . "$value" . $escape . " $where";
    $result = execute($sql, $conn);

    return true;
}

function execute($sql, $conn)
{
    $result = mysql_query($sql, $conn); //or die(mysql_error($conn));

    return $result;
}

