-- Seed data for application table
INSERT INTO application (app_id, username, app_secret) VALUES
(1, 'admin', 'secret123admin'),
(2, 'user1', 'secret123user1'),
(3, 'user2', 'secret123user2');

-- Seed data for device table
INSERT INTO device (device_id, mac_address, location, mother_app) VALUES
(1, '00:1A:C2:7B:00:47', 'Office', 1),
(2, '00:1A:C2:7B:00:48', 'Warehouse', 2),
(3, '00:1A:C2:7B:00:49', 'Lab', 3);

-- Seed data for device_apps table
INSERT INTO device_apps (device_id, app_id) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3),
(3, 3);

-- Seed data for routine table
INSERT INTO routine (routine_id, description, frequency, last_done) VALUES
(1, 'Routine maintenance for HVAC system', 30, '2024-12-01'),
(2, 'Weekly server backup', 7, '2024-12-20'),
(3, 'Monthly security checks', 30, '2024-12-10');

-- Seed data for task table
INSERT INTO task (task_id, title, description) VALUES
(1, 'Check filters', 'Check and replace air filters if necessary'),
(2, 'Data backup', 'Perform a full backup of all server data'),
(3, 'Firewall update', 'Update firewall rules and review security logs');

-- Seed data for routine_task table
INSERT INTO routine_task (routine_id, task_id) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Seed data for logs table
INSERT INTO logs (log_id, routine_id, completed) VALUES
(1, 1, TRUE),
(2, 2, FALSE),
(3, 3, TRUE);

-- Seed data for maintenance_history table
INSERT INTO maintenance_history (maintenance_id, log_id, date, note) VALUES
(1, 1, '2024-12-01', 'Replaced all air filters successfully'),
(2, 2, '2024-12-20', 'Scheduled for tomorrow'),
(3, 3, '2024-12-15', 'Updated firewall rules and cleared logs');
