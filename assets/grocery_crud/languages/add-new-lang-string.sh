#!/bin/sh
for i in *.php
do
   echo "\n" >> $i
   echo "\t/* Added in Jacat */" >> $i
   echo "\t\$lang['list_multiple_export'] = 'All Pages Export/Print';\n" >> $i
   echo "\t\$lang['list_single_export'] = 'Current Page Export/Print';\n" >> $i
done
