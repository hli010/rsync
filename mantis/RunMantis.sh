#!/bin/bash - 
#===============================================================================
#
#          FILE:  Backup.sh
# 
#         USAGE:  ./Backup.sh 
# 
#   DESCRIPTION:  
# 
#       OPTIONS:  ---
#  REQUIREMENTS:  ---
#          BUGS:  ---
#         NOTES:  ---
#        AUTHOR:  H. Li (Heng), heng@nextopsoftware.com
#       COMPANY:  NEXTOPSOFTWARE.INC
#       VERSION:  1.0
#       CREATED:  07/03/2013 03:59:27 PM CST
#      REVISION:  ---
#===============================================================================

set -o nounset                              # Treat unset variables as an error

function showMsg() {
   echo "[`date +"%Y-%m-%d %H:%M:%S"`]$*" 
}

datetag=`date +"%Y%m%d"`
ROOT=`dirname $0`
ROOT=`cd $ROOT; pwd`

BackupDir=$ROOT
RestoreDir=$ROOT
User=root
Passwd=''

encryptPasswd="nextop2shabc."

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

function backupMySql() {
    destdir=$BackupDir
    
    umask 0037
    dumpfile=${destdir}/mysql.all
    bugtrackerfile=${destdir}/mysql.bugtracker

    start=`date +%s`
    echo "start at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
    echo "dumping $dumpfile"
    mysqldump --all-databases --add-drop-table -u $User -p${Passwd} > ${dumpfile}
    /usr/bin/md5sum $dumpfile >$dumpfile.md5sum 2>&1
    

    echo "dumping $bugtrackerfile"
    mysqldump --databases bugtracker116 --add-drop-database --add-drop-table -u $User -p${Passwd} > ${bugtrackerfile}
    /usr/bin/md5sum $bugtrackerfile >$bugtrackerfile.md5sum 2>&1
    echo "end   at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
    end=`date +%s`
    echo "   TIME_CONSUME IS: $((end-start)) SECONDS."
}


function checkMD5sum(){
    local filename=$1
    
    md5sum=$filename.md5sum 
    if [ ! -e $filename ]
    then
	echo "can't found file: [$filename]!"
	return false;
    fi
    
    if [ ! -e $md5sum ]
    then
	echo "can't found checksum file: [$md5sum]!"
	return false;
    fi

    md5sum -c $md5sum >$md5sum.check
    return $?
}


function restoreMantis()
{
    	start=`date +%s`
	echo "start at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
        allbak=$RestoreDir/mysql.all
        bugbak=$RestoreDir/mysql.bugtracker

        if checkMD5sum $allbak
	then
             :
	else
	     echo "md5 check mismatch for [$allbak]!";
	     exit 1 
	fi
        
	if checkMD5sum $bugbak
	then
             :
	else
	     echo "md5 check mismatch for [$bugbak]!";
	     exit 1 
	fi

	echo "restore '$allbak' ..."
	mysql -u$User -p${Passwd} < $allbak
	echo "restore '$bugbak' ..."
	mysql -u$User -p${Passwd} < $bugbak
	echo "restore done."

	echo "end   at `date +"%Y-%m-%d %H:%M:%S"` on `hostname`"
    	end=`date +%s`
    	echo "   TIME_CONSUME IS: $((end-start)) SECONDS."
        echo " please access http://washington.cn.atrenta.com/mantis_backup/ for detail."
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
    backupMySql
fi

if [ x"$1" == x"restore" ]
then
    CheckMachineEnv "washington.cn.atrenta.com"
    restoreMantis
fi


