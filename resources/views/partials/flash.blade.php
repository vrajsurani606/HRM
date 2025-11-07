@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.success(@json(session('success')));
  });
</script>
@endif
@if(session('status'))
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.success(@json(session('status')));
  });
</script>
@endif
@if(session('error'))
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.error(@json(session('error')));
  });
</script>
@endif
@if($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', function(){
    toastr.error('Please fix the highlighted errors.');
  });
</script>
@endif
