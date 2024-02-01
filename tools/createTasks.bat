@echo off

REM Create MINUTE task
schtasks /Create /SC MINUTE /TN "Agendamentos Minuto a Minuto" /TR "php \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" MINUTE"

REM Create HOURLY task
schtasks /Create /SC HOURLY /TN "Agendamentos Horários" /TR "php \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" HOURLY"

REM Create DAILY task
schtasks /Create /SC DAILY /TN "Agendamentos Diários" /TR "php \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" DAILY"

REM Create WEEKLY task
schtasks /Create /SC WEEKLY /TN "Agendamentos Semanais" /TR "php \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" WEEKLY"

REM Create MONTHLY task
schtasks /Create /SC MONTHLY /TN "Agendamentos Mensais" /TR "php \"C:\xampp\htdocs\cartonagem-trindade\scheduled.php\" MONTHLY"