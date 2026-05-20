@echo off
start cmd /k "cd /d C:\Hostel Management Laravel\hostel-management && php artisan serve"
timeout /t 3
start cmd /k "cd /d C:\Hostel Management Laravel\hostel-management\ngrok-v3-stable-windows-amd64 && .\ngrok.exe http 8000"