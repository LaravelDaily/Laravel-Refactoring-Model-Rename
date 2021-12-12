<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');

        $this->user = User::first(); // admin
        $this->actingAs($this->user);
    }

    public function testProductsIndex()
    {
        $response = $this->get('/admin/products');

        $response->assertStatus(200);
    }

    public function testProductsCreate()
    {
        $response = $this->get('/admin/products/create');

        $response->assertStatus(200);
    }

    public function testProductsStoreAndEdit()
    {
        $product = [
            'user_id' => $this->user->id,
            'details' => 'Some details',
            'status' => 'accepted'
        ];
        $response = $this->post('/admin/products', $product);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', $product);

        $response = $this->get('/admin/products/1/edit');
        $response->assertStatus(200);
    }

    public function testProductsUpdate()
    {
        $product = Product::factory()->create();

        $updatedProduct = [
            'user_id' => $this->user->id,
            'details' => 'Some details',
            'status' => 'cancelled'
        ];
        $response = $this->put('/admin/products/' . $product->id, $updatedProduct);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', $updatedProduct);

        $response = $this->get('/admin/products/'.$product->id.'/edit');
        $response->assertStatus(200);
    }

    public function testProductsDelete()
    {
        $product = Product::factory()->create();
        $this->delete('/admin/products/' . $product->id);

        $product = Product::withTrashed()->find($product->id);
        $this->assertNotNull($product->deleted_at);

        $response = $this->get('/admin/products/'.$product->id.'/edit');
        $response->assertStatus(404);
    }
}
