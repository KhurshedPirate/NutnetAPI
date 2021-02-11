<!Doctype HTML>
<html lang="ru">
<head>

	<title>To DB adder</title>
	<script src="jquery.min.js"></script>
	<meta http-equiv="charset" content="utf-8">
	
</head>

<body>
<form action="add.php" method="POST">
<table align="center" style ="Margin-top:20px;">
	<tr>
		<td align="left" >Name:</td>
		<td><input type="text" class="nameField" placeholder="Введите имя" name="name"></td>
	</tr>
	<tr>
		<td align="left">Surname:</td>
		<td><input type="text" class="surnameField" placeholder="Введите фамилию" name="surname"></td>
	</tr>
	<tr>
		<td align="left">Age:</td>
		<td><input type="text"  class="age" placeholder="Введите ваш возраст" name="age"></td>
	</tr>
	<tr> <td></br></td> </tr>
	<tr>
		<td align="center"><input type="button" value="Сохранить" name="add" class="button"></td>
		<td align="center"><input type="submit" class="Upload" name="Upload" value="Выгрузить"><td>
	</tr>
</table>
</form>

<p></p>

<table class="rows">

</table>

<script>
jQuery(document).ready(function() {
    jQuery(".button").bind("click", function() {

        var name = jQuery('.nameField').val();
		var surname = jQuery('.surnameField').val();
		var age = jQuery('.age').val();
        
		jQuery('.nameField').val('');
		jQuery('.surnameField').val('');
		jQuery('.age').val('');
		
        jQuery.ajax({
            url: "add.php",
            type: "POST",
            data: {name:name, surname:surname, age: age}, 
            dataType: "json",
            success: function(result) {
                if (result){ 
					jQuery('.rows tr').remove();
                    jQuery('.rows').append(function(){
						var res = '<tr><td>ID</td><td>Имя</td><td>Фамилия</td> <td>Возрасть</td></tr>';
						
						for(var i = 0; i < result.users.name.length; i++){
							res += '<tr><td>' + result.users.id[i] + '</td><td>' + result.users.name[i] + '</td><td>' + result.users.surname[i] + '</td><td align="right">' + result.users.age[i] + '</td></tr>';
						}
							return res;
					});
					console.log(result);
                }else{
                    alert(result.message);
                }
				return false;
            }
        });
	return false;
    });
});
</script>
</body>



</html>