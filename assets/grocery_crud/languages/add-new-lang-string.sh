#!/bin/sh
for i in *.php
do
   echo "\n" >> $i
   echo "\t/* Added in Jacat */" >> $i
   echo "\t\$lang['show_columns'] = 'Show Columns';\n" >> $i
done
