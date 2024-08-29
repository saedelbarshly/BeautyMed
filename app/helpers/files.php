<?php
function checkForDirectory($path)
{
    File::exists($path) or File::makeDirectory($path);
}
function upload_image($path , $image , $width=300 , $height=null)
{
    checkForDirectory('uploads/'.$path);
    // $image must be a $request->image 
    Intervention\Image\Facades\Image::make($image)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    })
        ->save(public_path('uploads/'.$path .'/'. $image->hashName()));
    return $image->hashName();
}

function upload_image_without_resize($path , $image )
{
    checkForDirectory('uploads/'.$path);
    // $image must be a $request->image 
    Intervention\Image\Facades\Image::make($image)->save(public_path('uploads/'.$path .'/'. $image->hashName()));
    return $image->hashName();
}

function delete_image($folder , $image)
{
    if (File::exists($folder.'/'.$image))
        File::delete($folder.'/'.$image);
}

function delete_folder($folder)
{
    if (File::exists($folder))
        File::deleteDirectory($folder);
}

function upload_file($path, $request_file){
    $fileName = time().'.'.$request_file->getClientOriginalExtension();
    $request_file->move(public_path('uploads/'.$path), $fileName);
    return $fileName;
}

function is_current_route($route){
    if(request()->route()->getName() == $route)
        return true;
    return false;
}

function get_setting_by_key($key){
    return \App\Setting::where('key',$key)->first();
}

function image_path($path,$image_name){
    return asset("public/uploads/$path/".$image_name);
}