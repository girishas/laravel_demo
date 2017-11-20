@if (Session::has('message'))
    <div class="flash-message success-msg">{{ Session::get('message') }}</div>
@elseif (Session::has('errormessage'))
    <div class="flash-message failure-msg">{{ Session::get('errormessage') }}</div>
@endif
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.flash-message').delay(3000).fadeOut();
	});
</script>