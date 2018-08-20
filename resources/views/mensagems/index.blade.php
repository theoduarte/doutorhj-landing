@extends('layouts.base')

@section('title', 'DoutorHJ: Notificações')

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
                    <a href="#" class="list-group-item b-0 active"><i class="fa fa-download m-r-10"></i>Caixa de Entrada <b class="ml-1">({{ sizeof($total_notificacoes) }})</b></a>
                    <!-- <a href="#" class="list-group-item b-0"><i class="fa fa-star-o m-r-10"></i>Starred</a> -->
                    <a href="#" class="list-group-item b-0"><i class="fa fa-file-text-o m-r-10"></i>Visualizadas <b class="ml-1">(20)</b></a>
                    <!-- <a href="#" class="list-group-item b-0"><i class="fa fa-paper-plane-o m-r-10"></i>Sent Mail</a> -->
                    <a href="#" class="list-group-item b-0"><i class="fa fa-trash-o m-r-10"></i>Excluída(a) <b class="ml-1">(354)</b></a>
                </div>


                <h4 class="font-18 m-t-40">Marcadores</h4>

                <div class="list-group b-0 mail-list">
                    <a href="#" class="list-group-item b-0"><span class="fa fa-circle text-info m-r-10"></span>Contato Doutor Hoje</a>
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

            <div class="card-box p-1 m-t-20">
                <div class="panel-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mails m-0">
                            <tbody>
                            @foreach( $mensagems as $msg )
                            <tr class="unread">
                                <td class="mail-select">
                                    <div class="checkbox checkbox-primary m-r-15">
                                        <input id="checkbox1" type="checkbox">
                                        <label for="checkbox1"></label>
                                    </div>

                                    <i class="fa fa-star m-r-15 text-muted"></i>

                                    <i class="fa fa-circle m-l-5 text-warning"></i>
                                </td>

                                <td>
                                    <a href="ver-notificacoes/{{ $msg->id }}" class="email-name">{{$msg->rma_nome}}</a>
                                </td>

                                <td class="hidden-xs">
                                    <a href="ver-notificacoes/{{ $msg->id }}" class="email-msg">{{$msg->assunto}} @if($msg->visualizado) <span class="badge label-table badge-primary"> Lido </span> @else <span class="badge label-table badge-success"> Não Lido </span> @endif</a>
                                </td>
                                <td style="width: 20px;">
                                    @switch($msg->tipo_destinatario)
                                		@case('DH') Administrativo DoctorHoje @break;
                                		@case('PC') Paciente @break;
                                		@case('CN') Responsável Clinica (Prestador) @break;
                                		@case('PF') Profissional @break;
                                		@case('UC') Usuário comum sem relacionamento @break;
                                	@endswitch
                                </td>
                                <td class="text-right">
                                    {{$msg->created_at}}
                                </td>
                            </tr>
                            
                            <!-- <tr class="acaoVisualizar" id="{{$msg->id}}">
                            	<td>{{$msg->created_at}}</td>
                                <td>{{$msg->assunto}} @if($msg->visualizado) <span class="badge label-table badge-primary"> Lido </span> @else <span class="badge label-table badge-success"> Não Lido </span> @endif</td>
                                <td>{{$msg->rma_nome}}</td>
                                <td>{{$msg->rma_email}}</td>
                                <td>
                                	
                                	
                                	</td>
                                <td>{!! $msg->conteudo !!}</td>
                                <td>
                                	<span class="badge label-table badge-primary">
                                		Lido
                                	</span>
                                </td>
                            </tr> -->
                            @endforeach


                            </tbody>
                        </table>
                    </div>

                </div> <!-- panel body -->
            </div> <!-- panel -->

            <div class="row m-b-20">
                <div class="col-7">
                    <span class="text-primary">
            			{{ sprintf("%02d", $mensagems->total()) }} Registro(s) encontrado(s) e {{ sprintf("%02d", $mensagems->count()) }} Registro(s) exibido(s)
            		</span>
            		{!! $mensagems->links() !!}
                </div>
                <div class="col-5">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-sm btn-secondary waves-effect"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" class="btn btn-sm btn-secondary waves-effect"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

        </div> <!-- end Col-9 -->

    </div>

@endsection