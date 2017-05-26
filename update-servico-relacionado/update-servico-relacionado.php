<?php 
defined( 'ABSPATH' ) or die( 'Nenhum arquivo Encontrado' );

/*
Plugin Name: Update Serviço Relacionado
Description: Plugin desenvolvido atualizar automaticamente serviço relacionado de fornecedores
Version:     0.1
Author:      Inforce
*/



// campo no custom field = servico_relacionado

if ( is_admin() and $post_type != 'fornecedores' ) {

	add_action( 'save_post', 'Update_Fornecedor');


	function Update_Fornecedor( $post ) {
		$metas = get_post_meta( $post );

		// Se tiver o servico_relacionado setado
		if ( isset($metas['servico_relacionado'] ) ) {
			
			// Captura o meta servico_relacionado
			$servico_relacionado = $metas['servico_relacionado'];
			// transforma array em string
			$servico_relacionado = implode(",", $servico_relacionado);
			// Tira o serialize
			$servico_relacionado = maybe_unserialize( $servico_relacionado );

			// Percorre os posts que estão como serviço relacionado 
			// para inserir em cada um deles o post atual como post relacionado
			foreach ( $servico_relacionado as $key => $postID ) {
				// Captura o Meta do fornecedor
				$meta_existentes = get_post_meta( $postID );

				// Pega o post_relacionado do fornecedor
				$posts_relacionados = $meta_existentes['posts_relacionados'];
				// transforma array em string
				$posts_relacionados = implode(",", $posts_relacionados);
				// Tira o serialize
				$posts_relacionados = maybe_unserialize( $posts_relacionados );
				
				// Verifica se o id do post atual já está cadastrado como post relacionado
				if ( !in_array( (string)$post, $posts_relacionados ) ) {	

					// Insere o post relacionado no fornecedor
					array_push($posts_relacionados, (string)$post);
				}
				
				// Dá um update no post_meta do fornecedor
				update_post_meta( $postID, 'posts_relacionados', $posts_relacionados );

				// echo "<pre>";
				// var_dump($posts_relacionados);
				// die();
			}

		}
		
	}
}