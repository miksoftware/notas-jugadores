<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Unauthenticated requests to / should redirect to /login.
     */
    public function test_root_redirects_unauthenticated_users_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }
}
