<?php
namespace MultiTenant;

use Origin\Model\Entity;

/**
 * Multitenant Concern - sidestepping callbacks
 */
trait Tenantable
{
    /**
     * Runs a find query
     *
     * @param string $type  (first,all,count,list)
     * @param array $options  The options array can work with the following keys
     *   - conditions: an array of conditions to find by. e.g ['id'=>1234,'status !=>'=>'new]
     *   - fields: an array of fields to fetch for this model. e.g ['id','title','description']
     *   - joins: an array of join arrays e.g. table' => 'authors','alias' => 'authors', 'type' => 'LEFT' ,
     * 'conditions' => ['authors.id = articles.author_id']
     *   - order: the order to fetch e.g. ['title ASC'] or ['category','title ASC']
     *   - limit: the number of records to limit by
     *   - group: the field to group by e.g. ['category']
     *   - callbacks: default is true. Set to false to disable running callbacks such as beforeFind and afterFind
     *   - associated: an array of models to get data for e.g. ['Comment'] or ['Comment'=>['fields'=>['id','body']]]
     * @return \Origin\Model\Entity|\Origin\Model\Collection|array|int $resultSet
     */
    public function find(string $type = 'first', $options = [])
    {
        if (Tenant::initialized()) {
            $foreignKey = Tenant::foreignKey();
            $options['conditions'][$foreignKey] = Tenant::id();
        }
       
        return parent::find($type, $options);
    }

    /**
    * Save model data to database, it can save one level of associations.
    *
    * ## Options
    *
    * The options array can be passed with the following keys:
    *
    * - validate: wether to validate data or not
    * - callbacks: call the callbacks duing each stage.  You can also put only before or after
    * - transaction: wether to save through a database transaction (default:true)
    * - associated: default true. boolean or an array of associated data to save as well
    *
    * # Callbacks
    *
    * The following callbacks will called in this Model
    *
    * - beforeValidate
    * - afterValidate
    * - beforeSave
    * - beforeCreate/beforeCreate
    * - afterCreate/afterUpdate
    * - afterSave
    * - afterCommit/afterRollback
    *
    * @param entity $entity to save
    * @param array  $options keys (validate,callbacks,transaction,associated)
    * @return bool true or false
    */
    public function save(Entity $data, array $options = []) : bool
    {
        if (Tenant::initialized() and ! $data->exists()) {
            $foreignKey = Tenant::foreignKey();
            $data->$foreignKey = Tenant::id();
        }
  
        return parent::save($data);
    }
}
