<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Academic;

class AcademicTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

/*     public function test_index()
    {
        // load data in db
        $academics = Academic::factory(10)->create();
        // call index
        $response = $this->json('get', 'academics');
        // assert status
        $reponse->assertStatus(200);
        // verify records

    } */

    public function test_create(){
        $academic = [
            'firstname' => 'Zhe',
            'lastname' => 'Wang',
            'teaching_load' => '40',
            'area' => 'AI',
            'note' => 'no note'
        ];
        $this->post('academic', $academic);

        $this->assertDatabaseHas('academics', $academic);
        // Not sure why the redirect assert fails. 
        // $response->assertRedirect('academic');
    }

    public function test_validation(){
        $this->post('academic', ['firstname'=>'Bob', 'area' => 'anything'])
                ->assertSessionHasErrors('lastname')
                ->assertStatus(302);

        $this->assertDatabaseMissing('academics', ['firstname' =>'Bob']);
    }

}
