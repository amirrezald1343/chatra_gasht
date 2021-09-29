@extends('errors::minimal')

@section('title', __('Not Found'))

@section('message')

<h2>
404
</h2>

<p>صفحه مورد نظر یافت نشد</p>
<p style="color:green; direction: rtl"> در حال انتقال به صفحه اصلی  . . .  </p>

<br>
@endsection



<script>

setTimeout(function(){
        window.location.href="/"
},4000);

</script>

