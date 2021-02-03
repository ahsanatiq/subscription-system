<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PlatformTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;


    /** @test */
    public function shouldBeValidationErrorWhenMissingReceipt()
    {
        $this->post('platform/android');

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'type' => 'ValidationException',
        ]);
    }

    /** @test */
    public function shouldBeValidationErrorWhenGivenAnInvalidOS()
    {
        $this->post('platform/abc', ['receipt' => 'ABC1234']);

        $this->seeStatusCode(422);
        $this->seeJsonContains([
            'type' => 'OperatingSystemNotExists',
        ]);
    }

     /** @test */
    public function shouldBeValidationErrorWhenCredentialsInvalidorMissingInHeader()
    {
        $this->post('platform/ios', ['receipt' => 'ABC1234']);

        $this->seeStatusCode(401);
        $this->seeJsonContains([
            'type' => 'PlatformCredentialsFail',
        ]);
    }

    /** @test */
    public function shouldReturnFalseWhenReceiptGivenAsEven()
    {
        $this->post('platform/ios', ['receipt' => 'ABC1234'], ['username' => 'admin', 'password' => '123']);

        $this->seeStatusCode(200);
        $this->seeJsonContains([
            'success' => false
        ]);
    }

    /** @test */
    public function shouldReturnTrueWhenReceiptGivenAsOdd()
    {
        $this->post('platform/ios', ['receipt' => 'ABC1233'], ['username' => 'admin', 'password' => '123']);

        $this->seeStatusCode(200);
        $this->seeJsonContains([
            'success' => true
        ]);
        $this->seeJsonStructure([
            'expiry'
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
