<?php
    class Ventas_Model extends CI_Model{

        public function addVenta($data){
            $insertVenta="call sp_AddVenta(".$data['UsuarioId'].",".$data['ClienteId'].",".$data['TotalPagar'].","
            .$data['Descuento'].",".$data['TotalFinalPagar'].",".$data['deposito'].",".$data['cambio'].",'"
            .gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $queryVenta=$this->db->query($insertVenta);
            if(!$queryVenta){
                return var_dump($this->db->error());
            }

            for($i=0;$i<count($data['dataCollectionPrenda']);$i++){
                $insertDetalleVenta="call sp_AddDetalleVenta(".strval($data['dataCollectionPrenda'][$i]['PrendaId']).",".strval($data['dataCollectionPrenda'][$i]['PrendaCantidad']).");";
                $queryDetalleVenta=$this->db->query($insertDetalleVenta);
                if(!$queryDetalleVenta){
                    return var_dump($this->db->error());
                }
            }

            $respuesta=$this->db->query("call sp_getVentaByVentaId;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            
            return $data;

        }

        public function addApartado($data){
            $insertApartado="call sp_AddApartado(".$data['UsuarioId'].",".$data['ClienteId'].",'".$data['alias']."',".$data['TotalPagar'].",".$data['debe'].","
            .$data['Descuento'].",".$data['TotalFinalPagar'].",".$data['deposito'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $queryApartado=$this->db->query($insertApartado);
            /*if(!$queryApartado){
                return var_dump($this->db->error());
            }*/

            for($i=0;$i<count($data['dataCollectionPrenda']);$i++){
                $insertDetalleApartado="call sp_AddDetalleApartado(".strval($data['dataCollectionPrenda'][$i]['PrendaId']).",".strval($data['dataCollectionPrenda'][$i]['PrendaCantidad']).");";
                $queryDetalleVenta=$this->db->query($insertDetalleApartado);
                /*if(!$queryDetalleApartado){
                    return var_dump($this->db->error());
                }*/
            }

            $respuesta=$this->db->query("call sp_getApartadoByApartadoId;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            
            return $data;
        }

        public function getAllVentas(){
            $respuesta=$this->db->query("call sp_GetAll_Ventas;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getDetalleVentasByVentaId($ventaId){
            $respuesta=$this->db->query("call sp_GetDetalleVentaByVentaId(".$ventaId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllApartados(){
            $respuesta=$this->db->query("call sp_GetAll_Apartados;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getDetalleApartadoByApartadoId($apartadoId){
            $respuesta=$this->db->query("call sp_GetDetalleApartadoByApartadoId(".$apartadoId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function abonarApartado($data){
            $insertApartado="call sp_AddAbonoApartado(".$data['UsuarioId'].",".$data['ApartadoId'].",".$data['Monto'].",'"
            .gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $queryApartado=$this->db->query($insertApartado);
            
            if(!$queryApartado){
                return var_dump($this->db->error());
            }
            return true;

        }
    }
?>