@extends('web.layouts.app')
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')
<form id="submit" action="/api/event/groupon" method="post"  enctype="multipart/form-data">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="imag">
    <input type="text" class="form-control" name="product[1][name]">
    <input type="text" class="form-control" name="product[1][price]">
    <input type="text" class="form-control" name="product[1][quantity]">
    <input type="text" class="form-control" name="product[2][name]">
    <input type="text" class="form-control" name="product[2][price]">
    <input type="text" class="form-control" name="product[2][quantity]">
    <button type="button" class="btn">提交</button>
</form>
@endsection
@section('script')
<script>
$('.btn').click(function(){
    $('#submit').submit();
})
</script>
@endsection
