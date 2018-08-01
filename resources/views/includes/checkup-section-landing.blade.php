<div id="checkup" class="area-checkup">
    <div class="container">
        <div class="selo">
            <img src="/libs/home-template/img/ckp-selo.png" alt="">
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="pacote-checkup">
                    <div class="resumo">
                        <div class="textos">
                            <h3>{{ $checkupMasculino->titulo }}</h3>
                            <p class="qtde-procedimentos">{{ $checkupMasculino->itemCheckups->count('id') }} Procedimentos</p>
                            <ul>
                                @foreach( $checkupMasculinoSummary as $summary )
                                <li>
                                    <p><strong>{{ $summary->qty }} {{ $summary->ds_atendimento }}:</strong> {{ $summary->especialidade }}</p>
                                </li>

                                @endforeach
                            </ul>
                        </div>
                        <div class="valor">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="vlr-mercado"><strike>R$ {{ number_format( $checkupMasculino->itemCheckups->sum('vl_mercado'),  2, ',', '.')  }}</strike></p>
                                    <p>valor de mercado</p>
                                </div>
                                <div class="col-md-3">
                                    <p class="txt-auxiliar">a partir de</p>
                                </div>
                                <div class="col-md-5">
                                    <p class="vlr-drhj">R$ {{ number_format( $checkupMasculino->itemCheckups->sum('vl_com_checkup'),  2, ',', '.')  }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="area-btn">
                        <a href="/resultado-checkup?tipo_atendimento=checkup&tipo_especialidade={{ $checkupMasculino->id }}&local_atendimento=TODOS&endereco_id="><button type="button" class="btn btn-agendar-plano-1">Agendar</button></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="pacote-checkup">
                    <div class="resumo">
                        <div class="textos">
                            <h3>{{ $checkupFeminino->titulo }}</h3>
                            <p class="qtde-procedimentos">{{ $checkupFeminino->itemCheckups->count('id') }} Procedimentos</p>
                            <ul>
                                @foreach( $checkupFemininoSummary as $summary )
                                <li>
                                    <p><strong>{{ $summary->qty }} {{ $summary->ds_atendimento }}:</strong> {{ $summary->especialidade }}</p>
                                </li>

                                @endforeach
                            </ul>
                        </div>
                        <div class="valor">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="vlr-mercado"><strike>R$ {{ number_format( $checkupFeminino->itemCheckups->sum('vl_mercado'),  2, ',', '.')  }}</strike></p>
                                    <p>valor de mercado</p>
                                </div>
                                <div class="col-md-3">
                                    <p class="txt-auxiliar">a partir de</p>
                                </div>
                                <div class="col-md-5">
                                    <p class="vlr-drhj">R$ {{ number_format( $checkupFeminino->itemCheckups->sum('vl_com_checkup'),  2, ',', '.')  }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="area-btn">
                        <a href="/resultado-checkup?tipo_atendimento=checkup&tipo_especialidade={{ $checkupFeminino->id }}&local_atendimento=TODOS&endereco_id="><button type="button" class="btn btn-agendar-plano-2">Agendar</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>