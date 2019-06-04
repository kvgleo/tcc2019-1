@extends('adm.template.main')

@section('main-content')
<div class="row">
  <div class="col-md-2">2</div>
  <div class="col-md-8">8</div>
  <div class="col-md-9">2</div>
  
</div>
@endsection
@section('js-content')
<script>
  $(function() {
    $('#dashboard').addClass('btn-danger');
  });
</script>
@endsection