import urllib2

base = 'http://metar.vatsim.net/metar.php?id='
airports = ['KBOS', 'KPWM', 'KPVD', 'KBDL', 'KBTV', 'KMHT']
metars = []
for code in airports:
    text = urllib2.urlopen(base + code + '\r\n')
    metars.append(text.read())

feed = open('../feeds/metar.txt', 'w')
for m in metars:
    feed.write(m)
