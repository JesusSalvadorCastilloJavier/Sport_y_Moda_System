<?php
    class Catalogos_Model extends CI_Model{

        public function getAllCatSexo(){
            $respuesta=$this->db->query("call sp_getAll_CatSexo;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllCatEstado(){
            $respuesta=$this->db->query("call sp_getAll_CatEstado;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllCatMunicipio($estadoId){
            $respuesta=$this->db->query("call sp_getAll_catMunicipio_ByEstadoId(".$estadoId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllRole(){
            $respuesta=$this->db->query("call sp_getAll_CatRole;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllTalla(){
            $respuesta=$this->db->query("call sp_getAll_CatTalla;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllGenero(){
            $respuesta=$this->db->query("call sp_getAll_CatGenero;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllMarca(){
            $respuesta=$this->db->query("call sp_getAll_CatMarca;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }
        public function getAllColor(){
            $respuesta=$this->db->query("call sp_getAll_CatColor;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }
        public function getAllProveedor(){
            $respuesta=$this->db->query("call sp_getAll_CatProveedor;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }
    }
?>