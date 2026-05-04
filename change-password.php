<?php
require_once __DIR__ . '/includes/php/bootstrap.php';
$pageSlug = jr_page_slug();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JR MARKETING (PVT) LTD — Settings</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f4f4f4; }
        .nav { background: #2e7d32; color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center; }
        .nav a { color: white; text-decoration: none; font-weight: bold; border: 1px solid white; padding: 0.5rem 1rem; border-radius: 4px; }
        .container { display: flex; max-width: 1200px; margin: 2rem auto; gap: 2rem; }
        .sidebar { background: white; padding: 1rem; width: 250px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .sidebar a { display: block; padding: 0.75rem; color: #333; text-decoration: none; border-radius: 4px; margin-bottom: 0.5rem; }
        .sidebar a.active { background: #e8f5e9; color: #2e7d32; font-weight: bold; }
        .content { flex: 1; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        .btn-save { background: #2e7d32; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; cursor: pointer; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="nav">
        <span>JR MARKETING (PVT) LTD — Settings</span>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
    <div class="container">
        <div class="sidebar" id="sidebar">
            <a href="change-password.php">Change Password</a>
            <a href="update-profile.php">Update Profile</a>
            <a href="theme-settings.php">Theme Settings</a>
            <a href="notification-settings.php">Notifications</a>
            <a href="language-settings.php">Language Settings</a>
            <a href="system-settings.php">System Settings</a>
            <a href="manage-roles.php">Manage Roles</a>
            <a href="integrations.php">Integrations</a>
            <a href="about.php">About</a>
        </div>
        <div class="content">
            <h1 id="main-heading">Settings</h1>
            <p id="description"></p>
            <hr>
            <div id="page-content"></div>
            <br>
            <button id="save-btn" class="btn-save">Save Changes</button>
        </div>
    </div>
    <script>
        const path = window.location.pathname.split('/').pop() || 'change-password.php';
        const heading = document.getElementById('main-heading');
        const desc = document.getElementById('description');
        const content = document.getElementById('page-content');
        const saveBtn = document.getElementById('save-btn');

        // Highlight active link
        document.querySelectorAll('.sidebar a').forEach(link => {
            if (link.getAttribute('href') === path) {
                link.classList.add('active');
            }
        });

        const pages = {
            'change-password.php': { h: 'Change Password', d: 'Update your login credentials.', c: '<div class="form-group"><label>New Password</label><input type="password"></div><div class="form-group"><label>Confirm Password</label><input type="password"></div>' },
            'update-profile.php': { h: 'Update Profile', d: 'Manage your personal information.', c: '<div class="form-group"><label>Full Name</label><input type="text"></div><div class="form-group"><label>Email</label><input type="email"></div>' },
            'theme-settings.php': { h: 'Theme Settings', d: 'Customize the appearance of your dashboard.', c: '<div class="form-group"><label>Primary Color</label><input type="color"></div><div class="form-group"><label>Dark Mode</label><input type="checkbox"></div>' },
            'notification-settings.php': { h: 'Notification Settings', d: 'Configure how you receive alerts.', c: '<div class="form-group"><label>Email Notifications</label><input type="checkbox" checked></div><div class="form-group"><label>Push Notifications</label><input type="checkbox"></div>' },
            'language-settings.php': { h: 'Language Settings', d: 'Select your preferred language.', c: '<div class="form-group"><label>Language</label><select><option>English</option><option>Sinhala</option><option>Tamil</option></select></div>' },
            'system-settings.php': { h: 'System Settings', d: 'Configure core platform parameters.', c: '<div class="form-group"><label>API Endpoint</label><input type="text" value="https://api.jrmarketing.lk"></div>' },
            'manage-roles.php': { h: 'Manage Roles', d: 'Assign and edit user permissions.', c: '<div class="form-group"><label>Role Name</label><input type="text"></div><div class="form-group"><label>Level</label><select><option>Admin</option><option>Manager</option><option>Staff</option></select></div>' },
            'integrations.php': { h: 'Integrations', d: 'Connect with third-party services.', c: '<div class="form-group"><label>Webhook URL</label><input type="text"></div>' },
            'about.php': { h: 'About', d: 'Information about JR MARKETING (PVT) LTD.', c: '<p>Version 2.0.4. Specialized in marketing solutions in Sri Lanka.</p>', hideSave: true }
        };

        const config = pages[path] || pages['change-password.php'];
        heading.innerText = config.h;
        desc.innerText = config.d;
        content.innerHTML = config.c;
        if (config.hideSave) saveBtn.classList.add('hidden');
    </script>
</body>
</html>
