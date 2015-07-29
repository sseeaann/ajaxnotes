<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AJAX NOTES</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	#container {
		margin: 10px auto;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		width: 970px;
	}
	
	#header{
		min-height: 50px;
		border-bottom: 1px solid #D0D0D0;
		padding: 10px;
		text-align: center;
	}
		h1 {
			color: white;
			font-size: 70px;
			font-weight: normal;
			margin: 0;
			text-shadow: 0px 0px 25px #0033ff;
		}

	#notesContent {
		margin: 0 15px 0 15px;
	}
		.notes{
			display: inline-block;
			border: 2px solid blue;
			box-shadow: 0 0 30px #000099;
			width: 275px;
			height: 250px;
			padding: 10px;
			margin: 10px 5px;
			background: linear-gradient(135deg, #0099ff, #fff);
			/*overflow: scroll;*/
		}
			#notesHead{
				border-bottom: 1px solid #fff;
				height: 50px;
			}
				.notes h4{
					color: #fff;
					text-shadow: 0px 0px 20px #000033;
					margin: 5px 0;
					width: 210px;
					min-height: 10px;
					display: inline-block;
				}

				#noteForm {
					text-decoration: none;
					margin-right: 0px;
					text-shadow: 0 0 20px white;
					vertical-align: top;
					display: inline-block;
				}

			#notesBody{
				height: 180px;
				overflow: scroll;
			}
				
				#noteP{
					width: 275px;
					height: 180px;
					word-wrap: break-word;
				}
	
	#addNotes {
		margin: 0 15px;
		border-top:1px solid #fff;
	}
	h3{
		margin-bottom: 0;
	}

	input{
		display: block;
		margin: 5px 0;
	}

	#addNote{
		background: linear-gradient(blue, #000099);
		border-radius: 5px;
		color: white;
		padding: 5px;
	}
	#textP, #noteP{
		width: 265px;
		height: 200px;
	}
	#textTitle{
		width: 200px;
		height: 20px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	</style>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).on('submit', 'form.addNoteForm', function(){
			// url, content, response, response method (json, html)
			$.post(
				$(this).attr('action'),
				$(this).serialize(),
				function(return_data){
					console.log(return_data);
					$("div#notesContent").append(
"<div class='notes'>"+
	"<div id='notesHead'>"+
		"<form class='addNoteForm' method='post' action='/notes_controller/updateTitle'>"+
			"<input type='hidden' name='noteID' value='"+return_data.row.id+"'>"+
			"<h4 id='noteTitle'>"+return_data.row.title+"</h4>"+
		"</form>"+
		"<form class='noteForm' method='post' action='/notes_controller/delete'>"+
			"<input type='hidden' name='noteID' value='"+return_data.row.id+"'>"+
			"<input type='submit' value='delete'>"+
		"</form>"+
	"</div>"+
	"<div>"+
		"<form class='addNoteBodyForm' method='post' action='/notes_controller/update'>"+
			"<input type='hidden' name='noteID' value='"+return_data.row.id+"'>"+
			"<p id='noteP'>"+" "+"</p>"+
		"</form>"+
	"</div>"+
	
"</div>");
				},
				"json"
			);	
			return false;
		});		
		$(document).on('submit','form.addNoteBodyForm', function(){
			$.post(
				$(this).attr('action'),
				$(this).serialize(),
				function(return_data)
				{
					console.log(return_data);
				},
				"json"
			);	
			return false;
		});

		$(document).on('submit','form.noteForm', function(){
			console.log($(this));
			$(this).parent().parent().remove();
			$.post(
				$(this).attr('action'),
				$(this).serialize(),
				function(data)
				{
					console.log('deleted');
					console.log(data);
				},
				"json"
			);
			return false;
		});

		$(document).on('click', '#noteP', function(){
			$(this).replaceWith($('<textarea id="textP" name="noteAppend">' + $(this).text() + '</textarea>'))
			$('#textP').focus();
		});
		$(document).on('blur', '#textP', function(){
			$(this).parent().submit();
			$(this).replaceWith($('<p id="noteP">' + $(this).val() + '</p>'));
		});

		$(document).on('click', '#noteTitle', function(){
			$(this).replaceWith($('<textarea id="textTitle" name="titleAppend">' + $(this).text() + '</textarea>'))
			$('#textTitle').focus();
		});
		$(document).on('blur', '#textTitle', function(){
			$(this).parent().submit();
			$(this).replaceWith($('<h4 id="noteTitle">' + $(this).val() + '</h4>'));
		});
	</script>
</head>
<body>

<div id="container">
	<div id="header">
		<h1>Ajax Notes</h1>
	</div>
	<div id="notesContent">
<?php 
	foreach($notes as $note)
	{
?>
		<div class="notes">
			<div id="notesHead">
				<form class="addNoteForm" method="post" action="/notes_controller/updateTitle">
				<input type="hidden" name="noteID" value="<?= $note['id'];?>">
				<h4 id="noteTitle"><?= $note['title'];?></h4>
				</form>
				<form class="noteForm" method="post" action="/notes_controller/delete">
					<input type="hidden" name="noteID" value="<?= $note['id'];?>">
					<input type="submit" value="delete">
				</form>
			</div>
			<div id="notesBody">
				<form class="addNoteBodyForm" method="post" action="/notes_controller/update">
					<input type="hidden" name="noteID" value="<?= $note['id'];?>">
					<p id="noteP"><?= $note['description']; ?></p>
				</form>
			</div>
		</div>
<?php } ?>
	</div>
	<div id="addNotes">
		<h3>Add Note:</h3>
			<form class="addNoteForm" method="post" action="/notes_controller/create">
				<input type="text" name="noteTitle" placeholder="Insert note title here...">
				<input id="addNote" type="submit" value="Add Note">
			</form>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>