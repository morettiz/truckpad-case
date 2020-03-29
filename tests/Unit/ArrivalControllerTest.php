<?php

namespace Tests\Unit;

use App\Http\Controllers\ArrivalController;
use App\Http\Requests\ArrivalFormRequest;
use App\Model\Arrival;
use App\Model\Truck;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArrivalControllerTest extends TestCase
{
    use RefreshDatabase;

    private $arrivalController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->arrivalController = new ArrivalController();
    }

    public function testIndexArrivals()
    {
        $truck = factory(Truck::class)->create();

        factory(Arrival::class, 20)->create(['truck_id' => $truck->code]);

        $total = Arrival::query()->count();

        $response = $this->arrivalController->index();

        $trucks = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->status());

        $this->assertCount($total, $trucks);
    }

    public function testGetArrivalById()
    {
        $truck = factory(Truck::class)->create();

        $arrival = factory(Arrival::class)->create(['truck_id' => $truck->code]);

        $response = $this->arrivalController->get($arrival->id);

        $truck = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->status());

        $this->assertEquals($arrival->id, $truck['id']);
    }

    public function testGetArrivalByWrongId()
    {
        $wrongId = 1;

        $this->expectException(ModelNotFoundException::class);

        $this->arrivalController->get($wrongId);
    }

    public function testUpdateArrival()
    {
        $truck = factory(Truck::class)->create();

        $arrival = factory(Arrival::class)->create(['truck_id' => $truck->code]);

        $request = new ArrivalFormRequest(['drivers_name' => 'Antonio Fagundes']);

        $this->arrivalController->update($arrival->id, $request);

        $newInstance = Arrival::find($arrival->id);

        $this->assertNotEquals($newInstance->drivers_name, $arrival->drivers_name);
    }

    public function testUpdateArrivalWrongId()
    {
        $wrongId = 999999;

        $attributes = factory(Arrival::class)->make()->toArray();

        $request = new ArrivalFormRequest($attributes);

        $this->expectException(ModelNotFoundException::class);

        $this->arrivalController->update($wrongId, $request);
    }

    public function testStoreShouldSucceed()
    {
        $truck = factory(Truck::class)->create();

        $attributes = factory(Arrival::class)->make(['truck_id' => $truck->code])->toArray();

        $attributes['birth_date'] = Carbon::parse($attributes['birth_date'])->format('Y-m-d');

        $request = new ArrivalFormRequest($attributes);

        $response = $this->arrivalController->store($request);

        $this->assertEquals(200, $response->status());

        $arrival = json_decode($response->getContent(), true);

        $arrival = Arrival::find($arrival['id']);

        $this->assertInstanceOf(Arrival::class, $arrival);
    }
}
