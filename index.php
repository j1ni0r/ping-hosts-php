<?php

$title = "Ping da Loja 01"; // website's title
$servers = array(
    'Google' => array(
    'ip' => 'google.com',
	'port' => 80, 
	'info' => 'google',
	'purpose' => 'Web'
    ),
    'Globo' => array(
       'ip' => 'globo.com',
	'port' => 80, 
	'info' => 'globo',
	'purpose' => 'Web'
    ),
    'Radio Loja 01 - IMPERATRIZ' => array(
        'ip' => '192.168.4.99',
        'port' => 80,
        'info' => '192.168.4.99',
        'purpose' => 'RADIO'
    ),
    'Radio Pendanga - Balsas' => array(
        'ip' => '10.252.99.104',
        'port' => 80,
        'info' => '10.252.99.104',
        'purpose' => 'RADIO'
    ),
    'PDV 001' => array(
        'ip' => '192.168.1.220',
        'port' => 80,
        'info' => '1.220',
        'purpose' => 'FRENTE LOJA'
    ),
    'PDV 002' => array(
        'ip' => '192.168.1.106',
        'port' => 80,
        'info' => '1.106',
        'purpose' => 'FRENTE LOJA'
    ),
    'PDV 003' => array(
        'ip' => '192.168.1.110',
        'port' => 80,
        'info' => '1.110',
        'purpose' => 'FRENTE LOJA'
    ),
    
    
);
if (isset($_GET['host'])) {
    $host = $_GET['host'];
    if (isset($servers[$host])) {
        header('Content-Type: application/json');
        $return = array(
            'status' => test($servers[$host])
        );
        echo json_encode($return);
        exit;
    } else {
        header("HTTP/1.1 404 Not Found");
    }
}
$names = array();
foreach ($servers as $name => $info) {
    $names[$name] = md5($name);
}
?>


<?php
/* Função para testar conexão */
function test($server) {
    $socket = @fsockopen($server['ip'], $server['port'], $errorNo, $errorStr, 3);
    if ($errorNo == 0) {
        return true;
    } else {
        return false;
    }
}
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de monitoramento">
    <meta name="author" content="Wilson Júnior">
  

    <link rel="shortcut icon" href="favicon.ico">

	<title>Ping Servers - Página de monitoramento de Servidores Responsiva</title>

	<!-- Google-Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">

	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/prettify.css" />

	<!-- Custom CSS -->
	<link href="css/styles.css" rel="stylesheet">

</head>

<body class="imagem" >

	<div id="wrapper">

		<!-- Page Content -->
		<div id="page-content-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="right-bar">

							<div id="intro" class="com-container">

								

            <h1><?php echo $title; ?></h1>
           
            <table class="table table-condensed">
                
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>Servidor</th>
                        <th>Provedor</th>
                    </tr>
                </thead>
                 <colgroup>
          
        </colgroup>
                <tbody>

            <!--        <?php// echo $servers['SOAP']['ip'].": Nome: ".$servers[0][1].", Endereço: ".$servers[0][2].".<br>"; ?> -->
                    
                    <?php 
                     //   $i = 0;
                     //   $maxiterations = 13;
                        foreach ($servers as $name => $server): ?>
                    <?php// if ($i < $maxiterations) { ?>

                        <tr id="<?php echo md5($name); ?>">
                            <td><i class="icon-spinner icon-spin icon-large"></i></td>
                            <td class="name"><?php echo $name; ?></td>
                            <td><?php echo $server['info']; ?></td>
                            <td><?php echo $server['purpose']; ?></td> 
                        </tr>
                    <?php // $i++; ?>
<?php // } ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
 
                
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript">
            function test(host, hash) {
                // Fork it
                var request;
                // fire off the request to /form.php
                request = $.ajax({
                    url: "<?php echo basename(__FILE__); ?>",
                    type: "get",
                    data: {
                        host: host
                    },
                    beforeSend: function () {
                        $('#' + hash).children().children().css({'visibility': 'visible'});
                    }
                });
                // callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR) {
                    var status = response.status;
                    var statusClass;
                    if (status) {
                        statusClass = 'success';
                    } else {
                        statusClass = 'error';
                    }
                    $('#' + hash).removeClass('success error').addClass(statusClass);
                });
                // callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) {
                    // log the error to the console
                    console.error(
                        "The following error occured: " +
                            textStatus, errorThrown
                    );
                });
                request.always(function () {
                    $('#' + hash).children().children().css({'visibility': 'hidden'});
                })
            }
            $(document).ready(function () {
                var servers = <?php echo json_encode($names); ?>;
                var server, hash;
                for (var key in servers) {
                    server = key;
                    hash = servers[key];
                    test(server, hash);
                    (function loop(server, hash) {
                        setTimeout(function () {
                            test(server, hash);
                            loop(server, hash);
                        }, 6000);
                    })(server, hash);
                }
            });
        </script>
             


             <div class="text-center">
						<p class="copy">Copyright 2019 Wilson Jr Dev.</p>
					</div>						
				<!-- /#wrapper -->

				<!-- jQuery -->
				<script src="js/jquery.js"></script>

				<!-- Bootstrap Core JavaScript -->
				<script src="js/bootstrap.min.js"></script>

				<script src="js/jquery.easing.min.js"></script>

				<script type="text/javascript" src="js/prettify.js"></script>

	</body>

</html>
