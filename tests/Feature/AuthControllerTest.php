<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function test_me_correcto()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL25ldyIsImlhdCI6MTY5NzgwNjUzMywiZXhwIjoxNjk3ODEwMTMzLCJuYmYiOjE2OTc4MDY1MzMsImp0aSI6IlVrR2NVd0gyeHI4UWJTUFIiLCJzdWIiOiI2IiwicHJ2IjoiYzIzYzc3ZDdkNjAyMGI3NDFhNWY2MzZmOTZkNDM5MzcyMWM5Y2JiMSJ9.ucP_6_z3KFOovhGHP06ljF357fMEy64Y2YEpjMsQ5ro';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/me');

        $response->assertStatus(200);
    }

    public function test_me_error()
    {
        $token = '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/me');

        $response->assertStatus(401);
    }
}
