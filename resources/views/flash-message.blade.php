<!-- NOTIFICATIONS -->
@if ($message = Session::get('success'))
<script type="text/javascript">
$(document).ready(function () {

	$.Notification.notify('success', 'top right', 'Solicitação Concluída!', '{{ $message }}');
});
</script>
@endif


@if ($message = Session::get('error'))
<script type="text/javascript">
$(document).ready(function () {

	$.Notification.notify('error','top right', 'Solicitação Falhou!', '{{ $message }}');
});
</script>
@endif

@if ($message = Session::get('warning'))
<script type="text/javascript">
$(document).ready(function () {

	$.Notification.notify('warning','top right', 'Atenção!', '{{ $message }}');
});
</script>
@endif

@if ($message = Session::get('info'))
<script type="text/javascript">
$(document).ready(function () {

	$.Notification.notify('info', 'top right', 'DoutorHJ Informa!', '{{ $message }}');
});
</script>
@endif

@if ($message = Session::get('cart'))
<script type="text/javascript">
$(document).ready(function () {

	$.Notification.notify('cart', 'top right', 'Solicitação Concluída!', '{{ $message }}');
});
</script>
@endif

<!-- ALERTS -->
@if ($message = Session::get('success-alert'))
<script type="text/javascript">
$(document).ready(function () {
    swal(
            {
                title: '<div class="tit-sweet tit-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Sucesso!</div>',
                text: '{{ $message }}'
            }
        );
    });
</script>
@endif


@if ($message = Session::get('error-alert'))
<script type="text/javascript">
$(document).ready(function () {
    swal(
        {
            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Ocorreu um erro</div>',
            text: '{{ $message }}'
        }
    );
});
</script>
@endif

@if ($message = Session::get('warning-alert'))
<script type="text/javascript">
$(document).ready(function () {
    swal(
        {
            title: '<div class="tit-sweet tit-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Atenção!</div>',
            text: '{{ $message }}'
        }
    );
});
</script>
@endif

@if ($message = Session::get('info-alert'))
<script type="text/javascript">
$(document).ready(function () {
    swal(
        {
            title: '<div class="tit-sweet tit-info"><i class="fa fa-info-circle" aria-hidden="true"></i> Informação</div>',
            text: '{{ $message }}.'
        }
    );
});
</script>
@endif

@if ($message = Session::get('erro-clear-storage'))
<?php
Illuminate\Support\Facades\Session::flush();
?>
<script type="text/javascript">
$(document).ready(function () {
	localStorage.clear();
	sessionStorage.clear();
	var cookies = document.cookie;

	for (var i = 0; i < cookies.split(";").length; ++i)
	{
		var myCookie = cookies[i];
		var pos = myCookie.indexOf("=");
		var name = pos > -1 ? myCookie.substr(0, pos) : myCookie;
		document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
	}

	$.Notification.notify('error','top right', 'Solicitação Falhou!', '{{ $message }}');
});
</script>
@endif

@if ($errors->any())
<script type="text/javascript">
$(document).ready(function () {
    swal(
        {
            title: '<div class="tit-sweet tit-error"><i class="fa fa-times-circle" aria-hidden="true"></i> Operação Falhou!</div>',
            text: 'Por favor, verifique sua operação e tente novamente.'
        }
    );
});
</script>
@endif