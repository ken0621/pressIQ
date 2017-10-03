## DEPENDENCIES ##
command -v gzip >/dev/null 2>&1 || { sudo apt-get update; sudo apt-get install gzip; }
command -v pv >/dev/null 2>&1 || { sudo apt-get update; sudo apt-get install pv; }
command -v sshpass >/dev/null 2>&1 || { sudo apt-get update; sudo apt-get install sshpass; }

## LOGIN SSH ##
sshpass -p "digima2018" ssh -o StrictHostKeyChecking=no digima@128.199.91.177 "~/update-live.sh"

echo "Production Server has been updated!"