<?php
namespace MultiTenant\Test\Fixture;

use Origin\TestSuite\Fixture;

class ProductFixture extends Fixture
{
    protected $schema = [
        'columns' => [
            'id' => ['type' => 'integer', 'limit' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'autoIncrement' => true],
            'user_id' => ['type'=>'integer','default'=>null],
            'name' => ['type' => 'string', 'limit' => 40, 'null' => false, 'default' => null],
            'description' => ['type' => 'text', 'null' => true, 'default' => null],
            'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
            'modified' => ['type' => 'datetime', 'null' => false, 'default' => null]
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'column' => 'id']
        ],
        'indexes' => [],
        'options' => ['engine' => 'InnoDB', 'autoIncrement'=>1000]
    ];
    
    protected $records = [
        [
            'user_id' => 1000,
            'name' => 'Widget #1',
            'description' => 'none',
            'created' => '2019-09-10 14:16:40',
            'modified' => '2019-09-10 14:24:02'
        ],
        [
            'user_id' => 1000,
            'name' => 'Widget #2',
            'description' => 'none',
            'created' => '2019-09-10 14:16:40',
            'modified' => '2019-09-10 14:24:02'
        ],
        [
            'user_id' => 1001,
            'name' => 'Widget #3',
            'description' => 'none',
            'created' => '2019-09-10 14:16:40',
            'modified' => '2019-09-10 14:24:02'
        ]
    ];
}
