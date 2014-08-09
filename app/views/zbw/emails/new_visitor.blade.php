<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2 style="text-align:center">Welcome to Boston ARTCC</h2>
<div>
    <p>Dear {{ $user->first_name }},</p>
    <p>Welcome to ZBW! We would like to welcome you to one of the best ARTCCs
    around! This email contains your login information for the ZBW website and
     its services! Should you have a question, please don't hesitate to contact
     a staff member!</p>
</div>
<div>
    <p><b>Username:</b> {{ $user->username }}</p>
    <p><b>Operating Initials:</b> {{ $user->initials }}</p>
    <p><b>Registered CID: </b> {{ $user->cid }}</p>
    <p><b>Teamspeak Password: </b> garve</p>
    <p><b>Teamspeak Host: </b> ts3.bostonartcc.net</p>
    <p>Login to the ZBW website will require you to enter your VATSIM CID and password on the VATSIM website.</p>
</div>
<div>
  <p>ZBW prides itself on a high standard of excellence in our community. Check the website on appropriate reading resources prior to taking an exam.</p>
  <p>To ensure you are prepared for your ZBW training, please follow the following steps:</p>
  
  <p><b>Step 1:</b> Download VRC here: http://www1.metacraft.com/VRC/download.shtml</p>
  
  <p><b>Step 2:</b> Download the ZBW Sector Files for VRC <a href="http://www.bostonartcc.net/controllers/files">here</a></p>
  
  <b>Step 3:</b> Watch and follow the instructions given on these YouTube videos and set up your VRC accordingly: <a href="https://www.youtube.com/watch?v=v4X8T4w4d2s">Video 1</a> AND <a href="https://www.youtube.com/watch?v=tY7ssXmzTGA">Video 2</a>
  
  <b>Step 4:</b> Set up the ZBW Sweatbox (will be used during training). TO DO SO FOLLOW THESE STEPS:
  <ol>
    <li>Using a text editor (such as Notepad), create a new file in your <i><b>My Documents/VRC Directory</b></i> (not the VRC Program Directory) named <span style="color:blue">myservers.txt</span></li>
    <li>Add the following line to your text file: <span style="color:blue">sweatbox.vatsim.net SWEATBOX</span></li>
    <li>Save and exit.</li>
    <li>Open VRC and select your session profile.</li>
    <li>Under <span style="color:blue">File > Connect > Server:</span> select the <span style="color:blue">SWEATBOX</span> server</li>
    <li>Connect with an appropriate callsign (i.e. <span style="color:blue">ACK_S_DEL, PVD_S_TWR, BOS_S_APP</span>, etc).</li>
  </ol>
  <p><b>Step 5:</b> Have TeamSpeak 3 downloaded and have our server set up. You may access the ZBW TeamSpeak3 server at ts3.bostonartcc.net. The first time you log in on a new computer,
  you will need to log in with your teamspeak key (found in your profile settings on the website). The Teamspeak server password is "garve", without the quotes. This information is not to be
   given to anyone outside of ZBW without the explicit permission of the ATM, DATM, or TA. Violations are subject to disciplinary action.</p>
  
  <b>Step 6:</b> Familiarize yourself with KPWM and set up your VRC sector file accordingly, as this airport is our primary training facility. 
  
  On behalf of the instructors and mentors at ZBW, we look forward to training and controlling with you. Great job so far, good luck, and see you on the scopes soon!
</div>
<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>
