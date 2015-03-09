@extends('layouts.master')
@section('title')
ZBW Documents
@stop
@section('content')
<h1 class="text-center">ZBW Document Library</h1>
<div class="row">
<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">SOPs</div>
    <div class="panel-body">
    <div class="list-group">
        {{ HTML::linkAsset('/documents/sops/intro.pdf', 'Intro', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/general.pdf', 'General', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/kbos.pdf', 'KBOS', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/a90.pdf', 'A90/Boston', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/cape.pdf', 'K90/Cape', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/kpvd.pdf', 'KPVD', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/kbdl.pdf', 'Y90/KBDL', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/kalb.pdf', 'KALB', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/ksyr.pdf', 'KSYR', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/kbtv.pdf', 'KBTV', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/kbgr.pdf', 'KBGR', ['class' => 'list-group-item', 'target' => '_blank']) }}
        {{ HTML::linkAsset('/documents/sops/ctr.pdf', 'Center', ['class' => 'list-group-item', 'target' => '_blank']) }}
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">Syllabi and OTS Standards</div>
    <div class="panel-body">
        <div class="list-group">
          {{ HTML::linkAsset('/documents/training/syllabus_s1.pdf', 'S1 Syllabus', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/training/syllabus_s2.pdf', 'S2 Syllabus', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/training/syllabus_s3.pdf', 'S3 Syllabus', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/training/syllabus_c1.pdf', 'C1 Syllabus', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWS1OTS.pdf", 'Class C/D Delivery/Ground Certification OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWBGND.pdf", 'Class B DEL/GND Certification OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWCTWR.pdf", 'Class C/D Tower Certification OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWBTWR.pdf", 'Class B Tower Certification OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWCAPP.pdf", 'Class C Approach Certification OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWBAPP.pdf", 'Class B Approach Certification OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset("/documents/training/ZBWCTROTS.pdf", 'Center Controller OTS Standards', ['class' => 'list-group-item', 'target' => '_blank']) }}
        </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">Reference Information</div>
    <div class="panel-body">
      <div class="list-group">
          {{ HTML::linkAsset('/documents/reference/new_controller_info.pdf', 'New Controller Info', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/loas/ny.pdf', 'ZNY LOA', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/loas/cle.pdf', 'ZOB LOA', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/loas/dc.pdf', 'ZDC LOA', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ HTML::linkAsset('/documents/loas/zbwyul20090408.pdf', 'YUL LOA', ['class' => 'list-group-item', 'target' => '_blank']) }}
        </div>
    </div>
  </div>
</div>
</div>
@stop
