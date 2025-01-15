DROP TABLE IF EXISTS `department_team`;
DROP TABLE IF EXISTS `employee_role`;
DROP TABLE IF EXISTS `team`;
DROP TABLE IF EXISTS `department`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `company_branch`;
DROP TABLE IF EXISTS `company`;

CREATE TABLE company (
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         company_info TEXT,
                         company_name VARCHAR(100) NOT NULL,
                         address VARCHAR(400) DEFAULT NULL
);

CREATE TABLE company_branch (
                                id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                                company_id INT UNSIGNED,
                                workers_count INT UNSIGNED DEFAULT 0,
                                city VARCHAR(200),
                                address VARCHAR(400),
                                branch_description TEXT,
                                FOREIGN KEY (company_id) REFERENCES company(id)
);

CREATE TABLE department (
                            department_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            branch_id INT UNSIGNED NOT NULL,
                            department_name TEXT NOT NULL,
                            FOREIGN KEY (branch_id) REFERENCES company_branch(id)
);

CREATE TABLE user (
                      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                      team_id INT UNSIGNED,
                      first_name VARCHAR(100),
                      last_name VARCHAR(100),
                      middle_name VARCHAR(100),
                      phone_number VARCHAR(100),
                      email VARCHAR(100),
                      sex ENUM('male', 'female'),
                      birth_date DATE,
                      hiring_date DATE,
                      comment TEXT,
                      password TEXT
);

CREATE TABLE team (
                      team_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                      team_name TEXT NOT NULL
);

CREATE TABLE department_team (
                                 department_team_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                 team_id INT UNSIGNED NOT NULL,
                                 department_id INT UNSIGNED NOT NULL,
                                 FOREIGN KEY (team_id) REFERENCES team(team_id),
                                 FOREIGN KEY (department_id) REFERENCES department(department_id),
                                 UNIQUE KEY (team_id, department_id)
);

CREATE TABLE employee_role (
                               employee_id INT UNSIGNED PRIMARY KEY,
                               accessibility INT,
                               role_name VARCHAR(100) NOT NULL,
                               FOREIGN KEY (employee_id) REFERENCES user(id)
);
