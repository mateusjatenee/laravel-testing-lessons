<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexReturnsAllProducts()
    {
        $products = factory(App\Product::class, 2)->create();

        $this->get('api/products')->seeStatusCode(200);

        foreach ($products as $product) {
            $this->seeJson(['name' => $product->name]);
        }
    }

    public function testStoreCreatesAProduct()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $this
            ->post('api/products', [
                'name' => 'Produto',
                'price' => 10,
            ])
            ->seeStatusCode(200)
            ->seeJson(['name' => 'Produto', 'price' => 10]);
    }

    public function testShowReturnsAnSpecificProduct()
    {
        $product = factory(App\Product::class)->create();

        $this
            ->get('api/products/' . $product->id)
            ->seeStatusCode(200)
            ->seeJson(['id' => $product->id, 'name' => $product->name]);
    }

    public function testAProductCanBeDeleted()
    {
        $product = factory(App\Product::class)->create();
        $user = User::find(1);

        $this
            ->actingAs($user)
            ->delete('api/products/1')
            ->seeStatusCode(204)
            ->isEmpty();

        $this->notSeeInDatabase('products', ['id' => 1]);
    }
}
