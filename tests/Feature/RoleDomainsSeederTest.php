<?php

namespace Tests\Feature;

use Database\Seeders\RoleDomainsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class RoleDomainsSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_without_an_owner_or_explicit_credentials_fails_safely(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'No owner account exists. Set OWNER_NAME, OWNER_EMAIL, and OWNER_PASSWORD before seeding.'
        );

        (new RoleDomainsSeeder)->run();

        $this->assertDatabaseCount('users', 0);
    }
}
