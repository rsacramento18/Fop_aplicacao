<?php

require_once('../mysql_config.php');

function sec_session_start(){
	$session_name = 'sec_session_id';
	$secure = true;
	$httponly = true;
		// Forces sessions to only use cookies.
	if(ini_set('session.use_only_cookies', 1) === false){
			// header("Location: /error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}
		// Gets current cookies params.
	$currentCookieParams = session_get_cookie_params(); 

	session_set_cookie_params( 
		$currentCookieParams["lifetime"], 
		$currentCookieParams["path"], 
		$currentCookieParams["domain"], 
		$currentCookieParams["secure"], 
		$currentCookieParams["httponly"] 
		); 

	session_name('mysessionname'); 
	session_start();
	
}

function login ($user, $password, $dbc){
	
	$query = "SELECT privilegio, password, salt, clube, block
	FROM users
	WHERE user_id = ?
	LIMIT 1";

	if($stmt = mysqli_prepare($dbc, $query)) {

		mysqli_stmt_bind_param($stmt, 's', $user);
			$stmt->execute();    // Execute the prepared query.
			$stmt->store_result();

			$stmt->bind_result($privilegio, $db_password, $salt, $clube, $block);
			$stmt->fetch();
			if($stmt->num_rows == 1){
				// hash the password with the unique salt.
				$password = hash('sha512', $password . $salt);

				if($stmt->num_rows == 1){
					if($block == 'Nao' || $block == 'admin'){
						if(checkbrute($user, $dbc) == true){
							echo "erro checkbrute";
							return 'false';
						}
						else {

							if($db_password == $password){
		        				// Password is correct!
		                    	// Get the user-agent string of the user.
								$user_browser = $_SERVER['HTTP_USER_AGENT'];
		        				// XSS protection as we might print this value
								$_SESSION['user'] = $user;
								$_SESSION['privilegio'] = $privilegio;
								$_SESSION['clube'] = $clube;
								$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
								return 'true';
							}
							else {
		        				// Password is not correct
		                    	// We record this attempt in the database
								$now = time();
								$dbc->query("INSERT INTO login_attempts(user_id , time) VALUES ('$user_id', '$now')");
								return 'false';
							}
						}
					}
					else {
						return 'contaBlock';
					}
				}
				else {
	        		//no user exists.
					return 'false';
				} 
			}
		}	
	}

function login_socio ($user, $password, $dbc){
	
	$query = "SELECT privilegio, password, salt, block
	FROM contasSocio
	WHERE stamContaSocio = ?
	LIMIT 1";

	if($stmt = mysqli_prepare($dbc, $query)) {

		mysqli_stmt_bind_param($stmt, 's', $user);
			$stmt->execute();    // Execute the prepared query.
			$stmt->store_result();

			$stmt->bind_result($privilegio, $db_password, $salt, $block);
			$stmt->fetch();
			if($stmt->num_rows == 1){
				// hash the password with the unique salt.
				$password = hash('sha512', $password . $salt);

				if($stmt->num_rows == 1){
					if($block == 'Nao'){
						if(checkbrute($user, $dbc) == true){
							echo "erro checkbrute";
							return 'false';
						}
						else {

							if($db_password == $password){
		        				// Password is correct!
		                    	// Get the user-agent string of the user.
								$user_browser = $_SERVER['HTTP_USER_AGENT'];
		        				// XSS protection as we might print this value
								$_SESSION['user'] = $user;
								$_SESSION['privilegio'] = $privilegio;
								$_SESSION['clube'] = '';
								$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
								return 'true';
							}
							else {
		        				// Password is not correct
		                    	// We record this attempt in the database
								$now = time();
								$dbc->query("INSERT INTO login_attempts(user_id , time) VALUES ('$user_id', '$now')");
								return 'false';
							}
						}
					}
					else {
						return 'contaBlock';
					}
				}
				else {
	        		//no user exists.
					return 'false';
				} 
			}
		}	
	}

function login_socioEstrangeiro ($user, $password, $dbc){
	
	$query = "SELECT privilegio, password, salt, block
	FROM contasEstrangeiro
	WHERE stam = ?
	LIMIT 1";

	if($stmt = mysqli_prepare($dbc, $query)) {

		mysqli_stmt_bind_param($stmt, 's', $user);
			$stmt->execute();    // Execute the prepared query.
			$stmt->store_result();

			$stmt->bind_result($privilegio, $db_password, $salt, $block);
			$stmt->fetch();
			if($stmt->num_rows == 1){
				// hash the password with the unique salt.
				$password = hash('sha512', $password . $salt);

				if($stmt->num_rows == 1){
					if($block == 'Nao'){
						if(checkbrute($user, $dbc) == true){
							echo "erro checkbrute";
							return 'false';
						}
						else {

							if($db_password == $password){
		        				// Password is correct!
		                    	// Get the user-agent string of the user.
								$user_browser = $_SERVER['HTTP_USER_AGENT'];
		        				// XSS protection as we might print this value
								$_SESSION['user'] = $user;
								$_SESSION['privilegio'] = $privilegio;
								$_SESSION['clube'] = '';
								$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
								return 'true';
							}
							else {
		        				// Password is not correct
		                    	// We record this attempt in the database
								$now = time();
								$dbc->query("INSERT INTO login_attempts(user_id , time) VALUES ('$user_id', '$now')");
								return 'false';
							}
						}
					}
					else {
						return 'contaBlock';
					}
				}
				else {
	        		//no user exists.
					return 'false';
				} 
			}
		}	
	}



	function checkbrute($user, $dbc){
		$now = time();

		$valid_attemps = $now - (2*60*60);

		if($stmt = $dbc->prepare("SELECT time 
			FROM login_attempts 
			WHERE user_id = ? 
			AND time > ?")) {
			
			$stmt->bind_param('si', $user, $valid_attempts);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 5) {
			return true;
		} else {
			return false;
		}
	}	
}

function login_check($dbc) {
	if(isset($_SESSION['user'],
		$_SESSION['privilegio'],
		$_SESSION['login_string'])) {

		$user = $_SESSION['user'];
	$privilegio = $_SESSION['privilegio'];
	$login_string = $_SESSION['login_string'];
	
	$user_browser = $_SERVER['HTTP_USER_AGENT'];

	if ($stmt = $dbc->prepare("SELECT password 
		FROM users 
		WHERE user_id = ? LIMIT 1")) {
            	// Bind "$user_id" to parameter. 
		$stmt->bind_param('s', $user);
            	$stmt->execute();   // Execute the prepared query.
            	$stmt->store_result();

            	if ($stmt->num_rows == 1) {

	                // If the user exists get variables from result.
            		$stmt->bind_result($password);
            		$stmt->fetch();
            		$login_check = hash('sha512', $password . $user_browser);

            		if ($login_check == $login_string) {
                    	// Logged In!!!! 
            			return true;
            		} else {
                    	// Not logged in 
            			return false;
            		}

            	} else{
            		return false;
            	}
            } else {
            	return false;
            }
        } else {
        	return false;
        }
    }

function login_checkSocios($dbc) {
	if(isset($_SESSION['user'],
		$_SESSION['privilegio'],
		$_SESSION['login_string'])) {

		$user = $_SESSION['user'];
	$privilegio = $_SESSION['privilegio'];
	$login_string = $_SESSION['login_string'];
	
	$user_browser = $_SERVER['HTTP_USER_AGENT'];

	if ($stmt = $dbc->prepare("SELECT password 
		FROM contasSocio
		WHERE stamContaSocio = ? LIMIT 1")) {
            	// Bind "$user_id" to parameter. 
		$stmt->bind_param('s', $user);
            	$stmt->execute();   // Execute the prepared query.
            	$stmt->store_result();

            	if ($stmt->num_rows == 1) {

	                // If the user exists get variables from result.
            		$stmt->bind_result($password);
            		$stmt->fetch();
            		$login_check = hash('sha512', $password . $user_browser);

            		if ($login_check == $login_string) {
                    	// Logged In!!!! 
            			return true;
            		} else {
                    	// Not logged in 
            			return false;
            		}

            	} else{
            		return false;
            	}
            } else {
            	return false;
            }
        } else {
        	return false;
        }
    }


function login_checkEstrangeiros ($dbc) {
	if(isset($_SESSION['user'],
		$_SESSION['privilegio'],
		$_SESSION['login_string'])) {

		$user = $_SESSION['user'];
	$privilegio = $_SESSION['privilegio'];
	$login_string = $_SESSION['login_string'];
	
	$user_browser = $_SERVER['HTTP_USER_AGENT'];

	if ($stmt = $dbc->prepare("SELECT password 
		FROM contasEstrangeiro WHERE stam = ? LIMIT 1")) {
            	// Bind "$user_id" to parameter. 
		$stmt->bind_param('s', $user);
            	$stmt->execute();   // Execute the prepared query.
            	$stmt->store_result();

            	if ($stmt->num_rows == 1) {

	                // If the user exists get variables from result.
            		$stmt->bind_result($password);
            		$stmt->fetch();
            		$login_check = hash('sha512', $password . $user_browser);

            		if ($login_check == $login_string) {
                    	// Logged In!!!! 
            			return true;
            		} else {
                    	// Not logged in 
            			return false;
            		}

            	} else{
            		return false;
            	}
            } else {
            	return false;
            }
        } else {
        	return false;
        }
    }


    function login_fop_check($dbc) {
    	if(isset($_SESSION['user']) ){

    		$user = $_SESSION['user'];
    		if ($stmt = $dbc->prepare("SELECT privilegio 
    			FROM users
    			WHERE user_id = ? LIMIT 1")) {
            	// Bind "$user_id" to parameter. 
    			$stmt->bind_param('s', $user);
            	$stmt->execute();   // Execute the prepared query.
            	$stmt->store_result();

            	if ($stmt->num_rows == 1) {

	                // If the user exists get variables from result.
            		$stmt->bind_result($privilegio);
            		$stmt->fetch();
            		if ($privilegio == "fop" || $privilegio == "admin") {
            			return true;
            		} else {
            			return false;
            		}

            	} else{
            		return false;
            	}
            } else {
            	return false;
            }
        } else {
        	return false;
        }
    }

    function login_colegio_check($dbc) {
        if(isset($_SESSION['user']) ){

            $user = $_SESSION['user'];
            if ($stmt = $dbc->prepare("SELECT privilegio 
                FROM users
                WHERE user_id = ? LIMIT 1")) {
                // Bind "$user_id" to parameter. 
                $stmt->bind_param('s', $user);
                $stmt->execute();   // Execute the prepared query.
                $stmt->store_result();

                if ($stmt->num_rows == 1) {

                    // If the user exists get variables from result.
                    $stmt->bind_result($privilegio);
                    $stmt->fetch();
                    if ($privilegio == "colegioJuizes") {
                        return true;
                    } else {
                        return false;
                    }

                } else{
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function login_clube_check($dbc) {
        if(isset($_SESSION['user']) ){

            $user = $_SESSION['user'];
            if ($stmt = $dbc->prepare("SELECT privilegio 
                FROM users
                WHERE user_id = ? LIMIT 1")) {
                // Bind "$user_id" to parameter. 
                $stmt->bind_param('s', $user);
                $stmt->execute();   // Execute the prepared query.
                $stmt->store_result();

                if ($stmt->num_rows == 1) {

                    // If the user exists get variables from result.
                    $stmt->bind_result($privilegio);
                    $stmt->fetch();
                    if ($privilegio != "colegioJuizes" && $privilegio != "fop" && $privilegio != "admin" ) {
                        return true;
                    } else {
                        return false;
                    }

                } else{
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function esc_url($url) {
    	
    	if ('' == $url) {
    		return $url;
    	}
    	
    	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    	
    	$strip = array('%0d', '%0a', '%0D', '%0A');
    	$url = (string) $url;
    	
    	$count = 1;
    	while ($count) {
    		$url = str_replace($strip, '', $url, $count);
    	}
    	
    	$url = str_replace(';//', '://', $url);
    	
    	$url = htmlentities($url);
    	
    	$url = str_replace('&amp;', '&#038;', $url);
    	$url = str_replace("'", '&#039;', $url);
    	
    	if ($url[0] !== '/') {
	        // We're only interested in relative links from $_SERVER['PHP_SELF']
    		return '';
    	} else {
    		return $url;
    	}
    }

    function getUsers($dbc){
    	$query = "SELECT user_id, privilegio, clube, block
    	FROM users WHERE user_id NOT IN ('admin','admin2','cos01')";
    	$stmt = @mysqli_query($dbc, $query);
    	if($stmt) {

    		echo "<table id='table'>
    		<tr>
    			<th>User</th>
    			<th>Privilegio</th>
    			<th>Clube</th>
    			<th>Conta Bloqueada</th>
    		</tr>";
    		while($row = mysqli_fetch_array($stmt)) {
    			echo "<tr>";
    			echo "<td>" . $row['user_id'] . "</td>";
    			echo "<td>" . $row['privilegio'] . "</td>";
    			echo "<td>" . $row['clube'] . "</td>";
    			echo "<td>" . $row['block'] . "</td>";
    			echo "</tr>";
    		}
    		echo "</table>";
    	}
    	else {
    		echo "nao funcionou";
    	}

    }

    function getClubes($dbc){

    	$query = "SELECT nome_clube FROM clubes
    	GROUP BY nome_clube asc";

    	$stmt = @mysqli_query($dbc, $query);
    	if($stmt){
    		
    		while ($row= mysqli_fetch_array($stmt)) {
    			echo "<option value='".$row['nome_clube']."'>". $row['nome_clube']. "</option>";
    		}
    	}		
    }
    
    function getJuizes($dbc){

    	$query = "SELECT idJuiz, nome FROM juizes
    	GROUP BY idJuiz asc";

    	$stmt = @mysqli_query($dbc, $query);
    	if($stmt){
    		
    		while ($row= mysqli_fetch_array($stmt)) {
    			echo "<option value='".$row['idJuiz']."'>". $row['nome']. "</option>";
    		}
    	}		
    }

    function verificarDataPedido($dbc){
    	
    	date_default_timezone_set('Portugal');
    	$dataHoje = date('Y-m-d', time());

        $pedidoNum = '';
    	$query = "SELECT pedidoNum  FROM pedidoEmVigor";
    	if ($stmt = @mysqli_query($dbc, $query)){

    		$row = mysqli_fetch_array($stmt);
    		$pedidoNum = $row['pedidoNum'];

    		

    		$query2 = "SELECT data from datasAnilhas where dataNum = '$pedidoNum'";

    		if ($stmt2 = @mysqli_query($dbc, $query2)){

    			$row2 = mysqli_fetch_array($stmt2);
    			$dataPedidoX = $row2['data'];
    			
    			if($dataPedidoX<$dataHoje){
    				if($pedidoNum == 6) {//se for igual ao max pedidos;
    					$query3 = "UPDATE pedidoEmVigor SET pedidoNum='1' 
    					WHERE id = '1'";
                        $pedidoNum = 1;
    				}
    				else {
    					$pedidoNum = $pedidoNum + 1;
    					$query3 = "UPDATE pedidoEmVigor SET pedidoNum='$pedidoNum' 
    					WHERE id= '1'";
    				}
    				if ($stmt3 = @mysqli_query($dbc, $query3)){

    				}
    			}

    		}
        }
        $_SESSION['pedidoEmVigor'] = $pedidoNum;
    }

    function algorimoStams($dbc){
    	$query = "SELECT * FROM sequenciastam WHERE id= 1";
    	if ($stmt = @mysqli_query($dbc, $query)){
    		$row = mysqli_fetch_array($stmt);
    		$letra = chr(ord($row['letra1'])+1);
    		if($row['numero'] == 99){
    			if($row['letra2'] == Z){
    				$letra = chr(ord($row['letra1'])+1);
    				$query = "UPDATE SequenciaStam  
    				SET letra1 = '$letra' ,letra2 = 'A', numero = 1
    				where id = 1";
    			}
    			else{
    				$letra = chr(ord($row['letra2'])+1);
    				$query = "UPDATE SequenciaStam  
    				SET letra2 = '$letra', numero = 1 
    				where id = 1";
    			}
    		}
    		else{
    			$numero = $row['numero'] + 1;
    			$query = "UPDATE SequenciaStam  
    			SET  numero = $numero 
    			where id = 1";
    		}
    		if ($stmt = @mysqli_query($dbc, $query)){
    			
    		}
    		else{
    			echo "erro ao actualizar stams";
    		}

    	}
    }
    
    function validarCartao($dbc, $cartaoSocio){
    	$query = "SELECT data from datasAnilhas where dataNum = 6";
    	$dataLimite= date("y-m-d");
    	if($stmt = @mysqli_query($dbc, $query)) {
    		$row = mysqli_fetch_array($stmt);
    		$dataLimite =  $row['data'];
    	}

    	$dataLimite = explode('-', $dataLimite);

    	$dataLimite[0] = $cartaoSocio + 1;

    	$dataLimite = implode('-', $dataLimite);


    	$dataCurrente = date("Y-m-d");
    	

    	if ($dataCurrente > $dataLimite) {
    		return true;
    	}
    	return false;
    }

    function validar6Pedido($dbc, $vagaNum) {
    	if(intval($vagaNum) == 6){
    		return true;
    	}
    	return false;
    }

    function validarBi($bi){
    	if (strlen($bi) != 9){
    		return false;
    	}
    	$nParcela;
    	$nSoma = 0;
    	$nResto;
    	$nCheck;
    	$nContribCheck;

    	for ($i = 0; $i < 8; $i++)
    	{
    		$nParcela = intval(substr($bi,$i,1));
    		$nSoma += $nParcela * (9-$i);
    	}
    	$nContribCheck = intval(substr($bi,8,1));
    	$nResto = $nSoma % 11;

        // Calcula o CheckDigit
    	if ($nResto == 0 || $nResto == 1){
    		$nCheck = 0;
    	}
    	else {
    		$nCheck = 11 - $nResto;
    	}

        // Retorna o resultado
    	return strcmp($nCheck,$nContribCheck);
    }

    function getSociosMembros(){
    	$clube = $_SESSION['clube']; 
    	$query = "SELECT socios.stam, socios.nome, socios_clubes.membro_num from socios INNER JOIN socios_clubes
    	ON socios.stam=socios_clubes.stam 
    	WHERE socios_clubes.clube = '$clube'
    	ORDER BY membro_num ASC LIMIT 0,20";
    	$max = 0;
    	if($stmt = @mysqli_query($dbc, $query)) {
    		
    		while($row = mysqli_fetch_array($stmt)) {
    			echo "<div class='associadoQuadrado'>";
    			echo "<p>". $row['membro_num'] ."</p>";
    			echo "<p>". $row['stam'] ."</p>";
    			echo "<p>". $row['nome'] ."</p>";
    			echo "</div>";
    		}
    		
    	}
    	else{
    		echo "nao funcionou";
    	}
    }

    function csv_to_array($filename='', $delimiter=';')
    {
	    if(!file_exists($filename) || !is_readable($filename))
		    return FALSE;
	
	    $header = NULL;
	    $data = array();
	    if (($handle = fopen($filename, 'r')) !== FALSE)
	    {
		    while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
		    {
			    if(!$header)
				    $header = $row;
			    else
				    $data[] = array_combine($header, $row);
		    }
		    fclose($handle);
	    }
	    return $data;
    }

    function utf8_encode_deep(&$input) {
        if (is_string($input)) {
            $input = utf8_encode($input);
        } 
        else if (is_array($input)) {
            foreach ($input as &$value) {
                utf8_encode_deep($value);
            }

            unset($value);
        } 
        else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));

            foreach ($vars as $var) {
                utf8_encode_deep($input->$var);
            }
        }
    }
?>
