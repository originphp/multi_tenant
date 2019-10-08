<?php
namespace MultiTenant\Test\Fixture;

use Origin\TestSuite\Fixture;

class UserFixture extends Fixture
{
    protected $schema = [
        'columns' => [
            'id' => ['type' => 'integer', 'limit' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'autoIncrement' => true],
            'first_name' => ['type' => 'string', 'limit' => 40, 'null' => false, 'default' => null],
            'last_name' => ['type' => 'string', 'limit' => 80, 'null' => false, 'default' => null],
            'email' => ['type' => 'string', 'limit' => 255, 'null' => true, 'default' => null],
            'password' => ['type' => 'string', 'limit' => 255, 'null' => false, 'default' => null],
            'description' => ['type' => 'text', 'null' => true, 'default' => null],
            'token' => ['type' => 'text', 'null' => false, 'default' => null],
            'verified' => ['type' => 'datetime', 'null' => true, 'default' => null],
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
            'first_name' => 'Jon',
            'last_name' => 'Snow',
            'email' => 'jon.snow@originphp.com',
            'password' => '$2y$10$nCMxYLvcvbXFnsBDFP5WpOky3bz.EDgo54VR0Tg9cpave3ZETT/di', // 123456
            'token' => '3905604a-b14d-4fe8-906e-7867b39289b3',
            'description' => null,
            'verified' => '2019-09-10 14:17:13',
            'created' => '2019-09-10 14:16:40',
            'modified' => '2019-09-10 14:24:02'
        ]
    ];
}
