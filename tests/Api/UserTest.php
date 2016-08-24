<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BaseApiTestCase
{

    public function testGetAllUsers()
    {
//        $this->withOAuthTokenTypeUser();
        $this->getApi('users');
        $this->printResponseData();
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'user_id',
                    'name',
                ],
            ]
        ]);
    }

    public function testGetCurrentUser()
    {
//        $this->withOAuthTokenTypeUser();
        $this->getApi('users/me');
        $this->printResponseData();
        $this->assertResponseOk();
    }

    public function testGetSingleUser()
    {
//        $this->withOAuthTokenTypeUser();
        $this->getApi('users/1');
        $this->assertResponseOk();
    }

    public function testCreateUser()
    {
//        $this->withOAuthTokenTypeClient();
        $this->postApi('users', [
            'name' => 'Abc',
            'email' => rand(100000, 999999) . 'abc@example.com',
            'password' => '12345678',
        ]);
        $this->printResponseData();
        $this->assertResponseOk();
    }

    public function testUpdateUser()
    {
//        $this->withOAuthTokenTypeUser();
        $this->putApi('users/2', [
            'name' => 'Harry Potter',
        ]);
        $this->printResponseData();
        $this->assertResponseNoContent();
    }

    public function testDeleteUser()
    {
        $user = \Someline\Models\Foundation\User::find(3);
        if (!$user) {
            $user = factory(\Someline\Models\Foundation\User::class, 1)->make();
            $user->user_id = 3;
            $user->save();
        }

//        $this->withOAuthTokenTypeUser();
        $this->deleteApi('users/3');
        $this->printResponseData();
        $this->assertResponseNoContent();
    }

}
