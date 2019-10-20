<?php
namespace MultiTenant\Test;

use MultiTenant\Tenant;
use Origin\Model\Model;
use MultiTenant\Tenantable;
use Origin\TestSuite\OriginTestCase;

class Product extends Model
{
    use Tenantable;
}

/**
 * @property \App\Model\MultiTenant $MultiTenant
 */
class MultiTenantModelTest extends OriginTestCase
{
    protected $fixtures = ['MultiTenant.User','MultiTenant.Product'];

    protected function startup() : void
    {
        $this->loadModel('Product', [
            'className' => Product::class
        ]);
    }

    public function testFind()
    {
        $results = $this->Product->find('all');
        $this->assertEquals(3, count($results));

        Tenant::initialize(1000, [
            'foreignKey' => 'user_id'
        ]);

        $results = $this->Product->find('all');
        $this->assertEquals(2, count($results));

        Tenant::initialize(1001, [
            'foreignKey' => 'user_id'
        ]);
        $results = $this->Product->find('all');
        $this->assertEquals(1, count($results));
    }

    public function testDelete()
    {
        Tenant::initialize(1000, [
            'foreignKey' => 'user_id'
        ]);

        $product = $this->Product->new(['id' => 1002]);
        $this->assertFalse($this->Product->delete($product));

        $product = $this->Product->new(['id' => 1001]);
        $this->assertTrue($this->Product->delete($product));

        Tenant::initialize(1001, [
            'foreignKey' => 'user_id'
        ]);

        $product = $this->Product->new(['id' => 1002]);
        $this->assertTrue($this->Product->delete($product));
    }
}
