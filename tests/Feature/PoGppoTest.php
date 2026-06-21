<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PoGppoTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_po_gppo_validation_with_files()
    {
        $user = User::factory()->create([
            'role' => RoleEnum::SUPPLIER->value,
        ]);

        $file = UploadedFile::fake()->create('test.pdf', 100);

        $response = $this->actingAs($user)
            ->post(route('supplier.po-gppo.store'), [
                'invoice_no' => 'INV-123',
                'po_no' => 'PO-123',
                'amount' => 1500.50,
                'files' => [$file],
            ]);

        $response->assertStatus(302);
        // Let's assert there are no validation errors
        $response->assertSessionHasNoErrors();
    }

    public function test_store_po_gppo_validation_fails_without_files()
    {
        $user = User::factory()->create([
            'role' => RoleEnum::SUPPLIER->value,
        ]);

        $response = $this->actingAs($user)
            ->post(route('supplier.po-gppo.store'), [
                'invoice_no' => 'INV-123',
                'po_no' => 'PO-123',
                'amount' => 1500.50,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['files']);
    }

    public function test_update_po_gppo_validation()
    {
        $user = User::factory()->create([
            'role' => RoleEnum::SUPPLIER->value,
        ]);

        $poGppo = \App\Models\PoGppo::create([
            'user_id' => $user->id,
            'invoice_no' => 'INV-123',
            'po_no' => 'PO-123',
            'amount' => 1000.00,
            'files' => [],
            'status' => \App\Enums\PoGppoStatusEnum::PENDING,
        ]);

        $file = UploadedFile::fake()->create('new.pdf', 100);

        $response = $this->actingAs($user)
            ->put(route('supplier.po-gppo.update', $poGppo), [
                'invoice_no' => 'INV-1234',
                'po_no' => 'PO-1234',
                'amount' => '1500.50',
                'files' => [$file],
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function test_store_po_gppo_validation_with_upload_error()
    {
        $user = User::factory()->create([
            'role' => RoleEnum::SUPPLIER->value,
        ]);

        // Create a fake file with an error code (1 = UPLOAD_ERR_INI_SIZE)
        $file = new UploadedFile(
            tempnam(sys_get_temp_dir(), 'test'),
            'large_file.pdf',
            'application/pdf',
            UPLOAD_ERR_INI_SIZE,
            true
        );

        $response = $this->actingAs($user)
            ->post(route('supplier.po-gppo.store'), [
                'invoice_no' => 'INV-123',
                'po_no' => 'PO-123',
                'amount' => 1500.50,
                'files' => [$file],
            ]);

        $response->assertStatus(302);
        fwrite(STDERR, "SESSION ERRORS: " . json_encode(session('errors') ?? [], JSON_PRETTY_PRINT) . PHP_EOL);
    }
}
