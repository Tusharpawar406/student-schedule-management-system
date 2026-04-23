
CREATE DATABASE IF NOT EXISTS ssms;
USE ssms;

DROP TABLE IF EXISTS activity;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS student;


CREATE TABLE student (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    course   VARCHAR(50),
    year     INT
);

-- one day for one student
CREATE TABLE schedule (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    date       DATE NOT NULL,
    FOREIGN KEY (student_id) REFERENCES student(id) ON DELETE CASCADE
);

-- one task inside a schedule
CREATE TABLE activity (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    schedule_id INT NOT NULL,
    task        VARCHAR(100) NOT NULL,
    category    VARCHAR(50),
    start_time  TIME,
    end_time    TIME,
    FOREIGN KEY (schedule_id) REFERENCES schedule(id) ON DELETE CASCADE
);

--  data
INSERT INTO student (name, course, year) VALUES
('Tushar Pawar',  'B.Tech', 3),
('Yashraj Pokle', 'B.Tech', 3),
('Sneha Desai',   'B.Tech', 2);

INSERT INTO schedule (student_id, date) VALUES (1, '2025-03-01');
INSERT INTO schedule (student_id, date) VALUES (2, '2025-03-01');

INSERT INTO activity (schedule_id, task, category, start_time, end_time) VALUES
(1, 'Attend Lecture',  'College', '09:00', '13:00'),
(1, 'Self Study',      'Study',   '14:00', '16:00'),
(1, 'Sleep',           'Rest',    '22:00', '06:00'),
(2, 'Morning Exercise','Gym',     '06:00', '07:30'),
(2, 'College',         'College', '09:00', '14:00');
