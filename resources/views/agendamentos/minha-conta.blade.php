@extends('layouts.base')

@section('title', 'DoctorHj: Minha Conta')

@push('scripts')

@endpush

@section('content')
    <section class="area-busca-interna minha-conta">
        <div class="container">
            {{--<div class="busca-home">
                <div class="titulo">
                    <span>Quero agendar</span>
                </div>
                <form action="/resultado" class="form-busca-home" method="get">
                    <div class="row">
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="tipo">Tipo de atendimento</label>
                            <select id="tipo_atendimento" class="form-control" name="tipo_atendimento">
                                <option value="" disabled selected hidden>Ex.: Consulta</option>
                                <option value="saude">Consulta Médica</option>
                                <!-- <option value="odonto">Consulta Odontológica</option> -->
                                <option value="exame">Exames</option>
                                <!-- <option value="procedimento">Procedimento</option> -->
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="especialidade">Especialidade ou exame</label>
                            <select id="tipo_especialidade" class="form-control select2" name="tipo_especialidade">
                                <option value="" disabled selected hidden>Ex.: Clínica Médica</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="local">Local de atendimento</label>
                            <select id="local_atendimento" class="form-control select2" name="local_atendimento">
                                <option value="" disabled selected hidden>Ex.: Asa Sul</option>
                            </select>
                            <i class="cvx-no-loading fa fa-spin fa-spinner"></i>
                            <input type="hidden" id="endereco_id" name="endereco_id">
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <button type="submit" class="btn btn-primary btn-vermelho">Pesquisar</button>
                        </div>
                    </div>
                </form>
            </div>--}}
            <div class="box-minha-conta">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 menu">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-cadastro" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-caret-right"></i>
                                Cadastro</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-pagamento" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-caret-right"></i>
                                Pagamento</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-anuidade" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-caret-right"></i>
                                Anuidade</a>
                            {{--<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-mensagens" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-caret-right"></i>
                                Mensagens</a>--}}
                            <a class="nav-link" id="v-pills-notifications-tab" data-toggle="pill" href="#v-pills-notificacoes" role="tab" aria-controls="v-pills-notifications" aria-selected="false"><i class="fa fa-caret-right"></i>
                                Notificações</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-sugestoes" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-caret-right"></i>
                                Deixe sua Sugestão</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-sair" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-caret-right"></i>
                                Sair</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-9 conteudo">
                        <div class="tab-content" id="v-pills-tabContent">

                            <!-- Cadastro -->

                            <div class="tab-pane fade show active" id="v-pills-cadastro" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 col-dados-cadastro">
                                        <span class="label-titulo">Cadastro</span>
                                        <form>
                                            <fieldset disabled>
                                                <div class="form-group">
                                                    <label for="inputNome">Nome</label>
                                                    <input type="text" id="inputNome" class="form-control" value="{{ $user_paciente->paciente->nm_primario.' '.$user_paciente->paciente->nm_secundario }}" placeholder="Nome completo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail">Email</label>
                                                    <input type="email" id="inputEmail" class="form-control" value="{{ $user_paciente->email }}" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputTelefone">Telefone</label>
                                                    <input type="text" id="inputTelefone" class="form-control" value="{{ $user_paciente->paciente->contatos->first()->ds_contato }}" placeholder="Telefone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="selectGenero">Gênero</label>
                                                    <select id="selectGenero" class="form-control">
                                                        <option @if( $user_paciente->paciente->cs_sexo == 'M') selected="selected" @endif>
                                                            Homem
                                                        </option>
                                                        <option @if( $user_paciente->paciente->cs_sexo == 'F') selected="selected" @endif>
                                                            Mulher
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group fc-tit-dn">
                                                    <label>Data de Nascimento</label>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <select id="selectDia" class="form-control">
                                                            @for($i = 1; $i < 32; $i++)
                                                                <option @if( $dt_nascimento[0] == $i) selected="selected" @endif >{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <select id="selectMes" class="form-control">
                                                            @for($i = 1; $i <= 12; $i++)
                                                                <option @if( $dt_nascimento[1] == $i) selected="selected" @endif >{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <select id="selectAno" class="form-control">
                                                            @for($i = date('Y'); $i >= (date('Y')-100); $i--)
                                                                <option @if( $dt_nascimento[2] == $i) selected="selected" @endif>{{ sprintf("%04d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                        <div>
                                            <a href="#" data-toggle="modal" data-target="#modalTermos">Termo de Uso</a>
                                            <div class="modal fade modal-termos" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle" style="color: #fff;">
                                                                Termos e Condições de Uso e Política de Segurança e
                                                                Privacidade</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><span>TERMOS E CONDIÇÕES – USUÁRIOS FINAIS</span></p>

                                                            <p>
                                                                <span>Condições gerais de cadastramento e contratação</span>
                                                            </p>
                                                            <p>1. O presente termo é firmado entre <strong>NEW SERVICE
                                                                    TECNOLOGY LTDA</strong> (DOCTOR HOJE), pessoa
                                                                jurídica de direito privado, sociedade empresária
                                                                limitada, inscrita no CNPJ/MF sob o nº
                                                                21.520.255/0001-55, com sede no SCS, Quadra 3, Bloco A,
                                                                nº 107, Sala 103, Ed. Antônia Alves Pereira de Sousa,
                                                                Brasília – DF, CEP: 70.303-907, proprietário e detentor
                                                                de todos os direitos da plataforma digital de sérvios
                                                                tecnológicos “DOCTOR HOJE”, e o USUÁRIO DOS SERVIÇOS,
                                                                ora denominado USUÁRIO.</p>
                                                            <p>2. Para utilizar os serviços da plataforma digital DOCTOR
                                                                HOJE, o USUÁRIO deverá acessar o site
                                                                <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>,
                                                                cadastrar e aceitar os termos e condições gerais e todas
                                                                as políticas e os princípios que o regem.</p>
                                                            <p><strong>3. Ao acessar o site e se cadastrar, o USUÁRIO
                                                                    manifesta plena aceitação em relação a todos os
                                                                    termos e às condições ora estabelecidas, assim como
                                                                    demais políticas disponibilizadas através desses
                                                                    canais, submetendo-se automaticamente às regras e
                                                                    condições aqui presentes e suas futuras
                                                                    atualizações.</strong></p>

                                                            <p><span>Conceitos</span></p>
                                                            <p>4. Para melhor entendimento deste Termo de Uso, DOCTOR
                                                                HOJE é o prestador do serviço tecnológico de agendamento
                                                                e pagamento de consultas e exames por meio de uma
                                                                plataforma digital que contém site e aplicativo mobile;
                                                                USUÁRIO é a pessoa física cadastrada no site que utiliza
                                                                a ferramenta tecnológica pra adquirir e agendar
                                                                consultas e exames; PRESTADOR, pessoa física ou
                                                                jurídica, devidamente contratada e cadastrada no site,
                                                                com registro no respectivo órgão de classe, que presta
                                                                serviços na área médica, odontológica ou paramédica (Ex:
                                                                psicologia, fisioterapia, fonoaudiologia e
                                                                nutrição).</p>

                                                            <p><span>Do acesso</span></p>
                                                            <p>5. Para acessar e utilizar o site do DOCTOR HOJE, o
                                                                USUÁRIO deverá ser juridicamente capaz, ter no mínimo 18
                                                                (dezoito) anos de idade e declarar que leu e aceitou
                                                                integralmente as condições deste Termo. Deverá fornecer
                                                                os seguintes dados: nome completo, e-mail, telefones
                                                                celular e fixo, CPF, data de nascimento. A cada novo
                                                                acesso será enviada senha pelo celular e e-mail. O
                                                                Usuário deverá manter suas informações cadastrais sempre
                                                                atualizadas, completas, exatas e verdadeiras,
                                                                responsabilizando-se integralmente pelo conteúdo de tais
                                                                informações.</p>
                                                            <p>6. O nome de usuário e senha de acesso ao site são de uso
                                                                exclusivo do USUÁRIO, que se compromete a manter tais
                                                                informações como confidenciais e impedir que terceiros
                                                                acessem o site utilizando tais informações. Em caso de
                                                                extravio das informações ou de acesso de terceiros não
                                                                autorizados, bem como qualquer suspeita ou conhecimento
                                                                acerca de falha de segurança do site ou perda ou roubo
                                                                do telefone celular, o USUÁRIO deverá informar
                                                                imediatamente o DOCTOR HOJE, por meio do e-mail
                                                                <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a>
                                                                ou telefone (61) 3221.5350.</p>
                                                            <p>7. Cabe exclusivamente ao DOCTOR HOJE o direito de
                                                                modificar o presente Acordo, bem como interromper ou
                                                                suspender o acesso ao site, a qualquer tempo, sem
                                                                necessidade de prévio aviso. Em caso de violação aos
                                                                termos e condições do Acordo, instruções de uso
                                                                presentes no site ou norma legal aplicável, o DOCTOR
                                                                HOJE poderá suspender ou impedir o acesso do USUÁRIO ao
                                                                Site, a qualquer tempo e sem prévia notificação, sem
                                                                prejuízo da responsabilidade cível e criminal do USUÁRIO
                                                                decorrente da respectiva violação. </p>
                                                            <p>8. O USUÁRIO, por sua vez, poderá cancelar o seu
                                                                cadastramento no site a qualquer tempo e sem qualquer
                                                                custo. O uso contínuo do site pelo USUÁRIO caracteriza a
                                                                aceitação dos termos e condições do Acordo que vierem a
                                                                sofrer alterações.</p>
                                                            <p>8.1. Se o USUÁRIO cancelar seu cadastramento no site
                                                                tendo adquirido consulta ou exame e ainda não utilizado,
                                                                o mesmo terá o prazo de até 30 (dias) da aquisição para
                                                                a realização dos mesmos, sob pena de perder o valor pago
                                                                pelos mesmos.</p>

                                                            <p><span>Do objeto</span></p>
                                                            <p>9. O objeto da plataforma digital DOCTOR HOJE é a oferta
                                                                de serviços tecnológicos que permite ao USUÁRIO o
                                                                agendamento e pagamento de consultas médicas e
                                                                odontológicas e exames de diagnósticos e terapias,
                                                                laboratoriais, de imagem e check up, a serem prestados
                                                                por médicos, odontólogos clínicas e laboratórios
                                                                (“Prestadores”) ao USUÁRIO interessado na marcação de
                                                                consultas e exames, conforme disponibilizados no
                                                                presente Termo de Uso. </p>
                                                            <p>10. Os serviços tecnológicos disponibilizados pelo DOCTOR
                                                                HOJE se diferenciam dos serviços de saúde prestados pelo
                                                                PRESTADOR ao USUÁRIO e incluem o acesso ao site, à
                                                                página web e aos serviços de pagamento na forma descrita
                                                                neste Termo e no site
                                                                <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>,
                                                                ficando o USUÁRIO responsável pelo bom uso dos serviços.
                                                            </p>
                                                            <p>11. Esta plataforma digital não contempla a publicidade
                                                                ou prestação de serviços médicos ou exames, não equivale
                                                                a plano privado de assistência à saúde, e não permite o
                                                                agendamento de atendimentos, consultas ou exames médicos
                                                                em caráter de urgência ou emergência ou internação de
                                                                qualquer natureza. Fica o USUÁRIO desde já advertido que
                                                                atendimentos de urgência ou emergência e internações,
                                                                devem ser agendados diretamente com o prestador de
                                                                serviços, e que qualquer dano ao USUÁRIO em decorrência
                                                                do descumprimento dessa condição não será suportado pelo
                                                                DOCTOR HOJE. </p>
                                                            <p>12. O USUÁRIO ESTÁ CIENTE QUE O DOCTOR HOJE É APENAS UMA
                                                                PLATAFORMA DIGITAL DE SERVIÇOS TECNOLÓGICOS DE
                                                                AGENDAMENTO E PAGAMENTO DE SERVIÇOS MÉDICOS OU
                                                                ODONTOLÓGICOS, E QUE NESSA QUALIDADE, NÃO TEM QUALQUER
                                                                RESPONSABILIDADE TÉCNICA, CIVIL OU CRIMINAL, POR
                                                                QUALQUER ATO OU FATO DECORRENTE DA PRESTAÇÃO DO SERVIÇO
                                                                MÉDICO OU ODONTOLÓGICO, CUJO PRESTADOR SE RESPONSABILIZA
                                                                TOTALMENTE PELA ENTREGA, QUALIDADE, LEGITIMIDADE E
                                                                INTEGRIDADE DOS SERVIÇOS MÉDICOS OU ODONTOLÓGICOS
                                                                PRESTADOS AO USUÁRIO. O DOCTOR HOJE SE EXIME, AINDA, DE
                                                                RESPONSABILIDADE POR EVENTUAL ERRO OU NEGLIGÊNCIA
                                                                MÉDICA, ERROS EM EXAMES ENVOLVENDO OS SERVIÇOS DE SAÚDE
                                                                PRESTADOS, OU PELO MAL ATENDIMENTO, INSUFICIÊNCIA DE
                                                                INFORMAÇÕES, BEM COMO POR DANOS MORAIS OU DE QUALQUER
                                                                NATUREZA.</p>

                                                            <p><span>Das responsabilidades do Doctor Hoje</span></p>
                                                            <p>13. O DOCTOR HOJE é responsável pelo desenvolvimento e
                                                                manutenção da plataforma digital, bem como pela
                                                                contratação e habilitação dos PRESTADORES aptos a
                                                                executarem as atividades médicas ou odontológicas, no
                                                                que tange a sua condição e registro perante o Conselho
                                                                Regional de Medicina e de Odontologia do respectivo
                                                                Estado, não se responsabilizando pelas informações e
                                                                avaliações constantes no site acerca dos PRESTADORES, e
                                                                nem, tampouco, pelo grau de experiência profissional e
                                                                qualificação dos mesmos.</p>
                                                            <p>14. O DOCTOR HOJE não se responsabiliza pelas
                                                                consequências decorrentes do descumprimento de
                                                                obrigações relacionadas às consultas e exames agendados
                                                                por meio do Site, incluindo cancelamentos e atrasos de
                                                                médicos, odontólogos ou USUÁRIOS, sendo que sua
                                                                responsabilidade se restringe aos serviços tecnológicos
                                                                ofertados pela plataforma digital para acesso e
                                                                pagamento entre o USUÁRIO e o PRESTADOR de serviços de
                                                                saúde.</p>
                                                            <p>15. Por se tratar de um ambiente eletrônico e virtual
                                                                condicionado ao pleno acesso à Internet por parte do
                                                                USUÁRIO e dos PRESTADORES, eventualmente, o sistema
                                                                poderá não estar disponível por motivos técnicos ou
                                                                falhas da internet, ou por qualquer outro evento
                                                                fortuito ou de força maior, alheio ao controle do DOCTOR
                                                                HOJE, o qual se compromete a envidar seus melhores
                                                                esforços para sanar qualquer anormalidade no
                                                                funcionamento do Site dentro da menor brevidade
                                                                possível.</p>

                                                            <p><span>Das responsabilidades do usuário</span></p>
                                                            <p>16. O USUÁRIO é exclusivamente responsável, perante o
                                                                DOCTOR HOJE e/ou terceiros, por todas as práticas
                                                                diretas e indiretas envolvendo o uso do Site, incluindo
                                                                a escolha do PRESTADOR de serviço e o pagamento por
                                                                exames e consultas médicas, bem como pela veracidade dos
                                                                dados pessoais por ele inseridos em seu cadastro, pelas
                                                                informações prestadas e por toda a atividade que ocorrer
                                                                em sua conta de acesso aos serviços.</p>
                                                            <p>17. É exclusiva responsabilidade do USUÁRIO receber e
                                                                manter em sigilo sua senha de acesso ao site, que será
                                                                enviada por sms a cada novo acesso. </p>
                                                            <p>18. O USUÁRIO deverá notificar o DOCTOR HOJE
                                                                imediatamente sobre qualquer uso não autorizado de
                                                                qualquer senha, conta, ou sobre qualquer outra suspeita
                                                                ou conhecimento acerca de falha na segurança do
                                                                serviço.</p>
                                                            <p>19. É facultado ao USUÁRIO o cadastramento de outras
                                                                pessoas como dependentes no site, para as quais possa a
                                                                vir a pretender agendar consultas ou exames com os
                                                                PRESTADORES, ficando ciente e de acordo, desde já, que
                                                                as cobranças pelos procedimentos realizados por essas
                                                                pessoas serão pagas pelo USUÁRIO cadastrado, por meio de
                                                                cartão de débito ou crédito. </p>
                                                            <p>20. Em nenhuma hipótese será permitida a cessão, venda,
                                                                aluguel ou outra forma de transferência da conta. Também
                                                                não se permitirá a manutenção de mais de um cadastro por
                                                                um mesmo USUÁRIO, ou ainda a criação de novos cadastros
                                                                por usuários cujos cadastros originais tenham sido
                                                                cancelados por infrações às políticas do DOCTOR HOJE. Se
                                                                o DOCTOR HOJE detectar cadastros duplicados, através do
                                                                sistema de verificação de dados, irá inabilitar
                                                                definitivamente todos os cadastros duplicados.</p>
                                                            <p>21. O USUÁRIO tem ciência que o DOCTOR HOJE não tem
                                                                qualquer ingerência na contratação entre o USUÁRIO e
                                                                seus bancos ou administradoras de cartões de débito ou
                                                                crédito. Os USUÁRIOS declaram saber e conhecer todas as
                                                                condições impostas por suas instituições financeiras
                                                                para a compra de bens e produtos por cartões de débito
                                                                ou crediário, dentre elas: taxas de juros, encargos
                                                                financeiros, limites de crédito, número de parcelas,
                                                                etc, isentando o DOCTOR HOJE de qualquer
                                                                responsabilidade quanto a tais condições.</p>
                                                            <p>22. O USUÁRIO concorda em guardar e manter o DOCTOR HOJE
                                                                e seus parceiros a salvo e a indenizá-los por quaisquer
                                                                reclamações, processos, ações, perdas, danos, bem como
                                                                quaisquer outras responsabilidades decorrentes de seu
                                                                uso ou utilização indevida do site, bem como por
                                                                violação deste Termo, violação dos direitos de qualquer
                                                                outra pessoa ou entidade, ou qualquer violação das
                                                                declarações, garantias e acordos feitos aqui pelo
                                                                USUÁRIO.</p>

                                                            <p><span>Das responsabilidades do Prestador</span></p>
                                                            <p>23. O PRESTADOR escolhido pelo USUÁRIO prestará os
                                                                serviços para os quais está contratado junto ao DOCTOR
                                                                HOJE e cadastrado no Site, diretamente ao USUÁRIO, de
                                                                forma autônoma e independente, na região onde desenvolve
                                                                a sua atividade, estando livre para realizar o seu
                                                                diagnóstico e tratamento da forma como melhor lhe
                                                                aprouver, inclusive respondendo por eventuais danos
                                                                médicos causados aos USUÁRIOS, não havendo qualquer
                                                                ingerência do DOCTOR HOJE em relação ao ato médico
                                                                realizado, estando todas as Partes absolutamente cientes
                                                                e concordantes com o fato de que o DOCTOR HOJE é apenas
                                                                uma plataforma de serviços tecnológicos que não presta
                                                                serviços de saúde, nem opera como agente ou plano de
                                                                saúde.</p>
                                                            <p>24. O USUÁRIO e o PRESTADOR se comprometem a não utilizar
                                                                o site do DOCTOR HOJE para agendar a prestação de
                                                                serviços de internação hospitalar de qualquer natureza,
                                                                de URGÊNCIA e EMERGÊNCIA ou de aconselhamento médico,
                                                                por telefone ou vídeo, aos USUÁRIOS do DOCTOR HOJE.</p>
                                                            <p>25. O PRESTADOR se compromete a não prestar serviço ao
                                                                USUÁRIO que não esteja de posse da senha de atendimento
                                                                fornecida pelo DOCTOR HOJE, a qual deverá ser validada
                                                                em sistema na área privativa do prestador no portal
                                                                <a href="www.doctorhoje.com.br" target="_blank">www.doctorhoje.com.br</a>.
                                                            </p>
                                                            <p>26. Oferecer aos USUÁRIOS da plataforma digital DOCTOR
                                                                HOJE a mesma atenção em relação aos demais pacientes,
                                                                bem como que o atendimento seja pautado pelo exercício
                                                                ético da medicina, com base em parâmetros de
                                                                competência, excelência, autonomia, sigilo e
                                                                respeito.</p>
                                                            <p>27. Não cobrar do USUÁRIO qualquer valor extra referente
                                                                aos serviços de saúde prestados. </p>

                                                            <p><span>Instruções gerais para agendamento de consultas médicas e odontológicas</span>
                                                            </p>
                                                            <p>28. O agendamento de consultas por meio do Site DOCTOR
                                                                HOJE seguirá as seguintes regras e etapas
                                                                consecutivas:</p>
                                                            <ul>
                                                                <li>
                                                                    <p>Ao acessar o Site pela primeira vez, o USUÁRIO
                                                                        deverá se cadastrar e fazer o login, utilizando
                                                                        o e-mail e senha de acesso;</p>
                                                                </li>
                                                                <li>
                                                                    <p>Após cadastrado, o USUÁRIO buscará os
                                                                        PRESTADORES, informando a especialidade e a
                                                                        localidade e com base na respectiva pesquisa, o
                                                                        Site apresentará uma lista de PRESTADORES
                                                                        cadastrados, sendo o critério de ordenamento dos
                                                                        PRESTADORES definido exclusivamente pelo
                                                                        Site;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO escolherá o PRESTADOR, o dia e o
                                                                        horário de agenda pretendido e será encaminhado
                                                                        para a tela de pagamento. O dia e o horário
                                                                        indicados pelo USUÁRIO é um pré-agendamento, que
                                                                        será confirmado em até 48 (quarenta e oito)
                                                                        horas. </p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO pagará o valor da consulta, conforme
                                                                        estabelecido pelo PRESTADOR, já incluído o valor
                                                                        da taxa de utilização do serviço
                                                                        tecnológico;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O pré-agendamento ou a disponibilização de cada
                                                                        consulta só será realizado mediante comprovação
                                                                        de pagamento; caso não haja pagamento
                                                                        confirmado, o pré-agendamento será
                                                                        automaticamente cancelado, sem qualquer prejuízo
                                                                        ao USUÁRIO;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O comprovante de pagamento e o código de
                                                                        confirmação da consulta serão enviados para o
                                                                        USUÁRIO por e-mail ou SMS e estarão disponíveis
                                                                        no acesso logado.</p>
                                                                </li>
                                                            </ul>

                                                            <p><span>Instruções gerais para aquisição e/ou agendamento de exames</span>
                                                            </p>
                                                            <p>29. O agendamento de exames por meio da plataforma
                                                                digital DOCTOR HOJE seguirá as seguintes regras e etapas
                                                                consecutivas: </p>
                                                            <ul>
                                                                <li>
                                                                    <p>Ao acessar o Site pela primeira vez, o USUÁRIO
                                                                        deverá se cadastrar e fazer o login, utilizando
                                                                        o e-mail e senha de acesso;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO informará o exame desejado e a
                                                                        localidade e com base na respectiva pesquisa, o
                                                                        Site apresentará uma lista de PRESTADORES
                                                                        cadastrados, sendo o critério de ordenamento dos
                                                                        PRESTADORES definidos exclusivamente pelo
                                                                        Site;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO escolherá o PRESTADOR, o dia e o
                                                                        horário de agenda pretendido e será encaminhado
                                                                        para a tela de pagamento. O dia e o horário
                                                                        indicados pelo USUÁRIO é um pré-agendamento, que
                                                                        será confirmado em até 48 (quarenta e oito)
                                                                        horas.</p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO não está obrigado a apresentar o pedido
                                                                        médico para a aquisição de exames pelo DOCTOR
                                                                        HOJE, sendo a escolha do exame de
                                                                        responsabilidade do USUÁRIO. Entretanto, é
                                                                        aconselhável ao USUÁRIO apresentar pedido médico
                                                                        no dia do exame, que, a critério do PRESTADOR,
                                                                        poderá ou não ser exigido. </p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO escolherá o PRESTADOR e será
                                                                        encaminhado para a tela de pagamento;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O USUÁRIO pagará o valor do exame, conforme
                                                                        estabelecido pelo PRESTADOR, já incluído o valor
                                                                        da taxa de utilização do serviço
                                                                        tecnológico.</p>
                                                                </li>
                                                                <li>
                                                                    <p>O pré-agendamento ou a disponibilização de cada
                                                                        exame só será realizado mediante comprovação de
                                                                        pagamento; caso não haja pagamento confirmado, o
                                                                        pré-agendamento será automaticamente cancelado,
                                                                        sem qualquer prejuízo ao USUÁRIO;</p>
                                                                </li>
                                                                <li>
                                                                    <p>O comprovante de pagamento e o código de
                                                                        confirmação do exame serão enviados para o
                                                                        USUÁRIO por e-mail ou SMS e estarão disponíveis
                                                                        no acesso logado.</p>
                                                                </li>
                                                            </ul>

                                                            <p>
                                                                <span>Reagendamento ou cancelamento de consultas e exames</span>
                                                            </p>
                                                            <p>30. O USUÁRIO poderá reagendar e/ou cancelar
                                                                definitivamente a respectiva consulta ou exame por meio
                                                                do Site ou SAC em até 24 (vinte e quatro) horas antes da
                                                                data agendada.</p>
                                                            <p>31. Na hipótese de cancelamento da consulta ou exame com
                                                                até 24 (vinte e quatro) de antecedência da data
                                                                agendada, será estornado ao USUÁRIO valor correspondente
                                                                a 50% (cinquenta por cento) do valor pago. Em nenhuma
                                                                hipótese haverá estorno do valor total do serviço, já
                                                                que o simples agendamento de consulta ou exame por meio
                                                                da plataforma digital enseja a efetivação da prestação
                                                                dos serviços pelo DOCTOR HOJE.</p>
                                                            <p>32. Se o USUÁRIO não comparecer no dia da consulta ou
                                                                procedimento agendado ou se não efetuar a remarcação da
                                                                consulta ou do procedimento com pelo menos 24 (vinte e
                                                                quatro) de antecedência ao horário e data marcados, o
                                                                valor do procedimento (consulta ou exame) não será
                                                                estornado, será cobrado normalmente, estando o USUÁRIO
                                                                ciente e plenamente de acordo com o ora
                                                                estabelecido.</p>
                                                            <p>33. Os exames ou consultas só poderão ser reagendados uma
                                                                única vez pelo UUSÁRIO e dentro de 30 (trinta) dias a
                                                                contar da data do agendamento inicial.</p>
                                                            <p>34. Na hipótese de exames disponibilizados por
                                                                PRESTADORES sem necessidade de agendamento (Ex: exames
                                                                laboratoriais), o USUÁRIO poderá cancelá-los por meio da
                                                                plataforma digital DOCTOR HOJE em até 7 (sete) dias após
                                                                a respectiva compra, desde que ainda não os tenha
                                                                realizado. Nesse caso, será devolvido o valor integral
                                                                pago pelo USUÁRIO. Para desistência ou cancelamento após
                                                                o 8º (oitavo) dia da compra, será estornado ao USUÁRIO
                                                                valor correspondente a 50% (cinquenta por cento) do
                                                                valor pago.</p>
                                                            <p>34.1. Todo e qualquer exame que não necessite de
                                                                agendamento, deverá ser obrigatoriamente realizado em
                                                                até 60 (sessenta) dias da compra, sob pena de o USUÁRIO
                                                                perder o valor pago pelo mesmo. </p>
                                                            <p>35. A devolução quando devida ocorrerá por meio de
                                                                crédito em conta corrente ou estorno do cartão de
                                                                crédito, conforme o caso, no prazo máximo de até 5
                                                                (cinco) dias úteis do pedido de cancelamento ou no prazo
                                                                estabelecido pelo cartão de débito ou crédito.</p>
                                                            <p>36. Se o PRESTADOR cancelar a consulta ou exame agendado,
                                                                o PRESTADOR ou o USUÁRIO deverão contatar o DOCTOR HOJE,
                                                                o qual providenciará o reagendamento com outro PRESTADOR
                                                                com a maior brevidade possível. </p>
                                                            <p>37. O USUÁRIO poderá exercer o direito de arrependimento
                                                                e desistir da consulta ou exame adquiridos pela
                                                                plataforma digital DOCTOR HOJE no prazo máximo de até 7
                                                                (sete) dias contados da aquisição, desde que ainda não
                                                                os tenha realizado. Nesse caso, será devolvido o valor
                                                                integral pago pelo USUÁRIO.</p>
                                                            <div class="tabela-termos">
                                                                <div class="row">

                                                                    <div class="col-md-12 titulo">
                                                                        Regras para cancelamento e agendamento
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        &nbsp;
                                                                    </div>
                                                                    <div class="col-md-4 titulo">
                                                                        Solicitação/Período
                                                                    </div>
                                                                    <div class="col-md-4 titulo">
                                                                        Até 24 horas
                                                                    </div>
                                                                    <div class="col-md-4 titulo">
                                                                        Inferior a 24 horas
                                                                    </div>

                                                                    <div class="col-md-4 linha">
                                                                        Cancelamento
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Reembolso de 50% do valor pago em até 5 dias
                                                                        úteis
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Sem direito a reembolso
                                                                    </div>

                                                                    <div class="col-md-4 linha">
                                                                        Reagendamento
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Direito a 1 (um) reagendamento em no máximo 30
                                                                        dias
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Perda do direito de reagendamento
                                                                    </div>

                                                                    <div class="col-md-4 titulo">
                                                                        Regras especiais
                                                                    </div>
                                                                    <div class="col-md-4 titulo">
                                                                        Prazos
                                                                    </div>
                                                                    <div class="col-md-4 titulo">
                                                                        Condições
                                                                    </div>

                                                                    <div class="col-md-4 linha">
                                                                        Exames sem necessidade de agendamento
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Realizar até 60 dias da aquisição
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Após 60 dias perderá o direito ao reembolso
                                                                    </div>

                                                                    <div class="col-md-4 linha">
                                                                        Cancelamento da conta DOCTOR HOJE
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Realizar até 30 dias após pedido de cancelamento
                                                                        da conta
                                                                    </div>
                                                                    <div class="col-md-4 linha">
                                                                        Após 30 dias perderá o direito ao reembolso
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <p>&nbsp;</p>
                                                            <p>
                                                                <span>Instruções para realização de consultas e exames</span>
                                                            </p>
                                                            <p>38. Na data da consulta ou exame agendado, o USUÁRIO
                                                                deverá comparecer ao estabelecimento do PRESTADOR com
                                                                antecedência mínima de 30 (trinta) minutos, sempre
                                                                munido de documento de identidade, pedido médico ou
                                                                odontológico, quando for o caso, e código de confirmação
                                                                da consulta ou do exame fornecido pelo DOCTOR HOJE e
                                                                disponível na área logada.</p>
                                                            <p>39. Cabe a cada PRESTADOR indicar livremente os prazos de
                                                                retorno de consultas médicas ou odontológicas, as quais
                                                                deverão ser agendadas pelo DOCTOR HOJE. A determinação
                                                                do tempo necessário para avaliação do USUÁRIO e de seus
                                                                exames segue critérios técnicos e médicos, sem qualquer
                                                                interferência do DOCTOR HOJE.</p>
                                                            <p>40. Na hipótese de realização de exames que ensejem
                                                                preparo específico (ex.: jejum, dieta, medicação), o
                                                                USUÁRIO será informado pelo DOCTOR HOJE, pelo e-mail
                                                                cadastrado.</p>
                                                            <p>41. Após cada consulta ou exame, o USUÁRIO terá a
                                                                possibilidade de avaliar o PRESTADOR acessando a
                                                                plataforma DOCTOR HOJE. Essa avaliação é facultativa e
                                                                consiste na atribuição de uma nota de 1 (um) a 5 (cinco)
                                                                para o atendimento do PRESTADOR, para as condições de
                                                                atendimento do profissional, atendimento da secretária,
                                                                tempo de espera, estrutura física e acessibilidade. </p>
                                                            <p>42. O USUÁRIO e PRESTADOR expressamente concordam e
                                                                reconhecem que o DOCTOR HOJE não tem nenhuma
                                                                responsabilidade em relação às avaliações dos
                                                                PRESTADORES realizadas pelos USUÁRIOS, e que essas
                                                                avaliações não devem ser consideradas divulgações de
                                                                caráter publicitário.</p>

                                                            <p><span>Pagamento pelos serviços contratados no site e taxa de agendamento</span>
                                                            </p>
                                                            <p>43. A remuneração pela contratação do PRESTADOR será paga
                                                                pelo USUÁRIO por meio da plataforma digital DOCTOR HOJE,
                                                                por meio de cartão de débito ou crédito.</p>
                                                            <p>44. O USUÁRIO concorda que o DOCTOR HOJE cobrará uma taxa
                                                                de utilização do serviço tecnológico prestado, que
                                                                incidirá sobre o preço de cada consulta ou exame
                                                                agendado por meio do Site, a qual estará incluída no
                                                                valor total cobrado por cada consulta ou exame.</p>
                                                            <p>44.1. Para a utilização do serviço tecnológico o USUÁRIO
                                                                pagará ao DOCTOR HOJE o valor anual de R$ 48,80
                                                                (quarenta e oito reais e oitenta centavos). O USUÁRIO
                                                                que se cadastrar no DOCTOR HOJE até 30/09/2018, terá
                                                                desconto de 50% na primeira anuidade, pagando o valor de
                                                                R$ 24,40 (vinte e quatro reais e quarenta centavos)
                                                                somente no 6º (sexto) mês após a adesão. A anuidade
                                                                seguinte será integral, válida para os próximos 12
                                                                (doze) meses contados da data da adesão.</p>
                                                            <p>44.2. O DOCTOR HOJE deixa claro que o valor anual
                                                                refere-se a utilização do serviço tecnológico e não se
                                                                trata, nem se equipara a mensalidades ou pagamentos a
                                                                planos privados de assistência à saúde.</p>
                                                            <p>45. O USUÁRIO concorda em pagar por todo e qualquer
                                                                serviço intermediado por meio da plataforma digital
                                                                DOCTOR HOJE utilizando seu nome, cartão de débito ou
                                                                crédito ou outras formas de pagamento. Todos os
                                                                pagamentos feitos através de cartão de débito ou crédito
                                                                estarão sujeitos à autorização e aprovação da
                                                                administradora do cartão.</p>
                                                            <p>45.1. O USUÁRIO, a seu critério, poderá optar pelo
                                                                armazenamento dos dados de seu cartão de débito ou
                                                                crédito para facilitar futuras compras. </p>
                                                            <p>46. O DOCTOR HOJE emitirá nota fiscal eletrônica, a qual
                                                                será enviada por e-mail ao USUÁRIO. Por se tratar de
                                                                prestação de serviços tecnológicos de agendamento de
                                                                consultas ou exames, os valores não são dedutíveis na
                                                                Declaração de Imposto de Renda ou passíveis de
                                                                reembolso.</p>
                                                            <p>47. Os valores correspondentes às consultas e exames
                                                                poderão, a critério exclusivo do USUÁRIO, ser parcelados
                                                                em até 2 (duas) parcelas, sem juros. Acima de 3 (três)
                                                                parcelas serão cobrados juros do cartão, conforme
                                                                informação que constará do Site. </p>
                                                            <p>48. O DOCTOR HOJE jamais será responsável por possíveis
                                                                interrupções nos serviços de pagamentos de empresas
                                                                contratadas, nem pelas falhas e/ou danos e prejuízos que
                                                                o uso serviços possam gerar ao USUÁRIO.</p>
                                                            <p>49. O DOCTOR HOJE não se responsabiliza pelas obrigações
                                                                tributárias que recaiam sobre as atividades dos
                                                                PRESTADORES de serviços médicos ou odontológicos.</p>
                                                            <p>50. Toda discrepância, erro, omissão e/ou inconveniente
                                                                referente ao sistema, forma e/ou instituição de
                                                                pagamento será de exclusiva responsabilidade do USUÁRIO
                                                                e das instituições de pagamento, não cabendo imputação
                                                                alguma ao DOCTOR HOJE. Ao optar por utilizar o serviço
                                                                de controle de pagamentos, o DOCTOR HOJE não tem como
                                                                evitar ocasionais falhas das referidas instituições e
                                                                dos sistemas bancários e/ou administradoras de cartão de
                                                                débito ou crédito.</p>
                                                            <p>51. Caso ocorram problemas devidos ao seu uso, o USUÁRIO
                                                                deverá informar o DOCTOR HOJE por e-mail
                                                                <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a>
                                                                ou pelo telefone (61) 3221.5350, não gerando obrigação
                                                                para que o DOCTOR HOJE resolva tais problemas.</p>

                                                            <p><span>PROPRIEDADE INTELECTUAL</span></p>
                                                            <p>52. O USUÁRIO concorda que todo o conteúdo referente aos
                                                                serviços, banco de dados, redes, arquivos e todas as
                                                                funcionalidades disponíveis no Site são de propriedade
                                                                exclusiva do DOCTOR HOJE, seus anunciantes e/ou
                                                                licenciados, e que estão protegidos como direitos
                                                                autorais, marcas, segredos comerciais e outros direitos
                                                                referentes a propriedade intelectual e/ou industrial
                                                                previstos na Legislação Brasileira.</p>
                                                            <p>52.1. O conteúdo do Site DOCTOR HOJE, incluindo textos,
                                                                imagens, áudios e/ou vídeos, não poderá ser distribuído,
                                                                modificado, alterado, transmitido, reutilizado ou
                                                                reenviado a terceiros pelo USUÁRIO, seja para qual
                                                                finalidade for, sem a prévia e expressa autorização do
                                                                DOCTOR HOJE. </p>
                                                            <p>52.2. É expressamente vedado ao USUÁRIO utilizar os dados
                                                                ou o conteúdo do Site ou respectivos micro sites para
                                                                criar compilações e bases de dados de qualquer tipo sem
                                                                a permissão por escrito do DOCTOR HOJE. Sendo assim, é
                                                                proibido o uso do conteúdo ou materiais do Site e
                                                                respectivos micro sites para qualquer propósito que não
                                                                esteja expressamente autorizado neste Termo de Uso.</p>
                                                            <p>53. A presença de links para outros sites não implica
                                                                relação de sociedade, de supervisão, de cumplicidade ou
                                                                solidariedade do DOCTOR HOJE para com esses sites e seus
                                                                conteúdos.</p>

                                                            <p><span>Declarações do usuário</span></p>
                                                            <p>54. O USUÁRIO declara expressamente e garante, para todos
                                                                os fins de direito, que possui capacidade jurídica para
                                                                celebrar este contrato e utilizar os serviços objeto do
                                                                mesmo, sendo maior de 18 (dezoito) anos de idade.</p>
                                                            <p>54.1. Os pais ou os representantes legais do menor de
                                                                idade ou incapaz responderão pelos atos por ele
                                                                praticados na utilização da plataforma digital, dentre
                                                                os quais eventuais danos causados a terceiros, práticas
                                                                de atos vedados pela lei e pelas disposições deste
                                                                Termo.</p>
                                                            <p>55. O USUÁRIO garante que não se identificou falsamente,
                                                                nem forneceu qualquer informação falsa para obter acesso
                                                                ao serviço do DOCTOR HOJE.</p>
                                                            <p>56. O USUÁRIO está ciente que o DOCTOR HOJE se reserva o
                                                                direito de utilizar todos os meios válidos e possíveis
                                                                para identificar seus USUÁRIOS, bem como de solicitar
                                                                dados adicionais e documentos que estime serem
                                                                pertinentes a fim de conferir os dados pessoais
                                                                informados.</p>
                                                            <p>57. O USUÁRIO está ciente que o DOCTOR HOJE poderá
                                                                modificar os termos e condições do presente Termo ou as
                                                                suas políticas relativas ao serviço a qualquer momento,
                                                                efetivadas após a publicação de uma versão atualizada do
                                                                Termo sobre o serviço.</p>
                                                            <p>58. O USUÁRIO é responsável por verificar regularmente o
                                                                presente Termo de Uso, sendo que o uso continuado do
                                                                Serviço após qualquer alteração, constituirá o seu
                                                                consentimento para tais mudanças.</p>

                                                            <p><span>Disposições finais</span></p>
                                                            <p>59. O USUÁRIO poderá contatar o DOCTOR HOJE para tratar
                                                                de questões referentes ao Site, incluindo dúvidas,
                                                                reclamações e sugestões, por meio do endereço
                                                                eletrônico: <a href="mailto:cliente@doctorhoje.com.br">cliente@doctorhoje.com.br</a>.
                                                                A resposta do DOCTOR HOJE em relação às demandas do
                                                                USUÁRIO deverá ser realizada em até 5 (cinco) dias
                                                                úteis.</p>
                                                            <p>60. A propriedade do Site poderá ser cedida e transferida
                                                                a qualquer tempo pelo DOCTOR HOJE a terceiros, sem
                                                                necessidade de anuência do USUÁRIO.</p>
                                                            <p>61. Cada cláusula deste Termo de Uso deverá ser
                                                                interpretada de modo a se tornar válida e eficaz à luz
                                                                da lei aplicável. Caso alguma das cláusulas seja
                                                                considerada ilícita, dita cláusula deverá ser julgada
                                                                separadamente do restante do Termo e todas as demais
                                                                cláusulas continuarão em pleno vigor.</p>
                                                            <p>62. A disponibilização do Site terá prazo indeterminado,
                                                                reservando-se ao DOCTOR HOJE o direito de suspender ou
                                                                interromper, a qualquer momento independentemente de
                                                                prévio aviso.</p>
                                                            <p>63. As partes contratantes elegem o foro da Circunscrição
                                                                Judiciária de Brasília – DF, para a resolução de
                                                                quaisquer controvérsias oriundas deste Termo de Uso,
                                                                renunciando a todo e qualquer outro, por mais
                                                                privilegiado que seja.</p>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-vermelho" data-dismiss="modal">
                                                                Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-lista-dependentes">
                                        <span class="label-titulo">Dependentes</span>
                                        <div id="lista-dependentes" class="lista-dependentes">
                                            @for($i = 0; $i < sizeof($dependentes); $i++)
                                                <div class="dependente">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <span class="nm-dependente"><strong>Dep0{{ ($i+1) }}</strong>: {{ $dependentes[$i]->nm_primario.' '.$dependentes[$i]->nm_secundario }}</span>
                                                            <input type="hidden" id="dependente_{{ $dependentes[$i]->id }}" class="dependente_id" value="{{ $dependentes[$i]->id }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a class="exclui-dependente"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                            @if(sizeof($dependentes) == 0)
                                                <span id="lbl-no-dependents">NENHUM DEPENDENTE ENCONTRADO!</span>
                                            @endif
                                        </div>

                                        <button type="button" class="btn btn-light btn-add-dependente" data-toggle="modal" data-target="#modalAdicionaDependente">
                                            <i class="fa fa-plus"></i> Adicionar dependente
                                        </button>

                                        <!-- Modal adicionar dependente -->

                                        <div class="modal fade" id="modalAdicionaDependente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-adiciona-dependente" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Novo
                                                            Dependente</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group"></div>
                                                            <div class="form-row">
                                                                <label for="inputNomeDependente">Nome</label>
                                                                <input type="text" class="form-control" id="inputNomeDependente" placeholder="Nome *" maxlength="50">
                                                                <input type="hidden" id="inputPacienteId" value="{{ $user_paciente->paciente->id }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputNomeDependente">Sobrenome</label>
                                                                <input type="text" class="form-control" id="inputNmSecundarioDependente" placeholder="Sobrenome *" maxlength="100">
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="tp_documento_dependente" class="control-label">Tipo
                                                                        Documento</label>
                                                                    <select id="tp_documento_dependente" class="form-control" name="tp_documento_dependente">
                                                                        <option value="RG">RG</option>
                                                                        <option value="CPF">CPF</option>
                                                                        <option value="CNASC">Certi. Nasc.</option>
                                                                        <option value="CTPS">Cart. Trabalho</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-8">
                                                                    <label for="te_documento_dependente" class="control-label">Nr.
                                                                        Documento</label>
                                                                    <input type="text" id="te_documento_dependente" class="form-control" name="te_documento_dependente" placeholder="Nr. Documento">
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-row">
                                                                <div class="col-md-4">
                                                                    <label for="selectGeneroDependente">Gênero</label>
                                                                    <select id="selectGeneroDependente" class="form-control">
                                                                        <option value="M">Masc.</option>
                                                                        <option value="F">Fem.</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label for="selectParentescoDependente">Parentesco</label>
                                                                    <select id="selectParentescoDependente" class="form-control">
                                                                        <option value="">Selecione</option>
                                                                        <option value="avo">Avô/Avó</option>
                                                                        <option value="conjuge">Cônjuge/Companheiro
                                                                        </option>
                                                                        <option value="enteado">Enteado(a)</option>
                                                                        <option value="filho">Filho(a)</option>
                                                                        <option value="irmao">Irmã(ão)</option>
                                                                        <option value="mae">Mãe</option>
                                                                        <option value="pai">Pai</option>
                                                                        <option value="outros">Outros</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group fc-tit-dn">
                                                                <label>Data de Nascimento</label>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectDiaDependente" class="form-control">
                                                                        <option value="">Dia</option>
                                                                        @for($i = 1; $i <= 31; $i++)
                                                                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectMesDependente" class="form-control">
                                                                        <option value="">Mês</option>
                                                                        @for($i = 1; $i <= 12; $i++)
                                                                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <select id="selectAnoDependente" class="form-control">
                                                                        <option value="">Ano</option>
                                                                        @for($i = date('Y'); $i >= (date('Y'))-110; $i--)
                                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-md-12 text-center">
                                                                    <button type="button" id="btn-add-dependente" class="btn btn-vermelho" style="width: 200px;">
                                                                        <i class="fa fa-floppy-o"></i><span id="lbl-add-dependente" style="margin-left: 10px;"> Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="label-titulo">Alteração Cadastral</span>
                                        <p>Para alterar as informações do seu cadastro é necessário entrar em contato
                                            com a nossa central de atendimento pelo número: <strong>(61)
                                                3221-5350</strong></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagamento -->

                            <div class="tab-pane fade" id="v-pills-pagamento" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-5">
                                            <span class="label-titulo">Cartões Salvos</span>
                                            <div class="box-pagamento lista-cartoes">
                                                @foreach($cartoes_paciente as $cartao)
                                                    <div class="cartao">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="bandeira {{ strtolower($cartao->bandeira) }}"></div>
                                                                <p>
                                                                    <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                    <span class="final">{{ $cartao->numero }}</span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a class="exclui-cartao"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if(sizeof($cartoes_paciente) == 0)
                                                    <span id="lbl-cartao-paciente">NENHUM CARTÃO ENCONTRADO!</span>
                                                @endif
                                            </div>
                                            <!-- <button type="button" class="btn btn-light btn-add-cartao" data-toggle="modal" data-target="#modalAdicionarCartao">
                                            	<i class="fa fa-plus"></i> Adicionar cartão
                                            </button> -->
                                            <div class="modal fade" id="modalAdicionarCartao" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarCartao" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Adicionar
                                                                cartão</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="form-group row">
                                                                    <div class="col col-12 col-sm-6">
                                                                        <label for="inputNumeroCartaoDebito">Número do
                                                                            cartão</label>
                                                                        <input type="text" class="form-control input-numero-cartao" id="inputNumeroCartaoDebito" placeholder="Número do cartão">
                                                                    </div>
                                                                    <div class="col col-12 col-sm-6">
                                                                        <label for="inputNomeCartaoDebito">Nome impresso
                                                                            no cartão</label>
                                                                        <input type="email" class="form-control" id="inputNomeCartaoDebito" placeholder="Nome impresso no cartão">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col col-6 col-sm-6 col-md-3">
                                                                        <label for="selectValidadeMesDebito">Validade</label>
                                                                        <div class="button dropdown">
                                                                            <select class="form-control select-validade-mes" id="selectValidadeMesDebito">
                                                                                <option>Mês</option>
                                                                                <option>Janeiro</option>
                                                                                <option>Fevereiro</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col col-6 col-sm-6 col-md-3">
                                                                        <label class="label-validade-ano" for="selectValidadeAnoDebito">&nbsp;</label>
                                                                        <div class="button dropdown">
                                                                            <select class="form-control" id="selectValidadeAnoDebito">
                                                                                <option>Ano</option>
                                                                                <option>2018</option>
                                                                                <option>2019</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col col-12 col-sm-12 col-md-6 codigo-seguranca">
                                                                        <label for="inputCodigoDebito" class="label-codigo-seguranca">Código
                                                                            de segurança</label>
                                                                        <div class="area-codigo-seguranca">
                                                                            <input type="text" class="form-control" id="inputCodigoDebito" placeholder="000">
                                                                            <i class="fa fa-credit-card" data-toggle="tooltip" data-placement="top" title="Código de segurança ou CVV são os 3 dígitos eu ficam no verso do seu cartão."></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-vermelho">Adicionar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-7">
                                            <span class="label-titulo">Últimas Transações</span>
                                            <div class="box-pagamento lista-transacoes">

                                                @foreach($agendamentos as $agendamento)
                                                    <div class="transacoes">
                                                        <div class="row">
                                                            <div class="col-sm-3 area-data">
                                                                <p class="dia">{{ date('d', strtotime($agendamento->getRawDtAtendimentoAttribute())) }}</p>
                                                                <p class="mes">{{ ucfirst(substr(strftime('%B', strtotime($agendamento->getRawDtAtendimentoAttribute())), 0, 3)) }}</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p class="tipo">
                                                                    @if($agendamento->atendimento->consulta_id != null)
                                                                        Consulta:
                                                                    @elseif($agendamento->atendimento->procedimento_id != null)
                                                                        Exame:
                                                                    @endif
                                                                    {{ substr($agendamento->atendimento->ds_preco, 0, 14) }}
                                                                    @if(strlen($agendamento->atendimento->ds_preco > 14))
                                                                        ...
                                                                    @endif
                                                                </p>
                                                                <p class="clinica">
                                                                    {{ $agendamento->clinica->nm_fantasia }}
                                                                </p>
                                                                <p class="cartao-utilizado">
                                                                    @if($agendamento->itempedidos->first()->pedido->cartao_paciente == null)
                                                                        <span class="bandeira-extenso">-</span>
                                                                        <span class="numero-oculto">Nenhum Cartão informado</span>
                                                                        <span class="final">-</span>
                                                                    @else
                                                                        <span class="bandeira-extenso">{{ $agendamento->itempedidos->first()->pedido->cartao_paciente->bandeira }} </span>
                                                                        <span class="numero-oculto">●●●● ●●●● ●●●● </span>
                                                                        <span class="final">{{ $agendamento->itempedidos->first()->pedido->cartao_paciente->numero }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <p class="valor">R$
                                                                    <span>{{ $agendamento->valor_total }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if(sizeof($agendamentos) == 0)
                                                    <span id="lbl-pedido-paciente">NENHUM PEDIDO ENCONTRADO!</span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-anuidade" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div>
                                    <div class="area-tipo-plano">
                                        <div class="row">
                                            <div class="col-md-6 atp1">
                                                <p class="nome-plano">Plano Premium</p>
                                                <p class="valor-anuidade">Anuidade Doctor Hoje R$ 9.99</p>
                                            </div>
                                            <div class="col-md-6 atp2">
                                                <p class="valor-plano">1 ano grátis</p>
                                                <a class="link-indique-amigo" href="#">Indique um Amigo</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-notificacoes" role="tabpanel" aria-labelledby="v-pills-notifications-tab">
                                <div class="lista-notificacoes">
                                    <div class="accordion" id="accordionNotificacoes">
                                        <div class="card">
                                            <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <h5 class="mb-0">
                                                    <span class="titulo-notificacao">Você possui um cupom de desconto</span>
                                                    <span class="status-notificacao sn-nao-lido">Não lido</span>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p class="titulo">Aproveite seu desconto!</p>
                                                    <p class="texto">Você possui um cupom que garante <strong>10% de
                                                            desconto</strong> no seu primeiro agendamento feito pelo
                                                        site Doctor Hoje. Aproveite, é por tempo limitado. Na tela de
                                                        finalização de compra insira o código: <strong>DOCTOR10</strong>
                                                    </p>
                                                    <button type="button" class="close-div btn btn-secondary" title="Apagar mensagem">
                                                        <i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="opcoes-notificacao">
                                    <div class="tit-opcoes-notificacao">
                                        <span>Quais notificações deseja receber por E-mail?</span>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-9 col-md-9 col-lg-5">
                                            <label for="toggleLembrete"><strong>Lembrete</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-3 col-md-3 col-lg-2">
                                            <input type="checkbox" id="toggleLembrete" data-plugin="switchery" data-color="#3bafda" data-size="small" checked>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-9 col-md-9 col-lg-5">
                                            <label for="toggleConfirmacao"><strong>Confirmação</strong> de consulta
                                                ou
                                                exame</label>
                                        </div>
                                        <div class="col-3 col-md-3 col-lg-2">
                                            <input type="checkbox" id="toggleConfirmacao" data-plugin="switchery" data-color="#3bafda" data-size="small" checked>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-9 col-md-9 col-lg-5">
                                            <label for="toggleCancelamento"><strong>Cancelamento</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-3 col-md-3 col-lg-2">
                                            <input type="checkbox" id="toggleCancelamento" data-plugin="switchery" data-color="#3bafda" data-size="small" checked>

                                        </div>
                                    </div>
                                    <div class="tit-opcoes-notificacao tit-not-mob">
                                        <span>Quais notificações deseja receber no Celular?</span>
                                    </div>
                                    <div class="row">

                                        <div class="tit-opc-not col-9 col-md-9 col-lg-5">
                                            <label for="toggleLembreteMobile"><strong>Lembrete</strong> de consulta ou
                                                exame</label>
                                        </div>
                                        <div class="col-3 col-md-3 col-lg-2">
                                            <input type="checkbox" id="toggleLembreteMobile" data-plugin="switchery" data-color="#3bafda" data-size="small">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-9 col-md-9 col-lg-5">
                                            <label for="toggleConfirmacaoMobile"><strong>Confirmação</strong> de
                                                consulta ou exame</label>
                                        </div>
                                        <div class="col-3 col-md-3 col-lg-2">
                                            <input type="checkbox" id="toggleConfirmacaoMobile" data-plugin="switchery" data-color="#3bafda" data-size="small" checked>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tit-opc-not col-9 col-md-9 col-lg-5">
                                            <label for="toggleCancelamentoMobile"><strong>Cancelamento</strong> de
                                                consulta ou exame</label>
                                        </div>
                                        <div class="col-3 col-md-3 col-lg-2">
                                            <input type="checkbox" id="toggleCancelamentoMobile" data-plugin="switchery" data-color="#3bafda" data-size="small">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sugestões -->

                            <div class="tab-pane fade" id="v-pills-sugestoes" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <span class="label-titulo">Avalie o Doctor Hoje</span>
                                        <p>Deixe sua avaliação e nos ajude a deixar o Doctor Hoje melhor ainda.</p>
                                        <p>Dê uma nota de 1 a 5 estrelas para cada tópico abaixo, sendo 1 para
                                            péssimo e
                                            5 para excelente.</p>
                                        <div class="nota-avaliacao nota-servico">
                                            <p>Serviço</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input" id="servico-nota-5" name="rating-input-servico">
                                                <label for="servico-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="servico-nota-4" name="rating-input-servico">
                                                <label for="servico-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="servico-nota-3" name="rating-input-servico">
                                                <label for="servico-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="servico-nota-2" name="rating-input-servico">
                                                <label for="servico-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="servico-nota-1" name="rating-input-servico">
                                                <label for="servico-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-navegacao">
                                            <p>Navegação</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input" id="navegacao-nota-5" name="rating-input-navegacao">
                                                <label for="navegacao-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="navegacao-nota-4" name="rating-input-navegacao">
                                                <label for="navegacao-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="navegacao-nota-3" name="rating-input-navegacao">
                                                <label for="navegacao-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="navegacao-nota-2" name="rating-input-navegacao">
                                                <label for="navegacao-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="navegacao-nota-1" name="rating-input-navegacao">
                                                <label for="navegacao-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-organizacao">
                                            <p>Organização</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input" id="organizacao-nota-5" name="rating-input-organizacao">
                                                <label for="organizacao-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="organizacao-nota-4" name="rating-input-organizacao">
                                                <label for="organizacao-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="organizacao-nota-3" name="rating-input-organizacao">
                                                <label for="organizacao-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="organizacao-nota-2" name="rating-input-organizacao">
                                                <label for="organizacao-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="organizacao-nota-1" name="rating-input-organizacao">
                                                <label for="organizacao-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-facilidade">
                                            <p>Facilidade</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input" id="facilidade-nota-5" name="rating-input-facilidade">
                                                <label for="facilidade-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="facilidade-nota-4" name="rating-input-facilidade">
                                                <label for="facilidade-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="facilidade-nota-3" name="rating-input-facilidade">
                                                <label for="facilidade-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="facilidade-nota-2" name="rating-input-facilidade">
                                                <label for="facilidade-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="facilidade-nota-1" name="rating-input-facilidade">
                                                <label for="facilidade-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                        <div class="nota-avaliacao nota-atendimento">
                                            <p>Rede de Atendimento</p>
                                            <span class="rating">
                                                <input type="radio" class="rating-input" id="atendimento-nota-5" name="rating-input-atendimento">
                                                <label for="atendimento-nota-5" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="atendimento-nota-4" name="rating-input-atendimento">
                                                <label for="atendimento-nota-4" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="atendimento-nota-3" name="rating-input-atendimento">
                                                <label for="atendimento-nota-3" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="atendimento-nota-2" name="rating-input-atendimento">
                                                <label for="atendimento-nota-2" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="atendimento-nota-1" name="rating-input-atendimento">
                                                <label for="atendimento-nota-1" class="rating-star"></label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <span class="label-titulo">Mais alguma sugestão?</span>
                                        <p>Deixe sua avaliação e nos ajude a deixar o Doctor Hoje melhor ainda.</p>
                                        <form>
                                            <div class="form-group">
                                                <textarea class="form-control" id="textareaSugestao" rows="6"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-vermelho">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Sair -->

                            <div class="tab-pane fade" id="v-pills-sair" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="itens-sair">
                                    <span class="label-titulo">Obrigado por usar o Doctor Hoje</span>
                                </div>
                                <div class="itens-sair">
                                    <img src="/libs/home-template/img/doctor-hoje-notebook.png" alt="">
                                </div>
                                <div class="itens-sair">
                                    <span>Você tem certeza que deseja sair?</span>
                                    <div class="btns-sair">
                                        <button type="button" class="btn btn-light" onclick="window.location.href='{{ route("logout") }}'">
                                            Sim
                                        </button>
                                        <button type="submit" class="btn btn-vermelho">Não</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var laravel_token = '{{ csrf_token() }}';
                var resizefunc = [];

                $('#btn-add-dependente').click(function () {

                    var result = true;
                    var nm_primario_dependente = $('#inputNomeDependente');

                    if (nm_primario_dependente.val().length == 0) {
                        nm_primario_dependente.parent().addClass('cvx-has-error');
                        nm_primario_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#inputNomeDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var nm_secundario_dependente = $('#inputNmSecundarioDependente');

                    if (nm_secundario_dependente.val().length == 0) {
                        nm_secundario_dependente.parent().addClass('cvx-has-error');
                        nm_secundario_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#inputNmSecundarioDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var tp_documento = $('#tp_documento_dependente');

                    if (tp_documento.val() == '') {
                        tp_documento.parent().addClass('cvx-has-error');
                        tp_documento.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#tp_documento_dependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var nr_documento = $('#te_documento_dependente');

                    if (nr_documento.val().length == 0) {
                        nr_documento.parent().addClass('cvx-has-error');
                        nr_documento.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#te_documento_dependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var sexo_dependente = $('#selectGeneroDependente');

                    if (sexo_dependente.selectedIndex == 0) {
                        sexo_dependente.parent().addClass('cvx-has-error');
                        sexo_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#selectGeneroDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var dt_nasc_dia_dependente = $('#selectDiaDependente');

                    if (dt_nasc_dia_dependente.val() == '') {
                        dt_nasc_dia_dependente.parent().addClass('cvx-has-error');
                        dt_nasc_dia_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#selectDiaDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var dt_nasc_mes_dependente = $('#selectMesDependente');

                    if (dt_nasc_mes_dependente.val() == '') {
                        dt_nasc_mes_dependente.parent().addClass('cvx-has-error');
                        dt_nasc_mes_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#selectMesDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var dt_nasc_ano_dependente = $('#selectAnoDependente');

                    if (dt_nasc_ano_dependente.val() == '') {
                        dt_nasc_ano_dependente.parent().addClass('cvx-has-error');
                        dt_nasc_ano_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#selectAnoDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    var parentesco_dependente = $('#selectParentescoDependente');

                    if (parentesco_dependente.val() == '') {
                        parentesco_dependente.parent().addClass('cvx-has-error');
                        parentesco_dependente.parent().append('<span class="help-block text-danger"><strong>Campo Obrigatório</strong></span>');

                        $('#selectParentescoDependente').keypress(function () {
                            $(this).parent().removeClass('cvx-has-error');
                            $(this).parent().find('span.help-block').remove();
                        });

                        result = false;
                    }

                    if (!result) {
                        return false;
                    }

                    $('#btn-add-dependente').attr('disabled', 'disabled')
                    $('#lbl-add-dependente').html('Enviando <i class="fa fa-spin fa-spinner" style="display: inline-block; float: right; font-size: 16px;"></i>');

                    var nome_dep = nm_primario_dependente.val();
                    var sobrenome_dep = nm_secundario_dependente.val();
                    var tp_documento_dep = tp_documento.val();
                    var nr_documento_dep = nr_documento.val();
                    var sexo_dep = sexo_dependente.val();
                    var parentesco_dep = parentesco_dependente.val();
                    var dia_nasc_dep = dt_nasc_dia_dependente.val();
                    var mes_nasc_dep = dt_nasc_mes_dependente.val();
                    var ano_nasc_dep = dt_nasc_ano_dependente.val();
                    var paciente_id = $('#inputPacienteId').val();

                    jQuery.ajax({
                        type: 'POST',
                        url: '/add-dependente',
                        data: {
                            'nome': nome_dep,
                            'sobrenome': sobrenome_dep,
                            'tp_documento': tp_documento_dep,
                            'nr_documento': nr_documento_dep,
                            'sexo': sexo_dep,
                            'parentesco': parentesco_dep,
                            'dia_nasc': dia_nasc_dep,
                            'mes_nasc': mes_nasc_dep,
                            'ano_nasc': ano_nasc_dep,
                            'paciente_id': paciente_id,
                            '_token': laravel_token
                        },
                        success: function (result) {

                            if (result.status) {

                                var dependente = JSON.parse(result.dependente);
                                $('#lbl-no-dependents').empty();
                                var index = ($('#lista-dependentes').find('div.dependente').length) + 1;

                                var content = '<div class="dependente"> \
                                  <div class="row"> \
	                                  <div class="col-md-10"> \
	                                      <span class="nm-dependente"><strong>Dep0' + index + '</strong>: ' + dependente.nm_primario + ' ' + dependente.nm_secundario + '</span> \
	                                      <input type="hidden" id="dependente_' + dependente.id + '" class="dependente_id" value="' + dependente.id + '"> \
	                                  </div> \
	                                  <div class="col-md-2"> \
	                                  	  <a class="exclui-dependente"><i class="fa fa-trash"></i></a> \
	                                  </div> \
	                              </div> \
	                          	</div>';

                                $('#modalAdicionaDependente').find('input.form-control').val('');
                                $('#modalAdicionaDependente').find('select.form-control').prop('selectedIndex', 0);

                                $('#modalAdicionaDependente').modal('toggle');
                                $('#lista-dependentes').append(content);

                                $.Notification.notify('success', 'top right', 'DrHoje', result.mensagem);
                            }

                            $('#btn-add-dependente').removeAttr('disabled')
                            $('#lbl-add-dependente').html('Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                        },
                        error: function (result) {
                            $('#btn-add-dependente').removeAttr('disabled')
                            $('#lbl-add-dependente').html('Adicionar <i class="fa fa-spin fa-spinner" style="display: none; float: right; font-size: 16px;"></i>');
                            $.Notification.notify('error', 'top right', 'DrHoje', 'Falha na operação!');
                        }
                    });

                });
            });

            /*********************************
             *
             * REMOVE PRODUTO DEPENDENTE E CARTÃO
             *
             *********************************/
            $(".exclui-dependente").on("click", function (event) {
                event.preventDefault();
                var element = $(this);
                if (confirm("Tem certeza que deseja excluir esse dependente?")) {

                    var paciente_id = $(element).parent().parent().find('.dependente_id').val();

                    jQuery.ajax({
                        type: 'POST',
                        url: '/delete-dependente',
                        data: {
                            'paciente_id': paciente_id,
                            '_token': laravel_token
                        },
                        success: function (result) {

                            var dependente = JSON.parse(result.dependente);
                            var num_dependentes = result.num_dependentes;

                            if (result.status) {

                                $(element).parent().parent().parent().remove();

                                for (var i = 0; i < num_dependentes; i++) {
                                    var index = i + 1;
                                    $('#lista-dependentes').find('div.dependente:eq(' + i + ')').find('span.nm-dependente').find('strong').html('Dep0' + index);
                                    //$('#lista-dependentes').find('div.dependente:eq(0)').find('span.nm-dependente').find('strong').html()
                                    //alert($('#lista-dependentes').find('div.dependente:eq('+i+')').find('span.nm-dependente').find('strong').html());
                                }
                                $.Notification.notify('success', 'top right', 'DrHoje', result.mensagem);
                            }
                        },
                        error: function (result) {
                            $.Notification.notify('error', 'top right', 'DrHoje', 'Falha na operação!');
                        }
                    });
                }
            });

            $(".exclui-cartao").on("click", function (event) {
                event.preventDefault();
                if (confirm("Tem certeza que deseja excluir esse cartão?")) {
                    $(this).parent().parent().parent().remove();
                }
            });

            /*********************************
             *
             * ATIVA TOOLTIP
             *
             *********************************/

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            /*********************************
             *
             * APAGA MENSAGEM
             *
             *********************************/

            $(".close-div").on("click", function (event) {
                event.preventDefault();
                if (confirm("Tem certeza que deseja apagar essa mensagem?")) {
                    $(this).parent().parent().parent().remove();
                }
            });

            /*********************************
             *
             * SWITCHERY
             *
             *********************************/

            var elem = document.querySelector('.email-lembrete');
            var init = new Switchery(elem, {
                size: 'small', // small, default, large
            });
            var elem = document.querySelector('.email-confirmacao');
            var init = new Switchery(elem, {
                size: 'small', // small, default, large
            });
            var elem = document.querySelector('.email-cancelamento');
            var init = new Switchery(elem, {
                size: 'small', // small, default, large
            });

            var elem = document.querySelector('.mobile-lembrete');
            var init = new Switchery(elem, {
                size: 'small', // small, default, large
            });
            var elem = document.querySelector('.mobile-confirmacao');
            var init = new Switchery(elem, {
                size: 'small', // small, default, large
            });
            var elem = document.querySelector('.mobile-cancelamento');
            var init = new Switchery(elem, {
                size: 'small', // small, default, large
            });
        </script>

    @endpush

@endsection