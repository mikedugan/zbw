import sys
import _mysql
import string
import getopt
import profile, pstats
import zbwdb.py


file = open('../feeds/vatsim.txt', 'r')
traffic_template = open('../../views/includes/bj/_flightstrip.blade.php')
atc_template = open('../../views/includes/bj/_atc.blade.php')
traffic_template.truncate()
atc_template.truncate()

db = _mysql.connect('localhost', ')
