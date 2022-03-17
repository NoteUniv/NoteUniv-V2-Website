@echo off

call composer install
call npm install

copy %CD%.env.example %CD%.env

powershell write-host -fore red `n`n`nPlease fill the .env with your environment configuration and press enter`n`n`n
set /p _=""

if not exist "%CD%\storage\app\private" mkdir "%CD%\storage\app\private"

powershell -Command "Invoke-WebRequest https://raw.githubusercontent.com/NoteUniv/NoteUniv-Excel/main/mecc_template.xlsx -OutFile storage\app\private\mecc_template.xlsx"
powershell -Command "Invoke-WebRequest https://raw.githubusercontent.com/NoteUniv/NoteUniv-Excel/main/grades_template.xlsx -OutFile storage\app\private\grades_template.xlsx"

php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed

call npm run dev

start http://localhost:8000

php artisan serve

pause
