<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Http\Controllers\AdminCountriesController;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Yajra\DataTables\Facades\DataTables; // Assuming Yajra DataTables
use Illuminate\Http\JsonResponse;

class AdminCountriesControllerTest extends TestCase
{
    // Use Mockery integration trait
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    protected $countriesMock;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the Countries model
        $this->countriesMock = Mockery::mock('overload:App\Models\Countries');

        // Instantiate the controller
        $this->controller = new AdminCountriesController();
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Close Mockery expectations
        parent::tearDown();
    }

    /** @test */
    public function index_returns_view_with_countries()
    {
        // Arrange
        $mockCollection = new Collection([
            (object)['country_id' => 1, 'country_name' => 'USA', 'country_code' => 'US'],
            (object)['country_id' => 2, 'country_name' => 'Canada', 'country_code' => 'CA'],
        ]);

        // Mock the query chain
        $this->countriesMock->shouldReceive('orderBy')->with('country_name', 'asc')->andReturnSelf();
        $this->countriesMock->shouldReceive('groupBy')->with('country_code')->andReturnSelf();
        $this->countriesMock->shouldReceive('get')->andReturn($mockCollection);

        $request = Mockery::mock(Request::class);

        // Act
        $response = $this->controller->index($request);

        // Assert
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('admin.countries.countryList', $response->getName());
        $this->assertArrayHasKey('all_countries', $response->getData());
        $this->assertEquals($mockCollection, $response->getData()['all_countries']);
    }

    /** @test */
    public function country_returns_dashboard_view()
    {
        // Arrange
        $request = Mockery::mock(Request::class);

        // Act
        $response = $this->controller->country($request);

        // Assert
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('admin.country.dashboard', $response->getName());
    }

    /** @test */
    public function country_data_returns_datatables_json()
    {
        // Arrange
        $mockCollection = new Collection([
            (object)['country_id' => 1, 'country_name' => 'USA', 'country_code' => 'US'],
            (object)['country_id' => 2, 'country_name' => 'Canada', 'country_code' => 'CA'],
        ]);

        // Mock the query chain for the model
        $this->countriesMock->shouldReceive('orderBy')->with('country_name', 'asc')->andReturnSelf();
        $this->countriesMock->shouldReceive('groupBy')->with('country_code')->andReturnSelf();
        $this->countriesMock->shouldReceive('get')->andReturn($mockCollection);

        // Mock the DataTables facade/helper
        // We expect `of` to be called with our collection and `toJson` to return a JsonResponse
        DataTables::shouldReceive('of')
            ->once()
            ->with($mockCollection)
            ->andReturnSelf(); // Return the mocked DataTables instance
        DataTables::shouldReceive('toJson')
            ->once()
            ->andReturn(Mockery::mock(JsonResponse::class));


        $request = Mockery::mock(Request::class);

        // Act
        $response = $this->controller->countryData($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        // Further assertions could check the structure/content if needed,
        // but mocking toJson confirms DataTables was likely invoked correctly.
    }

    /** @test */
    public function createrecord_adds_country_successfully()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('isMethod')->with('post')->andReturn(true);
        $request->shouldReceive('post')->with('function')->andReturn('add-country');
        $request->shouldReceive('post')->with('country_code')->andReturn('DE');
        $request->shouldReceive('post')->with('country_name')->andReturn('Germany');
        $request->shouldReceive('post')->with('country_status')->andReturn('1');
        $request->shouldReceive('session')->andReturnSelf(); // Mock session chain
        $request->shouldReceive('flash')->once()->with('message', 'The country [Germany] was saved successfully');

        $newCountryMock = Mockery::mock(Countries::class);
        $newCountryMock->country_id = 5; // Simulate ID after save
        $newCountryMock->shouldReceive('setAttribute')->with('country_code', 'DE');
        $newCountryMock->shouldReceive('setAttribute')->with('country_name', 'Germany');
        $newCountryMock->shouldReceive('setAttribute')->with('country_status', '1');
        $newCountryMock->shouldReceive('save')->once()->andReturn(true);

        // Mock the static 'new' or constructor if needed, or just expect methods on the mock
        $this->countriesMock->shouldReceive('newInstance')->andReturn($newCountryMock); // More robust way

        // Act
        $response = $this->controller->createrecord($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        // Assuming you have a named route 'admin.countries'
        $this->assertTrue(str_contains($response->getTargetUrl(), route('admin.countries')));
    }

    /** @test */
    public function createrecord_edits_country_successfully()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('isMethod')->with('post')->andReturn(true);
        $request->shouldReceive('post')->with('function')->andReturn('edit-country');
        $request->shouldReceive('post')->with('country_id')->andReturn(10);
        $request->shouldReceive('post')->with('country_code')->andReturn('FR');
        $request->shouldReceive('post')->with('country_name')->andReturn('France');
        $request->shouldReceive('post')->with('country_status')->andReturn('1');
        $request->shouldReceive('session')->andReturnSelf();
        $request->shouldReceive('flash')->once()->with('message', 'The country [France] was updated successfully');

        $existingCountryMock = Mockery::mock(Countries::class);
        $existingCountryMock->country_id = 10;
        $existingCountryMock->shouldReceive('setAttribute')->with('country_code', 'FR');
        $existingCountryMock->shouldReceive('setAttribute')->with('country_name', 'France');
        $existingCountryMock->shouldReceive('setAttribute')->with('country_status', '1');
        $existingCountryMock->shouldReceive('save')->once()->andReturn(true);

        $this->countriesMock->shouldReceive('find')->once()->with(10)->andReturn($existingCountryMock);

        // Act
        $response = $this->controller->createrecord($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue(str_contains($response->getTargetUrl(), route('admin.countries')));
    }

     /** @test */
    public function createrecord_handles_invalid_function()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('isMethod')->with('post')->andReturn(true);
        $request->shouldReceive('post')->with('function')->andReturn('some-other-function');
        $request->shouldReceive('session')->andReturnSelf();
        $request->shouldReceive('flash')->once()->with('message', 'your action was not completed successfully');

        // Act
        $response = $this->controller->createrecord($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue(str_contains($response->getTargetUrl(), route('admin.countries')));
    }

    /** @test */
    public function createrecord_handles_non_post_request()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('isMethod')->with('post')->andReturn(false);
        // No flash should be called, no redirect expected directly from this path

        // Act
        $response = $this->controller->createrecord($request);

        // Assert
        $this->assertNull($response); // Or whatever the method returns implicitly
    }


    /** @test */
    public function update_updates_country_and_returns_id()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('post')->with('country_id')->andReturn(15);
        $request->shouldReceive('post')->with('country_code')->andReturn('JP');
        $request->shouldReceive('post')->with('country_name')->andReturn('Japan');
        $request->shouldReceive('post')->with('country_status')->andReturn('1');

        $existingCountryMock = Mockery::mock(Countries::class);
        $existingCountryMock->country_id = 15; // Set the ID property
        $existingCountryMock->shouldReceive('setAttribute')->with('country_code', 'JP');
        $existingCountryMock->shouldReceive('setAttribute')->with('country_name', 'Japan');
        $existingCountryMock->shouldReceive('setAttribute')->with('country_status', '1');
        $existingCountryMock->shouldReceive('save')->once()->andReturn(true);

        $this->countriesMock->shouldReceive('find')->once()->with(15)->andReturn($existingCountryMock);

        // Act
        $response = $this->controller->update($request);

        // Assert
        $this->assertEquals(15, $response);
    }

     /** @test */
    public function delete_deletes_country()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('post')->with('country_id')->andReturn(20);

        $existingCountryMock = Mockery::mock(Countries::class);
        $existingCountryMock->shouldReceive('delete')->once()->andReturn(true);

        $this->countriesMock->shouldReceive('find')->once()->with(20)->andReturn($existingCountryMock);

        // Act
        $this->controller->delete($request);

        // Assert (Mockery expectations handle the assertion)
        // No return value to check, just that mocks were called.
    }

    /** @test */
    public function delete_handles_country_not_found()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('post')->with('country_id')->andReturn(999); // Non-existent ID

        $this->countriesMock->shouldReceive('find')->once()->with(999)->andReturn(null);

        // Expect an error because the code tries to call delete() on null
        $this->expectException(\Error::class); // Or TypeError depending on PHP version

        // Act
        $this->controller->delete($request);

        // Assert (Exception is asserted)
    }
}
