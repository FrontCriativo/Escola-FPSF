<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    public function test_public_site_from_zip_renders(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Escola FPSF')
            ->assertSee('css/style.css', false)
            ->assertSee('js/script.js', false);
    }
}
