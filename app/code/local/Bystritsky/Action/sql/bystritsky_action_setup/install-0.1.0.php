<?php

$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('bystritsky_action/action');
$installer->getConnection()->dropTable($tableName);

// @var $table Varien_Db_Ddl_Table
$table = $installer->getConnection()->newTable($tableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ])
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => false
    ])
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, [
        'nullable' => false
    ])
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
        'nullable' => false
    ])
    ->addColumn('short_description', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => false
    ])
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => true
    ])
    ->addColumn('create_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ])
    ->addColumn('start_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ])
    ->addColumn('end_datetime', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => true
    ]);

$installer->getConnection()->createTable($table);

/*

    INSERT INTO `$table` (`id`, `name`, `is_active`, `description`, `short_description`, `image`, `create_datetime`, `start_datetime`, `end_datetime`) VALUES
(1, 'Длинная акция', 1, 'Это очень длинная акция. Она началась давно и продлится ещё долго.', 'Это очень длинная акция.', NULL, '2016-10-11 09:43:05', '2016-09-05 21:00:00', '2017-07-13 21:00:00'),
(2, 'Прошедшая акция', 1, 'Эта акция уже прошла. Да.', 'Эта акция уже прошла.', NULL, '2016-10-11 09:42:00', '2016-10-01 21:00:00', '2016-10-03 21:00:00'),
(3, 'Бесконечная акция', 1, 'Есть у акции начало, нет у акции конца.', 'Есть начало, нет конца.', NULL, '2016-10-01 21:00:00', '2016-10-01 21:00:00', NULL),
(4, 'Крайне длинная акция', 1, 'Это ещё одня очень длинная акция. Она началась очень давно и продлится ещё очень долго.', 'Ещё одна очень длинная акция.', NULL, '2010-10-11 09:43:05', '2010-09-05 00:00:00', '2020-07-13 00:00:00'),
(5, 'Короткая акция', 1, 'Не такая уж она и короткая на самом деле.', 'Не такая уж она и короткая', NULL, '2016-10-11 09:43:05', '2016-10-01 00:00:00', '2017-01-01 22:35:00'),
(6, 'Будущая акция', 1, 'Это будущая акция, она начнётся ещё не скоро', 'Это будущая акция', NULL, '2016-10-11 09:43:05', '2020-01-01 00:00:00', NULL),
(7, 'Lorem', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias aliquid animi blanditiis dignissimos doloremque doloribus ducimus earum eligendi esse expedita, explicabo fugit harum iste laudantium libero maxime non perspiciatis possimus quasi recusandae sed tempore temporibus veritatis voluptatibus. A ab accusantium aliquam amet architecto asperiores aspernatur commodi consectetur distinctio doloremque dolores dolorum ducimus eum facere labore laboriosam minima minus nam odio optio pariatur perspiciatis, placeat provident quae quam quia quo sed similique sint suscipit totam ullam vel voluptas voluptatem, voluptates voluptatibus, voluptatum. Amet aperiam at consectetur cum delectus, deserunt ducimus, ea esse et eveniet facere fugit laudantium libero magni minima modi, nisi officia officiis optio quas quis reiciendis saepe totam ut vel? Ad dolor eveniet illum iste neque nobis pariatur porro quis suscipit voluptatum. Aliquid aperiam, cum exercitationem ipsum labore maiores molestiae provident rem vero voluptate. Aliquam fugit hic incidunt laborum laudantium maxime odio pariatur perspiciatis vel vero? Ab adipisci cumque cupiditate dolorum, ducimus eius et hic laborum minima molestiae nemo placeat porro, quaerat quam quidem quis quod sint vel. Aliquam aliquid aspernatur atque blanditiis commodi cumque ducimus eius eligendi et eum excepturi harum, hic illo in ipsa, labore minima nam non obcaecati porro quae quaerat quam quia quo rem repellendus saepe sapiente similique tempore tenetur, ut velit vero voluptatum! Dignissimos eum quisquam recusandae velit! Dolor doloremque doloribus ea fugit hic impedit, ipsa, laborum, minima nemo nihil nisi possimus qui quis sed sunt temporibus ut? Architecto aspernatur beatae dignissimos est fugiat molestias, mollitia nulla sint? Architecto deserunt distinctio enim explicabo numquam, omnis optio perspiciatis repellendus sunt tenetur? Accusamus alias aliquid autem eaque illum inventore ipsa minima natus nesciunt possimus quae quis quisquam ratione, recusandae repudiandae totam unde. Aspernatur consequuntur dignissimos facere fuga iste modi numquam similique unde velit. Alias consequuntur culpa itaque nam, provident rem. Magnam nam omnis pariatur? Animi asperiores dolores molestiae optio! Alias architecto debitis libero quibusdam reiciendis. Alias commodi cum fuga modi neque repudiandae sed! Alias aperiam consequuntur deleniti deserunt, doloribus error exercitationem facilis fuga iusto laboriosam molestias nihil optio porro quae quasi quia recusandae repellendus sed velit voluptates! A alias assumenda, corporis ducimus ipsa iusto laboriosam, magnam mollitia natus non numquam pariatur perferendis quidem sapiente sed sint, sunt veniam voluptas. Ab accusamus adipisci aperiam cum debitis delectus dicta dolor dolorum eaque eligendi est explicabo facere fuga incidunt iste libero magnam necessitatibus nemo nihil non numquam obcaecati odit officia officiis optio pariatur, quas quis reiciendis repellat sequi tempora, tempore ut velit veniam veritatis voluptas voluptates! Adipisci architecto blanditiis dolores ducimus eos est id in, maxime mollitia neque, odit quam quos tenetur ullam, vitae. Accusantium aut cum incidunt magni maxime porro tempora voluptate. A animi deleniti dignissimos dolores esse facere iure nulla, optio tempora voluptatem. Corporis dignissimos maxime tempora vitae. Alias aliquid dolore dolores doloribus fuga minima quam soluta? Dolores eos quasi quia sint! Accusamus consectetur, eos error excepturi expedita labore neque reprehenderit velit! Ab ad consectetur consequatur hic nihil perferendis similique, voluptas? A accusamus hic magni repellendus sed velit veritatis? Adipisci animi cum distinctio ratione soluta voluptatum.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet asperiores beatae cum deserunt distinctio dolorum ducimus enim fugiat fugit hic, incidunt magnam modi molestias mollitia nam necessitatibus officiis provident quasi quisquam, repellendus rerum sapiente sed sit, suscipit tempora veritatis voluptatem. A cupiditate distinctio est magni molestias nulla obcaecati sunt voluptate!', NULL, '2016-02-01 00:00:00', '2016-02-01 00:00:00', '2017-01-01 00:00:00'),
(8, 'Неактивная акция', 0, 'Это неактивная акция. Её можно сдалать активной, выставив соответсвующее значение полю is_active в админ. панели', 'Это неактивная акция', NULL, '2016-10-10 00:00:00', '2016-10-10 00:00:00', '2017-10-10 00:00:00')
;
*/

$installer->endSetup();
