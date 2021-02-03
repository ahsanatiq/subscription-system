<?php

use Domain\Device;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CheckSubscriptionTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    private $client_token;

    protected function setUp(): void
    {
        parent::setUp();
        app('redis')->flushdb();
        $data = [
            'uID' => 'X123456789Z',
            'appID' => 'ABC1234',
            'language' => 'en',
            'os' => 'android'
        ];
        $this->post('/v1/device/register', $data);
        $this->client_token = json_decode($this->response->getContent(), true)['token'];
    }

    /** @test */
    public function shouldBeValidationErrorWhenEmpty()
    {
        $this->post('/v1/subscription/check');

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'type' => 'ValidationException',
        ]);
    }

    /** @test */
    public function shouldBeFalseWhenDidNotPurchase()
    {
        $data = [
            'clientToken' => $this->client_token,
        ];

        $this->post('/v1/subscription/check', $data);

        $this->seeStatusCode(200);
        $this->seeJsonContains([
            'status' => false
        ]);
    }

    /** @test */
    public function shouldBeTrueWhenDidPurchase()
    {
        $data = [
            'clientToken' => $this->client_token,
            'receipt' => 'ABC1235',
        ];
        $this->post('/v1/subscription/purchase', $data);

        $data = [
            'clientToken' => $this->client_token,
        ];
        $this->post('/v1/subscription/check', $data);

        $this->seeStatusCode(200);
        $this->seeJsonContains([
            'status' => true
        ]);
    }

    public function runDatabaseMigrations()
    {
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }
}
