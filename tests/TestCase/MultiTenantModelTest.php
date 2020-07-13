<?php
namespace MultiTenant\Test;

use MultiTenant\Tenant;
use Origin\Model\Model;
use MultiTenant\Tenantable;
use Origin\TestSuite\OriginTestCase;
use Origin\Model\Concern\Timestampable;

class Product extends Model
{
    use Tenantable, Timestampable;
}

/**
 * @property \App\Model\MultiTenant $MultiTenant
 */
class MultiTenantModelTest extends OriginTestCase
{
    protected $fixtures = ['MultiTenant.User','MultiTenant.Product'];

    protected function setUp(): void
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

    public function testCreateRecord()
    {
        Tenant::initialize(1000, [
            'foreignKey' => 'user_id'
        ]);
        $product = $this->Product->new(['name' => 'foo','description' => 'none']);
        $this->assertTrue($this->Product->save($product));
        $this->assertEquals(1000, $product->user_id);
    }

    /**
     * @depends testCreateRecord
     */
    public function testDelete()
    {
        Tenant::initialize(1000, [
            'foreignKey' => 'user_id'
        ]);

        // test Delete with user_id
        $product = $this->Product->new(['name' => 'foo','description' => 'none']);
        $this->assertTrue($this->Product->save($product));
        $this->assertTrue($this->Product->delete($product));
    }

    public function testDeleteOtherTenant()
    {
        Tenant::initialize(1000, [
            'foreignKey' => 'user_id'
        ]);

        // test Delete record with different user_id
        $product = $this->Product->get(1000);
        $product->user_id = 12345;
        $this->assertFalse($this->Product->delete($product));
    }
}
