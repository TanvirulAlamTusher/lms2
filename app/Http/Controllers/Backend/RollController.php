<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Illuminate\Http\Request;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
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

    public function EditPermission($id){
       $permission = Permission::find($id);
       return view('admin.backend.pages.permission.edit_permission',compact('permission'));
    }// End function

    public function UpdatePermission(Request $request){
        $per_id = $request->id;
        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notifaction = array('message' => 'Permission Update Succefully',
        'alert_type' => 'success');


        return redirect()->route('all.permission')->with($notifaction );

    }// End function

    public function DeletePermission($id){
        Permission::find($id)->delete();

        $notifaction = array('message' => 'Permission Delete Succefully',
        'alert_type' => 'success');
        return redirect()->back()->with($notifaction );

    }// End function

    public function ImportPermission(){
        return view('admin.backend.pages.permission.import_permission',);
    }//End function
    public function Export(){
        return Excel::download(new PermissionExport, 'permission.xlsx');

        // you can download as csv file also
        // return Excel::download(new PermissionExport, 'permission.csv');

    }// End function
    public function Import(Request $request){
        try{
            Excel::import(new PermissionImport, $request->file('import_file'));


            $notifaction = array('message' => 'Permission Imported Succefully',
            'alert_type' => 'success');

            return redirect()->route('all.permission')->with($notifaction );


        }catch(Exception $e){
            $notifaction = array('message' => 'Permission Exctis',
            'alert_type' => 'error');

            return redirect()->back()->with($notifaction );

        }


    }// End function

    ///////////All Role Method////////////////

    public function AllRoles(){
        $roles = Role::all();
      return view('admin.backend.pages.roles.all_roles',compact('roles'));

    }// End function

    public function AddRoles(){
        return view('admin.backend.pages.roles.add_roles',);
    }// End function

    public function StoreRoles(Request $request){
        Role::create([
            'name' => $request->name,

        ]);

        $notifaction = array('message' => 'Roles Add Succefully',
        'alert_type' => 'success');


        return redirect()->route('all.roles')->with($notifaction );

    }// End function
}
