<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
      /**
     * Show All Role
     */


    public function index()
    {
     
      $roles = Role::latest() -> get();
       return view('backend.permission.roleindex', compact('roles'));
    }
    public function create()
    {
      $permissions = Permission::all();
  
       return view('backend.permission.roleadd', compact('permissions'));
    }
     /**
     * Store All Role
     */


     public function store(Request $request)
     {
       $this -> validate ($request,[
        'name' => 'required',
      
            
      ]);
     $role = Role::create(['name'   => $request -> name  ]);
        if (!empty($request->per)){
          foreach($request->per as $per){
            $role -> givePermissionTo($per);
          }
        }

    
      return back() ->with('success', 'Permission added successfuly');
     }

     
    /**
     * Delete A Role
     */

    public function destroy($id)
    {
      $delete_data = Role::findOrFail($id);
      $delete_data -> delete();
      return redirect() -> route('admin.role') ->with('success-main', 'Role deleted successfuly');
    }


 /**
     * Edit role data 
     */
    public function edit($id)
    {
        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $roles = Role::latest() -> get();
        $type = 'edit';
        return view('admin.users.role.index', compact('permissions', 'roles', 'role', 'type'));
    }


 /**
     * Update role data 
     */

public function update(Request $request, $id)
{

   $this -> validate($request, [
       'name'  => 'required'
   ]);


  $update_data =  Role::findOrFail($id);

  $update_data -> update([
      'name'       => $request -> name,
      'slug'       => Str::slug($request -> name),
      'permission' => json_encode($request -> per)
  ]);

  return redirect() -> route('admin.role') -> with('success-main', 'Roel data updated');
  

}








}

