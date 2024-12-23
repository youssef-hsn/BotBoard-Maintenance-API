-- App table
CREATE TABLE application (
    app_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    app_secret VARCHAR(255)
);

-- device table
CREATE TABLE device (
    device_id INT AUTO_INCREMENT PRIMARY KEY,
    mac_address VARCHAR(17),
    location VARCHAR(255),
    mother_app INT,
    FOREIGN KEY (mother_app) REFERENCES application(app_id)
);

-- device link to apps (who can access the device)
CREATE TABLE device_apps (
    device_id INT,
    app_id INT,
    PRIMARY KEY (device_id, app_id),
    FOREIGN KEY (device_id) REFERENCES device(device_id),
    FOREIGN KEY (app_id) REFERENCES application(app_id)
);

-- routine table
CREATE TABLE routine (
    routine_id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    frequency INT, -- in days
    last_done DATE
);

-- task table
CREATE TABLE task (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT
);

-- routine link to task
CREATE TABLE routine_task (
    routine_id INT,
    task_id INT,
    PRIMARY KEY (routine_id, task_id),
    FOREIGN KEY (routine_id) REFERENCES routine(routine_id),
    FOREIGN KEY (task_id) REFERENCES task(task_id)
);

-- logs table
CREATE TABLE logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    routine_id INT,
    completed BOOLEAN,
    FOREIGN KEY (routine_id) REFERENCES routine(routine_id)
);

-- maintenance history table
CREATE TABLE maintenance_history (
    maintenance_id INT AUTO_INCREMENT PRIMARY KEY,
    log_id INT,
    date DATE,
    note TEXT,
    FOREIGN KEY (log_id) REFERENCES logs(log_id)
);
