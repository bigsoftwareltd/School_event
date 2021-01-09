<?php

namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Modules\Content\Models\Content;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ContentController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewContent()
    {
        $content = null;
        return view('Content::view-content',compact('content'));
    }

    public function getContent(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = Content::contentList();

            return DataTables::of($list)
                ->editColumn('image', function ($list) {
                    return ' <a target="_blank"><i class="fas fa-file-archive 2x" style="color: #0a0f1c"></i>"'.basename($list->image).'"</a>';
                })
                ->addColumn('action', function ($list) {
                    return '<a id="'.$list->id.'" onclick="editcontent(this.id)" class="btn btn-primary btn-xs" style="color: #fff"> <i class="fa fa-edit"></i> Edit </a> <a style="color: #fff" name="'.$list->id.'" onclick="deletecontent(this.name)" class="btn btn-danger btn-xs"> <i class="fa fa-remove"></i> Delete </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action','image'])
                ->make(true);

        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function SaveContent(Request $request)
    {
//        dd($request->all());
//        try {
            DB::beginTransaction();
            if($request->content_id !=null){
                $data = Content::findOrFail($request->content_id);
            }
            else{
                $data = new Content();
            }

            $data->title = $request->title;
            $data->description = $request->description;


            if ($request->has('image') && $request->image != '') {
                $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png']);
                $path = 'uploads/users/' . date("Y") . "/" . date("m") . "/";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                    fclose($new_file);
                }
                $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
                $image = $request->image;
                $imageName = time() . '.' . $image->extension();
                $image->move($root_path . '/' . $path, $imageName);
                $data->image = $path . $imageName;
            }
//            $data->status = !empty($request->status) ? $request->status : 0;
            $data->save();
            // User photo
            DB::commit();
            $content = Content::all();
            Session::flash('success', 'The Content has been added successfully!');
            return response()->json($content);
//            return Redirect::back();

//        } catch (\Exception $e) {
//            DB::rollback();
//            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
//            return Redirect::back()->withInput();
//        }

    }
    public function EditContent(Request $request)
    {
        $downloads = Content::findOrFail($request->id);
        return response()->json($downloads);
    }
    public function DeleteContent(Request $request)
    {
//        Client::findOrFail($request->id)->delete();
        DB::table('content')->where('id',$request->id)->delete();
        $msg = "Download documents Deleted Successfully";
        Session::flash("success","Download documents Deleted Successfully");
        return response()->json($msg);
    }
}
