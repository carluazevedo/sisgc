<?php $this->load->view('templates/navbar'); ?>
<!-- Modal 'visualizar' -->
<div class="modal fade bs-example-modal-lg" id="modal-visualizar" tabindex="-1" role="dialog" aria-labelledby="VisualizarViagem">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<small><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></small> Visualizar viagem
				</h4>
			</div>
			<div class="modal-body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /Modal 'visualizar' -->

<!-- Modal 'remover' -->
<div class="modal fade bs-example-modal-sm" id="modal-remover" tabindex="-1" role="dialog" aria-labelledby="RemoverViagem">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<small><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></small> Remover viagem
				</h4>
			</div>
			<div class="modal-body">
				<p>Deseja realmente remover esta viagem?</p>
			</div>
			<div class="modal-footer">
				<form id="remover-viagem"></form>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-danger" id="remover" name="remover" form="remover-viagem">Remover</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /Modal 'remover' -->

<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1><?php echo $titulo_pagina; ?></h1>
				</div>
				<div class="table-responsive">
					<table class="table table-condensed table-hover"><!-- table-bordered -->
						<thead>
							<tr class="active">
								<th>NÚMERO DT</th>
								<th>STATUS</th>
								<th>DATA ENTRADA</th>
								<th>DATA SAÍDA</th>
								<th>MOTORISTA</th>
								<th>TRATOR</th>
								<th>REBOQUE</th>
								<th>TRANSPORTADORA</th>
								<th>ORIGEM</th>
								<th colspan="3">AÇÕES</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!$registros) : ?>
							<tr>
								<td class="text-center danger" colspan="12">Não há registros de viagens.</td>
							</tr>
							<?php else : ?>
								<?php foreach ($registros as $reg) : ?>
								<tr>
									<td><?php echo $reg->dt_num; ?></td>
									<?php echo $this->viagens_model->status_viagem_tb($reg->status_viagem); ?>
									<td><?php echo $this->viagens_model->formata_data_mysql($reg->entrada_data); ?></td>
									<td><?php echo $this->viagens_model->formata_data_mysql($reg->saida_data); ?></td>
									<td><?php echo $reg->motorista_nome; ?></td>
									<td><?php echo $reg->placa_trator; ?></td>
									<td><?php echo $reg->placa_reboque_1; ?></td>
									<td><?php echo $reg->transp_nome; ?></td>
									<td><?php echo $reg->operacao_nome.' - '.$reg->operacao_unidade; ?></td>
									<td class="acoes">
										<button type="button" class="btn btn-sm btn-success acao-visualizar" title="Visualizar">
											<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
										</button>
									</td>
									<td class="acoes">
										<button type="button" class="btn btn-sm btn-info acao-editar" title="Editar" value="<?php echo $reg->id; ?>" onclick="editarViagem(this)">
											<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
										</button>
									</td>
									<td class="acoes">
										<button type="button" class="btn btn-sm btn-danger acao-remover" title="Remover" value="<?php echo $reg->id; ?>" onclick="removerViagem(this)">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</button>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
						<tfoot>
							<!-- Última linha em branco da tabela -->
							<tr>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.table-responsive -->
			</div><!-- /.col-sm-12 -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>