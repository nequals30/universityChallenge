#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Sun Oct 22 18:22:04 2017

* Downloads VTT subtitles from youtube for a given episode
* Parses the VTT subtitles into a format organized by line

youtube-dl https://www.youtube.com/watch?v=iGYq1TC708A -x --sub-lang id --write-sub --skip-download

@author: nEquals30
"""

import MySQLdb
from nltk import tokenize

# Download the Episode --------------------------------------------------------
# Implement Later:
# https://stackoverflow.com/questions/18054500/how-to-use-youtube-dl-from-a-python-program

# Parse the VTT into a temporary stage file -----------------------------------
episodeID = 'uc47_03'

fin = open('vtt_files/' + episodeID + '.vtt','r')
fstage = open(episodeID + '_stage.txt','w')

isOn = False

for line in fin.readlines():
    if isOn:
        if line[:2] != '00':
            if "10 points" in line or "ten points" in line.lower():
                fstage.write('NEXT QUESTION')
            
            line = line.replace('BUZZ','. ')
            line = line.replace('BELL RINGS','. ')
            line = line.replace('APPLAUSE','')
            line = line.replace('THEY WHISPER','')
            line = line.replace('THEY CONFER QUIETLY','')
            line = line.replace('THEY CONFER','')
            fstage.write(line.strip() + ' ')

    if "first starter" in line:
        isOn = True
        
    if "GONG" in line:
        isOn = False

fin.close()
fstage.close()

# Split into sentences and load into SQL --------------------------------------

file_in = open(episodeID + '_stage.txt','r')
sentences_in = tokenize.sent_tokenize(file_in.read())
file_in.close()

# Connect to SQL --------------------------------------------------------------
fileMysqlConfig = open('mysqlInfo.config','r')
mysqlInfo = fileMysqlConfig.readlines()

cn = MySQLdb.connect(host='localhost',           # host 
                     user=mysqlInfo[0].strip(),  # username
                     passwd=mysqlInfo[1].strip(),# password
                     db="universityChallenge")   # database

cur = cn.cursor()
fileMysqlConfig.close()

# Load all sentences into SQL -------------------------------------------------
try:
    cur.execute("delete from stageText;")
    cn.commit()
except:
    cn.rollback()

question = 1
for sentence in sentences_in:
    if "NEXT QUESTION" in sentence:
        sentence = sentence.replace("NEXT QUESTION","")
        question = question + 1
    try:
        q = "insert into stageText(textString,questionNumGuess) values (%s,%s)"
        cur.execute(q,(sentence,str(question)))
        #cur.execute("insert into stageText(textString,questionNumGuess) values ('" + sentence + "'," + str(question) + ");")
        cn.commit()
    except:
        cn.rollback()
cn.close()

print('COMPLETED')
