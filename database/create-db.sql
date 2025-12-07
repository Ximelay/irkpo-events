-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE =
    'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema irkpo_events
--
-- База данных для системы регистрации мероприятий колледжа ИРКПО
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `irkpo_events` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `irkpo_events`;

-- -----------------------------------------------------
-- Table `irkpo_events`.`admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`admins`
(
    `adminID`          INT          NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор администратора',
    `admin_firstName`  VARCHAR(50)  NOT NULL COMMENT 'Имя администратора',
    `admin_lastName`   VARCHAR(50)  NOT NULL COMMENT 'Фамилия администратора',
    `admin_middleName` VARCHAR(50)  NULL     DEFAULT NULL COMMENT 'Отчество администратора',
    `admin_email`      VARCHAR(100) NOT NULL COMMENT 'Электронная почта администратора',
    `admin_password`   VARCHAR(100) NOT NULL COMMENT 'Пароль администратора',
    `admin_isActive`   TINYINT      NOT NULL DEFAULT '1' COMMENT 'Активен ли пользователь (1 - Active)',
    `remember_token`   VARCHAR(100) NULL     DEFAULT NULL,
    PRIMARY KEY (`adminID`),
    UNIQUE INDEX `admin_email_UNIQUE` (`admin_email` ASC) VISIBLE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица администраторов информационной системы (воспитальный отдел)';


-- -----------------------------------------------------
-- Table `irkpo_events`.`cache`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`cache`
(
    `key`        VARCHAR(255) NOT NULL,
    `value`      MEDIUMTEXT   NOT NULL,
    `expiration` INT          NOT NULL,
    PRIMARY KEY (`key`)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `irkpo_events`.`cache_locks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`cache_locks`
(
    `key`        VARCHAR(255) NOT NULL,
    `owner`      VARCHAR(255) NOT NULL,
    `expiration` INT          NOT NULL,
    PRIMARY KEY (`key`)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `irkpo_events`.`faculties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`faculties`
(
    `facultyID`   INT          NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор отделения',
    `facultyName` VARCHAR(100) NOT NULL COMMENT 'Наименование отделения',
    `facultyHead` VARCHAR(150) NOT NULL,
    PRIMARY KEY (`facultyID`),
    UNIQUE INDEX `facultyName_UNIQUE` (`facultyName` ASC) VISIBLE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица отделений';


-- -----------------------------------------------------
-- Table `irkpo_events`.`specialties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`specialties`
(
    `specialityID`        INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор специальности',
    `specialityName`      VARCHAR(50) NOT NULL COMMENT 'Наименование специальности.',
    `specialityCode`      VARCHAR(50) NOT NULL COMMENT 'Код специальности (допустим 09.02.07)',
    `faculties_facultyID` INT         NOT NULL COMMENT 'Связь отделения и его специальностей',
    PRIMARY KEY (`specialityID`),
    UNIQUE INDEX `SpecialityCode_UNIQUE` (`specialityCode` ASC) VISIBLE,
    INDEX `fk_Specialties_faculties1_idx` (`faculties_facultyID` ASC) VISIBLE,
    CONSTRAINT `fk_Specialties_faculties1`
        FOREIGN KEY (`faculties_facultyID`)
            REFERENCES `irkpo_events`.`faculties` (`facultyID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица специальностей у конкретного отделения.';


-- -----------------------------------------------------
-- Table `irkpo_events`.`groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`groups`
(
    `groupID`                  INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор группы',
    `groupName`                VARCHAR(50) NOT NULL COMMENT 'Наименование группы',
    `specialties_specialityID` INT         NOT NULL COMMENT 'Связь специальностей и групп к котороым они принадлежат',
    PRIMARY KEY (`groupID`),
    INDEX `fk_groups_Specialties1_idx` (`specialties_specialityID` ASC) VISIBLE,
    CONSTRAINT `fk_groups_Specialties1`
        FOREIGN KEY (`specialties_specialityID`)
            REFERENCES `irkpo_events`.`specialties` (`specialityID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица учебных групп';


-- -----------------------------------------------------
-- Table `irkpo_events`.`curators`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`curators`
(
    `curatorID`          INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор куратора',
    `curator_firstName`  VARCHAR(50) NOT NULL COMMENT 'Имя куратора',
    `curator_lastName`   VARCHAR(50) NOT NULL COMMENT 'Фамилия куратора',
    `curator_middleName` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Отчество куратора',
    `groups_groupID`     INT         NOT NULL COMMENT 'Связь групп и их кураторов',
    PRIMARY KEY (`curatorID`),
    INDEX `fk_Curators_groups1_idx` (`groups_groupID` ASC) VISIBLE,
    CONSTRAINT `fk_Curators_groups1`
        FOREIGN KEY (`groups_groupID`)
            REFERENCES `irkpo_events`.`groups` (`groupID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица кураторов групп';


-- -----------------------------------------------------
-- Table `irkpo_events`.`eventStatuses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`eventStatuses`
(
    `eventStatusID` INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса мероприятия',
    `eventStatus`   VARCHAR(50) NOT NULL DEFAULT 'planned' COMMENT 'Статус мероприятия. По умолчанию - \'planed\'',
    PRIMARY KEY (`eventStatusID`),
    UNIQUE INDEX `eventStatus_UNIQUE` (`eventStatus` ASC) VISIBLE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 5
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица статусов мероприятий';


-- -----------------------------------------------------
-- Table `irkpo_events`.`eventTypes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`eventTypes`
(
    `eventTypeID` INT          NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор типа мероприятия',
    `eventType`   VARCHAR(100) NOT NULL COMMENT 'Тип мероприятия',
    PRIMARY KEY (`eventTypeID`),
    UNIQUE INDEX `eventType_UNIQUE` (`eventType` ASC) VISIBLE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 3
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица типов мероприятий (Спортивные, воспитательные и др.)';


-- -----------------------------------------------------
-- Table `irkpo_events`.`organizers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`organizers`
(
    `organizerID`          INT          NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор организатора',
    `organizer_firstName`  VARCHAR(50)  NOT NULL COMMENT 'Имя организатора',
    `organizer_lastName`   VARCHAR(50)  NOT NULL COMMENT 'Фамилия организатора',
    `organizer_middleName` VARCHAR(50)  NULL DEFAULT NULL COMMENT 'Отчество организатора',
    `jobTitle`             VARCHAR(100) NOT NULL COMMENT 'Должность организатора',
    PRIMARY KEY (`organizerID`)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица организаторов';


-- -----------------------------------------------------
-- Table `irkpo_events`.`events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`events`
(
    `eventID`                     INT            NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор мероприятия',
    `title`                       VARCHAR(100)   NOT NULL COMMENT 'Название мероприятия',
    `description`                 TEXT           NULL DEFAULT NULL COMMENT 'Описание, всё мероприятие',
    `startDateTime`               DATETIME       NOT NULL COMMENT 'Начало мероприятия',
    `endDateTime`                 DATETIME       NOT NULL COMMENT 'Конец мероприятия',
    `location`                    VARCHAR(255)   NOT NULL COMMENT 'Место проведения мероприятия',
    `budget`                      DECIMAL(10, 2) NULL DEFAULT NULL COMMENT 'Общий бюджет мероприятия',
    `createdAt`                   DATETIME       NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Когда запись создана',
    `eventTypes_eventTypeID`      INT            NULL DEFAULT NULL COMMENT 'Связь тип мероприятия - мероприятие',
    `eventStatuses_eventStatusID` INT            NULL DEFAULT NULL COMMENT 'Связь статус мероприятия - мероприятие',
    `faculties_facultyID`         INT            NULL DEFAULT NULL COMMENT 'Связь Отделений с его мероприятия',
    `organizers_organizerID`      INT            NOT NULL COMMENT 'Связь организатора и его мероприятий',
    PRIMARY KEY (`eventID`),
    INDEX `fk_events_eventTypes1_idx` (`eventTypes_eventTypeID` ASC) VISIBLE,
    INDEX `fk_events_eventStatuses1_idx` (`eventStatuses_eventStatusID` ASC) VISIBLE,
    INDEX `fk_events_faculties1_idx` (`faculties_facultyID` ASC) VISIBLE,
    INDEX `fk_events_Organizers1_idx` (`organizers_organizerID` ASC) VISIBLE,
    CONSTRAINT `fk_events_eventStatuses1`
        FOREIGN KEY (`eventStatuses_eventStatusID`)
            REFERENCES `irkpo_events`.`eventStatuses` (`eventStatusID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE,
    CONSTRAINT `fk_events_eventTypes1`
        FOREIGN KEY (`eventTypes_eventTypeID`)
            REFERENCES `irkpo_events`.`eventTypes` (`eventTypeID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE,
    CONSTRAINT `fk_events_faculties1`
        FOREIGN KEY (`faculties_facultyID`)
            REFERENCES `irkpo_events`.`faculties` (`facultyID`)
            ON DELETE SET NULL
            ON UPDATE CASCADE,
    CONSTRAINT `fk_events_Organizers1`
        FOREIGN KEY (`organizers_organizerID`)
            REFERENCES `irkpo_events`.`organizers` (`organizerID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 3
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица мероприятий';


-- -----------------------------------------------------
-- Table `irkpo_events`.`eventGroupRegistrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`eventGroupRegistrations`
(
    `groupRegistrationID`     INT NOT NULL AUTO_INCREMENT,
    `registrationDate`        DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `statusGroupRegistration` VARCHAR(50)     NOT NULL DEFAULT 'active',
    `events_eventID`          INT             NOT NULL,
    `groups_groupID`          INT             NOT NULL,
    PRIMARY KEY (`groupRegistrationID`),
    INDEX `eventGroupRegistrations_events_eventID_fk` (`events_eventID` ASC) VISIBLE,
    INDEX `eventGroupRegistrations_groups_groupID_fk` (`groups_groupID` ASC) VISIBLE,
    CONSTRAINT `eventGroupRegistrations_events_eventID_fk`
        FOREIGN KEY (`events_eventID`)
            REFERENCES `irkpo_events`.`events` (`eventID`)
            ON DELETE CASCADE,
    CONSTRAINT `eventGroupRegistrations_groups_groupID_fk`
        FOREIGN KEY (`groups_groupID`)
            REFERENCES `irkpo_events`.`groups` (`groupID`)
            ON DELETE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `irkpo_events`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`users`
(
    `userID`          INT          NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор пользователя',
    `user_firstName`  VARCHAR(50)  NOT NULL COMMENT 'Имя пользователя',
    `user_lastName`   VARCHAR(50)  NOT NULL COMMENT 'Фамилия пользователя',
    `user_middleName` VARCHAR(50)  NULL     DEFAULT NULL COMMENT 'Отчество пользователя (при наличии)',
    `user_email`      VARCHAR(100) NULL     DEFAULT NULL COMMENT 'Электронная почта пользователя',
    `user_isActive`   TINYINT      NOT NULL DEFAULT '1' COMMENT 'Статус пользователя. По умолчанию 1 (true)',
    `createdAt`       DATETIME     NULL     DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания записи',
    `groups_groupID`  INT          NULL     DEFAULT NULL COMMENT 'Связь учебных групп с пользователями',
    PRIMARY KEY (`userID`),
    UNIQUE INDEX `email_UNIQUE` (`user_email` ASC) VISIBLE,
    INDEX `fk_users_groups1_idx` (`groups_groupID` ASC) VISIBLE,
    CONSTRAINT `fk_users_groups1`
        FOREIGN KEY (`groups_groupID`)
            REFERENCES `irkpo_events`.`groups` (`groupID`)
            ON DELETE SET NULL
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 25
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица всех  пользователей';


-- -----------------------------------------------------
-- Table `irkpo_events`.`eventRegistrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`eventRegistrations`
(
    `registrationID`          INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор регистрации пользователей на мероприятие',
    `registrationDate`        DATETIME    NULL     DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации на мероприятие',
    `statusEventRegistration` VARCHAR(50) NOT NULL DEFAULT 'active' COMMENT 'Статус регистрации. По умолчанию \'active\'',
    `events_eventID`          INT         NULL     DEFAULT NULL COMMENT 'Связь мероприятий с зарегистрированными мероприятиями',
    `users_userID`            INT         NULL     DEFAULT NULL COMMENT 'Связь пользователей с зарегистрированными мероприятиями',
    PRIMARY KEY (`registrationID`),
    UNIQUE INDEX `unique_user_event` (`events_eventID` ASC, `users_userID` ASC) COMMENT '\'Индекс для недопущения повторной регистрации на мероприятие\'' VISIBLE,
    INDEX `eventRegistrations_eventID1_idx` (`events_eventID` ASC) INVISIBLE,
    INDEX `eventRegistrations_users_usersID1_idx` (`users_userID` ASC) VISIBLE,
    CONSTRAINT `fk_eventRegistrations_events_eventID1`
        FOREIGN KEY (`events_eventID`)
            REFERENCES `irkpo_events`.`events` (`eventID`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_eventRegistrations_users_usersID1`
        FOREIGN KEY (`users_userID`)
            REFERENCES `irkpo_events`.`users` (`userID`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 2
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица регистраций на мероприятия';


-- -----------------------------------------------------
-- Table `irkpo_events`.`inventoryCategories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`inventoryCategories`
(
    `inventoryCategoryID`   INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор категории инвенторя',
    `nameInventoryCategory` VARCHAR(50) NOT NULL COMMENT 'Имя категории инвенторя',
    PRIMARY KEY (`inventoryCategoryID`)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 3
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица категорий инвентаря';


-- -----------------------------------------------------
-- Table `irkpo_events`.`inventories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`inventories`
(
    `inventoryID`                             INT         NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор единицы инвенторя',
    `nameInventory`                           VARCHAR(50) NOT NULL COMMENT 'Наименование инвентаря',
    `countInventory`                          INT         NOT NULL COMMENT 'Количество инвентаря',
    `inventoryCategories_inventoryCategoryID` INT         NOT NULL COMMENT 'Связь категорий инвентаря с его инвентарём',
    `events_eventID`                          INT         NOT NULL COMMENT 'Связь мероприятий с необходимым ему инвентарём',
    PRIMARY KEY (`inventoryID`),
    INDEX `fk_Inventories_InventoryCategories1_idx` (`inventoryCategories_inventoryCategoryID` ASC) VISIBLE,
    INDEX `fk_Inventories_events1_idx` (`events_eventID` ASC) VISIBLE,
    CONSTRAINT `fk_Inventories_events1`
        FOREIGN KEY (`events_eventID`)
            REFERENCES `irkpo_events`.`events` (`eventID`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_Inventories_InventoryCategories1`
        FOREIGN KEY (`inventoryCategories_inventoryCategoryID`)
            REFERENCES `irkpo_events`.`inventoryCategories` (`inventoryCategoryID`)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci
    COMMENT = 'Таблица инвентаря';


-- -----------------------------------------------------
-- Table `irkpo_events`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`migrations`
(
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch`     INT          NOT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 4
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `irkpo_events`.`sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `irkpo_events`.`sessions`
(
    `id`            VARCHAR(255)    NOT NULL,
    `user_id`       BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address`    VARCHAR(45)     NULL DEFAULT NULL,
    `user_agent`    TEXT            NULL DEFAULT NULL,
    `payload`       LONGTEXT        NOT NULL,
    `last_activity` INT             NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sessions_user_id_index` (`user_id` ASC) VISIBLE,
    INDEX `sessions_last_activity_index` (`last_activity` ASC) VISIBLE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
