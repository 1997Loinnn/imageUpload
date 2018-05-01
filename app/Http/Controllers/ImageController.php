<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    // #1
    public function index()
    {
        return view('image-view');
    }

    public function store(Request $request)
    {
        $imageName = request()->file->getClientOriginalName();
        request()->file->move(public_path('upload'),$imageName);

        return response()->json(['uploaded'=>'/upload'.$imageName]);
    }
    // #2
    public function imageCrop()
    {
        return view('imageCrop');
    }

    public function imageCropPost(Request $request)
    {
        $data = $request->image;

        list($type,$data) = explode(';',$data);
        list(,$data) = explode(',',$data);

        $data = base64_decode($data);
        $image_name = time().'.png';
        $path = public_path().'/upload/'.$image_name;

        file_put_contents($path,$data);

        return response()->json(['success'=>'done']);
    }

    // #3

    public function imageUpload()
    {
        return view('image-upload');
    }

    public function imageUploadPost(Request $request)
    {
        $this->validate($request,[
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('image'),$imageName);

        return back()
            ->with('success','Image upload successfully')
            ->with('path',$imageName);
    }

    // #4

    public function dropzone()
    {
        return view('dropzone-view');
    }

    public function dropzoneStore(Request $request)
    {
        $image = $request->file('file');
        $imageName = time().$image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);

        return response()->json(['success',$imageName]);
    }

    // #5

    public function resizeImage()
    {
        return view('resizeImage');
    }

    public function resizeImagePost(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'image'=>'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('thumbnail');
        $img =Image::make($image->getRealPath());

        $img->resize(100,100,function ($constraint){
            $constraint->aspectRatio();
        })->save('thumbnail/'.$input['imagename']);



        return $img;
//
//        $image = $request->file('image');
//        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
//
//        $destinationPath = public_path('/thumbnail');
//        $img = Image::make($image->getRealPath());
//        $img->resize(123, 123, function ($constraint) {
//             $constraint->aspectRatio();
//        })->save($destinationPath.'/'.$input['imagename']);
//
//        $destinationPath = public_path('/images');
//        $image->move($destinationPath, $input['imagename']);

//        $image = $request->file('image');
//
//        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
//
//        $destinationPath = public_path('/thumbnail');
//
//        $img = Image::make($image->getRealPath());
//
//        $img->resize(100, 100, function ($constraint) {
//
//            $constraint->aspectRatio();
//
//        })->save($destinationPath.'/'.$input['imagename']);
//
//        /*After Resize Add this Code to Upload Image*/
//        $destinationPath = public_path('/');
//
//
//        $image->move($destinationPath, $input['imagename']);

//        $this->postImage->add($input);
//
//
//        return back()
//            ->with('success','Image Upload successful')
//            ->with('imageName',$input['imagename']);

    }



}
