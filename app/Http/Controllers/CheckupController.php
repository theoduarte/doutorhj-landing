<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as CVXCart;
use Illuminate\Support\Facades\Request as CVXRequest;
use App\Checkup;
use App\Clinica;

/**
 * @author Frederico Cruz <frederico.cruz@comvex.com.br>
 * 
 */
class CheckupController extends Controller
{
    /**
     * Consulta tipos de check-up em função do título.
     * 
     * @param string $titulo
     * @return Collection
     */
    public function getTipoCheckupAtivo()
    {
        return DB::table('checkups')
                 ->select('checkups.tipo')
                 ->where('checkups.cs_status', \App\Checkup::ATIVO)
                 ->distinct()
                 ->where(DB::Raw('to_str(checkups.titulo)'), UtilController::toStr(CVXRequest::get('tipo_atendimento')))
                 ->get();
    }
    
    /**
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function resultadoCheckup()
    {

        $checkup = new Checkup;
        $checkups = $checkup->getActive();
        $checkupObj = Checkup::find(CVXRequest::get('tipo_especialidade'));

        $consulta = $this->_consultaCheckup( CVXRequest::all() );

        return view('checkup.resultado', compact('checkups', 'consulta', 'checkupObj'));
    }
    
    /**
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function carrinhoCheckup()
    {
        return view('checkup.carrinho');
    }
    
    /**
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function pagamentoCheckup()
    {
        return view('checkup.pagamento');
    }

    /**
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function confirmacaoCheckup()
    {
        return view('checkup.confirmacao');
    }
    
    /**
     * Consulta check-up utilizado na busca de landing.
     * 
     * @return array
     */
    private function _consultaCheckup(array $dados)
    {
        $tipoEspecialidade = $dados['tipo_especialidade'];
        
        $resumo = DB::table('atendimentos')
                    ->select(['checkups.id', 'clinicas.nm_razao_social', 'clinicas.id AS idclinica', 'clinicas.obs_procedimento', 'atendimentos.id AS idatendimento', 'enderecos.te_endereco', 'enderecos.te_bairro',
                              'cidades.nm_cidade', 'estados.sg_estado', 'procedimentos.cd_procedimento', 
                              'procedimentos.ds_procedimento', 'item_checkups.vl_com_checkup', 'item_checkups.vl_net_checkup', 
                              'item_checkups.vl_mercado', 'item_checkups.ds_item', 'consultas.cd_consulta', 'consultas.ds_consulta', 
                              'especialidades.ds_especialidade', 'checkups.titulo', 'checkups.tipo', 'atendimentos.vl_com_atendimento',
                              'atendimentos.vl_net_atendimento', 'item_checkups.ds_categoria', 'atendimentos.ds_preco', 'tag_populars.cs_tag', 'profissionals.nm_primario', 'profissionals.nm_secundario'])
                    ->join('clinicas', 'atendimentos.clinica_id', '=', 'clinicas.id')
                    ->leftjoin('consultas', 'atendimentos.consulta_id', '=', 'consultas.id')
                    ->leftjoin('procedimentos', 'atendimentos.procedimento_id', '=', 'procedimentos.id')
                    ->leftjoin('especialidades', 'especialidades.id', '=', 'consultas.especialidade_id')
                    ->leftjoin('profissionals', 'profissionals.id', '=', 'atendimentos.profissional_id')
                    ->join('item_checkups', 'atendimentos.id', '=', 'item_checkups.atendimento_id')
                    ->join('checkups', 'checkups.id', '=', 'item_checkups.checkup_id')
                    ->join('clinica_endereco', 'clinica_endereco.clinica_id', '=', 'atendimentos.clinica_id')
                    ->leftJoin('tag_populars', function($join) { $join->on('tag_populars.procedimento_id', '=', 'procedimentos.id')->orOn('tag_populars.consulta_id', '=', 'consultas.id');})
                    ->join('enderecos', 'enderecos.id', '=', 'clinica_endereco.endereco_id')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.id')
                    ->join('estados', 'estados.id', '=', 'cidades.estado_id')
                    ->whereNotNull('item_checkups.vl_com_checkup')
                    ->whereNotNull('item_checkups.vl_net_checkup')
                    // ->where('clinicas.cs_status', \App\Clinica::ATIVO)
                    // ->where('atendimentos.cs_status', \App\Clinica::ATIVO)
                    ->where( function($query) use ($tipoEspecialidade) {
                        if ( !empty($tipoEspecialidade) ) { $query->where('checkups.id', $tipoEspecialidade); }
                    } )
                    ->distinct()
                    ->orderBy('id', 'asc')
                    ->orderBy('ds_categoria', 'asc')
                    ->get();

        return $this->_trataVetorConsultaCheckup($resumo);
    }
    
    /**
     * Monta vetor agrupando resultado da busca por camadas.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $resumo
     * @return array|number
     */
    private function _trataVetorConsultaCheckup(Collection $resumo)
    {
        $dados                 = [];
        $arQtCamadas           = [];
        $totalComCheckup       = 0;
        $totalNetCheckup       = 0;
        $totalVlMercado        = 0;
        $totalVlComAtendimento = 0;
        $qtTotalProcedimentos  = 0;
        $dsCheckupAnterior     = '';

        $checkup = new Checkup;
        
        foreach($resumo as $p){
            
            $summary = $checkup->getSummary( $p->id );

            $dados[$p->titulo.'-'.$p->tipo]['summary'] = $summary;

            if ( $dsCheckupAnterior != $p->titulo.'-'.$p->tipo ){
                @$arQtCamadas[$p->titulo.'-'.$p->tipo] = [];
                $totalComCheckup = 0;
                $totalNetCheckup = 0;
                $totalVlMercado  = 0;
                $totalVlComAtendimento = 0;
                $qtTotalProcedimentos = 0;
                $dsCheckupAnterior = $p->titulo.'-'.$p->tipo;
            }
            $clinica_temp = Clinica::findorfail($p->idclinica);
            $dados[$p->titulo.'-'.$p->tipo]['id'] = $p->id;
            $dados[$p->titulo.'-'.$p->tipo]['titulo'] = $p->titulo;
            $dados[$p->titulo.'-'.$p->tipo]['tipo'] = $p->tipo;
            $dados[$p->titulo.'-'.$p->tipo]['prestador'] = $p->nm_razao_social;
            $dados[$p->titulo.'-'.$p->tipo]['endereco'] = $p->te_endereco . ' ' . $p->te_bairro . ' - ' . $p->nm_cidade .'/'.$p->sg_estado;
            
            if(!empty($p->cd_consulta)) {
            	$dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['idatendimento'] = $p->idatendimento;
            	$dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['descricao'] = $p->cs_tag ? mb_strtoupper($p->cs_tag) : mb_strtoupper($p->ds_preco);
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['prestador'] = $p->nm_razao_social;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['endereco'] = $p->te_endereco . ' ' . $p->te_bairro . ' - ' . $p->nm_cidade .'/'.$p->sg_estado;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['obs_procedimento'] = $p->obs_procedimento;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['nm_profissional'] = $p->nm_primario . ' ' . $p->nm_secundario;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_consulta]['tp_prestador'] = $clinica_temp->tp_prestador;
            }
            elseif( !empty($p->cd_procedimento) ) {
            	$dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['idatendimento'] = $p->idatendimento;
            	$dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['descricao'] = $p->cs_tag ? mb_strtoupper($p->cs_tag) : mb_strtoupper($p->ds_preco);
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['prestador'] = $p->nm_razao_social;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['endereco'] = $p->te_endereco . ' ' . $p->te_bairro . ' - ' . $p->nm_cidade .'/'.$p->sg_estado;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['nm_profissional'] = null;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['ds_item'] = $p->ds_item;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['obs_procedimento'] = $p->obs_procedimento;
              $dados[$p->titulo.'-'.$p->tipo]['camadas'][$p->ds_categoria][$p->cd_procedimento]['tp_prestador'] = $clinica_temp->tp_prestador;
            }
            
            @$arQtCamadas[$p->titulo.'-'.$p->tipo][mb_strtoupper($p->ds_categoria) ] += 1;
            
            $totalComCheckup += $p->vl_com_checkup;
            $totalNetCheckup += $p->vl_net_checkup;
            $totalVlMercado  += $p->vl_mercado;
            $totalVlComAtendimento += $p->vl_com_atendimento;
            
            $dados[$p->titulo.'-'.$p->tipo]['total_com_checkup'] = UtilController::formataMoeda($totalComCheckup);
            $dados[$p->titulo.'-'.$p->tipo]['total_net_checkup'] = UtilController::formataMoeda($totalNetCheckup);
            $dados[$p->titulo.'-'.$p->tipo]['total_vl_mercado'] = UtilController::formataMoeda($totalVlMercado);
            $dados[$p->titulo.'-'.$p->tipo]['total_vl_individual'] = UtilController::formataMoeda($totalVlComAtendimento);
            $dados[$p->titulo.'-'.$p->tipo]['total_procedimentos'] = ++$qtTotalProcedimentos;
            $dados[$p->titulo.'-'.$p->tipo]['total_camadas'] = $arQtCamadas[$p->titulo.'-'.$p->tipo];
        }
      
        dd($dados);
        return $dados;
    }
}