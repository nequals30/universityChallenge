#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Mon Nov 20 19:48:54 2017

Loads questions from "/raw_files/ucSS_EE.txt" files, which have been manually 
organized into the type of question.

@author: nEquals30
"""

import MySQLdb

# Connect to the database -----------------------------------------------------
fileMysqlConfig = open('mysqlInfo.config','r')
mysqlInfo = fileMysqlConfig.readlines()

cn = MySQLdb.connect(host='localhost',           # host 
                     user=mysqlInfo[0].strip(),  # username
                     passwd=mysqlInfo[1].strip(),# password
                     db="universityChallenge")   # database

cur = cn.cursor()
fileMysqlConfig.close()

# Go through and load all relevant text strings -------------------------------

try:
    cur.execute("insert into text(textString) values ('this is a test');")
    cn.commit()
except:
    cn.rollback()
    
cn.close()

print "yo dawg"