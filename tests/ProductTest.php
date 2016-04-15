<?php

use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
{

    use DatabaseMigrations;

    public function testProductCanBeCreated()
    {
        $user = factory(App\User::class)->create();

        $product = $user->products()->create([
            'name' => 'Revista',
            'price' => 10,
        ]);

        $product_2 = $user->products()->create([
            'name' => 'Revista 2',
            'price' => 20,
        ]);

        $found_product = Product::all();

        $this->assertEquals($product_2->id, $found_product[1]->id);
    }
}
