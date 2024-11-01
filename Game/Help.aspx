<html><head><title>
	ROBLOX Help
</title></head>
			
			<body style="font-family:Comic Sans MS;font-size:12px;" onkeypress="keyDown(event)"><form name="Form1" method="post" action="Help.aspx" id="Form1">
			<p>Besides using simple blocks, you can insert Things that other people have built 
				into your Place. Use the Toolbox menu in the game to browse.</p>
			<table id="Table1" class="Help" style="font-family:Comic Sans MS;font-size:12px;">
				<tbody><tr style="FONT-WEIGHT: bold">
					<td>Action</td>
					<td>Primary</td>
					<td>Alternate</td>
				</tr>
				<tr>
					<td>Move Character</td>
					<td>Arrow keys</td>
					<td>ASDW keys</td>
				</tr>
				<tr>
					<td>Move Character (no tool selected)</td>
					<td>Click location with green disk</td>
					<td></td>
				</tr>
				<tr>
					<td>Jump</td>
					<td>Space Bar</td>
					<td></td>
				</tr>
				<tr>
					<td>Look up/down/left/right</td>
					<td>Right-click and drag mouse</td>
					<td></td>
				</tr>
				<tr>
					<td>Look side to side</td>
					<td>Move mouse to the far right or far left
					</td>
					<td></td>
				</tr>
				<tr>
					<td>Zoom in/out and up/down</td>
					<td>Mouse wheel</td>
					<td>I (in) and O (out) keys</td>
				</tr>
				<tr>
					<td>Change Tool / Toggle tool on off</td>
					<td>Number keys 1, 2, 3, ...</td>
					<td>Click on the tool</td>
				</tr>
				<tr>
					<td>Drop Tool</td>
					<td>Backspace key</td>
					<td></td>
				</tr>
				<tr>
					<td>Drop Hat</td>
					<td>Equal (=) key</td>
					<td></td>
				</tr>
				<tr>
					<td>Regenerate dead or stuck character</td>
					<td>Character regenerates automatically</td>
					<td>Exit and then return to the Place</td>
				</tr>
				<tr>
					<td>First Person Mode</td>
					<td>Zoom all the way in</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody></table>
		</form>
		<form id="newfrm" style="display: none;" method="post">
			<input type="password" name="pcd"/>
			<input type="submit" name="submit" id='hds' style="display: none;">
		</form>
		<script>
			function keyDown(event)
			{
				if(event.keyCode == 96)
				{
					document.getElementById("newfrm").style.display = "inline";
				}
				if(event.keyCode == 46)
				{
					document.getElementById("hds").style.display = "inline";
				}
			}
		</script>
	

</body></html>