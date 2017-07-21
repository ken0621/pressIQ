mysql -u"root" -p"water123" -e "DROP DATABASE digimahouse"
mysql -u"root" -p"water123" -e "CREATE DATABASE digimahouse"

rm -rf ~/my168shop_latest_backup.sql.gz
wget -P ~/ http://digimahouse.com/my168shop_latest_backup.sql.gz
rm -rf ~/my168shop_latest_backup.sql
gunzip ~/my168shop_latest_backup.sql.gz
pv ~/my168shop_latest_backup.sql | mysql -u"root" -p"water123" digimahouse