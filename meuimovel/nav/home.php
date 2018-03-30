     <div id="imoveis_home">
       
       <h1>Imóveis</h1>
       
         <form name="busca_comum" action="index.php?pg=search" method="post">
           <label>
             <span>Busca Comum: </span>
             <input type="text" name="p" />
             
             <input type="submit" name="Buscar" value="" class="btn" />
             
           </label>
         
         </form>
         
           <ul class="lista_um">
             <?php homePosts();?>
           </ul>
           
           <table>
               <th>
                   <td>
                   <ul class="lista_dois">
                     <?php homePostsListaDois();?>
                   </ul>
                   </td>
                   <td>
                     <div class="anuncie">
                        <a href="index.php?pg=anuncie"><img src="images/cadastre_se2_1.jpg" alt="" title="" border="0" /></a>
                     </div><!--classe anuncie-->
                  </td>
              </th>
     		</table>
            
                      <div id="informativo">
           
            <div class="sobre">
            	<h1>Sobre o portal MEUIMÓVEL</h1>
                <h2>Somos um portal para anúncios de imóveis com foco na região de Osasco e Grande São Paulo, a nossa proposta é fornecer um seviço aonde o proprietário possa aunciar seu imóvel e negociar diretamente com o interessado sem a intermediação de terceiros e por consequência sem o pagamento de comissões, impactando dessa forma o preço final da venda.</h2>
			</div><!--fecha sobre>-->
 		  </div><!--Fecha informativo>-->
     
     </div><!--fecha imoves home-->
     
     
