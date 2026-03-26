<?php

namespace Tests\Feature;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FolderTest extends TestCase
{
    use RefreshDatabase;

    public function test_utilisateur_peut_creer_un_dossier(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('folders.store'), [
            'name' => 'Mon dossier test',
        ]);

        $response->assertRedirect(route('folders.index'));
        $this->assertDatabaseHas('folders', [
            'name'    => 'Mon dossier test',
            'user_id' => $user->id,
        ]);
    }

    public function test_utilisateur_ne_peut_pas_voir_dossier_dautrui(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $folder = Folder::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->get(route('folders.show', $folder));

        $response->assertStatus(403);
    }

    public function test_utilisateur_peut_supprimer_son_dossier(): void
    {
        $user = User::factory()->create();
        $folder = Folder::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete(route('folders.destroy', $folder));

        $response->assertRedirect(route('folders.index'));
        $this->assertDatabaseMissing('folders', ['id' => $folder->id]);
    }
}