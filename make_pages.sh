#!/bin/bash
pages=("change-password.php" "update-profile.php" "theme-settings.php" "notification-settings.php" "language-settings.php" "system-settings.php" "manage-roles.php" "integrations.php" "about.php")
for page in "${pages[@]}"; do
  cp dashboard.php "$page"
  # Replace title inside the newly created file with the page name to make it look "functional"
  sed -i "s/<title>JR MARKETING (PVT) LTD — Dashboard<\/title>/<title>JR MARKETING (PVT) LTD — ${page%.*}<\/title>/g" "$page"
done
