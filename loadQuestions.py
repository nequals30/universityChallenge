#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Fri Dec  8 19:55:33 2017

@author: nEquals30
"""

import MySQLdb
import pandas as pd
import numpy as np

season = 47
episode = 1

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

# Delete this episode from question table -------------------------------------
q = 'delete from question where season=' + str(season) + ' and episode=' + str(episode)
cur.execute(q)
cn.commit()

# Iterate through questions ---------------------------------------------------
q = "insert into question (season,episode,question,subQuestion,phraseType,phraseText) values (%s,%s,%s,%s,%s,%s)"
for i in range(1,max(allQtbl['qNum']) + 1):
    print('Question ' + str(i))
    thisTbl = allQtbl[allQtbl['qNum']==i]
    thisTbl = thisTbl[thisTbl.cat!=0]
    
    # Categorize into subQuestion (1-5) and phraseType (1-4)
    thisTbl = thisTbl.assign(sq=pd.Series([0] * (len(thisTbl.index))))
    thisTbl = thisTbl.assign(pt=pd.Series([0] * (len(thisTbl.index))))
    
    thisTbl.loc[thisTbl['cat']==1,'sq'] = 1   # starter
    thisTbl.loc[thisTbl['cat']==1,'pt'] = 1   # starter
        
    thisTbl.loc[thisTbl['cat']==6,'sq'] = 1   # starter interruption
    thisTbl.loc[thisTbl['cat']==6,'pt'] = 4   # starter interruption
    
    thisTbl.loc[thisTbl['cat']==4,'sq'] = 2   # bonus introduction
    thisTbl.loc[thisTbl['cat']==4,'pt'] = 0   # bonus introduction   
    
    thisTbl.loc[thisTbl['cat']==5,'sq'] = np.cumsum(np.logical_and(thisTbl.cat[2:]==5,thisTbl.cat[1:(len(thisTbl.index)-1)]!=5))[thisTbl.cat==5] + 2
    thisTbl.loc[thisTbl['cat']==5,'pt'] = 1   # bonus questions

    thisTbl.sq[np.isnan(thisTbl.sq)] = 0
    thisTbl['sq']=thisTbl['sq'].replace(to_replace=0,method='ffill')
    
    thisTbl.loc[thisTbl['cat']==2,'pt'] = 2  # correct answer
    thisTbl.loc[thisTbl['cat']==3,'pt'] = 3  # wrong answer
    
    for sq in range(1,6):
        for pt in range(0,5):
            if not thisTbl[np.logical_and(thisTbl.pt==pt,thisTbl.sq==sq)].empty:
                s = thisTbl[np.logical_and(thisTbl.pt==pt,thisTbl.sq==sq)].textStr.str.cat(sep=' ')
                # if sq in (2,3,4) remove periods and question marks
                cur.execute(q,(season,episode,i,sq,pt,s))

    cn.commit()

print('COMPLETED')