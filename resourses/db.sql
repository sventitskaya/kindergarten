CREATE SCHEMA IF NOT EXISTS kindergarten;

-- Создание таблицы "Роли"
CREATE TABLE IF NOT EXISTS Roles
(
    role_id   INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(20) NOT NULL
);

-- Вставка ролей
INSERT INTO Roles (role_name)
VALUES ('Родитель'),
       ('Учитель'),
       ('Воспитатель'),
       ('Заведующая');

-- Удаление ролей с id больше 3 (если они есть)
DELETE
FROM Roles
WHERE role_id > 4;

-- Создание таблицы "Пользователи"
CREATE TABLE IF NOT EXISTS Users
(
    user_id           INT AUTO_INCREMENT PRIMARY KEY,
    username          VARCHAR(255)        NOT NULL,
    email             VARCHAR(255) UNIQUE NOT NULL,
    password          VARCHAR(255)        NOT NULL,
    first_name        VARCHAR(255)        NOT NULL,
    middle_name       VARCHAR(255)        NOT NULL,
    last_name         VARCHAR(255)        NOT NULL,
    contact_phone     VARCHAR(20)         NOT NULL,
    address           TEXT,
    role_id           INT,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES Roles (role_id)
);

-- Вставка суперадмина
INSERT INTO Users (username, email, password, first_name, middle_name, last_name, contact_phone, address, role_id)
VALUES ('super', 'super@super.ru', SHA2('123', 256), 'super', 'super', 'super', '99999999', 'superaddress', 4);
-- Удаление суперадмина (если user_id > 1 и username = 'super')
DELETE
FROM Users
WHERE user_id > 1
  AND username = 'super';

-- Создание таблицы "Группы"
CREATE TABLE IF NOT EXISTS ChildrenGroups
(
    group_id    INT AUTO_INCREMENT PRIMARY KEY,
    group_name  VARCHAR(255) NOT NULL,
    educator_id INT,
    FOREIGN KEY (educator_id) REFERENCES Users (user_id)
);

-- Создание таблицы "Дети"
CREATE TABLE IF NOT EXISTS Children
(
    child_id    INT AUTO_INCREMENT PRIMARY KEY,
    first_name  VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NOT NULL,
    last_name   VARCHAR(255) NOT NULL,
    birth_date  DATE         NOT NULL,
    gender      VARCHAR(10)  NOT NULL,
    group_id    INT,
    FOREIGN KEY (group_id) REFERENCES ChildrenGroups (group_id)
);

-- Создание таблицы "Заявки на регистрацию"
CREATE TABLE IF NOT EXISTS RegistrationRequests
(
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT,
    status     VARCHAR(20) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
);

-- Создание таблицы "Родитель-Ребенок"
CREATE TABLE IF NOT EXISTS ParentChildRelation
(
    parent_id INT,
    child_id  INT,
    PRIMARY KEY (parent_id, child_id),
    FOREIGN KEY (parent_id) REFERENCES Users (user_id),
    FOREIGN KEY (child_id) REFERENCES Children (child_id)
);

-- Создание таблицы "Занятия"
CREATE TABLE IF NOT EXISTS Lessons
(
    lesson_id      INT AUTO_INCREMENT PRIMARY KEY,
    lesson_name    VARCHAR(255) NOT NULL,
    start_datetime TIMESTAMP    NOT NULL,
    end_datetime   TIMESTAMP    NOT NULL,
    description    TEXT,
    teacher_id     INT,
    FOREIGN KEY (teacher_id) REFERENCES Users (user_id)
);

-- Создание таблицы "Урок-Группа"
CREATE TABLE IF NOT EXISTS LessonGroupRelation
(
    lesson_id INT,
    group_id  INT,
    PRIMARY KEY (lesson_id, group_id),
    FOREIGN KEY (lesson_id) REFERENCES Lessons (lesson_id),
    FOREIGN KEY (group_id) REFERENCES ChildrenGroups (group_id)
);