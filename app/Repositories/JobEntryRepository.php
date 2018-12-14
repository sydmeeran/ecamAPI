<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/12/18
 * Time: 5:48 PM
 */

namespace App\Repositories;


use App\Imports\PnlExcelImport;
use App\JobEntry;
use App\PnlExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class JobEntryRepository extends BaseRepository
{
    protected $pnl, $balance_sheet;

    public function __construct()
    {
        $this->pnl = DataRepo::pnl_excel();
        $this->balance_sheet = DataRepo::balance_sheet_excel();
    }

    public function model()
    {
        return JobEntry::query();
    }

    public function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'type' => 'required|string',
            'company_type' => 'required|string',
            'excel_type' => 'required|string',
            'excel_file' => 'required|mimes:xlsx,csv|max:2048',
            'customer_id' => 'required',
        ]);
    }

    public function setData(Request $request)
    {
        $job_entry_data = [
            'type' => $request->input('type'),
            'company_type' => $request->input('company_type'),
            'excel_type' => $request->input('excel_type'),
            'customer_id' => $request->input('customer_id'),
        ];
        return $job_entry_data;
    }

    public function storeExcelFile(Request $request, $excel_type, $customer_id)
    {
        /**
         * @var UploadedFile $nrc_photo
         */

            $excel_file = $request->file('excel_file');
            $excel_file_name = $excel_file->move(public_path('db/excel_files/' . $excel_type), $this->uuid(date('m'), 15) . '.' . $excel_file->getClientOriginalExtension());
            $name = 'db/excel_files/' . $excel_type . '/' . $excel_file_name->getFilename();
            return $name;
    }

    public function store(Request $request)
    {
        $validator = $this->validation($request);
        if ($validator->fails()) {
            return $validator;
        }

        $data = $this->setData($request);

        $excel_file = $this->storeExcelFile($request, $data['excel_type'], $data['customer_id']);

        $data['excel_file'] = $excel_file;

        $job_entry = $this->model()->create($data);

        if ($data['excel_type'] == "pnl") {
            $this->pnl->register($excel_file, $job_entry->id);
        } else {
            $this->balance_sheet->register($excel_file, $job_entry->id);
        }

        return 'success';
    }

    public function updateValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'type' => 'required|string',
            'company_type' => 'required|string',
            'excel_type' => 'required|string',
            'excel_file' => 'mimes:xlsx,csv|max:2048',
            'customer_id' => 'required',
        ]);
    }

    public function updateNrcPhoto(Request $request, $id)
    {
        if (Input::hasFile('nrc_photo')) {
            $customer = $this->find($id);
            if (file_exists($customer->nrc_photo)) {
                unlink($customer->nrc_photo);
            }
        }
        return $this->storeNrcPhoto($request);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->updateValidation($request);
        if ($validator->fails()) {
            return $validator;
        }

        $data = $this->setData($request);

        if(Input::hasFile('excel_file')){
            $job_entry = $this->find($id);
            if(file_exists($job_entry->excel_file)){
                unlink($job_entry->excel_file);
            }

            $excel_file = $this->storeExcelFile($request, $data['excel_type'], $data['customer_id']);

            $data['excel_file'] = $excel_file;

            if ($data['excel_type'] == "pnl") {
                $this->pnl->update($excel_file, $id);
            } else {
                $this->balance_sheet->update($excel_file, $id);
            }
        }

        $this->model()->where('id', $id)->update($data);

        return 'success';
    }

    public function destroy($id){
        $job_entry = $this->find($id);
        if(file_exists($job_entry->excel_file)){
            unlink($job_entry->excel_file);
        }

        $this->delete($id);
    }
}