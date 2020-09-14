<?php

namespace App\Http\Controllers;

use Storage;
use App\User;
use App\UserImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Resources\UserImage as UserImageResource;

class UserImageController extends Controller
{
  public function store()
  {
    $data = request()->validate([
      'image' => '',
      'width' => '',
      'height' => '',
      'location' => '',
    ]);

    $image = $data['image']->store('user-images', 'public');
    
    if($data['location'] == 'profile'){
      $LastImage=User::findOrFail(auth()->user()->id)->profileImage;
    }else{
      $LastImage=User::findOrFail(auth()->user()->id)->coverImage;
    }

    $userImage = auth()->user()->images()->create([
      'path' => $image,
      'width' => $data['width'],
      'height' => $data['height'],
      'location' => $data['location'],
    ]);
    
    if($userImage && $LastImage->id){
      UserImage::findOrFail($LastImage->id)->delete();
    }
    
    $storageImage=Image::make($data['image'])
    ->resize($data['width'], $data['height'])
    // ->fit($data['width'], $data['height'])
    ->save(storage_path('app/public/user-images/'.$data['image']->hashName()));
    
    if($storageImage 
      && $LastImage->path 
      && $LastImage->path != 'user-images/1.jpeg' 
      && $LastImage->path != 'user-images/person1.png')
    {
      Storage::has('public/' . $LastImage->path)?Storage::delete('public/' . $LastImage->path ):'';
    }
    return new UserImageResource($userImage);
  }
}
