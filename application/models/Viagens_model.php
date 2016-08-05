<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viagens_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function listar_registros($tabela, $colunas = '') {
		$this->db->select($colunas);
		$query = $this->db->get($tabela);
		return $query->result();
		/* return $query->result_array(); */
	}

	public function buscar_registro($tabela, $id) {
		$this->db->where('id', $id);
		$query = $this->db->get($tabela);
		return $query->row();
	}

	public function registrar($tabela, $dados) {
		$this->db->insert($tabela, $dados);
		if ($this->db->affected_rows() == '1') {
			return true;
		}
		return false;
	}

	public function editar_registro($tabela, $id, $dados) {
		$this->db->where('id', $id);
		$this->db->update($tabela, $dados);
		if ($this->db->affected_rows() == '1') {
			return true;
		}
		return false;
	}

	public function remover($tabela, $id) {
		$this->db->where('id', $id);
		$this->db->delete($tabela);
		if ($this->db->affected_rows() == '1') {
			return true;
		}
		return false;		
	}

	/* Funções para tratamento de exibição de dados */
	public function usuario_atual() {
		$string = $this->session->userdata('identity');
		$exploded = explode('@', $string);
		$identidade = array_shift($exploded);
		return $identidade;
	}

	public function formata_data_mysql($data_mysql) {
		if ($data_mysql == 0) {
			return '-';
		} else {
			$data = date_format(date_create($data_mysql), 'd/m/Y H:i');
			return $data;
		}
	}

	public function status_viagem_tb($status) {
		$status_contexto = array('info','warning','success','danger');
		$status_texto    = array('NOVA VIAGEM','EM PÁTIO','FINALIZADA','CANCELADA');
		$status_retorno = sprintf('<td class="%s">%s</td>', $status_contexto[$status], $status_texto[$status]);
		return $status_retorno.PHP_EOL;
	}

	public function status_viagem_pn($status, $elemento) {
		$status_contexto = array('label-info','label-warning','label-success','label-danger');
		$status_texto    = array('NOVA VIAGEM','EM PÁTIO','FINALIZADA','CANCELADA');
		switch ($elemento) {
			case 'contexto':
				return $status_contexto[$status];
				break;
			case 'texto':
				return $status_texto[$status];
				break;
		}
	}

	public function ultimo_id() {
		if ($this->db->insert_id() != 0) {
			return $this->db->insert_id();
		} else {
			$query = $this->db->query('SELECT LAST_INSERT_ID()');
			$row = $query->row_array();
			return $row['LAST_INSERT_ID()'];
		}
	}

	/* Funções para exibição dos dados no formulário */
	public function inicializar_valores() {
		$valores_em_branco = array(
			'dt_num'               => '',
			'motorista_cpf'        => '',
			'motorista_nome'       => '',
			'placa_trator'         => '',
			'placa_reboque_1'      => '',
			'placa_reboque_2'      => '',
			'transp_nome'          => '',
			'transp_unidade'       => '',
			'operacao_nome'        => '',
			'operacao_unidade'     => '',
			'notas_fiscais'        => '',
			'valor'                => '000',
			'peso'                 => '0000',
			'ent_unic'             => '',
			'ent_frac'             => '',
			'transfer'             => '',
			'circ_est'             => '',
			'hpc'                  => '',
			'foods'                => '',
			'hpc_foods'            => '',
			'destinatario_cnpj'    => '',
			'destinatario_nome'    => '',
			'destinatario_unidade' => '',
			'rota'                 => '',
			'observacoes'          => ''
		);
		return $valores_em_branco;
	}

	public function preencher_valores($tabela, $id) {
		$valores = $this->buscar_registro($tabela, $id);
		if (isset($valores)) {
			$valores_preenchidos['id']                   = $valores->id;
			$valores_preenchidos['status_viagem']        = $valores->status_viagem;
			$valores_preenchidos['entrada_data']         = $this->formata_data_mysql($valores->entrada_data);
			$valores_preenchidos['entrada_usuario']      = $valores->entrada_usuario;
			$valores_preenchidos['saida_data']           = $this->formata_data_mysql($valores->saida_data);
			$valores_preenchidos['saida_usuario']        = $valores->saida_usuario;
			$valores_preenchidos['carga_risco']          = $valores->carga_risco;
			$valores_preenchidos['carga_escolta']        = $valores->carga_escolta;
			$valores_preenchidos['dt_num']               = $valores->dt_num;
			$valores_preenchidos['motorista_cpf']        = $valores->motorista_cpf;
			$valores_preenchidos['motorista_nome']       = $valores->motorista_nome;
			$valores_preenchidos['placa_trator']         = $valores->placa_trator;
			$valores_preenchidos['placa_reboque_1']      = $valores->placa_reboque_1;
			$valores_preenchidos['placa_reboque_2']      = $valores->placa_reboque_2;
			$valores_preenchidos['transp_nome']          = $valores->transp_nome;
			$valores_preenchidos['transp_unidade']       = $valores->transp_unidade;
			$valores_preenchidos['operacao_nome']        = $valores->operacao_nome;
			$valores_preenchidos['operacao_unidade']     = $valores->operacao_unidade;
			$valores_preenchidos['notas_fiscais']        = $valores->notas_fiscais;
			$valores_preenchidos['valor']                = $valores->valor;
			$valores_preenchidos['peso']                 = $valores->peso;
			$valores_preenchidos['ent_unic']             = ($valores->entrega_tipo == 'ent_unic') ? true : '' ;
			$valores_preenchidos['ent_frac']             = ($valores->entrega_tipo == 'ent_frac') ? true : '' ;
			$valores_preenchidos['transfer']             = ($valores->entrega_tipo == 'transfer') ? true : '' ;
			$valores_preenchidos['circ_est']             = ($valores->entrega_tipo == 'circ_est') ? true : '' ;
			$valores_preenchidos['hpc']                  = ($valores->mercadoria_tipo == 'hpc') ? true : '' ;
			$valores_preenchidos['foods']                = ($valores->mercadoria_tipo == 'foods') ? true : '' ;
			$valores_preenchidos['hpc_foods']            = ($valores->mercadoria_tipo == 'hpc_foods') ? true : '' ;
			$valores_preenchidos['destinatario_cnpj']    = $valores->destinatario_cnpj;
			$valores_preenchidos['destinatario_nome']    = $valores->destinatario_nome;
			$valores_preenchidos['destinatario_unidade'] = $valores->destinatario_unidade;
			$valores_preenchidos['rota']                 = $valores->rota;
			$valores_preenchidos['observacoes']          = $valores->observacoes;
		}
		return $valores_preenchidos;
	}
}
