@extends('layouts.master')
@section('title')
Training Outline
@stop
@section('content')
<h3 class="text-center">vZBW ARTCC Training</h3>
<p class="small"><i>Please note: Some links may be broken. All training and exam requests should be managed through the training manager (click on your initials at the top right)</i></p>
<h4 class="text-center">Quick Reference</h4>
<p>Most of the following documents are linked to throughout this page, however they are presented here for quick reference</p>
<div class="row">
<div class="col-md-3">
  <h4>SOPs</h4>
  <ul>
    <li>{{ HTML::linkAsset('/documents/sops/intro.pdf', 'Intro', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/general.pdf', 'General', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/kbos.pdf', 'KBOS', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/a90.pdf', 'A90/Boston', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/cape.pdf', 'K90/Cape', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/kpvd.pdf', 'G90/KPVD', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/kbdl.pdf', 'Y90/KBDL', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/kalb.pdf', 'KALB', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/sops/ctr.pdf', 'Center', ['target' => '_blank']) }}</li>
  </ul>
</div>
<div class="col-md-6">
  <h4>Syllabi and OTS Standards</h4>
  <ul>
    <li>{{ HTML::linkAsset('/documents/training/syllabus_s1.pdf', 'S1 Syllabus', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/training/syllabus_s2.pdf', 'S2 Syllabus', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/training/syllabus_s3.pdf', 'S3 Syllabus', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/training/syllabus_c1.pdf', 'C1 Syllabus', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWS1OTS.pdf", 'Class C/D Delivery/Ground Certification OTS Standards', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWBGND.pdf", 'Class B DEL/GND Certification OTS Standards', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWCTWR.pdf", 'Class C/D Tower Certification OTS Standards', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWBTWR.pdf", 'Class B Tower Certification OTS Standards', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWCAPP.pdf", 'Class C Approach Certification OTS Standards', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWBAPP.pdf", 'Class B Approach Certification OTS Standards', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset("/documents/training/ZBWCTROTS.pdf", 'Center Controller OTS Standards', ['target' => '_blank']) }}</li>
  </ul>
</div>
<div class="col-md-3">
  <h4>Reference Information</h4>
  <ul>
    <li>{{ HTML::linkAsset('/documents/reference/new_controller_info.pdf', 'New Controller Info', ['target' => '_blank']) }}</li>
  </ul>
</div>
</div>
<h4 class="text-center">Training Outline</h4>

<p>The vZBW Training Program is a comprehensive program which not only teaches you the fundamentals of virtual Air Traffic Control, but also teaches you how to work out practical problems on your own. During the course of instruction, you'll be constantly challenged at each stage, but the training staff is always available to provide guidance and help you along the way towards your goals.</p>
<p>To begin your training after you've become a member of the vZBW Team and when you are ready, you may request the vZBW SOP exam through <a href="http://www.bostonartcc.net/training">THIS FORM</a> to request the automated vZBW SOP exam. This exam is designed to see if you have followed the instructions in your welcome letter, read the pertinent information you were directed to, and are able to research the answers to basic questions specific to vZBW from our website, including forums as well as the VATSIM Code of Conduct and/or Code of Regulations. You must pass this exam (and all other exams) with a grade of 80% or greater in order to continue to the next step in the training program. A failing grade will result a 7 day waiting period to correct and relearn the material before you can reapply to take the exam.</p>
<p>The program is divided into 4 separate training syllabi. They are:</p>
  <p>{{ HTML::linkAsset('/documents/training/syllabus_s1.pdf', 'Ground Controller (S1)') }}</p>
  <p>{{ HTML::linkAsset('/documents/training/syllabus_s2.pdf', 'Tower Controller (S2)') }}</p>
  <p>{{ HTML::linkAsset('/documents/training/syllabus_s3.pdf', 'Approach Controller (S3)') }}</p>
  <p>{{ HTML::linkAsset('/documents/training/syllabus_c1.pdf', 'En-route/Center Controller (C1)') }}</p>

<p>Within the syllabi, you may progress through various certification levels which build upon previous certifications you've earned and material you've learned. These certification levels are:</p>
<ul>
<li>Delivery/Ground Controller</li>
<li>Tower Controller</li>
<li>Approach Controller</li>
<li>Center/Enroute Controller</li>
</ul>

<p>At your discretion, you may choose to enroll in the Minor Track or the Major Track.  The Major Track allows you to control our Major airfields and/or airspace. Currently, Boston (KBOS/A90) is our only airfield/airspace designated as Major.</p>
<ul>
  <li>In the Minor Track, students earn their certification for each position at the Class C/D level. For example, once earning Class C/D Delivery/Ground certification, the student would then skip the Advanced (Class B) portion of the Delivery/Ground Controller (S1) Syllabus, and proceed on to the Tower Controller (S2) Syllabus</li>
  <li>In the Major Track, students earn their certification for each position at the Class C/D level and then continue on to earn their certification at each position at the Class B/Major level. For example, once earning Class C/D Delivery/Ground certification, the student would then continue on to the Advanced (Class B) portion of the Delivery/Ground Controller (S1) Syllabus.</li>
  <li>Students enrolled in the Minor Track who have already achieved certifications desiring to enter the Major Track may do so by retroactively going back and &quot;catching up&quot; by earning Class B/Major Certifications for any position up to the student's current rating/certification level. For example, a Class C/D certified Approach Controller decides to switch to the Major Track. The student would have to go back to and complete the Advanced (Class B) portion of the Delivery/Ground Controller (S1) Syllabus, the Tower Controller (S2) Syllabus, and could then proceed on to the Advanced (Class B) Approach certification.</li>
</ul>
<p>The training program is very self-learning centered. As you can see in the above-linked syllabi, all of the required reference material is provided, and students are expected to "dig into the books" to find the answers to questions. Once any required written tests are successfully completed, the student will then work with a training staff member on their certifications. This proven design ensures that a student has a solid foundation in the theory, before working on practical application.</p>
<p>In order to take vZBW's online exams you will need to go to the <a href="http://www.vatusa.net/test.php">VATUSA Exam Center</a> and use your VATSIM CID and password to complete the exams.
<p>
<h4 class="text-center">The Testing Process</h4>

<p><strong>Online Exams</strong></p>
<p>There are many complicated and intricate details that an Air Traffic Controller must fully understand in order to be both successful and efficient. In order to be sure that our students are on the right path to success, they must pass a series of online tests before they begin practicing an online position under supervision. This ensures that the students have the appropriate background knowledge to understand the experience they'll have and situations they'll face online. All of the exam questions are based on fundamental concepts which a student needs to know. They are so important that students are required to correct any questions they get wrong, regardless if they pass or fail the exam. After completing an exam, the student is required to submit their corrections in the Test Corrections forum in the following format:</p>
<ul>
<li>Each question they answered incorrectly</li>
<li>The correct answer</li>
<li>An explanation of the answer in enough detail to convey a solid understanding</li>
<li>A reference to the source where they received the information. Eg. Boston Tower SOP, 7110.65 Chapter 2 Section 2-1-2. etc</li>
</ul>

<p>If an instructor feels a student's cumulative online test performance is not satisfactory (even with passing scores), that instructor, in consultation with the TA, will require the student to retake any of the ZBW exams.</p>

<p><strong>Over-The-Shoulder (OTS) Exams and Position Certification</strong></p>

<p>After the student passes all of their online exams and has worked with a mentor enough to become proficient at a particular position, the student will be given an Over-The-Shoulder (OTS) exam. As the description alludes, this exam is <strong>unannounced</strong>. Mentors and Instructors can evaluate a student's performance at any time and when they feel the student has demonstrated an adequate level of performance for a position, they will be granted certification at that position. This is done to prevent the student from feeling pressured during an exam.</p>
<p>OTS Standards are publicly available so that students know exactly what is expected of them to successfully pass an OTS. The OTS standards are:</p>
<ul>
  <li>{{ HTML::linkAsset("/documents/training/ZBWS1OTS.pdf", 'Class C/D Delivery/Ground Certification OTS Standards') }}</li>
  <li>{{ HTML::linkAsset("/documents/training/ZBWBGND.pdf", 'Class B DEL/GND Certification OTS Standards') }}</li>
  <li>{{ HTML::linkAsset("/documents/training/ZBWCTWR.pdf", 'Class C/D Tower Certification OTS Standards') }}</li>
  <li>{{ HTML::linkAsset("/documents/training/ZBWBTWR.pdf", 'Class B Tower Certification OTS Standards') }}</li>
  <li>{{ HTML::linkAsset("/documents/training/ZBWCAPP.pdf", 'Class C Approach Certification OTS Standards') }}</li>
  <li>{{ HTML::linkAsset("/documents/training/ZBWBAPP.pdf", 'Class B Approach Certification OTS Standards') }}</li>
  <li>{{ HTML::linkAsset("/documents/training/ZBWCTROTS.pdf", 'Center Controller (C1) OTS Standards') }}</li>

</ul>

<p>These standards are provided as a guide for the level of proficiency students will be required to demonstrate for certification. However, it should be reiterated that OTSs are only administered when an instructor or mentor feels a student is proficient enough for certification.</p>

<h4 class="text-center">Step-By-Step Process</h4>

<p><strong>Ground Controller</strong></p>
<ol>
<li>Student reviews ZBW website and ZBW Controller forums, including all policies and procedures.</li>
<li>Student submits an exam request <a href="http://www.bostonartcc.net/training"><b>HERE</b></a> requesting the SOP exam.</li>
<li>Student passes SOP exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
<li>Student studies the Delivery/Ground Controller (S1) Syllabus studying sections 1-7.</li>
<li>Student takes and passes the DEL/GND exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
<li>Student is now eligible to begin training with a mentor or instructor. </li>
<li>After passing a vZBW Class C/D DEL/GND OTS, the VATUSA Ground Controller (S1)  exam will be assigned. </li>
<li>Student takes and passes the  VATUSA S1 exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the rating of Ground Controller (S1) may be awarded, and the controller will then be certified as a Class C/D Delivery/Ground controller.</li>

<p>If the Student chooses to enroll in the Major track, then proceed to Step 9.  Otherwise, proceed to <strong>Tower Controller</strong>.</p>

  <li>After obtaining a Class C/D Delivery/Ground certification, the student studies the Class B Delivery/Ground section of the S1 syllabus,  takes and passes the Advanced Delivery/Ground exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
  <li>The student then successfully takes and passes KBOS familiarization training with a mentor or instructor. Upon approval from the mentor or instructor, the student is now eligible to control KBOS at the DEL/GND level during off-peak times.</li>
  <li>Student is now eligible to begin training online with a mentor or instructor and, upon passing an OTS, earn the Class B DEL/GND certification.</li>
</ol>
<p>&nbsp;</p>
<p><strong>Tower Controller</strong></p>
<ol>
  <li>Student studies the Tower Controller (S2) syllabus, takes and passes the Local Control exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
  <li>Student is now eligible to begin training with a mentor or instructor.</li>
  <li>After passing a vZBW Class C Tower OTS, the VATUSA Tower Controller (S2) exam will be assigned. </li>
  <li>Upon successful completion of the VATUSA Tower Controller (S2) exam, the rating of Tower Controller (S2) may be awarded, and the controller will then be certified as a Class C/D Tower controller.</li>
  <p>If the Student chooses to enroll in the Major track. then proceed to Step 5.  Otherwise, proceed to <strong>Approach Controller</strong>.</p>
  <li>After obtaining a Class C/D Tower certification, the student studies the Class B Tower section of the S2 syllabus,  takes and passes the Advanced Local exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
  <li>The student then successfully takes and passes KBOS familiarization training with a mentor or instructor. Upon approval from the mentor or instructor, the student is now eligible to control KBOS at the Tower level during off-peak times.</li>
  <li>Student is now eligible to begin training online with a mentor or instructor and, upon passing an OTS, earn the Class B Tower certification.</li>
</ol>
<p>&nbsp;</p>
<p><strong>Approach Controller</strong></p>
<ol>
  <li>Student studies the Approach Controller (S3) syllabus, takes and passes the Approach Control exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
  <li>Student is now eligible to begin training with a mentor or instructor. </li>
  <li>After passing a vZBW Class C Approach OTS, the VATUSA Approach Controller (S3) exam will be assigned. </li>
  <li>Upon successful completion of the VATUSA Approach Controller (S3) exam, the rating of Approach Controller (S3) may be awarded and the controller will then be certified as a Class C Approach controller.</li>
  <p>If the Student chooses to enroll in the Major track. then proceed to Step 5.  </p>
  <li>After obtaining a Class C Approach certification, the student studies the Class B Approach section of the S3 syllabus,  takes and passes the Advanced Approach exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
  <li>The student then successfully takes and passes A90 familiarization training with a mentor or instructor. The student is now eligible to control A90 at the Approach level during off-peak times.</li>
  <li>Student is now eligible to begin training online with a mentor or instructor and, upon passing an OTS, earns the Class B Approach certification.</li>
</ol>
<p>&nbsp;</p>
<p><strong>Center/Enroute Controller</strong></p>
<ol>
  <li>After obtaining a Class B Approach certification the student studies the Center/Enroute Controller (C1) syllabus, takes and passes the Center/Enroute Control exam with an 80% or better, posts corrections to the <a href="http://www.bostonartcc.net/forum/index.php?board=11.0">forums</a>, and reviews the corrections with a mentor or instructor on the forum. Once the mentor or instructor approves the corrections as successfully completed, the Student may continue.</li>
  <li>Student is now eligible to begin training with a mentor or instructor. </li>
  <li>After passing a vZBW Center Controller (C1) OTS, the VATUSA Center/Enroute Controller (C1) exam will be assigned. Upon successful completion of the VATUSA Center/Enroute Controller (C1) exam, the rating of Center/Enroute Controller (C1) may be awarded.</li>
  <li>The student is now eligible to control ZBW at the Center/Enroute level during off-peak times.</li>
  <li>Student continues training online with an instructor and, upon passing an OTS, earns the Center/Enroute certification.</li>
</ol>
<p>The process may be found in checklist form <a target="_blank" href="/documents/training/training_checklist.pdf">here</a>.</p>
<p><br />
</p>
<p><strong>Mentor/Instructor</strong></p>
<ol>
  <li>At the discretion of the TA and ATM.</li>
</ol>
@stop
