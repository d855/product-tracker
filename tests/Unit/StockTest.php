<?php

namespace Tests\Unit;

use App\Clients\Client;
use App\Clients\ClientException;
use App\Clients\ClientFactory;
use App\Clients\ClientFactoryFacade;
use App\Clients\StockStatus;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_throws_an_exception_if_a_client_is_not_found_when_tracking()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Retailer::first()->update(['name' => 'Foo Retailer']);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }

    /** @test */
    function it_updates_local_stock_status_after_being_tracked()
    {
        $this->withoutExceptionHandling();
        $this->seed(RetailerWithProductSeeder::class);

        $clientMock = Mockery::mock(Client::class);
        $clientMock->shouldReceive('checkAvailability')->andReturn(new StockStatus(true, 9900));

        ClientFactoryFacade::shouldReceive('make')->andReturn($clientMock);

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);

    }
}
