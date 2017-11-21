#!/usr/bin/env python2
# -*- coding: utf-8 -*-
"""
Created on Mon Nov 20 19:48:54 2017

Loads questions from "/raw_files/ucSS_EE.txt" files, which have been manually 
organized into the type of question.

@author: nEquals30
"""

import MySQLdb

db = MySQLdb.connect(host="localhost",  # your host 
                     user="root",       # username
                     passwd="FAKEFORNOW",     # password
                     db="universityChallenge")   # name of the database