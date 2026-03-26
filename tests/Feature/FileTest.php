<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function test_utilisateur_peut_uploader_un_fichier(): void
    {
        Storage::fake('private');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($user)->post(route('files.store'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('files.index'));
        $this->assertDatabaseHas('files', [
            'user_id' => $user->id,
        ]);
    }

    public function test_utilisateur_peut_telecharger_son_fichier(): void
    {
        Storage::fake('private');

        $user = User::factory()->create();
        $fakeFile = UploadedFile::fake()->create('test.pdf', 50);
        $path = $fakeFile->store('uploads', 'private');

        $file = File::factory()->create([
            'user_id'       => $user->id,
            'path'          => $path,
            'original_name' => 'test.pdf',
        ]);

        $response = $this->actingAs($user)
            ->get(route('files.download', $file));

        $response->assertStatus(200);
    }

    public function test_utilisateur_ne_peut_pas_telecharger_fichier_dautrui(): void
    {
        Storage::fake('private');

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $file = File::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->get(route('files.download', $file));

        $response->assertStatus(403);
    }
}