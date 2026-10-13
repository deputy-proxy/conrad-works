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
        $keys = ['OWNER_NAME', 'OWNER_EMAIL', 'OWNER_PASSWORD'];
        $original = [];

        foreach ($keys as $key) {
            $original[$key] = getenv($key);
            putenv($key);
            unset($_ENV[$key], $_SERVER[$key]);
        }

        try {
            (new RoleDomainsSeeder)->run();
            $this->fail('Seeding should require explicit owner credentials when no user exists.');
        } catch (RuntimeException $exception) {
            $this->assertSame(
                'No owner account exists. Set OWNER_NAME, OWNER_EMAIL, and OWNER_PASSWORD before seeding.',
                $exception->getMessage()
            );
        } finally {
            foreach ($original as $key => $value) {
                if ($value === false) {
                    putenv($key);
                    unset($_ENV[$key], $_SERVER[$key]);
                    continue;
                }

                putenv($key.'='.$value);
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }

        $this->assertDatabaseCount('users', 0);
    }
}
