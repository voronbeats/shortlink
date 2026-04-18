
CREATE TABLE links (
  id INT AUTO_INCREMENT PRIMARY KEY,
  original_url TEXT NOT NULL,
  short_code VARCHAR(10) UNIQUE,
  created_at DATETIME,
  clicks INT DEFAULT 0
);

CREATE TABLE logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  link_id INT,
  ip VARCHAR(45),
  created_at DATETIME
);
