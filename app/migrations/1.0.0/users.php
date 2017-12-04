<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UsersMigration_100
 */
class UsersMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('users', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'email',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'email'
                        ]
                    ),
                    new Column(
                        'mustChangePassword',
                        [
                            'type' => Column::TYPE_BOOLEAN,
                            'size' => 1,
                            'after' => 'password'
                        ]
                    ),
                    new Column(
                        'profilesId',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 10,
                            'after' => 'mustChangePassword'
                        ]
                    ),
                    new Column(
                        'banned',
                        [
                            'type' => Column::TYPE_BOOLEAN,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'profilesId'
                        ]
                    ),
                    new Column(
                        'suspended',
                        [
                            'type' => Column::TYPE_BOOLEAN,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'banned'
                        ]
                    ),
                    new Column(
                        'active',
                        [
                            'type' => Column::TYPE_BOOLEAN,
                            'size' => 1,
                            'after' => 'suspended'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('profilesId', ['profilesId'], null)
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '1',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
