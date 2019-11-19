INSERT INTO `service_livetv_channel` (`id`, `uuid`, `source_id`, `short_name`, `full_name`, `time_zone`, `primary_language`, `weight`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'14a2a6f3-bd0d-4ea7-ac0d-c3e237930bdc',17,'yle_tv1','Yle TV1','EEST','fi',1,'2016-07-01 09:14:42','2016-08-18 08:17:29',NULL),
	(2,'7fbee3b8-3c32-4e42-9b60-167f16eccd9e',33,'yle_tv2','Yle TV2','EEST','fi',2,'2016-07-01 09:14:43','2016-08-18 08:17:30',NULL),
	(3,'f453efda-f5c0-4165-b6c7-a4a2d27bb502',81,'yle_fem','Yle Fem','EEST','fi',3,'2016-07-01 09:14:43','2016-08-18 08:17:30',NULL),
	(4,'553467fe-2532-4226-99ab-0bd090e7cb28',113,'yle_teema','Yle Teema','EEST','fi',4,'2016-07-01 09:14:44','2016-08-18 08:17:31',NULL),
	(5,'3f794752-4624-402b-b4c4-deb643484753',155,'ava','AVA','EEST','fi',5,'2016-07-01 09:14:45','2016-08-18 08:17:32',NULL),
	(6,'0d0bb6ce-8cdf-4ea5-b7f6-106cb826e90b',49,'mtv3','MTV3','EEST','fi',6,'2016-07-01 09:14:45','2016-08-18 08:17:32',NULL),
	(7,'10e2c1c2-abe2-461b-a859-a7cfe3ff9d02',65,'nelonen','Nelonen','EEST','fi',7,'2016-07-01 09:14:46','2016-08-18 08:17:33',NULL),
	(8,'27993c8d-051d-4e28-8fba-d4f0cc49bd6e',97,'subtv','Sub','EEST','fi',8,'2016-07-01 09:14:46','2016-08-18 08:17:33',NULL),
	(9,'9e43e5c3-ebf5-4f16-9224-f2f95a7256ad',177,'liv','Liv','EEST','fi',9,'2016-07-01 09:14:47','2016-08-18 08:17:34',NULL),
	(10,'98945f2b-c2da-40aa-b83a-45e52781aea0',8193,'estradi','Estradi','EEST','fi',10,'2016-07-01 09:14:48','2016-08-18 08:17:34',NULL),
	(11,'6cc27404-e690-463b-a557-6159fd5d7835',451,'frii','Frii','EEST','fi',11,'2016-07-01 09:14:48','2016-08-18 08:17:35',NULL),
	(12,'a40558fd-5432-4fb5-a676-86baf13f2475',529,'fox','FOX','EEST','fi',12,'2016-07-01 09:14:49','2016-08-18 08:17:35',NULL),
	(13,'0705f1df-d679-43c3-8e92-9d1d0b1acc09',817,'iskelma_harju_pontinen','Iskelmä/Harju&Pöntinen','EEST','fi',13,'2016-07-01 09:14:50','2016-08-18 08:17:36',NULL),
	(14,'00daf6a0-779b-4b3d-bc77-1304ce433694',129,'jim','Jim','EEST','fi',14,'2016-07-01 09:14:50','2016-08-18 08:17:37',NULL),
	(15,'266fb2f4-8262-494c-8dee-0c2eaeb79c06',161,'tv5','TV5','EEST','fi',15,'2016-07-01 09:14:51','2016-08-18 08:17:38',NULL),
	(16,'ead33252-0d4b-4bf6-9121-f09dc76491e5',178,'kutonen','Kutonen','EEST','fi',16,'2016-07-01 09:14:51','2016-08-18 08:17:39',NULL);

INSERT INTO `service_livetv_show_type` (`id`, `type`)
VALUES
	(1, 'movie'),
	(2, 'series'),
	(3, 'other');
