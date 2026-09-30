<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
        /**
        * Show All User
        */
        public function index()
        {
          $users = User::latest() -> get();
           return view('backend.permission.userindex', compact('users'));
        }

        public function edit($id)
        {
            $user = User::findOrFail($id);
            $roles = Role::orderBy('name', 'asc')->get(); 
            $hasRoles = $user->roles->pluck('id');
            // dd($hasRoles);
            return view('backend.permission.useredit', compact('user', 'roles', 'hasRoles'));
        }

     public function update(Request $request, $id)
     {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'  => 'required|min:3',
      
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('users.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $user->name  = $request->name;
        $user->save();

        $user->syncRoles($request->role);


    
      return redirect()->route('users.index')->with('success', 'User updated successfully');
     }
}
