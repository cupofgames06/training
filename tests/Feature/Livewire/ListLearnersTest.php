<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ListLearners;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ListLearnersTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ListLearners::class);

        $component->assertStatus(200);
    }
}
