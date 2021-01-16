<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserSettings;
use Illuminate\Http\Request;
use Validator;
use Auth;

class SettingController extends Controller
{
    public function setDefaultImageVisibility($id)
    {
       $validator = Validator::make(request()->all(), [
           'visibility' => 'required|string'
       ]);

       if ($validator->fails()) {
           toast($validator->errors()->first(), 'error');
           return redirect()->back();
       }

       $userSettings = UserSettings::find($id);

       UserSettings::where('id', $id)->update([
          'default_image_visibility' => request()->get('visibility')
       ]);

        activity()->causedBy(Auth::user())->performedOn($userSettings)->log('Updated default image visibility to ' .  $userSettings->default_image_visibility);

       toast('Default visibility changed to: ' . request()->get('visibility'), 'success');
       return redirect()->back();
    }
}
