function formhash(form, password) {

	//create a new element input, this will be our hashed password field.
	var p = document.createElement("input");

	//Add the new element to our form.
	
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(password.value);

    form.appendChild(p);
	//Make sure the plaintext password doesn't get sent.
	password.value = "";

	//Finally submit the form.
	form.submit();
}

function regformhash(form, user, password, conf, privilegio, clubes) {

	// Check each field has a value
    if (user.value === ''          || 
        	password.value === ''  || 
        	conf.value === ''      ||
            privilegio.value =='privilegio') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
    
    // Add the new element to our form. 
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    //p.value = password.value;
    //hex_sha512(p.value);
    form.appendChild(p);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}


function regformhashRegistarNacional(form, stam, bi, password, conf) {

	// Check each field has a value
    if (stam.value === ''          || 
        	bi.value === ''  || 
        	password.value === ''  || 
        	conf.value === '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
    
    // Add the new element to our form. 
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    //p.value = password.value;
    //hex_sha512(p.value);
    form.appendChild(p);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}


function regformhashRegistarInternacional(form, nome, stam, indentification, country, address, password, conf) {

	// Check each field has a value
    if (nome.value === ''          || 
        	stam.value === ''  || 
        	indentification.value === ''  || 
        	country.value === ''  || 
        	address.value === ''  || 
        	password.value === ''  || 
        	conf.value === '' ) {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
    
    // Add the new element to our form. 
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    //p.value = password.value;
    //hex_sha512(p.value);
    form.appendChild(p);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}

function regformhashJuiz(form, userJuiz, nomeJuiz, emailJuiz, biJuiz, paisJuiz, regiaoJuiz, moradaJuiz, cod_postalJuiz, LocalidadeJuiz, telefone1Juiz, telefone2Juiz, passwordJuiz, conf) {

	// Check each field has a value
    if (userJuiz.value === ''       || 
        nomeJuiz.value === ''       || 
        emailJuiz.value === ''      || 
        biJuiz.value === ''         || 
        paisJuiz.value === ''       || 
        regiaoJuiz.value === ''     || 
        moradaJuiz.value === ''     || 
        cod_postalJuiz.value === '' || 
        LocalidadeJuiz.value === '' || 
        telefone1Juiz.value === ''  ||
        telefone2Juiz.value === ''  || 
        telefone2Juiz.value === ''  ||
        password.value === ''       || 
        conf.value === '') {
 
        alert('Tem que fornecer todos os dados. Por favor tente outra vez');
        return false;
    }

    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
    
    // Add the new element to our form. 
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    //p.value = password.value;
    //hex_sha512(p.value);
    form.appendChild(p);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}



