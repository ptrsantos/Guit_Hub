/*$(document).ready(function(){
	$("select[name=negocio]").change(function(){
	  beforeSend:$("select[name=categoria]").html('<option value="0">Aguarde Carregando...</option>');
	  
		var negocio = $("select[name=negocio]").val();
		$.post("filtro/categoria.php",{negocio: negocio},function(categoria){
		  complete:$("select[name=categoria]").html(categoria);
	  
			("select[name=categoria]").change(function(){
	      	beforeSend:$("select[name=bairro]").html('<option value="0">Aguarde Carregando...</option>');
	  
				var categoria = $("select[name=categoria]").val();
				$.post("filtro/imovel.php",{categoria: categoria},function(bairro){
		     	complete:$("select[name=bairro]").html(bairro);
			 
					$("select[name=bairro]").change(function(){
	            	beforeSend:$("select[name=comodos]").html('<option value="0">Aguarde Carregando...</option>');
	   
						var bairro = $("select[name=bairro]").val();
	            		$.post("filtro/bairro.php",{bairro: bairro},function(comodos){
		        		complete:$("select[name=comdos]").html(comodos);
						});//fechar $.port()
				
	          		});//fecha change()
			  
				});//fecha $.post()
        	
			});//fecha change()
			
		})//fecha $.post()
	 
	});//fecha change()	
})//ready()*/
	

$(document).ready(function(){
// Evento change no campo negocio  
	$("select[name=negocio]").change(function(){
    // Exibimos no campo categoria antes de concluirmos
		$("select[name=categoria]").html('<option value="">Carregando tipo...</option>');
            // Exibimos no campo bairro antes de selecionamos a tipo, serve também em caso
			// do usuario ja ter selecionado o tipo e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
				$("select[name=bairro]").html('<option value="">Aguardando bairro...</option>');
				// Passando negocio por parametro para a pagina categoria.php
            		$.post("filtro/categoria.php", {negocio:$(this).val()},
                  		// Carregamos o resultado acima para o campo categoria
 						function(valor){
                     	$("select[name=categoria]").html(valor);
                  	})//fecha $post()
	})//fecha change()
      			
	// Evento change no campo categoria 
	$("select[name=categoria]").change(function(){
    	// Exibimos no campo modelo antes de concluirmos
		$("select[name=bairro]").html('<option value="">Carregando...</option>');
        	// Passando marca por parametro para a pagina ajax-modelo.php
            $.post("imovel.php", {categoria:$(this).val()},
                  // Carregamos o resultado acima para o campo modelo
 				function(valor){
                $("select[name=bairro]").html(valor);
			})//fecha $post()
            
	})//fecha change()
	
	// Evento change no campo bairro 
	$("select[name=bairro").change(function(){
    	// Exibimos no campo comodos antes de concluirmos
		$("select[name=comodos]").html('<option value="">Carregando...</option>');
        	// Passando marca por parametro para a pagina ajax-modelo.php
            $.post("bairro.php", {comodos:$(this).val()},
                  // Carregamos o resultado acima para o campo modelo
 				function(valor){
                $("select[name=bairro]").html(valor);
			})//fecha $post()
            
	})//fecha change()
})
    