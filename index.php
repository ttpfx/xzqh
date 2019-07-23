<?php

// 数据来源：http://www.mca.gov.cn/article/sj/xzqh/2019/

$text = file_get_contents('xzqh.txt');
$list = explode("\n", $text);

$result = [];

foreach ($list as $v) {
    $v = trim($v);

    // 编号
    $id = substr($v, 0, 6);
    // 名称
    $name = trim(substr($v, 6));
    // 级别
    $level = level($id);

    // 上级id
    if (isset($result[substr($id, 0, 4) . '00'])) {
        $pid = substr($id, 0, 4) . '00';
    } else if (isset($result[substr($id, 0, 2) . '0000'])) {
        $pid = substr($id, 0, 2) . '0000';
    } else {
        $pid = 0;
    }


    $result[$id] = [
        'id' => $id,
        'pid' => $pid,
        'name' => $name,
        'level' => $level,
    ];
}

var_export($result);

/**
 * 编号后4位为0为省，返回1
 * 否则后2位为0为市，返回2
 * 否则为县，返回3
 */
function level($code)
{
    if (substr($code, -4) === '0000') {
        return 1;
    } else if (substr($code, -2) == '00') {
        return 2;
    } else {
        return 3;
    }
}