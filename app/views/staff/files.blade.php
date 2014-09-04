@extends('layouts.master')
@section('title')
ZBW File Management
@stop
@section('content')
  <h1 class="text-center">ZBW File Management</h1>
  <div class="col-md-6">
    <h3 class="text-center">Current Files</h3>
    <table class="table">
      <thead>
        <tr>
          <th>File Name</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
      @foreach($files as $file)
        <tr>
          <td>{{ $file->getFilename() }}</td>
          <td><a href="{{route('staff.files.delete', $file->getFilename())}}"><span class="red halflings remove"></span></a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="col-md-6">
    <h3 class="text-center">Upload New File</h3>
    <form action="" method="post">
      <label for="files">Files</label>
      <p>Uploading a file of the same name <strong>will</strong> overwrite the existing file.</p>
      <div class="form-group">
          {{ Form::file('image1', ['class' => 'file-control btn btn-default', 'title' => 'Browse for File 1']) }}
          {{ Form::file('image2', ['class' => 'file-control btn btn-default', 'title' => 'Browse for File 2']) }}
          {{ Form::file('image3', ['class' => 'file-control btn btn-default', 'title' => 'Browse for File 3']) }}
          {{ Form::file('image4', ['class' => 'file-control btn btn-default', 'title' => 'Browse for File 4']) }}
      </div>
      <button type="submit" class="btn btn-success">Upload</button>
    </form>
  </div>
@stop
