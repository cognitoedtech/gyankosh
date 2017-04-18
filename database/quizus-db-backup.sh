NOW=$(date +%Y-%m-%d)

mysqldump -u root -pmipcat@racks123 xnorch > ~/mysql-quizus/backup/quizus_db_$NOW.sql

AWS_ACCESS_KEY_ID=AKIAJU4JRLYXC25VBYGQ AWS_SECRET_ACCESS_KEY=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 aws s3 sync ~/mysql-quizus/backup/ s3://quizus.co/db-backups/

#AWS_ACCESS_KEY_ID=AKIAJU4JRLYXC25VBYGQ AWS_SECRET_ACCESS_KEY=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 aws ses send-email --from quizus.co@gmail.com --to quizus.co@gmail.com --subject "QuizUs.co database backed up" --text "Database has been backed up!"
