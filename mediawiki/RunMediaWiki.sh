#http://lilydjwg.is-programmer.com/2011/5/28/story-of-migrating-mediawiki.27048.html
#

function CheckMachineEnv() {
    local destmach=$1

    if [ $(id -u) != 0 ]; then
        echo "The jobs should run as 'root'!" >&2
    fi

    hostname=$(hostname)
    if [ x"${hostname}" != x"${destmach}" ]
    then
        echo "The jobs should run on '$destmach', current it's '$hostname'!" >&2
        exit 1
    fi
}


php=`which php`
function backupMediaWiki(){
	backupdir=/n/rsync/rsync/mediawiki
	wikidir=/var/www/wiki/

    	start=`date +%s`
        echo "start at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
	mkdir -p $backupdir 2>/dev/null

	$php $wikidir/maintenance/dumpBackup.php --full --uploads > $backupdir/wiki-backup.xml
	tar -czf $backupdir/wiki-images.tgz $wikidir/images
        echo "end   at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
    	end=`date +%s`
    	echo "   TIME_CONSUME IS: $((end-start)) SECONDS."
}


function restoreMediaWiki(){
	backupdir=/n/rsync/rsync/mediawiki
	wikidir=/var/www/wiki_backup/

    	start=`date +%s`
        echo "start at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
	$php $wikidir/maintenance/importDump.php $backupdir/wiki-backup.xml
        rm -rf temporary tempimages 2>/dev/null 
	mkdir temporary
	cp $backupdir/wiki-images.tgz temporary
	cd temporary/
	tar -xzf wiki-images.tgz
	cd ../
	mkdir tempimages
	cp -r temporary/var/www/wiki/images tempimages/
	$php $wikidir/maintenance/importImages.php --search-recursively tempimages/images
	$php $wikidir/maintenance/initEditCount.php
	$php $wikidir/maintenance/rebuildrecentchanges.php

	$php $wikidir/maintenance/rebuildImages.php --missing
        echo "end   at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
    	end=`date +%s`
    	echo "   TIME_CONSUME IS: $((end-start)) SECONDS."
        echo "  please access http://washington.cn.atrenta.com/wiki_backup/ for detail."
}


mailto="heng@atrenta.com"
mailcc="hli010@gmail.com"

if [ $# -ne 1 ]
then
    echo "wrong params!"
    echo "usage: "
    echo "   `basename $0` backup|restore"
    exit 1
fi

if [ x"$1" == x"backup" ]
then
    CheckMachineEnv "portland.cn.atrenta.com"
    backupMediaWiki
fi

if [ x"$1" == x"restore" ]
then
    CheckMachineEnv "washington.cn.atrenta.com"
    restoreMediaWiki
fi


