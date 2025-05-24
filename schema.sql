CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judge_id INT NOT NULL,
    score INT NOT NULL CHECK (score >= 1 AND score <= 100),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (judge_id) REFERENCES judges(id)
);

-- Sample Data
INSERT INTO users (name) VALUES
('John Doe'),
('Jane Smith'),
('Bob Wilson');

INSERT INTO judges (judge_id, name) VALUES
('J001', 'Alice Brown'),
('J002', 'Charlie Davis');

INSERT INTO scores (user_id, judge_id, score) VALUES
(1, 1, 85),
(1, 2, 90),
(2, 1, 95),
(3, 2, 88);