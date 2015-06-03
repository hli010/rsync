

datetag=`date +"%Y%m%d"`
DataDir=/var/www/ds/data
LogDir=$DataDir/$datetag
hostname=`hostname`
hostname=${hostname%.cn.atrenta.com}

mkdir $LogDir  2>/dev/null

NO=0

function Rsync() {
   local srcdir=$1
   local destdir=$2

   dname=`basename $srcdir`
   mname=`echo $destdir|awk -F ":" '{print $1}'`
   log=$LogDir/$mname.$dname.$hostname.txt
   starttime=`date +"%Y-%m-%d %H:%M:%S"`
   start=`date +%s`
   if [ ! -e $srcdir ]
   then
	echo "can't access src: [$srcdir]!";
        return        
   fi
   
   size=`du -sh $srcdir |awk '{print $1}'`
   if [ x"$size" == x"4.0K" ]
   then
	echo "the directory [$srcdir] is empty!"
        return 
   fi

   ###echo "rsync -azvP -vzrtopg --progress --delete \"$srcdir/\" \"$destdir/\""
   rsync -azvP -vzrtopg --progress --delete "$srcdir/" "$destdir/" >${log} 2>&1
   end=`date +%s`
   endtime=`date +"%Y-%m-%d %H:%M:%S"`
   timeconsume=$((end-start))
   echo "$NO: [$srcdir] ===> [$destdir] SIZE: $size TIME: ${timeconsume}s"
   ((NO++))
}


#Rsync huashan:/nextop/pub/tool  /n/tool/tool
#Rsync xigu:/nextop/machine/xigu  /n/tool/xigu
#Rsync huashan:/nextop/pub/bs2/infra  /n/dev/script/CI

echo "==================== DATA SYNC ON [$datetag] ===================="
echo "START AT: $(date +"%Y-%m-%d %H:%M:%S") on `hostname`"
startime=`date +%s`


#THE DIRECTORY SHOULD NOT END WITH '/'.
#-------for wushi
Rsync /n/dev/git  heng@wushi.atrenta.com:/nextop/nxtdev/src/git/repositories
Rsync /n/archive/cvs heng@wushi.atrenta.com:/nextop/nxtdev/src/cvs
Rsync /n/release heng@wushi.atrenta.com:/nextop/nxt2/release
Rsync /n/mantis heng@wushi.atrenta.com:/nextop/nxt2/mantis
Rsync /n/license heng@wushi.atrenta.com:/nextop/nxt2/license
Rsync /n/dev/script/CI heng@wushi.atrenta.com:/nextop/nxt2/script/CI
Rsync /n/dev/script/infra heng@wushi.atrenta.com:/nextop/nxt2/script/infra
Rsync /n/dev/tars/ndbs heng@wushi.atrenta.com:/nextop/nxt2/tars/ndbs
Rsync /n/dev/tars/3party/python279 heng@wushi.atrenta.com:/nextop/nxt2/tars/3party/python279
Rsync /n/dev/tars/3party/verific heng@wushi.atrenta.com:/nextop/nxt2/tars/3party/verific
Rsync /n/designbank/bs2test   heng@wushi.atrenta.com:/nextop/nxtdesigns/bs2test 

#-------for washington
Rsync /n/archive/bs1/doc root@washington.cn.atrenta.com:/nextop/n/archive/bs1/doc
Rsync /n/archive/bs1/qmerge root@washington.cn.atrenta.com:/nextop/n/archive/bs1/qmerge
Rsync /n/archive/bs1/mantis root@washington.cn.atrenta.com:/nextop/n/archive/bs1/mantis
Rsync /n/archive/bs1/snapshot root@washington.cn.atrenta.com:/nextop/n/archive/bs1/snapshot
Rsync /n/archive/bs1/tars root@washington.cn.atrenta.com:/nextop/n/archive/bs1/tars
Rsync /n/archive/cvs root@washington.cn.atrenta.com:/nextop/n/archive/cvs
Rsync /n/dev/git root@washington.cn.atrenta.com:/nextop/n/dev/git
Rsync /n/dev/script/CI root@washington.cn.atrenta.com:/nextop/n/dev/script/CI
Rsync /n/dev/tars/3party/python279 root@washington.cn.atrenta.com:/nextop/n/dev/tars/3party/python279
Rsync /n/dev/tars/3party/verific root@washington.cn.atrenta.com:/nextop/n/dev/tars/3party/verific
#Rsync /n/dev/tars/doc root@washington.cn.atrenta.com:/nextop/n/dev/tars/doc
Rsync /n/dev/tars/ndbs root@washington.cn.atrenta.com:/nextop/n/dev/tars/ndbs
Rsync /n/license root@washington.cn.atrenta.com:/nextop/n/license
Rsync /n/mantis root@washington.cn.atrenta.com:/nextop/n/mantis
Rsync /n/release root@washington.cn.atrenta.com:/nextop/n/release
Rsync /n/release/exe root@washington.cn.atrenta.com:/nextop/n/release/exe
Rsync /n/dev/script/infra root@washington.cn.atrenta.com:/nextop/n/dev/script/infra

#------------for sync log
Rsync /var/www/ds/data root@washington.cn.atrenta.com:/var/www/ds/data

echo "END   AT: $(date +"%Y-%m-%d %H:%M:%S") on `hostname`"
endtime=`date +%s`
echo "   TIME CONSUME: $((endtime-startime)) seconds."
echo "==================== SYNC END =============================="





