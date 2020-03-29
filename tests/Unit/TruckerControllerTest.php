<?php

namespace Tests\Unit;

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\TruckerController;
use App\Http\Requests\ArrivalFormRequest;
use App\Model\Arrival;
use App\Model\Truck;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TruckerControllerTest extends TestCase
{
    use RefreshDatabase;

    private $truckerController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->truckerController = new TruckerController();
    }

    public function testGetUnloadedTrucks()
    {
        $truck = factory(Truck::class)->create();

        factory(Arrival::class, 10)->create(['is_truck_loaded' => true, 'truck_id' => $truck->code]);
        factory(Arrival::class, 10)->create(['is_truck_loaded' => false, 'truck_id' => $truck->code]);

        $response = $this->truckerController->getUnloadedTrucks();

        $trucks = json_decode($response->getContent(), true)['data'];

        $total = Arrival::all()->count();

        $this->assertEquals(200, $response->status());
        $this->assertCount(10, $trucks);
        $this->assertNotEquals(count($trucks), $total);
    }

    public function testGetTruckOwners()
    {
        $truck = factory(Truck::class)->create();

        factory(Arrival::class, 10)->create(['is_vehicle_owner' => true, 'truck_id' => $truck->code]);
        factory(Arrival::class, 10)->create(['is_vehicle_owner' => false, 'truck_id' => $truck->code]);

        $response = $this->truckerController->getTruckOwners();

        $trucks = json_decode($response->getContent(), true)['data'];

        $total = Arrival::all()->count();

        $this->assertEquals(200, $response->status());
        $this->assertCount(10, $trucks);
        $this->assertNotEquals(count($trucks), $total);
    }

    public function testGetLoadedTrucksByDay()
    {
        $truck = factory(Truck::class)->create();

        factory(Arrival::class, 10)->create([
            'is_truck_loaded' => true,
            'truck_id' => $truck->code,
            'created_at' => Carbon::now(),
        ]);

        factory(Arrival::class, 10)->create([
            'is_truck_loaded' => false,
            'truck_id' => $truck->code,
            'created_at' => Carbon::now(),
        ]);

        $response = $this->truckerController->getLoadedTrucks(new ArrivalFormRequest());

        $trucks = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(10, $trucks['LOADED_TRUCKS_DURING_DAY']['total']);
    }

    public function testGetLoadedTrucksByWeek()
    {
        $truck = factory(Truck::class)->create();

        factory(Arrival::class, 10)->create([
            'is_truck_loaded' => true,
            'truck_id' => $truck->code,
            'created_at' => Carbon::now()->subDays(5),
        ]);

        factory(Arrival::class, 10)->create([
            'is_truck_loaded' => false,
            'truck_id' => $truck->code,
            'created_at' => Carbon::now()->subDays(5),
        ]);

        $response = $this->truckerController->getLoadedTrucks(new ArrivalFormRequest());

        $trucks = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(10, $trucks['LOADED_TRUCKS_DURING_WEEK']['total']);
    }

    public function testGetLoadedTrucksByMonth()
    {
        $truck = factory(Truck::class)->create();

        factory(Arrival::class, 20)->create([
            'is_truck_loaded' => true,
            'truck_id' => $truck->code,
            'created_at' => Carbon::now()->subDays(20),
        ]);

        factory(Arrival::class, 25)->create([
            'is_truck_loaded' => false,
            'truck_id' => $truck->code,
            'created_at' => Carbon::now()->subDays(25),
        ]);

        $response = $this->truckerController->getLoadedTrucks(new ArrivalFormRequest());

        $trucks = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(20, $trucks['LOADED_TRUCKS_DURING_MONTH']['total']);
    }

    public function testTotalTrucksRoutesGroupedByTruckType()
    {
        factory(Truck::class)->create(['code' => 1]);
        factory(Truck::class)->create(['code' => 2]);
        factory(Truck::class)->create(['code' => 3]);
        factory(Truck::class)->create(['code' => 4]);
        factory(Truck::class)->create(['code' => 5]);

        factory(Arrival::class, 200)->create();

        $total = Arrival::query()->count();

        $response = $this->truckerController->getRoutesGroupedByTruckType();

        $trucks = json_decode($response->getContent(), true);

        $count = 0;
        foreach ($trucks as $truck) {
            $count += $truck['total'];
        }

        $this->assertEquals($total, $count);
    }
}
