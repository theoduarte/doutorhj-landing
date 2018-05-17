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

	$.Notification.notify('info', 'top right', 'DoctorHJ Informa!', '{{ $message }}');
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