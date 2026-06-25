@echo off
cd C:\laragon\www\Biblioteca-UPGOP
"C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" artisan biblioteca:clasificar-deudores >> storage\logs\clasificacion.log 2>&1