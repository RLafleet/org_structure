CREATE TABLE company_branch (
                                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                workers_count INT UNSIGNED,
                                city VARCHAR(200),
                                address VARCHAR(400),
                                company_name VARCHAR(200),
                                branch_name VARCHAR(200)
);

CREATE TABLE user (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      branch_id INT UNSIGNED ,
                      first_name VARCHAR(100),
                      last_name VARCHAR(100),
                      middle_name VARCHAR(100),
                      phone_number VARCHAR(100),
                      email VARCHAR(100),
                      sex ENUM('male', 'female'),
                      birth_date DATE,
                      hiring_date DATE,
                      position VARCHAR(100),
                      comment TEXT,
                      FOREIGN KEY (branch_id)
                          REFERENCES company_branch(id)
);