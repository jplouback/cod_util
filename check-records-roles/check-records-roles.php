<?php 
defined( 'ABSPATH' ) or die( 'Nenhum arquivo Encontrado' );

/*
Plugin Name: Check Records Roles
Description: Plugin desenvolvido para cadastrar regras aos novos usuários.
Version:     0.1
Author:      Inforce
*/

// Verificação para ver se está sendo cadastrado pela página /login
if ( isset($_POST['item_meta']) ) {
	
	add_action( 'user_register', 'change_role');

	function change_role( $user_id ) {

		$resposta = $_POST['item_meta']['151'];
		
		$wpUser = new WP_User($user_id);

		if ( $resposta == 'Não, sou convidada(o)' ) {
			$wpUser->set_role('subscriber');

		} elseif ( $resposta == 'Não, sou profissional do setor' ) {
			$wpUser->set_role('fornecedor_user');

		} else {
			$wpUser->set_role('noiva');
		}
	}

}