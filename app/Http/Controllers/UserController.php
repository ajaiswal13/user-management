<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getAllUsers();
        return view('users.list', ['users' => json_decode($users,true)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
          ], [
            'first_name.required' => 'First name of user is required',
            'last_name.required' => 'Last name of user is required',
            'email.required' => 'Email is required',
          ]);
          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages())->withInput($request->input());
          }

          $user = new User();
          $isDuplicateUser = $user->findDuplicate($request->all());
          if( $isDuplicateUser){
            return redirect()->route('user.create')
            ->with('error','User with same details is already present in the database.');
          }else{
            $user->insertUser($request->all());
          }
          return redirect()->route('user.index')
                        ->with('success','User added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
          ], [
            'first_name.required' => 'First name of user is required',
            'last_name.required' => 'Last name of user is required',
            'email.required' => 'Email is required',
          ]);
          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages())->withInput($request->input());
          }

          $user = new User();
          $isDuplicateUser = $user->findDuplicate($request->all());
          if( $isDuplicateUser){
            return redirect()->back()
            ->with('error','User with same details is already present in the database.');
          }else{
            $user->updateUser($id,$request->all());
          }
         
          return redirect()->route('user.index')
                        ->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')
        ->with('success','User deleted successfully.');
    }
}
