import sys
from metar import Metar
import string
import getopt
import profile, pstats

file = open('../feeds/metar.txt', 'r')
template = open('../../views/includes/bj/_metar.blade.php', 'w')
template.truncate()
blade = ""
lines = file.readlines()
for l in lines:
    metar = Metar.Metar(l)
    blade += '<div class="metar text-left col-md-6"><h4>' + metar.station_id + '</h4> at ' + metar.time.strftime('%H:%M') + 'Z <b>Altimeter:</b> ' + metar.press.string() + '</p>' + \
        '<p><b>Wind:</b> ' + metar.wind('mph') + ', <b>Visibility:</b> ' + metar.visibility('SM') + '</p>' + \
        '<p><b>Sky:</b> ' + metar.sky_conditions('; ') + ', <br><b>Temp:</b> ' + metar.temp.string() + ', <b>Dewpoint:</b> ' + metar.dewpt.string() + '</p></div>\r\n'
template.write(blade)
file.close()
template.close()
