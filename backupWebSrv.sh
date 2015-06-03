PWD=/n/rsync/rsync

cd $PWD


echo "======================backup mantis=================== "
mantis/RunMantis.sh backup

echo "======================backup mediawiki=================== "
mediawiki/RunMediaWiki.sh backup 

