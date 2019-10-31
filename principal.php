<div id="listagem" style="height:700px;">
	<input type="hidden" id="hidQtdLinhas" name="hidQtdLinhas" value="10">
	<input type="hidden" id="hidQtdPaginas" name="hidQtdPaginas">
	<div class="row">
		<div class="col-md-12" style="text-align:right;padding-bottom:20px;">
			<button type="button" class="btn btn-success" style="font-size:13px;width:100px;" id="btnCadastro">Cadastro</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<div style='margin:0px;padding:0px;' id='divListagem'>
					<table class='table table-striped' cellspacing='0' cellpadding='0' style='font-family:Arial;font-size:13px;width:100%;' id='tabela'></table>
				</div>
				<div class="clearfix"></div>
				<ul class="pagination justify-content-center" style="font-size:12px;" id="paginacao"></ul>
			</div>
		</div>
	</div>
</div>

<div id="cadastro" style="margin:0px;padding:5px;font-weight:bold;font-size:13px;">
	<input type='hidden' id='hidID' name='hidID'>
	<div class='form-row'>
		<div class='form-group col-md-6'>
			<label for='txtNome'>Nome:</label>
			<input type='text' class="form-control form-control-sm" id='txtNome' name='txtNome'>
		</div>
		<div class='form-group col-md-6'>
			<label for='txtEmail'>E-mail/Login:</label>
			<input type='email' class="form-control form-control-sm" id='txtEmail' name='txtEmail'>
		</div>
	</div>
	<div class='form-row'>
		<div class='form-group col-md-6'>
			<label for='txtSenha'>Senha:</label>
			<input type='password' class="form-control form-control-sm" id='txtSenha' name='txtSenha'>
		</div>
		<div class='form-group col-md-6'>
			<label for='txtConfSenha'>Confirmação de Senha:</label>
			<input type='password' class="form-control form-control-sm" id='txtConfSenha' name='txtConfSenha'>
		</div>
	</div>
	<div class='form-row'>
		<div class='form-group col-md-6'>
			<label for='txtLogin'>Telefone:</label>
			<input type='text' class="form-control form-control-sm" id='txtTelefone' name='txtTelefone' maxlength="14">
		</div>
	</div>
	<div class='form-row' style='padding:0px;'>
		<div class='form-group col-md-6' style='text-align:right;'>
			<button type='submit' class='btn btn-primary' id='btnSalvar'>Salvar</button>
		</div>
		<div class='form-group col-md-6'>
			<button type='button' class='btn btn-primary' id='btnVoltar'>Voltar</button>
		</div>
	</div>
</div>