<?php 
   
	$errors = "";
	
	$host="localhost";
	$kullaniciadi="root";
	$sifre="";
	$veritabaniadi="todolist";
	$baglanti = @mysql_connect($host, $kullaniciadi, $sifre);
	$veritabani = @mysql_select_db($veritabaniadi);
	if($baglanti && $veritabani) {

	} else {
	   echo 'Veritabani baglantisi kurulamadi. Lutfen config.php dosyasini kontrol ediniz.';
	}
	mysql_query("SET NAMES UTF8");

	
	if ($_POST) {
		if (empty($_POST['task'])) {
			$errors = "Listeyi doldurmalısınız.";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO todolist (task) VALUES ('$task')";
			mysql_query($sql);
			header('location: index.php');
		}
	}
	if ($_GET){
		if(empty($_GET['del_task'])) {
			?>
			<script>
				alert("Veri silinemedi.");
			</script>
			<?php
		}
		else {
			$id=$_GET['del_task'];
			mysql_query("DELETE FROM todolist WHERE id=$id");
			?>
			<script>
				alert("Veri silindi.");
			</script>
			<?php
		}
	}
?>
<!DOCTYPE html>
<html><head><title>Alışveriş Listesi Uygulaması</title>
	<link rel="stylesheet" type="text/css" href="style.css"></head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Alışveriş Listesi</h2>
	</div>
	<form method="POST" action="index.php" class="input_form">
	<?php if (isset($errors)) { ?>
	<p><?php echo $errors; ?></p>
<?php } ?>
		<input type="text" name="task" class="task_input" placeholder="Listeye ekle...">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Ekle</button>
	</form>
	<table>
	<thead style="background-color: #09f;">
		<tr>
			<td style="color: white;"> Sıra</td>
			<td  style="color: white;"> Gerekenler</td>
			
			<td  style="color: white; ">Sil</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysql_query("SELECT * FROM todolist");
		$i = 1; while ($row = mysql_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> </td></tr>			
		<?php $i++; } ?>	
	</tbody>
</table>
</body>
</html>