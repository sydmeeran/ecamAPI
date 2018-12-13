<?php

namespace App\Imports;

use App\BalanceSheetExcel;
use Maatwebsite\Excel\Concerns\ToModel;

class BalanceSheetExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BalanceSheetExcel([
            'var1' => $row[0],
            'var2' => $row[1],
            'var3' => $row[3]
        ]);
    }
}
