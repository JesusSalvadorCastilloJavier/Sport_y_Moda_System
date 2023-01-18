<?php
    class Rutas_Model extends CI_Model{

        public function inicio($usuarioId){
            $respuesta=$this->db->query("call sp_getUserByUserId(".$usuarioId.");");
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