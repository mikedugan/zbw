
file = open('../feeds/metar.txt', 'r')
lines = file.readlines()
blade = ""

for s in lines:
    segs = s.split(' ')
    temp = segs[5].split('/')[0].replace('M','-')
    dpt = segs[5].split('/')[1].replace('M','-')
    alt = segs[6].replace('A','')
    blade += '<div class="metar text-left col-md-6"><h4>' + segs[0] + '</h4> at ' + segs[1] + ' <b>Altimeter:</b> ' + alt + '</p>' + \
        '<p><b>Wind:</b> ' + segs[2] + ', <b>Visibility:</b> ' + segs[3] + '</p>' + \
        '<p><b>Sky:</b> ' + segs[4] + ', <b>Temp:</b> ' + temp + ', <b>Dewpoint:</b> ' + dpt + '</p></div>\r\n'
template = open('../../views/includes/bj/_metar.blade.php', 'w')
template.write(blade)
file.close()
template.close()


