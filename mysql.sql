SET NAMES utf8mb4;

DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS specifications;
DROP TABLE IF EXISTS positions;

CREATE TABLE positions (
  id   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE specifications (
  id   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE users (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  role        ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  login       VARCHAR(255) NOT NULL,
  password    VARCHAR(255) NOT NULL,
  last_name   VARCHAR(255) NOT NULL,
  first_name  VARCHAR(255) NOT NULL,
  middle_name VARCHAR(255) NULL,
  created_at  DATE NOT NULL DEFAULT (CURRENT_DATE),
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_login (login)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE patients (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  last_name   VARCHAR(255) NOT NULL,
  first_name  VARCHAR(255) NOT NULL,
  middle_name VARCHAR(255) NULL,
  birth_date  DATE NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE doctors (
  id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  last_name        VARCHAR(255) NOT NULL,
  first_name       VARCHAR(255) NOT NULL,
  middle_name      VARCHAR(255) NULL,
  birth_date       DATE NOT NULL,
  position_id      BIGINT UNSIGNED NULL,
  deleted          BOOLEAN NOT NULL DEFAULT FALSE,
  specification_id BIGINT UNSIGNED NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_doctors_position
    FOREIGN KEY (position_id) REFERENCES positions (id)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_doctors_specification
    FOREIGN KEY (specification_id) REFERENCES specifications (id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE appointments (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  patient_id      BIGINT UNSIGNED NOT NULL,
  doctor_id       BIGINT UNSIGNED NOT NULL,
  created_by      BIGINT UNSIGNED NOT NULL,
  visit_timestamp TIMESTAMP NOT NULL,
  status          ENUM('wait', 'cancelled', 'success') NOT NULL DEFAULT 'wait',
  created_at      DATE NOT NULL DEFAULT (CURRENT_DATE),
  cancelled_at    DATE NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_appointments_patient
    FOREIGN KEY (patient_id) REFERENCES patients (id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_appointments_doctor
    FOREIGN KEY (doctor_id) REFERENCES doctors (id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_appointments_created_by
    FOREIGN KEY (created_by) REFERENCES users (id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO users (id, role, login, password, last_name, first_name, middle_name, created_at) VALUES
  (1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Иванов', 'Иван', 'Иванович', CURRENT_DATE);
