-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: blog
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary view structure for view `view_users`
--

DROP TABLE IF EXISTS `view_users`;
/*!50001 DROP VIEW IF EXISTS `view_users`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_users` AS SELECT 
 1 AS `user_id`,
 1 AS `full_name`,
 1 AS `email`,
 1 AS `username`,
 1 AS `password`,
 1 AS `registered_at`,
 1 AS `status_id`,
 1 AS `is_logged`,
 1 AS `logged_in`,
 1 AS `logged_out`,
 1 AS `total_posts`,
 1 AS `star_rating`,
 1 AS `address_id`,
 1 AS `full_address`,
 1 AS `image_name`,
 1 AS `src_path`,
 1 AS `root_path`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_users`
--

/*!50001 DROP VIEW IF EXISTS `view_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_users` AS select `u`.`user_id` AS `user_id`,concat_ws(' ',`u`.`first_name`,`u`.`last_name`) AS `full_name`,`u`.`email` AS `email`,`u`.`username` AS `username`,`u`.`password` AS `password`,`u`.`registered_at` AS `registered_at`,`us`.`status_id` AS `status_id`,`us`.`is_logged` AS `is_logged`,`us`.`logged_in` AS `logged_in`,`us`.`logged_out` AS `logged_out`,`us`.`total_posts` AS `total_posts`,`us`.`star_rating` AS `star_rating`,`a`.`address_id` AS `address_id`,concat(`c`.`name`,' ',`a`.`city`,'(',`a`.`zip_code`,')',`a`.`address_line`) AS `full_address`,`pi`.`name` AS `image_name`,`pi`.`src_path` AS `src_path`,`pi`.`root_path` AS `root_path` from ((((`users` `u` join `user_status` `us` on((`u`.`user_id` = `us`.`user_id`))) left join `address` `a` on((`u`.`address_id` = `a`.`address_id`))) left join `countries` `c` on((`a`.`country_id` = `c`.`country_id`))) left join `profile_images` `pi` on((`u`.`image_id` = `pi`.`image_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Dumping events for database 'blog'
--

--
-- Dumping routines for database 'blog'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-24 13:49:19
