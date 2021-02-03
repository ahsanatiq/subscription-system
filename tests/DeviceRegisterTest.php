<?php

use Domain\Device;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeviceRegisterTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /** @test */
    public function shouldBeValidationErrorWhenEmpty()
    {
        $this->post('/v1/device/register');

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'type' => 'ValidationException',
        ]);
    }

    /** @test */
    public function shouldBeOkayWhenValidParams()
    {
        $data = [
            'uID' => 'X123456789Z',
            'appID' => 'ABC1234',
            'language' => 'en',
            'os' => 'android'
        ];

        $this->post('/v1/device/register', $data);

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'token'
        ]);
        $this->seeInDatabase('devices', [
            'u_id' => $data['uID'],
            'app_id' => $data['appID'],
            'lang' => $data['language'],
            'os' => $data['os'],
        ]);
    }

    /** @test */
    public function shouldNotDuplicateWhenDeviceAlreadyExistsAndExpectNewToken()
    {
        $data = [
            'uID' => 'X123456789Z',
            'appID' => 'ABC1234',
            'language' => 'en',
            'os' => 'android'
        ];

        $this->post('/v1/device/register', $data);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'token'
        ]);
        $token1 = json_decode($this->response->getContent(), true)['token'];
        $this->post('/v1/device/register', $data);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'token'
        ]);
        $token2 = json_decode($this->response->getContent(), true)['token'];
        $this->assertNotEquals(
            $token1,
            $token2
        );
        $this->assertEquals(1, Device::where([
            'u_id' => $data['uID'],
            'app_id' => $data['appID'],
            'lang' => $data['language'],
            'os' => $data['os'],
        ])->count());
    }

    /** @test */
    public function shouldBeValidationErrorWhenOSisNotFromTheList()
    {
        $this->post('/v1/device/register', [
            'uID' => 'X123456789Z',
            'appID' => 'ABC1234',
            'language' => 'en',
            'os' => 'macos'
        ]);

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'type' => 'ValidationException',
            'message' => 'OS should be one of: android,ios'
        ]);
    }

    /** @test */
    public function shouldBeValidationErrorWhenLangIsNotFromTheList()
    {
        $this->post('/v1/device/register', [
            'uID' => 'X123456789Z',
            'appID' => 'ABC1234',
            'language' => 'PR',
            'os' => 'ios'
        ]);

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'type' => 'ValidationException',
            'message' => 'Language should be one of: en,fr,ch,ar'
        ]);
    }
}
