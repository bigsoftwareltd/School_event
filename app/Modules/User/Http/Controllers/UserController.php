<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function Viewuser()
    {
        return view("User::view-user");
    }
    public function getList(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = User::userList();

            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->addColumn('action', function ($list) {
                    return '<a href="' . route('user_edit', ['id'=>Encryption::encodeId($list->id)]) .
                        '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> Edit </a> <a class="btn btn-danger btn-xs" id="'.Encryption::encodeId($list->id).'" onclick="deleteoperator(this.id,event)" style="color: #ffffff"> <i class="fas fa-remove"></i> Delete </a> ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'action'])
                ->make(true);

        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function edit($id)
    {
        $user_id = Encryption::decodeId($id);

        try {

            $user = User::findOrFail($user_id);

//            $user_types = UserType::where('status','active')->get(['id','type_name']);

            return view('User::edit', compact('user'));

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
    public function Adduser()
    {
        $user = null;

        return view('User::add_user',compact('user'));
    }
    public function userSave(Request $request)
    {
//        $token_no = hash('SHA256', "-" . $request->get('user_email') . "-");
//        $encrypted_token = Encryption::encodeId($token_no);

        try {
            DB::beginTransaction();

            //$data = User::findOrFail(Auth::user()->id);
            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->user_type = $request->user_type;
            $data->username = $request->username;
            $data->password = bcrypt($request->password);
            $data->status = empty($request->status) ? 0 : 1;
//            $data->user_hash = $encrypted_token;
            $data->save();

            DB::commit();

//            $this->createdUserVerification($encrypted_token);

            Session::flash('success', 'The user has created successfully! An email has been sending to the user with a password.');
            return redirect()->route('view-user');

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }
    private function createdUserVerification($encrypted_token)
    {
        try {
            $user = user::where('user_hash', $encrypted_token)->first();
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

//            $user->checkVerified($encrypted_token, $data);

//            AuditPassword::create([
//                'user_id' => $user->id,
//                'password' => $user_password,
//            ]);
            $user = user::findOrfail($user->id);
            $user->password = $user_password;
            $user->save();
            $email_sms_info['user_password'] = $user_password;
            $email_sms_info['base_url'] = config('app.url');

            $receiver_info[] = [
                'user_email' => $user->email,
                'mobile_number' => $user->mobile,
            ];

//            CommonFunction::sendEmailSMS('ACCOUNT_ACTIVATION', $email_sms_info, $receiver_info);

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something went wrong [UC-1520]');
            return \redirect()->back();
        }
    }
    public function update(Request $request)
    {
        $user_id = Encryption::decodeId($request->user_id);
        $user = User::findOrFail($user_id);

        try {
            DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->user_type = $request->user_type;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->status = empty($request->status) ? 0 : 1;


            // User photo
//            if ($request->has('photo') && $request->photo != '') {
//                $request->validate(['photo' => 'required|image|mimes:jpeg,jpg,png']);
//                $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
//                if (!file_exists($path)) {
//                    mkdir($path, 0777, true);
//                    $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
//                    fclose($new_file);
//                }
//                $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
//                $image = $request->photo;
//                $imageName = time() . '.' . $image->extension();
//                $image->move($root_path . '/' . $path, $imageName);
//                $user->photo = $path . $imageName;
//            }

            $user->save();

            DB::commit();

            Session::flash('success', 'The user has updated successfully!');
            return redirect()->route('view-user');

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
            return Redirect::back()->withInput();
        }

    }
    public function DeleteUser(Request $request)
    {
        $user_id = Encryption::decodeId($request->id);
        try{
            User::findOrFail($user_id)->delete();
            $msg = "User Deleted Successfully";
            Session::flash("error","User Deleted Successfully");
            return response()->json($msg);
        }  catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
            return Redirect::back()->withInput();
        }

    }
}
