<script type="text/javascript">
	$(document).ready(function(){

		// funcao de inclusao
		function dataApi(data){
			// produto
			$("input[name=Name]").val(data.DESCRICAO)
			$("textarea[name=Description]").val(data.DESCRICAO)
			$("input[name=DescriptionShort]").val(data.DESCRICAO)
			$("input[name=Title]").val(data.DESCRICAO)
			$("input[name=MetaTagDescription]").val(data.DESCRICAO)
			$("input[name=KeyWords]").val(data.DESCRICAO)
			$("input[name=RefId]").val(data.COD_PRODUTO)
			$("input[name=LinkId]").val(data.TEXTLINK)
			// preco
			$("input[name=basePrice]").val(data.VAREJO)
			// estoque
			$("input[name=quantity]").val(data.ESTOQUE)

			// perssistencias
			$("input[name=persistence-price]").val(data.VAREJO)
			$("input[name=persistence-inventory]").val(data.ESTOQUE)

		}

		// funcao de inclusao
		function cubageApi(data){
			$("input[name=Width]").val(data.LARGURA)
			$("input[name=Height]").val(data.ALTURA)
			$("input[name=Length]").val(data.COMPR)
			$("input[name=WeightKg]").val(data.PESO)
			$("input[name=PackagedLength]").val(data.COMPR)
			$("input[name=PackagedHeight]").val(data.ALTURA)
			$("input[name=PackagedWidth]").val(data.LARGURA)
			$("input[name=PackagedWeightKg]").val(data.PESO)
		}

		// script de manipulacao de input	
		function searchInputEffect(element,status){
			if( status == 'start' ){
				element.attr("disabled","disabled").parent().append('<small><i class="fa fa-spinner fa-spin"></i> requisitando...</small>')
			}else{
				element.parent().find('small').remove()
				element.removeAttr("disabled")
			}
		}

		// montagem de produtos e suas curvas
		function mountProducts(products){
			$(".response-search-erp").empty()
			$.each(products,function(k,v){

				var btnInsertForm;
				if( v.SKU_CADASTRADO == true ){
					btnInsertForm = '&nbsp;&nbsp;<b class="text-success"><i class="fas fa-check-circle"></i> SKU já cadastrado!</b> &nbsp;&nbsp;<a href="javascript:void(0);" class="font-weight-bold use-curve-' + k + '">Clique para usar</a>';
				}else{
					btnInsertForm = '&nbsp;&nbsp;<a href="javascript:void(0);" class="font-weight-bold use-curve-' + k + '">Clique para usar</a>';
				}

				// montando front
				$(".response-search-erp").append('\
					<fieldset id="'+k+'" style="box-shadow: 1px 1px 1px #ddd; border: 1px dashed #ccc; padding: 5px; border-left: 8px solid '+ v.COR+';">\
						<legend style="font-size: 15px; padding: 5px;">\
						Curva ' + (k + 1) + btnInsertForm + '\
					</legend>\
					<ul>\
						<li>COD BARRAS: ' + v.COD_BARRAS + '</li>\
						<li>COD LOJA: ' + v.COD_PRODUTO + '</li>\
						<li>DESCRIÇÃO: ' + v.DESCRICAO + '</li>\
						<li>VAREJO: ' + v.VAREJO + '</li>\
						<li>ESTOQUE: ' + v.ESTOQUE + '</li>\
						<li>CATEGORIA: ' + v.CATEGORIA + '</li>\
						<li>FORNECEDOR: ' + v.FORNECEDOR + '</li>\
						</ul>\
					</fieldset>\
				')
				// inserindo dados no fomrulario
				$(".use-curve-" + k).click(function(){
					dataApi(v)
					$(".search-erp").modal("hide")
				})
			})
		}

		// valid image
		function validateImages(){
			$("img").each(function(){
				$(this).error(function(){
					$(this).attr("src","https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSGjcQXyN5XwQtKd-DTVB2wu1u7Z7R9TmdILQ&usqp=CAU")
				})
			})
		}

		// montagem das imagens
		function mountImages(images){
			//console.log(images)
			// liberando div
			$(".images-sku").removeAttr("hidden")
			$.each(images,function(k,v){

				// padronizando primeira imagem como checked
				var imgChecked = k == 0 ? 'checked' : '';
				// gerando grid de imagens	
				$(".images-sku").find(".card-body").append('\
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">\
					<img class="img-thumbnail" width="100%" height="auto" src="' + v.link_imagem + '" /><br>\
					<input type="radio" name="main" value="' + k + '" ' + imgChecked + ' /> Principal\
					<input type="hidden" name="images[]" value="' + v.link_imagem + '" />&nbsp;&nbsp;<a href="javascript:void(0);" class="text-danger font-weight-bold remove-img-' + k + '"><i class="fas fa-times"></i> Remover</a>\
					</div>\
				')

				$(".remove-img-" + k).click(function(){
					$(this).parent().remove()
				})
			})

			validateImages()
		}

		// montagem de cubagem
		function mountCubage(cubage,){
			// cubagem
			var cubageContent = '\
				<br><br>\
				<table class="table table-bordered">\
					<thead class="thead-dark">\
						<tr>\
							<th colspan="4 font-weight-bold text-center">Cubagem do produto</th>\
						</tr>\
					</thead>\
					<tbody>\
						<tr class="font-weight-bold text-center">\
							<td>Peso: '+cubage[0].PESO+'</td>\
							<td>Altura: '+cubage[0].ALTURA+'</td>\
							<td>Largura: '+cubage[0].LARGURA+'</td>\
							<td>Comp: '+cubage[0].COMPR+'</td>\
						</tr>\
					</tbody>\
				</table>\
			';

			$(".response-search-erp").find(".data-cubage").remove();
			$(".response-search-erp").append(cubageContent)
		}

		function requestProduct(refId,element){

			searchInputEffect(element,'start')
						
			// url de requisicao
			var url = $("body").attr("index") + "/modules/api-protheus/controllers/get-productv2.php";
			
			// requisicao
			var request = $.post(url,{
				code: refId
			}).done(function(response){

				//console.log(response)

				searchInputEffect(element,'end')	

				// validacao de dados de produto
				var response = $.parseJSON(response)


				console.log(response)

				if( response.product.error == false ){
					// alocacao de dados de produto
					mountProducts(response.product.content)
				}else{
					alert(response.product.message)
				}

				// validacao de imagens
				if( response.images.error == false ){
					mountImages(response.images.content)
				}else{
					alert(response.images.message)
				}

				// validacao de cubagem
				if( response.cubage.error == false ){
					mountCubage(response.cubage.content)
				}else{
					alert(response.cubage.message)
				}
				
			});
		}

		// requisicao de campo de refid
		$("input[name=code]").keyup(function(e){
			if( e.keyCode == 13 && $(this).val() != "" ){
				// engine de requisicao	
				requestProduct($(this).val(), $(this))
			}
		})
	})
</script>