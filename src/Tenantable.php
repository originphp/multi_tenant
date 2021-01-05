<?php
/**
 * OriginPHP Framework
 * Copyright 2018 - 2021 Jamiel Sharief.
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

use ArrayObject;
use Origin\Model\Entity;

/**
 * Multi-tenant Concern
 */
trait Tenantable
{
    /**
     * Register callbacks
     *
     * @return void
     */
    protected function initializeTenantable(): void
    {
        $this->beforeFind('tenantBeforeFind');
        $this->beforeCreate('tenantBeforeCreate');
        $this->beforeDelete('tenantBeforeDelete');
    }

    /**
     * Adds the TenantId to the find conditions
     *
     * @param ArrayObject $options
     * @return void
     */
    protected function tenantBeforeFind(ArrayObject $options): void
    {
        if (Tenant::initialized()) {
            $foreignKey = Tenant::foreignKey();
            $options['conditions'][$foreignKey] = Tenant::id();
        }
    }

    /**
     * Adds the TenantId to new records before they are saved
     *
     * @param \Origin\Model\Entity $data
     * @param ArrayObject $options
     * @return void
     */
    protected function tenantBeforeCreate(Entity $data, ArrayObject $options): void
    {
        if (Tenant::initialized()) {
            $foreignKey = Tenant::foreignKey();
            $data->$foreignKey = Tenant::id();
        }
    }

    /**
     * Checks the foreign key that is being deleted
     *
     * @param \Origin\Model\Entity $data
     * @param ArrayObject $options
     * @return bool
     */
    protected function tenantBeforeDelete(Entity $data, ArrayObject $options): bool
    {
        if (Tenant::initialized()) {
            $foreignKey = Tenant::foreignKey();

            return $data->$foreignKey === Tenant::id();
        }

        return true;
    }
}
