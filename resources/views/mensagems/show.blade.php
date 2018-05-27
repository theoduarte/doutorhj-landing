@extends('layouts.base')

@section('title', 'DoctorHj: Notificações')

@push('scripts')

@endpush

@section('content')

<script>
    $(window).on('load', function(){
        
        /* $('#notificacoes').footable(); */
		
        $('.acaoVisualizar').click('click', function(e){
            $.ajax({
                url : "/notificacoes/visualizado/"+$(this).attr('id'),
                dataType: "json",
                success: function(data) {
                    response(data);
                }
            });
        });
    });
</script>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="page-title-box">
				<h4 class="page-title">Notificações</h4>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="row">

    <!-- Left sidebar -->
    <div class="col-xl-2 col-lg-2">

        <div class="p-20">
            <a href="#" class="btn btn-danger btn-rounded btn-custom btn-block waves-effect waves-light not-active">Escrever</a>

            <div class="list-group mail-list  m-t-20">
                <a href="/notificacoes" class="list-group-item b-0 active"><i class="fa fa-download m-r-10"></i>Caixa de Entrada <b class="ml-1">({{ sizeof($total_notificacoes) }})</b></a>
                <!-- <a href="#" class="list-group-item b-0"><i class="fa fa-star-o m-r-10"></i>Starred</a> -->
                <a href="#" class="list-group-item b-0"><i class="fa fa-file-text-o m-r-10"></i>Visualizadas <b class="ml-1">(20)</b></a>
                <!-- <a href="#" class="list-group-item b-0"><i class="fa fa-paper-plane-o m-r-10"></i>Sent Mail</a> -->
                <a href="#" class="list-group-item b-0"><i class="fa fa-trash-o m-r-10"></i>Excluída(a) <b class="ml-1">(354)</b></a>
            </div>


            <h4 class="font-18 m-t-40">Marcadores</h4>

            <div class="list-group b-0 mail-list">
                <a href="#" class="list-group-item b-0"><span class="fa fa-circle text-info m-r-10"></span>Contato DoctorHoje</a>
                <a href="#" class="list-group-item b-0"><span class="fa fa-circle text-warning m-r-10"></span>Atendimento Confirmado</a>
                <a href="#" class="list-group-item b-0"><span class="fa fa-circle text-purple m-r-10"></span>Atendimento Cancelado</a>
                <a href="#" class="list-group-item b-0"><span class="fa fa-circle text-pink m-r-10"></span>Promoções/Descontos</a>
                <a href="#" class="list-group-item b-0"><span class="fa fa-circle text-success m-r-10"></span>Novidades</a>
            </div>

        </div>

    </div>
    <!-- End Left sidebar -->

    <!-- Right Sidebar -->
    <div class="col-xl-10 col-lg-10">

        <div class="row">
            <div class="col-lg-12">
                <div class="btn-toolbar m-t-20" role="toolbar">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary waves-effect waves-light "><i class="fa fa-inbox"></i></button>
                        <button type="button" class="btn btn-primary waves-effect waves-light "><i class="fa fa-exclamation-circle"></i></button>
                        <button type="button" class="btn btn-primary waves-effect waves-light "><i class="fa fa-trash-o"></i></button>
                    </div>
                    <div class="btn-group ml-1">
                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-folder"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">Dropdown One</a>
                            <a class="dropdown-item" href="#">Dropdown Two</a>
                            <a class="dropdown-item" href="#">Dropdown Three</a>
                            <a class="dropdown-item" href="#">Dropdown Four</a>
                        </div>
                    </div>
                    <div class="btn-group ml-1">
                        <button type="button" class="btn btn-primary waves-effect waves-light  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-tag"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">Dropdown One</a>
                            <a class="dropdown-item" href="#">Dropdown Two</a>
                            <a class="dropdown-item" href="#">Dropdown Three</a>
                            <a class="dropdown-item" href="#">Dropdown Four</a>
                        </div>
                    </div>

                    <div class="btn-group ml-1">
                        <button type="button" class="btn btn-primary waves-effect waves-light  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Ver Mais
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">Dropdown One</a>
                            <a class="dropdown-item" href="#">Dropdown Two</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End row -->


        <div class="row">
            <div class="col-sm-12">
                <div class="card-box m-t-20">
                    <h4 class="m-t-0 font-18"><b>{{ $mensagem->mensagem->assunto }}</b></h4>

                    <hr/>

                    <div class="media m-b-30">
                        <img class="d-flex mr-3 rounded-circle thumb-sm" src="@if($remetente == null) /files/users/default.png @else /files/{{ $remetente->avatar }} @endif" alt="Avatar" style="width: 50px;">
                        <div class="media-body">
                            <span class="media-meta pull-right">{{ $mensagem->mensagem->created_at }}</span>
                            <h4 class="text-primary font-16 m-0">{{ $mensagem->mensagem->rma_nome }}</h4>
                            <small class="text-muted">Remetente: {{ $mensagem->mensagem->rma_email }}</small>
                        </div>
                    </div>
                    
                    {!! $mensagem->mensagem->conteudo !!}
                    
                    <hr/>

                    <!-- <h4 class="font-16"> <i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments <span>(3)</span> </h4>

                    <div class="row">
                        <div class="col-sm-2 col-xs-4">
                            <a href="#"> <img src="assets/images/small/img1.jpg" alt="attachment" class="img-thumbnail img-responsive"> </a>
                        </div>
                        <div class="col-sm-2 col-xs-4">
                            <a href="#"> <img src="assets/images/small/img2.jpg" alt="attachment" class="img-thumbnail img-responsive"> </a>
                        </div>
                        <div class="col-sm-2 col-xs-4">
                            <a href="#"> <img src="assets/images/small/img3.jpg" alt="attachment" class="img-thumbnail img-responsive"> </a>
                        </div>
                    </div> -->
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="media m-b-0">
                    <!-- <a href="#" class="pull-left">
                        <img alt="" src="assets/images/users/avatar-9.jpg" class="media-object thumb-sm img-circle">
                    </a>
                    <div class="media-body">
                        <div class="card-box">
                            <div class="summernote">
                                <h6>This is an Air-mode editable area.</h6>
                                <ul>
                                    <li>
                                        Select a text to reveal the toolbar.
                                    </li>
                                    <li>
                                        Edit rich document on-the-fly, so elastic!
                                    </li>
                                </ul>
                                <p>
                                    End of air-mode area
                                </p>

                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="text-right">
                    <a onclick="history.back(-1)" href="javascript:void(0)" class="btn btn-primary waves-effect waves-light m-t-20"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a>
                </div>
            </div>
        </div>
        <!-- End row -->

    </div> <!-- end Col-9 -->

</div>
</div>

@endsection