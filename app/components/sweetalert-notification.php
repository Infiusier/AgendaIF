<?php
	$app = new Module();
	$uri = $app->uri();
	$key = array_search("alert", $uri);

	if( $key ):
		$notify = explode("=", base64_decode($uri[$key + 1]));
		$alert['content'] = $notify[1];
		$alert['className'] = ($notify[0] == "success") ? "success" : "danger";
		$alert['icon'] = ($notify[0] == "success") ? "success" : "error";
		$alert['title'] = ($notify[0] == "success") ? "Sucedido" : "Falha";
?>
	<script type="text/javascript">
		$(function() {
			swal("<?=$alert['title']; ?>", "<?=$alert['content']; ?>", {
				icon : "<?=$alert['icon']; ?>",
				buttons: {        			
					confirm: {
						className : "btn btn-<?=$alert['className']; ?>"
					}
				}
			});
		})
	</script>
<?php
	endif;
?>