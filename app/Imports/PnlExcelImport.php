<?php

namespace App\Imports;

use App\PnlExcel;
use Maatwebsite\Excel\Concerns\ToModel;

class PnlExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PnlExcel([
            'var1' => $row[0],
            'var2' => $row[1],
            'var3' => $row[3]
        ]);
    }
}
