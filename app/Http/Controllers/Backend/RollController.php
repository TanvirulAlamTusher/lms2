<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Support\Facades\DB;
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

    public function EditRoles($id){
        $roles = role::find($id);
        return view('admin.backend.pages.roles.edit_roles',compact('roles'));
     }// End function

     public function UpdateRoles(Request $request){
        $role_id = $request->id;
        Role::find($role_id)->update([
            'name' => $request->name,

        ]);

        $notifaction = array('message' => 'Roles Update Succefully',
        'alert_type' => 'success');


        return redirect()->route('all.roles')->with($notifaction );

    }// End function
    public function DeleteRoles($id){
        Role::find($id)->delete();

        $notifaction = array('message' => 'Role Delete Succefully',
        'alert_type' => 'success');
        return redirect()->back()->with($notifaction );

    }// End function

    ////////////////////////////////Add Roles Permission all route////////////////////////////////////////

    public function AddRolesPermission(){
        $roles =  Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.backend.pages.rolesetup.add_roles_permission',
        compact('roles','permission_groups','permissions'));

    }// End function

    public function RolesPermissionStore(Request $request){
        $data = array();
        $permissions = $request->permission;

     foreach ($permissions as $key => $item) {
        $data['role_id'] = $request->role_id;
        $data['permission_id'] = $item;

        DB::table('role_has_permissions')->insert($data);
     }
     $notifaction = array('message' => 'Role Permission Succefully',
     'alert_type' => 'success');

     return redirect()->route('all.roles')->with($notifaction );

    }//end function

    public function AllRolesPermission(){
        $roles = Role::all();
        return view('admin.backend.pages.rolesetup.all_roles_permission',
        compact('roles'));
    }//end function

    public function AdminEditRoles($id){
        $role =  Role::find($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.backend.pages.rolesetup.edit_roles_permission',
        compact('role','permission_groups','permissions'));

    }//end function

    public function AdminUpdateRoles(Request $request, $id)
{
    $role = Role::findById($id, 'web'); // Ensure correct guard
    $permissions = $request->permission ?? [];

    // Convert IDs to names
    $permissionNames = \Spatie\Permission\Models\Permission::whereIn('id', $permissions)->pluck('name')->toArray();

    $role->syncPermissions($permissionNames); // Use names instead of IDs

    return redirect()->route('all.roles.permission')->with([
        'message' => 'Role Permission Updated Successfully',
        'alert-type' => 'success'
    ]);
}

    public function AdminDeleteRoles($id){
      $role = Role::find($id);
      if (!is_null($role)) {
        $role->delete();
    }

    $notification = array(
        'message' => 'Role Permission Deleted Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);

    }// End Method

     ////////////////////////////////End Add Roles Permission all route////////////////////////////////////////


}
