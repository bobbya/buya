<?
	require_once( $_SERVER['DOCUMENT_ROOT'].'/assets/design.php' ); 
	displayHeader();

	if(isset($_POST['formSubmit'])) {
		require_once( $_SERVER['DOCUMENT_ROOT'].'/assets/errorOut.php' );
		$error = new errorOut();
		$errors = 0;
		
		if( empty($_POST['company']) || !($error->is_printableText($_POST['company'])) ) {
			$errors++;
			$companyError = 'Invalid Company Name';
		}
		
		if( empty($_POST['firstName']) || !($error->is_name($_POST['firstName'])) ) {
			$errors++;
			$firstNameError = 'Invalid Name';
		}
		
		if( empty($_POST['lastName']) || !($error->is_name($_POST['lastName'])) ) {
			$errors++;
			$lastNameError = 'Invalid Name';
		}
		
		if( empty($_POST['email']) || !($error->is_email($_POST['email'])) ) {
			$errors++;
			$emailError = 'Invalid Email Address';
		}
		
		if( empty($_POST['phone']) || !($error->is_phone($_POST['phone'],$_POST['country'])) ) {
			$errors++;
			$phoneError = 'Invalid Phone Number';
		}
				
		if( empty($_POST['state']) || !($error->is_name($_POST['state'])) ) {
			$errors++;
			$stateError = 'Invalid State';
		}
		
		if( empty($_POST['venue']) ) {
			$errors++;
			$venueError = 'Please select one.';
		}
		
		if($errors===0) {
			$linebreak = "\r\n";

			$headers = '';
			$headers .= 'MIME-Version: 1.0' . $linebreak;
			$headers .= 'Content-type: text/plain; charset=UTF-8' . $linebreak;
			$headers .= 'From: no-reply@buya.co . $linebreak;
			
			$to = 'bob@skytics.com';

			$subject = 'Getting Started Contact Form Submission';
		
			$body = "Company: {$_POST['company']}\n";
			$body .= "First Name: {$_POST['firstName']}\n";
			$body .= "Last Name: {$_POST['lastName']}\n";
			$body .= "Email: {$_POST['email']}\n";
			$body .= "Phone: {$_POST['phone']}\n";
			$body .= "State: {$_POST['state']}\n";
			$body .= "Email: {$_POST['email']}\n";
			$body .= "Country: {$_POST['country']}\n";
			$body .= "\n";
			$body .= "Venue Confirmed: {$_POST['venue']}\n";
			$body .= "Venue Name: {$_POST['venuename']}\n";
			$body .= "Venue Capacity: {$_POST['venuecapacity']}\n";
			$body .= "\n";
			$body .= "Comments: {$_POST['comments']}\n";
			$body .= "Referred: {$_POST['findus']}\n";
			$body .= "\n";
			$body .= "Originating IP: {$_SERVER['REMOTE_ADDR']}\n";
			$body .= "Agent: {$_SERVER['HTTP_USER_AGENT']}\n";		

			mail($to, $subject, $body, $headers);
			?>
				<div id="content">
					<div class="entry">
						<h1>Thank You</h1>
						<p>Your information has been submitted.</p>
						<p>We will attempt to contact you within 24 hours.</p>
	                </div>
   				</div>
			<?php 
			displayFooter();
			die();
		}
	}
?>


<div id="content">
	<div class="entry">
		<h1>Get Started with SkyTics Today!</h1>
		<p>To get started we need to gather some basic information about you. </p>
		<p><em>* indicates a required field.</em></p>
	
		<hr/>
		
		<form id="getStartedForm" method="post">
			<p>
				<span class="formLabel">*Company Name:</span> <input type="text" name="company" value="<?php echo isset($_POST['company']) ? $_POST['company'] : ''; ?>"/>
				<?php if(isset($companyError)) echo '<span class="formError">'.$companyError.'</span>'; ?><br/>
				
				<span class="formLabel">*First Name:</span> <input type="text" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>"/>
				<?php if(isset($firstNameError)) echo '<span class="formError">'.$firstNameError.'</span>'; ?><br/>
				
				<span class="formLabel">*Last Name:</span> <input type="text" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>"/>
				<?php if(isset($lastNameError)) echo '<span class="formError">'.$lastNameError.'</span>'; ?><br/>
				
				<span class="formLabel">*Email:</span> <input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>
				<?php if(isset($emailError)) echo '<span class="formError">'.$emailError.'</span>'; ?><br/>
				
				<span class="formLabel">*Phone:</span> <input type="text" name="phone"  value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>"/>
				<?php if(isset($phoneError)) echo '<span class="formError">'.$phoneError.'</span>'; ?> <br/>
	            			
				<span class="formLabel">*State/Province:</span> <input type="text" name="state" value="<?php echo isset($_POST['state']) ? $_POST['state'] : ''; ?>"/>
				<?php if(isset($stateError)) echo '<span class="formError">'.$stateError.'</span>'; ?> <br/>
	                        			
				<span class="formLabel">*Country:</span> 
				<select name="country">
					<option <?php echo isset($_POST['country']) && $_POST['country']=='United States' ? 'selected="selected"' : ''; ?>>United States</option>
					<option <?php echo isset($_POST['country']) && $_POST['country']=='Canada' ? 'selected="selected"' : ''; ?>>Canada</option>
				</select>
				<?php if(isset($countryError)) echo '<span class="formError">'.$countryError.'</span>'; ?> <br/>
			</p>
            
            <p>
	       		<span class="formLabel">*Do you have a Venue?</span> 
				<input type="radio" name="venue" id="venueYes" value="yes" <?php echo isset($_POST['venue']) && $_POST['venue']=='yes' ? 'checked="checked"' : ''; ?>/><label for="venueYes">Yes</label>
				<input type="radio" name="venue" id="venueNo" value="no" <?php echo isset($_POST['venue']) && $_POST['venue']=='no' ? 'checked="checked"' : ''; ?>/><label for="venueNo">No</label>
				<?php if(isset($venueError)) echo '<span class="formError">'.$venueError.'</span>'; ?> <br/>     
	            
	            <span class="formLabel">Venue Name:</span> <input type="text" name="venuename" value="<?php echo isset($_POST['venuename']) ? $_POST['venuename'] : ''; ?>"/>
				<br/>   
	            
	            <span class="formLabel">Seating Capacity:</span> <input type="text" name="venuecapacity" value="<?php echo isset($_POST['venuecapacity']) ? $_POST['venuecapacity'] : ''; ?>"/>
				<br/>
			</p>
                        
            <p>
	            <span class="formLabel">Comments:</span> 
	            <textarea name="comments"><?php echo isset($_POST['comments']) ? $_POST['comments'] : '';?></textarea>
				<br/>   
	            
	            <span class="formLabel">How did you find SkyTics?</span> 
	            <textarea name="findus"><?php echo isset($_POST['findus']) ? $_POST['findus'] : '';?></textarea>
				<br/>
			</p>
			
			<div class="center"><input name="formSubmit" type="submit" value="Contact Me"/></div>
		</form>
	</div>
</div>

<?php 
	displayFooter();
?>

