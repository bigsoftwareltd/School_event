<?php

namespace App\Modules\Event\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Event\Models\Downloads;
use App\User;
use App\Modules\Event\Models\Event;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewGallery()
    {
        $event = null;
        return view('Event::list',compact('event'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = Event::galleryList();

            return DataTables::of($list)
//                ->addColumn('image', function ($list) {
//                    return '<img src="' . route('user_edit', ['id'=>Encryption::encodeId($list->id)]) .
//                        '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i>';
//                })
                ->addColumn('action', function ($list) {
                    return '<a href="' . route('user_edit', ['id'=>Encryption::encodeId($list->id)]) .
                        '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> Edit </a> <a href="' . route('user_edit', ['id'=>Encryption::encodeId($list->id)]) .
                        '" class="btn btn-danger btn-xs"> <i class="fa fa-remove"></i> Delete </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);

        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function SaveGallery(Request $request)
    {

        try {
            DB::beginTransaction();

            //$data = User::findOrFail(Auth::user()->id);
            $details = Array();
            $data = new Event();
            $data->event_name = $request->event_name;
            $data->date = $request->date;
            $data->save();
            $event_id = DB::table('photo_gallery')->orderBy("created_at","desc")->first()->id;
            $photo = $request->input('photo');
            if($photo){
                foreach ($photo as $key=>$value){
                    if ($request->has('photo') && $request->photo != '') {
                        $request->validate(['photo' => 'required|image|mimes:jpeg,jpg,png']);
                        $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                            $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                            fclose($new_file);
                        }
                        $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
                        $image = $photo[$key];
                        $imageName = time() . '.' . $image->extension();
                        $image->move($root_path . '/' . $path, $imageName);

                        $details->photo = $path . $imageName;
                        $details->event_id = $event_id;
                    }
                    $save = DB::table('photo')->insert($details);
                }
            }


            // User photo


            DB::commit();

            $this->createdUserVerification($encrypted_token);

            Session::flash('success', 'The user has created successfully! An email has been sending to the user with a password.');
            return redirect()->route('user_list');

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }

    }

    private function createdUserVerification($encrypted_token)
    {
        try {
            $user = User::where('user_hash', $encrypted_token)->first();
            if (empty($user)) {
                Session::flash('error', 'Invalid token! Please sign up again to complete the process');
                return redirect()->route('user_add');
            }

            // e.g. 'Sgbw~pec2l'
            $special_char = "!@#$%^&*()_+={}:;'\|,>?/<>.`~";
            $user_password = chr(rand(65,90)). strtolower(Str::random(3)). substr(str_shuffle($special_char),0,1). strtolower(Str::random(3)). rand(0,9). chr(rand(97,122));

            DB::beginTransaction();

            $data = [
                'password' => Hash::make($user_password),
                'email_verified_at' => Carbon::now(),
            ];

            $user->checkVerified($encrypted_token, $data);

            AuditPassword::create([
                'user_id' => $user->id,
                'password' => $user_password,
            ]);

            $email_sms_info['user_password'] = $user_password;
            $email_sms_info['base_url'] = config('app.url');

            $receiver_info[] = [
                'user_email' => $user->email,
                'mobile_number' => $user->mobile,
            ];

            CommonFunction::sendEmailSMS('ACCOUNT_ACTIVATION', $email_sms_info, $receiver_info);

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something went wrong [UC-1520]');
            return \redirect()->back();
        }
    }

    public function EditGallery($id)
    {
        $user_id = Encryption::decodeId($id);

        try {

            $user = User::findOrFail($user_id);

            $user_types = UserType::where('status','active')->get(['id','type_name']);

            return view('Users::edit', compact('user', 'user_types'));

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }

    public function UpdateGallery(Request $request)
    {
        $user_id = Encryption::decodeId($request->user_id);
        $user = User::findOrFail($user_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:100|unique:users,email,'.$user->id,
            'mobile' => 'required|string',
            'date_of_birth' => 'required|date',
            //'user_type' => 'required',
//                'father_name' => 'required|string|max:191',
//                'mother_name' => 'required|string|max:191',
//                'gender' => 'required',
//                'religion' => 'required',
//                'marital_status' => 'required',
//                'national_id' => 'required|string|max:191',
//                'alternate_mobile' => 'required|string',
//                'present_address' => 'required|string|max:191',
//                'permanent_address' => 'required|string|max:191',
        ]);

        try {
            DB::beginTransaction();

            $user->user_type = $request->user_type;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->date_of_birth = (!empty($request->date_of_birth) ? CommonFunction::dateStore($request->date_of_birth) : null);
            $user->mobile = $request->mobile;
            $user->father_name = $request->father_name;
            $user->mother_name = $request->mother_name;
            $user->gender = $request->gender;
            $user->religion = $request->religion;

            if(in_array(Auth::user()->user_type, ['101']) && Auth::user()->id != $user->id) {
                $user->status = empty($request->status) ? 0 : 1;
            }

//        $user->marital_status = $request->marital_status;
//        $user->national_id = $request->national_id;
//        $user->alternate_mobile = $request->alternate_mobile;
//        $user->present_address = $request->present_address;
//        $user->permanent_address = $request->permanent_address;

            // User photo
            if ($request->has('photo') && $request->photo != '') {
                $request->validate(['photo' => 'required|image|mimes:jpeg,jpg,png']);
                $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                    fclose($new_file);
                }
                $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
                $image = $request->photo;
                $imageName = time() . '.' . $image->extension();
                $image->move($root_path . '/' . $path, $imageName);
                $user->photo = $path . $imageName;
            }

            $user->save();

            DB::commit();

            Session::flash('success', 'The user has updated successfully!');
            return redirect()->route('user_list');

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
            return Redirect::back()->withInput();
        }

    }
    public function RemoveGallery(Request $request)
    {

    }
    public function ViewDownloads()
    {
        $downloads = null;
        return view('Event::downloads.list',compact('downloads'));
    }

    public function getDownloadList(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = Downloads::downloadList();

            return DataTables::of($list)
                ->editColumn('file', function ($list) {
                    return ' <a target="_blank"><i class="fas fa-file-archive 2x" style="color: #0a0f1c"></i>"'.basename($list->file).'"</a>';
                })
                ->addColumn('action', function ($list) {
                    return '<a id="'.$list->id.'" onclick="editdownloads(this.id)" class="btn btn-primary btn-xs" style="color: #fff"> <i class="fa fa-edit"></i> Edit </a> <a style="color: #fff" name="'.$list->id.'" onclick="deletedownloads(this.name)" class="btn btn-danger btn-xs"> <i class="fa fa-remove"></i> Delete </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action','file'])
                ->make(true);

        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function SaveDownloads(Request $request)
    {

        try {
            DB::beginTransaction();
            if($request->document_id){
                $data = Downloads::findOrFail($request->document_id);
            }
            else{
                $data = new Downloads();
            }

            $data->document_name = $request->document_name;
            if($request->date){
                $data->date = $request->date;
            }
            else{
                $data->date = date('Y-m-d H:i:s',Carbon::now());
            }

            $file = $request->file('file');

                    if ($request->has('file') && $request->file != '') {
                        $request->validate(['file' => 'required|file|mimes:pdf,docx,doc,ppt,pptx,xls,xlsx']);
                        $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                            $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                            fclose($new_file);
                        }
                        $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
                        $new_file = $request->file;
                        $fileName = time() . '.' . $new_file->extension();
                        $new_file->move($root_path . '/' . $path, $fileName);

                        $data->file = $path . $fileName;
                    }
                    $data->save();

            // User photo


            DB::commit();


            Session::flash('success', 'The downloads document has been added successfully!');
            return redirect()->route('view_downloads');

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }

    }
    public function EditDownloads(Request $request)
    {
        $downloads = Downloads::findOrFail($request->id);
        return response()->json($downloads);
    }
    public function DeleteDownloads(Request $request)
    {
//        Client::findOrFail($request->id)->delete();
        DB::table('downloads')->where('id',$request->id)->delete();
        $msg = "Download documents Deleted Successfully";
        Session::flash("success","Download documents Deleted Successfully");
        return response()->json($msg);
    }
}
