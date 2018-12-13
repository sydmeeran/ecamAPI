<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/13/18
 * Time: 2:47 PM
 */

namespace App\Repositories;


use App\PnlExcel;
use Illuminate\Support\Facades\Validator;

class PnlExcelRepository extends BaseRepository
{
    public function model(){
        return PnlExcel::query();
    }

    public function validation($data){
        return Validator::make($data, [
           'var1' => 'int',
           'var2' => 'int',
           'var3' => 'int',
        ]);
    }

    public function setData($excel_file, $job_entry_id){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        /** Load $inputFileName to a Spreadsheet Object  **/
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excel_file)->getActiveSheet();

        $var1 = $spreadsheet->getCell('B1')->getValue();
        $var2 = $spreadsheet->getCell('B2')->getValue();
        $var3 = $spreadsheet->getCell('B3')->getValue();
        $data = [
            'var1' => $var1,
            'var2' => $var2,
            'var3' => $var3,
            'job_entry_id' => $job_entry_id
        ];
        return $data;
    }

    public function register($excel_file, $job_entry_id){
        $data = $this->setData($excel_file, $job_entry_id);
        $validator = $this->validation($data);
        if($validator->fails()){
            if(file_exists($excel_file)){
                unlink($excel_file);
            }
            return $validator;
        }
        $this->model()->create($data);
        return 'success';
    }

    public function update($excel_file, $job_entry_id){
        $data = $this->setData($excel_file, $job_entry_id);
        $validator = $this->validation($data);
        if($validator->fails()){
            if(file_exists($excel_file)){
                unlink($excel_file);
            }
            return $validator;
        }
        $this->model()->where('job_entry_id', $job_entry_id)->update($data);
        return 'success';
    }

}