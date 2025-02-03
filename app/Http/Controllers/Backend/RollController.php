<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RollController extends Controller
{
    public function AllPermission(){
        $permissions = Permission::all();
      return view('admin.backend.pages.permission.all_permission',compact('permissions'));

    }// End function

    public function AddPermission(){
        return view('admin.backend.pages.permission.add_permission',);
    }// End function
    public function StorePermission(Request $request){
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
        
        $notifaction = array('message' => 'Permission Add Succefully',
        'alert_type' => 'success');


        return redirect()->route('all.permission')->with($notifaction );

    }// End function
}
