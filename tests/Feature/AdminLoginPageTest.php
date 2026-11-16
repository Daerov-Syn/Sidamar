<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminLoginPageTest extends TestCase
{
    public function test_admin_login_page_has_expected_branding_and_form(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
        $response->assertSeeText('SiDamar Admin');
        $response->assertSeeText('Masuk ke Panel Admin');
        $response->assertSeeText('ADMIN PORTAL');
        $response->assertSeeText('Kembali ke Portal Publik');
    }
}
