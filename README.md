1. docker compose build
2. docker compose up -d
3. open mysql container >  mysql -u root -p root < docker-entrypoint-initdb.d/dump.sql
4. run in browser /getCurrencies
5. run in browser /getAll for all results
6. run in browser /getByDate?date=2024-06-24 for certain date results

cron will take exchange rates at 03:00 AM