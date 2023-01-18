<?php
    class Login_Model extends CI_Model{

        public function login($datos){
            $respuesta=$this->db->query("call sp_getUserByUserAndPassword('".$datos['user']."','".$datos['password']."');");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getMenuPadre($usuarioId){
            $respuesta=$this->db->query("call sp_getMenuPadreByUsuarioId(".$usuarioId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getMenus($usuarioId){
            $respuesta=$this->db->query("call sp_getMenusByUsuarioId(".$usuarioId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }
    }
?>