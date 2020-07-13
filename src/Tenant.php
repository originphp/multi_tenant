<?php
/**
 * OriginPHP Framework
 * Copyright 2018 - 2020 Jamiel Sharief.
 *
 * Licensed under The MIT License
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * @copyright   Copyright (c) Jamiel Sharief
 * @link        https://www.originphp.com
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
declare(strict_types = 1);
namespace MultiTenant;

use Origin\Core\Exception\InvalidArgumentException;

/**
 * This is the Tenant Manager to use
 *
 *  Tenant::initialize($userId, [
 *    'foreignKey' => 'user_id'
 *   ]);
 */
class Tenant
{
    /**
     * Holds the tenant Id
     *
     * @var int|string
     */
    private static $id = null;

    /**
     * ForeignKey
     * e.g. tenant_id, user_id
     *
     * @var string
     */
    private static $foreignKey = null;

    /**
     * Initializes the Tenant
     *
     * @param int|string $id id or uuid or even domain
     * @param array $options The following option keys are supported
     *   - foreignKey: default tenant_id, can be user_id, or domain as well
     * @return void
     */
    public static function initialize($id, array $options = []) : void
    {
        $options += ['foreignKey' => 'tenant_id'];

        if (! is_integer($id) && ! is_string($id)) {
            throw new InvalidArgumentException('Invalid Tenant ID');
        }
      
        static::$id = $id;
        static::$foreignKey = $options['foreignKey'];
    }

    /**
     * Gets the TenantId
     *
     * @return int|string
     */
    public static function id()
    {
        return static::$id;
    }

    /**
     * Gets the foreign key
     *
     * @return string
     */
    public static function foreignKey() : string
    {
        return static::$foreignKey;
    }

    /**
     * Checks if this was initialized
     *
     * @return bool
     */
    public static function initialized() : bool
    {
        return ! empty(static::$id);
    }
}
