<?php

$installer = $this;
$installer->startSetup();
$installer->run("
    CREATE TABLE `{$installer->getTable('bystritsky_action/action')}` (
      `id` int(11) NOT NULL auto_increment,
      `name` text NOT NULL,
      `is_active` int NOT NULL,
      `description` text NOT NULL,
      `short description` text NOT NULL,
      `image` text,
      `create_datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
      `start_datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
      `end_datetime` timestamp,
      PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    INSERT INTO `{$installer->getTable('bystritsky_action/action')}` (`id`, `name`, `is_active`, `description`, `short description`, `image`, `create_datetime`, `start_datetime`, `end_datetime`) VALUES
(1, 'Длинная акция', 1, 'Это очень длинная акция. Она началась давно и продлится ещё долго.', 'Это очень длинная акция.', 'http://cdn.iwillteachyoutoberich.com/wp-content/uploads/2008/11/generic-candy.jpg', '2016-10-11 09:43:05', '2016-09-05 21:00:00', '2017-07-13 21:00:00'),
(2, 'Прошедшая акция', 1, 'Эта акция уже прошла. Да.', 'Эта акция уже прошла.', 'http://www.savingadvice.com/articles/wp-content/uploads/2012/04/generic.jpg', '2016-10-11 09:43:05', '2016-10-01 21:00:00', '2016-10-03 21:00:00'),
(3, 'Бесконечная акция', 1, 'Есть у акции начало, нет у акции конца.', 'Есть начало, нет конца.', 'http://blogs-images.forbes.com/peterubel/files/2015/03/Millions-to-Be-Made-on-Generic-Drugs.jpg', '2016-10-01 21:00:00', '2016-10-01 21:00:00', NULL),
(4, 'Крайне длинная акция', 1, 'Это ещё одня очень длинная акция. Она началась очень давно и продлится ещё очень долго.', 'Ещё одна очень длинная акция.', 'http://s3.amazonaws.com/37assets/svn/generic-brands.jpg', '2010-10-11 09:43:05', '2010-09-05 00:00:00', '2020-07-13 00:00:00'),
(5, 'Короткая акция', 1, 'Не такая уж она и короткая на самом деле.', 'Не такая уж она и короткая', 'https://cdn.gobankingrates.com/wp-content/uploads/2014/11/generic-vs-brand.jpg', '2016-10-11 09:43:05', '2016-10-01 00:00:00', '2017-01-01 22:35:00'),
(6, 'Будущая акция', 1, 'Это будущая акция, она начнётся ещё не скоро', 'Это будущая акция', 'https://i.ytimg.com/vi/2YBtspm8j8M/maxresdefault.jpg', '2016-10-11 09:43:05', '2020-01-01 00:00:00', NULL);
");
$installer->endSetup();