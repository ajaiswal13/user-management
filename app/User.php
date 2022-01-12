<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;

class User extends Model
{
    public $timestamps = false;

    public function insertUser($requestParams)
    {
      $this->first_name = $requestParams['first_name'];
      $this->last_name = $requestParams['last_name'];
      $this->email = $requestParams['email'];
      $this->save();
      return $this->id;
    }


    public static function getAllUsers()
    {
      return User::all();
    }

    public function updateUser($id,$requestParams)
    {
      $user = User::find($id);
      $user->first_name = $requestParams['first_name'];
      $user->last_name = $requestParams['last_name'];
      $user->email = $requestParams['email'];
      $user->update();
    }

    public function findDuplicate($requestParams){
          $allUsers = json_decode(User::all(),true);
          $isDuplicateUser = false;
          foreach($allUsers as $user){
               if($requestParams['first_name'] == $user['first_name'] &&
               $requestParams['last_name'] == $user['last_name'] &&
               $requestParams['email'] == $user['email']){
                          $isDuplicateUser = true;
                          break;
               }
          }
          return $isDuplicateUser;
    }
}
