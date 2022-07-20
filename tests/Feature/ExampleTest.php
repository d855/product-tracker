<?php

    namespace Tests\Feature;

    // use Illuminate\Foundation\Testing\RefreshDatabase;
    use App\Models\Product;
    use App\Models\Retailer;
    use App\Models\Stock;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class ExampleTest extends TestCase
    {

        use RefreshDatabase;

        /** @test */
        function it_checks_stock_for_products_at_retailers()
        {
            $switch = Product::create(['name' => 'Nintendo Switch']);

            $bestBuy = Retailer::create(['name' => 'Best Buy']);

            $this->assertFalse($switch->inStock());
            //        $bestBuy->haveStock($switch);

            $stock = new Stock([
                'price' => 1000,
                'url' => 'https://something.com',
                'sku' => '123',
                'in_stock' => true,
            ]);

            $bestBuy->addStock($switch, $stock);
            $this->assertTrue($switch->inStock());

        }

    }
