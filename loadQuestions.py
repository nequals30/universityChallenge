#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Fri Dec  8 19:55:33 2017

@author: nEquals30
"""

import MySQLdb
import pandas as pd

# Connect to SQL ------------- ------------------------------------------------
fileMysqlConfig = open('mysqlInfo.config','r')
mysqlInfo = fileMysqlConfig.readlines()

cn = MySQLdb.connect(host='localhost',           # host 
                     user=mysqlInfo[0].strip(),  # username
                     passwd=mysqlInfo[1].strip(),# password
                     db="universityChallenge")   # database

cur = cn.cursor()
fileMysqlConfig.close()

# Pull in all the questions ---------------------------------------------------
cur.execute("select textString,questionNumGuess,cat from stageText")
allQs = cur.fetchall()
allQtbl = pd.DataFrame.from_records(list(allQs),columns=['textStr','qNum','cat'])

# Iterate through questions ---------------------------------------------------
for i in range(1,max(allQtbl['qNum'])):
    print(i)

print('COMPLETED')