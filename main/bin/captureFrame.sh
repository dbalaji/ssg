#!/bin/sh

#This script gets the following commandline arguments
# $1 -- executable file path/ command name of dump-gnash (or any other tool as
#       specified in the configuration)
# $2 -- Swf movie file path
# $3 -- The frame number to be captured
# $4 -- Screenshot saving file path

#Modify this script to capture swf movie frames with tool other than gnash
#There is no harm in executing this script, as all the arguments come from php
# and not from the user input.
#NOTE: To debug set the redirections to a file at each of the commands(>> /dev/null 2>&1)

raw=$(mktemp)
$1 $2 -D $raw --max-advances $3 -j 500 -k 500 >> /dev/null 2>&1
tail -c 1MB $raw | convert -size 500x500 -depth 8 rgba:- \
-separate -swap 0,2 -combine -trim png:$4  >> /dev/null 2>&1
trap "rm $raw" EXIT
