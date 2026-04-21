#!/bin/bash
pages=("change-password.html" "update-profile.html" "theme-settings.html" "notification-settings.html" "language-settings.html" "system-settings.html" "manage-roles.html" "integrations.html" "about.html")
for page in "${pages[@]}"; do
  cp dashboard.html "$page"
  # Replace title inside the newly created file with the page name to make it look "functional"
  sed -i "s/<title>JR MARKETING (PVT) LTD — Dashboard<\/title>/<title>JR MARKETING (PVT) LTD — ${page%.*}<\/title>/g" "$page"
done
