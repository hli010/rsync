Workdir=/n/rsync/rsync
UrlSuffix=http://portland.cn.atrenta.com/ds/
backuphost=`hostname`
restorehost=washington.cn.atrenta.com

datetag=`date +"%Y%m%d"`
Logdir=/var/www/ds/data/$datetag
mkdir -p $Logdir 2>/dev/null

#data sync 
script=$Workdir/rsync_data.sh
log=$Logdir/summary.washington.txt 
echo "======================data sync on $backuphost======================== "
$script >$log 2>&1

echo "please access: $UrlSuffix/index.php?date=$datetag for detail." >>$log


cd $Workdir

mbacklog=$Logdir/mantis.backup.txt  
echo "======================backup mantis on $backuphost=================== "
$Workdir/mantis/RunMantis.sh backup >$mbacklog 2>&1

mrestorelog=$Logdir/mantis.restore.txt
echo "======================restore mantis on $restorehost =================== "
/usr/bin/dsh -m $restorehost -M $Workdir/mantis/RunMantis.sh restore >$mrestorelog 2>&1 


mwbacklog=$Logdir/mediawiki.backup.txt  
echo "======================backup mediawiki on $backup =================== "
$Workdir/mediawiki/RunMediaWiki.sh backup >$mwbacklog 2>&1 

mwrestorelog=$Logdir/mediawiki.restore.txt
echo "======================restore mediawiki on $restorehost=================== "
/usr/bin/dsh -m $restorehost -M  $Workdir/mediawiki/RunMediaWiki.sh restore >$mwrestorelog 2>&1 


rsynclog=$Logdir/datasync.txt 
rsync -azvP -vzrtopg --progress --delete  /var/www/ds/  root@washington.cn.atrenta.com:/var/www/ds/ >$rsynclog 2>&1

cat $log $mbacklog $mrestorelog $mwbacklog $mwrestorelog |mail -s "[$datetag]Data sync to SJC complete at `date +"%H:%M:%S"`!" "heng@atrenta.com"

/var/www/ds/mail.php >$Logdir/mail.log 2>&1

echo "The mail has sent!"
