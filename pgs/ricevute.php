<?php 
	$msg='';
	$tbl='ricevute';
	$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
	$record=(empty($_REQUEST['id'])) ?  R::dispense($tbl) : R::load($tbl, intval($_REQUEST['id']));
	if (!empty($_POST['clienti_id'])) :
			foreach ($_POST as $key=>$value){
				$record[$key]=$value;
			}
		try {
			R::store($record);
			$msg='Dati salvati correttamente ('.json_encode($record).') ';
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	
	if (!empty($_REQUEST['del'])) : 
		$record=R::load($tbl, intval($_REQUEST['del']));
		try{
			R::trash($record);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;
	
	$data=R::findAll($tbl, 'ORDER by id ASC LIMIT 999');
	$clienti=R::findAll('clienti');
	$new=!empty($_REQUEST['create']);
	
?>

<h1>
	
		<?=($id) ? ($new) ? 'Nuova ricevuta' : 'Ricevuta n. '.$id : 'Ricevute';?>
	
</h1>
<?php if ($id || $new) : ?>
		<form method="post" action="?p=<?=$tbl?>" class="form-group">
			<?php if ($id) : ?>
				<input type="hidden" name="id" value="<?=$record->id?>"/>
			<?php endif; ?>

			<label for="data">
				Data
			</label>
			<input name="data"  value="<?=date('Y-m-d',strtotime($record->data))?>" type="date" class="form-control" />
			
			<label for="clienti_id">
				Cliente
			</label>
			<select name="clienti_id" class="form-control">
				<option />
				<?php foreach ($clienti as $opt) : ?>
					<option value="<?=$opt->id?>" <?=($opt->id==$id) ? 'selected' :'' ?> >
						<?=$opt->nome?>
					</option>
				<?php endforeach; ?>
			</select>
			<label for="descrizione">
				Descrizione
			</label>
			<input name="descrizione"  value="<?=$record->descrizione?>" class="form-control" autofocus required  />			
			<label for="importo">
				Importo
			</label>			
			<input name="importo" value="<?=$record->importo?>" type="number" class="form-control" step="any" />
			<button type="submit" tabindex="-1" class="btn btn-success">
				Salva
			</button>
			
			<a href="?p=<?=$tbl?>" class="btn btn-info">
				Elenco
			</a>			
			
			<a href="?p=<?=$tbl?>&del=<?=$ma['id']?>" tabindex="-1" class="btn btn-danger">
				Elimina
			</a>					
		</form>
<?php else : ?>
<div class="container">
	<div class="table-responsive">
		<table class="table">
			<colgroup>
				<col style="width:50px" />
			</colgroup>
			<thead>
				<tr class="danger">
					<th>Cliente</th>
					<th>Data</th>
					<th>Descrizione</th>
					<th>Importo</th>
					<th>Modifica</th>
					<th>Cancella</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($data as $r) : ?>
				<tr>
					<td>
							<?=($r->clienti_id) ? $r->clienti->nome : ''?>
					</td>			
					<td>
						<?=date('d/m/Y',strtotime($r->data))?>
					</td>
					<td>
						<?=$r->descrizione?>
					</td>
					<td>
						<?=sprintf("%.2f",$r->importo)?>
					</td>			
					<td>
						<a href="?p=<?=$tbl?>&id=<?=$r['id']?>">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</a>
					</td>
					<td>
						<a href="?p=<?=$tbl?>&del=<?=$r['id']?>" tabindex="-1">
							<span style="color:red;" class="glyphicon glyphicon-trash" aria-hidden="true"></span>
						</a>
					</td>							
				</tr>		
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<h4 class="msg">
			<?=$msg?>
		</h4>	
	</div>
<?php endif; ?>
<a href="?p=<?=$tbl?>&create=1" class="btn btn-warning" style="margin:50px;">Inserisci nuovo</a>
<script>
	var chg=function(e){
		console.log(e.name,e.value)
		document.forms.frm.elements[e.name].value=(e.value) ? e.value : null
	}	
</script>