<?php

namespace Tests\App\Http\Controllers;

use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Helpers\EnvironmentHelper;
use \Mockery;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /** @test **/
    public function homeShouldReturnApiVersion()
    {
        $this->get('/')->seeStatusCode(200)->seeJson(['version' => '1.0']);
    }

    /** @test **/
    public function indexShouldReturnACollectionOfUsers()
    {
        $users = factory('App\User', 2)->create();

        $this->get('/users');

        $content = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $content);

        foreach ($users as $user) {
            $this->seeJson([
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'image'      => EnvironmentHelper::host() . $user->image,
            ]);
        }
    }

    /** @test **/
    public function ShowShouldReturnAnUser()
    {
        $user = factory('App\User')->create();

        $this->get("/users/{$user->id}")->seeStatusCode(200);

        $content = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $content);
        
        $data = $content['data'];

        $this->assertEquals($user->id, $data['id']);
        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals(EnvironmentHelper::host() . $user->image, $data['image']);
    }



    /** @test **/
    public function showShouldFailWhenUserIdNotExists()
    {
        $this->get('/users/99999999')->seeStatusCode(404)
            ->seeJson([
                'message' => 'Not Found',
                'status' => 404
            ]);
    }

    /** @test **/
    public function showShouldNotMatchAnInvalidRoute()
    {
        $this->get('/users/invalid-route');

        $this->assertNotRegExp('/Not found/', $this->response->getContent());
    }

    /** @test **/
    public function storeShouldSaveNewUser()
    {
        $this->markTestIncomplete('Pending to finish');

        /*$fuser = factory('App\User')->make(
            ['name' => 'Test Name']
        );

        $user = json_decode($fuser, true);

        $this->post('/users', $user);

        var_dump($this->response->getContent());die();

        $body = json_decode($this->response->getContent(), true);

        $this->assertArrayHasKey('data', $body);

        $data = $body['data'];

        $this->assertEquals($user['id'], $data['id']);
        $this->assertEquals($user['name'], $data['name']);
        $this->assertEquals($user['email'], $data['email']);
        $this->assertTrue($data['id'] > 0, 'Must be a possitive integer');

        $this->seeInDatabase('users', ['email' => 'valid_email_test@gmail.com']);*/
    }

    /** @test **/
    public function updateAnUser()
    {
        $this->markTestIncomplete('Pending to finish');

        /*$fuserInsert = factory('App\User')->create();

        $fuser = factory('App\User')->make(
            ['name' => 'Test Name']
        );

        //var_dump($testUser);
        //var_dump($userFactory->id);die('AAAAAAAAAAAAAAa');

        $this->put("/users/{$fuserInsert->id}", $fuser, ['charset=utf-8']);

        $this->seeStatusCode(200)->seeJson($fuser)->seeInDatabase('users', ['email' => 'valid_email_test@gmail.com']);

        $body = json_decode($this->response->getContent(), true);
        
        $this->assertArrayHasKey('data', $body);*/
    }

    /** @test **/
    public function updateShouldFailWithAnInvalidId()
    {
        $this->put('/users/99999999')->seeStatusCode(404)
            ->seeJson([
                'message' => 'Not Found',
                'status' => 404
            ]);
    }

    /** @test **/
    public function updateShouldNotMatchAInvalidRoute()
    {
        $this->put('/users/invalid-route')->seeStatusCode(404);
    }

    /** @test **/
    public function destroyShouldRemoveAValidUser()
    {
        $user = factory('App\User')->create();

        $this->delete("/users/{$user->id}")->seeStatusCode(200)
            ->seeJson([
                'data' => [
                'message' => 'Ok'
            ]
        ]);

        $this->notSeeInDatabase('users', ['id' => $user->id]);
    }

    /** @test **/
    public function destroyShouldReturnA404WithAnInvalidId()
    {
        $this->delete('/users/99999999')->seeStatusCode(404)
            ->seeJson([
                'message' => 'Not Found',
                'status' => 404
            ]);
    }

    /** @test **/
    public function destroyShouldNotMatchAnInvalidRoute()
    {
        $this->delete('/users/invalid-route')->seeStatusCode(404);
    }
}