<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Users\Customer;
use App\Models\Users\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_with_supplier_role_returns_supplier_instance()
    {
        $authUser = Supplier::factory()->createSupplierWithRole();
        $expectedSupplier = Supplier::find(1);

        $this->assertInstanceOf(Supplier::class, $authUser->roleInstance);
        $this->assertTrue($authUser->roleInstance->is($expectedSupplier));
    }

    public function test_user_with_customer_role_returns_customer_instance()
    {
        $authUser = Customer::factory()->createCustomerWithRole();
        $expectedCustomer = Customer::find(1);

        $this->assertInstanceOf(Customer::class, $authUser->roleInstance);
        $this->assertTrue($authUser->roleInstance->is($expectedCustomer));
    }
}
