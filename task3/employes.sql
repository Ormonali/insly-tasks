-- Table structure for employes
CREATE TABLE IF NOT EXISTS `employes` (
   `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
   `name` varchar(20) DEFAULT NULL, 
   `birth_date` date NOT NULL,
   `ssn` varchar(50) NOT NULL, 
   `is_a_current_employee` tinyint(1) DEFAULT NULL,
   `email` varchar(50) NOT NULL, 
   `phone_number` varchar(20) DEFAULT NULL, 
   `address` varchar(50) NOT NULL, 
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for translation languages

CREATE TABLE IF NOT EXISTS `languages` (
   `code` char(2) NOT NULL UNIQUE,
   `name` varchar(20) NOT NULL,
   PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for translation

CREATE TABLE IF NOT EXISTS `employee_translation` (
   `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
   `employee_id` int(11) NOT NULL,
   `language_code` char(2) NOT NULL,
   `introduction` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
   `previos_work_experience` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
   `education_information` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`employee_id`) REFERENCES `employes` (`id`) ON DELETE CASCADE,
   FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for log

CREATE TABLE IF NOT EXISTS `log` (
   `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
   `employee_id` int(11) NOT NULL DEFAULT '0',
   `username` varchar(20) NOT NULL,
   `created_at` datetime NOT NULL,
   `last_username` varchar(2) DEFAULT NULL,
   `updated_at` datetime DEFAULT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`employee_id`) REFERENCES `employes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Test data
INSERT INTO `languages` (`code`, `name`) VALUES ('en', 'English'), ('sp', 'Spanish'), ('fr', 'French');
INSERT INTO `employes` (`id`, `name`, `birth_date`, `ssn`, `is_a_current_employee`, `email`, `phone_number`, `address`) VALUES ('1','Ormonali', '2000-02-06', '453-3432-123', '1', 'kaarov8@gmail.com', '+996772405055', 'Kyrgyzstan, Bishkek');
INSERT INTO `employee_translation` (`employee_id`, `language_code`, `introduction`, `previos_work_experience`, `education_information`) VALUES ('1', 'en', 'i am a php developer', 'worked at MOORE studio', 'International University of Kyrgyzstan');
INSERT INTO `employee_translation` (`employee_id`, `language_code`, `introduction`, `previos_work_experience`, `education_information`) VALUES ('1', 'sp', 'Soy desarrollador de php', 'trabajó en MOORE studio', 'Universidad Internacional de Kirguistán');
INSERT INTO `employee_translation` (`employee_id`, `language_code`, `introduction`, `previos_work_experience`, `education_information`) VALUES ('1', 'fr', 'je suis un développeur php', 'travaillé à MOORE studio', 'Université internationale du Kirghizistan');

-- Example query to get 1-person data in all languages
SELECT * FROM `employes` LEFT JOIN employee_translation ON employee_translation.employee_id=1;