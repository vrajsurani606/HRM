@echo off
echo Installing required packages for PDF and PNG generation...
composer require barryvdh/laravel-dompdf:^3.0
composer require intervention/image:^3.0
echo Installation complete!
pause