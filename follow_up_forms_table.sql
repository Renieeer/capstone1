-- Follow-Up Forms Table (Existing Table Structure)
-- This table stores all follow-up form records submitted by counselors

-- If the table doesn't exist, create it
CREATE TABLE IF NOT EXISTS `follow_up` (
  `Follow_id` int NOT NULL AUTO_INCREMENT,
  `StudentID` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `CategoryID` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Title` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Counselor` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TimeCreated` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TimeUpdated` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Follow_id`),
  KEY `idx_followup_student` (`StudentID`),
  FOREIGN KEY (`StudentID`) REFERENCES `student_table` (`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
