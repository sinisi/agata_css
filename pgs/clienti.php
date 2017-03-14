<?php 
	$t='clienti';
	$url='?p='.$t;
	if (!empty($_REQUEST['del'])) : 
		$rec=R::load($t, intval($_REQUEST['del']));
		try{
			R::trash($rec);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	if (!empty($_POST['nome'])) : 
		if (empty($_POST['id'])){
			$rec=R::dispense($t);
		}else{
			$rec=R::load($t,intval($_POST['id']));
		}
		foreach ($_POST as $key=>$value){
			$rec[$key]=$value;
		}
		try {
			$id=R::store($rec);
		} catch (RedBeanPHP\RedException\SQL $e) {
			?>
			<h4 class="msg label error">
				<?=$e->getMessage()?>
			</h4>
			<?
		}	
	endif;
	
	$data=R::findAll($t);
?>

<h1>
	Clienti
	
</h1>
<section class="">
	<?php foreach ($data as $dt) : ?>
		<article style="text-align:center;">
			<form method="post" action="<?=$url?>">
				<input name="nome"  value="<?=$dt->nome?>"/>
				<input type="hidden" name="id" value="<?=$dt->id?>" />
				<button type="submit" tabindex="-1" class="btn btn-success">
					Salva
				</button>
				<a href="<?=$url?>&del=<?=$dt['id']?>" class="btn btn-danger" tabindex="-1">
					Elimina
				</a>					
			</form> <br />
		</article>
	<?php endforeach; ?>
	<article style="text-align:center;" class="card cc"> <br />
		<form method="post" action="<?=$url?>">
			<input name="nome" placeholder="Nuova voce" autofocus />
			<button type="submit" class="btn btn-info">
				Inserisci
			</button>
		</form>
	</article>
</section>