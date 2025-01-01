-- Existing tables...

CREATE TABLE site_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  site_name VARCHAR(100) NOT NULL,
  site_description TEXT,
  contact_email VARCHAR(100) NOT NULL,
  max_upload_size INT NOT NULL DEFAULT 5,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default site settings
INSERT INTO site_settings (site_name, site_description, contact_email, max_upload_size)
VALUES ('LMS Admin Dashboard', 'A powerful Learning Management System', 'admin@example.com', 5);

