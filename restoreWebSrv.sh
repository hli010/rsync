Workdir=/n/rsync/rsync
UrlSuffix=http://portland.cn.atrenta.com/ds/
datetag=`date +"%Y%m%d"`
Logdir=/var/www/ds/data/$datetag

cd $Workdir

mantisbacklog=$Logdir/mantis.backup.txt 
if [ -e $mantisbacklog ]
then
        mantislog=$Logdir/mantis.restore.txt
	echo "======================restore mantis=================== "
	$Workdir/mantis/RunMantis.sh restore >$mantislog 2>&1 
else
	echo "can't found backup files for mantis!"
fi

mediawikibacklog=$Logdir/mediawiki.backup.txt 
if [ -e $mediawikibacklog ]
then
        mediawikilog=$Logdir/mediawiki.restore.txt
	echo "======================restore mediawiki=================== "
	$Workdir/mediawiki/RunMediaWiki.sh restore >$mediawikilog 2>&1 
else
	echo "can't found backup files for mediawiki!"
fi


