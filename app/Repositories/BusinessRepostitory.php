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
use Illuminate\Validation\ValidationException;
use JD\Cloudder\Facades\Cloudder;

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
            'license_type' => 'required',
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
        if(!$license_no_arrs){
            $license_no_arrs = [];
            for($i=0; $i<count($business_name_arrs); $i++){
                $license_no_arrs[] = null;
            }
        }

        $result = array_map(function ($business_name_arr, $license_no_arr, $license_type_arr, $license_photo_arr, $address_arr) {
            return array_combine(
                ['business_name', 'license_no', 'license_type', 'license_photo', 'address'],
                [$business_name_arr, $license_no_arr, $license_type_arr, $license_photo_arr, $address_arr]
            );
        }, $business_name_arrs, $license_no_arrs, $license_type_arrs, $license_photo_arrs, $address_arrs);

        return $result;
    }

    public function create_business($data, $member_id){
        if(is_array($data['license_type'])){

            if(!$data['license_no']){
                $datbusinessesa['license_no'] = [];
            }

            if(!$data['license_photo']){
                $data['license_photo'] = [];
            }

            $businesses = $this->combine_array($data['business_name'], $data['license_no'], $data['license_type'], $data['license_photo'], $data['address']);

            foreach($businesses as $business){
                $this->model()->create([
                    'business_name' => $business['business_name'],
                    'license_no' => $business['license_no'],
                    'license_type' => $business['license_type'],
                    'license_photo' => $business['license_photo'],
                    'address' => $business['address'],
                    'member_id' => $member_id
                ]);
            }
        } else {
            $this->model()->create([
                'business_name' => $data['business_name'],
                'license_no' => $data['license_no'],
                'license_type' => $data['license_type'],
                'license_photo' => $data['license_photo'],
                'address' => $data['address'],
                'member_id' => $member_id
            ]);
        }
        return 'success';

    }

    public function storeLicensePhoto(Request $request){
        /**
         * @var UploadedFile $license_photo
         */
        $license_photos = $request->file('license_photo');
        $i=0;
        foreach($license_photos as $license_photo){
            // $nrc_photo = $request->nrc_photo;

            // if(!is_null($nrc_photo)){

                $filename = $license_photo->getRealPath();

                Cloudder::upload($filename, image_name('business', 'license_photos'),[
                    'folder' => 'ecam/business/license_photos/'
                ]);

                $image_id = Cloudder::getPublicId();

                $lpn[] = $image_id;
            // }

            // return null;

            // $name =  $this->uuid($this->prefix, 15).$i.'.'.$license_photo->getClientOriginalExtension();
            // $license_photo_name = $license_photo->move(public_path('db/license_photos'), $name);
            // $lpn[] = 'db/license_photos/'.$license_photo_name->getFilename();
            $i++;
        }
        if(!isset($lpn)){

            $filename = $license_photos->getRealPath();

            Cloudder::upload($filename, image_name('business', 'license_photos'),[
                'folder' => 'ecam/business/license_photos/'
            ]);

            $image_id = Cloudder::getPublicId();

            $lpn = $image_id;

            // $name =  $this->uuid($this->prefix, 15).'.'.$license_photos->getClientOriginalExtension();
            // $license_photo_name = $license_photos->move(public_path('db/license_photos'), $name);
            // $lpn = 'db/license_photos/'.$license_photo_name->getFilename();
        };
        return $lpn;
    }

    public function store(Request $request, $member_id){
        $data = $this->setData($request);

        if(Input::hasFile('license_photo')){
            $license_photo_name = $this->storeLicensePhoto($request);
            $data['license_photo'] = $license_photo_name;
        } else {
            $data['license_photo'] = null;
        }

        $this->create_business($data, $member_id);

        return 'success';
    }

    public function register(Request $request, $member_id){
        $validator = $this->validation($request);
        if($validator->fails()){
            throw new ValidationException($validator);
        }
        $data = $this->setData($request);
        if(Input::hasFile('license_photo')){
            $license_photo_name = $this->storeLicensePhoto($request);
            $data['license_photo'] = $license_photo_name;
        } else {
            $data['license_photo'] = null;
        }

        return $this->create_business($data, $member_id);
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
        return $request->validate([
            'business_name' => 'required|string',
            'license_type' => 'required|string',
            'license_photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
        ]);
    }

//    public function updateLicensePhoto(Request $request, $id){
//        /**
//         * @var UploadedFile $license_photo
//         */
//        if (Input::hasFile('license_photo')) {
//            $business = $this->find($id);
//            if(file_exists($business->license_photo)){
//                unlink($business->license_photo);
//            }
//            return $this->storeLicensePhoto($request);
//        }
//        return $this->storeLicensePhoto($request);
//    }

    public function update(Request $request, $id){
        $this->updateValidation($request);

        // $validator = $this->updateValidation($request);
        // if($validator->fails()){
        //     return $validator;
        // }

        $data = $this->setData($request);

        if(Input::hasFile('license_photo')){

            $business = $this->find($id);
            // if(file_exists($business->license_photo)){
            //     unlink($business->license_photo);
            // }
            // delete_image($business->license_photo);

            $license_photo = $this->storeLicensePhoto($request);
            $data['license_photo'] = $license_photo;
        }

        $this->model()->where('id', $id)->update($data);

        return 'success';
    }


    public function deleteByMemberId($id){
        $this->model()->where('member_id', $id)->delete();
    }
}