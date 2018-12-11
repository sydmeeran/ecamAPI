<?php

use Illuminate\Pagination\LengthAwarePaginator;

function createRangePaginator($itemCount, $total, $perPage)
{
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $path = LengthAwarePaginator::resolveCurrentPath();
    $paginator = new LengthAwarePaginator(range(1, $itemCount), $total, $perPage, $currentPage, [
        'path' => $path,
    ]);

    return $paginator;
}

function formatTableData(array $data)
{
    $fields = $data;
    $columns = array_shift($data);
    $columns = array_keys(array_except($columns, 'id'));

    return [
        'columns' => $columns,
        'fields'  => $fields,
    ];
}

function ok($ok = true, $merge = [])
{
    $status = $ok ? 200 : 500;

    return response(array_merge(['success' => $ok], $merge), $status);
}

function in_array_multi($needle, $array): bool
{
    if (!is_array($array)) {
        return false;
    }
    foreach ($array as $item) {
        if ($item === $needle || is_array($item) && in_array_multi($needle, $item)) {
            return true;
        }
    }

    return false;
}

function checkEmail($email)
{
    if (strpos($email, '@') !== false) {
        $split = explode('@', $email);

        return strpos($split[1], '.') ? true : false;
    }

    return false;
}

function human_memory($byte)
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

    return @round($byte / pow(1024, ($i = floor(log($byte, 1024)))), 2).' '.$unit[$i];
}
