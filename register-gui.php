<?php
include_once('open.php');
$info->title('Registrierung');
echo $info->gui->head;
?>
    <div class="container">
		<h1>Registrieren</h1>
	</div>
	<br>
    <form action="user.php?register=1" method="post">
	<div class="container hoverable z-depth-3">
		<br>
		<div class="row">
			<div class="center col s3 offset-s1"><h5>Grundlegende Informationen</h5></div>
			<div class="col s6">
			    <div class="input-field">
					<input id="username" name="username" type="text" class="validate">
					<label for="username">Benutzername</label>
				</div>
				<div class="input-field">
					<input id="first_name" name="first_name" type="text" class="validate">
					<label for="first_name">Vorname</label>
				</div>
				<div class="input-field">
					<input id="last_name" name="last_name" type="text" class="validate">
					<label for="last_name">Nachname</label>
				</div>
				<div class="input-field">
					<input id="email" name="email" type="email" class="validate">
					<label for="email">E-Mail</label>
				</div>
				<div class="input-field">
					<input id="pw" name="pw" type="password" class="validate">
					<label for="pw">Passwort</label>
				</div>
				<div class="input-field">
					<input id="pwconf" type="password" class="validate">
					<label for="pwconf">Passwort-Bestätigung</label>
				</div>
				<p>
					<label>
						<input class="with-gap" name="ToUPP-acc" type="checkbox"  checked />
						<span>I agree to the <a>Terms of Use</a> and <a>Privacy Policy</a></span>
					</label>
				</p>
				<p>
				<!--<button class="btn waves-effect waves-light right" type="submit" name="action">Registrieren
					<i class="material-icons right">send</i>
				</button>-->
				<input class="modal-close waves-effect waves-green btn-flat" type="submit" value="Registrieren">
					<br>
					<br>
				</p>
			</div>
		</div>
	</div>
	<br>
	<center><p> Haben Sie schon ein Kundenkonto? <a href="#">Anmelden</a></p></center>
	<br>

	<div class="container hoverable z-depth-3">
		<br>
			<div class="row">
				<div class="center col s3 offset-s1">
					<h5>Erweiterte Informationen</h5>
					<div class="input-field">
						<select>
							<option value="" disabled selected>Staatsbürgerschaft</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
					<div class="input-field">
						<select>
							<option value="" disabled selected>Geschlecht</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
					<p>Adresse</p>
					<textarea style="height: 150px; width: 100%;"></textarea>
					<br>
					<br>
				</div>
				<div class="col s3 offset-s1">
					<div class="input-field">
						<input id="gebdat" type="text" class="datepicker">
						<label for="gebdat">Geburtsdatum</label>
					</div>
					<div class="input-field">
						<select>
							<option value="" disabled selected>Ausweisdokument</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
				</div>
				<div class="col s2 offset-s1">
					<div class="center">
						<b>Zahlungsinformationen</b>
						<i class="small material-icons">credit_card</i>
					</div>  
					<div class="input-field">
						<input id="cardnr" type="text" class="validate">
						<label for="cardnr">Card number</label>
					</div>
					<div class="input-field">
						<input id="exdate" type="text" class="datepicker validate">
						<label for="exdate">Expiring Date</label>
					</div>
					<div class="input-field">
						<input id="cvv" type="text" class="validate">
						<label for="cvv">CVV</label>
					</div>
				</div>
				<div class="col s1"><br></div>
			</div>
	</div>
	</form>
	<div class="container hoverable z-depth-3">
	<br>
		<div class="row"><div class="center col s3 offset-s1"><h5>Newsletter</h5></div></div>
		<div class="row">
            <div class="col s5 offset-s1">
                <div class="input-field">
                    <input id="emailnews" type="email" class="validate">
                    <label for="emailnews">E-Mail</label>
                </div>
                <button class="btn waves-effect waves-light right" type="submit" name="action">Anmelden
                    <i class="material-icons right">email</i>
                </button><br><br><br><br>
            </div>
            <div class="col s1"></div>
            <div class="container col s4">
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LfKURIUAAAAAO50vlwWZkyK_G2ywqE52NU7YO0S" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
                    <!--<input class="form-control" data-recaptcha="true" required data-error="Please complete the Captcha">-->
                    <div class="help-block with-errors"></div>
                </div>
            </div>
         </div>
	</div>
	
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="validator.js"></script>
        <script src="contact.js"></script>';
<?php
echo $info->gui->footer;
?>
