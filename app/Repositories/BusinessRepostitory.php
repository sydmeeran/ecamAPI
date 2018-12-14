<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 11:32 AM
 */

namespace App\Repositories;

use App\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class BusinessRepostitory extends BaseRepository
{
    protected $prefix;

    public function __construct()
    {
        $this->prefix = date('my');
    }

    public function model(){
        return Business::query();
    }

    public function validation(Request $request){
        return Validator::make($request->all(), [
            'business_name' => 'required',
            'license_no' => 'required',
            'license_type' => 'required',
            'license_photo' => 'required',
            'license_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required',
        ]);
    }

    public function setData(Request $request){
        $business_data = [
            'business_name' => $request->input('business_name'),
            'license_no' => $request->input('license_no'),
            'license_type' => $request->input('license_type'),
            'address' => $request->input('address'),
        ];
        return $business_data;
    }

    protected function combine_array($business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs) {
        $result = array_map(function ($business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs) {
            return array_combine(
                ['business_name', 'license_no', 'license_type', 'license_photo', 'address'],
                [$business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs]
            );
        }, $business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs);

        return $result;
    }

    public function create_business($data, $customer_id){
        if(is_array($data['license_photo'])){
            $businesses = $this->combine_array($data['business_name'], $data['license_no'], $data['license_type'], $data['license_photo'], $data['address']);

            foreach($businesses as $business){
                $this->model()->create([
                    'business_name' => $business['business_name'],
                    'license_no' => $business['license_no'],
                    'license_type' => $business['license_type'],
                    'license_photo' => $business['license_photo'],
                    'address' => $business['address'],
                    'customer_id' => $customer_id
                ]);
            }
        } else {
            $this->model()->create([
                'business_name' => $data['business_name'],
                'license_no' => $data['license_no'],
                'license_type' => $data['license_type'],
                'license_photo' => $data['license_photo'],
                'address' => $data['address'],
                'customer_id' => $customer_id
            ]);
        }

    }

    public function storeLicensePhoto(Request $request){
        /**
         * @var UploadedFile $license_photo
         */
        $license_photos = $request->file('license_photo');
        foreach($license_photos as $license_photo){
            $name =  $this->uuid($this->prefix, 15).'.'.$license_photo->getClientOriginalExtension();
            $license_photo_name = $license_photo->move(public_path('db/license_photos'), $name);
            $lpn[] = 'db/license_photos/'.$license_photo_name->getFilename();
        }
        if(!isset($lpn)){
            $name =  $this->uuid($this->prefix, 15).'.'.$license_photos->getClientOriginalExtension();
            $license_photo_name = $license_photos->move(public_path('db/license_photos'), $name);
            $lpn = 'db/license_photos/'.$license_photo_name->getFilename();
        };
        return $lpn;
    }

    public function store(Request $request, $customer_id){
//        $validator = $this->validation($request);
//        if($validator->fails()){
//            return $validator;
//        }
        $license_photo_name = $this->storeLicensePhoto($request);
        $data = $this->setData($request);
        $data['license_photo'] = $license_photo_name;

        $this->create_business($data, $customer_id);

        return 'success';
    }

    public function register(Request $request, $customer_id){
        $validator = $this->validation($request);
        if($validator->fails()){
            return $validator;
        }
        $license_photo_name = $this->storeLicensePhoto($request);
        $data = $this->setData($request);
        $data['license_photo'] = $license_photo_name;

        $this->create_business($data, $customer_id);

        return 'success';
    }

//    public function update(Request $request){
//
//    }

//    public function updateLicensePhoto(){
//        if (Input::hasFile('license_photo')) {
//            $license_photo = $this->find($id);
//            if(file_exists($license_photo)){
//                unlink($license_photo);
//            }
//        }
//
//    }

    public function updateValidation(Request $request){
        return Validator::make($request->all(), [
            'business_name' => 'required|string',
            'license_no' => 'required|string',
            'license_type' => 'required|string',
            'license_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
        ]);
    }

    public function updateLicensePhoto(Request $request, $id){
        /**
         * @var UploadedFile $license_photo
         */
        if (Input::hasFile('nrc_photo')) {
            $business = $this->find($id);
            if(file_exists($business->license_photo)){
                unlink($business->license_photo);
            }
            return $this->storeLicensePhoto($request);
        }
        return $this->storeLicensePhoto($request);
    }

    public function update(Request $request, $id){
        $validator = $this->updateValidation($request);
        if($validator->fails()){
            return $validator;
        }

        $data = $this->setData($request);

        if(Input::hasFile('license_photo')){

            $business = $this->find($id);
            if(file_exists($business->license_photo)){
                unlink($business->license_photo);
            }

            $license_photo = $this->storeLicensePhoto($request);
            $data['license_photo'] = $license_photo;
        }

        $this->model()->where('id', $id)->update($data);

        return 'success';
    }


    public function deleteByCustomerId($id){
        $this->model()->where('customer_id', $id)->delete();
    }
}