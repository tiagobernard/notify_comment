<?php

/**
 * Plugin Name: Notify Comment
 * Plugin URI: http://www.tiagobernardes.com.br/
 * Description: Notificação de novo comentário
 * Version: 1.0.0
 * Author: Tiago Bernardes
 * Author URI: http://www.tiagobernardes.com.br/
 * License: GPL2
 */

function nc_comment_notification_text( $message, $comment_id ) {
    $comment = get_comment ($comment_id);//pega as informações do comentário

$post = get_post( $comment->comment_post_ID ); //construtor do novo texto
if( '' == $comment->comment_type ){
    $message  = sprintf( __( 'New comment on your post "%s"' ), $post->post_title ) . "\r\n";
    $message .= sprintf( __('Author : %1$s'), $comment->comment_author ) . "\r\n";
    $message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
    $message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
    $message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
    $message .= __('You can see all comments on this post here: ') . "\r\n";
    $message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";
    $message .= sprintf( __('Permalink: %s'), get_comment_link( $comment_id ) ) . "\r\n";

    if ( user_can( $post->post_author, 'edit_comment', $comment_id ) ) {
        if ( EMPTY_TRASH_DAYS )
            $message .= sprintf( __('Trash it: %s'), admin_url("comment.php?action=trash&c=$comment_id") ) . "\r\n";
        else
            $message .= sprintf( __('Delete it: %s'), admin_url("comment.php?action=delete&c=$comment_id") ) . "\r\n";
        $message .= sprintf( __('Spam it: %s'), admin_url("comment.php?action=spam&c=$comment_id") ) . "\r\n";
    }
}

return $message;
}

add_filter( 'comment_notification_text', 'nc_comment_notification_text', 10, 2 );

//

function add_roles_on_plugin_activation() {
 add_role( 'custom_role', 'Custom Subscriber', array( 'read' => true, 'level_0' => true ) );
}

?>
