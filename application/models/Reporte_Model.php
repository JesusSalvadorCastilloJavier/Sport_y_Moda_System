<?php
    class Reporte_Model extends CI_Model{
        
        public function getAllMovimientosByUserId($campos){
            $respuesta=$this->db->query("call sp_getAllLogsByUsuarioId(".$campos['usId'].",'".$campos['FechaI']."','".$campos['FechaF']."');");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllDatosByUserId($userId){
            $respuesta=$this->db->query("call sp_getDataByUserId(".$userId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllEntradasPrendasByFecha($campos){
            $respuesta=$this->db->query("call sp_getAllEntradasPrendasByFecha('".$campos['fechaInicio']."','".$campos['fechaFin']."');");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllPrendasExistentes($cantidad){
            $respuesta=$this->db->query("call sp_getPrendaExistenciaByCantidad(".$cantidad.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllCalendario($anio){
            $respuesta=$this->db->query("call sp_GetAll_DatosGrafica('".$anio."');");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }
        
    }
?>