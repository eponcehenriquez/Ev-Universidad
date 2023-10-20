<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function test_me_correcto()
    {

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjk3NzUzNzM4LCJleHAiOjE2OTc3NTczMzgsIm5iZiI6MTY5Nzc1MzczOCwianRpIjoiOU5QR0ViR1pPbHdDRGwyRiIsInN1YiI6IjEiLCJwcnYiOiJjMjNjNzdkN2Q2MDIwYjc0MWE1ZjYzNmY5NmQ0MzkzNzIxYzljYmIxIn0.ahXLchgRl1wsdc9ZZ5OFp7PGvtQE5QfPda5QsWXuGPg';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/me');

        $response->assertStatus(200);
    }
}
