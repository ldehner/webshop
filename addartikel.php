<?php
include_once('open.php');
$info->title('Artikel hinzufügen');
echo $info->gui->head;
?>
<div class="container">
		<h1>Artikel hinzufügen</h1>
	</div>
	<br>

	<div class="container hoverable z-depth-3">
        <form action="artikel.php?add=1" method="post" enctype="multipart/form-data">
		<br>
			<div class="row">
				<div class="center col s3 offset-s1">
                    <div class="input-field">
                        <input name="artname" id="artname" type="text" class="validate">
                        <label for="artname">Artikelname</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="price" name="price" step="0.01" min="0" max="1000" class="validate">
                        <label for="price">Preis</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="anz" name="anz" step="1" min="0" max="1000" class="validate">
                        <label for="anz">verfügbare Anzahl</label>
                    </div>

                    <div class="input-field">
                        <textarea type="text" name="beschreibung" class="materialize-textarea"></textarea>
                        <label for="beschreibung">Artikelbeschreibung</label>
                    </div>

                    <label>Artikelbilder auswählen</label>
                    <div class="file-field input-field">
                        <div class = "btn">
                            <span>Browse</span>
                            <input type="file" name="fileToUpload[]" multiple/>
                        </div>
                        <div class = "file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload multiple files"/>
                        </div>
                    </div>

                    <br>
                    <input class="modal-close waves-effect waves-green btn-flat" type="submit" value="Artikel hinzufügen">
                    <br>
                    <br>
				</div>
			</div>
        </form>
	</div>
<?php
echo $info->gui->footer;
?>
