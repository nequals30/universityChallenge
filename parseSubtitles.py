#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Sun Oct 22 18:22:04 2017

* Downloads VTT subtitles from youtube for a given episode
* Parses the VTT subtitles into a format organized by line

youtube-dl https://www.youtube.com/watch?v=iGYq1TC708A -x --sub-lang id --write-sub --skip-download
youtube-dl https://www.youtube.com/watch?v=KT2Jsb3H7cI -x --sub-lang id --write-sub --skip-download

@author: nEquals30
"""

# Part 1: Download the Episode ------------------------------------------------
# Implement Later:
# https://stackoverflow.com/questions/18054500/how-to-use-youtube-dl-from-a-python-program

# Part 2: Parse the VTT into a temporary stage file ---------------------------
episodeID = 'uc47_01'

fin = open('vtt_files/' + episodeID + '.vtt','r')
fstage = open(episodeID + '_stage.txt','w')

isOn = False

for line in fin.readlines():
    if isOn:
        if line[:2] != '00':
            if "10 points" in line or "ten points" in line.lower():
                fstage.write('\n---------------\n')
            fstage.write(line.strip() + ' ')

    if "first starter" in line:
        isOn = True
        
    if "GONG" in line:
        isOn = False

fin.close()
fstage.close()

# Part 2: 
from nltk import tokenize

file_in = open(episodeID + '_stage.txt','r').read()
fout = open('raw_files/' + episodeID + '.txt','w')

sentences_in = tokenize.sent_tokenize(file_in)

for sentence in sentences_in:
    if not '---------------' in sentence:
        fout.write("[ ] ")
    fout.write(sentence + '\n')

fin.close()
fout.close()