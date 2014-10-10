@extends('layouts.master')
@section('title')
ZBW Documents
@stop
@section('content')
<h1 class="text-center">ZBW Document Library</h1>
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
    <li>{{ HTML::linkAsset('/documents/loas/ny.pdf', 'ZNY LOA', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/loas/cle.pdf', 'ZOB LOA', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/loas/dc.pdf', 'ZDC LOA', ['target' => '_blank']) }}</li>
    <li>{{ HTML::linkAsset('/documents/loas/zbwyul20090408.pdf', 'YUL LOA', ['target' => '_blank']) }}</li>
  </ul>
</div>
</div>
@stop
