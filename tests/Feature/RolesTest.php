<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_authorization()
    {
        $this->post('/login', [
            'login' => 'admin',
            'password' => 'admin'
        ]);
        $response = $this->get('/inbox/incidents');
        $response->assertOk();
    }

    public function test_user_can_not_view_equipment_types()
    {
        $this->post('/login', [
            'login' => 'user',
            'password' => 'user'
        ]);
        $response = $this->get('/directory/types');
        $response->assertForbidden();
    }
}
